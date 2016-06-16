<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    //标签管理  控制器 

include 'content.php';

class tag extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'tag';
        $this->baseurl = 'index.php?d=admin&c=tag';
        $this->table = 'fm_tag';
        $this->list_view = 'tag_list';
        $this->add_view = 'tag_add';
    }
    
    // 首页
    public function index ()
    {
        $catid = intval($_REQUEST['catid']);
        $keywords = trim($_REQUEST['keywords']);
        $searchsql = '1';
		
        // 是否是查询
        if (empty($keywords)) {
            $config['base_url'] = $this->baseurl . "&m=index&catid=$catid";
        } else {
        $searchsql .= " AND (tag_name like '%{$keywords}%')";
		
        $config['base_url'] = $this->baseurl .
        "&m=index&catid=$catid&keywords=" . rawurlencode($keywords);
        }
        
        $data['list'] = array();
        $query = $this->db->query(
        "SELECT COUNT(*) AS num FROM $this->table WHERE  $searchsql");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        $this->load->library('pagination');
        
        $config['total_rows'] = $count['num'];
        $config['per_page'] = $this->per_page;
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links();
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
        $per_page = $config['per_page'];
        $sql = "SELECT * FROM $this->table WHERE  $searchsql ORDER BY id DESC limit $offset,$per_page";
		$query = $this->db->query($sql);
		$list=$query->result_array();
        $data['list'] = $query->result_array();
        $data['catid'] = $catid; 
		//print_r($list);exit;
		
		
		/**$query = $this->db->query("SELECT * FROM fm_role_group");
        $roles = $query->result_array();
		foreach($roles as $role){
			$data['group'][$role['id']] =$role['role_name'];
		}**/
    
        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }
	
	
	
	
	
	// 添加
    public function add ()
    {
		$value['catid'] = intval($_REQUEST['catid']);
        $category = get_cache('category');
        $value['catname'] = $category[$value['catid']]['name'];
        $data['value'] = $value;
        
        $this->load->view('admin/' . $this->add_view, $data);
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
        $data['value'] = $value;
        
        $data['id'] = $id;

        
        
        $this->load->view('admin/' . $this->add_view, $data);
    }
	
	
    // 保存 添加和修改都是在这里
    public function save ()
    {
        $id = intval($_POST['id']);
        $data = trims($_POST['value']);
		
		if($data['tag_name'] == '') {
            show_msg('标签名称不能为空');
        }
        
        if ($id) { // 修改 ===========
            $this->db->where('id', $id);
            $query = $this->db->update($this->table, $data);
			adminlog('修改信息: '.$this->control.' -> '.$id);
            show_msg('修改成功！', $_SESSION['url_forward']);
        } else { // ===========添加 ===========
            $data['addtime'] = time();
            $query = $this->db->insert($this->table, $data);
			adminlog('添加信息: '.$this->control.' -> '.$this->db->insert_id());
            show_msg('添加成功！', $_SESSION['url_forward']);
        }
    }
    
    
}
