<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
// 会员 控制器 by tangjian 

include 'content.php';

class Member extends Content
{
    // 会员组
    private $category = array(
            0 => '普通会员',
            1 => '认证会员',
            2 => '高级会员',
            3 => '电台组',
            );
    
    function __construct ()
    {
        parent::__construct();
        
        $this->control = 'member';
        $this->baseurl = 'index.php?d=admin&c=member';
        $this->table = 'fm_member';
        $this->list_view = 'member_list';
        $this->add_view = 'member_add';        
    }
    
    // 首页
    public function index()
    {
        $catid = intval($_REQUEST['catid']);
        $keywords = trim($_REQUEST['keywords']);
		$groupname = trim($_REQUEST['groupname']);
        $searchsql = '1';
//         if ($catid) {
//             $searchsql .= " AND catid=$catid ";
//         }
        // 是否是查询
        if (empty($keywords)) {
			if (empty($groupname)) {
            	$config['base_url'] = $this->baseurl . "&m=index&catid=$catid";  
			}else{
				$config['base_url'] = $this->baseurl . "&m=index&catid=$catid&groupname=$groupname"; 
				if( $groupname == 'other' ){
					 $searchsql .= " AND (groupname ='')"; 
				}else{
					 $searchsql .= " AND (groupname like '%{$groupname}%')"; 
				}
				
			}
        } else {
			if (empty($groupname)) {
				 $searchsql .= " AND (email like '%{$keywords}%' OR username like '%{$keywords}%' OR nickname like '%{$keywords}%' OR tel like '%{$keywords}%')";          
            $config['base_url'] = $this->baseurl . "&m=index&catid=$catid&keywords=" . rawurlencode($keywords);
			}else{
				
				 if( $groupname == 'other' ){
					  $searchsql .= " AND (email like '%{$keywords}%' OR username like '%{$keywords}%' OR nickname like '%{$keywords}%' OR tel like '%{$keywords}%')  AND (groupname ='')";
				}else{
					  $searchsql .= " AND (email like '%{$keywords}%' OR username like '%{$keywords}%' OR nickname like '%{$keywords}%' OR tel like '%{$keywords}%')  AND (groupname like '%{$groupname}%')";
				}
				 
            $config['base_url'] = $this->baseurl . "&m=index&catid=$catid&groupname=$groupname&keywords=" . rawurlencode($keywords);
				}
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
        $sql = "SELECT * FROM $this->table WHERE  $searchsql ORDER BY sort,id DESC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $list = $query->result_array();    
		foreach($list as &$value) {
		  $query1 = $this->db->query("SELECT count(*) num FROM fm_attention WHERE zid = {$value['id']}");
		  $num = $query1->row_array();
          $value['favorite_num'] = $num['num'];
		  
		  $query1 = $this->db->query("SELECT count(*) num FROM fm_program WHERE mid = {$value['id']}");
		  $num = $query1->row_array();
          $value['program_num'] = $num['num'];
		  
        }  
		$data['list'] = $list;
        $data['category'] = $this->category;       
    	$data['groupname'] = $groupname;
		
        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }
    
    // 添加
    public function add ()
    {
        $data['status_array'] = $this->status;
        $data['category'] = $this->category;
    
        $this->load->view('admin/' . $this->add_view, $data);
    }
    
    // 编辑
    public function edit()
    {
        $id = intval($_GET['id']);
        
        // 这条信息
        $query = $this->db->get_where($this->table, 'id = ' . $id, 1);
        $value = $query->row_array();
        $category = get_cache('category');
        $value['catname'] = $category[$value['catid']]['name'];
        $value['regtime'] = times($value['regtime'],1);
        $value['lastlogintime'] = times($value['lastlogintime'],1);
        $data['value'] = $value;
        
        $data['id'] = $id;
        $data['baseurl'] = $this->baseurl;
        $data['status_array'] = $this->status;
        $data['category'] = $this->category;
        
        $this->load->view('admin/' . $this->control . '_add', $data);
    }
    
    // 保存 添加和修改都是在这里
    public function save ()
    {
        $id = intval($_POST['id']);
        $data = trims($_POST['value']);
        
        if($data[password]) {
            $data[password] = get_password($data[password]);
        } else {
            unset ($data[password]);
        }
        if($data['avatar']) {
        	thumb($data['avatar'] );
        }
        
        if ($id) { // 修改 ===========
            $this->db->where('id', $id);
            $query = $this->db->update($this->table, $data);
			adminlog('修改信息: '.$this->control.' -> '.$id);
            show_msg('修改成功！', $_SESSION['url_forward']);
        } else { // ===========添加 ===========
            $data['regtime'] = time();
			$data['status'] = 1;
            $query = $this->db->insert($this->table, $data);
			adminlog('添加信息: '.$this->control.' -> '.$this->db->insert_id());
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
    		$query = $this->db->query("select id from $this->table where username='$value[2]' limit 1");
    		$row = $query->row_array();
    		if(empty($row)) {
    			$thumb = '';
    			// 获取主播的 头像
    			$query = $this->db->query("select thumb from fm_zhubo where title='$value[3]' limit 1");
    			$zhubo = $query->row_array();
    			if($zhubo['thumb']) {
    				thumb($zhubo['thumb']);
    				$thumb = $zhubo['thumb'];
    			}
    			$data = array(
    					'username' => $value[2],
    					'password' => 'fe78dbdd37b9b60dc886c1a1fba7303b', //123888
    					'nickname' => $value[3],
    					'truename' => $value[2],
    					'groupname' => $value[1],
    					'status' => 1,
    					'avatar' => $thumb,
    			);    			
    			$this->db->insert($this->table, $data);
    			$i++;
    		}
    	}
    	echo '导入完成'. $i;    	 
    }

    
	

}
