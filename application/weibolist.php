<?php
if (!defined('BASEPATH'))
	exit ('No direct script access allowed');

/*
* android客户端调用接口文�?通用文件接口 code by tangjian&lvyaozong 20130726
*/
class weibolist extends CI_Controller {

	function __construct() {
		parent :: __construct();
	}

	// 微博列表
	function index() {
// 		include_once ('config.php');
// 		include_once ('saetv2.ex.class.php');
// 		require_once APPPATH . 'libraries/emoji.php';
// 		$save_count = 0;
// 		$data['list'] = $this->common($save_count);
// 		$data['save_count'] = $save_count;
// 		$this->load->view('admin/weibo_list', $data);
		
		/* 原版�*/
		session_start();
		$save_count = 0;

		include ('config.php');
		include ('saetv2.ex.class.php');

		$c = new SaeTClientV2(WB_AKEY, WB_SKEY, $_SESSION['token']['access_token']);
		$listss = array();
		for($i = 1; $i < 6; $i++) {
			$ms = $c->home_timeline($i, 200); // 获取我的首页的最新微�?
			$uid_get = $c->get_uid();
			$uid = $uid_get['uid'];
			$data['user_message'] = $c->show_user_by_id($uid); // 根据ID获取用户等基本信�?
			$list = $ms['statuses'];	
			$list = array_reverse($list);
			// 先把系列台的微博 写入�?
			$weibo_ids = config_item('weibo_ids');
			
			foreach ($list as &$value) {
				$lists['id'] = $value['id'];
				$lists['user']['id'] = $value['user']['id'];
				$lists[text]  = $value['text'];
				$lists[addtime]  = strtotime($value['created_at']);
				$lists[created_at]  = $value['created_at'];
				$lists[user][name]  = $value['user']['name'];
					
					
				array_push($listss,$lists) ;
			}
			
		}
		
			$listss = $this->multi_array_sort($listss,'addtime');
			 
			$show_data = array();
			$this->load->model('groups_model');
			foreach ($listss as $value) {
				$weibo_uid = $value['user']['id'];
				$group_ary = $weibo_ids["$weibo_uid"];
				// �?系列台发的信�?
				if (empty ($group_ary['groupid'])) {
					continue;
				}
				$chat = array (
						'uid' => $group_ary['memberid'],
						'addtime' =>  strtotime($value['created_at']),
						'groupid' => $group_ary['groupid'],
						'title' => $value['text']
				);
			
				// 忽略 字数小于 10�?
				if (mb_strlen($value['text'], 'utf8') < 10) {
					continue;
				}
				// 过滤已经发过�?没有保存的就保存起来
				$is_save = $this->groups_model->check_weibo($value['id']);
				if ($is_save == false) {
					$this->groups_model->chats_save($chat);
					$save_count++;
					$show_data[] = $value;
				}
				
			}
			
		
	//	}
	    if( count($show_data) <1 ){
		   $data['list'] = $show_data;
	      }else{	
		   $data['list'] = $this->multi_array_sort($show_data,'addtime',SORT_DESC);
	    }
		$data['save_count'] = $save_count;
		$this->load->view('admin/weibo_list', $data);
		
	}

	// 转发主播微博
	function distribute() {
		include_once ('config.php');
		include_once ('saetv2.ex.class.php');
		require_once APPPATH . 'libraries/emoji.php';
		$save_count = 0;
		/*
		session_start();
		$save_count = 0;

		//		171 大海 117 1727470854
		//		175 晓娟 11  2017843205
		//		188 晨冬 124	1915566297
		//		138 草莓女主播Nicole 96	1865606165
		//		181 Kevin 55	1779988873
		//		189 音华 51 2017923657
		//		137 文佳 17 1783754225
		//		114 韦波 16 2576293655
		//		197 维克  14 1775218630
		//		151 紫悦 10 1919399755
		//		150 乐乐 36 930肖乐   1902378061
		$c = new SaeTClientV2(WB_AKEY, WB_SKEY, $_SESSION['token']['access_token']);
		$ms = $c->home_timeline(1, 50); // 获取我的首页的最新微�?
		$uid_get = $c->get_uid();
		$uid = $uid_get['uid'];
		$data['user_message'] = $c->show_user_by_id($uid); // 根据ID获取用户等基本信�?

		$list = $ms['statuses'];
		$list = array_reverse($list);

		$chat = config_item('chat');
		$this->load->model('groups_model');
		foreach ($list as $value) {
			// 过滤非主播发送的微博
			if(!array_key_exists(strval($value['user']['id']),$chat)) {
				continue;
			}

			$is_save = $this->groups_model->check_weibo_exists($value['mid']); // 对于筛选后的每一条微博，查询是否存在
			if ($is_save) {
				continue; // 存在，跳�?
			}
			$value['text'] = preg_replace("/(\/\/@.*)/","", $value['text']);
			$value['text'] = preg_replace("/(@.*)/","", $value['text']);
			$value['text'] = emoji_unified_to_html($value['text']);
			$value['text'] = preg_replace("#<span (.*)</span>#iUs","", $value['text']);
// 			$value['text'] = preg_replace("/(.x\S\S)/","", $value['text']);
			$pos  =  strpos ( $value['text'] ,  "😀" ); 
			if($pos != false) {
				continue; // 非法字符，跳�?
			}
// 			$value['text'] = preg_replace("/(.x\S\S)/","", $value['text']);
// 			$value['text'] = emoji_docomo_to_unified($value['text']);		
	
			// 忽略 字数小于 10�?
			if (mb_strlen($value['text'], 'utf8') < 10) {
				continue;
			}
			$weibo_id['id'] = $value['mid'];
			$userid = strval($value['user']['id']); //来自哪位主播
			
			$gid = $chat[$value['user']['id']]['groupid'];
			$uid = $chat[$value['user']['id']]['uid'];
			if($value['text'] =="") {
				continue;
			}
			if(!$gid || !$uid) continue;
			$chat[$userid]['groupid'] = $gid;
			
			$chat_data = array();
			
			$chat_data['uid'] = $uid;
			$chat_data['groupid'] = $gid;
			$chat_data['title'] = $value['text'];
			$chat_data['addtime'] = strtotime($value['created_at']);
			
// 			$chat[$userid]['groupid'] = $value[$list['user']['id']]['groupid'];
// 			$chat[$userid]['title'] = $value['text']; //微博内容
// 			$chat[$userid]['addtime'] = strtotime($value['created_at']); //微博发布时间
			
// 			$chat[$userid]['title'] = preg_replace("/(.x\S\S)/","", $value['text']);
// 			$this->groups_model->chats_save($chat_data);
			
			//新的更新方法
			//对于每一次采集，都会将最新的群信息写入到群列表，从而正确显�?
			$this->update_syn($chat_data);
			
			$this->db->insert('fly_weibo', $weibo_id); //更新已发微博�?
			$save_count++;
		}
		$list = array_reverse($list);

		*/
		$data['list'] = $this->common($save_count);
		$data['save_count'] = $save_count;
		$this->load->view('admin/zhubo_weibo_list', $data);
	}
	
	function distribute910() {
		include_once ('config910.php');
		include_once ('saetv2.ex.class.php');
		require_once APPPATH . 'libraries/emoji.php';		
		$save_count = 0;
		$data['list'] = $this->common($save_count);
		$data['save_count'] = $save_count;
		$this->load->view('admin/zhubo_weibo_list_910', $data);
	}
	
	function distribute930() {
		include_once ('config930.php');
		include_once ('saetv2.ex.class.php');
		require_once APPPATH . 'libraries/emoji.php';
		$save_count = 0;
		$data['list'] = $this->common($save_count);
		$data['save_count'] = $save_count;
		$this->load->view('admin/zhubo_weibo_list_930', $data);
	}
	
	function distribute950() {
		include_once ('config950.php');
		include_once ('saetv2.ex.class.php');
		require_once APPPATH . 'libraries/emoji.php';
		$save_count = 0;
		$data['list'] = $this->common($save_count);
		$data['save_count'] = $save_count;
		$this->load->view('admin/zhubo_weibo_list_950', $data);
	}
	
	function distribute970() {
		include_once ('config970.php');
		include_once ('saetv2.ex.class.php');
		require_once APPPATH . 'libraries/emoji.php';
		$save_count = 0;
		$data['list'] = $this->common($save_count);
		$data['save_count'] = $save_count;
		$this->load->view('admin/zhubo_weibo_list_970', $data);
	}
	
	function distribute1003() {
		include_once ('config1003.php');
		include_once ('saetv2.ex.class.php');
		require_once APPPATH . 'libraries/emoji.php';
		$save_count = 0;
		$data['list'] = $this->common($save_count);
		$data['save_count'] = $save_count;
		$this->load->view('admin/zhubo_weibo_list_1003', $data);
	}
	
	function distributebbr() {
		include_once ('configbbr.php');
		include_once ('saetv2.ex.class.php');
		require_once APPPATH . 'libraries/emoji.php';
		$save_count = 0;
		$data['list'] = $this->common($save_count);
		$data['save_count'] = $save_count;
		$this->load->view('admin/zhubo_weibo_list_bbr', $data);
	}
	
	function distributebbrtv() {
		include_once ('configbbrtv.php');
		include_once ('saetv2.ex.class.php');
		require_once APPPATH . 'libraries/emoji.php';
		$save_count = 0;
		$data['list'] = $this->common($save_count);
		$data['save_count'] = $save_count;
		$this->load->view('admin/zhubo_weibo_list_bbrtv', $data);
	}
	
	// 主播列表页和聊天页内容同步的方法
	private function update_syn($data) {
		//保存抓取的微�?
		$data['title'] = mb_substr($data['title'], 0, 390);
		$data['title'] = base64_encode( $data['title'] );
		$data['isbase64'] = 1;
		$this->db->insert ( 'fly_groups_chats', $data);
 		$insert_id = $this->db->insert_id();
			
		//按群取出最新的微博
		$sql = "SELECT groupid,title,isbase64 FROM fly_groups_chats where groupid = ".$data['groupid']." order by addtime desc limit 0,1";
		$query = $this->db->query($sql);
		$row = $query->row_array();	
		//更新群列表最新聊天记�?
// 		$sql = "UPDATE fly_groups SET last_title = '".$row['title']."' where id = ".$data['groupid'];
// 		$sql = 'UPDATE fly_groups SET last_title = "'.$row['title'].'" where id = '.$data['groupid'];
		$updateData = array();
		if($row['isbase64'] == 0){
		 $updateData['last_title'] = base64_encode( $row['title'] );
		}else{
			 $updateData['last_title'] =  $row['title'] ;
		}
		$updateData['last_time'] = $data['addtime'];
		$updateData['isbase64'] = 1;
		$this->db->where('id', $data['groupid']);
		$this->db->set($updateData);
		$q = $this->db->update('fly_groups');
		
// 		$this->db->query($sql);	 
		// 推�?
		$xinge = array (
				'type' => 'weibo',
				'title' => $updateData['last_title'],
				'addtime' => $data['addtime'],
				'group_tag'=> 'group'.$data ['groupid'],
				'uid' => $data['uid'],
				'id' => $insert_id);
		$this->load->model('xinge_model');
		$return = $this->xinge_model->xinge_group($xinge);
	}
	
	/* 原版�?
	 session_start();
	$save_count = 0;
	
	include ('config.php');
	include ('saetv2.ex.class.php');
	
	$c = new SaeTClientV2(WB_AKEY, WB_SKEY, $_SESSION['token']['access_token']);
	
	for($i = 1; $i < 6; $i++) {
	$ms = $c->home_timeline($i, 200); // 获取我的首页的最新微�?
	$uid_get = $c->get_uid();
	$uid = $uid_get['uid'];
	$data['user_message'] = $c->show_user_by_id($uid); // 根据ID获取用户等基本信�?
	$list = $ms['statuses'];
	$list = array_reverse($list);
	// 先把系列台的微博 写入�?
	$weibo_ids = config_item('weibo_ids');
	$this->load->model('groups_model');
	foreach ($list as $value) {
	$weibo_uid = $value['user']['id'];
	$group_ary = $weibo_ids["$weibo_uid"];
	// �?系列台发的信�?
	if (empty ($group_ary['groupid'])) {
	continue;
	}
	$chat = array (
			'uid' => $group_ary['memberid'],
			'addtime' => strtotime($value['created_at']),
			'groupid' => $group_ary['groupid'],
			'title' => $value['text']
	);
		
	// 忽略 字数小于 10�?
	if (mb_strlen($value['text'], 'utf8') < 10) {
	continue;
	}
	// 过滤已经发过�?没有保存的就保存起来
	$is_save = $this->groups_model->check_weibo($value['id']);
	if ($is_save == false) {
	$this->groups_model->chats_save($chat);
	$save_count++;
	}
	}
	}
	$data['list'] = $list;
	$data['save_count'] = $save_count;
	$this->load->view('admin/weibo_list', $data);
	*/
	
	// 微博采集方法
	private function common(&$save_count) {
		session_start();
		$c = new SaeTClientV2(WB_AKEY, WB_SKEY, $_SESSION['token']['access_token']);
		$ms = $c->home_timeline(1, 100); // 获取我的首页的最新微�?
		$uid_get = $c->get_uid();
		$uid = $uid_get['uid'];
		$data['user_message'] = $c->show_user_by_id($uid); // 根据ID获取用户等基本信�?

		$list = $ms['statuses'];
		$list = array_reverse($list);
	
		$chat = config_item('chat');
		$this->load->model('groups_model');
		foreach ($list as $value) {
			// 过滤非主播发送的微博
			if(!array_key_exists(strval($value['user']['id']),$chat)) {
				continue;
			}

			$is_save = $this->groups_model->check_weibo_exists($value['mid']); // 对于筛选后的每一条微博，查询是否存在
			
			if ($is_save) {
				continue; // 存在，跳�?
			}
			$value['text'] = preg_replace("/(\/\/@.*)/","", $value['text']);
			$value['text'] = preg_replace("/(@.*)/","", $value['text']);
			$value['text'] = emoji_unified_to_html($value['text']);
			$value['text'] = preg_replace("#<span (.*)</span>#iUs","", $value['text']);
			$pos  =  strpos ( $value['text'] ,  "😀" ); 
			if($pos != false) {
				continue; // 非法字符，跳�?
			}
	
			// 忽略 字数小于 10�?
			if (mb_strlen($value['text'], 'utf8') < 10) {
				continue;
			}
			$weibo_id['id'] = $value['mid'];
			$userid = strval($value['user']['id']); //来自哪位主播
			
			$gid = $chat[$value['user']['id']]['groupid'];
			$uid = $chat[$value['user']['id']]['uid'];
			if($value['text'] =="") {
				continue;
			}
			if(!$gid || !$uid) continue;
			$chat[$userid]['groupid'] = $gid;
			
			$chat_data = array();
			
			$chat_data['uid'] = $uid;
			$chat_data['groupid'] = $gid;
			$chat_data['title'] = $value['text'];
			$chat_data['addtime'] = strtotime($value['created_at']);
			
			//新的更新方法
			//对于每一次采集，都会将最新的群信息写入到群列表，从而正确显�?
			$this->update_syn($chat_data);
			
			$this->db->insert('fly_weibo', $weibo_id); //更新已发微博�?
			$save_count++;
		}
		$list = array_reverse($list);
		return $list;
	}
	
	
	function multi_array_sort($multi_array,$sort_key,$sort=SORT_ASC){
			if(is_array($multi_array)){
			foreach ($multi_array as $row_array){
			if(is_array($row_array)){
			$key_array[] = $row_array[$sort_key];
			}else{
			return false;
			}
			}
			}else{
			return false;
			}
			array_multisort($key_array,$sort,$multi_array);
			return $multi_array;
  } 

}