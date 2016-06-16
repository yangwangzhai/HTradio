<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
include('common.php');  
class Setting extends Common
{	
	protected $uid = '';
	 function __construct ()
    {
        parent::__construct();
        $this->uid = $this->session->userdata('uid');
    	if(!$this->uid) {
    		header("location:index.php?c=member&m=login");
    		exit();
    	}
		
	}
    // 首页
    public function index ()
    {
        $data['mid'] = $this->uid;
        //主播资料
        $sql = "SELECT nickname,avatar FROM fm_member WHERE id = $this->uid";
        $query = $this->db->query($sql);
        $data['zb'] = $query->row_array();


        //我的节目数
        $sql = "SELECT count(*) as num FROM fm_program WHERE mid = $this->uid";
        $query = $this->db->query($sql);
        $data['program_num'] = $query->row_array();

        //我的关注数
        $sql = "SELECT count(*) as num FROM fm_attention WHERE mid = $this->uid";
        $query = $this->db->query($sql);
        $data['guanzhu_num'] = $query->row_array();

        $sql = "SELECT id,avatar FROM fm_member WHERE id in (SELECT zid FROM fm_attention WHERE mid = $this->uid ORDER BY addtime DESC) limit 6";
        $query = $this->db->query($sql);
        $data['guanzhu_list'] = $query->result_array();

        //我的粉丝数
        $sql = "SELECT count(*) as num FROM fm_attention WHERE zid = $this->uid";
        $query = $this->db->query($sql);
        $data['fans_num'] = $query->row_array();

        $sql = "SELECT id,avatar FROM fm_member WHERE id in (SELECT mid FROM fm_attention WHERE zid = $this->uid ORDER BY addtime DESC) limit 6";
        $query = $this->db->query($sql);
        $data['fans_list'] = $query->result_array();
    	
    	$sql = "SELECT username,nickname,truename,gender,email,tel,sign,avatar FROM fm_member WHERE id = $this->uid";
    	$query = $this->db->query($sql);
    	$data['udata'] = $query->row_array();
    	$this->load->view("setting",$data);
    }

    public function password() {
        if($_SESSION['th']==1) {

            redirect('c=personal');
            exit;
        }
            $data['mid'] = $this->uid;
        //主播资料
        $sql = "SELECT nickname,avatar FROM fm_member WHERE id = $this->uid";
        $query = $this->db->query($sql);
        $data['zb'] = $query->row_array();


        //我的节目数
        $sql = "SELECT count(*) as num FROM fm_program WHERE mid = $this->uid";
        $query = $this->db->query($sql);
        $data['program_num'] = $query->row_array();

        //我的关注数
        $sql = "SELECT count(*) as num FROM fm_attention WHERE mid = $this->uid";
        $query = $this->db->query($sql);
        $data['guanzhu_num'] = $query->row_array();

        $sql = "SELECT id,avatar FROM fm_member WHERE id in (SELECT zid FROM fm_attention WHERE mid = $this->uid ORDER BY addtime DESC) limit 6";
        $query = $this->db->query($sql);
        $data['guanzhu_list'] = $query->result_array();

        //我的粉丝数
        $sql = "SELECT count(*) as num FROM fm_attention WHERE zid = $this->uid";
        $query = $this->db->query($sql);
        $data['fans_num'] = $query->row_array();

        $sql = "SELECT id,avatar FROM fm_member WHERE id in (SELECT mid FROM fm_attention WHERE zid = $this->uid ORDER BY addtime DESC) limit 6";
        $query = $this->db->query($sql);
        $data['fans_list'] = $query->result_array();
        
        $sql = "SELECT username,avatar FROM fm_member WHERE id = $this->uid";
        $query = $this->db->query($sql);
        $data['udata'] = $query->row_array();
        $this->load->view("setting-changepwd",$data);
    }

    public function save() {
    	$nickname = $_POST['nickname'];
    	$gender = $_POST['gender'];
    	$truename = $_POST['truename'];
    	$tel = $_POST['tel'];
    	$email = $_POST['email'];
    	$sign = $_POST['sign'];
    	$this->db->where('id',$this->uid);
    	$res = $this->db->update('fm_member',array(
    		'nickname'=>$nickname,
    		'gender'=>$gender,
    		'truename'=>$truename,
    		'tel'=>$tel,
    		'email'=>$email,
    		'sign'=>$sign));
    	echo $this->db->affected_rows();
    }

    public function changepwd() {
        $oldpwd = $_POST['oldpwd'];
        $newpwd = $_POST['newpwd'];
        if(empty($oldpwd)){
            echo 0;
            exit();
        }

        if(empty($newpwd)){
            echo 2;
            exit();
        }


        $sql = "SELECT * FROM fm_member WHERE id = $this->uid AND password = '".get_password($oldpwd)."'";
        $query = $this->db->query($sql);
        $res = $query->row_array();
        if($res) {
            if($res['password'] == get_password($newpwd)){
                echo 3;
                exit();
            }

            $this->db->where('id',$this->uid);
            $res = $this->db->update('fm_member',array(
                'password1'=>get_password($newpwd)));
            $this->session->unset_userdata('uid');
            delete_cookie("cm_username");  
            delete_cookie("cm_password");
            echo 1;
        }else{
            echo 0;
        }
    }

    public function check_used() {
    	$val = $_POST['val'];
    	$field = $_POST['field'];
    	$sql = "SELECT * FROM fm_member WHERE id = $this->uid";
    	$query = $this->db->query($sql);
    	$data = $query->row_array();
    	if($data[$field] == $val) {
    		echo 0;
    	}else {
    		$query = $this->db->query("SELECT count(*) as num FROM fm_member WHERE $field = '$val'");
    		$num = $query->row_array();
    		if($num['num']) {
    			echo 1;
    		}else{
    			echo 0;
    		}
    	}
    }
}