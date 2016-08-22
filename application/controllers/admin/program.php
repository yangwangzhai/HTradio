<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    //节目管理  控制器 

include 'content.php';

class program extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'program';
        $this->baseurl = 'index.php?d=admin&c=program';
        $this->table = 'fm_program';
        $this->list_view = 'program_list';
        $this->add_view = 'program_add';
		$this->load->model('content_model');
    }

    public function ceshi(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://video.bbrtv.com/api/ziyunServices.php?access_token=wudngbwvzkdndjua&action=getContentList&itemId=35&page=1&per_page=150");
        //curl_setopt($ch, CURLOPT_URL, "http://video.bbrtv.com/api/ziyunServices.php?access_token=wudngbwvzkdndjua&action=getContentDetail&id=31396");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output=curl_exec($ch);
        curl_close($ch);
        $result=json_decode($output,true);
        echo "<pre>";
        print_r($result);
        echo "<pre/>";
        exit;
    }


    //采集数据
    public function caiji(){
        $insert=array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://video.bbrtv.com/api/ziyunServices.php?access_token=wudngbwvzkdndjua&action=getContentList&itemId=35&page=1&per_page=150");
        //curl_setopt($ch, CURLOPT_URL, "http://video.bbrtv.com/api/ziyunServices.php?access_token=wudngbwvzkdndjua&action=getContentDetail&id=31396");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output=curl_exec($ch);
        curl_close($ch);
        $result=json_decode($output,true);
        foreach($result['content_lists'] as $res_key=>$res_value){
            $insert['title']=$res_value['title'];
            $insert['addtime']=strtotime("$res_value[created]");
            $insert['channel_id']=19;
            $insert['mid']=607;
            $insert['status']=1;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://video.bbrtv.com/api/ziyunServices.php?access_token=wudngbwvzkdndjua&action=getContentDetail&id=$res_value[id]");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $out=curl_exec($ch);
            curl_close($ch);
            $detail=json_decode($out,true);
            if(!empty($detail)){
                $insert['path']=$detail['content_detail']['play_url']['stream'][0]['streamURL'];
            }
            //插入数据库
            $this->content_model->db_insert_table("fm_program",$insert);

        }

    }

    // 首页
    public function index ()
    {
        $catid = intval($_REQUEST['catid']);
        $keywords = trim($_REQUEST['keywords']);
        $type_id = trim($_REQUEST['type_id']);
        $searchsql = '1';
        //         if ($catid) {
        //             $searchsql .= " AND catid=$catid ";
        //         }
        // 是否是查询
        if (empty($keywords)) {
            if (empty($type_id)) {
                $config['base_url'] = $this->baseurl . "&m=index&catid=$catid";  
            }else{
                $config['base_url'] = $this->baseurl . "&m=index&catid=$catid&type_id=$type_id"; 
                
                $searchsql .= " AND (type_id = $type_id)"; 
            }
        } else {
        $searchsql .= " AND (title like '%{$keywords}%' or mid in (SELECT id from fm_member WHERE nickname like '%{$keywords}%'))";
        $config['base_url'] = $config['base_url'] .
        "&keywords=" . rawurlencode($keywords);
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
	//	print_r( $data['pages']);exit;
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
        $per_page = $config['per_page'];
        $sql = "SELECT id,thumb,title,mid,playtimes,path,download_path,addtime,status FROM $this->table WHERE  $searchsql ORDER BY addtime DESC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['list'] = $query->result_array();
        $data['catid'] = $catid;
        $data['type_id'] = $type_id;
		foreach($data['list'] as $list_key=>$list_value){
            $result = $this->content_model->get_column("programme_id","fm_programme_list","program_id=$list_value[id]");
            if(!empty($result)){
                $str = '';
                $res = array();
                foreach($result as $value){
                    $title = $this->content_model->get_column2("title","fm_programme","id=$value[programme_id] AND status=1 AND publish_flag=1");
                    if(!empty($title)){
                        $str .=$title['title'].',';
                        $res[] = $value['programme_id'];
                    }
                }
                $data['list'][$list_key]['channel_name'] = substr($str,0,strlen($str)-1);
                $data['list'][$list_key]['channel_id'] = $res;
            }


        }

		$query = $this->db->query("SELECT * FROM fm_program_type");
        $program_types = $query->result_array();
		foreach($program_types as $program_type){
			$data['program_type'][$program_type['id']] =$program_type['title'];
		}
        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        //获取所有的公共频道
        $data['public_channel_list'] = $this->content_model->get_column("id,title","fm_programme","status=1 AND publish_flag=1");
        
        $this->load->view('admin/' . $this->list_view, $data);
    }
	
	
	// 添加
    public function add ()
    {
		$value['catid'] = intval($_REQUEST['catid']);
        $category = get_cache('category');
        $value['catname'] = $category[$value['catid']]['name'];
        $data['value'] = $value;
       
        //获取频道列表
        $query = $this->db->query("SELECT * FROM fm_channel");
        $channels = $query->result_array();
        foreach($channels as $channel){
            $data['channel'][$channel['id']] =$channel['title'];
        }

        //获取节目类型列表
        $query = $this->db->query("SELECT * FROM fm_program_type");   
        $program_types = $query->result_array();
        
            $data['program_types'] =$program_types;
        
       
        $this->load->view('admin/' . $this->add_view, $data);
    }
	
	
	function prog(){
		
		
		
		
		}
    
	 // 编辑
    public function edit ()
    {
        $id = intval($_GET['id']);
        
		
        // 这条信息
        $query = $this->db->get_where($this->table, 'id = ' . $id, 1);
        $value = $query->row_array();
        $category = get_cache('category');
        $value['catname'] = $category[$value['catid']]['name'];
        $data['value'] = $value;
		
        //print_r($value);exit;
        $data['id'] = $id;

        //获取频道列表
        $query = $this->db->query("SELECT * FROM fm_channel");
        $channels = $query->result_array();
        foreach($channels as $channel){
            $data['channel'][$channel['id']] =$channel['title'];
        }

        //获取节目类型列表
        $query = $this->db->query("SELECT * FROM fm_program_type");
        $program_types = $query->result_array();
                  
				  //判断是否二级分类	
                  foreach ($program_types  as $k => $v) {
					if($value['type_id']==$v['id']){
					$pid=$v['pid'];
					}
					if($value['type_id']==$v['pid']){
						$pid=$v['pid'];;
						}
			     }
		                    
		 $data['pid']=$pid;
         $data['program_types'] =$program_types;
        
        $this->load->view('admin/' . $this->add_view, $data);
    }
	
	
    // 保存 添加和修改都是在这里
    public function save ()
    {
        $id = intval($_POST['id']);
        $data = trims($_POST['value']);
		$type= trims($_POST['type']);
		
        if(empty($data['type_id'])){
		   $data['type_id']=$type;
		}
		
        if ($id) { // 修改 ===========
            $this->db->where('id', $id);
            $query = $this->db->update($this->table, $data);
			adminlog('修改信息: '.$this->control.' -> '.$id);
            show_msg('修改成功！', $_SESSION['url_forward']);
        } else { // ===========添加 ===========
            $data['addtime'] = time();
			$data['status'] = 1;
            $query = $this->db->insert($this->table, $data);
			adminlog('添加信息: '.$this->control.' -> '.$this->db->insert_id());
			if(isset($_POST['add_too']) && $_POST['add_too']==1){
				show_msg('添加成功！', 'index.php?d=admin&c=program&m=add');
			}else{
				show_msg('添加成功！', $_SESSION['url_forward']);
			}
        }
    }
	
	public function save_push(){
        $value = $this->input->post("value");
        $insert['program_id'] = $this->input->post("program_id");
        $insert['type_id'] = 1;
        //存入fm_programme_list表
        if(!empty($value)){
            foreach($value as $k=>$v){
                //查找是否已经存在
                $num = $this->content_model->db_counts("fm_programme_list","program_id=$insert[program_id] AND programme_id=$k");
                if($num){
                    continue;
                }else{
                    $insert['programme_id'] = $k;
                    $this->content_model->db_insert_table("fm_programme_list",$insert);
                    show_msg('推送成功！', 'index.php?d=admin&c=program&m=index');
                }
            }
        }else{
            show_msg('请选择频道！', 'index.php?d=admin&c=program&m=index');
        }

    }
	  // 删除
    public function delete ()
    {
		
        $id = $_GET['id'];
        $olg = "删除信息";
        if ($id) {	
			
			$query = $this->db->query("SELECT * FROM $this->table WHERE id=$id limit 1");
        	$value = $query->row_array();
						
			$this->db->delete($this->table, array('id' => $id));
			//删除文件
			delfile($value['thumb']);
			delfile($value['path']);
        } else {
			if(empty($_POST['delete'])){
				 show_msg('请选择操作项！', $_SESSION['url_forward']);
			}
            $ids = implode(",", $_POST['delete']);
			$sql = "";			
			if($_POST['del']){
				$sql = "delete from $this->table where id in ($ids)";
				foreach($_POST['delete'] as $v){
					$query = $this->db->query("SELECT thumb,path FROM $this->table WHERE id=$v limit 1");
        			$value = $query->row_array();
					//删除文件
					delfile($value['thumb']);
					delfile($value['path']);
				}
			}else if($_POST['tj']){
				$olg = "推荐节目";
				$sql = "UPDATE  $this->table SET hot=1 where id in ($ids)";
			}else if($_POST['qxtj']){
				$olg = "取消推荐节目";
				$sql = "UPDATE  $this->table SET hot=0 where id in ($ids)";
			}else if($_POST['zd']){
				$olg = "置顶节目";
				$sql = "UPDATE  $this->table SET show_homepage=1 where id in ($ids)";
			}else if($_POST['qxzd']){
				$olg = "取消置顶节目";
				$sql = "UPDATE  $this->table SET show_homepage=0 where id in ($ids)";
			}
			
            $this->db->query($sql);
        }
        adminlog($log . ': '.$this->control.' -> '.$id.$ids);
        show_msg($olg .'成功！', $_SESSION['url_forward']);
    }

    //设置在首页图片轮播推荐显示
    public function showInHomePage ()
    {
        $id = intval($_GET['id']);
        $show_homepage = intval($_GET['show_homepage']);
    
        if ($id && strlen($show_homepage)) {
            $this->db->query("update $this->table set show_homepage='$show_homepage' where id='$id' limit 1");
            echo $id;
            exit;
        }
        echo -1;
    }
	
    public function updateStatus ()
    {
        $id = intval($_GET['id']);
        $status = intval($_GET['status']);
        $field = $_GET['field'];
		if($status == 0){
			$status = 1;
		}else if($status == 1){
			$status = 0;
		}
	
        if ($id && strlen($field)) {
            $this->db->query("update $this->table set `$field`=$status where id='$id' limit 1");
            echo $id ;
            exit;
        }
        echo -1;
    }
	
	
	
	
	 // 二级分类数据
    
	public function nextbox(){
		
		 $pid = intval($_GET['id']);
		 $program_types=array();
		 if($pid!=0){
		 $query = $this->db->query("SELECT * FROM fm_program_type where `pid`=$pid");
		 
		 $program_types = $query->result_array();
		  
		 }
		echo json_encode($program_types);
		}
	
    //获取节目详情
	function getProgramInfo(){
		$id = $_GET['id'];
		$query = $this->db->get_where('fm_program', array('id' => $id), 1);
		$data = $query->row_array();		
		$this->load->view('admin/program_info', $data);
	}

    public function collect_program_view(){
        date_default_timezone_set('PRC');//设置北京时间

        $catid = intval($_REQUEST['catid']);
        $keywords = trim($_REQUEST['keywords']);
        $searchsql = '1';
        //         if ($catid) {
        //             $searchsql .= " AND catid=$catid ";
        //         }
        // 是否是查询
        if (empty($keywords)) {
            $config['base_url'] = $this->baseurl . "&m=collect_program_view&catid=$catid";
        } else {
            $searchsql .= " AND roel_name like '%{$keywords}%'";
            $config['base_url'] = $this->baseurl .
                "&m=collect_program_view&catid=$catid&keywords=" . rawurlencode($keywords);
        }

        $data['list'] = array();
        $query = $this->db->query(
            "SELECT COUNT(*) AS num FROM fm_collect_record WHERE  $searchsql");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        $this->load->library('pagination');

        $config['total_rows'] = $count['num'];
        $config['per_page'] = 20;
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links();
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
        $per_page = $config['per_page'];
        $sql = "SELECT * FROM fm_collect_record WHERE  $searchsql ORDER BY id DESC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['list'] = $query->result_array();
        $data['catid'] = $catid;


        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        $this->load->view("admin/collect_program_view",$data);
    }

    public function collect_program()
    {
        date_default_timezone_set('PRC');//设置北京时间
        $channel_id = $this->input->post("channel_id");
        $collect_num = $this->input->post("collect_num");

        $insert = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://video.bbrtv.com/api/ziyunServices.php?access_token=wudngbwvzkdndjua&action=getContentList&itemId=$channel_id&page=1&per_page=$collect_num");
        //curl_setopt($ch, CURLOPT_URL, "http://video.bbrtv.com/api/ziyunServices.php?access_token=wudngbwvzkdndjua&action=getContentDetail&id=31396");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($output, true);
        if(!empty($result['content_lists'])){
            foreach ($result['content_lists'] as $res_key => $res_value) {
                $insert['title'] = $res_value['title'];
                $insert['addtime'] = strtotime("$res_value[created]");
                $insert['channel_id'] = change_channel_id($channel_id);
                $insert['mid'] = $this->uid;
                $insert['status'] = 1;
                $insert['type_id'] = 86;//未分类的id为 86
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://video.bbrtv.com/api/ziyunServices.php?access_token=wudngbwvzkdndjua&action=getContentDetail&id=$res_value[id]");
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $out = curl_exec($ch);
                curl_close($ch);
                $detail = json_decode($out, true);
                if (!empty($detail)) {
                    $insert['path'] = $detail['content_detail']['play_url']['stream'][0]['streamURL'];
                    $insert['download_path'] = $detail['content_detail']['play_url']['stream'][0]['downLoadUrl'];
                    //检查是否已经存在该条记录，防止重复插入
                    $num = $this->content_model->db_counts("fm_program","path='$insert[path]'");
                    if($num){
                        continue;
                    }else{
                        //插入数据库
                        $res = $this->content_model->db_insert_table("fm_program", $insert);
                        if($res){
                            $title = substr($res_value['title'],0,strrpos($res_value['title'],'_'));//去掉后面的时间
                            //查看fm_programme是否有以$title命名的节目单
                            $p_id = $this->content_model->get_column2("id","fm_programme","title='$title'");
                            if($p_id['id']){
                                $p_insert['programme_id'] = $p_id['id'];
                                $p_insert['type_id'] = 1;
                                $p_insert['program_id'] = $res;
                                $this->content_model->db_insert_table("fm_programme_list", $p_insert);
                            }else{
                                $me_insert['status'] = 0;
                                $me_insert['vbd_type'] = 0;
                                $me_insert['publish_flag'] = 1;
                                $me_insert['title'] = $title;
                                $me_insert['mid'] = 0;
                                $me_insert['uid'] = $this->uid;
                                $me_insert['addtime'] = time();
                                $programme_id = $this->content_model->db_insert_table("fm_programme", $me_insert);
                                if($programme_id){
                                    $p_insert['programme_id'] = $programme_id;
                                    $p_insert['type_id'] = 1;
                                    $p_insert['program_id'] = $res;
                                    $this->content_model->db_insert_table("fm_programme_list", $p_insert);
                                }
                            }
                        }
                    }
                }
            }
            if($res){
                $insert_record['uid'] = $this->uid;
                $insert_record['collect_channel_id'] = change_channel_id($channel_id);
                $insert_record['collect_num'] = $collect_num;
                $insert_record['addtime'] = time();
                $this->content_model->db_insert_table("fm_collect_record", $insert_record);
                show_msg('采集成功！', 'index.php?d=admin&c=program&m=collect_program_view');
            }else{
                show_msg('采集成功！', 'index.php?d=admin&c=program&m=collect_program_view');
            }

        }else{
                show_msg('暂时没有数据！', 'index.php?d=admin&c=program&m=collect_program_view');
            }





    }


    //异步删除推送
    public function delete_push(){
        $programme_id = $this->input->post("programme_id");
        $program_id = $this->input->post("program_id");
        $affacted = $this->db->delete("fm_programme_list", array('programme_id' => $programme_id,'program_id'=>$program_id));
        if($affacted){
            echo json_encode($affacted);
        }else{
            echo json_encode(0);
        }

    }







}

