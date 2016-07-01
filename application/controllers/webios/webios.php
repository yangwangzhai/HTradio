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























}