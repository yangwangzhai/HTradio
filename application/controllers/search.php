<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
class Search extends CI_Controller
{
	 function __construct ()
    {
        parent::__construct();
		
	}
    // 首页
    public function index ()
    {
        $data['uid'] = $this->session->userdata('uid');
        $data['keyword'] = $keyword = trim($_GET['keyword']);

        $sql = "SELECT id,title,thumb,mid FROM fm_programme WHERE title like '%$keyword%'";
        $query = $this->db->query($sql);
        $data['me_list'] = $query->result_array();

        $sql = "SELECT id,title,mid,playtimes,program_time,addtime FROM fm_program WHERE title like '%$keyword%'";
        $query = $this->db->query($sql);
        $data['program_list'] = $query->result_array();

        $sql = "SELECT id,nickname,sign,avatar FROM fm_member WHERE nickname like '%$keyword%'";
        $query = $this->db->query($sql);
        $data['member_list'] = $query->result_array();

    	$this->load->view("search",$data);
    }
}