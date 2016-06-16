<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
/*
 * 微路新闻 客户端使用
 */
class test extends CI_Controller {
	public $pagesize = 20; // 分页每页条数····
	public $error = array ( // 返回的错误码
			'error_code' => 0,
			'error_msg' => 'this is error message' 
	);	
	
	public $jsonstr = '[{"PublishTime":"2015-10-29T10:41:45.0000000+08:00","Title":"w2广丰雷凌混动售13.98万起","ID":6560884,"FirstPicUrl":"http://img1.bitautoimg.com/wapimg-66-44/bitauto/news/2015/10/20151029103245706_320.jpg"},{"PublishTime":"2015-10-29T09:25:00.0000000+08:00","Title":"凯迪拉克新ATS-L购车手册","ID":6559226,"FirstPicUrl":"http://img1.bitautoimg.com/wapimg-66-44/bitauto/news/2015/10/20151021153138741_320.jpg"},{"PublishTime":"2015-10-29T07:55:22.2070000+08:00","Title":"宝骏首款电动车-柳州投产","ID":6562684,"FirstPicUrl":"http://img3.bitautoimg.com/wapimg-66-44/bitauto/2015/10/29/6ac7e7c2-1a5f-4b5c-b333-e980b42976fb_630.jpg"},{"PublishTime":"2015-10-29T07:53:06.1900000+08:00","Title":"一汽丰田将推多款小型车","ID":6562683,"FirstPicUrl":"http://img3.bitautoimg.com/wapimg-66-44/bitauto/2015/10/29/2e98387e-b446-42c9-9d50-7e19d67e04c3_630.jpg"},{"PublishTime":"2015-10-29T07:50:39.2830000+08:00","Title":"众泰首款电动A级车年内产","ID":6562682,"FirstPicUrl":"http://img2.bitautoimg.com/wapimg-66-44/bitauto/2015/10/29/b20ff447-4b96-41cc-a438-fba7b6e8f405_630.jpg"},{"PublishTime":"2015-10-29T07:39:21.3770000+08:00","Title":"路虎发现5将采用全铝平台","ID":6562681,"FirstPicUrl":"http://img2.bitautoimg.com/wapimg-66-44/bitauto/2015/10/29/29c6f7d8-2fec-40c4-ad1a-7a532fcc8510_630.jpg"},{"PublishTime":"2015-10-29T01:45:00.0000000+08:00","Title":"奔驰C63与宝马M3的决战","ID":6561655,"FirstPicUrl":"http://img1.bitautoimg.com/wapimg-66-44/bitauto/news/2015/10/20151028202738362_320.jpg"},{"PublishTime":"2015-10-29T00:32:00.0000000+08:00","Title":"抢先试驾大众高尔夫GTE","ID":6562442,"FirstPicUrl":"http://img1.bitautoimg.com/wapimg-66-44/bitauto/news/2015/10/20151028214824456_320.jpg"},{"PublishTime":"2015-10-29T00:05:00.0000000+08:00","Title":"宝马7系想要后来者居上？","ID":6561522,"FirstPicUrl":"http://img1.bitautoimg.com/wapimg-66-44/bitauto/news/2015/10/201510290208268_320.jpg"},{"PublishTime":"2015-10-29T00:00:00.0000000+08:00","Title":"实拍沃尔沃V60 CC跨界车","ID":6562279,"FirstPicUrl":"http://img1.bitautoimg.com/wapimg-66-44/bitauto/news/2015/10/20151027164219729_320.jpg"},{"PublishTime":"2015-10-29T00:00:00.0000000+08:00","Title":"SUV与MPV你该怎么选？！","ID":6559682,"FirstPicUrl":"http://img1.bitautoimg.com/wapimg-66-44/bitauto/news/2015/10/2015101515819157_320.jpg"},{"PublishTime":"2015-10-29T00:00:00.0000000+08:00","Title":"平行进口车只是便宜吗？","ID":6561326,"FirstPicUrl":"http://img1.bitautoimg.com/wapimg-66-44/bitauto/news/2015/10/201510281202334_320.jpg"},{"PublishTime":"2015-10-29T00:00:00.0000000+08:00","Title":"一汽丰田或推皇冠双擎版","ID":6562678,"FirstPicUrl":"http://img4.bitautoimg.com/wapimg-66-44/autoalbum/files/20150814/141/11261014102278_4203263_630x419__m1.jpg"},{"PublishTime":"2015-10-28T18:57:00.0000000+08:00","Title":"斯巴鲁新款森林人图解","ID":6562541,"FirstPicUrl":"http://img1.bitautoimg.com/wapimg-66-44/bitauto/news/2015/10/20151028184759815_320.jpg"},{"PublishTime":"2015-10-28T18:54:31.5970000+08:00","Title":"雷克萨斯LF-FC概念车图解","ID":6562653,"FirstPicUrl":"http://img1.bitautoimg.com/wapimg-66-44/bitauto/news/2015/10/20151028185352206_320.jpg"}]';
	
	function __construct() {
		parent::__construct ();
		
	}
	
	
	//android版本更新提示
	function android_version(){
		$data = get_cache('android_version');  
		 echo json_encode($data);	
	}
	
	function posttest(){
		foreach($_REQUEST as $k=>$v){
			echo $k;echo "--";
			echo $v;echo "</br>";
		}
		
	}
	
		//播单
	public function play_lists() {
		$page = intval ( $_GET ['page'] ) - 1;
		$offset = $page > 0 ? $page * $this->pagesize : 0;
		$query = $this->db->query ( "select id,title,thumb as FirstPicUrl,mid as PublishTime from fm_programme  order by playtimes desc limit $offset,$this->pagesize" );
		$list = $query->result_array ();
		foreach ($list as &$row) {
    		if($row['FirstPicUrl']) $row['FirstPicUrl'] = base_url().$row['FirstPicUrl'];
			if($row['PublishTime'])  $row['PublishTime'] = getNickName($row['PublishTime']);
    	}
		
		
		
		  echo json_encode($list);
	}
	
	function adduser(){
		$chars = "abcdefghijklmnopqrstuvwxyz1234567890";
		$rand = rand(6,12);
		
		for ( $j = 0; $j < 3500; $j++ )  {
		
			$password = "123456";  
			$user = "";
			for ( $i = 0; $i < $rand; $i++ )  
			{  
				//这里提供两种字符获取方式  
				//第一种是使用 substr 截取$chars中的任意一位字符；  
				//第二种是取字符数组 $chars 的任意元素  
				//$password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);  
				 $user .= $chars[ mt_rand(0, strlen($chars) - 1) ];  
			}  
			
			
			$data ['username'] = $user;
			$data ['nickname'] = $user;
			$data ['status'] = 1;
			$data ['gender'] =  rand(0,1);
			$data ['password'] = $user;
			$data ['addtime'] = time ();
			$query = $this->db->insert ( 'fly_member', $data );
			
		}
	}
	
	
} // ========类结束


