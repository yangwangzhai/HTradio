<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
// 首页 
class Common extends CI_Controller
{
  function __construct ()
  {
    parent::__construct();
    $this->uid = $this->session->userdata('uid');
    $username = $this->input->cookie("cm_username");//适用于控制器  
    $pwd = $this->input->cookie("cm_password"); 
    if($username && $pwd && !$this->uid){
	     $this->auto_login($username , $pwd);
		}
	}
	function auto_login($username , $pwd){
		$query = $this->db->get_where('fm_member',
                array(
                        'username' => $username,
                        'password' => $pwd
                ), 1);
        $user = $query->row_array();
        if ($user) {
			
			$userdata = array(
                   'uname'  => $user['username'],
				   'nickname'  => $user['nickname'],
                   'uid'     => $user['id'],
                   'logged_in' => TRUE
               );
			
			$this->session->set_userdata($userdata); 
		}
	}
}
