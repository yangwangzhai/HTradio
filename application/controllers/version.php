<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
/*
 *  版本信息
 */
include 'api.php';
class version extends Api {	
	
	function __construct() {
		parent::__construct ();
	}
	
	function index() {
		$netVersion = '1.5.5';
		$message = "本次更新内容有：  \n1、路况列表页添加摇一摇优化,摇一摇后自动发布当前位置的路况求助信息。  \n2、应用中心，添加环江聊天室 \n3、程序细节优化！赶快来更新吧。。。";
		
		
		$mobileVersion = $_POST ['version'];		
		if ($mobileVersion && $mobileVersion != $netVersion) {
			$version = array (
					'version' => $netVersion,
					'message' => $message,
					);
			echo json_encode ( $version );
		} else {
			echo $netVersion;
		}
	}	
	
	
	function getIOScrash(){
		$query = $this->db->query ( "SELECT * FROM fly_ios_crash ORDER BY id DESC limit 1" );
		$row = $query->row_array ();
		$version = array (
					'success' => $row['success'] == 1 ? true : false,
					'data' => array(
							'on'=> $row['on'] == 1 ? true : false,
							'version'=> $row['version'],
							'build'=> $row['build'],
					),
					);
		echo json_encode ( $version );
		
	}





	
} // 类结束


