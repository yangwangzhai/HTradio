<?php
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL & ~E_DEPRECATED);
    /*
   php多图片上传程序2.0
   www.qhjsw.net
   qhjsw@qhjsw.net
   QQ:909507090
   敬请注意：本程序为开源程序，你可以使用本程序在任何的商业、非商业项目或者网站中。但请你务必保留代码中相关信息（页面logo和页面上必要的链接可以清除），
	  请为本论坛（www.qhjsw.net）加上网址链接，谢谢支持。作为开发者你可以对相应的后台功能进行扩展（增删改相应代码）,但请保留代码中相关来源信息（例如：本论坛网址，邮箱等）。
          如果你进行了修改请务必把修改过的程序以邮件形式发送给本人（qhjsw#qhjsw.net #号换为@）。谢谢合作！
   */

     //为建立一个会话工作因为不发闪光播放器的饼乾
	if (isset($_POST["PHPSESSID"])) {
		session_id($_POST["PHPSESSID"]);
	} else if (isset($_GET["PHPSESSID"])) {
		session_id($_GET["PHPSESSID"]);
	}
	session_start();
	
	$type = "";
	if (isset($_POST["type"])) {
		$type =$_POST["type"];
	} else if (isset($_GET["type"])) {
		$type =$_GET["type"];
	}
	
	$id = "-1";
	if (isset($_POST["id"])) {
		$id =$_POST["id"];
	} else if (isset($_GET["id"])) {
		$id =$_GET["id"];
	}
	
	//检验post的最大上传的大小
	$POST_MAX_SIZE = ini_get('post_max_size');
	$unit = strtoupper(substr($POST_MAX_SIZE, -1));
	$multiplier = ($unit == 'M' ? 1048576 : ($unit == 'K' ? 1024 : ($unit == 'G' ? 1073741824 : 1)));

	if ((int)$_SERVER['CONTENT_LENGTH'] > $multiplier*(int)$POST_MAX_SIZE && $POST_MAX_SIZE) {
		header("HTTP/1.1 500 Internal Server Error"); // This will trigger an uploadError event in SWFUpload
		echo "fai:超过最大允许后的尺寸";
		exit(0);
	}
	
	// 设置
	$dir_file=date("Ymd");  //获取当前时间
	$wpf=date('YmdHis');
	$save_path = getcwd() . '/uploads/file/'.$dir_file.'/';				// 保存的路径
	$upload_name = "Filedata";
	$max_file_size_in_bytes = 2147483647;				// 2GB in bytes 最大上传的文件大小为2G
	$extension_whitelist = array(
                'gif',
                'jpg',
                'jpeg',
                'png',
                'bmp',
                'doc',
                'docx',
                'xls',
                'xlsx',
                'ppt',
                'htm',
                'html',
                'txt',
                'zip',
                'rar',
                'gz',
                'bz2',
				'swf',
                'flv',
                'mp3',
				'mp4',
                'wav',
                'wma',
                'wmv',
                'mid',
                'avi',
                'mpg',
                'asf',
                'rm',
                'rmvb'
        );	// 上传允许的文件扩展名称 gif', 'jpg', 'jpeg', 'png', 'jpe
	$valid_chars_regex = '.A-Z0-9_ !@#$%^&()+={}\[\]\',~`-'; //允许在文件名字符(在一个正则表达式格式)

	//其他的验证
	$MAX_FILENAME_LENGTH = 260;
	$file_name = "";
	$file_extension = "";
	$uploadErrors = array(
        0=>"没有错误,文件上传有成效",
        1=>"上传的文件的upload_max_filesize指令在你只有超过",
        2=>"上传的文件的超过MAX_FILE_SIZE指示那个没有被指定在HTML表单",
        3=>"未竟的上传的文件上传",
        4=>"没有文件被上传",
        6=>"错过一个临时文件夹"
	);
	
	$file_names = $_FILES[$upload_name]['name'];
	$file_names = iconv("UTF-8","GB2312",$file_names);
	
	//验证上传
	if (!isset($_FILES[$upload_name])) {
		HandleError("fai:没有发现上传 \$_FILES for " . $upload_name);
		exit(0);
	} else if (isset($_FILES[$upload_name]["error"]) && $_FILES[$upload_name]["error"] != 0) {
		HandleError($uploadErrors[$_FILES[$upload_name]["error"]]);
		exit(0);
	} else if (!isset($_FILES[$upload_name]["tmp_name"]) || !@is_uploaded_file($_FILES[$upload_name]["tmp_name"])) {
		HandleError("fai:Upload failed is_uploaded_file test.");
		exit(0);
	} else if (!isset($file_names)) {
		HandleError("fai:文件没有名字.");
		exit(0);
	}
	
	// 验证这个文件的大小(警告:最大的文件支持这个代码2 GB)
	$file_size = @filesize($_FILES[$upload_name]["tmp_name"]);
	if (!$file_size || $file_size > $max_file_size_in_bytes) {
		HandleError("fai:超过最高允许的文件的大小");
		exit(0);
	}
	
	if ($file_size <= 0) {
		HandleError("fai:超出文件的最小大小");
		exit(0);
	}
	
	// 验证文件名称(对于我们而言我们只会删除无效字符)
	$file_name = preg_replace('/[^'.$valid_chars_regex.']|\.+$/i', "", basename($_FILES[$upload_name]['name']));
	if (strlen($file_name) == 0 || strlen($file_name) > $MAX_FILENAME_LENGTH) {
		HandleError("fai:无效的文件");
		exit(0);
	}
	
	//确认我们不会地盖写现有的一个文件
	if (file_exists($save_path . $file_name)) {
		HandleError("fai:这个名字的文件已经存在");
		exit(0);
	}
	
	//验证文件扩展名
	$path_info = pathinfo($file_names);
	$file_extension = $path_info["extension"];
	$is_valid_extension = false;
	foreach ($extension_whitelist as $extension) {
		if (strcasecmp($file_extension, $extension) == 0) {
			$is_valid_extension = true;
			break;
		}
	}
	
	if (!$is_valid_extension) {
		HandleError("fai:无效的扩展名");
		exit(0);
	}
	
	if (file_exists($save_path . $file_name)) {
		HandleError("fai:这个文件的名称已经存在");
		exit(0);
	}
	
	
	define('BASEPATH',true);
//	include("application/config/database.php");
	
		
	if(is_dir('uploads/file/'.$dir_file)){ 
		$fileName=CreateNextName($file_extension,$save_path);
		if(!move_uploaded_file($_FILES[$upload_name]["tmp_name"], $save_path.$fileName)) {
			HandleError("fai:文件移动失败");
			exit(0);
	 	}
	 	else {
				$sucfilename = "uploads/file/".$dir_file."/".$fileName;				
			//	InsertAudio($type,$sucfilename,$id); //插入音频
				
	 			HandleError("suc:/uploads/file/".$dir_file."/,".$fileName.",".$file_size);				
				
	 			exit(0);
	 		}	
	}else{
		if(mkdir('uploads/file/'.$dir_file)){
			$fileName=CreateFirstName($file_extension );
			if(!move_uploaded_file($_FILES[$upload_name]["tmp_name"], $save_path.$fileName)) {
				HandleError("fai:文件移动失败");
				exit(0);
	 		}
	 		else {
				$sucfilename = "uploads/file/".$dir_file."/".$fileName;				
			//	InsertAudio($type,$sucfilename,$id); //插入音频
				
	 			HandleError("suc:/uploads/file/".$dir_file."/,".$fileName.",".$file_size);								
	 			exit(0);
	 		}	
		}
		else {
			HandleError("fai:创建目录失败");
			exit(0);
		}
	}
	exit(0);
	
	//错误
	function HandleError($message) {
		echo $message;
	}
//参数是文件的扩展名称
function CreateFirstName($file_extension ){
	$num=100001;
	$fileName=$num.".".$file_extension;
	return $fileName;
}

//参数是文件的扩展名称
function CreateNextName($file_extension,$file_dir){
	//在文件的目录下找最大的;
	$fileName_arr = scandir($file_dir,1);
	$fileName=$fileName_arr[0];
	$aa=explode('.',$fileName);
	$num=$aa[0]+1;
if(empty($aa[0]))
{
	$num = 100001;
}
	return $num.".".$file_extension;
	
}

function InsertAudio($type,$sucfilename ,$id){
	global  $db;
	$conn= mysql_connect($db['default']['hostname'],$db['default']['username'],$db['default']['password'])or die("连接失败：".mysql_error());
	mysql_select_db($db['default']['database'],$conn);
	if($type == "video"){		
		$result = mysql_query("SELECT * FROM fm_publicdata  WHERE TYPE='".$type."' ",$conn);	
		$re_num = mysql_num_rows($result);
		if($re_num > 0){
			$sql="UPDATE fm_publicdata SET  url='".$sucfilename."' WHERE  TYPE='".$type."'";	
		}else{
			$time = time();
			$sql="INSERT INTO  fm_publicdata  (url,type,addtime)VALUES('".$sucfilename."','".$type."',".$time.") ";
		}		
		mysql_query($sql,$conn);	
		
		
		
	}
	
	if($type == "audio"){
		
		$arr = explode( '.' , $sucfilename );
		$filename= $arr[count($arr)-1];	
			if($filename == 'wav' || $filename == 'wma'){		
				$mp3 = str_replace($filename,'mp3',$sucfilename);
				exec('ffmpeg.exe -i '.$sucfilename.' '.$mp3);
				@unlink ($sucfilename);
				$sucfilename = $mp3;
				 
			}
		
		if($id == '0' || $id == 0){			
			$time = time();
			$sql="INSERT INTO  fm_publicdata  (url,type,addtime)VALUES('".$sucfilename."','".$type."',".$time.") ";
		}
		if( intval($id) > 0 ){
			$sql="UPDATE fm_publicdata SET  url='".$sucfilename."' WHERE  id='".$id."'";	
		}
		mysql_query($sql,$conn);	
	}
}


?>
