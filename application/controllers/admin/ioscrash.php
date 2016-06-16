<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
// 问路

include 'content.php';

class ioscrash extends Content
{    
    function __construct ()
    {
        parent::__construct();
        
        $this->control = 'ioscrash';
        $this->baseurl = 'index.php?d=admin&c=ioscrash';
        $this->table = 'fm_ios_crash';
        $this->list_view = 'ios_crash_list';
        $this->add_view = 'ios_crash_add';
    }  

    
    // 首页
    public function index ()
    {
        $searchsql = '';      
        $keywords = trim($_REQUEST['keywords']);       
        
        if($keywords) {
            $this->baseurl .= "&keywords=" . rawurlencode($keywords);
            $searchsql .= " AND (version like '%{$keywords}%' OR bliud like '%{$keywords}%') ";            
        }
        
        $data['list'] = $list = array();
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
        $query = $this->db->query("SELECT * FROM $this->table WHERE 1 $searchsql ORDER BY id DESC limit $offset,$this->per_page"); 
      
        $data['list'] = $query->result_array();
        
        
        $_SESSION['url_forward'] = $this->baseurl. "&per_page=$offset";        
        $this->load->view('admin/' . $this->list_view, $data);
    }    

}
