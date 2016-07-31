<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="qc:admins" content="1442203424146222466375735214177" /><!--QQ互联验证-->
<title>海豚电台</title>
<link href="static/css/style.css" rel="stylesheet" type="text/css" />
<link href="static/css/baidu_player.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="static/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="static/js/koala.min.1.5.js"></script>
<script type="text/javascript" src="static/js/jquery.SuperSlide.2.1.1.js"></script>
<script type="text/javascript" src="static/flowplayer/flowplayer-3.2.12.min.js"></script>
<script type="text/javascript" src="static/flowplayer/flowplayer.ipad-3.2.12.min.js"></script>
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
  
        <div class="upload"><a href="./index.php?c=upload&m=index"><img src="static/images/btn_upload.png" /></a></div>
    </div>
</div>
<link href="static/css/index.css" rel="stylesheet" type="text/css" />
<div class="box">
	<div class="left_box">
    	<div class="text"><img src="static/images/text.png" /></div>
        <div class="play ">
        
        
<!--效果html开始-->
<div id="background"></div>
	<div id="player">
		<div class="cover"><img id="playthumb" src="<?php echo $list[0]['thumb'] ? $list[0]['thumb'] : 'uploads/default_images/default_jiemu.jpg'?>" width="130" height="130"></div>
		<div class="ctrl">
			<div class="tag">
				<strong id="playtitle">Title：<?=$list[0]['title']?></strong>
				<span class="artist">Artist</span>
				<span class="album">Album</span>
			</div>
			<div class="control">
				<a style="display: block; width: 345px; height: 25px;" id="flashls_vod"></a>
			</div>
			<div class="tag progress">

			</div>
		</div>
	</div>
	<ul id="playlist">
		<?php foreach($list as $list_key=>$list_value):?>
			<li <?php if($list_key==0){echo "style='color:#ffffff'";}?> class="playmenu"
				data-id="<?=$list_value['id']?>" data-title="<?=$list_value['title']?>" data-thumb="<?=$list_value['thumb']?>" data-url="<?=$list_value['path']?>">
				<?=$list_value['title']?>
			</li>
		<?php endforeach?>
	</ul>
	<script src="static/js/jquery-ui-1.8.17.custom.min.js"></script>
	<script src="static/js/script.js"></script>
<!--效果html结束-->

</div>
	<div class="find"><a href="./index.php?c=index&m=find"><img src="static/images/btn_find.png" /></a></div>
    </div>
    <div class="right_box">
    	<div class="phone"><img src="static/images/web.png" /></div>
        <div class="down"><a href="index.php?c=download&m=getApk"><img src="static/images/btn_android.png" /></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><img src="static/images/btn_iphone.png" /></a></div>
    </div>
</div>
<div class="foot">©2011-2015  caomei.fm All Rights Reserved.沪ICP备06026464号-4网络文化经营许可证 沪网文[2014]0587-137号</div>
<div id="cmplayer"></div><!--播放音频的flash隐藏窗口-->
</body>
<script type="text/javascript">
	flowplayer("flashls_vod", "static/flowplayer/flowplayer.swf", {
		plugins: {
			flashls: {
				url: 'static/flowplayer/flashlsFlowPlayer.swf'
			},
            controls:{
                autoHide: false//功能条是否自动隐藏
            }
		},
		clip: {
			url: "<?=$list[0]['path']?>",
			live: true,
			urlResolvers: "flashls",
			provider: "flashls"
		},
        onFinish: function() {
            //统计播完率
            var id = <?=$list[0]['id']?>;
            $.ajax({
                url: 'index.php?c=player&m=play_over',
                type: 'post',
                dataType:'json',
                data: {id:id},
                success:function(data) {
                    //alert(data);
                }
            });
        }

	}).ipad();

	$(".playmenu").click(function(){
		var id="flashls_vod";
		var url=$(this).attr("data-url");
		var pid=$(this).attr("data-id");
        //当前播放的节目数量+1

		fplayer(id,url,pid)
		//当前播放的节目，高亮
		$(".playmenu").css("color","#aaa");
		$(this).css("color","#ffffff");
		//播放器标题
		var title=$(this).attr("data-title");
		$("#playtitle").text(title);
		//节目缩略图
		var thumb=$(this).attr("data-thumb");
        if(thumb!=''){
            $("#playthumb").attr("src",thumb);
        };
        $.ajax({
            url: 'index.php?c=index&m=playtimes',
            type: 'post',
            dataType:'json',
            data: {pid:pid},
            success:function(data) {
                //alert(data);
            }
        });

	});

	function fplayer(id,url,pid){
		flowplayer(id, "static/flowplayer/flowplayer.swf", {
			// configure the required plugins
			plugins: {
				flashls: {
					url: 'static/flowplayer/flashlsFlowPlayer.swf'
				},
                controls:{
                    autoHide: false //功能条是否自动隐藏
                }
			},
			clip: {
				url: url,
				live: true,
				urlResolvers: "flashls",
				provider: "flashls"
			},
            onFinish: function() {
                //统计播完率
                $.ajax({
                    url: 'index.php?c=player&m=play_over',
                    type: 'post',
                    dataType:'json',
                    data: {id:pid},
                    success:function(data) {
                        //alert(data);
                    }
                });
            }
		}).ipad();
	}
</script>
</html>
