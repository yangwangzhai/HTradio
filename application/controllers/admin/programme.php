<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    //节目单管理  控制器 

include 'content.php';

class programme extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'programme';
        $this->baseurl = 'index.php?d=admin&c=programme';
        $this->table = 'fm_programme';
        $this->list_view = 'programme_list';
        $this->add_view = 'programme_add';
    }
    
    // 个人频道（也叫个人节目单）
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
        $config['base_url'] = $this->baseurl .
        "&m=index&catid=$catid&keywords=" . rawurlencode($keywords);
        }
        
        $data['list'] = array();
        $query = $this->db->query(
        "SELECT COUNT(*) AS num FROM $this->table WHERE  $searchsql");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        $this->load->library('pagination');
        
        $config['total_rows'] = $count['num'];
        $config['per_page'] = 20;
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links();
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
        $per_page = $config['per_page'];
        $sql = "SELECT * FROM $this->table WHERE  $searchsql AND status=0 ORDER BY id DESC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['list'] = $query->result_array();
        $data['catid'] = $catid;
        $data['type_id'] = $type_id;
        $data['public_flag'] = 0;

        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }

    //公共频道列表（也叫公共节目单）
    public function public_index(){
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
                $config['base_url'] = $this->baseurl . "&m=public_index&catid=$catid";
            }else{
                $config['base_url'] = $this->baseurl . "&m=public_index&catid=$catid&type_id=$type_id";

                $searchsql .= " AND (type_id = $type_id)";
            }
        } else {
            $searchsql .= " AND (title like '%{$keywords}%' or mid in (SELECT id from fm_member WHERE nickname like '%{$keywords}%'))";
            $config['base_url'] = $this->baseurl .
                "&m=public_index&catid=$catid&keywords=" . rawurlencode($keywords);
        }

        $data['list'] = array();
        $query = $this->db->query(
            "SELECT COUNT(*) AS num FROM $this->table WHERE  $searchsql AND  status=1");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        $this->load->library('pagination');

        $config['total_rows'] = $count['num'];
        $config['per_page'] = 20;
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links();
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
        $per_page = $config['per_page'];
        $sql = "SELECT * FROM $this->table WHERE  $searchsql AND status>=1 ORDER BY id DESC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['list'] = $query->result_array();
        $data['catid'] = $catid;
        $data['type_id'] = $type_id;
        $data['public_flag'] = 1;

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
        foreach($program_types as $program_type){
            $data['program_type'][$program_type['id']] =$program_type['title'];
        }
        $data['public_flag'] = $this->input->get("public_flag");

        $this->load->view('admin/' . $this->add_view, $data);
    }
    
	 // 编辑
    public function edit ()
    {
        $id = intval($_GET['id']);
        $data['flag'] = intval($_GET['flag']);

        // 这条信息
        $query = $this->db->get_where($this->table, 'id = ' . $id, 1);
        $value = $query->row_array();
        $category = get_cache('category');
        $value['catname'] = $category[$value['catid']]['name'];
        $data['value'] = $value;
        
        $data['id'] = $id;
        //获取该频道的节目
        $query_program = $this->db->query("SELECT program_id FROM fm_programme_list WHERE programme_id=$id");
        $result_program = $query_program->result_array();
        if(!empty($result_program)){
            $str_program= '';
            foreach($result_program as $program_value){
                $str_program .= $program_value['program_id'].",";
            }
            $data['str_program'] = substr($str_program,0,strlen($str_program)-1);
        }

        //获取频道列表
        $query = $this->db->query("SELECT * FROM fm_channel");
        $channels = $query->result_array();
        foreach($channels as $channel){
            $data['channel'][$channel['id']] =$channel['title'];
        }

        //获取节目类型列表
        $query = $this->db->query("SELECT * FROM fm_program_type");
        $program_types = $query->result_array();
        foreach($program_types as $program_type){
            $data['program_type'][$program_type['id']] =$program_type['title'];
        }
        //获取标签
        $query_tag = $this->db->query("SELECT tag_name FROM fm_programme_tag WHERE programme_id=$id");
        $result_tag = $query_tag->result_array();
        if(!empty($result_tag)){
            $str_tag= '';
            foreach($result_tag as $tag_value){
                $str_tag .= $tag_value['tag_name'].",";
            }
            $data['tag_name'] = substr($str_tag,0,strlen($str_tag)-1);
        }

        $this->load->view('admin/' . $this->add_view, $data);
    }
	
	
    // 保存 添加和修改都是在这里
    public function save ()
    {
        $id = intval($_POST['id']);
        $data = trims($_POST['value']);
        $list =trims($_POST['list']);
        $tag_name = trims($_POST['tag_name']);
        //因为手机端的缘故，这里需要将1，2对调
        foreach($list as &$value){
            if($value['type_id']==1){
                $value['type_id']=2;
            }elseif($value['type_id']==2){
                $value['type_id']=1;
            }
        }
        if(!empty($tag_name)){
            $tag_name = preg_replace("/(\n)|(\s{1,})|(\t)|(\')|(')|(，)|(\.)|(、)|(\|)/",',',$tag_name);//中文逗号转换成英文
            $tags = explode(",",$tag_name);
        }

        if ($id) { // 修改 ===========
            $this->db->where('id', $id);
            $query = $this->db->update($this->table, $data);

            $this->db->query("delete from fm_programme_list where programme_id=$id");
            foreach($list as  $key=>&$v){
                $v['programme_id']=$id;
                $program_ids[$key]=explode(",",$v['program_id']);
                unset($v['program_id']);
            }

            foreach($program_ids as $program_ids_key=>$program_ids_value){
                foreach($program_ids_value as $program_ids_value_k=>$program_ids_value_v){
                    $insert=array();
                    $insert[$program_ids_key]=$list[$program_ids_key];
                    $insert[$program_ids_key]['program_id']=$program_ids_value_v;
                    $this->db->insert_batch('fm_programme_list',$insert);
                    unset($insert);

                }
            }
            $this->db->query("delete from fm_programme_tag where programme_id=$id");
            if(!empty($tags)){
                foreach($tags as $t){
                    $insert_tag = array();
                    $insert_tag['programme_id'] = $id;
                    $insert_tag['tag_name'] = $t;
                    $insert_tag['addtime'] = time();
                    $this->db->insert('fm_programme_tag',$insert_tag);
                    unset($insert_tag);
                }
            }

			adminlog('修改信息: '.$this->control.' -> '.$id);
            show_msg('修改成功！', $_SESSION['url_forward']);
        } else { // ===========添加 ===========
            $data['addtime'] = time();
            $data['uid'] = $this->uid;
            $public_flag = $this->input->post("public_flag");
            if($public_flag){
                $channel_type = $this->input->post("channel_type");
                if($channel_type==1){
                    $data['status'] = 1;//总节目单（1:在手机客户端人人都可以看见,0:个人节目单，只有创建者能看到）
                }else{
                    $data['status'] = 2;//总节目单（1:在手机客户端人人都可以看见,0:个人节目单，只有创建者能看到）
                    $data['vbd_type'] = $this->input->post("vbd_type");
                }
            }else{
                $data['status'] = 0;//总节目单（1:在手机客户端人人都可以看见,0:个人节目单，只有创建者能看到）
            }

            $query = $this->db->insert($this->table, $data);
            $programme_id=$this->db->insert_id ();;

            if(!empty($list)){
                foreach($list as  $key=>&$v){
                    $v['programme_id']=$programme_id;
                    $program_ids[$key]=explode(",",$v['program_id']);
                    unset($v['program_id']);
                }

                foreach($program_ids as $program_ids_key=>$program_ids_value){
                    foreach($program_ids_value as $program_ids_value_k=>$program_ids_value_v){
                        $insert=array();
                        $insert[$program_ids_key]=$list[$program_ids_key];
                        $insert[$program_ids_key]['program_id']=$program_ids_value_v;
                        $this->db->insert_batch('fm_programme_list',$insert);
                        unset($insert);

                    }
                }
            }
            if(!empty($tags)){
                foreach($tags as $t){
                    $insert_tag = array();
                    $insert_tag['programme_id'] = $programme_id;
                    $insert_tag['tag_name'] = $t;
                    $insert_tag['addtime'] = time();
                    $this->db->insert('fm_programme_tag',$insert_tag);
                    unset($insert_tag);
                }
            }

			adminlog('添加信息: '.$this->control.' -> '.$this->db->insert_id());
            show_msg('添加成功！', $this->baseurl."&m=public_index");
        }
    }


    public function set_status(){
        $publish_flag = $this->input->post("publish_flag");
        $id = $this->input->post("id");
        $sql = "update fm_programme set publish_flag=$publish_flag WHERE id=$id";
        $this->db->query($sql);
        $result = $this->db->affected_rows();
        if($result){
            echo json_encode(1);
        }
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

    //生成节目单下节目列表
    public function getProgramList()
    {
        $ids = explode(',', trim($_GET['ids']));
        $html = '<style>li{height:25px;background:url(./static/admin_img/bg_repx_hd.gif);}span{line-height:25px;}</style>' ;
        $html .= '<ul style="list-style:none;margin:0;padding:0;">';
        foreach ($ids as $val) {
            $html .= '<li><img src="./static/admin_img/audio.png" height="70%"><span>'.getProgramName($val).'</span></li>';
        }
        $html .= '</ul>';
        echo $html;
    }


    public function getTypeList()
    {
        $ids = trims($_GET['ids']);
        $type=trims($_GET['type']);
        $len=trims($_GET['len']);

        if($ids){
            $query = $this->db->query("SELECT id,title FROM fm_program WHERE id in ($ids) order by field(id,$ids)");
            $data['value'] = $query->result_array();
            $data['ids'] = $ids;
        }
        if($type==1){
            $sql = "SELECT id,title FROM fm_program_type WHERE pid=0";
            $query = $this->db->query($sql);
            $list = $query->result_array();
            $data['list']=$list;
            $data['len']=$len;

            $this->load->view('admin/programme_add_program_type',$data);
        }else{
            $sql = "SELECT id,title,pid FROM fm_program_type WHERE 1";
            $query = $this->db->query($sql);
            $list = $query->result_array();
            $tree = array();
            foreach ($list as &$val) {
                if($val['pid'] == 0){
                    $val['lv'] = 0;
                    $tree[] = $val;
                    foreach ($list as &$v) {
                        if ($v[pid] == $val['id']) {
                            $v['lv'] = 1;
                            $tree[] = $v;
                        }
                    }
                }
            }

            $data['list'] = $tree;
            $data['len']=$len;

            $this->load->view('admin/programme_add_program',$data);
        }

        if($type==1){

        }else{

        }
}

    //获取分类下节目列表
    public function getList()
    {
        $id = intval($_GET['id']);
        $sql = "SELECT id,title FROM fm_program WHERE type_id = $id";
        $query = $this->db->query($sql);
        $list = $query->result_array();
        echo json_encode($list);
        
    }

    //获取二级节目分类
    public function getSecondProgramType(){
        $id = intval($_GET['id']);
        $sql = "SELECT id,title FROM fm_program_type WHERE pid = $id";
        $query = $this->db->query($sql);
        $list = $query->result_array();
        echo json_encode($list);
    }




    
}
