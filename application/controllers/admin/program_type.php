<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    //节目单管理  控制器 

include 'content.php';

class program_type extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'program_type';
        $this->baseurl = 'index.php?d=admin&c=program_type';
        $this->table = 'fm_program_type';
        $this->list_view = 'program_type_list';
        $this->add_view = 'program_type_add';
    }
    
    // 首页
    public function index ()
    {
        $catid = intval($_REQUEST['catid']);
        $keywords = trim($_REQUEST['keywords']);
        $searchsql = '1';
		//$searchsql .= "pid=0";
        //         if ($catid) {
        //             $searchsql .= " AND catid=$catid ";
        //         }
        // 是否是查询
        if (empty($keywords)) {
            $config['base_url'] = $this->baseurl . "&m=index&catid=$catid";
        } else {
        $searchsql .= " AND (title like '%{$keywords}%')";
		
        $config['base_url'] = $this->baseurl .
        "&m=index&catid=$catid&keywords=" . rawurlencode($keywords);
        }
        $searchsql .= " AND pid=0";
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
		 
        $sql = "SELECT * FROM $this->table WHERE  $searchsql ORDER BY hot DESC,id DESC limit $offset,$per_page";
		
		$query = $this->db->query($sql);
		$list=$query->result_array();
        $data['list'] = $query->result_array();
        $data['catid'] = $catid;
		//print_r($list);exit;
		
		$sql_sub = "SELECT * FROM $this->table WHERE pid!='0' ";
		$query_sub = $this->db->query($sql_sub);
		$list_sub=$query_sub->result_array();
        $data['list_sub']=$list_sub; 
		$data['status'] = array(0=>'未推送',1=>'已推送');
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
    
	// 添加二级分类
    public function add_sub ()
    {
		$id = intval($_GET['id']);
		if($_POST){
			
			$data = trims($_POST['value']);
            $data['addtime'] = time();
			
            $query = $this->db->insert($this->table, $data);
			adminlog('添加信息: '.$this->control.' -> '.$this->db->insert_id());
            show_msg('添加成功！', $_SESSION['url_forward']);
			}else{
				
			// 这条信息
			$query = $this->db->get_where($this->table, 'id = ' . $id, 1);
			$value = $query->row_array();
			$data['value'] = $value;
			$data['id'] = $id;
		
		  
        
        $this->load->view('admin/program_type_add_sub' , $data);
      }
	
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
		
		if($data['title'] == '') {
            show_msg('节目类型名称不能为空');
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
    
	 public function updatestatus ()
    {
        $id = intval($_GET['id']);
        $status = intval($_GET['status']);
        $field = $_GET['field'];		
	
        if ($id) {
            $this->db->query("update $this->table set hot=$status where id='$id' limit 1");
            echo $id ;
            exit;
        }
        echo -1;
    }
    
}
