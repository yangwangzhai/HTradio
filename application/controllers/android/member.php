<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
/*
 * android 会员接口
 */
include 'api.php';
class member extends Api {
	private $table = 'fm_member';
	
	function __construct() {
		parent::__construct ();
	}
	
	
	
	
	// 会员 登录验证
	public function check_login() {
		
		
		$catid = intval ( $this->input->get_post ('catid') );		
		$username = trim ( $this->input->post ( 'username' ) );
		$password = trim ( $this->input->post ( 'password' ) );
		
		if (empty ( $username ) || empty ( $password )) {
			show ( 5, '用户名和密码不能为空' );
		}
		
		// 手机号码
		if(strlen($username)>=11) {
			$wheredata = array (
					//'catid' => $catid,
					'tel' => $username
			);
		} else {  // 账号
			$wheredata = array (
				//	'catid' => $catid,
					'username' => $username
			);
		}
		$query = $this->db->get_where ( 'fm_member', $wheredata, 1 );
		$user = $query->row_array ();
		if (empty ( $user )) {
			show ( '8', '账号不存在' );
		}
		$password = get_password ( $password );
		if ($user ['password'] != $password) {
			show ( '2', '密码错误' );
		}
		if ($user ['status'] == 0) {
			show ( '3', '账号已被锁定，请联系管理员' );
		}
		
		$this->detail ( $user['id'] );
	}
	
	// 检测会员 是否可用，是否更新资料了，0 没有更新，1 更新无需重新登录 2 需要重新登录；	
	public function check_status() {
		$status = 0;
		$uid = intval ( $_GET ['uid'] );
		if($uid) {
			$status = $this->member_model->check_status($uid);
		}
		
		echo json_encode ( array('status'=>$status) );
	}
	
	// 注册
	public function regist() {
		
		
		$postdate = array (
				'username' => trim ( $_POST ['username'] ),
				'password' => trim ( $_POST ['password'] ),
				'email' => trim ( $_POST ['email'] ),
				'nickname' => trim ( $_POST ['nickname'] ),
				'tel' => trim ( $_POST ['tel'] ),
				'IDcard'=>trim ( $_POST ['IDcard'] ),
				'regtime' => time (),
				'status' => 1,
				'lastlogintime' => time () 
		);
		
		if ($postdate ['username'] == "" || $postdate ['password'] == "") {
			show ( 1, '用户名或者密码不能为空' );
		}
		$query = $this->db->query ( "select id from fm_member where username='{$postdate[username]}' limit 1" );
		if ($query->num_rows () > 0) {
			show ( 2, '用户名已经存在，请换一个' );
		}
		$query = $this->db->query ( "select id from fm_member where email='{$postdate[email]}' limit 1" );
		if ($query->num_rows () > 0) {
			show ( 3, '邮箱已经被使用，请换一个' );
		}
		
		$postdate ['password'] = get_password ( $postdate ['password'] );
		$query = $this->db->insert ( 'fm_member', $postdate );
		if ($this->db->insert_id () > 0) {
			$postdate ['id'] = $this->db->insert_id ();
			$postdate ['groupid'] = 1;
			//exit ( json_encode ( $postdate ) );
			show ( 0, $postdate );
			
		}else{
			show ( 4, '未知错误' );
		}
	}
	
	// 修改
	public function update() {
		
		
		
		$uid = intval ( $_POST ['uid'] );
		$postdate = array (
				'email' => trim ( $_POST ['email'] ),
				'nickname' => trim ( $_POST ['nickname'] ),
				'tel' => trim ( $_POST ['tel'] ),
				'sign' => trim ( $_POST ['sign'] ) 
		);
		
		if (empty ( $uid )) {
			show ( 1, 'uid is null' );
		}
		
		$query = $this->db->query ( "select id from fm_member where email='$postdate[email]' limit 1" );
		$row = $query->row_array ();
		if (! empty ( $row )) {
			if ($row ['id'] != $uid) {
				show ( 2, 'email used' );
			}
		}
		
		$query = $this->db->update ( 'fm_member', $postdate, 'id = ' . $uid );
		show ( 0,'ok' );
	}	
	
	
	// 获取一条会员全部信息
	function detail($uid=0) {
	
		
		if($_GET['uid']) {
			$uid = intval($_GET['uid']);
		}
		if(empty($uid)) {
			show ( 6, 'uid is null' );
		}
		
		$row = $this->member_model->get_one($uid);
		if(empty($row)) {
			show ( 7, 'user is null' );
		}
		unset ( $row ['password'] );
		$row ['userid'] = $row ['id']; // ios需要
		if ($row ['avatar']) {
			$row ['avatar'] = base_url () . new_thumbname ( $row ['avatar'], 100, 100 );
		}
		if ($row['catid']==1) {
			$row = $this->student_model->append_one ( $row );
		}
		if ($row['catid']==2) {
			$row ['manage_class_name'] = setClassname ( $row ['manage_class'] );
			$row ['teach_class_name'] = setClassname ( $row ['teach_class'] );
		}
		
		//关注数
		$sql = "SELECT count(*) as num from fm_attention where mid = ".$row ['id'];		
		$query = $this->db->query ( $sql );
		$favor_data = $query->row_array();
		$row['favorite'] = $favor_data['num'];


		//粉丝数
		$sql = "SELECT count(*) as num from fm_attention where zid = ".$row ['id'];		
		$query = $this->db->query ( $sql );
		$favor_data = $query->row_array();
		$row['is_favorite'] = $favor_data['num'];
		
		//私信
		$sql = "SELECT count(*) as num from fm_message where to_uid = ".$row ['id'] . " AND isread=1 ";		
		$query = $this->db->query ( $sql );
		$favor_data = $query->row_array();
		$row['private_letter'] = $favor_data['num'];
		
		echo json_encode ( $row );
	}
	
	// 会员 找回密码
	function find_password() {
		
		
		
		$result = '';
		$email = trim ( $_POST ['email'] );
		
		if (! isemail ( $email )) {
			show ( 1, "邮箱格式错误" );
		}
		
		$query = $this->db->get_where ( 'fm_member', array (
				'email' => $email 
		), 1 );
		$row = $query->row_array ();
		if (empty ( $row )) {
			show ( 2, "没有找到该邮箱" );
		}
		
		// 修改密码
		$this->load->helper ( 'string' );
		$radom = strtolower ( random_string ( 'alpha', 6 ) );
		$new_password = get_password ( $radom );
		$this->db->update ( 'fm_member', array (
				'password' => $new_password 
		), array (
				'email' => $email 
		) );
		
		// 发送新密码到该邮箱
		$this->load->library ( 'email' );
		$config ['protocol'] = 'smtp';
		$config ['smtp_host'] = 'smtp.qq.com';
		$config ['smtp_user'] = '1574147371@qq.com';
		$config ['smtp_pass'] = 'ruantejishu000';
		$config ['smtp_port'] = '25';
		$config ['newline'] = "\r\n";
		$this->email->initialize ( $config );
		$this->email->from ( '1574147371@qq.com', '微路' );
		$this->email->to ( $email );
		$this->email->subject ( '微路客户端 - 找回密码' );
		$this->email->message ( "微路客服提示您：您的新密码已重置为  $radom " );
		$this->email->send ();
		
		show ( 0,'ok' );
		
		// 第一步 发送邮箱验证码到他邮箱
		// 第二步 验证 验证码是否正确
		// 第三步 重新设置新密码
	}
	
	// 更新 此会员登录次数 登录时间
	function update_logincount() {
		$uid = intval ( $this->input->get ( 'uid' ) );
		
		if (! empty ( $uid )) {
			$query = $this->db->query ( 'update fm_member set logincount=logincount+1,lastlogintime=' . time () . ' where id=' . $uid );
		}
	}
	
	// 修改 保存头像
	function thumb_save() {
		$return = "";
		$uid = intval ( $_POST ['uid'] );
		if (empty ( $uid )) {
			show ( 1, "uid is null" );
		}
		
		if ($_FILES ['thumb'] ['name']) {
			$data ['avatar'] = uploadFile ( 'thumb', 'member' );
			if ($data ['avatar']) {
				thumb ( $data ['avatar'], 100, 100 );
				$query = $this->db->update ( 'fm_member', $data, 'id = ' . $uid );
				$return = base_url () . new_thumbname ( $data ['avatar'], 100, 100 );
				show ( 0,$return );
				exit;
			}
		}
		
		show ( 2, "thumb update failed" );
	}
	
	// 获取头像
	function thumb() {
		
		
		
		$uid = intval ( $_GET ['uid'] );
		if (empty ( $uid )) {
			show ( 1, "uid is null" );
		}
		
		$data = $this->member_model->get_one ( $uid );
		
		$ret = array (
				'small' => '',
				'big' => ''
		);
		
		if($data ['thumb']) {
			$ret = array (
					'small' => base_url () . new_thumbname ( $data ['thumb'] ),
					'big' => base_url () . $data ['thumb']
			);
		}
				
		echo json_encode ( $ret );
	}
	
	// 会员昵称 修改 保存
	function nickname_save() {
		
		$return = "";
		$uid = intval ( $_REQUEST ['uid'] );
		$data ['nickname'] = trim ( $_REQUEST ['nickname'] );
		
		if (! empty ( $uid ) && ! empty ( $data ['nickname'] )) {
			$query = $this->db->update ( 'fm_member', $data, 'id = ' . $uid );
		}
		
		show ( 0,'ok' );
	}
	
	// 会员个性签名 修改 保存
	function sign_save() {
		
		
		$return = "";
		$uid = intval ( $_REQUEST ['uid'] );
		$data ['sign'] = trim ( $_POST ['sign'] );
		
		if (! empty ( $uid )) {
			$query = $this->db->update ( 'fm_member', $data, 'id = ' . $uid );
		}
		
		show ( 0,'ok' );
	}
	
	// 电话号码 修改 保存
	function tel_save() {	
		
		
		
		$uid = intval ( $_POST ['uid'] );
		$data ['tel'] = trim ( $_POST ['tel'] );
		if(empty ( $uid ) ) {
			show(1,'用户id为空');
		}
		if(strlen ( $data ['tel'] ) < 11) {
			show(2,'手机号码不能少于11位');
		}
		
		// 检查手机号码 是否存在		
		if($this->member_model->is_tel_exist($data['tel'], $uid)){
			show (3, '手机号码已经存在，请更换' );
		}
		
		// 更新 保存
		$data['status2'] = 1;
		$query = $this->db->update ( 'fm_member', $data, 'id = ' . $uid );		
		
		show (0, 'ok' );
	}
	
	// 会员 密码 修改 保存post字段 uid, old_password, new_password
	function password_save() {
		
		
		$uid = intval ( $this->input->post ('uid') );
		$old_password =  trim ( $this->input->post ('old_password') );
		$new_password =  trim ( $this->input->post ('new_password') );
		
		if (empty ( $uid ) || empty ( $old_password ) || empty ( $new_password )) {
			show ( 1, '用户id, 原密码和新密码不能为空' );
		}	
		if ($old_password == $new_password) {
			show ( 5, '原密码和新密码不能相同' );
		}	
		
		$query = $this->db->get_where ( 'fm_member', 'id = '.$uid, 1 );
		$row = $query->row_array ();
		if (empty ( $row )) {
			show ( 2, '该用户不存在' );
		}
		
		$old_password = get_password($old_password);
		$new_password = get_password($new_password);				
		if( $row['password'] != $old_password) {
			show ( 3, '原密码不正确' );
		}
		
		$this->db->update ( 'fm_member', array (
				'password' => $new_password 
		), 'id = ' . $uid );
		$affected = $this->db->affected_rows ();
		if ($affected == 0) {
			show ( 4, '对不起，出错了，请稍后再试' );
		}
		
		show ( 0,'ok' );
	}
	
	// 查找会员
	function list_search() {
		
		
		$schoolid =  intval($this->input->get('schoolid'));
		$keywords = trim ( $this->input->post ( 'keywords' ) );
		if (empty ( $keywords )) {
			show ( 1, 'keywords is null' );
		}
		$list = $this->member_model->list_search ( $keywords, $schoolid );
		
		echo json_encode ( $list );
	}
	
	// 好友列表
	function friend_list() {
		
		
		
		$uid = intval ( $_GET ['uid'] );
		if (empty ( $uid )) {
			show ( 1, 'uid is null' );
		}
		echo json_encode ( ($this->member_model->friend_list ( $uid )) );
	}
	
	// 添加好友
	function friend_add() {
		
		
		$uid = intval ( $_GET ['uid'] );
		$fid = intval ( $_GET ['fid'] );
		if (empty ( $uid ) || empty ( $fid )) {
			show ( 1, 'uid or fid is null' );
		}
		$this->member_model->friend_add ( $uid, $fid );
		show ( 0,'ok' );
	}
	
	// 删除好友好友
	function friend_delete() {
		
		
		$uid = intval ( $_GET ['uid'] );
		$fid = intval ( $_GET ['fid'] );
		if (empty ( $uid ) || empty ( $fid )) {
			error ( 1, 'uid or fid is null' );
		}
		$this->member_model->friend_delete ( $uid, $fid );
		show (0, 'ok' );
	}
	
	//1为收藏(包括节目单和节目，list_type 为1是节目列表，为2是节目单列表)，2是下载，3是播放过
	function  mydata(){
		$type = intval ( $_GET ['type'] ); 
		$uid = intval ( $_GET ['uid'] );
		$page = intval ( $_GET ['page'] ) - 1;
		$offset = $page > 0 ? $page * $this->pagesize : 0;
		$data = array();
		if (empty ( $uid )) {
			show ( 1, 'uid is null' );
		}
		if (empty ( $type )) {
			show ( 2, 'type is null' );
		}
		
	
		
		$query = $this->db->query ( "select program_id from fm_program_data where type=$type and mid=$uid order by addtime desc limit $offset,$this->pagesize" );
		$list = $query->result_array ();
		foreach ($list as &$row) {
			$query = $this->db->query ( "select id,title,playtimes,thumb,mid,path from fm_program where id=$row[program_id]" );
			$program_row = $query->row_array ();
			if( $program_row ){
				if($program_row['thumb']) $program_row['thumb'] = base_url().$program_row['thumb'];
				if($program_row['path']) $program_row['path'] = base_url().$program_row['path'];
				if($program_row['mid'])  $program_row['owner'] = getNickName($program_row['mid']);
				if($type == 1) $program_row['list_type'] = 1 ;
				$data[] = $program_row;
			}			
		}
		
		//如果type为1 那就加收藏的节目单列表
		if($type == 1){
				$query = $this->db->query ( "select programme_id from fm_programme_data where type=$type and mid=$uid order by addtime desc limit $offset,$this->pagesize" );
				$list_programme = $query->result_array ();
				foreach ($list_programme as &$r) {
					$query = $this->db->query ( "select id,title,playtimes,thumb,mid from fm_programme where id=$r[programme_id]" );
					$programme_row = $query->row_array ();
					if( $programme_row ){
						if($programme_row['thumb']) $programme_row['thumb'] = base_url().$programme_row['thumb'];						
						if($programme_row['mid'])  $programme_row['owner'] = getNickName($programme_row['mid']);
						$programme_row['list_type'] = 2 ;
						$data[] = $programme_row;
					}
				}
		}
		
		
		echo json_encode ($data );
	}
	
		// 添加收藏主播
	public function favorite_add() {
		$mid = $_GET ['mid'];
		$zid = intval ( $_GET ['zid'] );
		
		if (empty ( $mid )) {//判断会员id
			show ( 1, 'mid is null' );
		}
		if (empty ( $zid )) {//判断被收藏者id
			show ( 2, 'zid is null' );
		}
		//判断被收藏者是否为主持人
		$temp = $this->db->query("select type from fm_member where id = $zid");
		$is_zcr = $temp->row_array();
		if(!$is_zcr){
			$is_zcr['type'] = 0;
		}
		$curr_time = time();
		$sql = "insert into fm_attention (mid,zid,addtime,is_zcr) values($mid,$zid,$curr_time,$is_zcr[type])";
		$query = $this->db->query($sql);
		if($query)
		{
			show ( 0, 'ok' );			
		}
		else {
			show ( 3, 'add failure' );
		}
		/*
		$sql = "SELECT favorite from fm_member where id = $mid";
		$query = $this->db->query ( $sql );
		$favor_data = ($query->row_array ());
		$favorites = $favor_data ['favorite'];
		$foo = explode ( ',', $favorites ); // 转为数组
		$flag = 0;
		for($i = 0; $i < count ( $foo ); $i ++) { // 匹配是否存在
			if ($zid == $foo [$i]) {
				$flag = 1;
				break;
			}
		}
		if ($flag == 0) {
			array_push ( $foo, $zid ); // 追加
		}
		$newfoo = implode ( ',', $foo ); // 转为字符串
		$sql = "update fm_member set favorite = '$newfoo' where id = $mid";
		$affectedrow = $this->db->query ( $sql );
		if($affectedrow) {
			show ( 0, 'ok' );			
		}
		else {
			show ( 3, 'add failure' );
		}*/


	}
	
	// 删除收藏主播
	public function favorite_delete() {
		$mid = $_GET ['mid'];
		$zid = intval ( $_GET ['zid'] );
		
		if (empty ( $mid )) {
			show ( 1, 'mid is null' );
		}
		if (empty ( $zid )) {
			show ( 2, 'zid is null' );
		}

		$sql = "DELETE from fm_attention where 'mid' = $mid AND 'zid' = $zid";
		$query = $this->db->delete('fm_attention',array('mid'=>$mid,'zid'=>$zid));
		
		if($this->db->affected_rows()){
			show ( 0, 'ok' );
		} else {
			show ( 3, 'delete failed' );
		}

		
		/*$sql = "SELECT favorite from fm_member where id = $mid";
		$query = $this->db->query ( $sql );
		$favor_data = ($query->row_array ());
		$favorites = $favor_data ['favorite'];
		$foo = explode ( ',', $favorites ); // 转换为收藏数组
		$flag = 0;
		$index = - 1;
		for($i = 0; $i < count ( $foo ); $i ++) { // 匹配是否存在
			if ($zid == $foo [$i]) {
				$flag = 1;
				$index = $i;
				break;
			}
		}
		if ($flag == 1 && $index != - 1) {
			unset ( $foo [$index] );
			$foo = array_values ( $foo ); // 重建索引
			$newfoo = implode ( ',', $foo );
			$sql = "update fm_member set favorite = '$newfoo' where id = $mid";
			$this->db->query ( $sql );
			show ( 0, 'ok' );
		} else {
			show ( 0, 'no row(s) affected' );
		}*/


	}
	
	//我的关注数列表
	function my_attention_list(){
		$mid = $_GET ['mid'];
		$page = intval ( $_GET ['page'] ) - 1;
		if (empty ( $mid )) { // 校验会员id
			show ( 1, 'mid is null' );
		}
		
		$offset = $page > 0 ? $page * $this->pagesize : 0;
		$sql = "SELECT id,zid as member_id,mid from fm_attention where mid = $mid order by addtime desc limit $offset,$this->pagesize";		
		$query = $this->db->query ( $sql );
		$list = $query->result_array();
		foreach ($list as &$r) {
			    $row = getMember($r['member_id']);
				if($row['avatar']) $r['avatar'] = base_url().$row['avatar'];
				$r['nickname'] = $row['nickname'];
				
				
	   }
	   
	   echo json_encode ( array('list' => $list) );
	}
	
	
	//我的粉丝数列表
	function my_fan_list(){
		$mid = $_GET ['mid'];
		$page = intval ( $_GET ['page'] ) - 1;
		if (empty ( $mid )) { // 校验会员id
			show ( 1, 'mid is null' );
		}
		
		$offset = $page > 0 ? $page * $this->pagesize : 0;
		$sql = "SELECT id,mid as member_id,zid from fm_attention where zid = $mid order by addtime desc limit $offset,$this->pagesize";		
		$query = $this->db->query ( $sql );
		$list = $query->result_array();
		foreach ($list as &$r) {
			    $row = getMember($r['member_id']);
				if($row['avatar']) $r['avatar'] = base_url().$row['avatar'];
				$r['nickname'] = $row['nickname'];
				
	   }
	   
	   echo json_encode ( array('list' => $list) );
	}
	
	
	//个人主页
	function homepage(){
		$mid = $_GET ['mid'];
		$zid = intval ( $_GET ['zid'] );
		
		if (empty ( $mid )) { // 校验会员id
			show ( 1, 'mid is null' );
		}
		if (empty ( $zid )) { // 校验主播id
			show ( 2, 'zid is null' );
		}
		//判断是否被收藏
		$sql = "SELECT count(*) as num from fm_attention where mid = $mid AND zid = $zid";
		$flag = 0;
		$query = $this->db->query ( $sql );
		$favor_data = ($query->row_array());
		if($favor_data['num']){
			$flag = 1;
		}

		$query2 = $this->db->query("select mid from fm_attention where mid= $mid");
		$foo_num = $query->num_rows();
		/*$favorites = $favor_data ['favorite'];
		$foo = explode ( ',', $favorites ); // 转换为收藏数组
		$foo_num = count($foo);  //关注数
		$flag = 0;
		for($i = 0; $i < $foo_num; $i ++) { // 匹配是否存在
			if ($zid == $foo [$i]) {
				$flag = 1;
				break;
			}
		}*/
		
		$sql = "SELECT avatar,username,nickname,level,backgroundpic from fm_member where id = $zid"; // 获取主播信息
		$query = $this->db->query ( $sql );
		$data = $query->row_array ();
		$data ['avatar'] = $data ['avatar'] ? base_url () . $data ['avatar'] : '';
		$data ['backgroundpic'] = $data ['backgroundpic'] ? base_url () . $data ['backgroundpic'] : '';
		
		$query1 = $this->db->query("SELECT mid FROM fm_attention WHERE zid = $zid");
		$num = $query1->num_rows();
        $fans_num =  $num; //粉丝数

		//被收藏的节目单数
		$query = $this->db->query("SELECT id FROM fm_member WHERE FIND_IN_SET( {$zid}, favorite_playbill)");
		$data['foo_playbill_num'] = $query->num_rows();
       
		
		$sql = "SELECT id,title,program_ids,playtimes,thumb from fm_programme where mid = $zid"; // 获取节目单信息
		$query = $this->db->query ( $sql );
		$playbill_num = $query->num_rows();
		$data['programme'] = $query->result_array ();
		foreach($data['programme'] as &$v){
			 $v['program_num'] = count( explode ( ',', $v['program_ids'] ) );
			 $v['thumb'] = $v['thumb'] ? base_url () . $v['thumb'] : '';
		}
		
		
		
		$data['is_favorite'] = $flag; // 添加是否被收藏信息
		$data['favorite_num'] = $foo_num;
		$data['fans_num'] = $fans_num;
		$data['playbill_num'] = $playbill_num;
		echo json_encode ( $data );
	}
	
	
} // 类结束
