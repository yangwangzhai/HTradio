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
        }
        
        if($me_id) {
            $sql = "SELECT title,mid,intro,thumb,program_ids,addtime,playtimes FROM fm_programme WHERE id=$me_id";
            $query = $this->db->query($sql);
            $data['me_data'] = $me_data = $query->row_array();
            $sql = "SELECT a.id,title,path,playtimes,ADDTIME,program_time FROM fm_program a LEFT JOIN  fm_programme_list b ON a.id =b.program_id WHERE b.type_id=1 AND b.programme_id=$me_id;";
            $query = $this->db->query($sql);
            $data['list'] = $query->result_array();
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
