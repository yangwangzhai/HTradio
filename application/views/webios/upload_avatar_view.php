<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>用户注册</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/sm.min.css">
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/sm-extend.min.css">
    <link rel="stylesheet" href="static/webios/css/style.css?">
    <script type="text/javascript" src="static/js/jquery-1.7.1.min.js"></script>
</head>
<body>
<div class="page-group">
    <div class="page page-current" style="margin-top: 0.5rem;">
        <!-- 你的html代码 -->
        <header class="bar bar-nav">
        	       <a class="button button-link2 button-nav pull-left external" href="index.php?d=webios&c=webios&m=main_view&mid=<?=$mid?>" >
                返回
            </a>
            <h1 class='title'>上传头像</h1>
        </header>
        <div class="content">
            <form method="post" action="index.php?d=webios&c=webios&m=save_upload_avatar" enctype="multipart/form-data">
                <input type="hidden" name="mid" value="<?=$mid?>">
                <div class="list-block">
                    <ul>
                        <!-- Text inputs -->
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-name"></i></div>
                                <div class="item-inner">
                                    <div class="item-input">
                                     <div class="upload_avatar_box"><img class="upload_avatar_img" style=" display: none;"/><input type="file" name="file" id="file" accept="image/*"  value="" class="upload_avatar"></div>
            <script>
 $(document).ready(function () {
	  $(".upload_avatar").change(function(){
      $(".upload_avatar_box").addClass("add_avatar_img");
      var imgname=$(".upload_avatar").val();
     $(".upload_avatar_img").show();
     var objUrl = getObjectURL(this.files[0]) ;
	 console.log("objUrl = "+objUrl) ;
	if (objUrl) {
		$(".upload_avatar_img").attr("src", objUrl) ;
	}
	
	
	  console.log(imgname);
	   
	  
  });
  
function getObjectURL(file) {
	var url = null ; 
	if (window.createObjectURL!=undefined) { // basic
		url = window.createObjectURL(file) ;
	} else if (window.URL!=undefined) { // mozilla(firefox)
		url = window.URL.createObjectURL(file) ;
	} else if (window.webkitURL!=undefined) { // webkit or chrome
		url = window.webkitURL.createObjectURL(file) ;
	}
	return url ;
}
 });
	 

</script> 
                                    </div>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>
                <div class="content-block">
                    <div class="row">
                        <div class="col-50"><a href="index.php?d=webios&c=webios&m=main_view&mid=<?=$mid?>" class="button button-big button-fill button-danger external">取消</a></div>
                        <div class="col-50"><input type="submit" class="button button-big button-fill button-success" value="提交"></div>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

<script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm-extend.min.js' charset='utf-8'></script>
</body>
</html>