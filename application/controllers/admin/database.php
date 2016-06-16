<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class database extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'database';
        $this->baseurl = 'index.php?d=admin&c=database';
        $this->table = 'fm_download';
        $this->list_view = 'database';
        $this->add_view = 'download_add';
		$this->database =$this->db->database;
		// 换行符
    	$this->ds = "\n";
    	// 存储SQL的变量
   		$this->sqlContent = "";
    	// 每条sql语句的结尾符
    	$this->sqlEnd = ";";
		$this->msg = '';
		$this->sqldir = ''; // 数据库备份文件夹   
    }
    
    // 首页
    public function index ()
    {		
		$tables = mysql_query ( 'SHOW TABLES' );
		while ( $table = mysql_fetch_array ( $tables ) ) {
			// 获取表名
           $tablenames[] = $table [0];
		}		
		$tablelist = '';		
		$rowcount = 0;
		foreach( $tablenames as $value) {
			$tablelist .= ($rowcount % 4 ? '' : '</tr><tr>')."<td id='$value'><input type='checkbox' id='customtabless' name='customtables[]' value='$value' checked>$value</td>\n";
			$rowcount ++;
		}
		$tablelist .= '</tr>';		
		$data['tablelist'] = $tablelist;	
		$data['filename'] =  date ( 'Ymd' ) .'_'. date( 'His' ) . "_all";	
        $this->load->view('admin/' . $this->list_view, $data);
    }
    
	//导入文件夹列表
	function import_index(){
		
			
		$exportlog = array();
		
		$dir = './backup/data';
			
		 $dh = @opendir($dir);             //打开目录，返回一个目录流
         $return = array();
         $i = 0; 
		
          while($file = @readdir($dh)){     //循环读取目录下的文件
		 
             if($file!='.' and $file!='..'){
				  
              $path = $dir.'/'.$file;     //设置目录，用于含有子目录的情况
              if(is_dir($path)){
				 
				 $return[]['name']= $path; 
								
          	  }	
			
		}
	}  // print_r($dir_objects);exit;
		
		$data['list']=$return;
		//var_dump($exportlog);exit;
	    array_multisort($data['list'], SORT_DESC, SORT_REGULAR , $return);
		
		
		$this->load->view('admin/database_import_index', $data);
	
		  
		  
		  
}
	//导入 数据库文件列表
		function import(){
		
			
			$url=$_GET['url'];
		$exportlog = array();
		$datadir = '.';
		$backupdir = 'backup/data';
		if(is_dir($url)) { 
			$dir = dir($url);
			while(FALSE !== ($entry = $dir->read())){
				$filename = $url.'/'.$entry;
				$basefile = $url.'/'.$entry;
				if(is_file($filename)){
					$filesize = filesize($filename);
					if(preg_match('/\.sql$/i', $filename)) {
						$fp = fopen($filename, 'rb');
						$identify = explode(',', base64_decode(preg_replace('/^# Identify:\s*(\w+).*/s', '\\1', fgets($fp, 256))));
						fclose($fp);
						$exportlog[] = array(
							'version' => $identify[1],
							'type' => $identify[2],
							'method' => $identify[3],
							'volume' => $identify[4],
							'filename' => $basefile,
							'name'=>$entry,
							'dateline' => filectime($filename),
							'size' => $filesize
							);
					} elseif(preg_match('/\.zip$/i', $filename)) {
						$exportlog[] = array(
							'type' => 'zip',
							'filename' => $basefile,
							'size' => $filesize,
							'name'=>$entry,
							'dateline' => filectime($filename),
							'method' => '',
						);
					}
				}
			}
			$dir->close();
		} else {
			
		}
		$data['list']=$exportlog;
		array_multisort($data['list'], SORT_ASC, SORT_REGULAR , $exportlog);
		$this->load->view('admin/database_import', $data);
	}
	
	
	
	
	
	
	
	
	function getFileList($directory) {        
		$files = array();        
		if(is_dir($directory)) {        
			if($dh = opendir($directory)) {        
				while(($file = readdir($dh)) !== false) {        
					if($file != '.' && $file != '..') {        
						$files[] = $file;        
					}        
				}   
				closedir($dh);        
			}        
		}        
		return $files;        
	}        
	
	
	
	function backup_shell($file , $filename){   
		$this->load->dbutil(); 
		$this->load->helper('file');
 		$filename = $filename . '.sql';
		$prefs = array(
                'tables'      => array(),  // 包含了需备份的表名的数组.
                'ignore'      => array(),           // 备份时需要被忽略的表
                'format'      => 'txt',             // gzip, zip, txt
                'filename'    => $filename,    // 文件名 - 如果选择了ZIP压缩,此项就是必需的
                'add_drop'    => TRUE,              // 是否要在备份文件中添加 DROP TABLE 语句
                'add_insert'  => TRUE,              // 是否要在备份文件中添加 INSERT 语句
                'newline'     => "\n"               // 备份文件中的换行符
              );
 		$this->_showMsg("正在备份...");
		$backup = $this->dbutil->backup($prefs);
 		 // 创建目录
        if (! is_dir ( $file )) {
            mkdir ( $file, 0777, true );
        }
		write_file($file.$filename, $backup);
	
	}
   
     /**
     * 数据库备份
     * 参数：备份哪个表(可选),备份目录(可选，默认为backup),分卷大小(可选,默认2000，即2M)
     *
     * @param $string $dir
     * @param int $size
     * @param $string $tablename
     */
    function backup() {
		$tablename = '';
		$dir = '' ;
		$size = $_POST['sizelimit'];
		$filename = $_POST['filename'];
	    $type = $_POST['type'];
		$method = $_POST['method'];
		
          $dir = $dir ? $dir : './backup/data/'.date ( 'Ymd' ).date( 'Hi' ) .'/';
		$filename = $filename ? $filename :  date ( 'Ymd' ) .'_'. date( 'His' ) . "_all";	
		//不分卷备份
		if($method == 'shell'){
			$this->backup_shell($dir,$filename);
			$this->_showMsg("恭喜您! <span class='imp'>备份成功</span>,备份文件 [ <span class='imp'>" .$dir . $filename .".sql</span> ]");
			exit;
		}
		
		
        // 创建目录
        if (! is_dir ( $dir )) {
            mkdir ( $dir, 0777, true ) or die ( '创建文件夹失败' );
        }
        $size = $size ? $size : 2048;
        $sql = '';
        // 只备份某个表
        if (! empty ( $tablename )) {
            if(@mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$tablename."'")) == 1) {
             } else {
                $this->_showMsg('表-<b>' . $tablename .'</b>-不存在，请检查！',true);
                die();
            }
            $this->_showMsg('正在备份表 <span class="imp">' . $tablename.'</span>');
            // 插入dump信息
            $sql = $this->_retrieve ();
            // 插入表结构信息
            $sql .= $this->_insert_table_structure ( $tablename );
            // 插入数据
            $data = mysql_query ( "select * from " . $tablename );
            // 文件名前面部分
            $filename = date ( 'YmdHis' ) . "_" . $tablename;
            // 字段数量
            $num_fields = mysql_num_fields ( $data );
            // 第几分卷
            $p = 1;
            // 循环每条记录
            while ( $record = mysql_fetch_array ( $data ) ) {
                // 单条记录
                $sql .= $this->_insert_record ( $tablename, $num_fields, $record );
                // 如果大于分卷大小，则写入文件
                if (strlen ( $sql ) >= $size * 1024) {
                    $file = $filename . "_v" . $p . ".sql";
                    if ($this->_write_file ( $sql, $file, $dir )) {
                        $this->_showMsg("表-<b>" . $tablename . "</b>-卷-<b>" . $p . "</b>-数据备份完成,备份文件 [ <span class='imp'>" .$dir . $file ."</span> ]");
                    } else {
                        $this->_showMsg("备份表 -<b>" . $tablename . "</b>- 失败",true);
                        return false;
                    }
                    // 下一个分卷
                    $p ++;
                    // 重置$sql变量为空，重新计算该变量大小
                    $sql = "";
                }
            }
            // 及时清除数据
            unset($data,$record);
            // sql大小不够分卷大小
            if ($sql != "") {
                $filename .= "_v" . $p . ".sql";
                if ($this->_write_file ( $sql, $filename, $dir )) {
                    $this->_showMsg( "表-<b>" . $tablename . "</b>-卷-<b>" . $p . "</b>-数据备份完成,备份文件 [ <span class='imp'>" .$dir . $filename ."</span> ]");
                } else {
                    $this->_showMsg("备份卷-<b>" . $p . "</b>-失败");
                    return false;
                }
            }
            $this->_showMsg("恭喜您! <span class='imp'>备份成功</span>");
        } else {
            $this->_showMsg('正在备份');
            // 备份全部表
            if ($tables = mysql_query ( "show table status from " . $this->database )) {
                $this->_showMsg("读取数据库结构成功！");
            } else {
                $this->_showMsg("读取数据库结构失败！");
                exit ( 0 );
            }
            
           
            $table_list = array();
			if($type == 'all'){
				// 查出所有表
				$tables = mysql_query ( 'SHOW TABLES' );
				
				while ( $table = mysql_fetch_array ( $tables ) ) {
					// 获取表名
					$table_list[] = $table [0];
				}
			}else{
				$table_list = $_POST['customtables'];				
				
			}
			
            // 第几分卷
            $p = 1;
			
            // 循环所有表
            foreach ( $table_list as $tablename ) {
                           
                // 获取表结构
                $sql .= $this->_insert_table_structure ( $tablename );
                $data = mysql_query ( "select * from " . $tablename );
                $num_fields = mysql_num_fields ( $data );

                // 循环每条记录
                while ( $record = mysql_fetch_array ( $data ) ) {
                    // 单条记录
                    $sql .= $this->_insert_record ( $tablename, $num_fields, $record );
                    // 如果大于分卷大小，则写入文件
                    if (strlen ( $sql ) >= $size * 1024) {
						// 插入dump信息
           		 		$sqldump = $this->_retrieve ($type, $p , $method);  
                        $file = $filename . "_v" . $p . ".sql";
                        // 写入文件
						$insert = $this->_write_file ( $sqldump . $sql, $file, $dir );
                        if ($insert) {							
                            $this->_showMsg("-卷-<b>" . $p . "</b>-数据备份完成,备份文件 [ <span class='imp'>".$dir.$file."</span> ]");
                        } else {
                            $this->_showMsg("卷-<b>" . $p . "</b>-备份失败!",true);
                            return false;
                        }
                        // 下一个分卷
                        $p ++;
                        // 重置$sql变量为空，重新计算该变量大小
                        $sql = "";
                    }
                }
            }
            // sql大小不够分卷大小
            if ($sql != "") {
				// 插入dump信息
           		$sqldump = $this->_retrieve ($type,$p,$method);
                $filename .= "_v" . $p . ".sql";
                if ($this->_write_file ( $sqldump . $sql, $filename, $dir )) {
                    $this->_showMsg("-卷-<b>" . $p . "</b>-数据备份完成,备份文件 [ <span class='imp'>".$dir.$filename."</span> ]");
                } else {
                    $this->_showMsg("卷-<b>" . $p . "</b>-备份失败",true);
                    return false;
                }
            }
            $this->_showMsg("恭喜您! <span class='imp'>备份成功</span>");
        }
    }

    //  及时输出信息
    public function _showMsg($message,$err=false){
    //  obclean();
		ob_end_clean();  
		echo str_pad(" ", 256);  
		$err = $err ? "<span class='err'>ERROR:</span>" : '' ;
        echo "<p class='dbDebug'>".$err . $message."</p>";
		ob_flush();
		flush();  
	//	ob_out();

    }

    /**
     * 插入数据库备份基础信息
     *
     * @return string
     */
    private function _retrieve($type,$volume,$method) {
      /*  $value = '';
        $value .= '--' . $this->ds;
        $value .= '-- MySQL database dump' . $this->ds;
        $value .= '-- Created by DbManage class, Power By yanue. ' . $this->ds;
        $value .= '-- http://yanue.net ' . $this->ds;
        $value .= '--' . $this->ds;
        $value .= '-- 主机: ' . $this->host . $this->ds;
        $value .= '-- 生成日期: ' . date ( 'Y' ) . ' 年  ' . date ( 'm' ) . ' 月 ' . date ( 'd' ) . ' 日 ' . date ( 'H:i' ) . $this->ds;
        $value .= '-- MySQL版本: ' . mysql_get_server_info () . $this->ds;
        $value .= '-- PHP 版本: ' . phpversion () . $this->ds;
        $value .= $this->ds;
        $value .= '--' . $this->ds;
        $value .= '-- 数据库: `' . $this->database . '`' . $this->ds;
		$value .= '-- time: ' . date('Y-m-d H:i:s') . '' . $this->ds;
		$value .= '-- type: ' . $type . '' . $this->ds;
        $value .= '--' . $this->ds . $this->ds;
        $value .= '-- -------------------------------------------------------';
        $value .= $this->ds . $this->ds;*/
		$time = date('Y-m-d H:i:s');
		$S_VER = '1.0';
		$idstring = '# Identify: '.base64_encode("$time,".$S_VER.",$type,$method,$volume")."\n";
		
		$sqldump = "$idstring".
			"# <?exit();?>\n".
			"# NewsRoom Multi-Volume Data Dump Vol.$volume\n".
			"# Version: cmradio 1.0\n".
			"# Time: $time\n".
			"# Type: $type\n".
			"# Table Prefix: fm_\n".
			"#\n".
			"# NewsRoom: http://www.NewsRoom.com\n".
			"# Please visit our website for newest infomation about cmradio\n".
			"# ---------------------------------------------------------\n\n\n".
			"$setnames";
		
		
        return $sqldump;
    }

    /**
     * 插入表结构
     *
     * @param unknown_type $table
     * @return string
     */
    private function _insert_table_structure($table) {
        $sql = '';
        $sql .= "--" . $this->ds;
        $sql .= "-- 表的结构" . $table . $this->ds;
        $sql .= "--" . $this->ds . $this->ds;

        // 如果存在则删除表
        $sql .= "DROP TABLE IF EXISTS `" . $table . '`' . $this->sqlEnd . $this->ds;
        // 获取详细表信息
        $res = mysql_query ( 'SHOW CREATE TABLE `' . $table . '`' );
        $row = mysql_fetch_array ( $res );
        $sql .= $row [1];
        $sql .= $this->sqlEnd . $this->ds;
        // 加上
        $sql .= $this->ds;
        $sql .= "--" . $this->ds;
        $sql .= "-- 转存表中的数据 " . $table . $this->ds;
        $sql .= "--" . $this->ds;
        $sql .= $this->ds;
        return $sql;
    }

    /**
     * 插入单条记录
     *
     * @param string $table
     * @param int $num_fields
     * @param array $record
     * @return string
     */
    private function _insert_record($table, $num_fields, $record) {
        // sql字段逗号分割
        $insert = '';
        $comma = "";
        $insert .= "INSERT INTO `" . $table . "` VALUES(";
        // 循环每个子段下面的内容
        for($i = 0; $i < $num_fields; $i ++) {
            $insert .= ($comma . "'" . mysql_real_escape_string ( $record [$i] ) . "'");
            $comma = ",";
        }
        $insert .= ");" . $this->ds;
        return $insert;
    }

    /**
     * 写入文件
     *
     * @param string $sql
     * @param string $filename
     * @param string $dir
     * @return boolean
     */
    private function _write_file($sql, $filename, $dir) {
        $dir = $dir ? $dir : './backup/';
        // 创建目录
        if (! is_dir ( $dir )) {
            mkdir ( $dir, 0777, true );
        }
        $re = true;
        if (! @$fp = fopen ( $dir . $filename, "w+" )) {
            $re = false;
            $this->_showMsg("打开sql文件失败！",true);
        }
        if (! @fwrite ( $fp, $sql )) {
            $re = false;
            $this->_showMsg("写入sql文件失败，请文件是否可写",true);
        }
        if (! @fclose ( $fp )) {
            $re = false;
            $this->_showMsg("关闭sql文件失败！",true);
        }
        return $re;
    }
   
   
   function dir_size($dir,$url){
     $dh = @opendir($dir);             //打开目录，返回一个目录流
     $return = array();
      $i = 0;
          while($file = @readdir($dh)){     //循环读取目录下的文件
             if($file!='.' and $file!='..'){
              $path = $dir.'/'.$file;     //设置目录，用于含有子目录的情况
              if(is_dir($path)){
          }elseif(is_file($path)){
              $filesize[] =  round((filesize($path)/1024),2);//获取文件大小
              $filename[] = $path;//获取文件名称                     
              $filetime[] = date("Y-m-d H:i:s",filemtime($path));//获取文件最近修改日期    
    
              $return[] =  $url.'/'.$file;
          }
          }
          }  
		 
          @closedir($dh);             //关闭目录流
          array_multisort($filesize,SORT_DESC,SORT_NUMERIC, $return);//按大小排序
          //array_multisort($filename,SORT_DESC,SORT_STRING, $files);//按名字排序
          //array_multisort($filetime,SORT_DESC,SORT_STRING, $files);//按时间排序
          return $return;               //返回文件
     }
   
   
   
   /**
     * 导入备份数据
     * 说明：分卷文件格式20120516211738_all_v1.sql
     * 参数：文件路径(必填)
     *
     * @param string $sqlfile
     */
    function restore() {
		
		//$list = $this->getFileList('./backup/data/');
		//var_dump($list);
		//exit;
		$sqlfile =  $_GET['sqlfile'];
		//.echo $sqlfile;exit;
        // 检测文件是否存在
        if (! file_exists ( $sqlfile )) {
            $this->_showMsg("sql文件不存在！请检查",true);
            exit ();
        }
        $this->lock ( $this->database );
        // 获取数据库存储位置
        $sqlpath = pathinfo ( $sqlfile );
        $this->sqldir = $sqlpath ['dirname'];
        // 检测是否包含分卷，将类似20120516211738_all_v1.sql从_v分开,有则说明有分卷
        $volume = explode ( "_v", $sqlfile );
        $volume_path = $volume [0];//var_dump(  $volume );var_dump(  $volume_path );exit;
        $this->_showMsg("请勿刷新及关闭浏览器以防止程序被中止，如有不慎！将导致数据库结构受损");
        $this->_showMsg("正在导入备份数据，请稍等！");
        if (empty ( $volume [1] )) {
            $this->_showMsg ( "正在导入sql：<span class='imp'>" . $sqlfile . '</span>');
            // 没有分卷
            if ($this->_import ( $sqlfile )) {
                $this->_showMsg( "数据库导入成功！");
            } else {
                 $this->_showMsg('数据库导入失败！',true);
                exit ();
            }
        } else {
            // 存在分卷，则获取当前是第几分卷，循环执行余下分卷
            $volume_id = explode ( ".sq", $volume [1] );
            // 当前分卷为$volume_id
            $volume_id = intval ( $volume_id [0] );
            while ( $volume_id ) {
                $tmpfile = $volume_path . "_v" . $volume_id . ".sql";
                // 存在其他分卷，继续执行
                if (file_exists ( $tmpfile )) {
                    // 执行导入方法
                    $this->_showMsg("正在导入分卷 $volume_id ：<span style='color:#f00;'>" . $tmpfile . '</span>');
                    if ($this->_import ( $tmpfile )) {

                    } else {
                        $volume_id = $volume_id ? $volume_id :1;
                        exit ( "导入分卷：<span style='color:#f00;'>" . $tmpfile . '</span>失败！可能是数据库结构已损坏！请尝试从分卷1开始导入' );
                    }
                } else {
                    $this->_showMsg( "此分卷备份全部导入成功！");
                    return;
                }
                $volume_id ++;
            }
        }
    }
	
	
	
	

    /**
     * 将sql导入到数据库（普通导入）
     *
     * @param string $sqlfile
     * @return boolean
     */
    private function _import($sqlfile) {
        // sql文件包含的sql语句数组
        $sqls = array ();
        $f = fopen ( $sqlfile, "rb" );
        // 创建表缓冲变量
        $create_table = '';
        while ( ! feof ( $f ) ) {
            // 读取每一行sql
            $line = fgets ( $f );
            // 这一步为了将创建表合成完整的sql语句
            // 如果结尾没有包含';'(即为一个完整的sql语句，这里是插入语句)，并且不包含'ENGINE='(即创建表的最后一句)
            if (! preg_match ( '/;/', $line ) || preg_match ( '/ENGINE=/', $line )) {
                // 将本次sql语句与创建表sql连接存起来
                $create_table .= $line;
                // 如果包含了创建表的最后一句
                if (preg_match ( '/ENGINE=/', $create_table)) {
                    //执行sql语句创建表
                    $this->_insert_into($create_table);
                    // 清空当前，准备下一个表的创建
                    $create_table = '';
                }
                // 跳过本次
                continue;
            }
            //执行sql语句
            $this->_insert_into($line);
        }
        fclose ( $f );
        return true;
    }

    //插入单条sql语句
    private function _insert_into($sql){
        if (! mysql_query ( trim ( $sql ) )) {
            $this->_showMsg( mysql_error ());
            return false;
        }
    }

    /*
     * -------------------------------数据库导入end---------------------------------
     */

    // 关闭数据库连接
    private function close() {
        mysql_close ( $this->db );
    }

    // 锁定数据库，以免备份或导入时出错
    private function lock($tablename, $op = "WRITE") {
        if (mysql_query ( "lock tables " . $tablename . " " . $op ))
            return true;
        else
            return false;
    }

    // 解锁
    private function unlock() {
        if (mysql_query ( "unlock tables" ))
            return true;
        else
            return false;
    }

    // 析构
   /* function __destruct() {
        if($this->db){
            mysql_query ( "unlock tables", $this->db );
            mysql_close ( $this->db );
        }
    }*/
	
	//删除
    public function delete() {
		
		//print_r($_POST['restore']);exit;
		//is_file($path)
			$dir = $_GET['dir'];
			$post=$_POST['dir'];
			if($dir){
			  if(is_dir($dir)){	
				if($this->dir_delete($dir)){//删除文件夹
				   show_msg('删除成功！');
				   }
			  }else{
				  if(unlink($dir)){//删除文件
				   show_msg('删除成功！');
				   }
				  
				  }
				   
		   }
		   if($post){
			   foreach($post as $k=>$v){
				  if(is_dir($v)){ 
				     $this->dir_delete($v);
				    }else{
						unlink($v);
						} 
				  }
			  show_msg('删除成功！');
			}
		   
		   
  
   }
   
   //删除文件夹
   function dir_delete($dir){
	  	if(is_dir($dir)){//2	 
			//先删除目录下的文件：
			   $dh=opendir($dir);
				while ($file=readdir($dh)) {//3
				   if($file!="." && $file!="..") {
						 $fullpath=$dir."/".$file;
						 if(!is_dir($fullpath)) {
								unlink($fullpath);
							 } else {
								deldir($fullpath);
						   }
				   }
				 }//3
			   closedir($dh);
			   if(rmdir($dir)){
				  return true;
				  }
			  
		}//2
	 
  
      }

       
   
	
	
	
	
	
	
	
	
}
