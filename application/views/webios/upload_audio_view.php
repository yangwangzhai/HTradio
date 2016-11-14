<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>上传音频</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="http://g.alicdn.com/msui/sm/0.6.2/css/sm.min.css">
    <link rel="stylesheet" href="http://g.alicdn.com/msui/sm/0.6.2/css/sm-extend.min.css">
      <link rel="stylesheet" href="static/webios/css/style.css?">
      <script type="text/javascript" src="static/js/jquery-1.7.1.min.js"></script>
</head>
<body>
<div class="page-group">
    <div class="page page-current" style="margin-top: 0.5rem;">
        <!-- 你的html代码 -->
        <header class="bar bar-nav">
           	       <a class="button button-link2 button-nav pull-left external" href="index.php?d=webios&c=webios&m=main_view" >
                返回
            </a>
            <h1 class='title'>上传音频</h1>
        </header>
        <div class="content">
            <form method="post" action="index.php?d=webios&c=webios&m=save_upload_audio" enctype="multipart/form-data">
                <div class="list-block">
                    <ul>
                        <!-- Text inputs -->
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-name"></i></div>
                                <div class="item-inner">
                                    <div class="item-input">
                                        <input type="hidden" name="MAX_FILE_SIZE" value="5000000">
                                        <div class="upload_audio_box"><input type="file" name="file" id="file"  value="" class="upload_audio"></div>
             <p class="upload_audio_title"></p>
             <script>
 $(document).ready(function () {
	  $(".upload_audio").change(function(){
      $(".upload_audio_box").addClass("add_audio_img");
	  var file_tile = $(".upload_audio").val();
      var fileName = getFileName(file_tile);
  
      function getFileName(o){
      var pos=o.lastIndexOf("\\");
      return o.substring(pos+1);  
}
      $(".upload_audio_title").html(fileName)

	  console.log(fileName);
	   
	  
  });
  

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
                        <div class="col-50"><a href="index.php?d=webios&c=webios&m=main_view" class="button button-big button-fill button-danger external">取消</a></div>
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