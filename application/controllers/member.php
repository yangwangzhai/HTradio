<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );


class member extends  CI_Controller
{
	 function __construct ()
    {
        parent::__construct();
		
	}
	
	
	
	public function reg(){
		
			$this->load->view('reg',$data);	
	}
	
	public function login(){
			$data['refer'] = $_GET['refer'];
			$this->load->view('login',$data);	
	}
	
	public function verify() {		
			$config = array('width' => 80,'height' => 35);
			$this->load->library('image',$config);
          	$this->image->doimg();  // 对象的实例名永远都是小写的 buildImageVerify();
			$_SESSION['authnum_session'] = 	$this->image->getCode();//验证码保存到SESSION中
        }
		
	// 会员 登录验证
	public function check_login() {
		$username = $_POST['u'];
		$password = get_password($_POST['p']);
		$yzm = $_POST['y'];
		$remember = $_POST['r'];
		if($yzm != 'yzm'){
			if($yzm != $_SESSION['authnum_session'] ){
				echo 1;
				return ;
			}
		}
		$query = $this->db->get_where('fm_member',
                array(
                        'username' => $username,
                        'password' => $password
                ), 1);
        $user = $query->row_array();
        if ($user) {
			echo 0;
			$userdata = array(
                   'uname'  => $user['username'],
				   'nickname'  => $user['nickname'],
                   'uid'     => $user['id'],
                   'logged_in' => TRUE
               );
			//记住登录状态   
			if($remember){   
				$this->input->set_cookie("cm_username",$user['username'],60 * 60 * 24 * 7);  
				$this->input->set_cookie("cm_password",$user['password'],60 * 60 * 24 * 7);  
			}   
			$this->session->set_userdata($userdata);           
		}else{
			echo 2;
		}
	}
	
	// 注册
	public function check_reg() {
		$postdate = array (
				'username' => trim ( $_POST ['username'] ),				
				'password' => trim ( $_POST ['password'] ),
				'email' => trim ( $_POST ['email'] ),
				'nickname' => trim ( $_POST ['nickname'] ),
				'tel' => trim ( $_POST ['tel'] ),
				'regtime' => time (),
				'status' => 1,
				'lastlogintime' => time () 
		);
		$yzm = $_POST['yzm'];
		if($yzm != $_SESSION['authnum_session'] ){
				echo 1;
				return ;
		}
		
		if (empty ( $postdate ['username'] ) || empty ( $postdate ['password'] )) {
			echo 2;
			return ;
		}
		
		$query = $this->db->query ( "select id from fm_member where username='{$postdate[username]}' limit 1" );
		
		if ($query->num_rows () > 0) {
			echo 3;
			return ;
		}
		
		$postdate ['password'] = get_password ( $postdate ['password'] );
		$query = $this->db->insert ( 'fm_member', $postdate );
		$insert_id = $this->db->insert_id ();
		
		if ($insert_id) {
			
			echo 0;
			$userdata = array(
                   'uname'  => $postdate['username'],
				   'nickname'  => $postdate['nickname'],
                   'uid'     => $insert_id,
                   'logged_in' => TRUE
               );
			$this->session->set_userdata($userdata); 
			update_logincount($insert_id);
			// 统计加1
			//$this->load->model ( 'stat_model' );
			//$this->stat_model->day_save ( 'members' );
		} else {
			echo 4;
		}
	}
	
	public function check_used(){
		$val = $_POST['val'];
		$field = $_POST['field'];
		$query = $this->db->query ( "select id from fm_member where `$field`='{$val}' limit 1" );		
		if ($query->num_rows () > 0) {
			echo 1;
		}else{
			echo 0;
		}
	}
	
	public function login_out(){
		$this->session->unset_userdata('uid');
		$this->session->unset_userdata('th');
		delete_cookie("cm_username");  
		delete_cookie("cm_password");  
		redirect('c=index&m=find'); 
	}
	


	// 会员 找回密码
	function find_password() {
		$result = '';
		$email = trim ( $_POST ['email'] );
		
		if (! isemail ( $email )) {
			error ( 1, "邮箱格式错误" );
		}
		
		$query = $this->db->get_where ( 'fm_member', array (
				'email' => $email 
		), 1 );
		$row = $query->row_array ();
		if (empty ( $row )) {
			error ( 2, "没有找到该邮箱" );
		}
		
		// 修改密码
		$this->load->helper ( 'string' );
		$radom = strtolower ( random_string ( 'alpha', 6 ) );
		$new_password = get_password ( $radom );
		$this->db->update ( 'fm_member', array (
				'password' => $new_password 
		), array (
				'email' => $email 
		) );
		
		// 发送新密码到该邮箱
		$this->load->library ( 'email' );
		$config ['protocol'] = 'smtp';
		$config ['smtp_host'] = 'smtp.qq.com';
		$config ['smtp_user'] = '1574147371@qq.com';
		$config ['smtp_pass'] = 'ruantejishu000';
		$config ['smtp_port'] = '25';
		$config ['newline'] = "\r\n";
		$this->email->initialize ( $config );
		$this->email->from ( '1574147371@qq.com', '微路' );
		$this->email->to ( $email );
		$this->email->subject ( '微路客户端 - 找回密码' );
		$this->email->message ( "微路客服提示您：您的新密码已重置为  $radom " );
		$this->email->send ();
		
		echo 'ok';
		
		// 第一步 发送邮箱验证码到他邮箱
		// 第二步 验证 验证码是否正确
		// 第三步 重新设置新密码
	}
	
	// 更新 此会员登录次数 登录时间
	function update_logincount($uid) {
		if( !$uid ) return; 
		
		if (! empty ( $uid )) {
			$query = $this->db->query ( 'update fm_member set logincount=logincount+1,lastlogintime=' . time () . ' where id=' . $uid );
		}
	}
	
	
} // 类结束
