<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
	

include 'content.php';
class Link extends Content {

	function __construct() {
		parent::__construct ();
		
		$this->control = 'link';
		$this->baseurl = 'index.php?d=admin&c=link';
		$this->table = 'fm_link';
		$this->list_view = 'link_list'; // 列表页
		$this->add_view = 'link_add'; // 添加页
		 $_SESSION['url_forward'] = $this->baseurl;
	}
	
	
	function index(){
		
		 $catid = intval($_REQUEST['catid']);
        $keywords = trim($_REQUEST['keywords']);
       $searchsql='1';
		//$searchsql .= "pid=0";
        //         if ($catid) {
        //             $searchsql .= " AND catid=$catid ";
        //         }
        // 是否是查询
        if (empty($keywords)) {
            $config['base_url'] = $this->baseurl . "&m=index&catid=$catid";
        } else {
        $searchsql .= " AND (name like '%{$keywords}%')";
		
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
	
		
		//print_r($data);exit;
		/**$query = $this->db->query("SELECT * FROM fm_role_group");
        $roles = $query->result_array();
		foreach($roles as $role){
			$data['group'][$role['id']] =$role['role_name'];
		}**/
    
        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
		
		
		
		}
		
	// 编辑
	public function add() {
		
		
		
		$this->load->view ( 'admin/' .$this->add_view);
	}
	
	// 保存 添加和修改都是在这里
	public function save() {
		$id = intval ( $_POST ['id'] );
		$data = trims ( $_POST ['value'] );
		
		if ($data ['name'] == '') {
			show_msg ( '网站名标题不能为空' );
		}
// 		if ($data ['thumb'] == "") {
// 			show_msg ( '图片不能为空' );
// 		}
		$data ['addtime'] = strtotime( $data ['addtime'] );
		
		if ($id) { // 修改 ===========
			$this->db->where ( 'id', $id );
			$query = $this->db->update ( $this->table, $data );
			adminlog ( '修改信息' . $this->control . $id );
			show_msg ( '修改成功！', $_SESSION ['url_forward'] );
		} else { // ===========添加 ===========		
		    $data['addtime']=time();	
			$query = $this->db->insert ($this->table, $data );
			adminlog ( '添加信息' . $this->control . $this->db->insert_id () );
			show_msg ( '添加成功！', $_SESSION ['url_forward'] );
		}
	}
	

	
}
