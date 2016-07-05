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
        @media only screen and (min-width:400px) {
            html {
                font-size:29.62px!important
            }
        }
        @media only screen and (min-width:414px) {
            html {
                font-size:34.72px!important
            }
        }
        @media only screen and (min-width:480px) {
            html {
                font-size:38.3333px!important
            }
        }
        body {
            background: url(static/webios/images/bg.jpg) no-repeat;
            background-size: 100% auto;
            font-family: "微软雅黑";
            margin: 0;
            padding: 0;
        }
        div.drum figure {
            text-align: center;
            color: #8892a1;
            background:url(static/webios/images/rule.png) no-repeat center 0rem;
            background-size: 96% auto;

        }
        div.drum-wrapper {
            height: 7.75rem;
            width: 100%;
            background: url(static/webios/images/srcoll_bg.png) no-repeat 0 .06rem;
            background-size: 100% 100%;
            overflow: hidden;
            padding: .2rem 0 0 0;
        }
        div.drum-wrapper .inner {
            height: 6.5rem;
            top: 1.1rem;

        }

        div.drum-wrapper div.container {
            height: 64px;
        }
        div.drum-wrapper figure {
            font-size: .44rem;
            height: 64px;
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
            -webkit-animation:on 0.3s .2s ease;
            -moz-animation:on 0.3s .2s ease;
            -o-animation:on 0.3s .2s ease;
            animation:on 0.3s .2s ease;
            background: url(static/webios/images/info_box.png) no-repeat;
            background-size: 100% 100%;
            z-index: 1000;
            width: 100%;
            height: 5.45rem;
            top: 0;
            left: 0;
            display: block;
            opacity: 1;


        }
        .info_box {
            position:absolute;
            color: #fff;
            height: 5.45rem;
            width: 10rem;
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
            height: 5.45rem;
            display:none;
            text-align: center;


        }
        .play{ -webkit-animation: Circle 10s linear infinite 0s forwards; animation: Circle 10s linear infinite 0s forwards; }
        @-webkit-keyframes Circle {  from {
            -webkit-transform: rotate(0deg);
        }
            to { -webkit-transform: rotate(360deg); }
        }
        @keyframes Circle {  from {
            transform: rotate(0deg);
        }
            to { transform: rotate(360deg); }
        }

        .info_body{position:relative;height: 5.45rem;}
        .info_l{float:left; margin:.6rem 0 0 .5rem;}
        .info_r{float:left;  margin:1.4rem 0 0 .5rem ; text-align:left;}
        .info_r h2{font-size:.6rem;line-height:.4rem; color:#333;  margin:0;}
        .info_r p{font-size:.48rem; color:#666; line-height:.2rem;}
        .music_img{max-width:100%; width:2.28rem; height:2.28rem; border:#fff 4px solid; border-radius:50%;}
        .zan{width:100%; height:1.46rem; position:absolute; bottom:0px; z-index:9999}
        .zan p{float:left; width:50%; margin:0; padding:0; font-size:.54rem; line-height:1.1rem ; color:#666;}
        .zan p img{ width:.82rem;}
        .zan p a{color:#666; text-decoration:none;}
        .info_btn{position:absolute; width:1.6rem; height:.6rem; background:#1a3d78; color:#fff; font-size:.40rem; right:.5rem; top:.5rem; line-height:.6rem; border-radius:.5rem;}

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
        }
        .zan p .active{color:#0a70fb;}
        .infox_main{ position:relative;width: 10rem;height:6.45rem; margin:1rem auto 0 auto;background: url(static/webios/images/info_box_bg.png) no-repeat;background-size: 100% auto;}
        .zan_num{display:inline-block;}

    </style>
</head>
<body>
<!-- page集合的容器，里面放多个平行的.page，其他.page作为内联页面由路由控制展示 -->
<div class="page-group indexbg">
    <!-- 单个page ,第一个.page默认被展示-->
    <div class="page">
        <!-- 标题栏 -->
        <header class="bar bar-nav"> <a class="icon pull-left open-panel pull-left-icon"></a>
            <h1 class="title">海豚FM</h1>
            <a class="icon pull-right pull-right-icon"></a> </header>

        <!-- 这里是页面内容区 -->
        <div class="content">
            <div class="infox_main">
                <div class="info_box">
                    <ul>
                        <li id="0" class="on">
                            <div class="info_body">
                                <div class="info_btn">直播</div>
                                <div class="info_l"><img src="static/webios/images/music_default.png"  class="music_img" alt="left"/></div><div class="info_r"><h2>私家车930</h2><p>我的汽车有话说</p></div>
                                <div class="zan">
                                    <p><a href="#" ><i class="fa fa-thumbs-up"></i><span class="zan_num">10</span></a></p>
                                    <p><a href="#" ><i class="fa fa-thumbs-down"></i><span class="zan_num">6</span></a></p>
                                </div>
                            </div>
                        </li>
                        <li id="r_0"><div class="info_body">
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
                    $("select.drum").drum({
                        onChange : function (e) {
                            $(".info_box").find("li").removeClass("on");
                            $("#"+"r_" +e.value).addClass("on");
                            $(".info_box").find(".info_l").removeClass("play");
                            $(".on").find(".info_l").addClass("play");
                        }
                    });

                    /*$("#gb").click(function(){ //alert('99');
                        $(".close-panel").trigger("click");alert('99');
                        //a(document).on("click",".close-panel, .panel-overlay",function(b){a.closePanel()})
                    })*/
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
            <!-- <div class="list-icon"><a href="#"><img src="img/playlist_icon.png"></a></div>-->
        </div>
    </div>

    <!-- 其他的单个page内联页（如果有） -->
    <div class="page">...</div>
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
            <li><img src="static/webios/img/menu_program.png" class="icon1"><a href="index.php?d=webios&c=webios&m=my_programme" class="external">我的节目单</a></li>
            <li><img src="static/webios/img/menu_favorite.png" class="icon2"><a href="#">我的收藏节目</a></li>
            <li><img src="static/webios/img/menu_message.png" class="icon3"><a href="#">意见反馈</a></li>
            <li id="gb"><img src="static/webios/img/menu_setting.png" class="icon4"><a href="index.php?d=webios&c=webios&m=setting_list" class="external">软件设置</a></li>
        </ul>
        <p><input name="" type="button" value="+创建我的节目" class="pbtn"></p>
        <!-- Click on link with "close-panel" class will close panel -->
        <p><a href="#" class="close-panel">关闭</a></p>
    </div>
</div>
<script type='text/javascript' src='http://g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='static/webios/js/jquery-1.8.1.min.js' charset='utf-8'></script>
<script type='text/javascript' src='static/webios/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='static/webios/js/sm-extend.min.js' charset='utf-8'></script>
</body>
</html>