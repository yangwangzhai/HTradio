<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
/*
 * android 节目接口
 */
include 'api.php';
class program extends Api {
	private $table = 'fm_member';
	
	function __construct() {
		parent::__construct ();
		$this->get_base();
        $this->load->model('content_model');
	}
	
	function get_base(){
		session_start();
		$row = trims($_POST ? $_POST : $_GET);
		if(is_array($row)){
			$new_row['text'] = array2string($row);	
		}else{
			$new_row['text'] = $row;
		}
		$new_row['addtime'] = time();
		$query = $this->db->insert('sql_text',$new_row);
		

	}
	//首页
	public function index() {
		
		$page = intval ( $_GET ['page'] ) - 1;
		$offset = $page > 0 ? $page * $this->pagesize : 0;

		//筛选出 “在首页显示”且“状态”为 1 的记录
		$query = $this->db->query ( "select id,title,thumb,path from fm_program where show_homepage=1 AND status=1 order by sort desc" );
		$list['top'] = $query->result_array ();
		foreach ($list['top'] as &$row) {
    		if($row['thumb']) $row['thumb'] = base_url().$row['thumb'];
			if($row['path']) $row['path'] = $row['path'];
    	}

		//热门 收听的节目
		$query = $this->db->query ( "select id,title,playtimes,thumb,mid,path from fm_program where show_homepage!=1 AND status=1 and hot=1 order by playtimes desc limit $offset,$this->pagesize" );
		$list['hot'] = $query->result_array ();
		foreach ($list['hot'] as &$row) {
    		if($row['thumb']) $row['thumb'] = base_url().$row['thumb'];
			if($row['path']) $row['path'] = $row['path'];
			if($row['mid'])  $row['owner'] = getNickName($row['mid']);
    	}
		$query = $this->db->query ( "select id,title,playtimes,thumb,mid,path from fm_program  where status=1 order by playtimes desc limit $offset,$this->pagesize" );
		$list['click_ranking'] = $query->result_array ();
		foreach ($list['click_ranking'] as &$row) {
    		if($row['thumb']) $row['thumb'] = base_url().$row['thumb'];
			if($row['path']) $row['path'] = $row['path'];
			if($row['mid'])  $row['owner'] = getNickName($row['mid']);
    	}

		echo json_encode ($list);
	}
	
	//播单
	public function play_lists() {
		$page = intval ( $_GET ['page'] ) - 1;
		$offset = $page > 0 ? $page * $this->pagesize : 0;
		$query = $this->db->query ( "select id,title,playtimes,thumb,mid from fm_programme  order by playtimes desc limit $offset,$this->pagesize" );
		$list = $query->result_array ();
		foreach ($list as &$row) {
    		if($row['thumb']) $row['thumb'] = base_url().$row['thumb'];
			if($row['mid'])  $row['owner'] = getNickName($row['mid']);
    	}

		echo json_encode ($list);
	}

	 //首页推送的节目类型
	 function homepage_type(){
		$query = $this->db->query ( "select id,title,thumb,content from fm_program_type where pid='0' AND hot=1 limit 8" );
		$list = $query->result_array ();
		foreach ($list as &$row) {
    		if($row['thumb']) $row['thumb'] = base_url().$row['thumb'];			
    	}
		echo json_encode ( array('list' => $list ) );

	 }

	 //添加频道
	 public function add_channel(){
		 $data = array(
    			'mid' => intval($_POST['uid']),    			
    			'title' => replaceBad(trim($_POST['title'])),
    			'addtime' => time()
    	);
    	if (empty($data['mid'])) {
    		show(1,'mid is null');	   	
    	}
    	    	
    	$insert_id = $this->db->insert ( 'fm_channel', $data );
    	if ($insert_id) {
    		$msg = 'ok';    		
    		show(0, $msg, $insert_id);  		
    	} else {
    		show(2, '未知错误，添加没有成功');    		
    	}	
	 }
	 
	
	
	//添加节目单
	function add_programme_old(){
		$program_ids = $_POST['program_ids'];
		if (empty($program_ids)) {
    		show(2,'program_ids is null');	   	
    	}
		//$ids = implode(",", $program_ids);
		$data = array(
    			'mid' => intval($_POST['uid']),    			
    			'title' => replaceBad(trim($_POST['title'])),
				'program_ids' => $program_ids ,
    			'addtime' => time()
    	);
    	if (empty($data['mid'])) {
    		show(1,'mid is null');	   	
    	}
		
    	  //	echo json_encode ($_POST );
    	$insert_id = $this->db->insert ( 'fm_programme', $data );
    	if ($insert_id) {
			
    		$msg = 'ok';    		
    		show(0, $msg, $this->db->insert_id());  		
    	} else {
    		show(2, '未知错误，添加没有成功');    		
    	}	
	}
	
	//添加节目单
	function add_programme(){
		
		//$ids = implode(",", $program_ids);
		
		$data = array(
    			'mid' => intval($_POST['mid']),    			
    			'title' => replaceBad(trim($_POST['title'])),				
    			'addtime' => time()
    	);
    	if (empty($data['mid'])) {
    		show(1,'mid is null');	   	
    	}
		
    	  //	echo json_encode ($_POST );
    	$this->db->insert ( 'fm_programme', $data );
		$insert_id = $this->db->insert_id();
    	if ($insert_id) {
			$program_list = $_POST['program_ids'];
			$program_list = str_replace("-","\"",$program_list);
			$program_list = json_decode($program_list,true);
			//var_dump($program_list);
			//$program_list = $data_post['program_list'];
			if( count($program_list) >0 ){
				foreach($program_list as $key=>$row){
					unset($data);
					$data = array(
							'programme_id' => $insert_id,    			
							'type_id' => $row['type'],
							'program_id' => $row['id'],
							'timespan' => $row['time'],
							'sort' => $key
    					);
				   $this->db->insert ( 'fm_programme_list', $data );	
				}
			}
			
    		$msg = 'ok';    		
    		show(0, $msg, $insert_id);  		
    	} else {
    		show(2, '未知错误，添加没有成功');    		
    	}	
	}
	
	
		//修改节目单
	function edit_programme(){
		
		$programme_id = $_POST['programme_id'];
		$data = array(
    			'mid' => intval($_POST['mid']),    			
    			'title' => replaceBad(trim($_POST['title']))	
    	);
    	if (empty($data['mid'])) {
    		show(1,'mid is null');	   	
    	}
		
		if (empty($programme_id)) {
    		show(2,'programme_id is null');	   	
    	}
		if($data['title'] != '' && !empty($data['title']) ){
			$this->db->where('id',$programme_id); 
			$this->db->update ( 'fm_programme', $data );
		}
		
    	if ($programme_id) {
			$program_list = $_POST['program_ids'];
			$program_list = str_replace("-","\"",$program_list);
			$program_list = json_decode($program_list,true);
			$this->db->query("DELETE FROM fm_programme_list WHERE programme_id ={$programme_id} ");
			//var_dump($program_list);
			//$program_list = $data_post['program_list'];
			if( count($program_list) >0 ){
				foreach($program_list as $key=>$row){
					unset($data);
					if($row['is_delete'] == "1") continue;
					$data = array(
							'programme_id' => $programme_id,    			
							'type_id' => $row['type'],
							'program_id' => $row['id'],
							'timespan' => $row['time'],
							'sort' => $key
    					);
				   $this->db->insert ( 'fm_programme_list', $data );	
				}
			}
			
    		$msg = 'ok';    		
    		show(0, $msg, $programme_id);  		
    	} else {
    		show(2, '未知错误，添加没有成功');    		
    	}	
	}
	
	function add_more_programme(){
		
		$programme_id = $_POST['programme_id'];
		$data = array(
    			'mid' => intval($_POST['mid']), 
    			'addtime' => time()
    	);
    	if (empty($data['mid'])) {
    		show(1,'mid is null');	   	
    	}
		if (empty($programme_id)) {
    		show(2,'programme_id is null');	   	
    	}
    	$query = $this->db->query("SELECT max(sort) as max_sort FROM fm_programme_list WHERE programme_id ={$programme_id} limit 1");
		$max_row = $query->row_array();
    	if ($programme_id) {
			$program_list = $_POST['program_ids'];
			$program_list = str_replace("-","\"",$program_list);
			$program_list = json_decode($program_list,true);
			
			if( count($program_list) >0 ){
				foreach($program_list as $key=>$row){
					unset($data);
					$data = array(
							'programme_id' => $programme_id,    			
							'type_id' => $row['type'],
							'program_id' => $row['id'],
							'timespan' => $row['time'],
							'sort' => $max_row['max_sort'] ++ 
    					);
				   $this->db->insert ( 'fm_programme_list', $data );	
				}
			}
			
    		$msg = 'ok';    		
    		show(0, $msg, $programme_id);
    	} else {
    		show(2, '未知错误，添加没有成功');    		
    	}	
	}
	
	
	
	// 返回音频（节目）信息
	public function audio_info() {
		$id = $_GET ['id'];//获取音频id
		$mid = $_GET ['mid'];
		if (empty ( $id )) {
			show ( 1, 'id is null' );
		}
		$query = $this->db->query ( "SELECT id,path,thumb FROM fm_program where id = $id" );
		$row = $query->row_array ();
		$row ['path'] = base_url () . $row ['path'];
		$row ['thumb'] = base_url () . $row ['thumb'];
		
		$row['is_download'] = 0 ; 
		$row['is_favorite'] = 0 ; 
		$row['is_share'] = 0 ;
		//type_id 1为收藏，2是下载，3是播放过，4是分享过
		$query = $this->db->get_where('fm_program_data', array( 'program_id' => $id,'mid'=>$mid ,'type'=>1  )); 
		if($query->num_rows() > 0) $row['is_favorite'] = 1 ; 
		
		$query = $this->db->get_where('fm_program_data', array( 'program_id' => $id,'mid'=>$mid ,'type'=>2  )); 
		if($query->num_rows() > 0) $row['is_download'] = 1 ; 
		
		$query = $this->db->get_where('fm_program_data', array( 'program_id' => $id,'mid'=>$mid ,'type'=>4  )); 
		if($query->num_rows() > 0) $row['is_share'] = 1 ; 
		
		echo json_encode ( $row );
	}
	
	// 节目热度+1
	public function audio_plus() {
		$id = $_GET ['id'];//歌曲id
		if (empty ( $id )) {
			show ( 1, 'id is null' );
		}
		$sql = "update fm_program set playtimes = playtimes+1 where id = $id";
		$affectedrow = $this->db->query ( $sql );
		if ($affectedrow) {
			show ( 0, 'plus success' );
		} else {
			show ( 1, 'plus failure' );
		}
	}
	
	// 收藏节目
	public function program_fav_add() {		
		$data = array(
    			'mid' => intval($_POST['mid']),  
				'program_id' => $_POST['program_id'] ,
				'type' => $_POST['type_id'],  // 1为收藏，2是下载，3是播放过，4是分享过
    			'addtime' => time()
    	);
    	if (empty($data['mid'])) {
    		show(1,'mid is null');	   	
    	}
		if (empty ( $data['program_id'] )) {
			show ( 1, 'program_id is null' );
		}
		if (empty ( $data['type'] )) {
			show ( 1, 'type_id is null' );
		}
    	
    	$insert_id = $this->db->insert ( 'fm_program_data', $data );
    	if ($insert_id) {			
    		$msg = 'ok';    		
    		show(0, $msg, $this->db->insert_id());  		
    	} else {
    		show(2, '未知错误，添加没有成功');    		
    	}	
		
		
		
		
		
	}
	// 删除收藏节目
	public function program_fav_del() {
		$program_id = $_GET ['program_id'];//歌曲id
		$mid = $_GET ['mid'];
		$type_id = $_GET ['type_id'];
		if (empty ( $program_id )) {
			show ( 1, 'program_id is null' );
		}
		if (empty($mid)) {
    		show(1,'mid is null');	   	
    	}
		if (empty($type_id)) {
    		show(1,'type_id is null');	   	
    	}
		$sql = "DELETE FROM fm_program_data  where program_id = $program_id AND mid=$mid AND type=$type_id";
		$affectedrow = $this->db->query ( $sql );
		if ($affectedrow) {
			show ( 0, 'del success' );
		} else {
			show ( 1, 'del failure' );
		}
		
	}
	
	
	
		// 收藏节目单
	public function programme_fav_add() {		
		$data = array(
    			'mid' => intval($_POST['mid']),  
				'programme_id' => $_POST['programme_id'] ,
				'type' => $_POST['type_id'],  // 1为收藏，2是下载，3是播放过，4是分享过
    			'addtime' => time()
    	);
    	if (empty($data['mid'])) {
    		show(1,'mid is null');	   	
    	}
		if (empty ( $data['programme_id'] )) {
			show ( 1, 'programme_id is null' );
		}
		if (empty ( $data['type'] )) {
			show ( 1, 'type_id is null' );
		}
    	
    	$insert_id = $this->db->insert ( 'fm_programme_data', $data );
    	if ($insert_id) {			
    		$msg = 'ok';    		
    		show(0, $msg, $this->db->insert_id());  		
    	} else {
    		show(2, '未知错误，添加没有成功');    		
    	}	
		
		
		
		
		
	}
	// 删除收藏节目单
	public function programme_fav_del() {
		$programme_id = $_GET ['programme_id'];//歌曲id
		$mid = $_GET ['mid'];
		$type_id = $_GET ['type_id'];
		if (empty ( $programme_id )) {
			show ( 1, 'programme_id is null' );
		}
		if (empty($mid)) {
    		show(1,'mid is null');	   	
    	}
		if (empty($type_id)) {
    		show(1,'type_id is null');	   	
    	}
		$sql = "DELETE FROM fm_programme_data  where programme_id = $programme_id AND mid=$mid AND type=$type_id";
		$affectedrow = $this->db->query ( $sql );
		if ($affectedrow) {
			show ( 0, 'del success' );
		} else {
			show ( 1, 'del failure' );
		}
		
	}

	//删除我的节目单
	public function programme_del(){
		$programme_id = $_GET['programme_id'];
		$mid = $_GET['mid'];
		if (empty($programme_id)) {
    		show(1,'programme_id is null');	   	
    	}
		if (empty($mid)) {
    		show(1,'mid is null');	  	   	
    	}
		$this->db->delete('fm_programme', array('id' => $programme_id,'mid' => $mid)); 
		show (0, 'ok' );
		
	}
	
	//删除节目单中的某个节目
	function programme_pro_del(){
		$programme_id = $_GET['programme_id'];
		$program_id = $_GET['program_id']; 
		if(empty($programme_id)){
			show (1, 'programme_id is null' );
		}
		if(empty($program_id)){
			show (2, 'program_id is null' );
		}
		$query = $this->db->query ( "SELECT id,program_ids FROM fm_programme where id = $programme_id" );
		$row = $query->row_array ();
		if($row['program_ids'] != ''){
			$program_ids_old = explode(',',$row['program_ids']);//原有的节目单节目id
			$program_ids_del = explode(',',$program_id);//要删除的节目单节目id
			
			$new_program_ids = array_diff($program_ids_old,$program_ids_del);//去掉重复的1,3,4,5,6,7,8,9
			if( !empty($new_program_ids) && is_array($new_program_ids) ){
					$new_program_ids = implode(',',$new_program_ids);
					$this->db->where('id',$programme_id);
					$query = $this->db->update('fm_programme',array('program_ids'=>$new_program_ids));
					show (0, 'ok' );
			}
		}
	}
	
	//节目单排序
	function programme_sort(){
		$programme_id = $_GET['programme_id'];
		$program_ids = $_GET['program_ids'];
		if(empty($programme_id)){
			show (1, 'programme_id is null' );
		}
		if(empty($program_ids)){
			show (2, 'program_ids is null' );
		}
		$program_ids = explode(',',$program_ids);
		if(count($program_ids) > 0){
			foreach($program_ids as $key=>$val){
				$this->db->where('id',$val);
				$this->db->update('fm_programme_list',array('sort'=>$key));
			}
			show (0, 'ok' );
		}else{
			show (1, 'error' );
		}
	}
	
	
	//下载节目
	public function program_dl(){
		$program_id = $_GET ['program_id'];//获取音频id
		if (empty($program_id)) {
    		show(1,'program_id is null');	   	
    	}
		$query = $this->db->query ( "SELECT id,path,title FROM fm_program where id = $program_id" );
		$row = $query->row_array ();
		$row ['path'] = base_url () . $row ['path'];
		echo json_encode ($row );
		
	}
	
	//下载节目单
	public function programme_dl(){
		$programme_id = $_GET['programme_id'];
		if (empty($programme_id)) {
    		show(1,'programme_id is null');	   	
    	}
		$query = $this->db->get_where('fm_programme', array('id'=>$programme_id ),1); 
		$row = $query->row_array();
		$ids = explode(',', trim($row['program_ids']));
		$list = array();
		foreach($ids as $id){
			$this->db->select('id, title, path');
			$query = $this->db->get_where('fm_program', array('id'=>$id ),1); 
			$program = $query->row_array();			
			$program['path'] = base_url(). $program['path'];
			$list[] = $program;
		}
		echo json_encode ($list );
	}
	
	/**
	*  搜索,type为1是节目列表，2是节目单列表，3是会员列表
	**/
	public function search(){
		$keyword = $_GET['keyword'];;
		$data = array();
		//搜索节目
		$this->db->select('id, title , path , thumb');
		$this->db->like(array('title'=>$keyword ));
		$query = $this->db->get_where('fm_program'); 
		$program_array = $query->result_array();
		foreach ($program_array as &$row) {
				$row['type'] = '1';
				if($row['path']) $row['path'] = base_url().$row['path'];
			    if($row['thumb']) $row['thumb'] = base_url().$row['thumb'];
				$data[] = $row;								
		}
		
		//搜索节目单
		$this->db->select('id, title');
		$this->db->like(array('title'=>$keyword ));
		$query = $this->db->get_where('fm_programme'); 
		$programme_array = $query->result_array();	
		foreach ($programme_array as &$row) {
			    $row['type'] = '2';
				$data[] = $row;								
		}
		
		//搜索会员
		$this->db->select('id, nickname');
		$this->db->like(array('nickname'=>$keyword ));
		$query = $this->db->get_where('fm_member'); 
		$member_array = $query->result_array();	
		foreach ($member_array as &$row) {
			    $row['type'] = '3';
				$row['title'] = $row['nickname'];
				$data[] = $row;								
		}	
		echo json_encode ($data );
	}

    //获取我的节目单
    public function my_programme(){
        $page = intval ( $_GET ['page'] ) - 1;
        $offset = $page > 0 ? $page * $this->pagesize : 0;
        $mid = $_GET ['mid'];
        if (empty($mid)) {
            show(1,'mid is null');
        }
        $this->db->select('id, title, thumb');
        $this->db->order_by("addtime", "desc");
        $query = $this->db->get_where('fm_programme', array('mid'=>$mid,'status'=>0,'publish_flag'=>1),$this->pagesize,$offset);
        $list = $query->result_array();
        foreach ($list as &$row) {
            if($row['thumb']) $row['thumb'] = base_url().$row['thumb'];
        }

        echo json_encode ($list );
    }

    //根据programme_id获取对应的节目单详情
    public function programme_detail(){
        $programme_id = $_GET['programme_id'];
        //$row['mid'] = $mid = $_GET['mid'];
        if (empty($programme_id)) {
            $result1=array("code"=>1,"message"=>"节目单ID没有传进来","time"=>time(),"data"=>array());
            echo json_encode($result1);
        }else{
            $query = $this->db->get_where('fm_programme', array('id'=>$programme_id ),1);
            $row = $query->row_array();
            if(empty($row['mid'])){
                $result1=array("code"=>1,"message"=>"找不到对应的数据","time"=>time(),"data"=>array());
                echo json_encode($result1);
            }else{
                $row_member = getMember($row['mid']);
                $row_data['programme_name'] = $row['title'];
                $row_data['programme_thumb'] = base_url().$row['thumb'];
                $row_data['member_name'] = $row_member['nickname'];
                $row_data['member_thumb'] = base_url().$row_member['avatar'];
                $row_data['member_id'] = $row['mid'];

                $data_list = array();
                $this->db->order_by('sort');
                $query = $this->db->get_where('fm_programme_list', array('programme_id'=>$programme_id ));
                $result = $query->result_array();
                //类型id,1节目id，2是类型id
                foreach($result as &$row){
                    if($row['type_id'] == 1){
                        $this->db->select('id, title, addtime , program_time , mid , path ,download_path ,thumb');
                        $query = $this->db->get_where('fm_program', array('id'=>$row['program_id'] ),1);
                        $program = $query->row_array();

                        if ($program['path']) {
                            //判断图片路径是否为http或者https开头
                            $preg="/(http:\/\/)|(https:\/\/)(.*)/iUs";
                            if(preg_match($preg,$program['path'])){
                                $row['path'] = $program['path'];
                            }else{
                                $row['path'] = base_url(). $program['path'];
                            }

                        }else{
                            $row['path'] = '';
                        }

                        if ($program['download_path']) {
                            //判断图片路径是否为http或者https开头
                            $preg="/(http:\/\/)|(https:\/\/)(.*)/iUs";
                            if(preg_match($preg,$program['download_path'])){
                                $row['download_path'] = $program['download_path'];
                            }else{
                                $row['download_path'] = base_url(). $program['download_path'];
                            }

                        }else{
                            $row['download_path'] = '';
                        }

                        if($program['thumb']) $row['thumb'] = base_url().$program['thumb'];
                        $row['addtime'] = date('Y/m/d',$program['addtime']);
                        $row['nickname'] = getNickName($program['mid']);
                        $row['title'] = $program['title'];
                    }else{
                        $this->db->select('id, title');
                        $query = $this->db->get_where('fm_program_type', array('id'=>$row['program_id'] ),1);
                        $program = $query->row_array();

                        $row['path'] = "";
                        $row['thumb'] = "";
                        $row['addtime'] = "";
                        $row['nickname'] = "";
                        $row['title'] = $program['title'];
                        $typeid = $row['program_id'];
                        $offset = 0;
                        $query = $this->db->query ( "select id,title,thumb,program_time,mid,path ,download_path from fm_program WHERE  ( status=1 AND type_id = $typeid ) OR ( status=1 AND type_id IN(SELECT id FROM fm_program_type WHERE pid = $typeid ) ) order by playtimes desc limit $offset,$this->pagesize" );
                        $list = $query->result_array ();
                        $i = 0;
                        foreach ($list as &$type_row) {
                            if($type_row['thumb']) $type_row['thumb'] = base_url().$type_row['thumb'];
                            if($type_row['path']) $type_row['path'] = base_url().$type_row['path'];
                            if($type_row['mid'])  $type_row['owner'] = getNickName($type_row['mid']);

                        }
                        $row['contentlist'] = $list;
                    }

                }
                $data = array('row' => $row_data , 'list' => $result );
                echo json_encode ($data );
            }

        }

    }


    //获取节目类型
    public function find(){
        $query = $this->db->query ( "select id,title from fm_program_type where pid='0' " );
        $list_type = $query->result_array ();

        $query = $this->db->query ( "select id,nickname,avatar from fm_member where catid='3' " );
        $list_member = $query->result_array ();
        foreach ($list_member as &$row) {
            if($row['avatar']) $row['avatar'] = base_url().$row['avatar'];

        }
        echo json_encode (array('radio_list'=>$list_member,'type_list'=>$list_type));
    }

    /**
     *  接口说明：按类型搜索节目(可获取该类型下的子孙类型节目，比如获取音乐类型节目，将取出类型为音乐的节目，同时所有以音乐为父类型的节目)
     *  接口地址：http://vroad.bbrtv.com/cmradio/index.php?d=android&c=program&m=get_list_by_type
     *
     */
    function get_list_by_type(){
        $typeid = $_GET['type_id'];
        if($typeid==''){
            show(1,'type_id is null');
        }
        $page = intval ( $_GET ['page'] ) - 1;
        $offset = $page > 0 ? $page * $this->pagesize : 0;
        $query = $this->db->query ( "select id,title,thumb,program_time,mid,path,playtimes from fm_program WHERE  ( status=1 AND type_id = $typeid ) OR ( status=1 AND type_id IN(SELECT id FROM fm_program_type WHERE pid = $typeid ) ) order by playtimes desc limit $offset,$this->pagesize" );
        $list = $query->result_array ();

        $i = 0;
        foreach ($list as &$row) {
            if($row['thumb']) $row['thumb'] = base_url().$row['thumb'];
            if($row['path']) $row['path'] =$row['path'];
            $row['owner'] = getNickName($row['mid']) ? getNickName($row['mid']) : '无名';
        }
        $data = array('list'=>$list );

        echo json_encode ($data );
    }

    /**
     *  接口说明：首页获取节目类型列表信息
     *  接口地址：http://vroad.bbrtv.com/cmradio/index.php?d=android&c=program&m=type_index
     *
     */
    public function type_index(){
        echo json_encode(array());
    }


    /**
     *  接口说明：获取节目类型列表信息
     *  接口地址：http://vroad.bbrtv.com/cmradio/index.php?d=android&c=program&m=type
     *  参数接收方式：get
     *	接收参数：
     *  mid；用户ID
     *  返回参数：
     *  "id": 类型id
     *  "title": 名称
     *  "thumb": logo地址
     *  "support_num"：当前点赞数
     *  "negative_num"：当前差评数
     *  "program_count": 该类型对应的具体的节目数目
     *  support_status：点赞状态，0:表示未点赞，1:表示已经点过赞
     *  negative_status：差评状态，0:表示未差评，1:已经差评过
     *
     */
    public function type() {
        $mid=$this->input->get("mid");
        $page = intval ( $_GET ['page'] ) - 1;
        $offset = $page > 0 ? $page * $this->pagesize : 0;
        $query = $this->db->query ( "select id,title,thumb,support_num,negative_num from fm_program_type where pid='0' limit $offset,$this->pagesize" );
        $list = $query->result_array ();
        foreach ($list as $list_key=>&$row) {
            if($row['thumb']) $row['thumb'] = base_url().$row['thumb'];
            $query = $this->db->query("SELECT COUNT(*) AS num FROM fm_program WHERE type_id='$row[id]' ");
            $count = $query->row_array();
            $row['program_count'] = $count['num'] ;
            //查看该频道是否被该用户点赞过
            if(!empty($mid)){
                $support_res=$this->db->query("SELECT COUNT(*) AS num FROM fm_support_negative WHERE mid=$mid AND support_target_id=$row[id] AND channel_type=2");
                $support_num=$support_res->row_array();
                if($support_num['num']){
                    $list[$list_key]['support_status']=1;
                }else{
                    $list[$list_key]['support_status']=0;
                }
                //查看该频道是否被该用户差评过
                $negative_res=$this->db->query("SELECT COUNT(*) AS num FROM fm_support_negative WHERE mid=$mid AND negative_target_id=$row[id] AND channel_type=2");
                $negative_num=$negative_res->row_array();
                if($negative_num['num']){
                    $list[$list_key]['negative_status']=1;
                }else{
                    $list[$list_key]['negative_status']=0;
                }
            }else{
                $list[$list_key]['support_status']=0;
                $list[$list_key]['negative_status']=0;
            }

        }
        echo json_encode ($list );
    }

    /**
     *  接口说明：获取个人频道的列表信息
     *  接口地址：http://vroad.bbrtv.com/cmradio/index.php?d=android&c=program&m=personal_channel_list
     *  参数接收方式：get
     *	接收参数：
     *  mid；用户ID
     *  返回参数：
     *  id：个人频道ID
     *  title：个人频道的名称
     *  description：个人频道简介
     *  logo：个人频道的logo
     *  support_num：当前点赞数
     *  negative_num：当前差评数
     *  support_status：点赞状态，0:表示未点赞，1:表示已经点过赞
     *  negative_status：差评状态，0:表示未差评，1:已经差评过
     */
    public function personal_channel_list(){
        $mid=$this->input->get("mid");
        if($mid==0){
            $result=array();
            echo json_encode($result);
        }else{
            $data['list'] = array();
            $num=$this->content_model->db_counts("fm_programme","");
            $data['count'] = $num;
            $this->load->library('pagination');
            $config['total_rows'] = $num;
            $config['per_page'] = 20;
            $this->pagination->initialize($config);
            $data['pages'] = $this->pagination->create_links();
            $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
            $per_page = $config['per_page'];
            $sql = "SELECT id,title,intro as description,thumb as logo ,status,0 as sort , addtime,uid,support_num,negative_num  FROM fm_programme WHERE status=1 AND publish_flag=1 ORDER BY id DESC limit $offset,$per_page";
            $query = $this->db->query($sql);
            $list = $query->result_array();
            foreach($list as $list_key=>&$list_value){
                $list[$list_key]['logo']=$list_value['logo'] ? "http://vroad.bbrtv.com/cmradio/".$list_value['logo'] : "http://vroad.bbrtv.com/cmradio/uploads/default_images/default_program.jpg";
                /*$list[$list_key]['sort'] = 0;*/
                //查看该频道是否被该用户点赞过
                if(!empty($mid)){
                    $support_res=$this->db->query("SELECT COUNT(*) AS num FROM fm_support_negative WHERE mid=$mid AND support_target_id=$list_value[id] AND channel_type=5");
                    $support_num=$support_res->row_array();
                    if($support_num['num']){
                        $list[$list_key]['support_status']=1;
                    }else{
                        $list[$list_key]['support_status']=0;
                    }
                    //查看该频道是否被该用户差评过
                    $negative_res=$this->db->query("SELECT COUNT(*) AS num FROM fm_support_negative WHERE mid=$mid AND negative_target_id=$list_value[id] AND channel_type=5");
                    $negative_num=$negative_res->row_array();
                    if($negative_num['num']){
                        $list[$list_key]['negative_status']=1;
                    }else{
                        $list[$list_key]['negative_status']=0;
                    }
                }else{
                    $list[$list_key]['support_status']=0;
                    $list[$list_key]['negative_status']=0;
                }
            }
            echo json_encode($list);
        }

    }

    /**
     *  接口说明：获取个人频道的节目
     *  接口地址：http://vroad.bbrtv.com/cmradio/index.php?d=android&c=program&m=get_personal_channel_program
     *  参数接收方式：get
     *  接收参数：
     *  id：个人频道ID
     *  成功时返回的数据：
     *  {
            "code": 0,
            "message": "获取成功",
            "time": 1467360686,
            "data": [
                        {
                        "id": "1349",
                        "title": "成长没烦恼_2016-04-28",
                        "path": "http://media2.bbrtv.com:1935/vod/_definst_/mp4:Archive/1003/2016/04/28/ccmfn_14568269163661003_1461798001090.mp4/playlist.m3u8"
                        },
                        {
                        "id": "1479",
                        "title": "资讯和音乐_2016-05-04",
                        "path": "http://media2.bbrtv.com:1935/vod/_definst_/mp4:Archive/970/2016/05/04/z_hyl_1439264080090970_1462323601027.mp4/playlist.m3u8"
                        }
            ]
        }
     *
     * 	"code"：返回码 0 表示获取成功，大于0表示获取失败
     * 	"message"：描述信息
     * 	"time"：时间戳
     *  "id"：节目ID
     *  "title"：节目名称
     *  "path"：节目路径
     */
    public function get_personal_channel_program(){
        $id=$this->input->get("id");
        if(empty($id)){
            $result=array("code"=>1,"message"=>"个人频道参数没有传进来","time"=>time(),"data"=>array());
            echo json_encode($result);
        }else{
            $sql_program = "select id,title,path from fm_program WHERE id IN (SELECT program_id FROM fm_programme_list WHERE programme_id=$id ORDER BY addtime DESC)";
            $query_program = $this->db->query($sql_program);
            $program=$query_program->result_array();
            if(!empty($program)){
                foreach($program as &$value){
                    if ($value ['path']) {
                        //判断图片路径是否为http或者https开头
                        $preg="/(http:\/\/)|(https:\/\/)(.*)/iUs";
                        if(preg_match($preg,$value ['path'])){
                            //不需要操作
                        }else{
                            $value ['path'] = base_url(). $value ['path'];
                        }

                    }
                }
            }

            if(!empty($program)){
                $result=array("code"=>0,"message"=>"获取成功","time"=>time(),"data"=>$program);
                echo json_encode($result);
            }else{
                $result=array("code"=>1,"message"=>"没有节目","time"=>time(),"data"=>array());
                echo json_encode($result);
            }
        }

    }

    /**
     *  接口说明：获取直播频道的列表信息
     *  接口地址：http://vroad.bbrtv.com/cmradio/index.php?d=android&c=program&m=live_channel_list
     *  参数接收方式：get
     *	接收参数：
     *  mid；用户ID
     *  返回参数：
     *  id：直播频道ID
     *  title：直播频道的名称
     *  description：直播频道简介
     *  add_channel：直播频道的链接地址
     *  logo：直播频道的logo
     *  support_num：当前点赞数
     *  negative_num：当前差评数
     *  support_status：点赞状态，0:表示未点赞，1:表示已经点过赞
     *  negative_status：差评状态，0:表示未差评，1:已经差评过
     */
	public function live_channel_list(){
        $mid=$this->input->get("mid");
        $data['list'] = array();
        $num=$this->content_model->db_counts("fm_live_channel","");
        $data['count'] = $num;
        $this->load->library('pagination');
        $config['total_rows'] = $num;
        $config['per_page'] = 20;
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links();
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
        $per_page = $config['per_page'];
        $sql = "SELECT * FROM fm_live_channel ORDER BY id DESC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $list = $query->result_array();
		foreach($list as $list_key=>$list_value){
			$list[$list_key]['logo']="http://vroad.bbrtv.com/cmradio/".$list_value['logo'];
            //查看该频道是否被该用户点赞过
            if(!empty($mid)){
                $support_res=$this->db->query("SELECT COUNT(*) AS num FROM fm_support_negative WHERE mid=$mid AND support_target_id=$list_value[id] AND channel_type=1");
                $support_num=$support_res->row_array();
                if($support_num['num']){
                    $list[$list_key]['support_status']=1;
                }else{
                    $list[$list_key]['support_status']=0;
                }
                //查看该频道是否被该用户差评过
                $negative_res=$this->db->query("SELECT COUNT(*) AS num FROM fm_support_negative WHERE mid=$mid AND negative_target_id=$list_value[id] AND channel_type=1");
                $negative_num=$negative_res->row_array();
                if($negative_num['num']){
                    $list[$list_key]['negative_status']=1;
                }else{
                    $list[$list_key]['negative_status']=0;
                }
            }else{
                $list[$list_key]['support_status']=0;
                $list[$list_key]['negative_status']=0;
            }
		}
        echo json_encode($list);
    }

	/**
	 *  接口说明：接收并保存客户端的上传的录音（音频）
	 *  接口地址：http://vroad.bbrtv.com/cmradio/index.php?d=android&c=program&m=upload_audio
	 *	接收参数：
	 * 	mid：用户id
	 * 	title：上传录音标题
	 * 	type_id：类型ID
	 * 	filename：上传文本框的名称。
	 * 	返回参数：
	 * 	status：状态码 1表示成功 ，0表示失败
	 * 	msg：描述
	 * 	time：时间戳
	 */
	public function upload_audio(){
		$mid=$this->input->post("mid");
		$title=$this->input->post("title");
		$type_id=$this->input->post("type_id");
		$path=uploadAudio('filename', $dir_name = 'audio');
		if($mid&&$title&&$type_id&&$path){
            //根据mid获取用户昵称
            $sql = "SELECT nickname FROM fm_member WHERE id=$mid";
            $query = $this->db->query($sql);
            $nickname=$query->row_array();
			$data = array(
					'mid' => $mid,
					'title' => $nickname['nickname'].'-'.date("Y-m-d H:i:s",time()),
					'type_id' => $type_id,
					'audio_flag' => 1,
					'addtime' => time(),
					'path' => $path,
					'download_path' => $path
			);
			$this->db->insert ( 'fm_program', $data );
			$result=array("status"=>1,"msg"=>"success","time"=>time());
			echo json_encode($result);
		}else{
			$result=array("status"=>0,"msg"=>"false","time"=>time());
			echo json_encode($result);
		}
	}

    /**
     *  接口说明：点赞
     *  接口地址：http://vroad.bbrtv.com/cmradio/index.php?d=android&c=program&m=support
     *  参数接收方式：post
     *	接收参数：
     * 	id：频道id
     * 	channel_type：频道类型，1:直播频道 ，2:录播频道，3:我的频道,4:个人频道
     *  mid；用户ID
     * 	返回参数：
     * 	code：返回码 0正确, 大于0 都是错误的
     * 	message：描述信息
     * 	time：时间戳
     *  "data":{"id":1,"channel_type":1,"support_num":5}
     *  其中：
     *  "id":频道id
     *  "channel_type":频道类型，1:直播频道 ，2:录播频道，3:我的频道，4:个人频道
     *  "support_num":当前点赞数
     *
     */
    public function support(){
        $insert['support_target_id']=$id=$this->input->post("id");
        $insert['channel_type']=$channel_type=$this->input->post("channel_type");
        $insert['mid']=$mid=$this->input->post("mid");
        //先查询该用户是否对该频道已经点过赞
        $res_num=$this->db->query("SELECT COUNT(*) AS num FROM fm_support_negative WHERE mid=$mid AND support_target_id=$id AND channel_type=$channel_type");
        $num=$res_num->row_array();
        if($num['num']){
            $result=array("code"=>1,"message"=>"已点赞","time"=>time(),"data"=>array("id"=>$id,"channel_type"=>$channel_type,"support_num"=>$num['num']));
            echo json_encode($result);
        }else{
            //把该用户点赞或者差评过的记录到数据库中，这样知道该用户点赞过哪个频道，差评过哪个频道，
            //同时防止同一个用户对同一个频道点赞或者差评多次
            $this->db->insert ( 'fm_support_negative', $insert);
            if($channel_type==1){   //直播频道点赞数加 1
                //先获取点赞数
                $sql = "SELECT support_num FROM fm_live_channel WHERE id=$id";
                $query = $this->db->query($sql);
                $res=$query->row_array();
                $support_num_new=$res['support_num']+1;
                //更新数据库
                $this->db->query("UPDATE fm_live_channel SET support_num=$support_num_new WHERE id=$id");
                //返回数据
                $result=array("code"=>0,"message"=>"success","time"=>time(),"data"=>array("id"=>$id,"channel_type"=>$channel_type,"support_num"=>$support_num_new));
                echo json_encode($result);
            }elseif($channel_type==2){
                //先获取点赞数
                $sql = "SELECT support_num FROM fm_program_type WHERE id=$id";
                $query = $this->db->query($sql);
                $res=$query->row_array();
                $support_num_new=$res['support_num']+1;
                //更新数据库
                $this->db->query("UPDATE fm_program_type SET support_num=$support_num_new WHERE id=$id");
                //返回数据
                $result=array("code"=>0,"message"=>"success","time"=>time(),"data"=>array("id"=>$id,"channel_type"=>$channel_type,"support_num"=>$support_num_new));
                echo json_encode($result);
            }elseif($channel_type==5){  //我的频道（公共频道）
                //先获取点赞数
                $sql = "SELECT support_num FROM fm_programme WHERE id=$id";
                $query = $this->db->query($sql);
                $res=$query->row_array();
                $support_num_new=$res['support_num']+1;
                //更新数据库
                $this->db->query("UPDATE fm_programme SET support_num=$support_num_new WHERE id=$id");
                //返回数据
                $result=array("code"=>0,"message"=>"success","time"=>time(),"data"=>array("id"=>$id,"channel_type"=>$channel_type,"support_num"=>$support_num_new));
                echo json_encode($result);
            }
        }

    }

    /**
     *  接口说明：差评
     *  接口地址：http://vroad.bbrtv.com/cmradio/index.php?d=android&c=program&m=negative
     *  参数接收方式：post
     *	接收参数：
     * 	id：频道id
     * 	channel_type：频道类型，1:直播频道 ，2:录播频道，3:我的频道，4:个人频道
     *  mid；用户ID
     * 	返回参数：
     * 	code：返回码 0正确, 大于0 都是错误的
     * 	message：描述信息
     * 	time：时间戳
     *  "data":{"id":1,"channel_type":1,"negative_num":5}
     *  其中：
     *  "id":频道id
     *  "channel_type":频道类型，1:直播频道 ，2:录播频道，3:我的频道，4:个人频道
     *  "negative_num":当前差评数
     *
     */
    public function negative(){
        $insert['negative_target_id']=$id=$this->input->post("id");
        $insert['channel_type']=$channel_type=$this->input->post("channel_type");
        $insert['mid']=$mid=$this->input->post("mid");
        //先查询该用户是否对该频道已经差评
        $res_num=$this->db->query("SELECT COUNT(*) AS num FROM fm_support_negative WHERE mid=$mid AND negative_target_id=$id AND channel_type=$channel_type");
        $num=$res_num->row_array();
        if($num['num']){
            $result=array("code"=>1,"message"=>"已差评","time"=>time(),"data"=>array("id"=>$id,"channel_type"=>$channel_type,"negative_num"=>$num['num']));
            echo json_encode($result);
        }else{
            //把该用户点赞或者差评过的记录到数据库中，这样知道该用户点赞过哪个频道，差评过哪个频道，
            //同时防止同一个用户对同一个频道点赞或者差评多次
            $this->db->insert ( 'fm_support_negative', $insert);
            if($channel_type==1){   //直播频道点赞数加 1
                //先获取差评数
                $sql = "SELECT negative_num FROM fm_live_channel WHERE id=$id";
                $query = $this->db->query($sql);
                $res=$query->row_array();
                $negative_num_new=$res['negative_num']+1;
                //更新数据库
                $this->db->query("UPDATE fm_live_channel SET negative_num=$negative_num_new WHERE id=$id");
                //返回数据
                $result=array("code"=>0,"message"=>"success","time"=>time(),"data"=>array("id"=>$id,"channel_type"=>$channel_type,"negative_num"=>$negative_num_new));
                echo json_encode($result);
            }elseif($channel_type==2){
                //先获取差评数
                $sql = "SELECT negative_num FROM fm_program_type WHERE id=$id";
                $query = $this->db->query($sql);
                $res=$query->row_array();
                $negative_num_new=$res['negative_num']+1;
                //更新数据库
                $this->db->query("UPDATE fm_program_type SET negative_num=$negative_num_new WHERE id=$id");
                //返回数据
                $result=array("code"=>0,"message"=>"success","time"=>time(),"data"=>array("id"=>$id,"channel_type"=>$channel_type,"negative_num"=>$negative_num_new));
                echo json_encode($result);
            }elseif($channel_type==5){
                //先获取差评数
                $sql = "SELECT negative_num FROM fm_programme WHERE id=$id";
                $query = $this->db->query($sql);
                $res=$query->row_array();
                $negative_num_new=$res['negative_num']+1;
                //更新数据库
                $this->db->query("UPDATE fm_programme SET negative_num=$negative_num_new WHERE id=$id");
                //返回数据
                $result=array("code"=>0,"message"=>"success","time"=>time(),"data"=>array("id"=>$id,"channel_type"=>$channel_type,"negative_num"=>$negative_num_new));
                echo json_encode($result);
            }
        }


    }

    /**
     *  接口说明：获取录音列表
     *  接口地址：http://vroad.bbrtv.com/cmradio/index.php?d=android&c=program&m=audio_list
     *  参数接收方式：post
     *	接收参数：
     * 	mid：用户ID
     * 	返回参数：
     * 	code：返回码 0正确, 大于0 都是错误的
     * 	message：描述信息
     * 	time：时间戳
     *  "data":{"id":1,"title":录音名称,"path":http://vroad.bbrtv.com/cmradio/uploads/audio/20160527/20160527153851_21282.amr,"addtime": 1465206911}
     *  其中：
     *  "id":录音id
     *  "title":录音名称
     *  "path":录音存放路径
     *  "addtime":录音上传时间
     */
    public function audio_list(){
        $mid=$this->input->post("mid");
        //从数据库获取录音列表
        $sql = "SELECT id,title,path,addtime FROM fm_program WHERE mid=$mid AND audio_flag=1 ORDER BY addtime DESC";
        $query = $this->db->query($sql);
        $res=$query->result_array();
        foreach($res as &$value){
            $value['path']=base_url().$value['path'];
        }
        $result=array("code"=>0,"message"=>"success","time"=>time(),"data"=>$res);
        echo json_encode($result);
    }

    /**
     *  接口说明：自动（从尚为服务器）获取媒资
     *  接口地址：http://vroad.bbrtv.com/cmradio/index.php?d=android&c=program&m=auto_save_program
     *  参数接收方式：post
     *	接收参数：
     * 	"title": 节目名称
     * 	"thumb": 缩略图
     * 	"path":  节目地址
     * 	"channel_id":   频道id
     * 	"type_id":  节目类型
     * 	返回参数：
     * 	code：返回码 0正确, 大于0 都是错误的
     * 	message：描述信息
     * 	time：时间戳
     *
     */

    public function auto_save_program(){
        $program_list=$this->input->post("program_list");
        $program_list=json_decode($program_list);
        if(!empty($program_list)){
            foreach($program_list as $value){
                $insert['title']=$value("title");
                $insert['thumb']=$value("thumb");
                $insert['path']=$value("path");
                $insert['channle_id']=$value("channel_id");
                $insert['program_time']=$value("program_time");
                //$insert['type_id']=$this->input->post("type_id");
                $insert['mid']=0;
                $insert['audio_flag']=0;
                $insert['addtime']=time();
                $insert['status']=1;
                $this->db->insert ( 'fm_program', $insert );
            }
            $result=array("code"=>000,"message"=>"保存成功");
            echo json_encode($result);
        }else{
            $result=array("code"=>001,"message"=>"获取失败");
            echo json_encode($result);
        }
        /*$insert['title']=$this->input->post("title");
        $insert['thumb']=$this->input->post("thumb");
        $insert['path']=$this->input->post("path");
        $insert['channle_id']=$this->input->post("channel_id");
        $insert['type_id']=$this->input->post("type_id");
        //path不能为空
        if($insert['path']){
            $insert['mid']=0;
            $insert['audio_flag']=0;
            $insert['addtime']=time();
            $insert['status']=1;
            $this->db->insert ( 'fm_program', $insert );
            $result=array("code"=>0,"message"=>"success","time"=>time());
            echo json_encode($result);
        }else{
            $result=array("code"=>0,"message"=>"false","time"=>time());
            echo json_encode($result);
        }*/

    }

    /**
     *  接口说明：获取欧洲杯新闻列表
     *  接口地址：http://vroad.bbrtv.com/cmradio/index.php?d=android&c=program&m=get_news_list
     * 	返回参数：
     * 	code：返回码 0正确, 大于0 都是错误的
     * 	message：描述信息
     * 	time：时间戳
     *  "data":{"new": [{"content": "腾讯体育6月24日讯"}],"old": [{"content": "小组赛阶段总共打进" },{"content": "意大利防线大将均有牌在神腾讯体育6月24日讯"}],}
     *  其中：
     *  "new":表示当前最新的一条新闻
     *  "old":表示旧新闻
     *  "content":新闻详细内容
     */
    public function get_news_list(){
        //从数据库获取录音列表
        $sql = "SELECT content FROM fm_eurocup ORDER BY addtime DESC";
        $query = $this->db->query($sql);
        $res=$query->result_array();
        foreach($res as $key=>$value){
            if($key==0){
                $list['new'][]=$value;
            }else{
                $list['old'][]=$value;
            }
        }
        $result=array("code"=>0,"message"=>"success","time"=>time(),"data"=>$list);
        echo json_encode($result);
    }

    //静态网页，使用js定时器，定时执行程序.
    //http://vroad.bbrtv.com/cmradio/index.php?d=android&c=program&m=get_news_view
    public function get_news_view(){
        $this->load->view("get_news_page");
    }

    //http://vroad.bbrtv.com/cmradio/index.php?d=android&c=program&m=get_news
    public function get_news(){
            $date=date("Ymd",time());
            $url = "http://sports.qq.com/l/isocce/2016eurocup/list.htm";
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $contents = curl_exec($ch);

            //匹配新闻列表链接
            $patter='/<a .*?href="http:\/\/sports.qq.com\/a\/'.$date;
            $pat=$patter.'\/(.*?)".*?>/is';
            /*$pat='/<a .*?href="http:\/\/sports.qq.com\/a\/20160625\/(.*?)".*?>/is';*/
            preg_match_all($pat, $contents, $arr);//匹配内容到arr数组
            curl_close($ch);

            //选择获取第几条链接。
            $con_url="http://sports.qq.com/a/"."$date/".$arr[1][0];
            //echo $con_url;
            $ch2 = curl_init();
            $timeout = 5;
            curl_setopt($ch2, CURLOPT_URL, $con_url);
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch2, CURLOPT_CONNECTTIMEOUT, $timeout);
            $contents_detail = curl_exec($ch2);
            $patter_link='/<link rel="alternate" (.*?) href="(.*?)">/i';
            preg_match_all($patter_link,$contents_detail,$arr_link);
            curl_close($ch2);
            if(empty($arr_link)){
                echo "匹配不到链接";
                exit();
            }else{
                $con_link=$arr_link[2][0];
                //判断是否已经抓取过
                $sql_url="select COUNT(*) as num from  fm_eurocup WHERE url='$con_link'";
                $result_url=$this->db->query($sql_url);
                $url_num=$result_url->row_array();
                if($url_num['num']){
                    echo "链接相同";
                    exit();
                }else{
                    $ch3 = curl_init();
                    $timeout = 5;
                    curl_setopt($ch3, CURLOPT_URL, $con_link);
                    curl_setopt($ch3, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch3, CURLOPT_CONNECTTIMEOUT, $timeout);
                    $contents_final = curl_exec($ch3);

                    $pat2='/<p class="split">.*?<\/p>/ism';
                    preg_match_all($pat2, $contents_final, $arr_final);//匹配内容到arr数组
                    $title=trimall($arr_final[0][0]);
                    $title=preg_replace('/<pclass=\"split\">/si',"",$title); //过滤html标签
                    $title=preg_replace('/<\/p>/si',"",$title); //过滤html标签
                    $str='';
                    foreach($arr_final[0] as $value){
                        $str .=trimall($value); //删除空格和回车;
                    }
                    $str=preg_replace('/<pclass=\"split\">/si',"",$str); //过滤html标签
                    $str=preg_replace('/<\/p>/si',"",$str); //过滤html标签
                    $insert['title']=$title;
                    $insert['content']=$str;
                    $insert['url']=$con_link;
                    $insert['addtime']=time();
                    if(!empty($insert['content'])&&!empty($insert['title'])){
                        $insert_sql="INSERT INTO fm_eurocup (title, content,url, addtime) VALUES ('$insert[title]','$insert[content]','$insert[url]',$insert[addtime])";
                        $this->db->query($insert_sql);
                        echo "采集成功";
                    }

                }

            }

    }


    //定时抓取网页数据存入数据库
    //http://vroad.bbrtv.com/cmradio/index.php?d=android&c=program&m=get_news
    public function get_news_old(){
        $timeout=1468339200;
        //获取当前时间戳
        $timenow=time();
        ignore_user_abort();//关闭浏览器后，继续执行php代码
        set_time_limit(0);//程序执行时间无限制
        $sleep_time = 300;//多长时间执行一次
        $wait_time = 300;//等待时间
        while($timenow<$timeout){
            $date=date("Ymd",time());
            $url = "http://sports.qq.com/l/isocce/2016eurocup/list.htm";
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $contents = curl_exec($ch);

            //匹配新闻列表链接
            $patter='/<a .*?href="http:\/\/sports.qq.com\/a\/'.$date;
            $pat=$patter.'\/(.*?)".*?>/is';
            /*$pat='/<a .*?href="http:\/\/sports.qq.com\/a\/20160625\/(.*?)".*?>/is';*/
            preg_match_all($pat, $contents, $arr);//匹配内容到arr数组
            curl_close($ch);

            //选择获取第几条链接
            $con_url="http://sports.qq.com/a/"."$date/".$arr[1][0];
            //echo $con_url;
            $ch2 = curl_init();
            $timeout = 5;
            curl_setopt($ch2, CURLOPT_URL, $con_url);
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch2, CURLOPT_CONNECTTIMEOUT, $timeout);
            $contents_detail = curl_exec($ch2);
            $patter_link='/<link rel="alternate" (.*?) href="(.*?)">/i';
            preg_match_all($patter_link,$contents_detail,$arr_link);
            curl_close($ch2);
            if(empty($arr_link)){
                sleep($sleep_time);
                //从数据库获取程序是否允许标志
                $sql = "SELECT eurocup_flag FROM fm_eurocup_flag WHERE id=1";
                $query = $this->db->query($sql);
                $res=$query->row_array();
                $timeout=$res['eurocup_flag'];
                continue;
            }
            $con_link=$arr_link[2][0];
            //判断是否已经抓取过
            $sql_url="select url from  fm_eurocup ORDER BY id DESC limit 0,1";
            $result_url=$this->db->query($sql_url);
            $url=$result_url->row_array();
            if($url['url']==$con_link){
                //相同新闻退出
                sleep($sleep_time);
                //从数据库获取程序是否允许标志
                $sql = "SELECT eurocup_flag FROM fm_eurocup_flag WHERE id=1";
                $query = $this->db->query($sql);
                $res=$query->row_array();
                $timeout=$res['eurocup_flag'];
                continue;
            }
            $ch3 = curl_init();
            $timeout = 5;
            curl_setopt($ch3, CURLOPT_URL, $con_link);
            curl_setopt($ch3, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch3, CURLOPT_CONNECTTIMEOUT, $timeout);
            $contents_final = curl_exec($ch3);
            //<meta name="Description" content="C罗一传两射扛全队晋级 近全票获选23日最佳">
            $pat2='/<p class="split">.*?<\/p>/ism';
            preg_match_all($pat2, $contents_final, $arr_final);//匹配内容到arr数组
            $title=trimall($arr_final[0][0]);
            $title=preg_replace('/<pclass=\"split\">/si',"",$title); //过滤html标签
            $title=preg_replace('/<\/p>/si',"",$title); //过滤html标签
            $str='';
            foreach($arr_final[0] as $value){
                $str .=trimall($value); //删除空格和回车;
            }
            $str=preg_replace('/<pclass=\"split\">/si',"",$str); //过滤html标签
            $str=preg_replace('/<\/p>/si',"",$str); //过滤html标签
            $insert['title']=$title;
            $insert['content']=$str;
            $insert['url']=$con_link;
            $insert['addtime']=time();
            if(!empty($insert['content'])&&!empty($insert['title'])){
                $insert_sql="INSERT INTO fm_eurocup (title, content,url, addtime) VALUES ('$insert[title]','$insert[content]','$insert[url]',$insert[addtime])";
            }
            $this->db->query($insert_sql);
            //$this->db->insert ( 'fm_eurocup', $insert );
            sleep($sleep_time);
            //从数据库获取程序是否允许标志
            $sql = "SELECT eurocup_flag FROM fm_eurocup_flag WHERE id=1";
            $query = $this->db->query($sql);
            $res=$query->row_array();
            $timeout=$res['eurocup_flag'];
            }
        exit();
    }














	
	
} // 类结束
