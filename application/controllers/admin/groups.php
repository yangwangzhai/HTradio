<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 群  控制器 by tangjian
    
include 'content.php';

class groups extends Content
{    
    function __construct ()
    {
        parent::__construct();        
		
		
        $this->control = 'groups';
        $this->baseurl = 'index.php?d=admin&c=groups';
        $this->table = 'fm_groups';
        $this->list_view = 'groups_list';
        $this->add_view = 'groups_add';        
    }
    
    
	
	 // 首页
    public function index ()
    {        
        $searchsql = '';
       
        $catid = intval($_REQUEST['catid']);
        $keywords = trim($_REQUEST['keywords']);
        
        if ($catid) {
            $this->baseurl .= "&catid=$catid";
            $searchsql .= " AND catid='$catid' ";
        }
        if ($keywords) {
            $this->baseurl .= "&keywords=" . rawurlencode($keywords);
            $searchsql .= " AND title like '%{$keywords}%' ";
        }
        
        $data['list'] = array();
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
        $sql = "SELECT * FROM $this->table WHERE 1 $searchsql ORDER BY sort,id desc limit $offset,$this->per_page";
        $query = $this->db->query($sql);
        $data['list'] = $query->result_array();
        $data['catid'] = $catid;
        
        $_SESSION['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }
    // 保存 添加和修改都是在这里
    public function save ()
    {
    	$id = intval($_POST['id']);
    	$data = trims($_POST['value']);
    	
    	if (!isset($data['hot'])) {
    		$data['hot'] = 0;
    	}
		
		if (!isset($data['sort'])) {
    		$data['sort'] = 100;
    	}
		if (!isset($data['uid'])) {
    		$data['uid'] = 0;
    	}
    
    	if ($id) { // 修改 ===========
    		$this->db->where('id', $id);
    		$query = $this->db->update($this->table, $data);
    		adminlog('修改信息'.$this->control.$id);
    		show_msg('修改成功！', $_SESSION['url_forward']);
    	} else { // ===========添加 ===========
    		$data['addtime'] = time();
			$data['last_title'] = '';
			$data['last_time'] = time();
    		$query = $this->db->insert($this->table, $data);
    		adminlog('添加信息'.$this->control.$this->db->insert_id());
    		show_msg('添加成功！', $_SESSION['url_forward']);
    	}
    }
    
    // 导入Excel
    public function excelIn ()
    {
    	exit('暂时不能使用');
    	require_once APPPATH . 'libraries/Spreadsheet_Excel_Reader.php';
    	// require_once 'Excel/reader.php'; //加载所需类
    	$data = new Spreadsheet_Excel_Reader(); // 实例化
    	$data->setOutputEncoding('utf-8'); // 设置编码
    	$data->read('zhubo.xls'); // read函数读取所需EXCEL表，支持中文
    	$list = $data->sheets[0]['cells'];
    	unset($list[1]);
    	// print_r($list);
    	$i = 0;
    	foreach($list as $value) {
    		// 查找是否已经存在
    		$query = $this->db->query("select id from fm_groups where title='$value[3]' limit 1");
    		$row = $query->row_array();
    		if(empty($row)) {
    			$data = array(
    					'title' => $value[3],
    					'keywords' => $value[3],
    					'description' => $value[3],
    					'ad_des' => $value[3],
    					'status' => 1   					
    					);
    			$this->db->insert('fm_groups', $data);
    			$i++;
    		}
    	}
    	echo '导入完成'. $i;
    	
    }
    
  
}
