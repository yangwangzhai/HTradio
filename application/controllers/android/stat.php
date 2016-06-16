<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
/*
 *  客户端统计
 */
class stat extends CI_Controller {	
	function __construct() {
		parent::__construct ();
		
	}
	// 基础统计 保存
	function base_save() {
		$data = array (
				'uid' => intval ( $_POST ['uid'] ),
				'city' => trim ( $_POST ['city'] ),
				'district' => trim ( $_POST ['district'] ),
				'lnglat' => trim ( $_POST ['lnglat'] ),
				'version' => trim ( $_POST ['version'] ),
				'os_version' => trim ( $_POST ['OSVersion'] ),
				'phone_model' => trim ( $_POST ['PhoneModel'] ),
				'phone_brand' => trim ( $_POST ['PhoneBrand'] ),
				'phone_os' => trim ( $_POST ['PhoneOS'] ),
				'ip' => ip (),
				'addtime' => time (),
				'isfirst' =>  trim ( $_POST ['isfirst'] ),
		);
		
		if (empty ( $data ['version'] )) {
			error ( 1, 'data version is null' );
		}
		
		$query = $this->db->insert ( 'fm_stat', $data ); // 写入基础统计表
		$id = $this->db->insert_id ();		
		show(0, 'ok', $id);  	
	}
	
	
	
		
	
} // ========类结束 