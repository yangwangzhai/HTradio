<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 问路 回答

include 'content.php';
class askanswer extends Content
{    
    function __construct ()
    {
        parent::__construct();
        
        $this->control = 'askanswer';
        $this->baseurl = 'index.php?d=admin&c=askanswer';
        $this->table = 'fm_askway_answer';
        $this->list_view = 'askanswer_list'; // 列表页
        $this->add_view = 'askanswer_add'; // 列表页
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
            if($value[audio]) $value[content] = QuickTimeJS($value[id],$value[audio],'').'<span id="player-'.$value[id].'"></span>';
        }
        $data['list'] = addMember($list);
        $data['catid'] = $catid;
        
        $_SESSION['url_forward'] = $config['base_url'] . "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }
    
    
}
