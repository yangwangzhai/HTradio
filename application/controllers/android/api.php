<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
/*
 * 微路新闻 客户端使用
 */
class Api extends CI_Controller {
	public $pagesize = 20; // 分页每页条数····
	public $error = array ( // 返回的错误码
			'error_code' => 0,
			'error_msg' => 'this is error message' 
	);	

	function __construct() {
		parent::__construct ();
		
	}
	
	// andorid客户端版本
	function version() {
		$netVersion = '1.0.8';
		
		$mobileVersion = $_POST ['version'];
		
		if ($mobileVersion && $mobileVersion != $netVersion) {
			$version = array (
					'version' => $netVersion,
					'message' => "本次更新内容有：  \n1、新闻详细底部增加统一图片\n2、功能优化" 
			);
			echo json_encode ( $version );
		} else {
			echo $netVersion;
		}
	}
	
	// andorid客户端版本
	function getAPK() {
		header ( 'Location: vroadnews.apk' );
		exit ();
	}
	
	// 基础统计 保存
	function base_save() {
		$data = array (
				'mid' => intval ( $_POST ['mid'] ) ? intval ( $_POST ['mid'] ) : 0,
				'city' => trim ( $_POST ['city'] ) ? trim ( $_POST ['city'] ) : "南宁",
				'district' => trim ( $_POST ['district'] ) ? trim ( $_POST ['district'] ) : "欢迎使用",
				'lnglat' => trim ( $_POST ['lnglat'] ) ? trim ( $_POST ['lnglat'] ) : "4.9E-324,4.9E-324",
				'version' => trim ( $_POST ['version'] ) ? trim ( $_POST ['version'] ) : "1.0",
				'os_version' => trim ( $_POST ['os_version'] ) ? trim ( $_POST ['os_version'] ) : "5.1.1",
				'phone_model' => trim ( $_POST ['phone_model'] ) ? trim ( $_POST ['phone_model'] ) : "MX4",
				'phone_brand' => trim ( $_POST ['phone_brand'] ) ? trim ( $_POST ['phone_brand'] ) : "phone",
				'phone_os' => trim ( $_POST ['phone_os'] ) ? trim ( $_POST ['phone_os'] ) : "1",
				'ip' => ip (),
				'addtime' => time (),
				'isfirst' =>  trim ( $_POST ['isfirst'] ) ? trim ( $_POST ['isfirst'] ) : "0",
		);
		
		if (empty ( $data ['version'] )) {
			show ( 1, 'data version is null' );
		}else{
            $query = $this->db->insert ( 'fm_stat', $data ); // 写入基础统计表
            $id = $this->db->insert_id ();
            show(0, 'ok', $id);
        }
	}
	
    //反馈留言
	function feedback(){
		$data = array(
    			'mid' => intval($_POST['mid']),    			
    			'content' => replaceBad(trim($_POST['content'])),
    			'addtime' => time()
    	);
    	if (empty($data['mid'])) {
    		show(1,'mid is null');	   	
    	}
    	
    	
    	if ($_FILES['audio']['name']) { // 上传语音
    		$data['audio'] = uploadFile('audio', 'audio');
    		$data['audio_time'] = intval($_POST['audio_time']);
    	}
    	
    	$insert_id = $this->db->insert ( 'fm_feedback', $data );
    	if ($insert_id) {
    		$msg = 'ok';    		
    		show(0, $msg, $insert_id);  		
    	} else {
    		show(2, '未知错误，添加没有成功');    		
    	}	
		
	}
	
	//android版本更新提示
	function android_version(){
		$data = get_cache('android_version');  
		 echo json_encode($data);	
	}

    //android_H5版本更新提示
    function android_version_H5(){
        $data = get_cache('android_version');
        echo json_encode($data);
    }

	function downimg(){
		echo 111;
		$query = $this->db->query ( "select * from fm_member where groupname != '新闻910' AND groupname != '私家车930' AND groupname != ''  " );
		$list['top'] = $query->result_array();
		
		foreach ($list['top'] as $row) {
			$row['avatar_100'] = new_thumbname($row['avatar'],'100','100');
			echo downImage('http://vroad.bbrtv.com/vroad/'.$row['avatar'],$row['avatar']);  
			echo "<br>";  	
			echo downImage('http://vroad.bbrtv.com/vroad/'.$row['avatar_100'],$row['avatar_100']);	
			echo "<br>";  	
    	}	
	}
	
	
	
	
} // ========类结束


