<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
include('common.php');   
class Zhubo extends Common
{
	 function __construct ()
    {
        parent::__construct();
		
	}
    // 首页
    public function index ()
    {
		$uid = $this->session->userdata('uid');	
    	$data['mid'] = $mid = $_GET['mid'];

		if(empty($data['mid'])){
			 show_msg('非法参数!', ''); 
		}

		if($uid == $mid){
			header("location: index.php?c=personal");
            exit();
		}
		
        //主播资料
        $sql = "SELECT wechat_id,username,nickname,avatar FROM fm_member WHERE id = $mid";
        $query = $this->db->query($sql);
        $zb = $query->row_array();
        $data['zb']['nickname'] = $zb['nickname'] ? $zb['nickname'] :$zb['username'] ? $zb['username'] : '佚名';
        $data['zb']['avatar'] = $zb['wechat_id'] ? '' : $zb['avatar'];
        $data['is_attention'] = is_attention($uid,$mid);//判断是否收藏

        //TA的节目数
        $sql = "SELECT count(*) as num FROM fm_program WHERE mid = $mid";
        $query = $this->db->query($sql);
        $data['program_num'] = $query->row_array();

        //TA的关注数
        $sql = "SELECT count(*) as num FROM fm_attention WHERE mid = $mid";
        $query = $this->db->query($sql);
        $data['guanzhu_num'] = $query->row_array();

        $sql = "SELECT id,avatar FROM fm_member WHERE id in (SELECT zid FROM fm_attention WHERE mid = $mid ORDER BY addtime DESC) limit 6";
        $query = $this->db->query($sql);
        $data['guanzhu_list'] = $query->result_array();

        //TA的粉丝数
        $sql = "SELECT count(*) as num FROM fm_attention WHERE zid = $mid";
        $query = $this->db->query($sql);
        $data['fans_num'] = $query->row_array();

        $sql = "SELECT id,avatar FROM fm_member WHERE id in (SELECT mid FROM fm_attention WHERE zid = $mid ORDER BY addtime DESC) limit 6";
        $query = $this->db->query($sql);
        $data['fans_list'] = $query->result_array();

        //TA最新的节目单
        $cur_page = $this->input->get('mper_page')?$this->input->get('mper_page'):1;//通过ajax获取当前第几页
       
	    
	   
        $config['base_url'] = 'index.php?c=zhubo&mid='.$mid;
        $query = $this->db->query("SELECT count(*) as num FROM fm_programme WHERE mid = $mid");
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

        $sql = "SELECT id,title,mid,thumb FROM fm_programme where mid = $mid ORDER BY id DESC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['me_list'] = $query->result_array();

        //TA最新的节目
        $cur_page = $this->input->get('per_page')?$this->input->get('per_page'):1;//通过ajax获取当前第几页
       
        $config['base_url'] = 'index.php?c=zhubo&mid='.$mid;
        $query = $this->db->query("SELECT count(*) as num FROM fm_program WHERE mid = $mid");
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
        

        $sql = "SELECT id,title,program_time,playtimes,addtime FROM fm_program WHERE mid = $mid ORDER BY addtime DESC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['program_list'] = $query->result_array();

        
        $this->load->view('zhubo',$data);
    }

    public function program_page() {
        $data['mid'] = $mid = $_GET['mid'];
        $cur_page = $this->input->get('per_page')?$this->input->get('per_page'):1;//通过ajax获取当前第几页
       // var_dump(expression)
        $config['base_url'] = 'index.php?c=zhubo&mid='.$mid;
        $query = $this->db->query("SELECT count(*) as num FROM fm_program WHERE mid = $mid");
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
        $this->load->library('ajax_pagination');
        $this->ajax_pagination->initialize($config);//默认的对象名是类名的小写
        $data['pages'] =$this->ajax_pagination->create_links($cur_page);
        $per_page = $config['per_page'];
        $offset = ($cur_page - 1) * $per_page;

        $sql = "SELECT id,title,path,download_path,program_time,playtimes,addtime FROM fm_program WHERE mid = $mid ORDER BY addtime DESC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['program_list'] = $query->result_array();
        $comment_html = $this->load->view('ajax_page/zhubo_program_list',$data,true);
        echo $comment_html;
    }

    public function programme_page() {
        $data['mid'] = $mid = $_GET['mid'];
        $cur_page = $this->input->get('mper_page')?$this->input->get('mper_page'):1;//通过ajax获取当前第几页
       // var_dump(expression)
        $config['base_url'] = 'index.php?c=zhubo&mid='.$mid;
        $query = $this->db->query("SELECT count(*) as num FROM fm_programme WHERE mid = $mid");
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

        $sql = "SELECT id,title,mid,thumb FROM fm_programme where mid = $mid ORDER BY id DESC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['me_list'] = $query->result_array();
        $comment_html = $this->load->view('ajax_page/zhubo_me_list',$data,true);
        echo $comment_html;
    }

    //收藏的节目单分页
    public function sc_programme_page(){
        $data['mid'] = $mid = $_GET['mid'];
        $cur_page = $this->input->get('mper_page')?$this->input->get('mper_page'):1;//通过ajax获取当前第几页
        // var_dump(expression)
        $config['base_url'] = 'index.php?c=zhubo&m=sc_programme_page&mid='.$mid;
        $query = $this->db->query("SELECT count(DISTINCT(a.programme_id)) as num FROM fm_programme_data a WHERE a.type=1 AND a.mid=$mid");
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

        $sql = "SELECT DISTINCT(a.programme_id),b.title,b.id FROM fm_programme_data a JOIN fm_programme b  WHERE a.programme_id=b.id AND a.type=1 AND a.mid=$mid ORDER by a.addtime DESC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['me_list'] = $query->result_array();
        $comment_html = $this->load->view('ajax_page/zhubo_me_list',$data,true);
        echo $comment_html;
    }

    //全部关注
    public function allAttention() {
        $data['uid'] = $uid = $this->session->userdata('uid'); 
        $data['mid'] = $mid = $_GET['mid'];
        if(empty($data['mid'])){
            show_msg('非法参数!', ''); 
        }
        
        if($uid == $data['mid']){
            
        }
        
        //主播资料
        $sql = "SELECT nickname,avatar FROM fm_member WHERE id = $mid";
        $query = $this->db->query($sql);
        $data['zb'] = $query->row_array();

        $data['is_attention'] = is_attention($uid,$mid);//判断是否收藏

        //TA的节目数
        $sql = "SELECT count(*) as num FROM fm_program WHERE mid = $mid";
        $query = $this->db->query($sql);
        $data['program_num'] = $query->row_array();

        //TA的关注数
        $sql = "SELECT count(*) as num FROM fm_attention WHERE mid = $mid";
        $query = $this->db->query($sql);
        $data['guanzhu_num'] = $query->row_array();

        $sql = "SELECT id,avatar FROM fm_member WHERE id in (SELECT zid FROM fm_attention WHERE mid = $mid ORDER BY addtime DESC) limit 6";
        $query = $this->db->query($sql);
        $data['guanzhu_list'] = $query->result_array();

        //TA的粉丝数
        $sql = "SELECT count(*) as num FROM fm_attention WHERE zid = $mid";
        $query = $this->db->query($sql);
        $data['fans_num'] = $query->row_array();

        $sql = "SELECT id,avatar FROM fm_member WHERE id in (SELECT mid FROM fm_attention WHERE zid = $mid ORDER BY addtime DESC) limit 6";
        $query = $this->db->query($sql);
        $data['fans_list'] = $query->result_array();

        //所有关注列表

        $cur_page = $this->input->get('per_page')?$this->input->get('per_page'):1;//通过ajax获取当前第几页
       // var_dump(expression)
        $config['base_url'] = 'index.php?c=zhubo&m=allattention&mid='.$mid;
        $query = $this->db->query("SELECT count(*) as num FROM fm_attention WHERE mid = $mid");
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

        $sql = "SELECT id,avatar,nickname,sign FROM fm_member WHERE id in (SELECT zid FROM fm_attention WHERE mid = $mid ORDER BY addtime DESC) limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['list'] = $query->result_array();
        $data['title'] = "TA的关注";

        $this->load->view("zhubo_more",$data);
    }

    //全部粉丝列表
    public function allFans() {
        $data['uid'] = $uid = $this->session->userdata('uid'); 
        $data['mid'] = $mid = $_GET['mid'];
        if(empty($data['mid'])){
            show_msg('非法参数!', ''); 
        }
        
        if($uid == $data['mid']){
            
        }
        
        //主播资料
        $sql = "SELECT nickname,avatar FROM fm_member WHERE id = $mid";
        $query = $this->db->query($sql);
        $data['zb'] = $query->row_array();

        $data['is_attention'] = is_attention($uid,$mid);//判断是否收藏

        //TA的节目数
        $sql = "SELECT count(*) as num FROM fm_program WHERE mid = $mid";
        $query = $this->db->query($sql);
        $data['program_num'] = $query->row_array();

        //TA的关注数
        $sql = "SELECT count(*) as num FROM fm_attention WHERE mid = $mid";
        $query = $this->db->query($sql);
        $data['guanzhu_num'] = $query->row_array();

        $sql = "SELECT id,avatar FROM fm_member WHERE id in (SELECT zid FROM fm_attention WHERE mid = $mid ORDER BY addtime DESC) limit 6";
        $query = $this->db->query($sql);
        $data['guanzhu_list'] = $query->result_array();

        //TA的粉丝数
        $sql = "SELECT count(*) as num FROM fm_attention WHERE zid = $mid";
        $query = $this->db->query($sql);
        $data['fans_num'] = $query->row_array();

        $sql = "SELECT id,avatar FROM fm_member WHERE id in (SELECT mid FROM fm_attention WHERE zid = $mid ORDER BY addtime DESC) limit 6";
        $query = $this->db->query($sql);
        $data['fans_list'] = $query->result_array();

        //所有粉丝列表

        $cur_page = $this->input->get('per_page')?$this->input->get('per_page'):1;//通过ajax获取当前第几页
       // var_dump(expression)
        $config['base_url'] = 'index.php?c=zhubo&m=allfans&mid='.$mid;
        $query = $this->db->query("SELECT count(*) as num FROM fm_attention WHERE zid = $mid");
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

        $sql = "SELECT id,avatar,nickname,sign FROM fm_member WHERE id in (SELECT mid FROM fm_attention WHERE zid = $mid ORDER BY addtime DESC) limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['list'] = $query->result_array();
        $data['title'] = "TA的粉丝";

        $this->load->view("zhubo_more",$data);
    }
    
	
	
	
		
		
}
