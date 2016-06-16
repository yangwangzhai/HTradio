<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
class Ajax extends CI_Controller
{
	private $uid;	
	function __construct ()
    {
        parent::__construct();		
	}
   

    //关注主播
    public function attention(){
		$uid = $this->session->userdata('uid');
    	$zid = $_POST['zid'];		
		$action = $_POST['action']; 
		if($zid == $uid) {
			echo 3;
			return;
		}
		if( !$uid ){
			echo 1;
			return ;
		}
		if($action == 'add'){
			$data = array( 'zid' => $zid,'mid'=>$uid,'addtime' => time() );
			$this->db->insert('fm_attention', $data); 
			if($this->db->insert_id()){
				echo 0;
			}else{
				echo 2;
			}
		}
		if($action == 'del'){
			$this->db->delete('fm_attention', array('zid' => $zid,'mid'=>$uid)); 
			echo 0;
		}
    }

    
	
	    //关注节目
    public function attention_program(){
		$uid = $this->session->userdata('uid');
    	$id = $_POST['id'];		
		$action = $_POST['action']; 
		if( !$uid ){
			echo 1;
			return ;
		}
		if($action == 'add'){
			$data = array( 'program_id' => $id,'mid'=>$uid,'addtime' => time(), 'type'=>1 );
			$this->db->insert('fm_program_data', $data); 
			if($this->db->insert_id()){
				echo 0;
			}else{
				echo 2;
			}
		}
		if($action == 'del'){
			$this->db->delete('fm_program_data', array('program_id' => $id,'mid'=>$uid, 'type'=>1)); 
			echo 0;
		}
    }

    //增加播放次数
    function addPlayTimes() {
    	$uid = $this->session->userdata('uid');
    	$mid = $uid?$uid:0;
    	$program_id = intval($_POST['id']);
    	$meid = intval($_POST['meid']);
    	if(!$program_id && !$meid) {
    		echo 1;
    		return;
    	}

    	$type = 3;

    	if($program_id) {
			$this->db->insert('fm_program_data',array('mid'=>$mid,'program_id'=>$program_id,'type'=>$type,'addtime'=>time()));
	    	if($this->db->insert_id()) {
	    		$this->db->query('update fm_program set playtimes = playtimes+1 where id = '.$program_id);
	    		echo 0;
	    	}else {
	    		echo 2;
	    	}
    	}elseif ($meid) {
    		$table_data = 'fm_programme_data';
			$table = 'fm_programme';
			$this->db->insert('fm_programme_data',array('mid'=>$mid,'programme_id'=>$meid,'type'=>$type,'addtime'=>time()));
	    	if($this->db->insert_id()) {
	    		$this->db->query('update fm_programme set playtimes = playtimes+1 where id = '.$meid);
	    		echo 0;
	    	}else {
	    		echo 2;
	    	}
    	}
	
    }
		    
	function get_play_list(){
		$this->db->order_by("playtimes", "desc");
		$query_top = $this->db->get_where('fm_program', array('show_homepage' => 1 , 'status' => 1));
		$list = $query_top->result_array();
		foreach($list as &$row){
			$list_r = array(
					 'title'=>$row['title'],
					 'artist'=>getNickName( $row['mid'] ),
					 'album'=>'',
					 'cover'=>show_thumb( $row['thumb'] ),
					 'mp3'=>$row['path'],
					 'ogg'=>''
			 );
			$data[] =  $list_r;
		}
			 
            echo json_encode($data);
		}
	
	    //关注节目
    public function send_message(){
		$uid = $this->session->userdata('uid');
    		
		$toid = $_POST['zid']; 
		$content = $_POST['content'];
		if( !$uid ){
			echo 1;
			return ;
		}
		
		$data = array( 'from_uid' => $uid,'to_uid'=>$toid,'addtime' => time(), 'status'=>1, 'title' => $content );
		$this->db->insert('fm_message', $data); 
		if($this->db->insert_id()){
			echo 0;
		}else{
			echo 2;
		}
		
		
    }	
	
		//设置头像
	public function sphoto() {
		$data = array();
		$data['src'] = trim($_POST['src']);
		$data['id']  = intval($_POST['id']);
		$this->load->view('sphoto',$data);
	}
		
}
