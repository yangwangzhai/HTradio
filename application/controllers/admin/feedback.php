<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 评论  控制器 by tangjian 

include 'content.php';
class feedback extends Content
{

    function __construct ()
    {
        parent::__construct();
        
        $this->control = 'comment';
        $this->baseurl = 'index.php?d=admin&c=feedback';
        $this->table = 'fm_feedback';
        $this->list_view = 'feedback_list'; // 列表页
        $this->add_view = 'program_comment_add'; // 列表页
    }
    
    // 首页
    public function index ()
    {
        
        $searchsql = '';
        $config['base_url'] = $this->baseurl;
        $catid = intval($_REQUEST['catid']);
        $keywords = trim($_REQUEST['keywords']);
        
        if ($catid) {
            $config['base_url'] = "&catid=$catid";
            $searchsql .= " AND catid='$catid' ";
        }
        if ($keywords) {
            $config['base_url'] = "&keywords=" . rawurlencode($keywords);
            $searchsql .= " AND content like '%{$keywords}%' ";
        }
        
        $data['list'] = array();
        $query = $this->db->query(
                "SELECT COUNT(*) AS num FROM $this->table WHERE 1 $searchsql");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        $this->load->library('pagination');
        $config['total_rows'] = $count['num'];
        $config['per_page'] = $this->per_page;
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links();
        
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
        $sql = "SELECT * FROM $this->table WHERE 1 $searchsql ORDER BY id DESC limit $offset,$this->per_page";
        $query = $this->db->query($sql);
        $list = $query->result_array();
        foreach($list as &$value) {           
            if($value[audio]) $value[content] = QuickTimeJS($value[id],$value[audio],'').'<span id="player-'.$value[id].'"></span>'.$value[content];
        }
        $data['list'] = addMember($list);
        $data['catid'] = $catid;
        
        $_SESSION['url_forward'] = $config['base_url'] . "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }
    
    
}
