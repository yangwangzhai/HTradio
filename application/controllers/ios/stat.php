<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	/*
 * android 统计接口
 */
include 'api.php';
class stat extends Api {
	function __construct() {
		parent::__construct ();
		
		$this->load->model ( 'stat_model' );
	}
	
	// 听广播 统计加1 ，点击播放按钮才提交的
	function radios() {
		$data = array (
				'radio_id' => intval ( $_POST ['radio_id'] ),
				'uid' => intval ( $_POST ['uid'] ),
				'addtime' => time () 
		);
		
		if (empty ( $data ['radio_id'] )) {
			error ( 1, 'data radio_id is null' );
		}
		
		$query = $this->db->insert ( 'fly_stat_radio', $data );
		
		// 统计加1
		$this->load->model ( 'stat_model' );
		$this->stat_model->day_save ( 'radios' );
	}
	
	// 听广播 系列台 喜欢 +1
	function stat_like() {
		$radio = trim ( $_GET ['radio'] );
		
		$array = array (
				'name_910' => 'radio_910',
				'name_930' => 'radio_930',
				'name_950' => 'radio_950',
				'name_970' => 'radio_970',
				'name_1003' => 'radio_1003',
				'name_bbr' => 'radio_bbr' 
		);
		
		$radio = $array [$radio];
		
		if ($radio) {
			$query = $this->db->query ( "UPDATE fly_stat_like SET $radio=$radio+1" );
			echo $radio;
		}
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
				'addtime' => time () 
		);
		
		if (empty ( $data ['version'] )) {
			error ( 1, 'data version is null' );
		}
		
		$query = $this->db->insert ( 'fly_stat', $data ); // 写入基础统计表
		
		$this->stat_model->day_save ( 'traffic_list' ); // 主页访问数加1
	}
} // 类结束
