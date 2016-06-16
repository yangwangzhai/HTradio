<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>欢迎登录后台管理系统</title>
	<link href="static/ql/css/style.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" src="static/ql/js/jquery.js"></script>


	<script language="javascript">
		$(function(){
			$('.loginbox').css({'position':'absolute','left':($(window).width()-578)/2});
			$(window).resize(function(){
				$('.loginbox').css({'position':'absolute','left':($(window).width()-578)/2});
			})
		});
	</script>

</head>

<body style="background-color:#1c77ac; background-image:url(static/ql/images/light.png); background-repeat:no-repeat; background-position:center top; overflow:hidden;">

<div class="logintop">
	<span>欢迎登录后台管理界面平台</span>
	<ul>
		<li><a href="index.php?d=admin&c=common&m=login">回首页</a></li>
		<li><a href="#">帮助</a></li>
		<li><a href="#">关于</a></li>
	</ul>
</div>
<form action="index.php?d=admin&c=common&m=check_login" method="post">
<div class="loginbody">
	<span class="systemlogo"></span>
	<div class="loginbox">
		<h1>用户登录</h1>
		<ul>
			<li><input name="username" type="text" class="loginuser" value="" /></li>
			<li><input name="password" type="password" class="loginpwd" value="" /></li>
			<li><input  type="submit" class="loginbtn" value="登录"  /><label><input name="" type="checkbox" value="" checked="checked" />记住密码</label><label><a href="#">忘记密码？</a></label></li>
		</ul>
	</div>
</div>
</form>


<div class="loginbm">版权所有  2016  <a href="http://vroad.bbrtv.com">广西人民广播电台</a> </div>


</body>

</html>
