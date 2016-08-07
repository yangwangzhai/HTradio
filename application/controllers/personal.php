<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
include('common.php');  
class Personal extends Common
{
	 function __construct ()
    {
        parent::__construct();
		
	}
    // 首页
    public function index ()
    {
    	$data['mid'] = $uid = $this->session->userdata('uid');
    	if(!$uid) {
    		header("location:index.php?c=member&m=login");
    		exit();
    	}

    	//主播资料
        $sql = "SELECT nickname,avatar FROM fm_member WHERE id = $uid";
        $query = $this->db->query($sql);
        $data['zb'] = $query->row_array();


        //我的节目数
        $sql = "SELECT count(*) as num FROM fm_program WHERE mid = $uid";
        $query = $this->db->query($sql);
        $data['program_num'] = $query->row_array();

        //我的关注数
        $sql = "SELECT count(*) as num FROM fm_attention WHERE mid = $uid";
        $query = $this->db->query($sql);
        $data['guanzhu_num'] = $query->row_array();

        $sql = "SELECT id,avatar FROM fm_member WHERE id in (SELECT zid FROM fm_attention WHERE mid = $uid ORDER BY addtime DESC) limit 6";
        $query = $this->db->query($sql);
        $data['guanzhu_list'] = $query->result_array();

        //我的粉丝数
        $sql = "SELECT count(*) as num FROM fm_attention WHERE zid = $uid";
        $query = $this->db->query($sql);
        $data['fans_num'] = $query->row_array();

        $sql = "SELECT id,avatar FROM fm_member WHERE id in (SELECT mid FROM fm_attention WHERE zid = $uid ORDER BY addtime DESC) limit 6";
        $query = $this->db->query($sql);
        $data['fans_list'] = $query->result_array();

        //我最新的节目单
        $cur_page = $this->input->get('mper_page')?$this->input->get('mper_page'):1;//通过ajax获取当前第几页


        $config['base_url'] = 'index.php?c=zhubo&mid='.$uid;
        $query = $this->db->query("SELECT count(*) as num FROM fm_programme WHERE mid = $uid");
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

        $sql = "SELECT id,title,mid,thumb FROM fm_programme where mid = $uid ORDER BY id DESC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['me_list'] = $query->result_array();

        //我最新的节目
        $cur_page = $this->input->get('per_page')?$this->input->get('per_page'):1;//通过ajax获取当前第几页
       
        $config['base_url'] = 'index.php?c=zhubo&mid='.$uid;
        $query = $this->db->query("SELECT count(*) as num FROM fm_program WHERE mid = $uid");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        $config['total_rows'] = $count['num'];
        $config['per_page'] = 2;   
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
        

        $sql = "SELECT id,title,path,program_time,playtimes,addtime FROM fm_program WHERE mid = $uid AND audio_flag=0 ORDER BY addtime DESC limit $offset,$per_page";

        $query = $this->db->query($sql);
        $data['program_list'] = $query->result_array();

    	$this->load->view("personal",$data);
    }

    //全部关注
    public function allAttention() {
        $data['uid'] = $uid = $this->session->userdata('uid'); 
        
        //主播资料
        $sql = "SELECT nickname,avatar FROM fm_member WHERE id = $uid";
        $query = $this->db->query($sql);
        $data['zb'] = $query->row_array();


        //TA的节目数
        $sql = "SELECT count(*) as num FROM fm_program WHERE mid = $uid";
        $query = $this->db->query($sql);
        $data['program_num'] = $query->row_array();

        //TA的关注数
        $sql = "SELECT count(*) as num FROM fm_attention WHERE mid = $uid";
        $query = $this->db->query($sql);
        $data['guanzhu_num'] = $query->row_array();

        $sql = "SELECT id,avatar FROM fm_member WHERE id in (SELECT zid FROM fm_attention WHERE mid = $uid ORDER BY addtime DESC) limit 6";
        $query = $this->db->query($sql);
        $data['guanzhu_list'] = $query->result_array();

        //TA的粉丝数
        $sql = "SELECT count(*) as num FROM fm_attention WHERE zid = $uid";
        $query = $this->db->query($sql);
        $data['fans_num'] = $query->row_array();

        $sql = "SELECT id,avatar FROM fm_member WHERE id in (SELECT mid FROM fm_attention WHERE zid = $uid ORDER BY addtime DESC) limit 6";
        $query = $this->db->query($sql);
        $data['fans_list'] = $query->result_array();

        //所有关注列表

        $cur_page = $this->input->get('per_page')?$this->input->get('per_page'):1;//通过ajax获取当前第几页
       // var_dump(expression)
        $config['base_url'] = 'index.php?c=personal&m=allattention';
        $query = $this->db->query("SELECT count(*) as num FROM fm_attention WHERE mid = $uid");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        $config['total_rows'] = $count['num'];
        $config['per_page'] = 1;   
        $config['cur_tag_open'] = '<span class="page-item page-navigator-current">';
        $config['cur_tag_close'] = '</span>';
        $config['prev_link'] = '上一页';
        $config['next_link'] = '下一页';
        $config['first_link'] = '第一页';
        $config['last_link'] = '最后一页';
        $config['use_page_numbers']= true;
        $config['anchor_class']="class='ajax_page page-item'";
        $config['cur_page']=$cur_page;
        $this->load->library('pagination');
        $this->pagination->initialize($config);//默认的对象名是类名的小写
        $data['pages'] =$this->pagination->create_links($cur_page);
        
        $per_page = $config['per_page'];
        $offset = ($cur_page - 1) * $per_page;

        $sql = "SELECT id,avatar,nickname,sign FROM fm_member WHERE id in (SELECT zid FROM fm_attention WHERE mid = $uid ORDER BY addtime DESC) limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['list'] = $query->result_array();
        $data['title'] = "我的关注";

        $this->load->view("personal_more",$data);
    }

    //全部粉丝列表
    public function allFans() {
        $data['uid'] = $uid = $this->session->userdata('uid'); 
        
        
        //主播资料
        $sql = "SELECT nickname,avatar FROM fm_member WHERE id = $uid";
        $query = $this->db->query($sql);
        $data['zb'] = $query->row_array();


        //TA的节目数
        $sql = "SELECT count(*) as num FROM fm_program WHERE mid = $uid";
        $query = $this->db->query($sql);
        $data['program_num'] = $query->row_array();

        //TA的关注数
        $sql = "SELECT count(*) as num FROM fm_attention WHERE mid = $uid";
        $query = $this->db->query($sql);
        $data['guanzhu_num'] = $query->row_array();

        $sql = "SELECT id,avatar FROM fm_member WHERE id in (SELECT zid FROM fm_attention WHERE mid = $uid ORDER BY addtime DESC) limit 6";
        $query = $this->db->query($sql);
        $data['guanzhu_list'] = $query->result_array();

        //TA的粉丝数
        $sql = "SELECT count(*) as num FROM fm_attention WHERE zid = $uid";
        $query = $this->db->query($sql);
        $data['fans_num'] = $query->row_array();

        $sql = "SELECT id,avatar FROM fm_member WHERE id in (SELECT mid FROM fm_attention WHERE zid = $uid ORDER BY addtime DESC) limit 6";
        $query = $this->db->query($sql);
        $data['fans_list'] = $query->result_array();

        //所有粉丝列表

        $cur_page = $this->input->get('per_page')?$this->input->get('per_page'):1;//通过ajax获取当前第几页
       // var_dump(expression)
        $config['base_url'] = 'index.php?c=personal&m=allfans';
        $query = $this->db->query("SELECT count(*) as num FROM fm_attention WHERE zid = $uid");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        
        $config['total_rows'] = $count['num'];
        $config['per_page'] = 1;   
        $config['cur_tag_open'] = '<span class="page-item page-navigator-current">';
        $config['cur_tag_close'] = '</span>';
        $config['prev_link'] = '上一页';
        $config['next_link'] = '下一页';
        $config['first_link'] = '第一页';
        $config['last_link'] = '最后一页';
        $config['use_page_numbers']= true;
        $config['anchor_class']="class='ajax_page page-item'";
        $config['cur_page']=$cur_page;
        $this->load->library('pagination');
        $this->pagination->initialize($config);//默认的对象名是类名的小写
        $data['pages'] =$this->pagination->create_links($cur_page);
        
        $per_page = $config['per_page'];
        $offset = ($cur_page - 1) * $per_page;

        $sql = "SELECT id,avatar,nickname,sign FROM fm_member WHERE id in (SELECT mid FROM fm_attention WHERE zid = $uid ORDER BY addtime DESC) limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['list'] = $query->result_array();
        $data['title'] = "我的粉丝";

        $this->load->view("personal_more",$data);
    }

    public function addProgramme() {
        $uid = $this->session->userdata('uid'); 
        $this->load->view("addProgramme",$data);
    }
}