<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="static/ql/css/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="static/ql/js/jquery.js"></script>
<script type="text/javascript">
$(function(){	
	//顶部导航切换
	$(".nav li a").click(function(){
		$(".nav li a.selected").removeClass("selected")
		$(this).addClass("selected");
	})	
})	
</script>


</head>

<body style="background:url(static/ql/images/topbg.gif) repeat-x;">

    <div class="topleft">
    <a href="main.html" target="_parent"><img src="static/ql/images/logo.png" title="系统首页" /></a>
    </div>
        
    <ul class="nav">
    <li><a href="index.php?d=admin&c=common&m=right" target="rightFrame" class="selected"><img src="static/ql/images/icon01.png" title="首页" /><h2>首页</h2></a></li>
    <li><a href="index.php?d=admin&c=channel&m=index" target="rightFrame"><img src="static/ql/images/icon02.png" title="频道列表" /><h2>频道列表</h2></a></li>
    <li><a href="index.php?d=admin&c=program&m=index"  target="rightFrame"><img src="static/ql/images/icon03.png" title="节目列表" /><h2>节目列表</h2></a></li>
    <li><a href="index.php?d=admin&c=program_type&m=index"  target="rightFrame"><img src="static/ql/images/icon04.png" title="节目类型" /><h2>节目类型</h2></a></li>
    <!--<li><a href="index.php?d=admin&c=stat&m=program_stat" target="rightFrame"><img src="static/ql/images/icon05.png" title="节目统计" /><h2>节目统计</h2></a></li>-->
    <li><a href="index.php?d=admin&c=admin&m=index"  target="rightFrame"><img src="static/ql/images/icon06.png" title="系统设置" /><h2>系统设置</h2></a></li>
    </ul>
            
    <div class="topright">    
    <ul>
    <li><span><img src="static/ql/images/help.png" title="帮助"  class="helpimg"/></span><a href="#">帮助</a></li>
    <li><a href="#">关于</a></li>
    <li><a href="index.php?d=admin&c=common&m=login_out" target="_parent">退出</a></li>
    </ul>
     
    <div class="user">
    <span>今天是：<?php echo date("Y年m月d日",time());?> &nbsp;&nbsp;<?php echo config_item('week')[date("N",time())];?></span>
    </div>
    
    </div>

</body>
</html>
