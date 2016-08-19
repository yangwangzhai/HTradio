<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
// 首页 by tangjian 
class Upload extends CI_Controller
{
	 function __construct ()
    {
        parent::__construct();
		$this->baseurl='index.php?c=upload';
		 $this->table = 'fm_program';
		$this->config->base_url();

		$this->load->model('content_model');
		$this->uid = $this->session->userdata('uid');
         
        if (empty($this->uid)) {
        	$returnUrl = escape('?c=index&m=program');
            show_msg('请先登录', 'index.php?c=member&m=login&returnUrl='.$returnUrl); 
        }
	}
    // 首页
    public function index (){
		
		//echo $this->uid;exit;	
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

		$this->load->view('upload',$data);
    } 
	
	
	 public function upload_rec(){
		 
		 
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
		
		
		$data['path']=$_GET['url'];
		
		$this->load->view('upload_rec',$data);
    }       
	
	public function edit_audio(){
		
		$id = $_GET['id'] ;
		
		 //获取节目类型列表
        $query = $this->db->query("SELECT * FROM fm_program_type");   
        $program_types = $query->result_array();
        $data['program_types'] =$program_types;
		
		//上传插件配置
		$data['file_size_limit'] = '2000 MB';
		$data['file_types'] = '*.mp4;*.swf;*.flv;*.mp3;*.wav;*.wma;*.wmv;*.mid;*.avi;*.mpg;*.asf;*.rm;*.rmvb;*.m4a;*.amr';
		$data['file_types_description'] = '音视频文件';
		$data['file_upload_limit'] = 3;
		
		$query = $this->db->get_where('fm_program', array('id' => $id),1);
		$row = $query->row_array();
		$data['data'] = $row;
		$this->load->view('upload_audio',$data);
		
	}
    
	public function save ()
    {		
		
        $id = intval($_POST['id']);
        $data = trims($_POST['value']);
		$type= trims($_POST['type']);
        $tag_name = trims($_POST['tag_name']);

		//处理图片路径
		$str=$data['thumb'];	// 原路径： /HTradio/uploads/image/20160408/20160408031935_71951.jpg，想去掉前面的 /HTradio/
		$str=substr($str,1);	//去掉第一个 “/”
		$str=strstr($str,'/');	//去掉 HTradio
		$data['thumb']=substr($str,1);	//去掉第二个 /

        if($data['type_id']==''){
		   $data['type_id']=$type;
		}
		if($data['tag']){
			$data['tag_ids'] = getTagidByName($data['tag']);
			unset($data['tag']);
		}
        if(!empty($tag_name)){
            $tag_name = preg_replace("/(\n)|(\s{1,})|(\t)|(\')|(')|(，)|(\.)|(、)|(\|)/",',',$tag_name);//中文逗号转换成英文
            $tags = explode(",",$tag_name);
        }

        if ($id) { // 修改 ===========
            $this->db->where('id', $id);
            $query = $this->db->update($this->table, $data);

            $this->db->query("delete from fm_program_tag where program_id=$id");
            if(!empty($tags)){
                foreach($tags as $t){
                    $insert_tag = array();
                    $insert_tag['program_id'] = $id;
                    $insert_tag['tag_name'] = $t;
                    $insert_tag['addtime'] = time();
                    $this->db->insert('fm_program_tag',$insert_tag);
                    unset($insert_tag);
                }
            }

            show_msg('修改成功！','index.php?c=personal');
        } else { // ===========添加 ===========
            $data['addtime'] = time();
            $data['download_path'] = $data['path'];
			$data['mid']=$this->session->userdata('uid');
            $query = $this->content_model->db_insert_table($this->table, $data);	//返回插入成功的数据的ID
            //添加标签
            if(!empty($tags)){
                foreach($tags as $t){
                    $insert_tag = array();
                    $insert_tag['program_id'] = $query;
                    $insert_tag['tag_name'] = $t;
                    $insert_tag['addtime'] = time();
                    $this->db->insert('fm_program_tag',$insert_tag);
                    unset($insert_tag);
                }
            }

			//根据ID获取音频路径
			$path=$this->content_model->get_column2("path","fm_program","id=$query");
			//对音频转换格式，并将新格式的路径替换原来的路径
			$m3u8_path=$this->change_m3u8($path['path']);
			$this->content_model->update2($query,"fm_program",array('path'=>$m3u8_path));

			show_msg('添加成功！','index.php?c=personal');
        }
    }


	public function change_m3u8($path){
		$ffmepg = "D:/wamp/www/HTradio/ffmpeg.exe"; // 指定转码器
		//$ffmepg = "E:/www/cmradio/ffmpeg.exe"; // 指定转码器
		date_default_timezone_set('PRC');
		$rand=rand(100000,999999);
		$date=date('ymdhis',time());
		$file=$date."_".$rand;
		//创建文件夹
		if(!is_dir("uploads/$file")){
			mkdir("uploads/$file");
		}
		$cmd1="$ffmepg -i $path -codec copy -bsf h264_mp4toannexb uploads/$file/$file.ts";
		exec($cmd1);
		$cmd2="$ffmepg -i uploads/$file/$file.ts -c copy -map 0 -f segment -segment_list $file.m3u8 -segment_time 10 uploads/$file/output%03d.ts";
		exec($cmd2);
		//返回 m3u8的路径
		return "$file.m3u8";
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
		
	public function checkType(){
		$id = $_GET['id'];
		$query = $this->db->query("SELECT * FROM fm_program_type where `id`=$id");
		$row = $query->row_array();
		echo $row['pid']; 
	}	
	
	//上传音频文件
	public function upload_audio(){
		
        //获取节目类型列表
        $query = $this->db->query("SELECT * FROM fm_program_type");
        $program_types = $query->result_array();
        $data['program_types'] =$program_types;

		$data['file_size_limit'] = '2000 MB';
		$data['file_types'] = '*.mp4;*.swf;*.flv;*.mp3;*.wav;*.wma;*.wmv;*.mid;*.avi;*.mpg;*.asf;*.rm;*.rmvb;*.m4a;*.amr';
		$data['file_types_description'] = '音视频文件';
		$data['file_upload_limit'] = 3;

		$this->load->view('upload_audio',$data);
	}
	
	
		
}
