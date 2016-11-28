<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

class webios extends  CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->model('content_model');
    }

    /** 注释说明
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

    //主页
    public function main_view(){
        $data['mid'] = $mid = $this->input->get('mid');
        if(!empty($mid)){
            //获取用户名称
            $sql="select username,avatar from fm_member WHERE id=$mid";
            $query = $this->db->query($sql);
            $data['user'] = $query->row_array();
            $data['time'] = time() ;
        }else{
            $username = $this->input->cookie("username");
            $uid = $this->input->cookie("mid");

            //验证用户名和密码
            if (!empty ( $username ) && !empty ( $uid )) {
                $wheredata = array (
                    'username' => $username
                );
                $query = $this->db->get_where ( 'fm_member', $wheredata, 1 );
                $user = $query->row_array ();
                if (!empty ( $user )) {
                    if ($user ['id'] == $uid) {
                        $data['mid'] = $mid = $uid;
                        $data['user'] = $user;
                        $data['time'] = time();
                    }
                }
            }
        }

        $data['username_ceshi'] = $this->input->cookie("username");
        $data['mid_ceshi'] = $this->input->cookie("mid");

        //获取所有直播频道信息
        $sql_channel = "select * from fm_live_channel";
        $query_channel = $this->db->query($sql_channel);
        $data['channel_list'] = $query_channel->result_array();
        //获取一条公共频道
        $sql_programme = "select id,title,support_num,negative_num,intro,thumb from fm_programme WHERE type_id=0 AND status=1 AND vbd_type=0 AND publish_flag=1 ORDER BY addtime DESC limit 1";
        $query_programme = $this->db->query($sql_programme);
        $data['programme'] = $res_programme= $query_programme->row_array();
        //根据公共频道id,获取相应的节目
        if(!empty($res_programme)){
            $sql_program = "select b.id,b.title,b.path from fm_programme_list a JOIN fm_program b WHERE a.programme_id= $res_programme[id] AND b.id=a.program_id";
            $query_program = $this->db->query($sql_program);
            $data['program'] = $query_program->result_array();
        }

        $this->load->view("webios/main_view",$data);
    }

    public function main_view2($mid){
        $data['mid'] = $mid ;
        if(!empty($mid)){
            //获取用户名称
            $sql="select username,avatar from fm_member WHERE id=$mid";
            $query = $this->db->query($sql);
            $data['user'] = $query->row_array();
            $data['time'] = time() ;
        }
        //获取所有直播频道信息
        $sql_channel = "select * from fm_live_channel";
        $query_channel = $this->db->query($sql_channel);
        $data['channel_list'] = $query_channel->result_array();
        //获取一条公共频道
        $sql_programme = "select id,title,support_num,negative_num,intro,thumb from fm_programme WHERE type_id=0 AND status=1 AND vbd_type=0 AND publish_flag=1 ORDER BY addtime DESC limit 1";
        $query_programme = $this->db->query($sql_programme);
        $data['programme'] = $res_programme= $query_programme->row_array();
        //根据公共频道id,获取相应的节目
        if(!empty($res_programme)){
            $sql_program = "select b.id,b.title,b.path from fm_programme_list a JOIN fm_program b WHERE a.programme_id= $res_programme[id] AND b.id=a.program_id";
            $query_program = $this->db->query($sql_program);
            $data['program'] = $query_program->result_array();
        }

        $this->load->view("webios/main_view",$data);
    }

    public function main_view3(){
        unset($_SESSION['mid']);
        $data['username_after'] = $this->input->cookie("username");
        $data['mid_after'] = $this->input->cookie("mid");
        //获取所有直播频道信息
        $sql_channel = "select * from fm_live_channel";
        $query_channel = $this->db->query($sql_channel);
        $data['channel_list'] = $query_channel->result_array();
        //获取一条公共频道
        $sql_programme = "select id,title,support_num,negative_num,intro,thumb from fm_programme WHERE type_id=0 AND status=1 AND vbd_type=0 AND publish_flag=1 ORDER BY addtime DESC limit 1";
        $query_programme = $this->db->query($sql_programme);
        $data['programme'] = $res_programme= $query_programme->row_array();
        //根据公共频道id,获取相应的节目
        if(!empty($res_programme)){
            $sql_program = "select b.id,b.title,b.path from fm_programme_list a JOIN fm_program b WHERE a.programme_id= $res_programme[id] AND b.id=a.program_id";
            $query_program = $this->db->query($sql_program);
            $data['program'] = $query_program->result_array();
        }

        $this->load->view("webios/main_view",$data);
    }

    public function out(){
        //销毁session数据
        unset($_SESSION['mid']);
        /*$this->input->set_cookie("username",'',-36000000000000,'/');
        $this->input->set_cookie("mid",'',-36000000000000,'/');
        $this->input->set_cookie("password",'',-36000000000000,'/');*/
        delete_cookie("username");
        delete_cookie("mid");
        delete_cookie("password");
        $this->main_view3();
    }

    //上传头像
    public function upload_avatar_view(){
        $data['mid'] = $this->input->get('mid') ;
        $this->load->view("webios/upload_avatar_view",$data);
    }

    public function save_upload_avatar(){
        $mid = $this->input->post('mid') ;
        $avatar = uploadFile("file","member");
        if(empty($avatar)){
            $data['mess'] = "上传失败！";
            $data['url'] = "";
            $this->load->view("webios/show_message2",$data);
        }else{
            $sql = "update fm_member set avatar='$avatar' WHERE id=$mid";
            $this->db->query($sql);
            $affect_result = $this->db->affected_rows();
            if($affect_result){
                $data['mess'] = "上传成功！";
                $data['url'] = "main_view&mid=".$mid;
                $this->load->view("webios/show_message",$data);
            }else{
                $data['mess'] = "上传失败！";
                $data['url'] = "";
                $this->load->view("webios/show_message2",$data);
            }

        }
    }

    //上传音频文件
    public function upload_audio_view(){
        $data['mid'] = $this->input->get('mid') ;
        $this->load->view("webios/upload_audio_view",$data);
    }

    public function save_upload_audio(){
        $mid = $this->input->post('mid') ;
        if($mid){
            //根据mid获取用户昵称
            $sql = "SELECT username,nickname FROM fm_member WHERE id=$mid";
            $query = $this->db->query($sql);
            $name=$query->row_array();
            $path = uploadFile("file","audio");
            if(empty($path)){
                $data['mess'] = "上传失败！";
                $data['url'] = "";
                $this->load->view("webios/show_message2",$data);
            }else{
                $data['mid'] = $mid ;
                $data['audio_flag'] = 1 ;
                $data['type_id'] = 86 ;
                $data['status'] = 0 ;
                $data['addtime'] = time() ;
                $data['title'] =  $name['nickname'] ? $name['nickname'].'-'.date("Y-m-d H:i:s",time()): $name['username'].'-'.date("Y-m-d H:i:s",time());
                $data['path'] = $path ;
                $data['download_path'] = $path ;
                $this->db->insert ( 'fm_program', $data);
                $affect_result = $this->db->affected_rows();
                if($affect_result){
                    $data['mess'] = "上传成功！";
                    $data['url'] = "main_view&mid=".$mid;
                    $this->load->view("webios/show_message",$data);
                }else{
                    $data['mess'] = "上传失败！";
                    $data['url'] = "";
                    $this->load->view("webios/show_message2",$data);
                }
            }
        }else{
            $data['mess'] = "请先登录！";
            $data['url'] = "";
            $this->load->view("webios/show_message2",$data);
        }
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
        //将用户所填信息存入cookie
        set_cookie("username",trim ( $_POST ['username'] ),time()+3600);
        set_cookie("password",trim ( $_POST ['password'] ),time()+3600);
        set_cookie("password2",trim ( $_POST ['password2'] ),time()+3600);
        set_cookie("email",trim ( $_POST ['email'] ),time()+3600);
        set_cookie("nickname",trim ( $_POST ['nickname'] ),time()+3600);
        set_cookie("tel",trim ( $_POST ['tel'] ),time()+3600);
        set_cookie("IDcard",trim ( $_POST ['IDcard'] ),time()+3600);

        if ($postdate ['username'] == "" || $postdate ['password'] == "") {
            $data['mess'] = "用户名或者密码不能为空！";
            $data['url'] = "regist_view";
            $this->load->view("webios/show_message2",$data);
        }else{
            if (trim ( $_POST ['password'] )!=trim ( $_POST ['password2'] )) {
                $data['mess'] = "两次输入密码不一致！";
                $data['url'] = "regist_view";
                $this->load->view("webios/show_message2",$data);
            }else{
                $query = $this->db->query ( "select id from fm_member where username='{$postdate[username]}' limit 1" );
                if ($query->num_rows () > 0) {
                    $data['mess'] = "用户名已经存在，请换一个！";
                    $data['url'] = "regist_view";
                    $this->load->view("webios/show_message2",$data);
                }else{
                    $postdate ['password'] = get_password ( $postdate ['password'] );
                    $this->db->insert ( 'fm_member', $postdate );
                    if ($this->db->insert_id () > 0) {
                        //注册成功，跳转到登录页
                        $data['mess'] = "注册成功，请登录！";
                        $data['url'] = "login_view";
                        $this->load->view("webios/show_message",$data);
                    }else{
                        $data['mess'] = "未知错误！";
                        $data['url'] = "regist_view";
                        $this->load->view("webios/show_message2",$data);
                    }
                }
            }
        }
    }

    //跳转登陆界面
    public function login_view(){
        $this->load->view("webios/login_view");
    }

    //验证登陆
    public function check_login() {
        $username = trim ( $this->input->post ( 'username' ) );
        $password = trim ( $this->input->post ( 'password' ) );
        $remember = trim ( $this->input->post ( 'remember' ) );
        //是否设置了 记住密码
        if($remember){
            //set_cookie("username",$username,time()+3600);
            //set_cookie("password",$password,time()+3600);
        }else{
            set_cookie("username","",time()-1);
            set_cookie("password","",time()-1);
        }
        if (empty ( $username ) || empty ( $password )) {
            $data['mess'] = "用户名或者密码不能为空！";
            $data['url'] = "login_view";
            $this->load->view("webios/show_message",$data);
        }else{
            $wheredata = array (
                'username' => $username
            );
            $query = $this->db->get_where ( 'fm_member', $wheredata, 1 );
            $user = $query->row_array ();
            if (empty ( $user )) {
                $data['mess'] = "账号不存在！";
                $data['url'] = "login_view";
                $this->load->view("webios/show_message",$data);
            }else{
                $password = get_password ( $password );
                if ($user ['password'] != $password) {
                    $data['mess'] = "密码错误！";
                    $data['url'] = "login_view";
                    $this->load->view("webios/show_message",$data);
                }else{
                    $admin = $this->detail ( $user['id'] );
                    /*echo $admin['id']." || ";
                    echo $admin['username'];
                    exit;*/
                    $this->session->set_userdata ("mid", $admin['id'] );
                    $this->input->set_cookie("mid",$admin['id'],86400);
                    $this->input->set_cookie("username",$admin['username'],86400);

                    $this->main_view2($admin['id']);
                }
            }
        }
    }

    // 获取一条会员全部信息
    function detail($uid=0) {
        /*if($_GET['uid']) {
            $uid = intval($_GET['uid']);
        }
        if(empty($uid)) {
            show ( 6, 'uid is null' );
        }*/
        $row = $this->member_model->get_one($uid);
        /*if(empty($row)) {
            show ( 7, 'user is null' );
        }*/
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

    //我的节目单
    public function my_programme(){
        $data['mid'] = $mid = $this->input->get('mid');
        $page = intval ( $_GET ['page'] ) - 1;
        $offset = $page > 0 ? $page * $this->pagesize : 0;
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

    public function my_programme2($mid){
        $data['mid'] = $mid ;
        $page = intval ( $_GET ['page'] ) - 1;
        $offset = $page > 0 ? $page * $this->pagesize : 0;
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

    //节目单详情
    public function programme_detail(){

        $data_list['programme_id'] = $programme_id = $this->input->get('programme_id');
        $data_list['mid'] = $mid = $this->input->get("mid");

        $query_user = $this->db->query("select username,avatar from fm_member WHERE id=$mid");
        $username = $query_user->row_array();

        if (empty($programme_id)) {
            $data['mess'] = "节目单不存在！";
            $data['url'] = "my_programme&mid=".$mid;
            $this->load->view("webios/show_message",$data);
        }
        if (empty($mid)) {
            $mid = 0;
        }
        $query = $this->db->get_where('fm_programme', array('id'=>$programme_id ),1);
        $programme_row = $query->row_array();

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

        //统计收藏的次数
        $sql_col= "select count(*) as num from fm_collect WHERE programme_id=$programme_id";
        $query_col = $this->db->query($sql_col);
        $result_col = $query_col->row_array();
        if ($result_col) {
            $data_list['col_num'] = $result_col['num'];
        } else {
            $data_list['col_num'] = 0;
        }

        //统计评论次数
        $sql_col= "select count(*) as num from fm_comment WHERE programme_id=$programme_id";
        $query_con = $this->db->query($sql_col);
        $result_con = $query_con->row_array();
        if ($result_con) {
            $data_list['con_num'] = $result_con['num'];
        } else {
            $data_list['con_num'] = 0;
        }

        $data_list['program_list'] = $result;
        $data_list['programme_title'] = $programme_row['title'];
        $data_list['username'] = $username['username'];
        $data_list['avatar'] = $username['avatar'] ? $username['avatar'] : base_url()."static/webios/img/play_bg.jpg";
        $data_list['programme_id'] = $_GET['programme_id'];

        $this->load->view("webios/programme_detail",$data_list);
    }

    //节目单详情
    public function programme_detail2($programme_id , $mid){
        $data_list['programme_id'] = $programme_id;
        $data_list['mid'] = $mid ;
        if (!empty($mid)) {
            $query_user = $this->db->query("select username,avatar from fm_member WHERE id=$mid");
            $username = $query_user->row_array();
        }

        if (empty($programme_id)) {
            $data['mess'] = "节目单不存在！";
            $data['url'] = "my_programme&mid=".$mid;
            $this->load->view("webios/show_message",$data);
        }

        $query = $this->db->get_where('fm_programme', array('id'=>$programme_id ),1);
        $programme_row = $query->row_array();

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

        //统计收藏的次数
        $sql_col= "select count(*) as num from fm_collect WHERE programme_id=$programme_id";
        $query_col = $this->db->query($sql_col);
        $result_col = $query_col->row_array();
        if ($result_col) {
            $data_list['col_num'] = $result_col['num'];
        } else {
            $data_list['col_num'] = 0;
        }

        //统计评论次数
        $sql_col= "select count(*) as num from fm_comment WHERE programme_id=$programme_id";
        $query_con = $this->db->query($sql_col);
        $result_con = $query_con->row_array();
        if ($result_con) {
            $data_list['con_num'] = $result_con['num'];
        } else {
            $data_list['con_num'] = 0;
        }

        $data_list['program_list'] = $result;
        $data_list['programme_title'] = $programme_row['title'];
        $data_list['username'] = $username['username'];
        $data_list['avatar'] = $username['avatar'] ? $username['avatar'] : base_url()."static/webios/img/play_bg.jpg";

        $this->load->view("webios/programme_detail",$data_list);
    }

    //删除节目单里面的节目
    public function program_del(){
        $programme_id = $this->input->post('programme_id');
        $program_del_ids = $this->input->post('delete');
        $mid = $this->input->post("mid");


        if(!empty($program_del_ids)){
            foreach($program_del_ids as $value){
                $this->db->delete('fm_programme_list', array('programme_id' => $programme_id , 'program_id'=> $value));
            }
        }else{

        }

        $this->programme_detail2($programme_id,$mid);
    }

    public function program_play(){
        $data['mid'] = $this->input->get('mid') ;
        $programme_id = $_GET['programme_id'];
        $program_id = $_GET['program_id'];

        //获取节目单里的全部节目（除了当前点击的）
        $sql_program = "select program_id from fm_programme_list WHERE programme_id=$programme_id AND program_id !=$program_id";
        $query_program=$this->db->query($sql_program);
        $program_arr = $query_program->result_array();
        foreach($program_arr as &$value){
            $sql="select title,path from fm_program WHERE id=$value[program_id]";
            $query=$this->db->query($sql);
            $result = $query->row_array();
            $value['title'] = $result['title'];
            $value['path'] = $result['path'];
        }

        $sql="select title,path from fm_program WHERE id=$program_id";
        $query=$this->db->query($sql);
        $data['program_first'] = $query->row_array();
        $data['program_first']['id'] = $program_id;
        $data['program_arr'] = $program_arr;
        $data['programme_id'] = $programme_id;
        $this->load->view("webios/program_play",$data);
    }

    public function my_comment_view(){
        $data['mid'] = $mid = $this->input->get("mid");
        $data['programme_id'] = $programme_id = $this->input->get("programme_id");
        //获取所有该节目单的评论
        $sql = "select mid,content,addtime from fm_comment WHERE programme_id=$programme_id ORDER by addtime DESC";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        date_default_timezone_set(PRC);//设置北京时间
        if(!empty($result)){
            foreach($result as &$value){
                $value['addtime'] = date('Y-m-d H:i:s',$value['addtime']);
                //根据mid获取用户信息
                $query_user = $this->db->query("select username,avatar from fm_member WHERE id=$value[mid]");
                $user = $query_user->row_array();
                $value['username'] = $user['username'];
                $value['avatar'] = $user['avatar'] ? $user['avatar'] : base_url()."static/webios/img/play_bg.jpg";
            }
        }
        $data['list'] = $result;

        $this->load->view("webios/my_comment_view",$data);
    }

    public function feedback_view(){
        $data['mid']= $mid = $this->input->get('mid') ;
        $this->load->view("webios/feedback_view",$data);
    }

    public function save_feedback(){
        $data['mid'] = $mid = $this->input->post('mid') ;
        $value=$this->input->post("value");
        if(!empty($value)){
            $value['addtime'] = time();
            $insert_id = $this->db->insert ( 'fm_feedback', $value );
            if ($insert_id) {
                $data['mess'] = "添加成功！";
                $data['url'] = "main_view&mid=".$mid;
                $this->load->view("webios/show_message",$data);
            } else {
                $data['mess'] = "未知错误，添加没有成功！";
                $data['url'] = "feedback_view&mid=".$mid;
                $this->load->view("webios/show_message",$data);
            }
        }
    }

    public function setting_list(){
        $data['mid'] = $mid = $this->input->get('mid') ;
        $data['web'] = get_cache('android_version');
        $this->load->view("webios/setting_list",$data);

    }

    public function update_version_view(){
        $data['mid'] = $this->input->get('mid') ;
        $data['web'] = get_cache('android_version');
        $this->load->view("webios/update_version_view",$data);
    }

    public function edit_passsword_view(){
        $data['mid']=$this->input->get('mid') ;
        $this->load->view("webios/edit_passsword_view",$data);
    }

    // 会员 密码 修改 保存post字段 uid, old_password, new_password
    function password_save() {
        //$uid = intval ( $this->input->post ('uid') );
        $uid=$this->input->post('mid') ;
        $old_password =  trim ( $this->input->post ('old_password') );
        $new_password =  trim ( $this->input->post ('new_password') );

        if (empty ( $uid ) || empty ( $old_password ) || empty ( $new_password )) {
            $data['mess'] = "原密码和新密码不能为空！";
            $data['url'] = "edit_passsword_view&mid=".$uid;
            $this->load->view("webios/show_message",$data);
        }else{
            if ($old_password == $new_password) {
                $data['mess'] = "原密码和新密码不能相同！！";
                $data['url'] = "edit_passsword_view&mid=".$uid;
                $this->load->view("webios/show_message",$data);
            }else{
                $query = $this->db->get_where ( 'fm_member', 'id = '.$uid, 1 );
                $row = $query->row_array ();

                $old_password = get_password($old_password);
                $new_password = get_password($new_password);
                if( $row['password'] != $old_password) {
                    $data['mess'] = "原密码不正确！！";
                    $data['url'] = "edit_passsword_view&mid=".$uid;
                    $this->load->view("webios/show_message",$data);
                }else{
                    $this->db->update ( 'fm_member', array (
                        'password' => $new_password
                    ), 'id = ' . $uid );
                    $affected = $this->db->affected_rows ();
                    if ($affected == 0) {
                        $data['mess'] = "对不起，出错了，请稍后再试！";
                        $data['url'] = "edit_passsword_view&mid=".$uid;
                        $this->load->view("webios/show_message",$data);
                    }else{
                        $data['mess'] = "修改成功！";
                        $data['url'] = "main_view&mid=".$uid;
                        $this->load->view("webios/show_message",$data);
                    }
                    }

            }
        }

    }



    public function creat_programme_view(){
        $data['mid']= $mid = $this->input->get('mid') ;
        $data['programme_id']= $programme_id = $this->input->get('programme_id') ?  $this->input->get('programme_id') : '';
        $query = $this->db->query ( "select id,title,thumb from fm_program_type where pid='0'" );
        $list = $query->result_array ();
        foreach ($list as $list_key=>&$row) {
            if ($row['thumb']) $row['thumb'] = base_url() . $row['thumb'];
        }
        $data['list'] = $list;
        $data['ids']='';
        $data['num'] = 0;
        $data['title'] = '';
        $this->load->view("webios/creat_programme_view",$data);

    }

    public function creat_programme_detail(){
        $id = $this->input->get("id");
        $ids = $this->input->get("ids");
        $mid = $this->input->get("mid");
        $title = $this->input->get("title");
        $data['programme_id']= $programme_id = $this->input->get('programme_id') ?  $this->input->get('programme_id') : '';
        $query = $this->db->query ( "select id,title,thumb from fm_program where type_id=$id ORDER BY id DESC limit 0,20 " );
        $data['list'] = $query->result_array ();
        $data['ids'] = $ids;
        $data['title'] = $title;
        $data['mid'] = $mid;

        $this->load->view("webios/creat_programme_detail",$data);
    }

    public function creat_programme_process(){
        $len = $this->input->get("len");
        $ids = $this->input->get("ids");
        $mid = $this->input->get("mid");
        $title = $this->input->get("title");
        $data['programme_id']= $programme_id = $this->input->get('programme_id') ?  $this->input->get('programme_id') : '';
        //echo $len."||".$ids;
        $query = $this->db->query ( "select id,title,thumb from fm_program_type where pid='0'" );
        $list = $query->result_array ();
        foreach ($list as $list_key=>&$row) {
            if ($row['thumb']) $row['thumb'] = base_url() . $row['thumb'];
        }
        $data['list'] = $list;
        $data['ids']=$ids;
        $data['mid']=$mid;
        if(empty($ids)){
            $data['num'] = 0;
        }else{
            $ids_arr = explode(",",substr($ids, 0, -1));
            $data['num'] = count($ids_arr);
        }
        $data['title'] = $title;
        $this->load->view("webios/creat_programme_view",$data);
    }


    public function save_creat_programme(){
        $mid = $this->input->post("mid");
        $sql_user = "select username,nickname from fm_member WHERE id=$mid";
        $query_user = $this->db->query($sql_user);
        $result_user = $query_user->row_array();
        $p_name = $result_user['nickname'] ? $result_user['nickname'].date('y-m-d',time()) : $result_user['username'].date('y-m-d',time());
        $data = array(
            'title' => $this->input->post("title") ? $this->input->post("title") : $p_name,
            'mid' => $mid,
            'addtime' => time()
        );
        //判断是添加还是编辑
        $programme_id = $this->input->post("programme_id") ;
        
        if($programme_id){      //编辑
            //更新 fm_programme 表
            $this->db->where('id', $programme_id);
            $this->db->update('fm_programme', $data);
            //更新 fm_programme_list 表
            $ids = $this->input->post("ids");
            $ids_arr = explode(",",substr($ids, 0, -1));
            //先删除原来的记录
            $this->db->delete('fm_programme_list', array('programme_id' => $programme_id));
            //添加新的记录
            foreach($ids_arr as $val){
                $value = array(
                    'programme_id' => $programme_id,
                    'program_id' => $val,
                    'type_id' => 1,
                );
                $this->db->insert ( 'fm_programme_list', $value );
            }
        }else{
            //添加
            $this->db->insert ( 'fm_programme', $data );
            $insert_id = $this->db->insert_id();
            $ids = $this->input->post("ids");
            $ids_arr = explode(",",substr($ids, 0, -1));
            if($insert_id){
                foreach($ids_arr as $val){
                    $value = array(
                        'programme_id' => $insert_id,
                        'program_id' => $val,
                        'type_id' => 1,
                    );
                    $this->db->insert ( 'fm_programme_list', $value );
                }
            }
        }


        $this->my_programme2($mid);
    }

    //编辑模式下向节目单添加节目
    public function add_programme_view(){
        $data['mid'] = $mid = $this->input->get('mid');
        $data['programme_id'] = $programme_id = $this->input->get('programme_id');
        //获取当前节目单的名称
        $this->db->select('title');
        $query = $this->db->get_where('fm_programme',array('id'=>$programme_id));
        $programme_title = $query->row_array();
        //获取当前节目单包含的节目
        $this->db->select('program_id');
        $query = $this->db->get_where('fm_programme_list',array('programme_id'=>$programme_id));
        $data['program_ids'] = $program_ids = $query->result_array();

        //获取节目类型列表
        $query = $this->db->query ( "select id,title,thumb from fm_program_type where pid='0'" );
        $list = $query->result_array ();
        foreach ($list as $list_key=>&$row) {
            if ($row['thumb']) $row['thumb'] = base_url() . $row['thumb'];
        }
        $data['list'] = $list;
        //组装现有的节目，以“ , ”隔开
        $ids = '' ;
        $num = 0 ;
        if(!empty($program_ids)){
            foreach($program_ids as $key=>$value){
                $ids .= $value['program_id'].',' ;
            }
            $num = count($program_ids) ;
        }
        $data['ids'] = $ids ;
        $data['num'] = $num ;
        $data['title'] = $programme_title['title'] ;
        $this->load->view("webios/creat_programme_view",$data);

    }

    public function version(){
        $data = array(
            'version'=> '1.1',
            "message"=>"版本说明",
            "url"=>"http://school.wojia99.com/public/app_download/haitun/"
        );
        echo json_encode($data);
    }

    public function support_negative(){
        $insert['mid'] = $mid = $this->input->post('mid') ;
        $id = $this->input->post("id");
        $insert['channel_type'] = $channel_type = $this->input->post("channel_type");//直播频道为 1，2为公共频道
        $type = $this->input->post("type");
        if($type=='support'){
            $res_num=$this->db->query("SELECT COUNT(*) AS num FROM fm_support_negative WHERE mid=$mid AND support_target_id=$id");
            $num=$res_num->row_array();
            if($num['num']){
                //已经点过赞
                echo json_encode(0);
            }else{
                //把该用户点赞或者差评过的记录到数据库中，这样知道该用户点赞过哪个频道，差评过哪个频道，
                //同时防止同一个用户对同一个频道点赞或者差评多次
                $insert['support_target_id'] = $id;
                $this->db->insert ( 'fm_support_negative', $insert);
                //先判断是直播频道还是公共频道
                if($channel_type==1){
                    //先获取点赞数
                    $sql = "SELECT support_num FROM fm_live_channel WHERE id=$id";
                    $query = $this->db->query($sql);
                    $res=$query->row_array();
                    $support_num_new=$res['support_num']+1;
                    //更新数据库
                    $this->db->query("UPDATE fm_live_channel SET support_num=$support_num_new WHERE id=$id");
                }else if($channel_type==2){
                    //先获取点赞数
                    $sql = "SELECT support_num FROM fm_programme WHERE id=$id";
                    $query = $this->db->query($sql);
                    $res=$query->row_array();
                    $support_num_new=$res['support_num']+1;
                    //更新数据库
                    $this->db->query("UPDATE fm_programme SET support_num=$support_num_new WHERE id=$id");
                }

                echo json_encode(1);
            }
        }else{
            $res_num=$this->db->query("SELECT COUNT(*) AS num FROM fm_support_negative WHERE mid=$mid AND negative_target_id=$id");
            $num=$res_num->row_array();
            if($num['num']){
                //已经差评过
                echo json_encode("0");
            }else{
                $insert['negative_target_id'] = $id;
                $this->db->insert ( 'fm_support_negative', $insert);
                //先判断是直播频道还是公共频道
                if($channel_type==1){
                    //先获取差评数
                    $sql = "SELECT negative_num FROM fm_live_channel WHERE id=$id";
                    $query = $this->db->query($sql);
                    $res=$query->row_array();
                    $negative_num_new=$res['negative_num']+1;
                    //更新数据库
                    $this->db->query("UPDATE fm_live_channel SET negative_num=$negative_num_new WHERE id=$id");
                }else if($channel_type==2){
                    //先获取差评数
                    $sql = "SELECT negative_num FROM fm_programme WHERE id=$id";
                    $query = $this->db->query($sql);
                    $res=$query->row_array();
                    $negative_num_new=$res['negative_num']+1;
                    //更新数据库
                    $this->db->query("UPDATE fm_programme SET negative_num=$negative_num_new WHERE id=$id");
                }

                echo json_encode(1);
            }
        }

    }

    //收藏页面
    public function collect_view(){
        $data['mid'] = $mid = $this->input->get('mid') ;
        $query = $this->db->query ( "select programme_id from fm_collect where mid=$mid");
        $list = $query->result_array ();
        if(!empty($list)){
            foreach($list as &$value){
                $query = $this->db->query ( "select mid,title from fm_programme where id=$value[programme_id]");
                $title = $query->row_array ();
                $value['title'] = $title['title'];
                $value['mid'] = $title['mid'];
            }
        }
        if(!empty($list)) {
            foreach ($list as &$value) {
                $sql_user = "select username,nickname,avatar from fm_member WHERE id=$value[mid]";
                $query_user = $this->db->query($sql_user);
                $result = $query_user->row_array();
                $value['avatar'] = $result['avatar'] ? $result['avatar'] : base_url()."static/webios/img/play_bg.jpg";
                if ($result['nickname']) {
                    $value['name'] = $result['nickname'];
                } else {
                    $value['name'] = $result['username'];
                }
            }
        }
        //统计收藏的次数
        if(!empty($list)){
            foreach ($list as &$value) {
                $sql_col= "select count(*) as num from fm_collect WHERE programme_id=$value[programme_id]";
                $query_col = $this->db->query($sql_col);
                $result_col = $query_col->row_array();
                if ($result_col) {
                    $value['col_num'] = $result_col['num'];
                } else {
                    $value['col_num'] = 0;
                }
            }
        }
        //统计评论次数
        if(!empty($list)){
            foreach ($list as &$value) {
                $sql_col= "select count(*) as num from fm_comment WHERE programme_id=$value[programme_id]";
                $query_con = $this->db->query($sql_col);
                $result_con = $query_con->row_array();
                if ($result_con) {
                    $value['con_num'] = $result_con['num'];
                } else {
                    $value['con_num'] = 0;
                }
            }
        }
        $data['list'] = $list;

        $this->load->view("webios/collect_view",$data);
    }

    public function collect_view2($mid){
        $data['mid'] = $mid ;
        $query = $this->db->query ( "select programme_id from fm_collect where mid=$mid");
        $list = $query->result_array ();
        if(!empty($list)){
            foreach($list as &$value){
                $query = $this->db->query ( "select mid,title from fm_programme where id=$value[programme_id]");
                $title = $query->row_array ();
                $value['title'] = $title['title'];
                $value['mid'] = $title['mid'];
            }
        }
        if(!empty($list)) {
            foreach ($list as &$value) {
                $sql_user = "select username,nickname,avatar from fm_member WHERE id=$value[mid]";
                $query_user = $this->db->query($sql_user);
                $result = $query_user->row_array();
                $value['avatar'] = $result['avatar'] ? $result['avatar'] : base_url()."static/webios/img/play_bg.jpg";
                if ($result['nickname']) {
                    $value['name'] = $result['nickname'];
                } else {
                    $value['name'] = $result['username'];
                }
            }
        }
        //统计收藏的次数
        if(!empty($list)){
            foreach ($list as &$value) {
                $sql_col= "select count(*) as num from fm_collect WHERE programme_id=$value[programme_id]";
                $query_col = $this->db->query($sql_col);
                $result_col = $query_col->row_array();
                if ($result_col) {
                    $value['col_num'] = $result_col['num'];
                } else {
                    $value['col_num'] = 0;
                }
            }
        }
        //统计评论次数
        if(!empty($list)){
            foreach ($list as &$value) {
                $sql_col= "select count(*) as num from fm_comment WHERE programme_id=$value[programme_id]";
                $query_con = $this->db->query($sql_col);
                $result_con = $query_con->row_array();
                if ($result_con) {
                    $value['con_num'] = $result_con['num'];
                } else {
                    $value['con_num'] = 0;
                }
            }
        }
        $data['list'] = $list;

        $this->load->view("webios/collect_view",$data);
    }

    public function add_col_programme_view(){
        //获取节目单
        $data['mid'] = $mid = $this->input->get('mid') ;
        $sql = "select id , title , mid from fm_programme WHERE mid !=$mid ORDER by addtime DESC";
        $query = $this->db->query($sql);
        $list = $query->result_array();
        if(!empty($list)){
            foreach($list as &$value){
                $sql_user="select username,nickname from fm_member WHERE id=$value[mid]";
                $query_user = $this->db->query($sql_user);
                $result = $query_user->row_array();
                if($result['nickname']){
                    $value['name'] = $result['nickname'];
                }else{
                    $value['name'] = $result['username'];
                }
            }
        }
        $data['list'] = $list;

        $this->load->view("webios/add_col_programme_view",$data);
    }

    public function save_col_programme(){
        $mid = $this->input->get('mid') ;
        $ids = $this->input->get("ids");

        $ids_arr = explode(",",substr($ids, 0, -1));
        foreach($ids_arr as $val){
            $value = array(
                'mid' => $mid,
                'programme_id' => $val
            );
            $this->db->insert ( 'fm_collect', $value );
        }

        $this->collect_view2($mid);
    }

    //节目单详情
    public function col_programme_detail(){
        $data_list['mid'] = $this->input->get('mid');
        $data_list['programme_id'] = $programme_id = $_GET['programme_id'];
        $data_list['programme_title'] = $programme_title = $_GET['programme_title'];
        $data_list['col_num'] = $col_num = $_GET['col_num'];
        $data_list['con_num'] = $con_num = $_GET['con_num'];
        $query_mid = $this->db->query("select mid from fm_programme WHERE id=$programme_id");
        $mid = $query_mid->row_array();
        $query_user = $this->db->query("select username,avatar from fm_member WHERE id=$mid[mid]");
        $username = $query_user->row_array();
        $data_list['username'] = $username['username'];
        $data_list['avatar'] = $username['avatar'] ? $username['avatar'] : base_url()."static/webios/img/play_bg.jpg";
        if (empty($programme_id)) {
            $data['mess'] = "节目单不存在！";
            $data['url'] = "collect_view&mid=".$data_list['mid'];
            $this->load->view("webios/show_message",$data);
        }else{
            //取出具体的节目
            $sql_program_ids = "select program_id from fm_programme_list WHERE programme_id=$programme_id";
            $query_program_ids = $this->db->query($sql_program_ids);
            $result_program_ids = $query_program_ids->result_array();
            if(!empty($result_program_ids)){
                foreach($result_program_ids as &$value){
                    $sql_program = "select title , path from fm_program WHERE id=$value[program_id]";
                    $query_program = $this->db->query($sql_program);
                    $result_program = $query_program->row_array();
                    $value['title'] = $result_program['title'];
                    $value['path'] = $result_program['path'];
                }
            }
            $data_list['program_list'] = $result_program_ids;

            $this->load->view("webios/col_programme_detail",$data_list);
        }

    }

    public function col_program_play(){
        $data['mid'] = $this->input->get('mid');
        $programme_id = $_GET['programme_id'];
        $program_id = $_GET['program_id'];
        $data['programme_title'] = $programme_title = $_GET['programme_title'];
        $data['col_num'] = $col_num = $_GET['col_num'];
        //获取节目单里的全部节目（除了当前点击的）
        $sql_program = "select program_id from fm_programme_list WHERE programme_id=$programme_id AND program_id !=$program_id";
        $query_program=$this->db->query($sql_program);
        $program_arr = $query_program->result_array();
        foreach($program_arr as &$value){
            $sql="select title,path from fm_program WHERE id=$value[program_id]";
            $query=$this->db->query($sql);
            $result = $query->row_array();
            $value['title'] = $result['title'];
            $value['path'] = $result['path'];
        }

        $sql="select title,path from fm_program WHERE id=$program_id";
        $query=$this->db->query($sql);
        $data['program_first'] = $query->row_array();
        $data['program_first']['id'] = $program_id;
        $data['program_arr'] = $program_arr;
        $data['programme_id'] = $programme_id;
        $this->load->view("webios/col_program_play",$data);
    }

    public function forget_view(){
        $this->load->view("webios/forget_view");
    }

    public function forget_active(){
        $username = trim ( $_POST ['username'] );
        $email = trim ( $_POST ['email'] );

        if(empty($username)||empty($email)){
            $data['mess'] = "用户名或者邮箱不能为空！";
            $data['url'] = "regist_view";
            $this->load->view("webios/show_message2",$data);
        }else{
            //根据用户名，判断用户输入的邮箱是否与数据库的匹配
            $sql = "select email from fm_member WHERE username='$username'";
            $query = $this->db->query($sql);
            $result_email = $query->row_array();
            if($result_email['email']==$email){
                $data['mess'] = "请打开邮箱，重置密码！";
                $data['url'] = "main_view";
                $this->load->view("webios/show_message",$data);
            }else{
                $data['mess'] = "用户名与邮箱不匹配，请重新输入！";
                $data['url'] = "main_view";
                $this->load->view("webios/show_message2",$data);
            }
        }

    }

    public function comment_view(){
        $data['mid'] = $mid = $this->input->get("mid");
        $data['programme_id'] = $programme_id = $this->input->get("programme_id");
        //获取所有该节目单的评论
        $sql = "select mid,content,addtime from fm_comment WHERE programme_id=$programme_id ORDER by addtime DESC";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        date_default_timezone_set(PRC);//设置北京时间
        if(!empty($result)){
            foreach($result as &$value){
                $value['addtime'] = date('Y-m-d H:i:s',$value['addtime']);
                //根据mid获取用户信息
                $query_user = $this->db->query("select username,avatar from fm_member WHERE id=$value[mid]");
                $user = $query_user->row_array();
                $value['username'] = $user['username'];
                $value['avatar'] = $user['avatar'] ? $user['avatar'] : base_url()."static/webios/img/play_bg.jpg";
            }
        }
        $data['list'] = $result;
        $this->load->view("webios/comment_view",$data);
    }

    public function save_comment(){
        $value = $this->input->post("value");
        $value['mid'] = $mid = $this->input->post('mid') ;
        if(empty($value['content'])){
            $data['mess'] = "评论内容不能为空！";
            $data['url'] = "main_view&mid=".$mid;
            $this->load->view("webios/show_message2",$data);
        }else{
            $value['addtime'] = time();
            $this->db->insert ( 'fm_comment', $value );
        }

        $this->collect_view2($mid);
    }

    //主页播放公共频道的节目
    public function public_program_play(){
        $programme_id = trim($this->input->get('programme_id'));
        $data['program_id'] = $program_id = trim($this->input->get('program_id'));
        //根据公共频道id,获取相应的节目
        if(!empty($programme_id)){
            $sql_program = "select b.id,b.title,b.path from fm_programme_list a JOIN fm_program b WHERE a.programme_id= $programme_id AND b.id=a.program_id AND b.id!=$program_id";
            $query_program = $this->db->query($sql_program);
            $data['program'] = $query_program->result_array();
        }
        $sql = "select id,title,path from fm_program  WHERE id=$program_id";
        $query = $this->db->query($sql);
        $data['program_now'] = $query->row_array();

        $this->load->view("webios/public_program_play",$data);
    }

    public function tong_bu(){
        $data['mid'] = $mid = trim($this->input->post('mid'));
        $flag = trim($this->input->post('flag'));
        $data['channel_id'] = $channel_id = trim($this->input->post('playing_id'));
        $data['Update_time'] = $Update_time = trim($this->input->post('time'));
        $step = 0;
        //查询是否有这条记录
        $sql = "select * from fm_tongbu WHERE mid=$mid";
        $query = $this->db->query($sql);
        $res = $query->row_array();
        if(empty($res)){
            //如果为空，数据库还没有记录，先添加
            $this->db->insert ( 'fm_tongbu', $data);
            $result = array('code'=>0,'mes'=>"新添加",'channel_id'=>$channel_id,'step'=>$step,'play_status'=>1);
            echo json_encode($result);
        }else if(!empty($res)&&$flag==0){
            //数据库已经有记录，但是是刚打开界面，调整为默认状态
            $this->db->query("UPDATE fm_tongbu SET channel_id=$channel_id,Update_time=$Update_time,play_status=1 WHERE mid=$mid");
            $result = array('code'=>0,'mes'=>"新添加",'channel_id'=>$channel_id,'step'=>$step,'play_status'=>1);
            echo json_encode($result);
        }else{
            if($res['channel_id']!=$channel_id){
                if($res['Update_time']>$Update_time){
                    $step = $res['channel_id']-$channel_id;
                    if($step>0){
                        $result = array('code'=>1,'mes'=>"切换频道，更新数据库",'channel_id'=>$res['channel_id'],'step'=>$step,'play_status'=>$res['play_status']);
                    }else{
                        $result = array('code'=>2,'mes'=>"切换频道，更新数据库",'channel_id'=>$res['channel_id'],'step'=>abs($step),'play_status'=>$res['play_status']);
                    }
                    echo json_encode($result);
                }
            }else{
                $result = array('code'=>0,'mes'=>"没有切换频道",'channel_id'=>$channel_id,'step'=>$step,'play_status'=>$res['play_status']);
                echo json_encode($result);
            }
        }


    }

    public function ipad_main_view(){
        $username = $this->input->cookie("username");
        $mid = $this->input->cookie("mid");
        //echo "cookie获取的用户名：".$username;echo "<br>";
        //echo "cookie获取的用户名密码：".$password;echo "<br>";
        //验证用户名和密码
        if (!empty ( $username ) && !empty ( $mid )) {
            $wheredata = array (
                'username' => $username
            );
            $query = $this->db->get_where ( 'fm_member', $wheredata, 1 );
            $user = $query->row_array ();

            if (!empty ( $user )) {
                if ($user ['id'] == $mid) {
                    $data['mid'] = $mid;
                    $data['time'] = time();
                    $data['avatar'] = $user['avatar'] ? $user['avatar'] : "uploads/default_images/default_avatar.jpg";
                }
            }
        }

        //获取所有直播频道信息
        $sql_channel = "select * from fm_live_channel";
        $query_channel = $this->db->query($sql_channel);
        $data['channel_list'] = $query_channel->result_array();
        //获取一条公共频道
        $sql_programme = "select id,title,support_num,negative_num,intro,thumb from fm_programme WHERE type_id=0 AND status=1 AND vbd_type=0 AND publish_flag=1 ORDER BY addtime DESC limit 1";
        $query_programme = $this->db->query($sql_programme);
        $data['programme'] = $res_programme= $query_programme->row_array();
        //根据公共频道id,获取相应的节目
        if(!empty($res_programme)){
            $sql_program = "select b.id,b.title,b.path from fm_programme_list a JOIN fm_program b WHERE a.programme_id= $res_programme[id] AND b.id=a.program_id";
            $query_program = $this->db->query($sql_program);
            $data['program'] = $query_program->result_array();
        }

        $this->load->view("webios/ipad_main_view",$data);
    }

    public function ipad_main_view2($username){

        $data['username'] = $username;
        //$data['mid'] = $mid;

        //获取所有直播频道信息
        $sql_channel = "select * from fm_live_channel";
        $query_channel = $this->db->query($sql_channel);
        $data['channel_list'] = $query_channel->result_array();
        //获取一条公共频道
        $sql_programme = "select id,title,support_num,negative_num,intro,thumb from fm_programme WHERE type_id=0 AND status=1 AND vbd_type=0 AND publish_flag=1 ORDER BY addtime DESC limit 1";
        $query_programme = $this->db->query($sql_programme);
        $data['programme'] = $res_programme= $query_programme->row_array();
        //根据公共频道id,获取相应的节目
        if(!empty($res_programme)){
            $sql_program = "select b.id,b.title,b.path from fm_programme_list a JOIN fm_program b WHERE a.programme_id= $res_programme[id] AND b.id=a.program_id";
            $query_program = $this->db->query($sql_program);
            $data['program'] = $query_program->result_array();
        }

        $this->load->view("webios/ipad_main_view",$data);
    }

    public function ipad_tong_bu(){
        $data['mid'] = $mid = trim($this->input->post('mid'));
        $flag = trim($this->input->post('flag'));
        $data['channel_id'] = $channel_id = trim($this->input->post('playing_id'));
        //$data['channel_type'] = $channel_type = trim($this->input->post('playing_channel_type'));
        $data['Update_time'] = $Update_time = trim($this->input->post('time'));
        $step = 0;
        if($mid==0){
            $result = array('code'=>0,'mes'=>"没有登录",'channel_id'=>$channel_id,'step'=>$step,'play_status'=>1);
            echo json_encode($result);
        }else{
            //查询是否有这条记录
            $sql = "select * from fm_tongbu WHERE mid=$mid";
            $query = $this->db->query($sql);
            $res = $query->row_array();
            if(empty($res)){
                //如果为空，先添加
                $this->db->insert ( 'fm_tongbu', $data);
                $result = array('code'=>0,'mes'=>"新添加",'channel_id'=>$channel_id,'step'=>$step,'play_status'=>1);
                echo json_encode($result);
            }else if(!empty($res)&&$flag==0){
                //首次进来，调整为默认状态
                $this->db->query("UPDATE fm_tongbu SET channel_id=$channel_id,Update_time=$Update_time,play_status=1 WHERE mid=$mid");
                $result = array('code'=>0,'mes'=>"新添加",'channel_id'=>$channel_id,'step'=>$step,'play_status'=>1);
                echo json_encode($result);
            }else{
                if($res['channel_id']!=$channel_id){
                    if($res['Update_time']>$Update_time){
                        $step = $res['channel_id'];
                        $result = array('code'=>1,'mes'=>"切换频道，更新数据库",'channel_id'=>$res['channel_id'],'step'=>$step,'play_status'=>$res['play_status']);
                        echo json_encode($result);
                    }
                }else{
                    $result = array('code'=>0,'mes'=>"没有切换频道",'channel_id'=>$channel_id,'step'=>$step,'play_status'=>$res['play_status']);
                    echo json_encode($result);
                }
            }
        }



    }

    public  function save_play_status(){
        $channel_id = trim($this->input->post('channel_id'));
        $mid = trim($this->input->post('mid'));
        $play_status = trim($this->input->post('play_status'));
        $pos = trim($this->input->post('pos'));
        if($pos==1||$pos==2){
            $this->db->query("UPDATE fm_tongbu SET play_status=$play_status WHERE mid=$mid");
            echo json_encode($play_status);
        }else{
            $Update_time = time();
            $this->db->query("UPDATE fm_tongbu SET channel_id=$channel_id,play_status=$play_status,Update_time=$Update_time WHERE mid=$mid");
            echo json_encode($Update_time);
        }

    }

    /*public  function save_play_status_old(){
        $channel_id = trim($this->input->post('channel_id'));
        $mid = trim($this->input->post('mid'));
        $play_status = trim($this->input->post('play_status'));
        $pos = trim($this->input->post('pos'));
        $Update_time = time();
        if($pos==1||$pos==2||$pos==3){
            $this->db->query("UPDATE fm_tongbu SET play_status=$play_status WHERE mid=$mid");
        }else{
            $this->db->query("UPDATE fm_tongbu SET channel_id=$channel_id,play_status=$play_status,Update_time=$Update_time WHERE mid=$mid");
        }
        $this->db->query("UPDATE fm_tongbu SET play_status=$play_status WHERE mid!=$mid");
        echo json_encode($pos);
    }*/

    function voice_distinguish(){
        $voice_txt = trim($this->input->post('str'));

        $data['mid'] = $mid = trim($this->input->post('mid'));
        $playing_id = trim($this->input->post('playing_id'));
        $arr_mate = $this->config->item("voice_match");
        $channel_id = '';
        foreach($arr_mate as $key=>$value){
            foreach($value as $k=>$v){
                if(strstr($voice_txt,$v)){
                    $channel_id = $key;
                    break;
                }
            }

        }
        $data['Update_time'] = $Update_time = time() ;
        if($channel_id == 0 || $channel_id != ''){    //语音识别成功
            $data['channel_id'] = $channel_id;
            $step = $channel_id-$playing_id;
            if($mid){
                //用户登陆(需要考虑同步)
                //查询是否有这条记录
                $sql = "select * from fm_tongbu WHERE mid=$mid";
                $query = $this->db->query($sql);
                $res = $query->row_array();
                if(empty($res)){
                    //如果为空，先添加
                    $this->db->insert ( 'fm_tongbu', $data);
                }else{
                    $this->db->query("UPDATE fm_tongbu SET channel_id=$channel_id,Update_time=$Update_time WHERE mid=$mid");
                }

                if($step>0){
                    $result = array('code'=>1,'mes'=>"切换频道，更新数据库",'step'=>$step,'play_status'=>1,'str'=>"$voice_txt");
                }else{
                    $result = array('code'=>2,'mes'=>"切换频道，更新数据库",'step'=>abs($step),'play_status'=>1,'str'=>"$voice_txt");
                }
                echo json_encode($result);


            }else{
                //用户没有登陆(不需要考虑同步)
                if($step>0){
                    $result = array('code'=>1,'mes'=>"切换频道，更新数据库",'step'=>$step,'play_status'=>1,'str'=>"$voice_txt");
                }else{
                    $result = array('code'=>2,'mes'=>"切换频道，更新数据库",'step'=>abs($step),'play_status'=>1,'str'=>"$voice_txt");
                }
                echo json_encode($result);
            }

        }else{
            $result = array('code'=>0,'mes'=>"未能识别语音",'str'=>"$voice_txt");
            echo json_encode($result) ;
        }

    }

    public function ipad_voice_distinguish(){
        $voice_txt = trim($this->input->post('str'));
        echo json_encode($voice_txt);exit;
        $data['mid'] = $mid = trim($this->input->post('mid'));
        $arr_mate = $this->config->item("voice_match");
        $channel_id = '';
        foreach($arr_mate as $key=>$value){
            foreach($value as $k=>$v){
                if(strstr($voice_txt,$v)){
                    $channel_id = $key;
                    break;
                }
            }

        }
        $data['Update_time'] = $Update_time = time() ;
        if($channel_id == 0 || $channel_id != ''){    //语音识别成功
            $data['channel_id'] = $channel_id;
            $step = $channel_id;
            if($mid){
                //用户登陆(需要考虑同步)
                //查询是否有这条记录
                $sql = "select * from fm_tongbu WHERE mid=$mid";
                $query = $this->db->query($sql);
                $res = $query->row_array();
                if(empty($res)){
                    //如果为空，先添加
                    $this->db->insert ( 'fm_tongbu', $data);
                }else{
                    $this->db->query("UPDATE fm_tongbu SET channel_id=$channel_id,Update_time=$Update_time WHERE mid=$mid");
                }

                $result = array('code'=>1,'mes'=>"切换频道，更新数据库",'channel_id'=>$channel_id,'step'=>$step,'play_status'=>1);
                echo json_encode($result);


            }else{
                //用户没有登陆(不需要考虑同步)
                $result = array('code'=>0,'mes'=>"刚刚切换频道",'channel_id'=>$channel_id,'step'=>$step,'play_status'=>1);
                echo json_encode($result);
            }

        }else{
            $result = array('code'=>0,'mes'=>"未能分辨",'str'=>$voice_txt);
            echo json_encode($result) ;
        }
    }

    public function ipad_login(){
        $username = trim($this->input->post('username'));
        $password = $pwd= trim($this->input->post('password'));
        //验证用户名和密码
        if (empty ( $username ) || empty ( $password )) {
            $result = array('code'=>0,'mes'=>"用户名或者密码不能为空");
            echo json_encode($result) ;
        }else{
            $wheredata = array (
                'username' => $username
            );
            $query = $this->db->get_where ( 'fm_member', $wheredata, 1 );
            $user = $query->row_array ();
            if (empty ( $user )) {
                $result = array('code'=>0,'mes'=>"账号不存在");
                echo json_encode($result) ;
            }else{
                $password = get_password ( $password );
                if ($user ['password'] != $password) {
                    $result = array('code'=>0,'mes'=>"密码错误");
                    echo json_encode($result) ;
                }else{
                    $this->input->set_cookie("username",$username,2*365*24*3600);
                    $this->input->set_cookie("mid",$user['id'],2*365*24*3600);
                    $user['avatar'] = $user['avatar'] ? $user['avatar'] : "uploads/default_images/default_avatar.jpg";
                    $result = array('code'=>1,'mes'=>"登陆成功",'mid'=>$user['id'],'avatar'=>$user['avatar'],'time'=>time());
                    echo json_encode($result) ;
                }
            }
        }
        //echo json_encode($username."||".$password);
    }

    public function ipad_out(){
        //$mid = $this->input->get("mid");
        //销毁cookie
        $username = $this->input->cookie("username");
        //$mid = $this->input->cookie("mid");
        delete_cookie("username");
        delete_cookie("mid");
        $this->ipad_main_view2($username);
    }


}