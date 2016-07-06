<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>海豚电台</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="static/webios/css/sm.min.css">
    <link rel="stylesheet" href="static/webios/css/sm-extend.min.css">
    <link rel="stylesheet" href="static/webios/css/style.css">
    <script src="static/webios/js/jquery-1.9.1.js"></script>
    <script src="static/webios/js/hammer.min.js"></script>
    <script src="static/webios/js/hammer.fakemultitouch.js"></script>
    <script src="static/webios/js/drum.js"></script>
    <script src="static/webios/js/public.js"></script>
    <link rel="stylesheet" href="static/webios/css/drum.css" />
    <link rel="stylesheet" type="text/css"	href="static/webios/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css"	href="static/webios/css/font-awesome-ie7.min.css" />

    <style>

@media only screen and (min-width:320px) {
div.drum-wrapper .inner  {
top: 1.3rem !important;
}
}
@media only screen and (min-width:360px) {
div.drum-wrapper .inner  {
top: 2.3rem !important;
}
}
@media only screen and (min-width:375px) {
div.drum-wrapper .inner  {
top: 2.1rem !important;
}
}
@media only screen and (min-width:414px) {
div.drum-wrapper .inner  {
top: 2.7rem !important;
}
}
@media only screen and (min-width:480px) {
html {
font-size:21px!important
}
div.drum-wrapper{
max-width:20rem;	
}
}
.panel-left:after{  content: "";
  display: block;
  position: absolute;
  top: 0;
  bottom: 0;
  right: 0;
  width: 1px;
  background: #222;
  box-shadow: 0 0 5px 2px #222;}
.page{background: url(static/webios/images/bg.jpg) no-repeat;
	background-size: 100% auto;}
.bar:after{ background: #5647ab;}
.bar { background:none; border:none; height: 3rem;}
.title { color:#fff; font-size: 1.4rem; line-height: 3rem;}
.bar-nav~.content{ top: 3rem;}
body {
	background: url(static/webios/images/bg.jpg) no-repeat;
	background-size: 100% auto;
	font-family: "微软雅黑";
	margin: 0 auto;
	padding: 0;
}

div.drum figure {
	text-align: center;
	color: #8892a1;
	background:url(static/webios/images/rule.png) no-repeat center 0rem;
	background-size: 96% auto;
	
}
div.drum-wrapper {
	height: 15.5rem;
	width: 100%;
	margin:.5rem auto 0 auto;
	background: url(static/webios/images/srcoll_bg.png) no-repeat 0 0rem;
	background-size: 100% 100%;
	overflow: hidden;
	padding:0 0 0 0;
	position: relative;
	display: block;
}
div.drum-wrapper .innera{
margin:.9rem 0;
height: 13.6rem;
overflow: hidden;	
}
div.drum-wrapper .inner {
	height: 13rem;
	top: 3rem;
	display:block;
}

div.drum-wrapper div.container,div.drum-wrapper figure {
	
}
@-webkit-keyframes on {
	0% {
		opacity: .5;
		-webkit-transform: scale(.5);
		transform: scale(.5)
	}
	50% {
		opacity: .8;
		-webkit-transform: scale(.5);
		transform: scale(.8)
	}
	70% {
		opacity: .5;
		-webkit-transform: scale(.8);
		transform: scale(.8)
	}
	100% {
		opacity: 1;
		-webkit-transform: scale(1);
		transform: scale(1)
	}
}
@keyframes on {
	0% {
		opacity: .5;
		-webkit-transform: scale(.5);
		-ms-transform: scale(.5);
		transform: scale(.5)
	}
	50% {
		opacity: .8;
		-webkit-transform: scale(.5);
		-ms-transform: scale(.5);
		transform: scale(.5)
	}
	70% {
		opacity: 1;
		-webkit-transform: scale(.8);
		-ms-transform: scale(.8);
		transform: scale(.8)
	}
	100% {
		opacity: 1;
		-webkit-transform: scale(1);
		-ms-transform: scale(1);
		transform: scale(1)
	}
}

@-o-keyframes on{
	0% {
		opacity: .5;
		-o-transform: scale(.5);
		transform: scale(.5)
	}
	50% {
		opacity: .8;
		-o-transform: scale(.5);
		transform: scale(.5)
	}
	70% {
		opacity: 1;
		-o-transform: scale(.8);
		transform: scale(.8)
	}
	100% {
		opacity: 1;
		-o-transform: scale(1);
		transform: scale(1)
	}
} 

@-moz-keyframes on{
	0% {
		opacity: .5;
		-moz-transform: scale(.5);
		transform: scale(.5)
	}
	50% {
		opacity: .8;
		-moz-transform: scale(.5);
		transform:scale(.5)
	}
	70% {
		opacity: 1;
		-o-transform: scale(.8);
		transform: scale(.8)
	}
	100% {
		opacity: 1;
		-moz-transform: scale(1);
		transform: scale(1)
	}
}



.info_box ul li.on {

	background: url(static/webios/images/info_box.png) no-repeat;
	background-size: 100% 100%;
	z-index: 1000;
	width: 100%;
	height: 10.9rem;
	top: 0;
	left: 0;
	display: block;
	opacity: 1;
-webkit-animation:bounceIn 1s .2s ease both;
-moz-animation:bounceIn 1s .2s ease both;

	
}
.info_box {
	position:absolute;
	color: #fff;
	height: 10.9rem;
	width: 20rem;
	margin: 0 auto 0 auto;
	bottom:0px;
	
}
.info_box ul{margin:0; padding:0;}
.info_box ul li {
	margin: 0;
	padding: 0;
	list-style-type: none;
	position: absolute;
	background: url(static/webios/images/info_box.png) no-repeat;
	background-size: 100% 100%;
	z-index: 99;
	width: 100%;
	height: 10.9rem;
	display:none;
	text-align: center;


}
 .play{ -webkit-animation: Circles 10s linear infinite 0s forwards; animation: Circles 10s linear infinite 0s forwards; }
@-webkit-keyframes Circles {  from {
 -webkit-transform: rotate(0deg);
}
to { -webkit-transform: rotate(360deg); }
}
@keyframes Circles {  from {
 transform: rotate(0deg);
}
to { transform: rotate(360deg); }
}

.info_body{position:relative;height: 10.9rem;}
.info_l{float:left; margin:1.2rem 0 0 1rem;}
.info_r{float:left;  margin:2.8rem 0 0 1rem ; text-align:left;}
.info_r h2{font-size:1.2rem;line-height:.8rem; color:#333;  margin:0;}
.info_r p{font-size:.96rem; color:#666; line-height:.4rem;}
.music_img{max-width:100%; width:4.56rem; height:4.56rem; border:#fff 4px solid; border-radius:50%;}
.zan{width:100%; height:2.92rem; position:absolute; bottom:0px; z-index:9999}
.zan p{float:left; width:50%; margin:0; padding:0; font-size:1rem; line-height:2.2rem ; color:#666;}
.zan p img{ width:1.64rem;}
.zan p  i{font-size: 1.4rem;}
.zan p a{color:#666; text-decoration:none;}
.info_btn{position:absolute; width:3.2rem; height:1.2rem; background:#1a3d78; color:#fff; font-size:.80rem; right:1rem; top:1rem; line-height:1.2rem; border-radius:1rem;}

@-webkit-keyframes zanicon {
	0% {
		opacity: 1;
		-webkit-transform: scale(1);
		transform: scale(1)
	}
	50% {
		opacity: 1;
		-webkit-transform: scale(4);
		transform: scale(4)
	}
	70% {
		-webkit-transform: scale(.8);
		transform: scale(.8)
	}
	100% {
		opacity: 1;
		-webkit-transform: scale(1);
		transform: scale(1)
	}
}
@keyframes zanicon {
	0% {
		opacity: 1;
		-webkit-transform: scale(1);
		-ms-transform: scale(1);
		transform: scale(1)
	}
	50% {
		opacity: 1;
		-webkit-transform: scale(4);
		-ms-transform: scale(4);
		transform: scale(4)
	}
	70% {
		-webkit-transform: scale(.8);
		-ms-transform: scale(.8);
		transform: scale(.8)
	}
	100% {
		opacity: 1;
		-webkit-transform: scale(1);
		-ms-transform: scale(1);
		transform: scale(1)
	}
}

@-o-keyframes zanicon{
	0% {
		opacity: 1;
		-o-transform: scale(1);
		transform: scale(1)
	}
	50% {
		opacity: 1;
		-o-transform: scale(4);
		transform: scale(4)
	}
	70% {
		-o-transform: scale(.8);
		transform: scale(.8)
	}
	100% {
		opacity: 1;
		-o-transform: scale(1);
		transform: scale(1)
	}
} 

@-moz-keyframes zanicon{
	0% {
		opacity: 1;
		-moz-transform: scale(1);
		transform: scale(1)
	}
	50% {
		opacity: 1;
		-moz-transform: scale(4);
		transform:scale(4)
	}
	70% {
		-o-transform: scale(.8);
		transform: scale(.8)
	}
	100% {
		opacity: 1;
		-moz-transform: scale(1);
		transform: scale(1)
	}
}
i.zanicon {
	-webkit-animation:zanicon 0.8s .2s ease;
	-moz-animation:zanicon 0.8s .2s ease;
	-o-animation:zanicon 0.8s .2s ease;
	animation:zanicon 0.8s .2s ease;
	color:#0a70fb;
	text-decoration:none;
	font-size:1rem;
}
.zan p .active{color:#0a70fb;}
.infox_main{ position:relative;width: 20rem;height:12.08rem; margin:1rem auto 0 auto;background: url(static/webios/images/info_box_bg.png) no-repeat;background-size: 100% auto;}
.zan_num{display:inline-block;}



@-webkit-keyframes bounceIn{
0%{opacity:0;
-webkit-transform:scale(.3)}
50%{opacity:.5;
-webkit-transform:scale(1.05)}
70%{opacity:.8;-webkit-transform:scale(.9)}
100%{opacity:1;-webkit-transform:scale(1)}
}
@-moz-keyframes bounceIn{
0%{opacity:0;
-moz-transform:scale(.3)}
50%{opacity:1;
-moz-transform:scale(1.05)}
70%{-moz-transform:scale(.9)}
100%{-moz-transform:scale(1)}
}

.info_box ul li.old{
display:block;
-webkit-animation:fadeOutDown 1s .2s ease both;
-moz-animation:fadeOutDown 1s .2s ease both;}
@-webkit-keyframes fadeOutDown{
0%{opacity:1;
-webkit-transform:translateY(0) rotateX(0deg)}
100%{opacity:0;
-webkit-transform:translateY(200px) rotateX(-90deg)}
}
@-moz-keyframes fadeOutDown{
0%{opacity:1;
-moz-transform:translateY(0) rotateX(0deg)}
100%{opacity:0;
-moz-transform:translateY(200px) rotateX(-90deg)}
}
</style>
</head>
<body>
<!-- page集合的容器，里面放多个平行的.page，其他.page作为内联页面由路由控制展示  open-panel -->
<div class="page-group indexbg">
    <!-- 单个page ,第一个.page默认被展示-->
    <div class="page" id="page-action">
        <!-- 标题栏 -->
        <header class="bar bar-nav">
            <a class="icon pull-left open-panel pull-left-icon external" <?php if(empty($mid)){echo 'href="index.php?d=webios&c=webios&m=login_view"';}?>></a>
            <h1 class="title">海豚FM</h1>
            <a class="icon pull-right pull-right-icon"></a>
        </header>
        <!-- 这里是页面内容区 -->
        <div class="content">

            <!--<script type="text/javascript" src="static/webios/player/sewise.player.min.js"></script>
            <div id="player" style="width: 0px;height: 0px;">
                <script type="text/javascript">
                    SewisePlayer.setup({
                        server: "vod",
                        type: "m3u8",
                        autostart: "true",
                        poster: "http://jackzhang1204.github.io/materials/poster.png",
                        videourl: "http://media.bbrtv.com:1935/live/_definst_/950/playlist.m3u8",
                        skin: "vodWhite",
                        title: "M3U8 AES 128",
                        lang: "zh_CN",
                        claritybutton: 'disable'
                    }, "player");
                </script>
            </div>-->

            <div class="infox_main">
                <div class="info_box">
                    <ul>
                        <li id="r_0" class="on"><div class="info_body">
                                <div class="info_btn">直播</div>
                                <div class="info_l"><img src="static/webios/images/music_default.png"  class="music_img" alt="left"/></div><div class="info_r"><h2>私家车930</h2><p>我的汽车有话说</p></div>
                                <div class="zan">
                                    <p><a href="#" ><i class="fa fa-thumbs-up"></i><span class="zan_num">10</span></a></p>
                                    <p><a href="#" ><i class="fa fa-thumbs-down"></i><span class="zan_num">6</span></a></p>
                                </div>
                            </div></li>
                        <li id="r_1"><div class="info_body">
                                <div class="info_btn">直播</div>
                                <div class="info_l"><img src="static/webios/images/music_default.png"  class="music_img" alt="left"/></div><div class="info_r"><h2>新闻910</h2><p>我的汽车有话说</p></div>
                                <div class="zan">
                                    <p><a href="#" ><i class="fa fa-thumbs-up"></i><span class="zan_num">10</span></a></p>
                                    <p><a href="#" ><i class="fa fa-thumbs-down"></i><span class="zan_num">6</span></a></p>
                                </div>
                            </div></li>
                        <li id="r_2"><div class="info_body">
                                <div class="info_btn">直播</div>
                                <div class="info_l"><img src="static/webios/images/music_default.png"  class="music_img" alt="left"/></div><div class="info_r"><h2>我的频道</h2><p>我的汽车有话说</p></div>
                                <div class="zan">
                                    <p><a href="#" ><i class="fa fa-thumbs-up"></i><span class="zan_num">10</span></a></p>
                                    <p><a href="#" ><i class="fa fa-thumbs-down"></i><span class="zan_num">6</span></a></p>
                                </div>
                            </div></li>
                        <li id="r_3"><div class="info_body">
                                <div class="info_btn">直播</div>
                                <div class="info_l"><img src="static/webios/images/music_default.png"  class="music_img" alt="left"/></div><div class="info_r"><h2>交通1003</h2><p>我的汽车有话说</p></div>
                                <div class="zan">
                                    <p><a href="#" ><i class="fa fa-thumbs-up"></i><span class="zan_num">10</span></a></p>
                                    <p><a href="#" ><i class="fa fa-thumbs-down"></i><span class="zan_num">6</span></a></p>
                                </div>
                            </div></li>
                        <li id="r_4"><div class="info_body">
                                <div class="info_btn">直播</div>
                                <div class="info_l"><img src="static/webios/images/music_default.png"  class="music_img" alt="left"/></div><div class="info_r"><h2>95.0MusicRadio</h2><p>我的汽车有话说</p></div>
                                <div class="zan">
                                    <p><a href="#" ><i class="fa fa-thumbs-up"></i><span class="zan_num">10</span></a></p>
                                    <p><a href="#" ><i class="fa fa-thumbs-down"></i><span class="zan_num">6</span></a></p>
                                </div>
                            </div></li>
                        <li id="r_5"><div class="info_body">
                                <div class="info_btn">直播</div>
                                <div class="info_l"><img src="static/webios/images/music_default.png"  class="music_img" alt="left"/></div><div class="info_r"><h2>970女主播电台</h2><p>我的汽车有话说</p></div>
                                <div class="zan">
                                    <p><a href="#" ><i class="fa fa-thumbs-up"></i><span class="zan_num">10</span></a></p>
                                    <p><a href="#" ><i class="fa fa-thumbs-down"></i><span class="zan_num">6</span></a></p>
                                </div>
                            </div></li>
                        <li id="r_6"><div class="info_body">
                                <div class="info_btn">直播</div>
                                <div class="info_l"><img src="static/webios/images/music_default.png"  class="music_img" alt="left"/></div><div class="info_r"><h2>北部湾之声</h2><p>我的汽车有话说</p></div>
                                <div class="zan">
                                    <p><a href="#" ><i class="fa fa-thumbs-up"></i><span class="zan_num">10</span></a></p>
                                    <p><a href="#" ><i class="fa fa-thumbs-down"></i><span class="zan_num">6</span></a></p>
                                </div>
                            </div></li>
                        <li id="r_7"><div class="info_body">
                                <div class="info_btn">直播</div>
                                <div class="info_l"><img src="static/webios/images/music_default.png"  class="music_img" alt="left"/></div><div class="info_r"><h2>广西旅游广播</h2><p>我的汽车有话说</p></div>
                                <div class="zan">
                                    <p><a href="#" ><i class="fa fa-thumbs-up"></i><span class="zan_num">10</span></a></p>
                                    <p><a href="#" ><i class="fa fa-thumbs-down"></i><span class="zan_num">6</span></a></p>
                                </div>
                            </div></li>
                        <li id="r_8" ><div class="info_body">
                                <div class="info_btn">直播</div>
                                <div class="info_l"><img src="static/webios/images/music_default.png"  class="music_img" alt="left"/></div><div class="info_r"><h2>2016欧洲</h2><p>我的汽车有话说</p></div>
                                <div class="zan">
                                    <p><a href="#" ><i class="fa fa-thumbs-up"></i><span class="zan_num">10</span></a></p>
                                    <p><a href="#" ><i class="fa fa-thumbs-down"></i><span class="zan_num">6</span></a></p>
                                </div>
                            </div></li>
                    </ul>
                </div>
            </div>
            <select   id="numbers1" class="drum">
                <option value="0">私家车930</option>
                <option value="1">新闻910</option>
                <option value="3">交通1003</option>
                <option value="4">95.0MusicRadio</option>
                <option value="5">970女主播电台</option>
                <option value="6">北部湾之声</option>
                <option value="7">广西旅游广播</option>
                <option value="8">2016欧洲杯</option>
            </select>
            <script>
               Hammer.plugins.fakeMultitouch();
		$(document).ready(function () {
			$(".on").find(".info_l").addClass("play");  
			var rid=$("#numbers1_value").val();
			$("select.drum").drum({
				onChange : function (e) {
			    $(".info_box").find("li").removeClass("old");
			    $(".info_box").find(".on").addClass("old");  
				$(".info_box").find("li").removeClass("on");
				$("#"+"r_" +e.value).addClass("on");
				$(".info_box").find(".info_l").removeClass("play"); 
				$(".on").find(".info_l").addClass("play"); 
				$("#numbers1_value").val(e.value); 
                }	
			});
		
		});

                $(".zan").find("p a").click(function() {
                    $(".zan").find(".fa").removeClass("zanicon");
                    $(this).children(".fa").addClass("zanicon");
                    $(".zan").find("p a").removeClass("active");
                    $(this).addClass("active");
                    var j=$(this).children("span.zan_num").text();
                    var i= parseInt(j);
                    i=i+1;
                    $(this).children("span.zan_num").text(i);
                    niceIn($(this));
                });
                function niceIn(prop){
                    $('.active i').addClass('zanicon');
                    setTimeout(function(){
                        $('.active i').removeClass('zanicon');
                    },1000);
                }

            </script>

            <div class="group"> <a href="#" class="button1"></a><a href="#" class="button2"></a><a href="#" class="button3"></a> </div>
        </div>
    </div>
</div>

<!-- popup, panel 等放在这里 -->
<div class="panel-overlay"></div>
<!-- Left Panel with Reveal effect -->
<div class="panel panel-left panel-reveal">
  <div class="content-block">
    <dl>
      <dt><a href="#"><img src="static/webios/img/play_bg.jpg"></a></dt>
      <dd><a href="#">广播之旅</a></dd>
    </dl>
    <ul>
      <li><i class="fa fa-file-text-o"></i><a href="index.php?d=webios&c=webios&m=my_programme" class="external">我的节目单</a></li>
      <li><i class="fa fa-heart-o"></i><a href="index.php?d=webios&c=webios&m=collect_view" class="external">我的收藏节目</a></li>
      <li><i class="fa fa-pencil-square-o"></i><a href="index.php?d=webios&c=webios&m=feedback_view" class="external">意见反馈</a</li>
      <li><i class="fa fa-cog"></i><a href="index.php?d=webios&c=webios&m=setting_list" class="external">软件设置</a></li>
    </ul>
    <!--<p><input name="" type="button" value="+创建我的节目" class="pbtn"></p>-->
      <p><a href="index.php?d=webios&c=webios&m=creat_programme_view" class="pbtn external">+创建我的节目</a></p>
    <!-- Click on link with "close-panel" class will close panel -->
  </div>
</div>
<script type='text/javascript' src='http://g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<!--<script type='text/javascript' src='static/webios/js/jquery-1.9.1.min.js' charset='utf-8'></script>-->
<script type='text/javascript' src='static/webios/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='static/webios/js/sm-extend.min.js' charset='utf-8'></script>
<!--<script type='text/javascript' src='static/webios/js/demo.js' charset='utf-8'></script>-->


</body>
</html>