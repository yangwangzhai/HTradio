<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>海豚电台</title>

<link href="static/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="static/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="static/js/koala.min.1.5.js"></script>
<script type="text/javascript" src="static/js/jquery.SuperSlide.2.1.1.js"></script>
<script type="text/javascript" src="static/js/lhgdialog/lhgdialog.min.js?self=true&skin=discuz"></script>
<script type="text/javascript" src="static/js/webfunction.js"></script>
<script type="text/javascript">
$(function(){
  
	$('.loginBtn').click(function(e){		
        e.stopPropagation();//阻止事件冒泡
		 $('.loginPanel_loginPop').toggle();
	})
	 $(document).click(function (event) { 
		 var target  = $(event.target);
        if(target.closest(".loginPanel_loginPop").length == 0){
            $(".loginPanel_loginPop").hide();
        }
	 	
	 });  
	 
	 
	$('.submitBtn').click(function(){formsubmit()});

  $('#password').keypress(function(e){
    var keycode = e.keyCode|| e.which;
    if(keycode == '13') {
      formsubmit();
    }
  });

  $("#search_btn").click(function(){
    var keyword = $.trim($("#search_txt").val());
    window.location.href="./index.php?c=search&keyword="+keyword;
  })
});
function formsubmit(){  
  
  var username = $.trim($('#username').val());
  var password = $.trim($('#password').val());  
  var remember = 0 ;
  
  if(username == ''){     
    $('.tip').html('请填写用户名！');
    return false;
  }
  
  if(password == ''){     
    $('.tip').html('请填写密码！');
    return false;
  }
  
  if($('#remember').attr("checked")){
    remember = 1;
  }
  
  $.post("index.php?c=member&m=check_login",{"u":username,"p":password,"y":'yzm',"r":remember},function(data){  
          
    if(data == 0){        
      $.dialog({
        title: '提示',
        time: 3, 
        icon: 'success.gif',
        titleIcon: 'lhgcore.gif',
        content: '登录成功！',
        ok:true,
        close:function(){
              location.reload();
          }

      }); 
    }
    
    if(data == 2){
      $('.tip').html('用户名密码错误！');
    }
      
    
    
  });
}
</script>
</head>
<body>
<div class="nav">
  <div class="navmain">
    	<div class="logo"><a href="./"><img src="static/images/logo.png" /></a></div>
        <div class="menu">
        	<ul>
            	<li><a href="./">首页</a></li>
                <li><a href="./index.php?c=index&m=find">发现</a></li>
                <li><a href="./index.php?c=index&m=ranklist">排行榜</a></li>
                <li><a href="./index.php?c=index&m=program">节目</a></li>
                <li><a href="./index.php?c=personal">我的电台</a></li>
                <li><a href="./index.php?c=download">APP下载</a></li>
            </ul>
    </div>
    <div class="search">
            <input id="search_txt" type="text" placeholder="搜索节目" value="<?=$keyword?>" class="text">
            <input id="search_btn" type="button" value="" class="submit">
        </div>
        <div class="upload"><a href="./index.php?c=upload&m=index"><img src="static/images/btn_upload.png" /></a></div>
    </div>
</div>
<?php $uid = $this->session->userdata('uid');
	  $nickname = $this->session->userdata('nickname');
?>
<div class="floatHeader">
	<div class="floatHeader_wrapper">
     <?php if ($uid){ ?> 
		<div class="search-panel header-search">
  			<p style="line-height: 36px; float: right;"> 欢迎您，<a href="index.php?c=personal"><?=$nickname?></a> , 
            <a onclick="return confirm('确定要退出吗？');" href="./index.php?c=member&m=login_out">退出</a></p>
        </div>
     <?php }else{    ?>      
       <div class="loginPanelBox">
        <div class="bgVLineL"></div>
        <div class="loginPanel">
          <p style="line-height: 36px; float: right;"> 
          <a href="javascript:;" style="margin-right: 10px;" class="loginBtn">登录</a>
          <a href="./index.php?c=member&m=reg"  class="registerBtn">注册</a>
          </p>

          
           <!-- 第三方账号登录 -->
           <div class="loginPanel_thirdLoginPop hidden" style="display:none;">
            <p><a class="qqLoginBtn" href="javascript:;"></a></p>
            <p><a class="weiboLoginBtn" href="javascript:;"></a></p>
            <p><a class="renrenLoginBtn" href="javascript:;"></a></p>
            <p><a class="login_click" href="javascript:;">用邮箱/手机登录</a></p>
            <div class="bud"></div>
           </div>
           <!-- 本地账号登录 -->
           <div class="loginPanel_loginPop hidden" style="display:none ;">
           
           		<div class="inputLine gapB">
                	<div class="left">账号</div>
                    <div class="right"><input type="text" id="username" class="username" value=""></div>
                </div>
                
            	<div class="inputLine">
                	<div class="left">密码</div>
                	<div class="right"><input type="password" id="password" class="password" value=""></div>
                </div>
                
            	<div class="inputLine is-inputLine-last"><div class="left"></div>
                  <div class="right">
                    <input type="checkbox" class="rememberMe" id="remember" value="">记住我
                    &nbsp;<a style="color:#3586bc;" href="#">忘记密码？</a>
                  </div>
            	</div>
            	<a class="submitBtn"></a>
                <div style="">
                  <a class="qqSmallLoginBtn" href="./index.php?d=qqoauth&c=index"><img src="static/images/qq_login.png"></a>
                  <a style="margin-top: 5px;" class="weiboSmallLoginBtn" href="./index.php?c=sin_login" ><img src="static/images/sina.png" width="120"></a>
                  <a class="renrenSmallLoginBtn" href="javascript:;"></a>
                  <a class="thirdlogin_click" href="javascript:;"></a>
                </div>
                <div class="tip" style="color:#F00;"></div>
            <div class="bud"></div>
          </div>
        </div>
      </div>
      <?php }?> 
       
  	</div>
</div>
<style>
.floatHeader {
 
  border-bottom: 1px solid #dddddd;
  border-top: 1px solid #dddddd;
  height: 36px;
  position: relative;
  width: 100%;
  z-index: 30;
}
.floatHeader .floatHeader_wrapper {
  height: 100%;
  margin: 0 auto;
  position: relative;
  width: 1050px;
}


.loginPanelBox {
    z-index: 20;
}

.loginPanelBox .loginPanel_loginPop .inputLine .username, .loginPanelBox .loginPanel_loginPop .inputLine .password {
  float: left !important;
  height: 100%;
  line-height: 14px;
  padding: 6px 8px;
  width: 147px;
   border: 1px solid #dddddd;
}

.loginPanelBox .loginPanel_loginPop .inputLine .right {
  float: right;
  width: 165px;
}

.loginPanelBox .loginPanel_loginPop .inputLine .left {
  float: left !important;
  width: 35px;
}

.loginPanelBox .loginPanel_loginPop .inputLine::before, .loginPanelBox .loginPanel_loginPop .inputLine::after {
  border-spacing: 0;
  content: "";
  display: table;
  line-height: 0;
}
.gapB {
  margin-bottom: 10px;
}

.loginPanelBox .loginPanel_MsgPop, .loginPanelBox .loginPanel_accountPop, .loginPanelBox .loginPanel_MenuPop {
    background: #fff none repeat scroll 0 0;
    border: 1px solid #ddd;
    box-shadow: 0 2px 5px 0 #eeeeee;
    padding: 1px;
    position: absolute;
    top: 36px;
    width: 105px;
}
.loginPanelBox .loginPanel_MsgPop .bud, .loginPanelBox .loginPanel_accountPop .bud, .loginPanelBox .loginPanel_MenuPop .bud {
    height: 5px;
    overflow: hidden;
    position: absolute;
    width: 10px;
}
.loginPanelBox .loginPanel_MsgPop .bud, .loginPanelBox .loginPanel_accountPop .bud, .loginPanelBox .loginPanel_MenuPop .bud {
    left: 70px;
    top: -5px;
}
.loginPanelBox .loginPanel_MsgPop .bud, .loginPanelBox .loginPanel_accountPop .bud, .loginPanelBox .loginPanel_MenuPop .bud {
    background-position: 0 -20px;
}
.loginPanelBox .loginPanel_accountPop a, .loginPanelBox .loginPanel_MenuPop a {
    color: #666666;
    cursor: pointer;
    display: block;
    height: 25px;
    line-height: 25px;
    padding: 0 9px;
}
.loginPanelBox .loginPanel_accountPop a:hover, .loginPanelBox .loginPanel_MenuPop a:hover {
    color: #333333;
    text-decoration: none;
    transition-duration: 0.3s;
    transition-property: color;
}
.loginPanelBox .loginPanel_accountPop a:hover, .loginPanelBox .loginPanel_MenuPop a:hover {
    background: #f5f5f5 none repeat scroll 0 0;
    transition-duration: 0.2s;
    transition-property: background-color;
    transition-timing-function: ease;
}
.loginPanelBox .loginPanel_accountPop {
    right: 50px;
}
.loginPanelBox .loginPanel_MenuPop {
    right: 0;
}
.loginPanelBox .loginPanel_MenuPop:hover .del {
    cursor: pointer;
    display: block;
}
.loginPanelBox .loginPanel_MenuPop .bud {
    left: 75px;
}
.loginPanelBox .loginPanel_MsgPop {
    color: #666666;
    cursor: pointer;
    padding: 5px 0;
    right: 0;
}
.loginPanelBox .loginPanel_MsgPop:hover .del {
    cursor: pointer;
    display: block;
}
.loginPanelBox .loginPanel_MsgPop:hover {
    color: #333333;
    text-decoration: none;
    transition-duration: 0.3s;
    transition-property: color;
}
.loginPanelBox .loginPanel_MsgPop li {
    padding: 0 10px;
}
.loginPanelBox .loginPanel_MsgPop li a {
    height: 25px;
    line-height: 25px;
}
.loginPanelBox .loginPanel_MsgPop .bud {
    left: 75px;
}
.loginPanelBox .loginPanel_loginPop, .loginPanelBox .loginPanel_thirdLoginPop {
    background: #fff none repeat scroll 0 0;
    border: 1px solid #ddd;
    box-shadow: 0 2px 5px 0 #eeeeee;
    right: 0;
    padding: 15px 10px;
    position: absolute;
    top: 36px;
}
.loginPanelBox .loginPanel_loginPop .bud, .loginPanelBox .loginPanel_thirdLoginPop .bud {
    height: 5px;
    overflow: hidden;
    position: absolute;
    width: 10px;
}
.loginPanelBox .loginPanel_loginPop .bud, .loginPanelBox .loginPanel_thirdLoginPop .bud {
    left: 50px;
    top: -5px;
}
.loginPanelBox .loginPanel_loginPop .bud, .loginPanelBox .loginPanel_thirdLoginPop .bud {
    background-position: 0 -20px;
}
.loginPanelBox .loginPanel_loginPop {
    width: 200px;
}
.loginPanelBox .loginPanel_loginPop .inputLine {
    height: 26px;
    line-height: 26px;
}
.loginPanelBox .loginPanel_loginPop .inputLine::before, .loginPanelBox .loginPanel_loginPop .inputLine::after {
    border-spacing: 0;
    content: "";
    display: table;
    line-height: 0;
}
.loginPanelBox .loginPanel_loginPop .inputLine::after {
    clear: both;
}
.loginPanelBox .loginPanel_loginPop .inputLine .left {
    float: left !important;
    width: 35px;
}
.loginPanelBox .loginPanel_loginPop .inputLine .right {
    float: right;
    width: 165px;
}
.loginPanelBox .loginPanel_loginPop .inputLine .username, .loginPanelBox .loginPanel_loginPop .inputLine .password {
    float: left !important;
    height: 100%;
    line-height: 14px;
    padding: 6px 8px;
    width: 147px;
}
.loginPanelBox .loginPanel_loginPop .inputLine .rememberMe {
    border: medium none;
    margin-right: 5px;
}
.loginPanelBox .loginPanel_loginPop .inputLine.is-inputLine-last {
    margin: 5px 0;
}
.loginPanelBox .loginPanel_loginPop .submitBtn {
    background: url("./static/images/auto.png") repeat scroll 0 -600px;
    cursor: pointer;
    display: inline-block;
    height: 33px;
    margin-bottom: 10px;
    overflow: hidden;
    padding: 0;
    vertical-align: middle;
    white-space: nowrap;
    width: 200px;
}
.loginPanelBox .loginPanel_loginPop .submitBtn span {
    background: url("static/images/auto.png") repeat scroll 0 0;
}
.loginPanelBox .loginPanel_loginPop .submitBtn:hover, .loginPanelBox .loginPanel_loginPop .submitBtn.hover {
    background-position: 0 -640px;
    text-decoration: none;
}
.loginPanelBox .loginPanel_loginPop .submitBtn:active {
    background-position: 0 -680px;
}
.loginPanelBox .loginPanel_loginPop .qqSmallLoginBtn {
    float: left !important;
    margin-right: 2px;
}
.loginPanelBox .loginPanel_loginPop .weiboSmallLoginBtn {
    float: left !important;
    margin-right: 5px;
}
.loginPanelBox .loginPanel_thirdLoginPop {
    width: 170px;
}
.loginPanelBox .loginPanel_thirdLoginPop .qqLoginBtn, .loginPanelBox .loginPanel_thirdLoginPop .weiboLoginBtn, .loginPanelBox .loginPanel_thirdLoginPop .renrenLoginBtn {
    margin-bottom: 10px;
}
</style>