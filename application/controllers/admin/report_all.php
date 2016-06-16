<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
// 举报 

include 'content.php';

class Report_all extends Content
{
    
    function __construct ()
    {
        parent::__construct();
        
        $this->control = 'report_all';
        $this->baseurl = 'index.php?d=admin&c=report_all';
        $this->table = 'fm_report_all';
        $this->list_view = 'report_all_list'; // 列表页
      
    }
    
    // 首页
    public function index ()
    {

        $searchsql = ' AND status=0 ';
		$status = trim($_REQUEST['status']) ?$_REQUEST['status']:0;
        $config['base_url'] = $this->baseurl. "&status=0";
        $catid = intval($_REQUEST['catid']);
        $keywords = trim($_REQUEST['keywords']);
    	$data['status'] = 0;	
        if ($catid) {
            $config['base_url'] = "&catid=$catid";
            $searchsql .= " AND catid='$catid' ";
        }
		
		if (empty($keywords)) {
				$searchsql = " AND status =$status ";
				$data['status'] = $status;
				$config['base_url'] = $this->baseurl . "&m=index&status=$status";  
        }
		
        if ($keywords) {
			$searchsql = " AND status =$status ";
				$data['status'] = $status;
            $config['base_url'] = "&keywords=" . rawurlencode($keywords) . "&status=$status";
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
        $sql = "SELECT * FROM $this->table WHERE 1 $searchsql ORDER BY id DESC limit $offset,$this->per_page";
        $query = $this->db->query($sql);
        $list = $query->result_array();
		$tables = $this->config->item('report_tb');
		$type_text =  $this->config->item('report_type');
		if(count($list) > 0){
			foreach($list as &$value) { 
				$type = $value['type'];
				$report_id = $value['report_id'];
				$table = $tables[$type];
				if($type == 1 || $type ==2 || $type == 3 || $type == 6){
					$query = $this->db->query("SELECT *  FROM $table WHERE id=$report_id");
					$row = $query->row_array(); 
					if($row['isbase64'] == 1) $row['title'] = base64_decode($row['title']);		
					if($row['audio']){
						 $value['content']= QuickTimeJS($row[id],$row[audio],'').'<span id="player-'.$row[id].'"></span>';						 
					}else{
						 $value['content']=  $row['title'];
					}  
					
					
					if($type == 3){
						$value['content'] =  $row[district] .' '.
                                $row['street'].' '. $row['typename'].' '.
                                $row['title'];
					}
					
				}
				
				
				
				
				if($type == 4 || $type == 5){
					$query = $this->db->query("SELECT id,content,audio  FROM $table WHERE id=$report_id");
					$row = $query->row_array(); 
					if($row['audio']){
						 $value['content']= QuickTimeJS($row[id],$row[audio],'').'<span id="player-'.$row[id].'"></span>';
						 
					}else{
						 $value['content']=  $row['content'];
					}
					 
				}
				$value['type'] = $type_text[$type];                 
				$value['publisher'] =   getNickName($value[publisher]);
				$value['reporter'] =   getNickName($value[reporter]);
		}
	}
	 	$data['list'] = $list;
        $data['catid'] = $catid;
      
        $_SESSION['url_forward'] = $config['base_url'] . "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }  
	
	 // 保存 添加和修改都是在这里
    public function updatereport()
    {
        $id = intval($_GET['id']);  
		$status = $_GET['status'];
		if($status == 0){
			$status = 1;
		}else if($status == 1){
			$status = 0;
		}
        if ($id) {           
            $query = $this->db->query("update $this->table set status=$status where id=$id ");
            echo 'ok';
        } 
    }  
    
}
