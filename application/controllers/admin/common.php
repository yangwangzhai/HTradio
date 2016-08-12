<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 后台公共页控制器 登陆页 by tangjian 
class Common extends CI_Controller
{
    public function top(){
        $this->load->view("admin/top");
    }

    public function left(){
        $this->load->view("admin/left");
    }

    public function right(){
        $this->load->view("admin/main");
    }
    
    // 框架首页
    public function index ()
    {
        $uid = $this->session->userdata('id');
        if (! $uid) {
            redirect('index.php?d=admin&c=common&m=login');
        }
        
        $list = get_cache('category');
        $data['website'] = get_cache('website');
		
        $this->load->library('tree');
        $this->tree->init($list);
        $string = '<li><a href=\"index.php?d=admin&c=news&m=index&catid=$id\" target=\"main\" >$spacer  ▪ $name </li>';
        
        $data['category'] = $this->tree->get_tree(0, $string);
        
        $data['mainurl'] = '';
        $this->load->view('admin/frame_index', $data);
    }
     // 验证码
    public function checkcode ()
    {
        include APPPATH . 'libraries/checkcode.class.php';
        $checkcode = new checkcode();
        $checkcode->doimage();
        $_SESSION['checkcode'] = $checkcode->get_code();
    }
    
    // 默认搜索页
    public function main ()
    {
        $uid = $this->session->userdata('id');
        if (! $uid) {
            redirect('index.php?d=admin&c=common&m=login');
        }
        $this->load->view('admin/main');
    }
    
    // 登陆页
    public function login ()
    {
        $data['website'] = get_cache('website');
        $this->load->view('admin/login_index', $data);
    }
	
	
	 // 登陆页
    public function logins ()
    {
		$data['website'] = get_cache('website');
        $uid = $this->session->userdata('id');
        if ($uid > 0) {
            redirect('d=admin&c=common');
        }
        
        $this->load->view('admin/login', $data);
    }
    
    // 验证登陆
    public function check_login()
    {
        
        $username = trim($this->input->post('username'));
        $password = get_password($this->input->post('password'));
        //$checkcode = trim($this->input->post('checkcode'));

        /*if ($checkcode != $_SESSION['checkcode']) {
            show_msg('验证码不正确，请重新输入');
        }*/


		//密码错误剩余重试次数
		$query = $this->db->get_where('fm_times',array('username'=>$username));
		$rtime = $query->row_array();
		$maxloginfailedtimes = get_cache('website');
		$maxloginfailedtimes = (int)$maxloginfailedtimes['error_times'];

		if($rtime['times'] >= $maxloginfailedtimes) {
			$minute = 60-floor((time()-$rtime['logintime'])/60);
			if($minute>0)  show_msg("密码重试次数太多，请过{$minute}分钟后重新登录！", '');
		}

		$query = $this->db->get_where('fm_admin',
                array(
                        'username' => $username
                ), 1);
        $username_row = $query->row_array();
		if( $username_row ){
			 $query = $this->db->get_where('fm_admin',
                array(
                        'password' => $password
                ), 1);
        	$password_row = $query->row_array();
			if($password_row['password'] != $password ){
				$ip = ip();
				if($rtime && $rtime['times'] < $maxloginfailedtimes) {
					$times = $maxloginfailedtimes-intval($rtime['times']);
					$new_times = intval($rtime['times']) + 1;
					$data = array('ip'=>$ip,'isadmin'=>1,'times'=>$new_times);
					$this->db->where('username', $username);
            		$query = $this->db->update('fm_times', $data);
					//$this->times_db->update(),array('username'=>$username));
				} else {
					$this->db->query("delete from fm_times where username='$username'");
					$data = array('username'=>$username,'ip'=>$ip,'isadmin'=>1,'logintime'=>time(),'times'=>1);
					$query = $this->db->insert('fm_times', $data);
					$times = $maxloginfailedtimes;
				}
				show_msg("用户名或密码错误，您还有<b style='color:red'>{$times}</b>次机会登录！", '');

			}
			$this->db->query("delete from fm_times where username='$username'");
			unset($username_row['password']);
            $this->session->set_userdata($username_row);
            adminlog('登录成功');
            redirect('d=admin&c=common&m=index');


		}else{
			show_msg('用户名或密码错误，请重新登录！', 'index.php?d=admin&c=common&m=logins');
		}
		
		
       
    }
    
	        // 大平台接口登陆验证 -------------------
    public function login_api()
    {
    	     
		//接口参数
		$_SSCONFIG['api_key'] = '098f6bcd4621d373cade4e832627b4f9';
		$api_Type	  = trim($_POST['Type']);
		$api_Key      = trim($_POST['Key']);
		$api_Password = trim($_POST['Password']);
		$api_Account  = trim($_POST['Account']);
        $password = get_password($api_Password);

        //key验证
    	if($api_Key != $_SSCONFIG['api_key']) {
			echo json_encode(array('Status'=>-1));
			exit;
		}

        $query = $this->db->get_where('fm_admin',array('username' => $api_Account,'password' => $password), 1);
        $user = $query->row_array();
        
        if($api_Type == 'Band') { //绑定验证
        	if ($user) {
        		$status = 1;
        	} else {
        		$status = -3;
        	}
        	echo json_encode(array('Status'=>$status));
        } else {
            if ($user) {
	            unset($user['password']);
	            $this->session->set_userdata($user);
	            $status = 1;
	        } else {
	            $status = -3;
	        }        
	        echo json_encode(array('Status'=>$status));	
        }    
    }
	
    // 退出
    public function login_out ()
    {
        $this->session->unset_userdata('id');
        adminlog('退出登录');
        redirect('d=admin&c=common&m=login');
    }
    
    // 基础设置
    public function website ()
    {
        $data[web] = get_cache('website');
        
        $this->load->view('admin/website', $data);
    }
    
    // 百度地图
    public function baidumap ()
    {    
        $this->load->view('admin/baidumap');
    }
    
    // 基础设置
    public function website_save ()
    {
        $data = trims($_POST['value']);
        
        set_cache('website', $data);
        
        show_msg('设置成功！', 'index.php?d=admin&c=common&m=website');
    }
    
    public function android_version(){
		$data[web] = get_cache('android_version');        
        $this->load->view('admin/android_version', $data);
	}
	
	public function android_version_save(){
		$data = trims($_POST['value']);
        
        set_cache('android_version', $data);
        
        show_msg('设置成功！', 'index.php?d=admin&c=common&m=android_version');
	}
    
    
}

/* End of file welcome.php */




