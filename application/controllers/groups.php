<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * 群 接口
 */
include 'api.php';
class groups extends Api
{
    function __construct ()
    {
        parent::__construct();        
       
        $this->load->model('groups_model');       
    }
    
    // 首页
    function list_home ()
    {   $uid = $_GET['uid'] ? $_GET['uid'] : 0; 	
    	$list = $this->groups_model->groups_list_home($uid);    	
    	echo json_encode($list);
    }
    
    
    // 群 tag列表
    function tag_list()
    {
    	
    	$query = $this->db->query("select id from fly_groups where hot=1 ORDER BY type desc,id limit 30");
    	$list = $query->result_array();
    	foreach($list as &$value) {    	
    		$value['group_tag'] = 'group'.$value['id'];    		
    		unset($value['id']);
    	}
    	 
    	echo json_encode($list);
    }
    
    // 获取一个群的信息
    public function detail()
    {
    	$id = intval($_GET['id']);
    	if(empty($id)) {
    		show(1, 'id is null');
    	}
    	$uid = $this->groups_model->memberid_for_group($id);
    	$value = $this->groups_model->groups_detail($id);
    	$value['uid'] = $uid;
    	if($value['thumb']) {
    		$value['thumb'] = base_url().$value['thumb'];
    	}
    	if($value['ad_pic']) {
    		$value['ad_pic'] = base_url().$value['ad_pic'];
    	}    	
    	echo json_encode($value);
    }    
    
    
    // 主播列表
    public function zhubo_list ()
    {
    	$type = addslashes($_GET['type']);
    	$page = intval($_GET['page']) - 1;
    	$offset = $page > 0 ? $page * $this->pagesize : 0;
    
    	$sql = "SELECT id,title,thumb FROM fly_zhubo where status=1 and typename='$type' ORDER BY id DESC limit $offset,$this->pagesize";
    	$query = $this->db->query($sql);
    	$data = $query->result_array();
    	foreach ($data as &$row) {
    		if($row['thumb']) $row['thumb'] = base_url().$row['thumb'];
    	}
    
    	echo json_encode($data);
    }
    
    // 获取 聊天信息 列表
    public function chats_list ()
    {
    	$groupid = intval($_GET['groupid']);
    	$page = intval($_GET['page']) - 1;
    	$offset = $page > 0 ? $page * $this->pagesize : 0;
    	
    	$query = $this->db->query("SELECT COUNT(*) AS num FROM fly_groups_chats where groupid='$groupid' AND (title !='' OR audio !='' OR thumb !='') ");
    	$count_row = $query->row_array();
    	$count = $count_row['num'];
    	
    	$data = array();
		$new_data = array();
    	if ($count > $offset) {
    		$sql = "SELECT id,uid,thumb,audio,audio_time,title,addtime,isbase64 FROM fly_groups_chats where groupid='$groupid' AND (title !='' OR audio !='' OR thumb !='') ORDER BY addtime DESC limit $offset,$this->pagesize";
    		$query = $this->db->query($sql);
    		$data = $query->result_array();
    		$data = array_reverse($data);
					
    		foreach ($data as &$row) {	
				if($row['isbase64'] == 1) $row['title'] = base64_decode($row['title']);			
    			$row['addtime'] = timeFromNow($row['addtime']);
    			if($row['thumb']){
    				$row['thumb'] = base_url().new_thumbname($row['thumb'], 100, 100);
    			}
    			if($row['audio']){
    				$row['audio'] = base_url().$row['audio'];
    			}
    		}
    		$data = $this->member_model->append_list($data);
    	}  	
    	echo json_encode($data);
    }
    
    // 群聊天信息 保存
    function chats_save ()
    {
//     	require_once 'badword.php';//敏感词库
    	
    	$data = array(
    			'uid' => intval($_POST['uid']),
    			'groupid' => intval($_POST['groupid']),
    			'title' => replaceBad(trim($_POST['title'])),
    			'addtime' => time()
    	);
    	if (empty($data['uid'])) {
    		show(1,'uid is null');	    	
    	}
    	
//     	$badword1 = array_combine($badword,array_fill(0,count($badword),'***'));//敏感词过滤
//     	$data['title'] = strtr($data['title'], $badword1);
    	
    	if ($_FILES['thumb']['name']) { // 上传图片 同时生成两张缩略图
    		$data['thumb'] = uploadFile('thumb');
    		if($data['thumb']) thumb2($data['thumb']);
    	}
    	if ($_FILES['audio']['name']) { // 上传语音
    		$data['audio'] = uploadFile('audio', 'audio');
    		$data['audio_time'] = intval($_POST['audio_time']);
    	}
    	
    	$insert_id = $this->groups_model->chats_save($data);
    	if ($insert_id) {
    		$msg = 'ok';
    		if($data['thumb']) $msg = base_url().new_thumbname($data['thumb'], 100, 100);
    		show(0, $msg, $insert_id);  		
    	} else {
    		show(2, '未知错误，添加没有成功');    		
    	}
    }
    
    // 群聊天信息 保存
    function chats_base64_save ()
    {
    	$data = array(
    			'uid' => intval($_POST['uid']),
    			'groupid' => intval($_POST['groupid']),
    			'title' => trim(base64_decode(replaceBad($_POST['title']))),
    			'addtime' => time()
    	);
    	if (empty($data['uid'])) {
    		show(1,'uid is null');
    	}
    	 
    	if ($_FILES['thumb']['name']) { // 上传图片 同时生成两张缩略图
    		$data['thumb'] = uploadFile('thumb');
    		if($data['thumb']) thumb2($data['thumb']);
    	}
    	if ($_FILES['audio']['name']) { // 上传语音
    		$data['audio'] = uploadFile('audio', 'audio');
    		$data['audio_time'] = intval($_POST['audio_time']);
    	}
    	 
    	$insert_id = $this->groups_model->chats_save($data);
    	if ($insert_id) {
    		$msg = 'ok';
    		if($data['thumb']) $msg = base_url().new_thumbname($data['thumb'], 100, 100);
    		show(0, $msg, $insert_id);
    	} else {
    		show(2, '未知错误，添加没有成功');
    	}
    }
    
    // 获取一条群聊的信息
    public function chats_detail()
    {
    	$id = intval($_GET['id']);
    	if(empty($id)) {
    		show(1, 'id is null');
    	}
    	
    	$value = $this->groups_model->chats_detail($id);
    	if($value['thumb']) {
    		$value['thumb'] = base_url().$value['thumb'];
    	}
    	if($value['audio']) {
    		$value['audio'] = base_url().$value['audio'];
    	}
    	 
    	echo json_encode($value);
    }
    
    // 删除一条群聊的信息
    public function chats_delete()
    {
    	$id = intval($_GET['id']);
    	if(empty($id)) {
    		show(1, 'id is null');
    	}
    	 
    	$affected_rows = $this->groups_model->chats_delete($id);
    	if(!isset($affected_rows)) {
    		show("2",'无此id记录');
    	}
    	
    	show('0','删除成功',$_GET['id']);
    }
       
    // 群列表排序
    public function groups_sort()
    {
    	$id = intval($_GET['id']);
    	if(empty($id)) {
    		show(1, 'id is null');
    	}
    
    	$affected_rows = $this->groups_model->chats_delete($id);
    	if(!isset($affected_rows)) {
    		show("2",'无此id记录');
    	}
    	 
    	show('0','删除成功',$_GET['id']);
    }
  
   //申请添加群组
	public function apply_group(){
		$data = array(
    			'uid' => intval($_POST['uid']),    			
    			'title' => replaceBad(trim($_POST['title'])),
				//'keywords' => replaceBad(trim($_POST['keywords'])),
				'description' => replaceBad(trim($_POST['description'])),
				'ad_des' => replaceBad(trim($_POST['description'])),				
    			'addtime' => time(),
				'last_time' => time(),
				'last_title' => '',
				'hot' => 1,
				'type' => 'private'
    	);
    	if (empty($data['uid'])) {
    		show(1,'uid is null');	    	
    	}
		if ($_FILES['thumb']['name']) { // 上传图片 同时生成两张缩略图
    		$data['thumb'] = uploadFile('thumb');
    		if($data['thumb']) $data['ad_pic'] = $data['thumb'];
    	}
		
		$this->db->insert ( 'fly_groups', $data);
    	$insert_id = $this->db->insert_id();
		$data = array('id'=>$insert_id);
    	echo json_encode($data);
	}
	
	 //删除群组
	public function del_group(){
		$uid = $_GET['uid'];
		$id = $_GET['id'];		
		if (empty($uid)) {
    		show(1,'uid is null');	    	
    	}
		if (empty($id)) {
    		show(1,'id is null');	    	
    	}
		$sql = "DELETE FROM fly_groups WHERE uid=$uid AND id=$id";
		$query = $this->db->query ( $sql );
		if($query){
			$data = array('status'=>0);
		}else{
			$data = array('status'=>1);
		}
		
    	echo json_encode($data);
	}
    
} // 类结束

