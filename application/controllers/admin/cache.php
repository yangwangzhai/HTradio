<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
	// 缓存控制器 常用变量
class cache extends CI_Controller {
	
	private $ttl = 315360000; // 缓存周期 一年
	
	function __construct ()
	{
		parent::__construct();
		$this->uid = $this->session->userdata('id');
		if (empty($this->uid)) {
			show_msg('请先登录', 'admin.php');
		}
	}
	
	// 首页
	public function index() {		
		
		$data['list'] = array(
				'电台组会员 缓存'				
				);
				
		$this->load->view ( 'admin/cache_list', $data );
	}
	
	// 更新缓存
	public function save() {
		
		$this->load->driver('cache',array('adapter'=>'file'));
		
		$query = $this->db->query('select id,nickname from fm_member where catid=3 limit 50');
		$list = $query->result_array();
		foreach($list as $value) {
			$user[ $value['id'] ] = $value['nickname'];
		}
		
		echo '更新中....';
		
		$this->cache->save('user_radios', $user, $this->ttl);
		show_msg('更新完成', 'index.php?d=admin&c=cache');
	}
	
	
}

/* End of file welcome.php */




