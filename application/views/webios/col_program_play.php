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
    <!--    <link rel="stylesheet" href="static/webios/css/style.css">-->
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
            .page{  width: 95% }
            .bar-nav{top:.6rem;}
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
            .bar-nav{top:.8rem;}
            .page{  width: 100% }
        }
        @media only screen and (min-width:414px) {
            div.drum-wrapper .inner  {
                top: 2.7rem !important;
            }
            .bar-nav{top:1rem;}
            .page{  width: 100% }
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
            background-size: 100% 100%; margin: 0 auto;  }

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
        .info_l{float:left; margin:1.2rem 0 0 1rem;width:4.56rem; height:4.56rem;}
        .info_r{float:left;  margin:2.8rem 0 0 1rem ; text-align:left; width:13rem;}
        .info_r h2{font-size:1.2rem;line-height:.8rem; color:#333;  margin:0;}
        .info_r p{font-size:.96rem; color:#666;  height:1.4rem; overflow:hidden; margin:.3rem 0 0 0; padding:0;white-space: nowrap;
            text-overflow: ellipsis;}
        .music_img{max-width:100%; width:4.56rem; height:4.56rem; border:#fff 4px solid; border-radius:50%;}
        .zan{width:100%; height:2.92rem; position:absolute; bottom:0px; z-index:9999}
        .zan p{float:left; width:50%; margin:0; padding:0; font-size:1rem; line-height:2.2rem ; color:#666;}
        .zan p img{ width:1.64rem;}
        .zan p  i{font-size: 1.4rem;}
        .zan p a{color:#666; text-decoration:none;}
        .info_btn{position:absolute; width:2.4rem; padding:.1rem; background:#1a3d78; color:#fff; font-size:.80rem; right:1rem; top:1rem;  border-radius:.4rem;}

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
<!-- page集合的容器，里面放多个平行的.page，其他.page作为内联页面由路由控制展示 -->
<div class="page-group indexbg">
    <!-- 单个page ,第一个.page默认被展示-->
    <div class="page" style="margin-top: 0.5rem;">
        <!-- 标题栏 -->
        <header class="bar bar-nav">
            <a class="button button-link button-nav pull-left external" href="index.php?d=webios&c=webios&m=col_programme_detail&programme_id=<?=$programme_id?>&programme_title=<?=$programme_title;?>&col_num=<?=$col_num?>" style="color:#fff">
                <span class="icon icon-left"></span>
                返回
            </a>
            <h1 class="title">播放列表</h1>
        </header>
        <!-- 这里是页面内容区 -->
        <div class="content">
            <div class="infox_main">
                <div class="info_box">
                    <ul>
                        <li id="r_0" class="on">
                            <div class="info_body">
                                <div class="info_btn">直播</div>
                                <div class="info_l"><img src="uploads/file/20160506/910.png"  class="music_img" alt="left"/></div><div class="info_r" ><h3 style="color: #000000;"><?=$program_first['title']?></h3><p></p></div>
                                <div class="zan">
                                    <p><a href="#" ><i class="fa fa-thumbs-up"></i><span class="zan_num">10</span></a></p>
                                    <p><a href="#" ><i class="fa fa-thumbs-down"></i><span class="zan_num">6</span></a></p>
                                </div>
                            </div>
                        </li>

                        <?php foreach($program_arr as $key=>$value){ $k=$key+1;?>
                            <li id="r_<?=$k;?>">
                                <div class="info_body">
                                    <div class="info_btn">直播</div>
                                    <div class="info_l"><img src="uploads/file/20160506/930.png"  class="music_img" alt="left"/></div><div class="info_r"><h3 style="color: #000000;"><?=$value['title']?></h3><p></p></div>
                                    <div class="zan">
                                        <p><a href="#" ><i class="fa fa-thumbs-up"></i><span class="zan_num">10</span></a></p>
                                        <p><a href="#" ><i class="fa fa-thumbs-down"></i><span class="zan_num">6</span></a></p>
                                    </div>
                                </div>
                            </li>
                        <?php }?>
                    </ul>

                </div>
            </div>

            <select   id="numbers1" class="drum">
                <option value="0"><?=$program_first['title']?></option>
                <?php foreach($program_arr as $key=>$value){ $k=$key+1;?>
                    <option value="<?=$k;?>"><?=$value['title']?></option>
                <?php }?>
            </select>
            <audio id="audio" controls style="width:0; height:0; position:absolute; left:-9999px;" autoplay="autoplay" preload="preload"></audio>
            <script>
                $(function() {

                    // 播放器
                    var Player = {
                        // 歌曲路径
                        path : '',

                        // 歌曲数据
                        data : null,

                        // 当前播放歌曲的 索引
                        currentIndex : -1,

                        //  播放器元素jquery对象
                        $audio : $('audio'),

                        // 歌曲列表
                        $mList : $('#m-list'),

                        //正在播放的歌曲
                        $rmusic : $('#rmusic'),

                        // 初始化 数据
                        init : function() {

                            // 数据一般来自服务器端,通过ajax 加载数据,这里是模拟
                            Player.data = [
                                <?php echo "'".$program_first['path']."'"?>,
                                <?php foreach($program_arr as $key=>$value){ ?>
                                <?php echo "'".$value['path']."'"?>,
                                <?php }?>
                            ];

                            // 一般用模板引擎,把数据 与 模板 转换为 视图,来显示,这里是模拟
                            var mhtml = '';
                            var len = Player.data.length;
                            for (var i = 0; i < len; i++) {
                                mhtml += '<li><a index="' + i + '">' + Player.data[i] + '</a></li>';
                            }
                            Player.$mList.html(mhtml);
                        },

                        // 就绪
                        ready : function() {
                            // 控制

                            Player.audio = Player.$audio.get(0);
                            //Player.audio.src = Player.path + Player.data[0];
                            //Player.audio.play();
                            $('#ctrl-area').on('click', 'button', function() {
                                Player.$rmusic.html(Player.data[Player.currentIndex]);
                            });

                            // 播放
                            $('#btn-play').click(function() {
                                $(this).hide();
                                $("#btn-pause").show();
                                Player.audio.play();

                                $(".info_box").find(".info_l").removeClass("play");
                                $(".on").find(".info_l").addClass("play");




                                if (Player.currentIndex == -1) {
                                    if (Player.currentIndex == -1) {
                                        Player.currentIndex = 0;
                                    } else if (Player.currentIndex == 0) {
                                        Player.currentIndex = (Player.data.length - 1);
                                    } else {
                                        Player.currentIndex--;
                                    }
                                    Player.audio.src = Player.path + Player.data[Player.currentIndex];
                                    Player.audio.play();
                                }
                            });

                            // 暂停
                            $('#btn-pause').click(function() {
                                Player.audio.pause();
                                $(this).hide();
                                $("#btn-play").show();
                                $(".info_box").find(".info_l").removeClass("play");
                            });

                            // 下一曲
                            $('#btn-next').click(function() {
                                if (Player.currentIndex == -1) {
                                    Player.currentIndex = 0;
                                } else if (Player.currentIndex == (Player.data.length - 1)) {
                                    Player.currentIndex = 0;
                                } else {
                                    Player.currentIndex++;
                                }
                                console.log("Player.currentIndex : " + Player.currentIndex);
                                Player.audio.src = Player.path + Player.data[Player.currentIndex];
                                Player.audio.play();
                            });

                            // 上一曲
                            $('#btn-pre').click(function() {
                                if (Player.currentIndex == -1) {
                                    Player.currentIndex = 0;
                                } else if (Player.currentIndex == 0) {
                                    Player.currentIndex = (Player.data.length - 1);
                                } else {
                                    Player.currentIndex--;
                                }
                                Player.audio.src = Player.path + Player.data[Player.currentIndex];
                                Player.audio.play();
                            });

                            // 单曲循环
                            $('#btn-loop').click(function() {
                                console.log("Player.currentIndex :", Player.currentIndex);
                                Player.audio.onended = function() {
                                    Player.audio.load();
                                    Player.audio.play();
                                };
                            });

                            // 顺序播放
                            $('#btn-order').click(function() {
                                console.log("Player.currentIndex :", Player.currentIndex);
                                Player.audio.onended = function() {
                                    $('#btn-next').click();
                                };
                            });

                            // 随机播放
                            $('#btn-random').click(function() {
                                Player.audio.onended = function() {
                                    var i = parseInt((Player.data.length - 1) * Math.random());
                                    playByMe(i);
                                };
                            });

                            // 播放指定歌曲
                            function playByMe(i) {
                                console.log("index:", i);
                                Player.audio.src = Player.path + Player.data[i];
                                Player.audio.play();
                                Player.currentIndex = i;
                                Player.$rmusic.html(Player.data[Player.currentIndex]);
                            }

                            // 歌曲被点击
                            $('#m-list a').click(function() {
                                playByMe($(this).attr('index'));
                            });
                        }
                    };
                    document.addEventListener('dragend', function(){
                        $("#btn-pause").show();
                        $("#btn-play").hide();
                        var i=$("#numbers1_value").val();
                        Player.audio.src = Player.path + Player.data[i];
                        Player.audio.play();
                    } );



                    Player.init();
                    Player.ready();

                });


            </script>
            <script>

                Hammer.plugins.fakeMultitouch();
                $(document).ready(function () {

                    $("select.drum").drum({
                        onChange : function (e) {
                            $(".info_box").find("li").removeClass("old");
                            $(".info_box").find(".on").addClass("old");
                            $(".info_box").find("li").removeClass("on");
                            $("#"+"r_" +e.value).addClass("on");
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
                    //异步保存点赞或者差评数


                });
                function niceIn(prop){
                    $('.active i').addClass('zanicon');
                    setTimeout(function(){
                        $('.active i').removeClass('zanicon');
                    },1000);
                }

            </script>

            <input type="text" class="values" id="numbers1_value" style=" width:0; height:0; position:absolute; left:-9999px;" value="0">
            <div class="group"> <a  class="button1" id="btn-next"></a><a  class="button2" id="btn-play"></a><a  id="btn-pause"></a><a  class="button3" id="btn-pre"></a> </div>
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
            <dd><a href="#"><?=$username['username']?></a></dd>
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
<!--<script type='text/javascript' src='static/webios/js/jquery-1.8.1.min.js' charset='utf-8'></script>-->
<script type='text/javascript' src='static/webios/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='static/webios/js/sm-extend.min.js' charset='utf-8'></script>
</body>
</html>