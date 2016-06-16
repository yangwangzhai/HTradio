<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
/*
 * android客户端调用接口文件 通用文件接口 code by tangjian 20130726
 */
class Api extends CI_Controller
{    
    public $pagesize = 20; // 分页每页条数····
    public $error = array( // 返回的错误码
            'error_code' => 0,
            'error_msg' => 'this is error message'
            );
            
    function __construct ()
    {
        parent::__construct();
    }
    
    // andorid客户端版本
    function version ()
    {
        $netVersion = '2.0.0';
		$message = "本次更新内容有：    \n1、优化UI细节  \n2、修正新闻更新提醒，添加myraio界面更新提醒 \n3、程序细节优化！赶快来更新吧！";
		
		
		$mobileVersion = $_POST ['version'];		
		if ($mobileVersion && $mobileVersion != $netVersion) {
			$version = array (
					'version' => $netVersion,
					'message' => $message,
					);
			echo json_encode ( $version );
		} else {
			echo $netVersion;
		}
    }
    
    // andorid客户端版本
    function getAPK ()
    {
        header('Location: vroad.apk');
        exit();
    }
    
    // 活动列表
    function action_list ()
    {
        $data = $member = array();
        $page = intval($_GET['page']) - 1;
        $offset = $page > 0 ? $page * $this->pagesize : 0;
        
        $query = $this->db->query("SELECT COUNT(*) AS num FROM fm_action");
        $count_row = $query->row_array();
        $count = $count_row['num'];
        // 文字路况列表
        if ($count > $offset) {
            $sql = "SELECT id,title,overview,thumb FROM fly_action ORDER BY id DESC limit $offset,$this->pagesize";
            $query = $this->db->query($sql);
            $data = $query->result_array();
        }
        
        echo json_encode($data);
    }
    
    // 活动 详细页
    function action_detail ()
    {
        $data = array();
        $id = intval($_GET['id']);
        
        if (! empty($id)) {
            $sql = "SELECT * FROM fly_action WHERE id='$id' limit 1";
            $query = $this->db->query($sql);
            $data = $query->row_array();
        }
        
        echo json_encode($data);
    }
    
    // 我要曝光 列表 先获取路况表，如果是会员 则从会员获取数据，组合起来
    function expose_list ()
    {
        $data = $member = array();
        $page = intval($_GET['page']) - 1;
        $offset = $page > 0 ? $page * $this->pagesize : 0;
        
        $query = $this->db->query(
                "SELECT COUNT(*) AS num FROM fly_traffictext WHERE status=1");
        $count_row = $query->row_array();
        $count = $count_row['num'];
        // 文字路况列表
        if ($count > $offset) {
            $sql = "SELECT id,uid,guest,title,thumb,addtime FROM fly_traffictext WHERE status=1 ORDER BY id DESC limit $offset,$this->pagesize";
            $query = $this->db->query($sql);
            while ($row = $query->_fetch_assoc()) {
                $row['addtime'] = timeFromNow($row['addtime']);
                $data[] = $row;
            }
        }
        
        echo json_encode($data);
    }
    
    // 我要曝光 提交保存
    function expose_save ()
    {
        $data = array(
                'uid' => intval($_POST['uid']),
                'title' => replaceBad( trim($_POST['title']) ),
                'longlat' => trim($_POST['longlat']),
                'addtime' => time()
        );
        if ($_FILES['thumb']['name']) {
            $data['thumb'] = uploadFile('thumb');
        }
        if (empty($data['title'])) {
            $this->error['error_code'] = 1;
            $this->error['error_msg'] = '标题不能为空！';
            echo json_encode($this->error);
            exit();
        }
        
        $query = $this->db->insert('fly_traffictext', $data);
        if ($this->db->insert_id()) {
            echo intval($this->db->insert_id());
        } else {
            $this->error['error_code'] = 99;
            $this->error['error_msg'] = '未知错误，添加没有成功';
            echo json_encode($this->error);
            exit();
        }
    }
    
    // 语音读报 列表输出
    function news_list ()
    {
    	$result = array();
    
    	$page = intval($_GET['page']) - 1;
    	$offset = $page > 0 ? $page * $this->pagesize : 0;
    	
    	$query = $this->db->query("SELECT COUNT(*) AS num FROM fly_news");
    	$count_row = $query->row_array();
    	$count = $count_row['num'];    	
    	
    	if ($count > $offset) {    	
	        $query = $this->db->query(
	                "select id,title,thumb,addtime from fly_news order by id desc limit $offset,$this->pagesize");
	        $list = $query->result_array();
	        
    	// 每四条合成一组新闻
		$i = 1;
		$group = array ();
		foreach ( $list as $key => $value ) {
			$group['time'] = timeFromNow( $value['addtime'] );
			$group ['id' . $i] = $value ['id'];
			$group ['title' . $i] = $value ['title'];
			$group ['thumb' . $i] = $value ['thumb'];
			
			if (count($list) == $key+1) {
				$result [] = $group;
				
				break;
			}
			if ($i==4) {
				$result [] = $group;
				$i = 1;
				$group = array ();				
			} else{				
				$i ++;				
			}
		}		
    	}
       	
        echo json_encode($result);        
    }
    
    // 新闻 详细页
    function news_detail ()
    {
    	$data = array();
    	$id = intval($_GET['id']);
    	
    	if (! empty($id)) {
    		$sql = "SELECT * FROM fly_news WHERE id='$id' limit 1";
    		$query = $this->db->query($sql);
    		$data = $query->row_array();
    	}
    	$data['content'] = str_cut($data['content'], 600);
    	$data['content'] = strip_tags($data['content']);
    	echo json_encode($data);
    	
    	// 统计加1
    	$this->load->model('stat_model');
    	$this->stat_model->day_save('news');
    }
	
	// 详细页底部 图片
    function news_detail_bottompic ()
    {
    	$this->load->driver('cache',array('adapter'=>'file'));
    	$set = $this->cache->get('news_setting');
    	echo $set['bottom_pic'];
    }
	
	// 新闻 推荐的 首页的
	function news_top() {	
		$titles = '';
		$query = $this->db->query("SELECT title FROM fly_news order by id desc limit 5");
		$list = $query->result_array();
		foreach($list as $key=>$row) {
			$titles .= ($key+1) .'.'. $row['title'].'; '; 
		}
		
		echo $titles;
	}
    
    
    // 获取 聊天信息 列表
    public function talk_list ()
    {
        $table = 'fly_talk_' . addslashes($_GET['type']);
        $page = intval($_GET['page']) - 1;
        $offset = $page > 0 ? $page * $this->pagesize : 0;
        
        $query = $this->db->query("SELECT COUNT(*) AS num FROM $table");
        $count_row = $query->row_array();
        $count = $count_row['num'];
        
        $data = array();
        if ($count > $offset) {
            $sql = "SELECT id,uid,thumb,audio,audio_time,message,addtime FROM $table ORDER BY id DESC limit $offset,$this->pagesize";
            $query = $this->db->query($sql);
            $data = $query->result_array();
            $data = array_reverse($data);
            foreach ($data as &$row) {
                $row['addtime'] = timeFromNow($row['addtime']);
                $row['thumb'] = new_thumbname($row['thumb'], 100, 100);
            }
            $data = addMember($data);
        }
        
        echo json_encode($data);
    }
    
    // 聊天信息 保存
    function talk_save ()
    {
        $table = 'fly_talk_' . addslashes($_GET['type']);
        
        $data = array(
                'uid' => intval($_POST['uid']),
                'message' => replaceBad( trim($_POST['message']) ),
                'addtime' => time()
        );
        // if (empty($data['message'])) {
        // $this->error['error_code'] = 1;
        // $this->error['error_msg'] = '标题不能为空！';
        // echo json_encode($this->error);
        // exit();
        // }
        
        if ($_FILES['thumb']['name']) { // 上传图片 同时生成两张缩略图
            $data['thumb'] = uploadFile('thumb');
            thumb2($data['thumb']);
        }
        if ($_FILES['audio']['name']) { // 上传语音
            $data['audio'] = uploadFile('audio', 'audio');
            $data['audio_time'] = intval($_POST['audio_time']);
        }
        
        $query = $this->db->insert($table, $data);
        if ($this->db->insert_id()) {
            echo intval($this->db->insert_id());
        } else {
            $this->error['error_code'] = 99;
            $this->error['error_msg'] = '未知错误，添加没有成功';
            echo json_encode($this->error);
            exit();
        }
    }
    
    // 留言 列表
    public function guestbook_list ()
    {
        $data = $member = array();
        $page = intval($_GET['page']) - 1;
        $radio = trim($_GET['radio']);
        $radios = array(
                'name_910' => 1,
                'name_930' => 2,
                'name_950' => 3,
                'name_970' => 4,
                'name_1003' => 5,
                'name_bbr' => 6
        );
        $radio = intval($radios[$radio]);
        if (empty($radio)) {
            $this->error['error_code'] = 2;
            $this->error['error_msg'] = '电台radio 不能为空';
            echo json_encode($this->error);
            exit();
        }
        $offset = $page > 0 ? $page * $this->pagesize : 0;
        
        $query = $this->db->query(
                "SELECT COUNT(*) AS num FROM fly_guestbook WHERE status=1 AND radio=$radio");
        $count_row = $query->row_array();
        $count = $count_row['num'];
        
        if ($count > $offset) {
            $sql = "SELECT id,uid,content,audio,addtime FROM fly_guestbook WHERE status=1 AND radio=$radio ORDER BY id DESC limit $offset,$this->pagesize";
            $query = $this->db->query($sql);
            $data = $query->result_array();
            $data = array_reverse($data);
            foreach ($data as &$row) {
                $row['addtime'] = timeFromNow($row['addtime']);
            }
            $data = addMember($data);
        }
        
        // print_r($data);
        echo json_encode($data);
    }
    
    // 留言 保存
    function guestbook_save ()
    {
        $radios = array(
                'name_910' => 1,
                'name_930' => 2,
                'name_950' => 3,
                'name_970' => 4,
                'name_1003' => 5,
                'name_bbr' => 6
        );
        $data = array(
                'uid' => intval($_POST['uid']),
                'radio' => intval($radios[$_POST['radio']]),
                'content' => replaceBad( trim($_POST['content']) ),
                'audio_time' => intval($_POST['audio_time']),
                'addtime' => time(),
                'status' => 1
        );
        if ($_FILES['audio']['name']) { // 上传语音
            $data['audio'] = uploadFile('audio', 'audio');
        }
        
        $this->db->insert('fly_guestbook', $data);
        echo 'ok'; // 返回的ID
    }
    
    // 会员 登录验证
    public function check_login ()
    {
        $username = trim($_POST['username']);
        $password = get_password($_POST['password']);
        
        $query = $this->db->get_where('fly_member', 
                array(
                        'username' => $username,
                        'password' => $password
                ), 1);
        $user = $query->row_array();
        
        if ($user) {
            exit(json_encode($user));
        } else {
        	error('-1', '用户名或密码错误');
        }
    }
    
    
    // 获取一条 推送通知 主页头部这里显示的
    function notice_one ()
    {
        $data = array();
        $sql = "SELECT id,title,addtime FROM fly_notice ORDER BY id DESC LIMIT 1";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        
        // echo json_encode($data);
        echo date('H:m ', $data['addtime']) . $data['title'];
    }
    
    // 获取电台 列表信息
    function radio_list ()
    {
        $data = array();
        
        $query = $this->db->query(
                "SELECT id,title,mms,thumb FROM fly_radio WHERE status=1 ORDER BY sort LIMIT 100");
        $data = $query->result_array();
        
        echo json_encode($data);
    }
    
    // 获取一条当日指定电台的 节目表
    function schedule ()
    {
        $data = array();
        $radio = trim($_GET['radio']);
        $week = date('w');
        $time = date('H:i');
        if ($week == 0)
            $week = 7;
        
        $sql = "SELECT content FROM fly_schedule WHERE radio='$radio' AND title='$week' LIMIT 1";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        
        preg_match_all('|.*?\\n|', $data[content], $matches);
        $list = array();
        $row = array();
        
        foreach ($matches[0] as $key => $r) {
            $time1 = substr(trim($r), 0, 5);
            // $time2 = substr(trim($matches[0][$key+1]),0,5);
            $row['time'] = $time1;
            $row['content'] = $r;
            $list[] = $row;
        }
        // print_r($list); exit;
        
        echo json_encode($list);
    }
    
    // 获取 日期 星期
    function weekday ()
    {
        $week = array(
                '星期日',
                '星期一',
                '星期二',
                '星期三',
                '星期四',
                '星期五',
                '星期六'
        );
        $weekday = $week[date('w')];
        echo date(' n月j日 ') . ' ' . $weekday;
    }
    
    // 评论列表 根据 用户ID
    function comment_list_uid ()
    {
        $data = $member = array();
        $page = intval($_GET['page']) - 1;
        $uid = intval($_GET['uid']);
        if ($uid) {
            exit("");
        }
        
        $offset = $page > 0 ? $page * $this->pagesize : 0;
        
        $query = $this->db->query(
                "SELECT COUNT(*) AS num FROM fly_comment WHERE uid='$uid'");
        $count_row = $query->row_array();
        $count = $count_row['num'];
        
        if ($count > $offset) {
            $sql = "SELECT id,uid,content,audio,addtime FROM fly_comment WHERE uid='$uid' ORDER BY id DESC limit $offset,$this->pagesize";
            $query = $this->db->query($sql);
            while ($row = $query->_fetch_assoc()) {
                $row['addtime'] = timeFromNow($row['addtime']);
                $data[] = $row;
            }
        }
        
        // print_r($data);
        echo json_encode($data);
    }
    
    
    
    // 评论列表 根据 路况 ID
    function comment_list_tid ()
    {
        $data = $member = array();
        $page = intval($_GET['page']) - 1;
        $tid = intval($_GET['tid']);
        if (empty($tid)) {
            echo "";
            exit();
        }
        
        $offset = $page > 0 ? $page * 10 : 0;
        
        $query = $this->db->query(
                "SELECT COUNT(*) AS num FROM fly_comment WHERE traffic_id='$tid'");
        $count_row = $query->row_array();
        $count = $count_row['num'];
        
        if ($count > $offset) {
            $sql = "SELECT id,uid,content,audio,audio_time,addtime FROM fly_comment WHERE traffic_id='$tid' ORDER BY id DESC limit $offset,10";
            $query = $this->db->query($sql);
            while ($row = $query->_fetch_assoc()) {
                $row['addtime'] = timeFromNow($row['addtime']);
                $data[] = $row;
            }
            $data = addMember($data);
        }
        
        // print_r($data);
        echo json_encode($data);
    }
    
    // 评论保存
    function comment_save ()
    {
        $data = array(
                'uid' => intval($_POST['uid']),
                'traffic_id' => intval($_POST['traffic_id']),
                'content' => replaceBad( trim($_POST['content']) ),
                'audio_time' => intval($_POST['audio_time']),
                'addtime' => time()
        );
        if ($_FILES['audio']['name']) { // 上传语音
            $data['audio'] = uploadFile('audio', 'audio');
        }
        if (empty($data['traffic_id'])) {
            exit("traffic_id is null");
        }
        
        // if (empty($data['content'])) {
        // $this->error['error_code'] = 1;
        // $this->error['error_msg'] = '评论不能为空！';
        // echo json_encode($this->error);
        // exit();
        // }
        
        $query = $this->db->insert('fly_comment', $data);
        $newID = $this->db->insert_id();
        if ($newID) {
			 // 评论数加1
        $this->db->query(
                "update fly_traffictext set comments=comments+1 where id=$data[traffic_id]");
            echo json_encode(array('id'=>$newID));
        } else {
            $this->error['error_code'] = 99;
            $this->error['error_msg'] = '未知错误，添加没有成功';
            echo json_encode($this->error);
            exit();
        }
    }
    
	
	
	 // 官方路况评论保存
    function official_comment_save ()
    {
        $data = array(
                'uid' => intval($_POST['uid']),               
                'content' => replaceBad( trim($_POST['content']) ),
                'audio_time' => intval($_POST['audio_time']),
                'addtime' => time()
        );
        if ($_FILES['audio']['name']) { // 上传语音
            $data['audio'] = uploadFile('audio', 'audio');
        }
              
        
        $query = $this->db->insert('fly_official_comment', $data);
        $newID = $this->db->insert_id();
        if ($newID) {			 
            echo json_encode(array('id'=>$newID));
        } else {
            $this->error['error_code'] = 99;
            $this->error['error_msg'] = '未知错误，添加没有成功';
            echo json_encode($this->error);
            exit();
        }
    }
	 // 官方路况评论保存
    function official_comment_del ()
    {	
		 $id = $_GET['comment_id']; 
		 $sql = "DELETE FROM fly_official_comment WHERE id=$id";
         $query = $this->db->query($sql);
		 if ($query) {			 
            echo json_encode(array('id'=>$id));
        } else {
            $this->error['error_code'] = 99;
            $this->error['error_msg'] = '未知错误，添加没有成功';
            echo json_encode($this->error);
            exit();
        }
	}
	// 官方评论列表
    function comment_list ()
    {
        $data = $member = array();
        $page = intval($_GET['page']) - 1;  
        $offset = $page > 0 ? $page * 10 : 0;
        $query = $this->db->query(
                "SELECT COUNT(*) AS num FROM fly_official_comment");
        $count_row = $query->row_array();
        $count = $count_row['num'];
        
        if ($count > $offset) {
            $sql = "SELECT id,uid,content,audio,audio_time,addtime FROM fly_official_comment  ORDER BY id DESC limit $offset,10";
            $query = $this->db->query($sql);
            while ($row = $query->_fetch_assoc()) {
                $row['addtime'] = timeFromNow($row['addtime']);
                $data[] = $row;
            }
            $data = addMember($data);
        }
        
        echo json_encode($data);
    }
	
    // 下载APK
    function download_apk ()
    {
        redirect(base_url() . "vroad.apk");
        exit();
    }
    
    // 修改 保存头像
    function member_avatar_save ()
    {
        $return = "";
        $uid = intval($_GET['uid']);
        
        if (! empty($uid) && $_FILES['avatar']['name']) {
            $data['avatar'] = uploadFile('avatar', 'avatar');
            thumb($data['avatar'], 100, 100);
            $query = $this->db->update('fly_member', $data, 'id = ' . $uid);            
            $return = new_thumbname($data['avatar'], 100, 100);
        }
        
        echo $return;
    }
    
    // 会员昵称 修改 保存
    function member_nickname_save ()
    {
        $return = "";
        $uid = intval($_REQUEST['uid']);
        $data['nickname'] = trim($_REQUEST['nickname']);
        
        if (! empty($uid) && ! empty($data['nickname'])) {
            $query = $this->db->update('fly_member', $data, 'id = ' . $uid);
            $return = 'ok';
        }
        
        echo $return;
    }
    
    // 会员个性签名 修改 保存
    function member_sign_save ()
    {
        $return = "";
        $uid = intval($_REQUEST['uid']);
        $data['sign'] = trim($_POST['sign']);
        
        if (! empty($uid)) {
            $query = $this->db->update('fly_member', $data, 'id = ' . $uid);
            $return = 'ok';
        }
        
        echo $return;
    }
    
    // 会员 密码 修改 保存post字段 uid, old_password, new_password
    function member_password_save ()
    {
        $result = '';
        
        $uid = intval($_REQUEST['uid']);
        $old_password = get_password(trim($_REQUEST['old_password']));
        $new_password = get_password(trim($_REQUEST['new_password']));
        
        if (empty($uid) || empty($_REQUEST['old_password']) ||
                 empty($_REQUEST['new_password'])) {
            $result = error(0, ' uid, old_password, new_password null');
            echo $result;
            exit();
        }
        
        $data['id'] = $uid;
        $data['password'] = $old_password;
        $query = $this->db->get_where('fly_member', $data, 1);
        $row = $query->row_array();
        if (empty($row)) {
            $result = error(1, '旧密码错误');
        } else {
            $this->db->update('fly_member', array(
                    'password' => $new_password
            ), 'id = ' . $uid);
            $affected = $this->db->affected_rows();
            if ($affected > 0)
                $result = 'ok';
            else
                $result = error(2, '修改密码失败，系统错误');
        }
        
        echo $result;
    }
    
    // 获取一条会员全部信息
    function member_one ()
    {
        $uid = intval($_GET['uid']);
        
        if (! empty($uid)) {
            $query = $this->db->get_where('fly_member', 'id = ' . $uid, 1);
            $row = $query->row_array();
            $row['avatar'] = new_thumbname($row['avatar'], 100, 100);
            unset($row['password']);
            echo json_encode($row);
        }
    }
    
   
    
    // 获取南宁市天气 返回字符串
    function weather ()
    {
        $subject = file_get_contents(
                'http://m.weather.com.cn/data/101300101.html');
        // $subject = mb_convert_encoding($subject, "UTF-8", "gb2312");
        
        $object = json_decode($subject);
        $object = $object->weatherinfo;
        $result = array(
                'today' => $object->weather1 . "\n" . $object->temp1,
                'weather1' => '今天 ' . $object->weather1 . ' ' . $object->temp1,
                'weather2' => '明天 ' . $object->weather2 . ' ' . $object->temp2,
                'weather3' => '后天 ' . $object->weather3 . ' ' . $object->temp3
                );
        // print_r($result);
        echo json_encode($result);
    }
    
    // 私信 列表 根据UID
    public function message_list ()
    {
        $data = $member = array();
        $page = intval($_GET['page']) - 1;
        $uid = intval($_GET['uid']);
        
        $offset = $page > 0 ? $page * $this->pagesize : 0;
        
        $query = $this->db->query(
                "SELECT COUNT(*) AS num FROM fly_message WHERE status=1 AND to_uid=$uid");
        $count_row = $query->row_array();
        $count = $count_row['num'];
        
        if ($count > $offset) {
            $sql = "SELECT id,from_uid,to_uid,title,audio,audio_time,addtime FROM fly_message WHERE status=1 AND to_uid=$uid ORDER BY id DESC limit $offset,$this->pagesize";
            $query = $this->db->query($sql);
            $data = $query->result_array();
            $data = array_reverse($data);
            foreach ($data as &$row) {
                $row['addtime'] = timeFromNow($row['addtime']);
            }
            $data = addMember2($data);
        }
        
        // print_r($data);
        echo json_encode($data);
        
        // 把所有未读 设为已读
        $this->db->query("update fly_message set isread=1 where to_uid=$uid");
    }
    
    // 私信 列表 个人对个人 
    public function message_p2p_list ()
    {
        $data = $member = array();
        $page = intval($_GET['page']) - 1;
        $from_uid = intval($_GET['from_uid']);
        $to_uid = intval($_GET['to_uid']);
        if (empty($from_uid) || empty($to_uid) ) {
            error(1,'uid is null');
        }
        
        $offset = $page > 0 ? $page * $this->pagesize : 0;    
        $query = $this->db->query(
                "SELECT COUNT(*) AS num FROM fly_message WHERE status=1 AND (from_uid=$from_uid OR to_uid=$from_uid) AND (from_uid=$to_uid OR to_uid=$to_uid)");
        $count_row = $query->row_array();
        $count = $count_row['num'];
        
        if ($count > $offset) {
            $sql = "SELECT id,from_uid,to_uid,title,audio,audio_time,addtime FROM fly_message WHERE status=1 AND (from_uid=$from_uid OR to_uid=$from_uid) AND (from_uid=$to_uid OR to_uid=$to_uid) ORDER BY id DESC limit $offset,$this->pagesize";
            $query = $this->db->query($sql);
            $data = $query->result_array();
            $data = array_reverse($data);
            foreach ($data as &$row) {
                $row['addtime'] = timeFromNow($row['addtime']);
            }
        }
        
        // print_r($data);
        echo json_encode($data);
        
        // 把指定人发给我的 未读 设为已读
        $this->db->query("update fly_message set isread=1 where to_uid=$from_uid AND from_uid=$to_uid");
    }
    
    // 私信 保存
    function message_save ()
    {
        $data = array(
                'from_uid' => intval($_POST['from_uid']),
                'to_uid' => intval($_POST['to_uid']),
                'title' => replaceBad( trim($_POST['title']) ),
                'addtime' => time(),
                'status' => 1
        );
        
        if (empty($data['from_uid']) || empty($data['to_uid'])) {
            error(1, "from_uid or to_uid null");
        }
        
        if ($_FILES['audio']['name']) { // 上传语音
            $data['audio'] = uploadFile('audio', 'audio');
            $data['audio_time'] = intval($_POST['audio_time']);
        }
        
        $query = $this->db->insert('fly_message', $data);
        echo 'ok';
    }    
    
    // 基础统计 保存
    function stat_save()
    {
        exit;
    }
    
    // 初始化 每日访问表，每天分24个时段  // 存插入数据的操作，最好用 MyISAM
    function test ()
    {
        echo date('G');
    }
    
	
	function save_error(){
		$data = array(
                'content' => $_POST['content'],
                'phone' => $_POST['phone'],
                'uid' =>  trim($_POST['uid']) ,
				'catid' => $_POST['catid'],
                'addtime' => time()
               
        );
         $query = $this->db->insert('fly_error', $data);
		 echo json_encode(array('id'=>$this->db->insert_id()));
	}
    
	function error_list(){
		$sql = "SELECT id,content,phone,catid,FROM_UNIXTIME(`addtime`) from fly_error ORDER BY id DESC";
        $query = $this->db->query($sql);
        $data = $query->result_array();
		var_dump($data);
	}
	
	
} // 类结束
