<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
include 'Common.php';    
// 首页 by tangjian 
class Index extends Common
{
	 function __construct ()
    {
        parent::__construct();
		$this->load->model('content_model');
	}
    // 首页
    public function index ()
    {
        //echo dirname(dirname(dirname(__FILE__)));exit;
		 $code=$this->input->get('code');
		 
		 if($code){
              $this->qq_login($code);
			 }
		   
        $data['id'] = '1213';
		//随机获取几个节目
		$sql="SELECT id,title,thumb,path,playtimes FROM fm_program WHERE id >= ((SELECT MAX(id) FROM fm_program)-(SELECT MIN(id) FROM fm_program)) * RAND() + (SELECT MIN(id) FROM fm_program)  LIMIT 3;";
		$query=$this->db->query($sql);
		$data['list']=$query->result_array();
        if(!empty($data['list'])){
            //直接播放随机取出的第一个节目，该节目播放数量+1
            $playtimes_current = $data['list'][0]['playtimes']+1;
            $insert['program_id'] = $id = $data['list'][0]['id'];
            $this->db->query("update fm_program set playtimes=$playtimes_current WHERE id=$id");
            //统计第一个节目详细的播放时间
            $insert['addtime'] = time();
            $this->db->insert("fm_program_playtimes",$insert);
        }
        $this->load->view('index',$data);
    }    
    
	
	public function find(){

		/*$id=2045;
		$data['path']=$this->content_model->get_column2("path","fm_program","id=$id");

		$this->load->view('hls_play',$data);*/

		$uid = $this->session->userdata('uid');
		//幻灯图片
		$this->db->order_by("playtimes", "desc");
		$query_top = $this->db->get_where('fm_program', array('show_homepage' => 1 , 'status' => 1));
		$data['top_list'] = $query_top->result_array();
		
		//推荐的节目
		$this->db->order_by("playtimes", "desc");
		$this->db->where('show_homepage !=', 1);
		$query_hot = $this->db->get_where('fm_program', array('hot' => 1, 'status' => 1),3);
		$data['hot_list'] = $query_hot->result_array();
		
		//类型排行
		$this->db->order_by("sort", "desc");
		$query_type = $this->db->get_where('fm_program_type', array('pid' => 0),10);
		$data['type_list'] = $query_type->result_array();
		foreach($data['type_list'] as &$row){
			//类型子类
			$this->db->order_by("sort", "desc");			
			$query_child = $this->db->get_where('fm_program_type', array('pid' => $row['id']),6);
			$row['type_child'] =  $query_child->result_array();	
			
			//节目
			$typeid = $row['id'];
			$order_by = " order by playtimes desc,addtime desc limit 3";			
			$nothot = " show_homepage !=1 AND hot !=1 ";			
			$sql ="SELECT * FROM `fm_program`  WHERE ( $nothot AND status=1 AND type_id = $typeid ) OR ( $nothot AND status=1 AND type_id IN(SELECT id FROM fm_program_type WHERE pid = $typeid ) )".$order_by;
		   $query = $this->db->query($sql);
			$row['program_list'] = $query->result_array();
					
		}
		
		//热门电台				
		$query = $this->db->get_where('fm_member', array('status' => 1,'catid'=>3),4);
		$data['radio_list'] = $query->result_array();
		foreach($data['radio_list'] as &$row){
			$row['is_attention'] = is_attention($uid,$row['id']);
		}
		
		//明星主播
		$this->db->where('groupname !=', '');
		$query = $this->db->get_where('fm_member', array('status' => 1,'catid'=>2),6);
		$data['zhubo_list'] = $query->result_array();
		foreach($data['zhubo_list'] as &$row){
			$row['is_attention'] = is_attention($uid,$row['id']);
			$row['avatar'] = new_thumbname($row['avatar'],100,100);
		}

		//新晋榜
		$data['new_top_list'] = $this->newTopList();

		//热播榜
		$data['hot_top_list'] = $this->hotTopList();

		//人气排行榜
		$data['popularity_list'] = $this->popularityList();
		
		$data['uname'] = $this->session->userdata('uname');
		$data['uid'] = $this->session->userdata('uid');

		$this->load->view('find',$data);
	}
	
	public function ranklist(){
		//节目收听榜
		//$this->db->order_by("playtimes", "desc");
		//$query = $this->db->get_where('fm_program', array('status' => 1),15);
		//$data['program_list'] = $query->result_array();
		
		$cur_page = $this->input->get('per_page')?$this->input->get('per_page'):1;//通过ajax获取当前第几页
        $config['base_url'] = 'index.php?c=ranklist_jm';
        $query = $this->db->query("SELECT count(*) as num FROM fm_program WHERE status=1");
        $count= $query->row_array();
		if($count['num']>99){
			$count['num']=99;
			}
        $data['count'] = $count['num'];
        $config['total_rows'] = $count['num'];
        $config['per_page'] =15;   
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
        $data['pages_jm'] =$this->pagination->create_links($cur_page);
		
        $per_page = $config['per_page'];
        $offset = ($cur_page - 1) * $per_page;
		 if($offset==90){
			 $per_page=9;
			 }
		
		$sql = "SELECT * FROM fm_program WHERE status=1  ORDER BY playtimes DESC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['program_list'] = $query->result_array();
		
		
		//电台收听榜
		$cur_page = $this->input->get('per_page')?$this->input->get('per_page'):1;//通过ajax获取当前第几页
        $config['base_url'] = 'index.php?c=ranklist_dt';
        $query = $this->db->query("SELECT mid FROM fm_program GROUP BY mid");
		$count =  $query->result_array();
		$length=count($count);
		if($length>99){
			$length=99;
			}
        $data['count'] = $length;
		$config['total_rows'] = $length;
        $config['per_page'] =15;   
        $config['cur_tag_open'] = '<span class="page-item page-navigator-current">';
        $config['cur_tag_close'] = '</span>';
        $config['prev_link'] = '上一页';
        $config['next_link'] = '下一页';
        $config['first_link'] = '第一页';
        $config['last_link'] = '最后一页';
        $config['use_page_numbers']= true;
        $config['anchor_class']="class='ajax_page_dt page-item' data-id=2 ";
        $config['cur_page']=$cur_page;
        $this->load->library('pagination');
        $this->pagination->initialize($config);//默认的对象名是类名的小写
        $data['pages_dt'] =$this->pagination->create_links($cur_page);
		$per_page = $config['per_page'];
        $offset = ($cur_page - 1) * $per_page;
		 if($offset==90){
			 $per_page=9;
			 }
		
		$sql = "SELECT SUM(playtimes) AS playtimes,mid FROM fm_program  GROUP BY MID ORDER BY  playtimes DESC limit $offset,$per_page";

		$query = $this->db->query($sql);
		$data['radio_list'] = $query->result_array();

		foreach($data['radio_list'] as &$r){
			$row = getMember($r['mid']);
			$r['nickname'] = $row['nickname'] ? $row['nickname'] :$row['username'] ? $row['username'] : '佚名';
			$r['avatar'] = $row['wechat_id'] ? '' : $row['avatar'];
		}

		//新晋榜
		$data['new_top_list'] = $this->newTopList();

		//热播榜
		$data['hot_top_list'] = $this->hotTopList();

		//人气排行榜
		$data['popularity_list'] = $this->popularityList();

		$this->load->view('ranklist',$data);
	}
	
   
   public function program(){
	   $uid = $this->session->userdata('uid');	
	 
	   $this->db->order_by("sort", "asc");
	   $query = $this->db->get_where('fm_program_type', array('pid' => 0));
	   $data['program_type_list'] = $query->result_array();
	   
	   //节目
	   $typeid = 0;
	   if(isset($_GET['type_id']) && $_GET['type_id'] != ''){
		   $typeid =  $_GET['type_id'];
	   }else{
		   $typeid =  $data['program_type_list'][0]['id'];
	   }
	   
	    $data['new_color'] = "#000";
		$data['hot_color'] = "#000";
		if(isset($_GET['order']) && $_GET['order'] == 'hot'){
			 $order_by = " order by playtimes desc";
			 $data['hot_color'] = "";
		}else{
			 $order_by = " order by addtime desc";
			 $data['new_color'] = "";
		}
		
		$sql ="SELECT * FROM `fm_program`  WHERE ( status=1 AND type_id = $typeid ) OR ( status=1 AND type_id IN(SELECT id FROM fm_program_type WHERE pid = $typeid ) )".$order_by;
		$query = $this->db->query($sql);
		$data['program_list'] = $query->result_array(); 
		foreach($data['program_list'] as &$r){
			$r['is_program_data'] = is_program_data($uid,$r['id'],1);//判断是否收藏
			//收藏数
			$this->db->where( array( 'type'=>1 , 'program_id'=>$r['id']) );
			$this->db->from('fm_program_data');
			$r['fav_count'] = $this->db->count_all_results();
	
		}
		
		
		//节目总数
		$sql ="SELECT count(*) as num FROM `fm_program`  WHERE ( status=1 AND type_id = $typeid ) OR ( status=1 AND type_id IN(SELECT id FROM fm_program_type WHERE pid = $typeid ) )";
		$query = $this->db->query($sql);
		$row_count = $query->row_array(); 
	    $data['program_count'] = $row_count['num'];
	    
		//当前节目类型名称
		$query = $this->db->get_where('fm_program_type', array('id' => $typeid),1);
		$row = $query->row_array();  
		$data['type_name'] = $row['title'];
		$data['type_id'] = $row['id'];
		
		$data['sub_link'] = '';
		if($row['pid'] == 0){ 
			$data['cur_id'] = $row['id']; //判断当前的父类型用来选中左边的菜单
			$data['sub_link'] = "<a href='./index.php?c=index&m=program&type_id=$typeid'>$row[title]</a>";
		}else{
			$query = $this->db->get_where('fm_program_type', array('id' => $row['pid']),1);
			$row_child = $query->row_array(); 
			
			$data['cur_id'] = $row_child['id']; //判断当前的父类型用来选中左边的菜单
			$data['sub_link'] = "<a href='./index.php?c=index&m=program&type_id=$row_child[id]'>$row_child[title]</a> > ";
			$data['sub_link'] .= "<a href='./index.php?c=index&m=program&type_id=$typeid'>$row[title]</a>";
		}
		
	    $this->load->view('program',$data);
   }
   
   
    
    //新晋榜
    private function newTopList() {
    	$beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
		$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
		$sql = "SELECT id,title FROM fm_program WHERE addtime>=$beginThismonth AND addtime<=$endThismonth ORDER BY playtimes DESC limit 10";
		$query = $this->db->query($sql);
		return $query->result_array();
    }
    //热播榜
    private function hotTopList() {
    	$sql = "SELECT id,title FROM fm_programme ORDER BY playtimes DESC limit 10";
		$query = $this->db->query($sql);
		return $query->result_array();
    }
    //人气排行榜
    private function popularityList() {
    	$sql = "SELECT id,title FROM fm_program ORDER BY zantimes DESC limit 10";
		$query = $this->db->query($sql);
		return $query->result_array();
		
    }
	
	 public function ranklist_jm() {
    	 $cur_page = $this->input->get('per_page')?$this->input->get('per_page'):1;//通过ajax获取当前第几页
		 
        $config['base_url'] = 'index.php?c=ranklist_jm';
        $query = $this->db->query("SELECT count(*) as num FROM fm_program WHERE status=1");
        $count = $query->row_array();
			if($count['num']>99){
			$count['num']=99;
			}
		
        $data['count'] = $count['num'];
		 
        $config['total_rows'] = $count['num'];
        $config['per_page'] =15;   
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
		 if($offset==90){
			 $per_page=9;
			 }
		
		$sql = "SELECT * FROM fm_program WHERE status=1  ORDER BY playtimes DESC limit $offset,$per_page";
        $query = $this->db->query($sql);
		
		$data['cur_page']=$cur_page;
        $data['program_list'] = $query->result_array();
        $comment_html = $this->load->view('ajax_page/ranklist_jm',$data,true);
        echo $comment_html;
		
    }
	
	 public function ranklist_dt(){
		 
		$cur_page = $this->input->get('per_page')?$this->input->get('per_page'):1;//通过ajax获取当前第几页
		//echo $cur_page;exit;
        $config['base_url'] = 'index.php?c=ranklist_dt';
        $query = $this->db->query("SELECT mid FROM fm_program GROUP BY mid");
		$count =  $query->result_array();
		$length=count($count);
		if($length>99){
			$length=99;
			}
        $data['count'] = $length;
		$config['total_rows'] = $length;
        $config['per_page'] =15;   
        $config['cur_tag_open'] = '<span class="page-item page-navigator-current">';
        $config['cur_tag_close'] = '</span>';
        $config['prev_link'] = '上一页';
        $config['next_link'] = '下一页';
        $config['first_link'] = '第一页';
        $config['last_link'] = '最后一页';
        $config['use_page_numbers']= true;
        $config['anchor_class']="class='ajax_page_dt page-item' data-id=2 ";
        $config['cur_page']=$cur_page;
        $this->load->library('pagination');
        $this->pagination->initialize($config);//默认的对象名是类名的小写
        $data['pages'] =$this->pagination->create_links($cur_page);
		$per_page = $config['per_page'];
        $offset = ($cur_page - 1) * $per_page;
		 if($offset==90){
			 $per_page=9;
			 }
		$sql = "SELECT SUM(playtimes) AS playtimes,mid FROM fm_program  GROUP BY MID ORDER BY  playtimes DESC limit $offset,$per_page";
		
		$query = $this->db->query($sql);
		$data['radio_list'] = $query->result_array();
		foreach($data['radio_list'] as &$r){
			$row = getMember($r['mid']);
			$r['nickname'] = $row['nickname'];
			$r['avatar'] = $row['avatar'];
		}
		  $data['cur_page']=$cur_page;
		  $comment_html = $this->load->view('ajax_page/ranklist_dt',$data,true);
        echo $comment_html;
		 
		 }
		


	private function qq_login($code){
         //获取QQ的  access_token
		$list= file_get_contents('https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&client_id=101245070&client_secret=3717113dd45f31989b9d533457ce069f&code='.$code.'&redirect_uri=http://vroad.bbrtv.com/cmradio/');
		$access_token_arr=explode("&",$list);
		foreach($access_token_arr as $v){
			$jValue = explode("=", $v);
			$arr[ $jValue[0]] =$jValue[1];
		}
		$access_token=trim($arr['access_token']);

        //获取QQ的open_id
		$open_arr= file_get_contents('https://graph.qq.com/oauth2.0/me?access_token='.$access_token);
        $open_arr=$this->simple_json_parser($open_arr);
		$open_id=trim(str_replace(");","",$open_arr['openid']));
		//查询是否是第一次登陆
		$query = $this->db->query ( "select * from fm_member where qqopenid='$open_id' limit 1" );
		$user=$query->row_array();
		if($user){
			//不是第一次直接赋值session
			$userdata = array(
				'uname'  => $user['username'],
				'nickname'  => $user['nickname'],
				'uid'     => $user['id'],
				'th'=>'1',
				'logged_in' => TRUE
			);
			$this->session->set_userdata($userdata);
			redirect("c=personal");
		}else {
			//第一次登录 获取QQ用户信息
			require_once("/qqAPI/qqConnectAPI.php");
			$qc = new QC($access_token, $open_id);
			$arr = $qc->get_user_info();
			if($arr['gender']=='男'){
				$gender='1';
			}else{
				$gender=0;
			}
            //随机分配给新用户一个 uesrname
			$i=0;
			for($i=0;$i<1000;$i++){
				$username=rand('10000000','99999999');
				//防止出现重复的username
				$query = $this->db->query ( "select id from fm_member where username='$username' limit 1" );
				$user=$query->row_array();
				if(empty($user)){
					break;
				}
			}


			$postdate = array (
				'username'=>$username,
                'nickname' => preg_replace("/[^\w]/iu",'',$arr ['nickname']),
				'gender'=>$gender,
				'qqopenid'=>$open_id,
				'regtime' => time (),
				'status' => 1,
				'lastlogintime' => time ()
			);
			$query = $this->db->insert ( 'fm_member', $postdate );
			$insert_id = $this->db->insert_id ();

			$userdata = array(
				'uname'  =>$username,
				'nickname'  =>preg_replace("/[^\w]/iu",'',$arr ['nickname']),
				'uid'     => $insert_id,
				'th'=>'1',
				'logged_in' => TRUE
			);
			$this->session->set_userdata($userdata);
		    redirect("c=personal");
		}

		//print_r($arr);exit;



	}


	//简单实现json到php数组转换功能
    private function simple_json_parser($json){
        $json = str_replace("{","",str_replace("}","", $json));
        $jsonValue = explode(",", $json);
        $arr = array();
        foreach($jsonValue as $v){
            $jValue = explode(":", $v);
            $arr[str_replace('"',"", $jValue[0])] = (str_replace('"', "", $jValue[1]));
        }
        return $arr;
    }

    //统计节目播放次数
    public function playtimes(){
        $insert['program_id'] = $id = $this->input->post("pid");
        if($id){
            //先获取此前听完的次数
            $query = $this->db->query("select playtimes from fm_program WHERE id=$id");
            $playtimes_before = $query->row_array();
            $playtimes_current = $playtimes_before['playtimes']+1;
            $this->db->query("update fm_program set playtimes=$playtimes_current WHERE id=$id");
            //统计播放该节目的时间
            $insert['addtime'] = time();
            $this->db->insert("fm_program_playtimes",$insert);
            echo json_encode($playtimes_current);
        }
    }













}
