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
            $sql = "SELECT title,mid,intro,thumb,program_ids,addtime,playtimes FROM fm_programme WHERE id=$me_id";
            $query = $this->db->query($sql);
            $data['me_data'] = $me_data = $query->row_array();
            $sql = "SELECT a.id,title,path,download_path,playtimes,ADDTIME,program_time FROM fm_program a LEFT JOIN  fm_programme_list b ON a.id =b.program_id WHERE b.type_id=1 AND b.programme_id=$me_id;";
            $query = $this->db->query($sql);
            $data['list'] = $query->result_array();
            //获取标签
            $query_tag = $this->db->query("SELECT tag_name FROM fm_programme_tag WHERE programme_id=$me_id");
            $data['result_tag'] = $query_tag->result_array();
        }

        //TA的其他节目
        $mid = $data['me_data']['mid'];
        $sql = "SELECT id,title,thumb,type_id FROM fm_program WHERE mid = $mid ORDER BY playtimes DESC limit 4";
        $query = $this->db->query($sql);
        $data['other'] = $query->result_array();

        //大家还在听
        $sql = "SELECT id,title,thumb,type_id FROM fm_program WHERE id in (SELECT program_id FROM fm_program_data WHERE type = 3 ORDER BY addtime DESC) limit 6";
        $query = $this->db->query($sql);
        $data['listen'] = $query->result_array();
        
        if($id){
            $this->load->view('detail',$data);
        }elseif($me_id){
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
            show_msg('文件不存在！', "index.php?c=player&meid=$meid");
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
	
	
	
		
		
}
