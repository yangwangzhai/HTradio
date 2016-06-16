<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
// 问路

include 'content.php';

class askway extends Content
{    
    function __construct ()
    {
        parent::__construct();
        
        $this->control = 'askway';
        $this->baseurl = 'index.php?d=admin&c=askway';
        $this->table = 'fm_askway';
        $this->list_view = 'askway_list';
        $this->add_view = 'askway_add';
    }  

    
    // 首页
    public function index ()
    {
        $searchsql = '';      
        $keywords = trim($_REQUEST['keywords']);       
        
        if($keywords) {
            $this->baseurl .= "&keywords=" . rawurlencode($keywords);
            $searchsql .= " AND (title like '%{$keywords}%' OR street like '%{$keywords}%') ";            
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
        $district = $this->config->item('district');
        $list = $query->result_array();
        foreach($list as &$value) {
            $value['title'] = $district[ $value[district] ].' '.
                                $value['street'].' '.
                                $value['title'];
            $value['thumb100'] = new_thumbname($value['thumb'], 100, 100);
            $value['thumb720'] = new_thumbname($value['thumb'], 720, 720);
            if($value['audio']) $value['audio']= QuickTimeJS($value[id],$value[audio],'').'<span id="player-'.$value[id].'"></span>';
        }
        $data['list'] = addMember($list);
        
        $_SESSION['url_forward'] = $this->baseurl. "&per_page=$offset";        
        $this->load->view('admin/' . $this->list_view, $data);
    }    

}
