<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 文章 控制器 by tangjian 

class news_title extends CI_Controller
{

    function __construct ()
    {
        parent::__construct();
        
        $this->control = 'news_title';
        $this->baseurl = './index.php?d=weixin2&c=news_title';
        $this->table = 'fly_weixin_news_title';
        $this->list_view = 'news_title_list'; // 列表页
        $this->add_view = 'news_title_add'; // 添加页
    }
    
    // 首页
    public function index ()
    {
        
        $searchsql = '';
        $config['base_url'] = $this->baseurl;
        $content = trim($_REQUEST['content']);
		
        if ($content) {
            $config['base_url'] = "&content=" . rawurlencode($content);
            $searchsql .= " AND title like '%{$content}%'";
        }
		
				
        $data['list'] = array();
        $query = $this->db->query(
                "SELECT COUNT(*) AS num FROM $this->table WHERE 1 $searchsql");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        $this->load->library('pagination');
        $config['total_rows'] = $count['num'];
        $config['per_page'] = $this->per_page;
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links();
        
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
        $sql = "SELECT * FROM $this->table  WHERE 1 $searchsql ORDER BY id DESC limit $offset,20";
        $query = $this->db->query($sql);
        $list = $query->result_array();
        $data['list'] = $list;
        
        $_SESSION['url_forward'] = $config['base_url'] . "&per_page=$offset";
//         $this->load->view('weixin/' . $this->list_view, $data);
        $this->load->view('radio1003/' . $this->list_view, $data);
    }
  
    
	    // 添加
    public function add ()
    {	
  	
        $this->load->view('radio1003/news_title_add.php', $data);
    }
	
	    // 编辑rule
    public function edit ()
    {	
        $id = intval($_GET['id']);
        // 这条信息
        $query = $this->db->get_where($this->table, 'id = ' . $id, 1);
        $value = $query->row_array();     
        $data['value'] = $value;
    	
        $this->load->view('weixin/' . $this->control . '_add', $data);
    }
	
	    //保存 1
    public function save() {
    	
    	$id       = intval($_POST['id']);
    	$rdata = trims($_POST['value']);
        
        if (get_magic_quotes_gpc()) {
			$cdata['content'] = stripslashes($cdata['content']);
		} else {
			$cdata['content'] = $cdata['content'];
		}
		//rulenewsedit

    	if ($rdata['title']=='') {
             show_msg('标题不能为空');
         } 
        
        $rdata['addtime'] = $rdata['addtime'] = time();
        if ($id) { // 修改 ===========       		
	        $this->db->where('id', $id);
	        $query = $this->db->update($this->table, $rdata);
            show_msg('修改成功！', $_SESSION['url_forward']);
        } else { // ===========添加 ===========
           
            $query = $this->db->insert($this->table, $rdata);
            $insert_id = $this->db->insert_id();
         
            show_msg('添加成功！', $_SESSION['url_forward']);
        }   	
    }
	
	public function news_pic(){		
		$titleid = $_GET['titleid'];
		$sql = "SELECT * FROM fly_weixin_news_pic  WHERE newstitle_id=$titleid ORDER BY id DESC ";
        $query = $this->db->query($sql);
        $list = $query->result_array();
        $data['list'] = $list;
        $data['titleid'] = $titleid;
        $_SESSION['url_forward'] = $this->baseurl . "&m=news_pic&titleid=$titleid";
        $this->load->view('weixin/news_title_pic', $data);
	}
	
	public function savepic(){
		$id = intval($_POST['id']);
        $data = trims($_POST['value']);			
		$image_file   =   $data["pic_url"];
		$image_size   =   getimagesize($image_file); 
		$data["width"] = $image_size[0];
		$data["height"] = $image_size[1];
        if ($id) { // 修改 ===========
            $this->db->where('id', $id);
            $query = $this->db->update('fly_weixin_news_pic', $data);			
            echo $data["pic_url"];
        } else { // ===========添加 ===========            
            $query = $this->db->insert('fly_weixin_news_pic', $data);			
            show_msg('添加成功！', $_SESSION['url_forward']);
        }
		
	}
	
	// 删除图片
    public function deletepic()
    {
        $id = $_GET['id'];
        
         if ($id) {			
            $this->db->query("delete from  fly_weixin_news_pic  where id=$id");
			 show_msg('删除成功！', $_SESSION['url_forward']);	
        } 
		show_msg('删除失败！', $_SESSION['url_forward']);
       
    }
	
    // 删除
    public function delete()
    {
        $id = $_GET['id'];
        
         if ($id) {			
            $this->db->query("delete from  $this->table  where id=$id");
			 show_msg('删除成功！', $_SESSION['url_forward']);	
        } 
		show_msg('删除失败！', $_SESSION['url_forward']);
       
    }
}
