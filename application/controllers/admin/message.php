<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
// 私信

include 'content.php';

class message extends Content
{
    function __construct ()
    {
        parent::__construct();
        
        $this->control = 'message';
        $this->baseurl = 'index.php?d=admin&c=message';
        $this->table = 'fm_message'; 
        $this->list_view = 'message_list'; // 列表页
        $this->add_view = 'message_add'; // 添加页
    }
    
    
    // 首页
    public function index ()
    {
        $searchsql = '';
        $config['base_url'] = $this->baseurl;       
        $keywords = trim($_REQUEST['keywords']);    
       
        if ($keywords) {
            $config['base_url'] = "&keywords=" . rawurlencode($keywords);
            $searchsql .= " AND title like '%{$keywords}%' ";
        }
        
        $data['list'] = array();
        $query = $this->db->query(
                "SELECT COUNT(*) AS num FROM $this->table WHERE 1 $searchsql");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        $this->load->library('pagination');
        $config['total_rows'] = $count['num'];
        $config['per_page'] = $this->per_page;
        $config['num_links'] = 5;
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links();
        
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;        
        $sql = "SELECT a.*,b.nickname AS from_user,c.nickname AS to_user  FROM fm_message AS a
LEFT JOIN (SELECT id,nickname FROM fm_member) AS b ON a.from_uid=b.id
LEFT JOIN (SELECT id,nickname FROM fm_member) AS c ON a.to_uid=c.id WHERE 1 $searchsql ORDER BY a.id DESC limit $offset,$this->per_page";
        $query = $this->db->query($sql);
        $data['list'] = $query->result_array();       
    
        $_SESSION['url_forward'] = $config['base_url'] . "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }
    
    
    
}
