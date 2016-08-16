<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
class Search extends CI_Controller
{
	 function __construct ()
    {
        parent::__construct();
		
	}
    // 首页
    public function index ()
    {
        $data['uid'] = $this->session->userdata('uid');
        $data['keyword'] = $keyword = trim($_GET['keyword']);
        //获取节目单
        $cur_page = $this->input->get('mper_page')?$this->input->get('mper_page'):1;//通过ajax获取当前第几页
        $config['base_url'] = 'index.php?c=search&keyword='.$keyword;
        $query = $this->db->query("SELECT count(*) as num FROM fm_programme WHERE title like '%$keyword%' AND publish_flag=1");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        $config['total_rows'] = $count['num'];
        $config['per_page'] = 8;
        $config['cur_tag_open'] = '<span class="page-item page-navigator-current">';
        $config['cur_tag_close'] = '</span>';
        $config['prev_link'] = '上一页';
        $config['next_link'] = '下一页';
        $config['first_link'] = '第一页';
        $config['last_link'] = '最后一页';
        $config['use_page_numbers']= true;
        $config['anchor_class']="class='ajax_mpage page-item'";
        $config['cur_page']=$cur_page;
        $this->load->library('pagination');
        $this->pagination->initialize($config);//默认的对象名是类名的小写
        $data['mpages'] =$this->pagination->create_links($cur_page);
        $per_page = $config['per_page'];
        $offset = ($cur_page - 1) * $per_page;
        $sql = "SELECT id,title,mid,thumb FROM fm_programme WHERE title like '%$keyword%' AND publish_flag=1 ORDER BY id DESC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['me_list'] = $query->result_array();

        //获取节目
        $cur_page = $this->input->get('per_page')?$this->input->get('per_page'):1;//通过ajax获取当前第几页
        $config['base_url'] = 'index.php?c=search&keyword='.$keyword;
        $query = $this->db->query("SELECT count(*) as num FROM fm_program WHERE title like '%$keyword%'");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        $config['total_rows'] = $count['num'];
        $config['per_page'] = 10;
        $config['cur_tag_open'] = '<span class="page-item page-navigator-current">';
        $config['cur_tag_close'] = '</span>';
        $config['prev_link'] = '上一页';
        $config['next_link'] = '下一页';
        $config['first_link'] = '第一页';
        $config['last_link'] = '最后一页';
        $config['use_page_numbers']= true;
        $config['anchor_class']="class='ajax_fpage page-item' data-id=2 ";
        $config['cur_page']=$cur_page;
        $this->load->library('pagination');
        $this->pagination->initialize($config);//默认的对象名是类名的小写
        $data['pages'] =$this->pagination->create_links($cur_page);
        $per_page = $config['per_page'];
        $offset = ($cur_page - 1) * $per_page;
        $sql = "SELECT id,title,path,download_path,program_time,playtimes,addtime FROM fm_program WHERE title like '%$keyword%' AND status=1  ORDER BY addtime DESC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['program_list'] = $query->result_array();

        //获取用户
        $sql = "SELECT id,nickname,sign,avatar FROM fm_member WHERE nickname like '%$keyword%'";
        $query = $this->db->query($sql);
        $data['member_list'] = $query->result_array();

    	$this->load->view("search",$data);
    }

    public function programme_page(){
        $data['keyword'] = $keyword = $_GET['keyword'];
        $cur_page = $this->input->get('mper_page')?$this->input->get('mper_page'):1;//通过ajax获取当前第几页
        // var_dump(expression)
        $config['base_url'] = 'index.php?c=search&keyword='.$keyword;
        $query = $this->db->query("SELECT count(*) as num FROM fm_programme WHERE title like '%$keyword%' AND publish_flag=1");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        $config['total_rows'] = $count['num'];
        $config['per_page'] = 8;
        $config['cur_tag_open'] = '<span class="page-item page-navigator-current">';
        $config['cur_tag_close'] = '</span>';
        $config['prev_link'] = '上一页';
        $config['next_link'] = '下一页';
        $config['first_link'] = '第一页';
        $config['last_link'] = '最后一页';
        $config['use_page_numbers']= true;
        $config['anchor_class']="class='ajax_mpage page-item'";
        $config['cur_page']=$cur_page;
        $this->load->library('ajax_pagination');
        $this->ajax_pagination->initialize($config);//默认的对象名是类名的小写
        $data['mpages'] =$this->ajax_pagination->create_links($cur_page);
        $per_page = $config['per_page'];
        $offset = ($cur_page - 1) * $per_page;

        $sql = "SELECT id,title,mid,thumb FROM fm_programme WHERE title like '%$keyword%' AND publish_flag=1 ORDER BY id DESC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['me_list'] = $query->result_array();
        $comment_html = $this->load->view('ajax_page/zhubo_me_list',$data,true);
        echo $comment_html;
    }

    public function program_page(){
        $data['keyword'] = $keyword = $_GET['keyword'];
        $cur_page = $this->input->get('per_page')?$this->input->get('per_page'):1;//通过ajax获取当前第几页
        // var_dump(expression)
        $config['base_url'] = 'index.php?c=search&keyword='.$keyword;
        $query = $this->db->query("SELECT count(*) as num FROM fm_program WHERE title like '%$keyword%'");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        $config['total_rows'] = $count['num'];
        $config['per_page'] = 10;
        $config['cur_tag_open'] = '<span class="page-item page-navigator-current">';
        $config['cur_tag_close'] = '</span>';
        $config['prev_link'] = '上一页';
        $config['next_link'] = '下一页';
        $config['first_link'] = '第一页';
        $config['last_link'] = '最后一页';
        $config['use_page_numbers']= true;
        $config['anchor_class']="class='ajax_fpage page-item' data-id=2 ";
        $config['cur_page']=$cur_page;
        $this->load->library('ajax_pagination');
        $this->ajax_pagination->initialize($config);//默认的对象名是类名的小写
        $data['pages'] =$this->ajax_pagination->create_links($cur_page);
        $per_page = $config['per_page'];
        $offset = ($cur_page - 1) * $per_page;

        $sql = "SELECT id,title,path,download_path,program_time,playtimes,addtime FROM fm_program WHERE title like '%$keyword%' AND status=1  ORDER BY addtime DESC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['program_list'] = $query->result_array();
        $comment_html = $this->load->view('ajax_page/zhubo_program_list',$data,true);
        echo $comment_html;
    }










}