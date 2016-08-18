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
        //我收藏的节目单
        $sql = "SELECT count(DISTINCT(a.programme_id)) as num FROM fm_programme_data a WHERE a.type=1 AND a.mid=$uid";
        $query = $this->db->query($sql);
        $data['sc_num'] = $query->row_array();
        $sql = "SELECT DISTINCT(a.programme_id),b.title FROM fm_programme_data a JOIN fm_programme b  WHERE a.programme_id=b.id AND a.type=1 AND a.mid=$uid ORDER by a.addtime DESC limit 0,3";
        $query = $this->db->query($sql);
        $data['sc_list'] = $query->result_array();
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
        

        $sql = "SELECT id,title,path,download_path,program_time,playtimes,addtime FROM fm_program WHERE mid = $uid  ORDER BY addtime DESC limit $offset,$per_page";

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
        //收藏的节目单
        $sql = "SELECT count(DISTINCT(a.programme_id)) as num FROM fm_programme_data a WHERE a.type=1 AND a.mid=$uid";
        $query = $this->db->query($sql);
        $data['sc_num'] = $query->row_array();
        $sql = "SELECT DISTINCT(a.programme_id),b.title FROM fm_programme_data a JOIN fm_programme b  WHERE a.programme_id=b.id AND a.type=1 AND a.mid=$uid ORDER by a.addtime DESC limit 0,3";
        $query = $this->db->query($sql);
        $data['sc_list'] = $query->result_array();
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
        $data['list'] = $list = $query->result_array();
        $data['title'] = "我的关注";
        //获取私信内容列表
        foreach($list as $value){
            $sql_message = "select from_uid,to_uid,title,addtime from fm_message WHERE (from_uid=$value[id] AND to_uid=$uid) OR (from_uid=$uid AND to_uid=$value[id]) ORDER BY addtime ASC";
            $query_message = $this->db->query($sql_message);
            $data['message'] = $query_message->result_array();
        }

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
        //收藏的节目单
        $sql = "SELECT count(DISTINCT(a.programme_id)) as num FROM fm_programme_data a WHERE a.type=1 AND a.mid=$uid";
        $query = $this->db->query($sql);
        $data['sc_num'] = $query->row_array();
        $sql = "SELECT DISTINCT(a.programme_id),b.title FROM fm_programme_data a JOIN fm_programme b  WHERE a.programme_id=b.id AND a.type=1 AND a.mid=$uid ORDER by a.addtime DESC limit 0,3";
        $query = $this->db->query($sql);
        $data['sc_list'] = $query->result_array();
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
        $data['list'] = $list = $query->result_array();
        $data['title'] = "我的粉丝";
        
        //获取私信内容列表
        foreach($list as $value){
            $sql_message = "select from_uid,to_uid,title,addtime from fm_message WHERE (from_uid=$value[id] AND to_uid=$uid) OR (from_uid=$uid AND to_uid=$value[id]) ORDER BY addtime ASC";
            $query_message = $this->db->query($sql_message);
            $data['message'] = $query_message->result_array();
        }

        $this->load->view("personal_more",$data);
    }

    //所有收藏节目的列表
    public function allsc(){
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
        //收藏的节目单
        $sql = "SELECT count(DISTINCT(a.programme_id)) as num FROM fm_programme_data a WHERE a.type=1 AND a.mid=$uid";
        $query = $this->db->query($sql);
        $data['sc_num'] = $query->row_array();
        $sql = "SELECT DISTINCT(a.programme_id),b.title FROM fm_programme_data a JOIN fm_programme b  WHERE a.programme_id=b.id AND a.type=1 AND a.mid=$uid ORDER by a.addtime DESC limit 0,3";
        $query = $this->db->query($sql);
        $data['sc_list'] = $query->result_array();
        //所有收藏节目单列表
        $cur_page = $this->input->get('mper_page')?$this->input->get('mper_page'):1;//通过ajax获取当前第几页
        $config['base_url'] = 'index.php?c=zhubo&m=sc_programme_page&mid='.$uid;
        $query = $this->db->query("SELECT count(DISTINCT(a.programme_id)) as num FROM fm_programme_data a WHERE a.type=1 AND a.mid=$uid");
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
        $sql = "SELECT DISTINCT(a.programme_id),b.title,b.id FROM fm_programme_data a JOIN fm_programme b  WHERE a.programme_id=b.id AND a.type=1 AND a.mid=$uid ORDER by a.addtime DESC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['me_list'] = $query->result_array();

        $this->load->view("personal_sc_more",$data);
    }

    public function addProgramme() {
        $uid = $this->session->userdata('uid'); 
        $this->load->view("addProgramme",$data);
    }

    public function save_talk(){
        $insert['from_uid'] = $this->input->post("to_uid");
        $insert['to_uid'] = $this->input->post("from_uid");
        $insert['title'] = $this->input->post("message");
        //$insert['addtime'] = $this->input->post("date");
        $addtime = $this->input->post("date");
        $insert['addtime'] = strtotime($addtime);
        $insert['status'] = 1;
        $this->db->insert("fm_message",$insert);

    }

    //异步删除自己上传的节目
    public function delete_personal_progarm(){
        $id = $this->input->post("id");
        $affect = $this->db->delete('fm_program', array('id' => $id));
        echo json_encode($affect);
    }

    //下载
    public function download(){
        $link = $this->input->get("download_path");
        if($link){
            //判断图片路径是否为http或者https开头
            $preg="/(http:\/\/)|(https:\/\/)(.*)/iUs";
            if(preg_match($preg,$link)){
                //不需要操作
            }else{
                $link = base_url(). $link;
            }
            $filename = $this->input->get("title") ? $this->input->get("title") : "我下载的音频";
            $ext=strrchr($link,".");
            //文件的类型
            header('Content-type: application/video');
            //下载显示的名字
            header('Content-Disposition: attachment; filename='."$filename"."$ext");
            readfile("$link");
            exit();
        }else{
            show_msg('文件不存在！', "index.php?c=personal");
        }

    }


}

