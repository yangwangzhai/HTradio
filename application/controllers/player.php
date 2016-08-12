<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');


class Player extends CI_Controller
{
	 function __construct ()
    {
        parent::__construct();
		
	}
    // 首页
    public function index ()
    {
        date_default_timezone_set('PRC');
        $data['id'] = $id = intval($_GET['id']);
        $data['meid'] = $me_id = intval($_GET['meid']);
        if(!$id && !$me_id){
            show(1,'请求参数不正确');
        }

        if($id) {
            $sql = "SELECT path,title,mid,description intro,thumb,addtime,playtimes FROM fm_program WHERE id=$id";
            $query = $this->db->query($sql);
            $data['me_data'] = $query->row_array();
            //获取标签
            $query_tag = $this->db->query("SELECT tag_name FROM fm_program_tag WHERE program_id=$id");
            $data['result_tag'] = $query_tag->result_array();
        }
        
        if($me_id) {
            //分页
            $query = $this->db->query("SELECT COUNT(*) AS num FROM fm_program a LEFT JOIN  fm_programme_list b ON a.id =b.program_id WHERE b.type_id=1 AND b.programme_id=$me_id;");
            $count = $query->row_array();
            $data['count'] = $count['num'];
            $this->load->library('pagination');

            $config['total_rows'] = $count['num'];
            $config['per_page'] = 15;
            $config['base_url'] = "index.php?c=player&m=index&meid=$me_id";
            $this->pagination->initialize($config,true);
            $data['pages'] = $this->pagination->create_links();
            $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
            $per_page = $config['per_page'];

            $sql = "SELECT title,mid,uid,intro,thumb,program_ids,addtime,playtimes FROM fm_programme WHERE id=$me_id";
            $query = $this->db->query($sql);
            $data['me_data'] = $me_data = $query->row_array();
            $sql = "SELECT a.id,title,path,download_path,playtimes,ADDTIME,program_time FROM fm_program a LEFT JOIN  fm_programme_list b ON a.id =b.program_id WHERE b.type_id=1 AND b.programme_id=$me_id limit $offset,$per_page";
            $query = $this->db->query($sql);
            $data['list'] = $query->result_array();
            //获取标签
            $query_tag = $this->db->query("SELECT tag_name FROM fm_programme_tag WHERE programme_id=$me_id");
            $data['result_tag'] = $query_tag->result_array();
            //获取评论
            $query_comment = $this->db->query("SELECT a.content,a.addtime,b.username,b.nickname,b.avatar FROM fm_comment a  JOIN fm_member b WHERE a.mid=b.id AND a.programme_id=$me_id ORDER BY a.addtime DESC LIMIT 0,3");
            $data['result_comment'] = $query_comment->result_array();
            //获取评论总条数
            $query_comment_num = $this->db->query("SELECT count(*) as num from fm_comment WHERE programme_id=$me_id");
            $result_comment_num = $query_comment_num->row_array();
            $data['result_comment_num'] = $result_comment_num['num'];
            //获取用户id,若为空，则说明用户没有登陆，评论时候先提示用户登录
            $data['mid'] = $this->session->userdata('uid');

            //评论分页
            $cur_page = $this->input->get('mper_page')?$this->input->get('mper_page'):1;//通过ajax获取当前第几页
            $config['base_url'] = 'index.php?c=player&m=comment_page&me_id='.$me_id;
            $query = $this->db->query("SELECT count(*) as num FROM fm_comment WHERE programme_id = $me_id");
            $count = $query->row_array();
            $config['total_rows'] = $count['num'];
            $config['per_page'] = 3;
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

        }

        //TA的其他节目
        if($data['me_data']['mid']){
            $mid = $data['me_data']['mid'];
            $sql = "SELECT id,title,thumb,type_id FROM fm_programme WHERE mid = $mid ORDER BY playtimes DESC limit 4";
        }else{
            $uid = $data['me_data']['uid'];
            $sql = "SELECT id,title,thumb,type_id FROM fm_programme WHERE uid = $uid ORDER BY playtimes DESC limit 4";
        }
        $query = $this->db->query($sql);
        $data['other'] = $query->result_array();

        //大家还在听
        $sql = "SELECT id,title,thumb,type_id FROM fm_program WHERE id in (SELECT program_id FROM fm_program_data WHERE type = 3 ORDER BY addtime DESC) limit 6";
        $query = $this->db->query($sql);
        $data['listen'] = $query->result_array();

        if($id){
            //直接播放的是节目，该节目播放数量+1
            $playtimes_current = $data['me_data']['playtimes']+1;
            $this->db->query("update fm_program set playtimes=$playtimes_current WHERE id=$id");
            //统计播放该节目的时间
            $insert['program_id'] = $id;
            $insert['addtime'] = time();
            $this->db->insert("fm_program_playtimes",$insert);
            $this->load->view('detail',$data);
        }elseif($me_id){
            //直接播放的是节目，该节目播放数量+1
            $playtimes_current = $data['me_data']['playtimes']+1;
            $this->db->query("update fm_programme set playtimes=$playtimes_current WHERE id=$me_id");
            //统计播放该节目单的时间
            $insert['programme_id'] = $me_id;
            $insert['addtime'] = time();
            $this->db->insert("fm_programme_playtimes",$insert);
            //判断该用户是否是此节目单的作者
            $uid = $this->session->userdata('uid'); //当前登陆的用户ID
            //查找此节目单的作者
            $mid_query = $this->db->query("select mid from fm_programme WHERE id=$me_id");
            $mid = $mid_query->row_array();
            if($uid==$mid['mid']){
                $data['is_owner'] = 1;
            }else{
                $data['is_owner'] = 0;
            }

            $this->load->view('my_detail',$data);
        }

    }

    // 编辑
    public function edit ()
    {
        $id = intval($_GET['id']);
        
        // 这条信息
        $query = $this->db->get_where("fm_programme", 'id = ' . $id, 1);
        $value = $query->row_array();
        $category = get_cache('category');
        $value['catname'] = $category[$value['catid']]['name'];
        $data['value'] = $value;

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
        foreach($program_types as $program_type){
            $data['program_type'][$program_type['id']] =$program_type['title'];
        }

        $this->load->view('programme_edit', $data);
    }

    // 保存 添加和修改都是在这里
    public function personal_programme_save ()
    {
        $id = intval($_POST['id']);
        $data = trims($_POST['value']);
        $list =trims($_POST['list']);

        //因为手机端的缘故，这里需要将1，2对调
        foreach($list as &$value){
            if($value['type_id']==1){
                $value['type_id']=2;
            }elseif($value['type_id']==2){
                $value['type_id']=1;
            }
        }

        if ($id) { // 修改 ===========
            $this->db->where('id', $id);
            $query = $this->db->update("fm_programme", $data);

            //$this->db->query("delete from fm_programme_list where programme_id=$id");
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
            adminlog('修改信息: '.$this->control.' -> '.$id);
            show_msg('修改成功！', "index.php?c=player&meid=$id");
        }
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

            $this->load->view('programme_add_program_type',$data);
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

            $this->load->view('programme_add_program',$data);
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

    //获取播放地址
    public function getUrl(){
    	$id = intval($_GET['id']);
        if($id) {
            $sql = "SELECT title,path FROM fm_program WHERE id=$id";
            $query = $this->db->query($sql);
            $data = $query->row_array();
            $type = fileext($data['path']);
            $list = array('title'=>$data['title'],$type=>$data['path']);
            
            
            echo json_encode($list);
        }
    	
    }

    //获取二级节目分类
    public function getSecondProgramType(){
        $id = intval($_GET['id']);
        $sql = "SELECT id,title FROM fm_program_type WHERE pid = $id";
        $query = $this->db->query($sql);
        $list = $query->result_array();
        echo json_encode($list);
    }

    //异步删除节目
    public function delete_progarm(){
        $meid = $this->input->post("meid");
        $id = $this->input->post("id");
        $affect = $this->db->delete('fm_programme_list', array('programme_id' => $meid,'program_id' => $id));
        echo json_encode($affect);
    }

    //下载
    public function download(){
        $link = $this->input->get("download_path");
        $meid = $this->input->get("meid");
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
            if($meid){
                show_msg('文件不存在！', "index.php?c=player&meid=$meid");
            }else{
                show_msg('文件不存在！', "index.php?c=player&meid=$meid");
            }

        }

    }

    //下一首 
    public function next_one() {
        $curr = intval($_GET['curr']);
        $mid = intval($_GET['mid']);
        if(!$curr || !$mid) {
            exit();
        }
        $sql = "SELECT id,title,path FROM fm_program WHERE id = (SELECT max(id) FROM fm_program WHERE id < $curr AND mid=$mid)";
        $query = $this->db->query($sql);
        if($res = $query->row_array()) {
            $data['id'] = $res['id'];
            $type = fileext($res['path']);
            $data['list'] = array('title'=>$res['title'],$type=>$res['path']);
            echo json_encode($data);
        }
        
    }

    //上一首
    public function prev_one() {
        $curr = intval($_GET['curr']);
        $mid = intval($_GET['mid']);
        if(!$curr || !$mid) {
            exit();
        }
        $sql = "SELECT id,title,path FROM fm_program WHERE id = (SELECT min(id) FROM fm_program WHERE id > $curr AND mid=$mid)";
        $query = $this->db->query($sql);
        if($res = $query->row_array()) {
            $data['id'] = $res['id'];
            $type = fileext($res['path']);
            $data['list'] = array('title'=>$res['title'],$type=>$res['path']);
            echo json_encode($data);
        }
    }

    //保存标签
    public function save_tag(){
        $tag_name = $this->input->post("tag_name");
        $id = $this->input->post("id");
        $tag_flag = $this->input->post("tag_flag");
        if(!empty($tag_name)){
            $tag_name = preg_replace("/(\n)|(\s{1,})|(\t)|(\')|(')|(，)|(\.)|(、)|(\|)/",',',$tag_name);//中文逗号转换成英文
            $tags = explode(",",$tag_name);
            if($tag_flag==1){
                foreach($tags as $t){
                    $insert_tag = array();
                    $insert_tag['program_id'] = $id;
                    $insert_tag['tag_name'] = $t;
                    $insert_tag['addtime'] = time();
                    $this->db->insert('fm_program_tag',$insert_tag);
                    unset($insert_tag);
                }
                //添加成功，返回标签数组
                echo json_encode($tags);
            }elseif($tag_flag==2){
                foreach($tags as $t){
                    $insert_tag = array();
                    $insert_tag['programme_id'] = $id;
                    $insert_tag['tag_name'] = $t;
                    $insert_tag['addtime'] = time();
                    $this->db->insert('fm_programme_tag',$insert_tag);
                    unset($insert_tag);
                }
                //添加成功，返回标签数组
                echo json_encode($tags);
            }
        }

    }

    public function play_over(){
        $insert['program_id'] = $id = $this->input->post("id");
        if($id){
            //先获取此前听完的次数
            $query = $this->db->query("select play_over_times from fm_program WHERE id=$id");
            $play_over_times_before = $query->row_array();
            $play_over_times_current = $play_over_times_before['play_over_times']+1;
            $this->db->query("update fm_program set play_over_times=$play_over_times_current WHERE id=$id");
            //统计播放完该节目的时间
            $insert['addtime'] = time();
            $this->db->insert("fm_program_playover",$insert);
            echo json_encode($play_over_times_current);
        }
    }

    public function save_comment(){
        date_default_timezone_set('PRC');
        $insert['programme_id'] = $me_id = trim($this->input->post("me_id"));
        $insert['mid'] = trim($this->input->post("mid"));
        $insert['content'] = trim($this->input->post("comment"));
        $insert['addtime'] = time();
        $affected = $this->db->insert("fm_comment",$insert);
        if($affected){
            //获取评论
            $query_comment = $this->db->query("SELECT a.content,a.addtime,b.username,b.nickname,b.avatar FROM fm_comment a  JOIN fm_member b WHERE a.mid=b.id AND a.programme_id=$me_id ORDER BY a.addtime DESC LIMIT 0,3");
            $data['result_comment'] = $query_comment->result_array();
            $arr[0] = $this->load->view('ajax_page/new_comment',$data,true);
            //获取评论总条数
            $query_comment_num = $this->db->query("SELECT count(*) as num from fm_comment WHERE programme_id=$me_id");
            $result_comment_num = $query_comment_num->row_array();
            $arr[1] = $result_comment_num['num'];
            echo json_encode($arr);
        }else{
            echo json_encode(0);
        }
    }

    //异步获取评论分页
    public function comment_page(){
        date_default_timezone_set('PRC');
        $data['mid'] = $this->session->userdata('uid');
        $me_id = $_GET['me_id'];
        $cur_page = $this->input->get('mper_page')?$this->input->get('mper_page'):1;//通过ajax获取当前第几页

        $config['base_url'] = 'index.php?c=player&m=comment_page&me_id='.$me_id;
        $query = $this->db->query("SELECT count(*) as num FROM fm_comment WHERE programme_id = $me_id");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        $config['total_rows'] = $count['num'];
        $config['per_page'] = 3;
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

        $query_comment = $this->db->query("SELECT a.content,a.addtime,b.username,b.nickname,b.avatar FROM fm_comment a  JOIN fm_member b WHERE a.mid=b.id AND a.programme_id=$me_id ORDER BY a.addtime DESC LIMIT $offset,$per_page");
        $data['result_comment'] = $query_comment->result_array();

        $comment_html = $this->load->view('ajax_page/comment_page',$data,true);
        echo $comment_html;
    }

	
	
		
		
}
