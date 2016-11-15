<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>软件更新</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="http://g.alicdn.com/msui/sm/0.6.2/css/sm.min.css">
    <link rel="stylesheet" href="http://g.alicdn.com/msui/sm/0.6.2/css/sm-extend.min.css">
     <link rel="stylesheet" href="static/webios/css/style.css?23">
      <script type="text/javascript" src="static/js/jquery-1.7.1.min.js"></script>
</head>
<body>
<div class="page-group">
    <div class="page page-current" style="margin-top: 0.5rem;">
        <!-- 你的html代码 -->
        <header class="bar bar-nav" style="background:#39F; color:#fff">
           	       <a class="button button-link button-nav pull-left external" href="index.php?d=webios&c=webios&m=main_view" >
                返回
            </a>
            <h1 class='title' style="color:#fff">软件更新</h1>
        </header>
        <div class="content" style="top:3rem;">
        <div class="update">
           
         <a href="#" class="icon icon-update"></a>
         <p class="update_txt">检测更新 </p>
       
  <script>
  $(document).ready(function () {
  $(".icon-update").click(function(){
  niceIn($(this));

});
  function niceIn(prop){
	  
	$(".icon-update").addClass('circle');
	setTimeout(function(){
    $(".icon-update").removeClass('circle');	
	},3000);		
}
    });
  </script>
                 
                </div> 
                
                <div class="update_content">
                    <div class="row">
                     
                        <div class="col-100"><input type="submit" class="button button-big button-fill button-success button-update" value="下载更新包"></div>
                        
                    
                    </div>
                    <div class="update_text">
                        <p class="update_ver">海豚FM <em><?=$web['version']?></em></p>
                        <p>当前已是最新版本！</p>
                    </div>
                    </div>
        </div>

    </div>
</div>


</body>
</html>