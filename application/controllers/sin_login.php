<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of index
 * @author victory
 */
class Sin_login extends CI_Controller {
    
    public function __construct() {
        parent::__construct();

        $this->load->model("third_login_model","third");
        $this->load->library('session');
    }

    public function index() {

        $this->load->model("third_login_model","third");//加载新浪登录接口类
        $datas['sina_url'] = $this->third->sina_login();//调用类中的sina_login方法
		//echo $datas['sina_url'];exit;
        redirect($datas['sina_url']);
       // $this->load->view("sin_index.php",$datas);//调取视图文件，并传入数据

     }

    public function callback(){
        header("content-type: text/html; charset=utf-8");
       // $this->load->model("user_reg_model","user_reg");
        $code = $_REQUEST['code'];//code值由入口文件callback.php传过来
		
        $arr =array();
        $arr = $this->third->sina_callback($code);//通过授权并获取用户信息（包括u_id）

        $id=$arr['id'];
        //查询是否是第一次登陆
        $query = $this->db->query ( "select * from fm_member where sina_id='$id' limit 1" );
        $user=$query->row_array();
        //print_r($user);exit;
        if($user){
            //不是第一次直接赋值session
            $userdata = array(
                'uname'  => $user['username'],
                'nickname'  => preg_replace("/[^\w]/iu",'',$user['nickname']),
                'uid'     => $user['id'],
                'th'=>'1',
                'logged_in' => TRUE
            );
            $this->session->set_userdata($userdata);
            redirect("c=personal");
        }else {
            $i=0;
            for($i=0;$i<1000;$i++){
                $username=rand('10000000','99999999');
                $query = $this->db->query ( "select id from fm_member where username='$username' limit 1" );
                $user=$query->row_array();
                if(empty($user)){
                    break;
                }
            }
            //插入数据库数组
            $postdate = array(
                'username'=>$username,
                'nickname'  => preg_replace("/[^\w]/iu",'',$user['nickname']),
                'sina_id' => $arr['id'],
                'regtime' => time(),
                'status' => 1,
                'lastlogintime' => time()
            );
            $query = $this->db->insert('fm_member', $postdate);
            $insert_id = $this->db->insert_id();

             //sission数组
            $userdata = array(
                'uname'  =>$username,
                'nickname'  => $arr['name'],
                'uid'     => $insert_id,
                'th'=>'1',
                'logged_in' => TRUE
            );
            $this->session->set_userdata($userdata);

            redirect("c=personal");
        }
    }


}