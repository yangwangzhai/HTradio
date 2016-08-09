<?php $this->load->view('header');?>
<script type="text/javascript">
$(document).ready(function(){
  $(".details_list ul li").mouseover(function(){
    $(this).addClass("current");
  });
$(".details_list ul li").mouseout(function(){
    $(this).removeClass("current");
  });
});
</script>
<div class="app_banner">
  <div class="down1"><a href="./index.php?c=download&m=getApk"><img src="static/images/down1.png" /></a></div>
    <div class="down2"><a href="#"><img src="static/images/down2.png" /></a></div>
</div>
<div class="app_main">
	<h1><img src="static/images/Android.jpg" /></h1>
    <div class="left"><img src="static/images/Android1.jpg" /></div>
    <div class="right">
    <h2>扫描二维码下载</h2>
    <p>使用手机上的二维码扫描以下二维码即可立即下载</p>
    <p><img src="static/images/ewm.png" /></p>
    <p>或者</p>
    <p><a href="./index.php?c=download&m=getApk">点击下载到本地</a></p>
    </div>
    <h1><img src="static/images/apple.jpg" /></h1>
    <div class="left">
    <h2>扫描二维码下载</h2>
    <p>使用手机上的二维码扫描以下二维码即可立即下载</p>
    <p><img src="static/images/er.png" width="244" height="244"/></p>
    <p>或者</p>
    <p><a href="http://school.wojia99.com/public/app_download/haitun/">点击下载到本地</a></p>
    </div>
    <div class="right"><img src="static/images/apple1.jpg" /></div>
</div>

<?php $this->load->view('footer');?>