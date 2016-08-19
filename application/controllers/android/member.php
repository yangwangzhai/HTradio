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
    /**
     *  接口说明：差评
     *  接口地址：http://vroad.bbrtv.com/cmradio/index.php?d=android&c=member&m=check_login
     *  参数接收方式：post
     *	接收参数：
     * 	id：频道id
     * 	channel_type：频道类型，1:直播频道 ，2:录播频道，3:我的频道
     *  mid；用户ID
     * 	返回参数：
     * 	code：返回码 0正确, 大于0 都是错误的
     * 	message：描述信息
     * 	time：时间戳
     *  "data":{"id":1,"channel_type":1,"negative_num":5}
     *  其中：
     *  "id":频道id
     *  "channel_type":频道类型，1:直播频道 ，2:录播频道，3:我的频道
     *  "negative_num":当前差评数
     *
     */
	public function check_login() {
		//$catid = intval ( $this->input->get_post ('catid') );
		$username = trim ( $this->input->post ( 'username' ) );
		$password = trim ( $this->input->post ( 'password' ) );
		if (empty ( $username ) || empty ( $password )) {
			show ( 5, '用户名和密码不能为空' );
		}
		// 手机号码
		if(strlen($username)>=11) {
			$wheredata = array (
					//'catid' => $catid,
					'username' => $username
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

    /**
     *  接口说明：验证微信是否已经关联注册。
     *  接口地址：http://vroad.bbrtv.com/cmradio/index.php?d=android&c=member&m=check_wechat_login
     *  参数接收方式：post
     *	接收参数：
     * 	wechat_id：微信id
     * 	返回参数：
     * 	code：返回码 0 表示已注册, 1 表示未注册
     * 	message：描述信息
     * 	time：时间戳
     *  "data": {
                    "id": "607",
                    "wechat_id": "101100",
                    "catid": "0",
                    "username": "杨旺摘",
                    "password": "f84e2ee55211659f6e26cee30f86992c",
                    "nickname": "杨旺摘",
                    "truename": "",
                    "gender": "1",
                    "email": "312778836@qq.com",
                    "tel": "15994397920",
                    "address": "",
                    "sign": "",
                    "regtime": "1459924276",
                    "lastlogintime": "1459924276",
                    "logincount": "0",
                    "status": "1",
                    "avatar": "uploads/file/20151013/20151013164309_78919.jpg",
                    "content": "",
                    "groupname": "",
                    "type": "0",
                    "backgroundpic": "",
                    "favorite": "",
                    "favorite_audio": "",
                    "favorite_playbill": "",
                    "sort": "100",
                    "program": "",
                    "program_type": "",
                    "attentionpays": "0",
                    "IDcard": "450924199003234772",
                    "level": "0",
                    "qqopenid": null,
                    "sina_id": null
                    }
     *  其中：
        "id":用户id，
        "wechat_id":用户微信id，
        "catid": 用户组id,
        "username":用户名称，
        "password": 用户密码,
        "nickname": 昵称,
        "truename": 真实姓名,
        "gender": 性别 1代表男性，0代表女性,2代表保密,
        "email": 邮箱,
        "tel": 电话,
        "address": 地址,
        "sign": 个性签名,
        "regtime": 注册时间,
        "lastlogintime": 最后登录时间,
        "logincount": 登录次数,
        "status": 状态,
        "avatar": 头像,
        "content": 备注,
        "groupname": 群名称,
        "type": 会员类型 0游客 1主播,
        "backgroundpic": 主播背景图片,
        "favorite": 收藏,
        "favorite_audio": 收藏节目,
        "favorite_playbill": 收藏的节目单,
        "sort": "100",
        "program": 主持的节目,
        "program_type": 节目的类型,
        "attentionpays": 关注数,
        "IDcard": 身份证号,
        "level": 等级,
        "qqopenid": ,
        "sina_id": ，
     */
	public function check_wechat_login(){
        //接收微信、微博id
        $wechat_id = trim ( $this->input->post ( 'wechat_id' ) );
        //根据id从数据库查询是否已经存在，存在则说明已经授权微信、微博登陆。
        $sql="select COUNT(*) as num from  fm_member WHERE wechat_id='$wechat_id'";
        $query=$this->db->query($sql);
        $num=$query->row_array();
        if($num['num']){
            //不为空，说明已经授权，注册过，取出该条用户信息
            $sql_member="select * from fm_member WHERE wechat_id='$wechat_id'";
            $query_member=$this->db->query($sql_member);
            $member=$query_member->row_array();
            unset($member['password']);
            $result=array("code"=>0,"message"=>"已注册","time"=>time(),"data"=>$member);
            echo json_encode($result);
        }else{
            $result=array("code"=>1,"message"=>"未注册","time"=>time(),"data"=>array('id'=>'','wechat_id'=>$wechat_id,'username'=>''));
            echo json_encode($result);
        }

    }

    /**
     *  接口说明：使用微信关联注册。
     *  接口地址：http://vroad.bbrtv.com/cmradio/index.php?d=android&c=member&m=wechat_regist
     *  参数接收方式：post
     *	接收参数：
     * 	wechat_id：微信id
     *  username: 用户名
     *  password: 用户密码
     *  avatar： 用户头像
     *
     * 	成功时返回的数据：
     *  {
            "code": 0,
            "message": "注册成功",
            "time": 1467360686,
            "data": {
                    "id": 620,
                    "wechat_id": "rersdfgasdf32423",
                    "username": "9999999",
                    "avatar": "http://vroad.bbrtv.com/cmradio/uploads/member/20160615/20160615163803_61899.jpg"
                }
        }
     * 	code：返回码 0 表示注册成功
     * 	message：描述信息
     * 	time：时间戳
     *  "id":用户id
     *  "wechat_id":用户微信id
     *  "username":用户名称
     *  "avatar"： 用户头像
     *
     *  注册失败返回的数据：
     *  {
            "error_code": 1,
            "error_msg": "用户名已被注册，请更换",
            "time": 1467360850
        }
     *  error_code：错误码：1代表用户名已经被注册，2代表注册失败，原因未知
     *  error_msg：错误描述
     *  time：时间戳
     *
     */
    public function wechat_regist(){
        $postdate = array (
            'wechat_id' => trim ( $_POST ['wechat_id'] ),
            'username' => trim ( $_POST ['username'] ),
            'password' => trim ( $_POST ['password'] ),
            'avatar' => trim ( $_POST ['avatar'] ),
            'regtime' => time (),
            'status' => 1,
            'lastlogintime' => time ()
        );
        $sql="select COUNT(*) as num from  fm_member WHERE username='$postdate[username]'";
        $query=$this->db->query($sql);
        $num=$query->row_array();
        if($num['num']){
            $result = array("error_code"=>1,"error_msg"=>"用户名已被注册，请更换","time"=>time());
            echo json_encode($result);
        }else{
            $postdate ['password'] = get_password ( $postdate ['password'] );
            $query = $this->db->insert ( 'fm_member', $postdate );
            if ($this->db->insert_id () > 0) {
                $postdate ['id'] = $this->db->insert_id ();
                $result=array("code"=>0,"message"=>"注册成功","time"=>time(),"data"=>array('id'=>$postdate ['id'],'wechat_id'=>$postdate['wechat_id'],'username'=>$postdate['username'],'avatar'=>$postdate['avatar']));
                echo json_encode($result);
            }else{
                $result = array("error_code"=>2,"error_msg"=>"注册失败，未知错误","time"=>time());
                echo json_encode($result);
                /*$result=array("code"=>1,"message"=>"注册失败","time"=>time(),"data"=>array('id'=>'','wechat_id'=>$postdate['wechat_id'],'username'=>''));
                echo json_encode($result);*/
            }
        }
    }

    //小平测试接口

    /**
     *http://vroad.bbrtv.com/cmradio/index.php?d=android&c=member&m=delete_wechat
     * 注册失败返回的数据：
     *  {
            "code": 0,
            "msg": "用户名已被注册，请更换",
            "time": 1467360850
            }
     *  code：错误码：0代表删除成功，1代表删除失败
     *  msg：错误描述
     *  time：时间戳
     *
     */
    public function delete_wechat(){
        $wechat_id="oeU0WwT2qYokPx1-TMmgU3v_Q_pQ";
        $sql="delete  from fm_member WHERE wechat_id='$wechat_id'";
        $this->db->query($sql);
        $sql2="select COUNT(*) as num from  fm_member WHERE wechat_id='$wechat_id'";
        $query=$this->db->query($sql2);
        $num=$query->row_array();
        if($num['num']){
            $result=array("code"=>1,"msg"=>"删除失败","time"=>time());
            echo json_encode($result);
        }else{
            $result=array("code"=>0,"msg"=>"删除成功","time"=>time());
            echo json_encode($result);
        }
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
			//判断图片路径是否为http或者https开头
            $preg="/(http:\/\/)|(https:\/\/)(.*)/iUs";
            if(preg_match($preg,$row['avatar'])){
                //不需要操作
            }else{
                $row ['avatar'] = base_url(). new_thumbname ( $row ['avatar'], 100, 100 );
            }

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
				if($program_row['mid']){
                    $owner = getMember($program_row['mid']);
                    $program_row['owner'] = $owner['nickname']?$owner['nickname']:$owner['username']?$owner['username']:'佚名';
                }
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
						if($programme_row['mid']){
                            $owner = getMember($programme_row['mid']);
                            $programme_row['owner'] =$owner['nickname']?$owner['nickname']:$owner['username']?$owner['username']:'佚名';
                        }else{
                            $programme_row['owner']='佚名';
                        }
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
