<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 后台操作日志

include 'content.php';

class adminlog extends Content
{    
    function __construct ()
    {
        parent::__construct();
        
        $this->control = 'adminlog';
        $this->baseurl = 'index.php?d=admin&c=adminlog';
        $this->table = 'fm_adminlog';
        $this->list_view = 'adminlog_list'; // 添加页
    }
	
	 // 首页
    public function index ()
    {        
        $searchsql = '';
       
        $catid = intval($_REQUEST['catid']);
        $keywords = trim($_REQUEST['keywords']);
        
        if ($catid) {
            $this->baseurl .= "&catid=$catid";
            $searchsql .= " AND catid='$catid' ";
        }
        if ($keywords) {
            $this->baseurl .= "&keywords=" . rawurlencode($keywords);
            $searchsql .= " AND title like '%{$keywords}%' ";
        }
        
        $data['list'] = array();
        $query = $this->db->query(
                "SELECT COUNT(*) AS num FROM $this->table WHERE 1 $searchsql");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        
        $this->config->load('pagination', TRUE);       
        $pagination = $this->config->item('pagination');
        $pagination['base_url'] = $this->baseurl;
        $pagination['total_rows'] = $count['num'];        
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data['pages'] = $this->pagination->create_links();
                
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;       
        $sql = "SELECT * FROM $this->table WHERE 1 $searchsql ORDER BY id desc limit $offset,$this->per_page";
        $query = $this->db->query($sql);
        $data['list'] = $query->result_array();
		foreach($data['list'] as &$value){
			$query = $this->db->query("SELECT truename,username FROM fm_admin WHERE id={$value[adminid]}");
			$row = $query->row_array();
			$value['adminname'] = $row['truename'] ? $row['truename'] : $row['username'];
		}
        $data['catid'] = $catid;
        
        $_SESSION['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }
   
}
