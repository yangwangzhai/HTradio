<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 群聊信息
    
include 'content.php';

class groups_chats extends Content
{
   public $groups = array();
    
    function __construct ()
    {
        parent::__construct();		
		
        $this->control = 'groups_chats';
        $this->baseurl = 'index.php?d=admin&c=groups_chats';
        $this->table = 'fm_groups_chats';
        $this->list_view = 'groups_chats_list';
        $this->add_view = 'groups_chats_add'; 

        $this->load->model('groups_model');
        $this->groups =  $this->groups_model->lists();      
    }
    
    
	// 首页
    public function index ()
    {    	
    	
        $searchsql = '';
        $config['base_url'] = $this->baseurl;
        $keywords = trim($_REQUEST['keywords']);
    	$groupid = trim($_REQUEST['groupid']);
		
	
        if($keywords) {
			$config['base_url'] .= "&keywords=" . rawurlencode($keywords) . "&groupid=" . $groupid;
			$base64_title = base64_decode($keywords);
			if(!empty($groupid)){
				 $searchsql .= " AND( title like '%{$keywords}%' OR title like '%{$base64_title}%') AND groupid=$groupid";				
			}else{
				 $searchsql .= " AND( title like '%{$keywords}%' OR title like '%{$base64_title}%')";
			}         
        }else{
			if(!empty($groupid)){
				 $config['base_url'] .= "&groupid=" . $groupid;
				 $searchsql .= " AND groupid=$groupid";				
			}  
			
		}
        
        $data['list'] = $list = array();
        $query = $this->db->query(
                "SELECT COUNT(*) AS num FROM $this->table WHERE 1 $searchsql");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        $this->load->library('pagination');        
        $config['total_rows'] = $count['num'];
        $config['per_page'] = 20;
        $config['num_links'] = 5;
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links();
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
        $per_page = $config['per_page'];
        $query = $this->db->query("SELECT * FROM $this->table WHERE 1 $searchsql ORDER BY id DESC limit $offset,$per_page"); 
       
        $list = $query->result_array();
        foreach($list as &$value) {
			if($value['isbase64'] == 1) $value['title'] = base64_decode($value['title']);
        	$value['groupname'] =   $this->groups[$value[groupid]];
            $value['thumb100'] = new_thumbname($value['thumb'], 100, 100);
            $value['thumb720'] = new_thumbname($value['thumb'], 720, 720);
            if($value['audio']) $value['audio']= QuickTimeJS($value[id],$value[audio],'').'<span id="player-'.$value[id].'"></span>';
        }
        $data['list'] = addMember($list);
        $data['value'] = array('groupid' =>$groupid);
        $_SESSION['url_forward'] = $config['base_url']. "&per_page=$offset";        
        $this->load->view('admin/' . $this->list_view, $data);
    } 


	 // 编辑
    public function edit ()
    {
        $id = intval($_GET['id']);
        
        // 这条信息
        $query = $this->db->get_where($this->table, 'id = ' . $id, 1);
        $value = $query->row_array();
        $category = get_cache('category');
        $value['catname'] = $category[$value['catid']]['name'];
		 if($value['isbase64'] == 1) $value['title'] = base64_decode($value['title']);	
        $data['value'] = $value;
       
        $data['id'] = $id;
        
        $this->load->view('admin/' . $this->add_view, $data);
    }
	
    // 保存 添加和修改都是在这里
    public function save ()
    {
    	$id = intval($_POST['id']);
    	$data = trims($_POST['value']);
		$data['uid'] = intval($data['uid']);
    
    	        if ($data['uid'] == "") {
    	            show_msg('用户ID不能为空');
    	        }
    	if($data['thumb']) {
    		thumb2($data['thumb'] );
    	}
    	
		if($data['isbase64'] == 1) {
    		$data['title'] = base64_encode($data['title']);
    	}
    
		
    	if ($id) { // 修改 ===========
    		$this->db->where('id', $id);
    		$query = $this->db->update($this->table, $data);
    		adminlog('修改信息'.$this->control.$id);
    		show_msg('修改成功！', $_SESSION['url_forward']);
    	} else { // ===========添加 ===========
    		$data['addtime'] = time();
//     		$query = $this->db->insert($this->table, $data);
			$insert_id = $this->groups_model->chats_save($data);
			
    		adminlog('添加信息'.$this->control.$insert_id);
    		show_msg('添加成功！', $_SESSION['url_forward']);
    	}
    }
    
    
}
