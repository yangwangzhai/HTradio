<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    //频道管理  控制器 

include 'content.php';

class channel extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'channel';
        $this->baseurl = 'index.php?d=admin&c=channel';
        $this->table = 'fm_channel';
        $this->list_view = 'channel_list';
        $this->add_view = 'channel_add';
        $this->load->model('content_model');
    }

    // 首页
    public function index ()
    {
        $catid = intval($_REQUEST['catid']);
        $keywords = trim($_REQUEST['keywords']);
        $searchsql = '1';
        //         if ($catid) {
        //             $searchsql .= " AND catid=$catid ";
        //         }
        // 是否是查询
        if (empty($keywords)) {
            $config['base_url'] = $this->baseurl . "&m=index&catid=$catid";
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
        $sql = "SELECT * FROM $this->table WHERE  $searchsql ORDER BY id DESC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $list= $query->result_array();
        if(!empty($list)){
            foreach($list as &$value){
                $sql_user = "select username,truename from fm_admin WHERE id=$value[uid]";
                $query_user = $this->db->query($sql_user);
                $result_user = $query_user->row_array();
                if(!empty($result_user)){
                    $value['name'] = $result_user['username'] ? $result_user['username'] : $result_user['truename'];
                }
            }
        }

        $data['catid'] = $catid;
        $data['list'] = $list;

		/**$query = $this->db->query("SELECT * FROM fm_role_group");
        $roles = $query->result_array();
		foreach($roles as $role){
			$data['group'][$role['id']] =$role['role_name'];
		}**/
    
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
        
        $this->load->view('admin/' . $this->add_view, $data);
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
        
        $data['id'] = $id;
        
        $this->load->view('admin/' . $this->add_view, $data);
    }
	
	
    // 保存 添加和修改都是在这里
    public function save ()
    {
        $id = intval($_POST['id']);
        $data = trims($_POST['value']);
        $data['uid'] = $this->uid;

        if($data['title'] == '') {
            show_msg('频道名称不能为空');
        }
        
        if ($id) { // 修改 ===========
            $this->db->where('id', $id);
            $query = $this->db->update($this->table, $data);
			adminlog('修改信息: '.$this->control.' -> '.$id);
            show_msg('修改成功！', $_SESSION['url_forward']);
        } else { // ===========添加 ===========
            $data['addtime'] = time();
            $query = $this->db->insert($this->table, $data);
			adminlog('添加信息: '.$this->control.' -> '.$this->db->insert_id());
            show_msg('添加成功！', $_SESSION['url_forward']);
        }
    }

    public function set_status(){
        $status = $this->input->post("status");
        $id = $this->input->post("id");
        $sql = "update fm_channel set status=$status WHERE id=$id";
        $this->db->query($sql);
        $result = $this->db->affected_rows();
        if($result){
            echo json_encode(1);
        }
    }

    //直播频道列表
    public function live_channel_list(){
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
        $data['list'] = $query->result_array();

        $_SESSION['url_forward'] = 'index.php?d=admin&c=channel&m=live_channel_list' . "&per_page=$offset";
        $this->load->view('admin/live_channel_list', $data);
    }

    public function live_channel_add(){
        $this->load->view('admin/live_channel_add');
    }

    public function live_channel_edit(){
        $id = intval($_GET['id']);
        // 这条信息
        $query = $this->db->get_where("fm_live_channel", 'id = ' . $id, 1);
        $value = $query->row_array();
        $category = get_cache('category');
        $data['value'] = $value;
        $data['id'] = $id;

        $this->load->view('admin/live_channel_add',$data);
    }

    public function live_channel_save(){
        $id = intval($_POST['id']);
        $data = trims($_POST['value']);
        $_SESSION['url_forward'] = 'index.php?d=admin&c=channel&m=live_channel_list';
        if($data['title'] == '') {
            show_msg('频道名称不能为空');
        }

        if ($id) { // 修改 ===========
            $this->db->where('id', $id);
            $query = $this->content_model->update2($id,"fm_live_channel", $data);
            adminlog('修改信息: '.$this->control.' -> '.$id);
            show_msg('修改成功！', $_SESSION['url_forward']);
        } else { // ===========添加 ===========
            $query = $this->content_model->db_insert_table("fm_live_channel", $data);
            adminlog('添加信息: '.$this->control.' -> '.$this->db->insert_id());
            show_msg('添加成功！', $_SESSION['url_forward']);
        }
    }

    public function live_channel_delete(){
        $id = $_GET['id'];
        $_SESSION['url_forward'] = 'index.php?d=admin&c=channel&m=live_channel_list';
        if ($id) {
            $this->db->query("delete from fm_live_channel where id=$id");
        } else {
            if(empty($_POST['delete'])){
                show_msg('请选择操作项！', $_SESSION['url_forward']);
            }
            $ids = implode(",", $_POST['delete']);
            $this->db->query("delete from fm_live_channel where id in ($ids)");
        }
        adminlog('删除信息: '.$this->control.' -> '.$id.$ids);
        show_msg('删除成功！', $_SESSION['url_forward']);
    }
















    
    
}



