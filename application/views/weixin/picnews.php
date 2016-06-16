<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$value[title]?></title>
<style>
.slider{display:none}/*用于获取更加体验*/
.focus span{width:10px;height:10px;margin-right:10px;border-radius:50%;background:#666;font-size:0}
.focus span.current{background:#fff}
</style>
<link rel="stylesheet" type="text/css" href="static/weixin_css/style.css">

<script src="static/weixin_css/jq/jquery-1.6.4.min.js"></script>
<style type="text/css">
a {
	font-size: 18px;
}
</style>
</head>

<body>
<div class="slider">
	  <ul>
       <?php foreach($list as $key=>$r) {?>
	    <li><img src="<?=$r['pic_url']?>"></li>		
       <?php }?>
	  </ul>
</div>
<script type="text/javascript" src="static/weixin_css/yxMobileSlider.js"></script>
<script>
    $(".slider").yxMobileSlider({width:640,height:<?=$maxheight?>,during:3000})
  </script>

<div  style="width: 640px;margin: 10px auto;">
<span style="FONT-FAMILY:'宋体'; FONT-SIZE:16px;">
<?=$value['content']?>
</span>
</div>
<script>
var url = window.location.href;
//host = "http://" + window.location.host;
var host = '<?=$baseurl?>';
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {		
		window.shareData = {
				"imgUrl":host +"/<?php if(count($list)>0){echo $list[0]['pic_url'];}?>",
				"timeLineLink": url,
				"sendFriendLink": url,				
				"tTitle": "<?=$value['title']?>",
				"tContent": "<?=$value['content']?>",
				"fTitle": "<?=$value['title']?>",
				"fContent": "<?=$value['content']?>"
				//"wContent": "岁月经不起蹉跎，成功经不起等待"
			};
		
		// 发送给好友
			WeixinJSBridge.on('menu:share:appmessage', function (argv) {
				WeixinJSBridge.invoke('sendAppMessage', {
					"img_url": window.shareData.imgUrl,
					"img_width": "640",
					"img_height": "640",
					"link": window.shareData.sendFriendLink,
					"desc": window.shareData.fContent,
					"title": window.shareData.fTitle
				}, function (res) {
                    if('send_app_msg:cancel' != res.err_msg){
                        shareReport();
                    }
					_report('send_msg', res.err_msg);
				})
			});
		
		// 分享到朋友
        WeixinJSBridge.on('menu:share:timeline', function (argv) {
            WeixinJSBridge.invoke('shareTimeline', {
                "img_url": window.shareData.imgUrl,
				"img_width": "640",
				"img_height": "640",
				"link": window.shareData.timeLineLink,
				"desc": window.shareData.tContent,
				"title": window.shareData.tTitle
            }, function (res) {
                _report('timeline', res.err_msg);
            });
        });
    }, false) 
		
</script>
</body>
</html>

