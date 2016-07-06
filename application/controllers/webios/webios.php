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

        $this->main_view();
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

    //
    public function main_view(){
        //$data['mid'] = $mid = $this->session->userdata('mid');
        //$data['href']='href="index.php?d=webios&c=webios&m=login_view"';
        $this->load->view("webios/main_view");
    }

    //我的节目单
    public function my_programme(){
        $mid = $this->session->userdata('mid') ;
        if(empty($mid)){
            $this->load->view("webios/login_view");
        }else{
            $page = intval ( $_GET ['page'] ) - 1;
            $offset = $page > 0 ? $page * $this->pagesize : 0;
            //$mid = 607 ;//$this->session->userdata('mid') ;
            /*if (empty($mid)) {
                show(1,'mid is null');
            }*/
            $this->db->select('id, title, thumb');
            $this->db->order_by("addtime", "desc");
            $query = $this->db->get_where('fm_programme', array('mid'=>$mid ),$this->pagesize,$offset);
            $list = $query->result_array();
            foreach ($list as &$row) {
                if($row['thumb']) $row['thumb'] = base_url().$row['thumb'];
            }
            $data['list']=$list;

            $this->load->view("webios/programme_list",$data);
        }
    }

    //节目单详情
    public function programme_detail(){
        $programme_id = $_GET['programme_id'];
        $mid = 607 ;//$this->session->userdata('mid') ;
        if (empty($programme_id)) {
            show(1,'programme_id is null');
        }
        if (empty($mid)) {
            $mid = 0;
        }
        $query = $this->db->get_where('fm_programme', array('id'=>$programme_id ),1);
        $row = $programme_row = $query->row_array();
        $row_member = getMember($row['mid']);

        $row_data['programme_name'] = $row['title'];
        $row_data['programme_thumb'] = base_url().$row['thumb'];
        $row_data['member_name'] = $row_member['nickname'];
        $row_data['member_thumb'] = base_url().$row_member['avatar'];
        $row_data['member_id'] = $row['mid'];

        //关注数
        $sql = "SELECT count(*) as num from fm_programme_data where programme_id = $programme_id  AND type=1 ";
        $query = $this->db->query ( $sql );
        $favor_data = $query->row_array();
        $row_data['programme_fav'] = $favor_data['num'];


        //判断是否收藏
        $sql = "SELECT count(*) as num from fm_programme_data where programme_id = $programme_id  AND type=1 AND mid=$mid";
        $query = $this->db->query ( $sql );
        $favor_data = $query->row_array();
        $row_data['is_favorite'] = intval($favor_data['num']) > 0 ? 1:0;


        //未做
        $row_data['programme_comment'] = 2091;
        $row_data['programme_share'] = 308;
        $row_data['programme_dl'] = 1; //是否下载


        $data_list = array();
        $this->db->order_by('sort');
        $query = $this->db->get_where('fm_programme_list', array('programme_id'=>$programme_id ));
        $result = $query->result_array();
        //类型id,1节目id，2是类型id
        foreach($result as &$row) {
            if ($row['type_id'] == 1) {
                $this->db->select('id, title, addtime , program_time , mid , path , thumb');
                $query = $this->db->get_where('fm_program', array('id' => $row['program_id']), 1);
                $program = $query->row_array();

                if ($program['path']) $row['path'] = $program['path'];
                if ($program['thumb']) $row['thumb'] = base_url() . $program['thumb'];
                $row['addtime'] = date('Y/m/d', $program['addtime']);
                $row['nickname'] = getNickName($program['mid']);
                $row['title'] = $program['title'];
            } else {
                $this->db->select('id, title');
                $query = $this->db->get_where('fm_program_type', array('id' => $row['program_id']), 1);
                $program = $query->row_array();

                $row['path'] = "";
                $row['thumb'] = "";
                $row['addtime'] = "";
                $row['nickname'] = "";
                $row['title'] = $program['title'];
                $typeid = $row['program_id'];
                $offset = 0;
                $query = $this->db->query("select id,title,thumb,program_time,mid,path from fm_program WHERE  ( status=1 AND type_id = $typeid ) OR ( status=1 AND type_id IN(SELECT id FROM fm_program_type WHERE pid = $typeid ) ) order by playtimes desc limit $offset,$this->pagesize");
                $list = $query->result_array();

                $i = 0;
                foreach ($list as &$type_row) {
                    if ($type_row['thumb']) $type_row['thumb'] = base_url() . $type_row['thumb'];
                    if ($type_row['path']) $type_row['path'] = base_url() . $type_row['path'];
                    if ($type_row['mid']) $type_row['owner'] = getNickName($type_row['mid']);

                }
                $row['contentlist'] = $list;
            }
        }
        $data_list['program_list'] = $result;
        $data_list['programme_title'] = $programme_row['title'];

        $this->load->view("webios/programme_detail",$data_list);
    }

    public function program_play(){
        $program_id = $_GET['program_id'];
        $sql="select title,path from fm_program WHERE id=$program_id";
        $query=$this->db->query($sql);
        $data['program_row']=$query->row_array();

        $this->load->view("webios/program_play",$data);
    }

    public function feedback_view(){
        $data['mid']= $mid = $this->session->userdata('mid') ;
        if(empty($mid)){
            $this->load->view("webios/login_view");
        }else{
            $this->load->view("webios/feedback_view",$data);
        }
    }

    public function save_feedback(){
        $data['mid']=607;//$this->session->userdata('mid') ;
        $value=$this->input->post("value");
        if (empty($value['mid'])) {
            show(1,'mid is null');
        }
        if(!empty($value)){
            $value['addtime'] = time();
            $insert_id = $this->db->insert ( 'fm_feedback', $value );
            if ($insert_id) {
                show_msg('添加成功！', 'index.php?d=webios&c=webios&m=main_view');
            } else {
                show(2, '未知错误，添加没有成功');
            }
        }
    }

    public function setting_list(){
        $data['mid'] = $mid = $this->session->userdata('mid') ;
        if(empty($mid)){
            $this->load->view("webios/login_view");
        }else{
            $data[web] = get_cache('android_version');
            $this->load->view("webios/setting_list",$data);
        }

    }

    public function edit_passsword_view(){
        $data['mid']=607;//$this->session->userdata('mid') ;
        $this->load->view("webios/edit_passsword_view",$data);
    }

    // 会员 密码 修改 保存post字段 uid, old_password, new_password
    function password_save() {
        //$uid = intval ( $this->input->post ('uid') );
        $uid=607; //$this->session->userdata('mid') ;
        $old_password =  trim ( $this->input->post ('old_password') );
        $new_password =  trim ( $this->input->post ('new_password') );
        echo $old_password."||";echo $new_password;exit;
        if (empty ( $uid ) || empty ( $old_password ) || empty ( $new_password )) {
            show ( 1, '用户id, 原密码和新密码不能为空' );
        }
        if ($old_password == $new_password) {
            show ( 5, '原密码和新密码不能相同' );
        }

        $query = $this->db->get_where ( 'fm_member', 'id = '.$uid, 1 );
        $row = $query->row_array ();
        if (empty ( $row )) {
            show ( 2, '该用户不存在' );
        }

        $old_password = get_password($old_password);
        $new_password = get_password($new_password);
        if( $row['password'] != $old_password) {
            show ( 3, '原密码不正确' );
        }

        $this->db->update ( 'fm_member', array (
            'password' => $new_password
        ), 'id = ' . $uid );
        $affected = $this->db->affected_rows ();
        if ($affected == 0) {
            show ( 4, '对不起，出错了，请稍后再试' );
        }

        show ( 0,'ok' );
    }

    public function out(){
        //销毁session数据
        unset($_SESSION['mid']);
        $this->load->view("webios/main_view");
    }

    public function collect_view(){
        $this->load->view("webios/collect_view");
    }

    public function creat_programme_view(){
        $data['mid']= $mid = $this->session->userdata('mid') ;
        if(empty($mid)){
            $this->load->view("webios/login_view");
        }else{
            $query = $this->db->query ( "select id,title,thumb from fm_program_type where pid='0' limit 0,10" );
            $list = $query->result_array ();
            foreach ($list as $list_key=>&$row) {
                if ($row['thumb']) $row['thumb'] = base_url() . $row['thumb'];
            }
            $data['list'] = $list;
            $data['ids']='';
            $this->load->view("webios/creat_programme_view",$data);
        }
    }

    public function creat_programme_detail(){
        $id = $this->input->get("id");
        $ids = $this->input->get("ids");
        $query = $this->db->query ( "select id,title,thumb from fm_program where type_id=$id limit 0,20" );
        $data['list'] = $query->result_array ();
        $data['ids']=$ids;
        $this->load->view("webios/creat_programme_detail",$data);
    }

    public function creat_programme_process(){
        $len = $this->input->get("len");
        $ids = $this->input->get("ids");
        echo $len."||".$ids;
        $query = $this->db->query ( "select id,title,thumb from fm_program_type where pid='0' limit 0,10" );
        $list = $query->result_array ();
        foreach ($list as $list_key=>&$row) {
            if ($row['thumb']) $row['thumb'] = base_url() . $row['thumb'];
        }
        $data['list'] = $list;
        $data['ids']=$ids;

        $this->load->view("webios/creat_programme_view",$data);
    }












}