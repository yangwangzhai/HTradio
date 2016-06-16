<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class permission extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'permission';
        $this->baseurl = 'index.php?d=admin&c=permission';
        $this->table = 'fm_permission';
        $this->list_view = 'permission';
        $this->add_view = 'admin_add';
    }
    
    // 首页
    public function index ()
    {
		
        $catid = $_REQUEST['catid']==true?$_REQUEST['catid']:1;;
	    
       	$query = $this->db->query("SELECT * FROM fm_role_group");
        $roles = $query->result_array();
		foreach($roles as $role){
			$data['group'][$role['id']] =$role['role_name'];
		}
    	
		$query_row =  $this->db->query("SELECT * FROM $this->table WHERE id=$catid");
		$get_row= $query_row->row_array();
		$inmenu = json_decode($get_row['menu_list']);
		if($inmenu =='' || $inmenu ==NULL){
			$data['inmenu'] = array('1'=>1);
		}else{
			$data['inmenu'] = $inmenu;
		}
		
		$menu_lists = $this->config->item('menu_lists');
		$data['main_menu'] = $menu_lists['main_menu'];
	    $data['menu_lists'] = $menu_lists;
	    $data['catid'] = $catid;
		$data['id'] = $catid;
			
        $_SESSION['url_forward'] =  $this->baseurl ;
        $this->load->view('admin/' . $this->list_view, $data);
    }
    
    // 保存 添加和修改都是在这里
    public function save ()
    {
        $id = intval($_POST['id']);
        $menu_list = json_encode($_POST['strmenu']); 
        $query = $this->db->query("SELECT COUNT(*) AS num FROM $this->table WHERE  catid=$id");
        $count = $query->row_array();
        $num = $count['num']; 
        if ($num>0) { // 修改 ===========
			$sql = "update  $this->table set menu_list='$menu_list' where catid=$id ";
            $query = $this->db->query($sql);             	
       		show_msg('保存成功！', $_SESSION['url_forward'] . "&catid=$id");
        }else{
			$data['catid'] = $id;
			$data['menu_list'] = $menu_list;
			$query = $this->db->insert($this->table, $data);
			show_msg('保存成功！', $_SESSION['url_forward'] . "&catid=$id");
		}
    }
    
    
}
