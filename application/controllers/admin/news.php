<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
	// 文章 控制器 by tangjian

include 'content.php';
class News extends Content {

	function __construct() {
		parent::__construct ();
		
		$this->control = 'news';
		$this->baseurl = 'index.php?d=admin&c=news';
		$this->table = 'fm_news';
		$this->list_view = 'news_list'; // 列表页
		$this->add_view = 'news_add'; // 添加页
	}
	

	// 编辑
	public function add() {
		$weburl = $_GET ['weburl'];
		$data[value][addtime] = time();
		
		// 采集
		if ($weburl) {
			include APPPATH . 'libraries/contents.class.php';
			$content = new contents ();
			$data ['value'] ['content'] = $content->get_content ( $weburl );
		}
		$this->load->view ( 'admin/' . $this->control . '_add', $data );
	}
	
	// 保存 添加和修改都是在这里
	public function save() {
		$id = intval ( $_POST ['id'] );
		$data = trims ( $_POST ['value'] );
		
		if ($data ['title'] == "") {
			show_msg ( '标题不能为空' );
		}
// 		if ($data ['thumb'] == "") {
// 			show_msg ( '图片不能为空' );
// 		}
		$data ['addtime'] = strtotime( $data ['addtime'] );
		
		if ($id) { // 修改 ===========
			$this->db->where ( 'id', $id );
			$query = $this->db->update ( $this->table, $data );
			adminlog ( '修改信息' . $this->control . $id );
			show_msg ( '修改成功！', $_SESSION ['url_forward'] );
		} else { // ===========添加 ===========			
			$query = $this->db->insert ( $this->table, $data );
			adminlog ( '添加信息' . $this->control . $this->db->insert_id () );
			show_msg ( '添加成功！', $_SESSION ['url_forward'] );
		}
	}
	
	// 采集 910 970 
	function list_910() {	
		$radio = $_GET['radio'];
		if ($radio==910){
			$db = $this->load->database ( 'newsroom', TRUE );
		} elseif($radio==970) {
			$db = $this->load->database ( 'newsgroup', TRUE );
		}
		
 		$query = $db->query ( "SELECT id,title,content,dateline FROM news_list WHERE typeid IN (40,10,49,50,16) ORDER BY id DESC LIMIT 20" );
 		$data['list'] = $query->result_array ();
		$data['radio'] = $radio;
		
		$this->load->view ( 'admin/news_list_910', $data );
	}
	// 采集 910 970
	function list_970() {
		$radio = $_GET['radio'];
		$db = $this->load->database ( 'newsgroup', TRUE );		
	
		$query = $db->query ( "SELECT id,title,content,dateline FROM news_list ORDER BY id DESC LIMIT 20" );
		$data['list'] = $query->result_array ();
		$data['radio'] = $radio;
	
		$this->load->view ( 'admin/news_list_910', $data );
	}
	
	// 采集
	function gather() {
		$web = $_GET ['web'] ? $_GET ['web'] : 'sina';
		
		if ($web == 'sina') { // 新闻要闻
			$url = 'http://rss.sina.com.cn/news/marquee/ddt.xml';
		} else if ($web == 'ifeng') {
			$url = 'http://news.ifeng.com/rss/world.xml'; // 国际
		} else if ($web == 'people') {
			$url = 'http://www.people.com.cn/rss/politics.xml'; // 国内新闻
		} else if ($web == 'gxnews') {
			$url = 'http://www.gxnews.com.cn/rss/191.xml'; // 广西要闻
		}
		
		include APPPATH . 'libraries/rss.php';
		$rss = new lastRSS (); // 实例化
		$rss->cache_dir = 'cache'; // 设置缓存目录，要手动建立
		$rss->cache_time = 3600; // 设置缓存时间。默认为0，即随访问更新缓存；建议设置为3600，一个小时
		$rss->default_cp = 'UTF-8'; // 设置RSS字符编码，默认为UTF-8
		$rss->cp = 'UTF-8'; // 设置输出字符编码，默认为GBK
		$rss->items_limit = 50; // 设置输出数量，默认为10
		$rss->date_format = 'U'; // 设置时间格式。默认为字符串；U为时间戳，可以用date设置格式
		$rss->stripHTML = true; // 设置过滤html脚本。默认为false，即不过滤
		$rss->CDATA = 'content'; // 设置处理CDATA信息。默认为nochange。另有strip和content两个选项
		
		$data = $rss->Get ( $url ); // 处理RSS并获取内容
		$data ['web'] = $web;
		
		$this->load->view ( 'admin/news_rss_list', $data );
	}
	
	// 微路新闻 展示页 模板设置
	function template() {		
		$data['value'] = $this->cache->get('news_setting');
		
		$this->load->view ( 'admin/news_template', $data );
	}
	
	// 微路新闻 展示页 模板设置
	function template_save() {
		$data = trims ( $_POST ['value'] );
// 		$a = $this->cache->get('news_setting2');
		print_r($data);
// 		print_r(get_cache('website'));
// 		print_r($data);
// 		$this->cache->save('news_setting2', $data, $this->ttl);
// 		show_msg ( '设置完成', 'index.php?d=admin&c=news&m=template' );	
	}
	
	// 从910采集中心采集新闻
	public function getNewsFrom910() {		
		$news910id = intval ( $this->cache->get ( 'news910id' ) );		
		$db = $this->load->database ( 'newsroom', TRUE );
		$query = $db->query ( "SELECT id,title,content FROM news_list WHERE id>$news910id AND typeid IN (40,10,49,50,16) ORDER BY id DESC LIMIT 12" );
		$list = $query->result_array ();
		if (! empty ( $list )) {
			foreach ( $list as $value ) {
				// 插入数据
				$data = array (
						'title' => $value [title],
						'content' => $value [content],
						'catid' => 1,
						'addtime' => time () 
				);
				$this->db->insert ( 'fm_news', $data );
			}
			$news910id = $list [0] [id];
		}
		
		// 保存最后的 新闻id
		$this->cache->save ( 'news910id', $news910id, 31536000 );
		show_msg ( '采集完成！', 'index.php?d=admin&c=news&m=index' );
	}
	
	// 从970采集中心采集新闻
	public function getNewsFrom970() {
		$news970id = intval ( $this->cache->get ( 'news970id' ) );		
		$db = $this->load->database ( 'newsgroup', TRUE );
		$query = $db->query ( "SELECT id,title,content FROM news_list WHERE id>$news970id AND radiotype='970' ORDER BY id DESC LIMIT 12" );
		$list = $query->result_array ();	
		if (! empty ( $list )) {
			foreach ( $list as $value ) {
				// 插入数据
				$data = array (
						'title' => $value [title],
						'content' => $value [content],
						'catid' => 4,
						'addtime' => time ()
				);
				$this->db->insert ( 'fm_news', $data );
			}
			$news970id = $list [0] [id];
		}	
		
		// 保存最后的 新闻id
		$this->cache->save ( 'news970id', $news970id, 31536000 );
		show_msg ( '采集完成！'.$news970id, 'index.php?d=admin&c=news&m=index' );
	}
	
	// 模板管理
	function template_manager() {
		
		if(!$_GET['catid']) {
			$_GET['catid'] = 1;
		}
		/*	以下是缓存保存形式	
		$data['value'] = $this->cache->get("news_setting".$_GET['catid']);
		print_r($data['value']);
		$this->load->view ( 'admin/' . $this->control . '_template_manager', $data);
	*/
		
		// 以下是数据库保存形式
		$sql = "SELECT * from fm_news_template where catid = ".$_GET['catid'];
		$query = $this->db->query($sql);
		$data['value'] = $query->row_array();
		$this->load->view ( 'admin/' . $this->control . '_template_manager', $data);
	}
	
	// 模板保存和修改
	function template_manager_save() {
		$data = trims ( $_POST ['value'] );
		/*	以下是缓存保存形式
		$this->cache->save("news_setting".$data['catid'],$data,31536000);
		*/
		$sql = "SELECT * from fm_news_template where catid = ".$data['catid'];
		$query = $this->db->query($sql);
		$row = $query->row_array();
		$condiction['catid'] = $data['catid'];
		if($row) {
// 			$this->db->where($condiction);
			$this->db->update('fm_news_template', $data, $condiction);
			show_msg ( '修改成功！');
		}
		else {
			$this->db->insert('fm_news_template', $data);
			show_msg ( '添加成功！');
		}
	}
	
}
