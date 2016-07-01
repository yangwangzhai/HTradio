<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

class webios extends  CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('content_model');
    }

    /**
     *  接口说明：获取直播频道的列表信息
     *  接口地址：http://vroad.bbrtv.com/cmradio/index.php?d=android&c=program&m=live_channel_list
     *  参数接收方式：get
     *	接收参数：
     *  mid；用户ID
     *  返回参数：
     *  id：直播频道ID
     *  title：直播频道的名称
     *  description：直播频道简介
     *  add_channel：直播频道的链接地址
     *  logo：直播频道的logo
     *  support_num：当前点赞数
     *  negative_num：当前差评数
     *  support_status：点赞状态，0:表示未点赞，1:表示已经点过赞
     *  negative_status：差评状态，0:表示未差评，1:已经差评过
     */
    public function live_channel_list(){
        $mid=$this->input->get("mid");
        $data['list'] = array();
        $num=$this->content_model->db_counts("fm_live_channel","");
        $data['count'] = $num;
        $this->load->library('pagination');
        $config['total_rows'] = $num;
        $config['per_page'] = 20;
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links();
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
        $per_page = $config['per_page'];
        $sql = "SELECT * FROM fm_live_channel ORDER BY id DESC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $list = $query->result_array();
        foreach($list as $list_key=>$list_value){
            $list[$list_key]['logo']="http://vroad.bbrtv.com/cmradio/".$list_value['logo'];
            //查看该频道是否被该用户点赞过
            if(!empty($mid)){
                $support_res=$this->db->query("SELECT COUNT(*) AS num FROM fm_support_negative WHERE mid=$mid AND support_target_id=$list_value[id] AND channel_type=1");
                $support_num=$support_res->row_array();
                if($support_num['num']){
                    $list[$list_key]['support_status']=1;
                }else{
                    $list[$list_key]['support_status']=0;
                }
                //查看该频道是否被该用户差评过
                $negative_res=$this->db->query("SELECT COUNT(*) AS num FROM fm_support_negative WHERE mid=$mid AND negative_target_id=$list_value[id] AND channel_type=1");
                $negative_num=$negative_res->row_array();
                if($negative_num['num']){
                    $list[$list_key]['negative_status']=1;
                }else{
                    $list[$list_key]['negative_status']=0;
                }
            }else{
                $list[$list_key]['support_status']=0;
                $list[$list_key]['negative_status']=0;
            }
        }
        $data['list']=$list;

        $this->load->view("webios/live_channel_list",$data);
    }

    public function regist_view(){
        $this->load->view("webios/regist_view");
    }

    // 注册
    public function regist() {
        $postdate = array (
            'username' => trim ( $_POST ['username'] ),
            'password' => trim ( $_POST ['password'] ),
            'email' => trim ( $_POST ['email'] ),
            'nickname' => trim ( $_POST ['nickname'] ),
            'tel' => trim ( $_POST ['tel'] ),
            'IDcard'=>trim ( $_POST ['IDcard'] ),
            'regtime' => time (),
            'status' => 1,
            'lastlogintime' => time ()
        );

        if ($postdate ['username'] == "" || $postdate ['password'] == "") {
            show ( 1, '用户名或者密码不能为空' );
        }
        $query = $this->db->query ( "select id from fm_member where username='{$postdate[username]}' limit 1" );
        if ($query->num_rows () > 0) {
            show ( 2, '用户名已经存在，请换一个' );
        }
        $query = $this->db->query ( "select id from fm_member where email='{$postdate[email]}' limit 1" );
        if ($query->num_rows () > 0) {
            show ( 3, '邮箱已经被使用，请换一个' );
        }

        $postdate ['password'] = get_password ( $postdate ['password'] );
        $query = $this->db->insert ( 'fm_member', $postdate );
        if ($this->db->insert_id () > 0) {
            //注册成功，跳转到登录页
            $this->load->view("webios/login_view");
        }else{
            show ( 4, '未知错误' );
        }
    }

    //验证登陆
    public function check_login() {
        //$catid = intval ( $this->input->get_post ('catid') );
        $username = trim ( $this->input->post ( 'username' ) );
        $password = trim ( $this->input->post ( 'password' ) );
        if (empty ( $username ) || empty ( $password )) {
            show ( 5, '用户名和密码不能为空' );
        }
        // 手机号码
        if(strlen($username)>=11) {
            $wheredata = array (
                //'catid' => $catid,
                'tel' => $username
            );
        } else {  // 账号
            $wheredata = array (
                //	'catid' => $catid,
                'username' => $username
            );
        }
        $query = $this->db->get_where ( 'fm_member', $wheredata, 1 );
        $user = $query->row_array ();
        if (empty ( $user )) {
            show ( '8', '账号不存在' );
        }
        $password = get_password ( $password );
        if ($user ['password'] != $password) {
            show ( '2', '密码错误' );
        }
        if ($user ['status'] == 0) {
            show ( '3', '账号已被锁定，请联系管理员' );
        }

        $admin = $this->detail ( $user['id'] );

        $this->session->set_userdata ( 'mid', $admin['id'] );

        $this->left_view();
    }

    // 获取一条会员全部信息
    function detail($uid=0) {

        if($_GET['uid']) {
            $uid = intval($_GET['uid']);
        }
        if(empty($uid)) {
            show ( 6, 'uid is null' );
        }
        $row = $this->member_model->get_one($uid);
        if(empty($row)) {
            show ( 7, 'user is null' );
        }
        unset ( $row ['password'] );
        $row ['userid'] = $row ['id']; // ios需要
        if ($row ['avatar']) {
            $row ['avatar'] = base_url () . new_thumbname ( $row ['avatar'], 100, 100 );
        }
        if ($row['catid']==1) {
            $row = $this->student_model->append_one ( $row );
        }
        if ($row['catid']==2) {
            $row ['manage_class_name'] = setClassname ( $row ['manage_class'] );
            $row ['teach_class_name'] = setClassname ( $row ['teach_class'] );
        }

        //关注数
        $sql = "SELECT count(*) as num from fm_attention where mid = ".$row ['id'];
        $query = $this->db->query ( $sql );
        $favor_data = $query->row_array();
        $row['favorite'] = $favor_data['num'];


        //粉丝数
        $sql = "SELECT count(*) as num from fm_attention where zid = ".$row ['id'];
        $query = $this->db->query ( $sql );
        $favor_data = $query->row_array();
        $row['is_favorite'] = $favor_data['num'];

        //私信
        $sql = "SELECT count(*) as num from fm_message where to_uid = ".$row ['id'] . " AND isread=1 ";
        $query = $this->db->query ( $sql );
        $favor_data = $query->row_array();
        $row['private_letter'] = $favor_data['num'];

        return $row;
    }

    //跳转登陆界面
    public function login_view(){
        $this->load->view("webios/login_view");
    }

    public function left_view(){
        $mid=$this->session->userdata('mid');

    }

    public function main_view(){
        //$data['mid'] = $mid = $this->session->userdata('mid');
        $this->load->view("webios/main_view");
    }
















}