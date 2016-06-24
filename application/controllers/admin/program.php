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
        //if (empty($keywords)) {
            if (empty($type_id)) {
                $config['base_url'] = $this->baseurl . "&m=index&catid=$catid";  
            }else{
                $config['base_url'] = $this->baseurl . "&m=index&catid=$catid&type_id=$type_id"; 
                
                $searchsql .= " AND (type_id = $type_id)"; 
            }
        //} else {
        $searchsql .= " AND (title like '%{$keywords}%' or mid in (SELECT id from fm_member WHERE nickname like '%{$keywords}%'))";
        $config['base_url'] = $config['base_url'] .
        "&keywords=" . rawurlencode($keywords);
        //}
        
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
        $sql = "SELECT * FROM $this->table WHERE  $searchsql ORDER BY show_homepage DESC,hot DESC,id DESC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['list'] = $query->result_array();
        $data['catid'] = $catid;
        $data['type_id'] = $type_id;
		

		$query = $this->db->query("SELECT * FROM fm_program_type");
        $program_types = $query->result_array();
		foreach($program_types as $program_type){
			$data['program_type'][$program_type['id']] =$program_type['title'];
		}
        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
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
}

