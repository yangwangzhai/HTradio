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
    <link rel="stylesheet" href="static/webios/css/style.css?12">
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
		
		
.voice-masker { position: fixed; top: 0; right: 0; bottom: 0; left: 0; display: none; overflow: hidden; -webkit-user-select: none; -ms-user-select: none; user-select: none; z-index: 1024; font-family: sans-serif; }
.voice-masker > .wrapper { background: rgba(0, 0, 0, 0.9) ;position: absolute; top: 0; right: 0; bottom: 0; left: 0; opacity: 1 }
.voice-masker .voice-speak-btn { background-color: #306eff; border-radius: 50%; bottom: 10px; color: #fff; display: block; width: 90px; height: 90px; line-height: 90px; margin-left: -40px; position: absolute; left: 50%; text-align: center; text-decoration: none; -webkit-user-select: none; -ms-user-select: none; user-select: none; cursor: pointer; font-size: 16px; -webkit-touch-callout: none; -webkit-tap-highlight-color: transparent; }
.voice-masker .voice-speak-btn .voice-speak-wave { position: absolute; top: -1px; left: -1px; border: solid #0ce2fb 1px; width: 88px; height: 88px; border-radius: 50%; opacity: .85; display: none; }
.voice-masker .voice-speak-btn .voice-speak-wave.level0 { -webkit-animation: spread0 3s linear 0s infinite; animation: spread0 3s linear 0s infinite }
.voice-masker .voice-speak-btn .voice-speak-wave.level1 { -webkit-animation: spread1 3s linear 0s infinite; animation: spread1 3s linear 0s infinite }
.voice-masker .voice-speak-btn .voice-speak-wave.level2 { -webkit-animation: spread2 3s linear 0s infinite; animation: spread2 3s linear 0s infinite }
.voice-masker .voice-speak-btn .voice-speak-wave.level3 { -webkit-animation: spread3 3s linear 0s infinite; animation: spread3 3s linear 0s infinite }
.voice-masker .voice-speak-btn .voice-speak-circle { position: absolute; top: -1px; left: -1px; width: 88px; height: 88px; border-radius: 50%; opacity: .3; display: none; background-color: #60aff9; border: solid #60aff9 1px; -webkit-animation: stretch 1s linear 0s alternate infinite; animation: stretch 1s linear 0s alternate infinite }
.voice-masker .voice-speak-btn.press .voice-speak-wave, .voice-masker .voice-speak-btn.press .voice-speak-circle { display: block }
.voice-masker .voice-text { color: 111; font-size: 20px; margin-top: 60%; padding: 0 10%; text-align: center; -webkit-user-select: none; -ms-user-select: none; user-select: none }
.voice-masker .voice-close-btn { position: absolute; top: 0; right: 0; width: 40px; height: 40px; font-size: 24px; line-height: 40px; text-align: center; color: #ddd; -webkit-tap-highlight-color: transparent; text-decoration: none }
@-webkit-keyframes stretch {
0%, 100% {
-webkit-transform:scale(1);
transform:scale(1)
}
25%, 60% {
-webkit-transform:scale(1.5);
transform:scale(1.5)
}
50%, 80% {
-webkit-transform:scale(1.3);
transform:scale(1.3)
}
10%, 75% {
-webkit-transform:scale(1.1);
transform:scale(1.1)
}
}
@keyframes stretch {
0%, 100% {
-webkit-transform:scale(1);
transform:scale(1)
}
25%, 60% {
-webkit-transform:scale(1.5);
transform:scale(1.5)
}
50%, 80% {
-webkit-transform:scale(1.3);
transform:scale(1.3)
}
10%, 75% {
-webkit-transform:scale(1.1);
transform:scale(1.1)
}
}
@-webkit-keyframes spread0 {
0% {
opacity:.3
}
100% {
opacity:0;
-webkit-transform:scale(2);
transform:scale(2)
}
}
@keyframes spread0 {
0% {
opacity:.3
}
100% {
opacity:0;
-webkit-transform:scale(2);
transform:scale(2)
}
}
@-webkit-keyframes spread1 {
0% {
opacity:.3
}
100% {
opacity:0;
-webkit-transform:scale(4);
transform:scale(4)
}
}
@keyframes spread1 {
0% {
opacity:.3
}
100% {
opacity:0;
-webkit-transform:scale(4);
transform:scale(4)
}
}
@-webkit-keyframes spread2 {
0% {
opacity:.3
}
100% {
opacity:0;
-webkit-transform:scale(8);
transform:scale(8)
}
}
@keyframes spread2 {
0% {
opacity:.3
}
100% {
opacity:0;
-webkit-transform:scale(8);
transform:scale(8)
}
}
@-webkit-keyframes spread3 {
0% {
opacity:.3
}
100% {
opacity:0;
-webkit-transform:scale(14);
transform:scale(14)
}
}
@keyframes spread3 {
0% {
opacity:.3
}
100% {
opacity:0;
-webkit-transform:scale(14);
transform:scale(14)
}
}

.voice-masker .voice-close-btn { text-indent: -9999em; background-image: url(static/webios/img/close.svg); background-size:100% 100%; width:2rem; height:2rem; display:block; top:1rem; right:1rem; }

    </style>
</head>
<body>
<!-- page集合的容器，里面放多个平行的.page，其他.page作为内联页面由路由控制展示 -->
<div class="page-group indexbg">
    <!-- 单个page ,第一个.page默认被展示-->
    <div class="page">
        <!-- 标题栏 -->
        <header class="bar bar-nav">
            <a class="icon pull-left <?php if(!empty($mid)){echo 'open-panel';}?>  pull-left-icon
 external" <?php if(empty($mid)){echo 'href="index.php?d=webios&c=webios&m=login_view"';}?>>
            </a>
            <a href="index.php?d=webios&c=webios&m=upload_audio_view&mid=<?=$mid?>" class="external icon pull-right pull-right-icon"></a>
        </header>
        <!-- 这里是页面内容区 -->
        <div class="content">
            <div class="infox_main">
                <div class="info_box">
                    <ul>
                        <?php foreach($channel_list as $key=>$value) :?>

                            <li id="r_<?=$key?>" class="<?php if($key==4){echo "on";}else{ echo "info_body";} ?>">
                                <div class="info_body">
                                    <div class="info_btn">直播</div>
                                    <div class="info_l" data-id="<?=$key;?>" channel-type="1" mid="<?=$mid?>" ><img src="<?=$value['logo'];?>"  class="music_img" alt="left"/></div><div class="info_r"><h2><?=$value['title'];?></h2><p><?=$value['description'];?></p></div>
                                    <div class="zan">
                                        <p>
                                            <a data-id="<?=$value['id'];?>" data-type="support" channel-type="1" href="<?php if(empty($mid)){echo 'index.php?d=webios&c=webios&m=login_view';}else{echo '#';}?>" <?php if(empty($mid)){echo 'class="external"';}?>>                                        <i class="fa fa-thumbs-up"></i>
                                                <span class="zan_num"><?=$value['support_num'];?></span>
                                            </a>
                                        </p>
                                        <p><a data-id="<?=$value['id'];?>" data-type="negative" channel-type="1" href="<?php if(empty($mid)){echo 'index.php?d=webios&c=webios&m=login_view';}else{echo '#';}?>" <?php if(empty($mid)){echo 'class="external"';}?>>   <i class="fa fa-thumbs-down"></i><span class="zan_num"><?=$value['negative_num'];?></span></a></p>
                                    </div>
                                </div>
                            </li>

                        <?php endforeach?>
                        <li id="r_8"><div class="info_body">
                                <div class="info_btn">录播</div>
                                <div class="info_l" data-id="<?=count($channel_list);?>" channel-type="2" mid="<?=$mid?>"><img src="static/webios/images/music_default.png"  class="music_img" alt="left"/></div><div class="info_r"><h2><?=$programme['title']?></h2><p><?=$programme['intro']?></p></div>
                                <div class="zan">
                                    <p>
                                        <a data-id="<?=$programme['id'];?>" data-type="support" channel-type="2" href="<?php if(empty($mid)){echo 'index.php?d=webios&c=webios&m=login_view';}else{echo '#';}?>" <?php if(empty($mid)){echo 'class="external"';}?>>
                                            <i class="fa fa-thumbs-up"></i>
                                            <span class="zan_num"><?=$programme['support_num']?></span>
                                        </a>
                                    </p>
                                    <p><a data-id="<?=$programme['id'];?>" data-type="negative" channel-type="2" href="<?php if(empty($mid)){echo 'index.php?d=webios&c=webios&m=login_view';}else{echo '#';}?>" <?php if(empty($mid)){echo 'class="external"';}?>>
                                            <i class="fa fa-thumbs-down"></i>
                                            <span class="zan_num"><?=$programme['negative_num']?></span>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </li>

                    </ul>

                </div>
            </div>

            <select   id="numbers1" class="drum">
                <?php foreach($channel_list as $key=>$value) :?>
                    <option value="<?=$key?>" <?php echo $key==4?"selected='selected'":''?>><?=$value['title'];?></option>
                <?php endforeach?>
                <option value="8"><?=$programme['title']?></option>
            </select>
            <audio id="audio" controls style="width:0; height:0; position:absolute; left:-9999px;" preload="preload"></audio>
            <!--<input type="text" value="4" class="values" id="numbers1_value" style=" width:0; height:0; position:absolute; left:-9999px;">-->
            <input type="hidden" value="4" class="values" id="numbers1_value">
            <input type="hidden" value="<?=$time?>" class="values" id="time" >
            <script>
                var Player ;
                $(function() {

                    // 播放器
                     Player = {
                        // 歌曲路径
                        path : '',

                        // 歌曲数据
                        data : null,

                        // 当前播放歌曲的 索引
                        currentIndex : 4,

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
                                <?php foreach($channel_list as $key=>$value) :?>
                                    <?php if($key==count($channel_list)-1){?>
                                        '<?=$value['add_channel'];?>',
                                    <?php }else{?>
                                        '<?=$value['add_channel'];?>',
                                    <?php }?>
                                <?php endforeach?>
                                "<?=$program[0]['path']?>"
                                /*'http://media.bbrtv.com:1935/live/_definst_/910/playlist.m3u8',
                                'http://media.bbrtv.com:1935/live/_definst_/930/playlist.m3u8',
                                'http://media.bbrtv.com:1935/live/_definst_/950/playlist.m3u8',
                                'http://media.bbrtv.com:1935/live/_definst_/970/playlist.m3u8',
                                'http://media.bbrtv.com:1935/live/_definst_/1003/playlist.m3u8',
                                'http://media.bbrtv.com:1935/live/_definst_/bbr/playlist.m3u8',
                                'http://media.bbrtv.com:1935/live/_definst_/fashion/playlist.m3u8',
                                'http://media.bbrtv.com:1935/live/_definst_/lypl/playlist.m3u8'*/
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
                            //Player.currentIndex=4;
                            Player.audio = Player.$audio.get(0);

                            $("#btn-pause").show();
                            $("#btn-play").hide();
                            $(".on").find(".info_l").addClass("play");
                            //Player.audio.src = Player.path + Player.data[4];
                            //Player.audio.play();

                            $('#ctrl-area').on('click', 'button', function() {
                                Player.$rmusic.html(Player.data[Player.currentIndex]);
                            });

                            // 播放
                            $('#btn-play').click(function(e,num) {
                                $(this).hide();
                                $("#btn-pause").show();
                                Player.audio.play();
                                $(".info_box").find(".info_l").removeClass("play");
                                $(".on").find(".info_l").addClass("play");
                                if (Player.currentIndex == 4) {
                                    if (Player.currentIndex == -1) {
                                        Player.currentIndex = 0;
                                    } else if (Player.currentIndex == 0) {
                                        Player.currentIndex = (Player.data.length - 1);
                                    } else {
                                        //Player.currentIndex--;
                                    }
                                    Player.audio.src = Player.path + Player.data[Player.currentIndex];
                                    Player.audio.play();
                                }
                                //异步存储当前播放状态
                                if (num==undefined) {   //num==undefined时，主动调整状态，不等于undefined时，被动调整
                                    var mid = <?php if(!empty($mid)){echo $mid;}else{echo 0;}?>;
                                    if (mid) {
                                        $.ajax({
                                            url: "index.php?d=webios&c=webios&m=save_play_status",   //后台处理程序
                                            type: "post",         //数据发送方式
                                            dataType: "json",    //接受数据格式
                                            data: {mid: mid, play_status: 1, pos: 1},  //要传递的数据
                                            success: function (data) {
                                                if(data==1){
                                                    if($('#btn-play').css("display")!='none'){
                                                        //alert("播放");
                                                        $('#btn-play').trigger('click',[1]);
                                                    }
                                                }
                                            },
                                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                                //alert(errorThrown);
                                            }
                                        });
                                    }
                                }
                            });

                            // 暂停
                            $('#btn-pause').click(function(e,num) {
                                Player.audio.pause();
                                $(this).hide();
                                $("#btn-play").show();
                                $(".info_box").find(".info_l").removeClass("play");
                                //异步存储当前播放状态
                                if (num==undefined) {   //num==undefined时，主动调整状态，不等于undefined时，被动调整
                                    var mid = <?php if(!empty($mid)){echo $mid;}else{echo 0;}?>;
                                    if (mid) {
                                        $.ajax({
                                            url: "index.php?d=webios&c=webios&m=save_play_status",   //后台处理程序
                                            type: "post",         //数据发送方式
                                            dataType: "json",    //接受数据格式
                                            data: {mid: mid, play_status: 0, pos: 2},  //要传递的数据
                                            success: function (data) {
                                                if(data==0){
                                                    if($('#btn-pause').css("display")!='none'){
                                                        //alert("暂停");
                                                        $('#btn-pause').trigger('click',[1]);
                                                    }
                                                }
                                            },
                                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                                //alert(errorThrown);
                                            }
                                        });
                                    }
                                }
                            });

                            // 上一曲
                            $('#btn-next').click(function(e,num) {
                                $("#btn-pause").show();
                                $("#btn-play").hide();
                                if (Player.currentIndex == -1) {
                                    Player.currentIndex = Player.data.length-1;
                                } else if (Player.currentIndex == 0) {
                                    Player.currentIndex = Player.data.length-1;
                                } else {
                                    Player.currentIndex--;
                                }
                                $("#numbers1_value").val(Player.currentIndex);
                                console.log("Player.currentIndex : " + Player.currentIndex);
                                Player.audio.src = Player.path + Player.data[Player.currentIndex];
                                Player.audio.play();
                                //异步存储当前播放状态
                                if (num==undefined) {   //num==undefined时，主动切换频道，不等于undefined时，被动切换
                                    //异步存储当前播放状态
                                    var mid = <?php if(!empty($mid)){echo $mid;}else{echo 0;}?>;
                                    if(mid){
                                        $.ajax({
                                            url: "index.php?d=webios&c=webios&m=save_play_status",   //后台处理程序
                                            type: "post",         //数据发送方式
                                            dataType:"json",    //接受数据格式
                                            data:{channel_id:Player.currentIndex,mid:mid,play_status:1},  //要传递的数据
                                            success:function(data){
                                                //alert("当期时间："+data) ;

                                                $("#time").val(data);
                                            },
                                            error:function(XMLHttpRequest, textStatus, errorThrown)
                                            {
                                                //alert(errorThrown);
                                            }
                                        });
                                    }
                                }else{
                                    //alert("上一曲") ;
                                }
                            });

                            // 下一曲
                            $('#btn-pre').click(function(e,num) {
                                $("#btn-pause").show();
                                $("#btn-play").hide();
                                if (Player.currentIndex == -1) {
                                    Player.currentIndex = 1;
                                } else if (Player.currentIndex == (Player.data.length - 1)) {
                                    Player.currentIndex = 0;
                                } else {
                                    Player.currentIndex++;
                                }
                                $("#numbers1_value").val(Player.currentIndex);
                                Player.audio.src = Player.path + Player.data[Player.currentIndex];
                                Player.audio.play();
                                if (num==undefined) {   //num==undefined时，主动切换频道，不等于undefined时，被动切换
                                    //异步存储当前播放状态
                                    var mid = <?php if(!empty($mid)){echo $mid;}else{echo 0;}?>;
                                    if(mid){
                                        $.ajax({
                                            url: "index.php?d=webios&c=webios&m=save_play_status",   //后台处理程序
                                            type: "post",         //数据发送方式
                                            dataType:"json",    //接受数据格式
                                            data:{channel_id:Player.currentIndex,mid:mid,play_status:1},  //要传递的数据
                                            success:function(data){
                                                //alert("当期时间："+data) ;

                                                $("#time").val(data);
                                            },
                                            error:function(XMLHttpRequest, textStatus, errorThrown)
                                            {
                                                //alert(errorThrown);
                                            }
                                        });
                                    }
                                }else{
                                    //alert("下一曲") ;
                                }
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
                        //alert("当前id："+i);
                        Player.currentIndex = i;
                        Player.audio.src = Player.path + Player.data[i];
                        Player.audio.play();
                        //异步存储当前播放状态
                        var mid = <?php if(!empty($mid)){echo $mid;}else{echo 0;}?>;
                        if(mid){
                            $.ajax({
                                url: "index.php?d=webios&c=webios&m=save_play_status",   //后台处理程序
                                type: "post",         //数据发送方式
                                dataType:"json",    //接受数据格式
                                data:{channel_id:i,mid:mid,play_status:1},  //要传递的数据
                                success:function(data){
                                    //alert("当期时间："+data) ;
                                    $("#time").val(data);
                                },
                                error:function(XMLHttpRequest, textStatus, errorThrown)
                                {
                                    //alert(errorThrown);
                                }
                            });
                        }

                    } );

                    Player.init();
                    Player.ready();


                });

                function android_play(){
                    $("#btn-pause").show();
                    $("#btn-play").hide();
                    var i=$("#numbers1_value").val();
                    Player.currentIndex = i;
                    Player.audio.src = Player.path + Player.data[i];
                    //alert(i);
                    //alert(Player.audio.src);
                    Player.audio.play();
                }

            </script>

            <script>

                Hammer.plugins.fakeMultitouch();
                $(document).ready(function () {

                    $("select.drum").drum({
                        onChange : function (e) {
                            $(".info_box").find(".info_l").removeClass("play");
                            $(".info_box").find("li").removeClass("old");
                            $(".info_box").find(".on").addClass("old");
                            $(".info_box").find("li").removeClass("on");
                            $("#"+"r_" +e.value).addClass("on");
                            $(".on").find(".info_l").addClass("play");
                            $("#numbers1_value").val(e.value);
                            //alert(e.value);
                            //alert($("#numbers1_value").val());
                            if(e.value==8){
                                $('.list-icons').show();
                            }
                            else{
                                $('.list-icons').hide();
                            }

                        }
                    });

                    $(".list-icons").click(function(){
                        $(".list-popup").animate({
                            height:'toggle',
                            bottom:'0'
                        });
                    });

                    $(".list-popup").click(function(){
                        $(".list-popup").animate({
                            height:'toggle',
                            bottom:'0'
                        });
                    });

                    //点击语音按钮，开始录音
                    $(".sound-icon").click(function(){
                        //先暂停播放
                        if($('#btn-pause').css("display")!='none'){
                            $('#btn-pause').trigger('click',[1]);
                            var mid = <?php if(!empty($mid)){echo $mid;}else{echo 0;}?>;
                            //异步存储当前播放状态
                            if(mid){
                                $.ajax({
                                    url: "index.php?d=webios&c=webios&m=save_play_status",   //后台处理程序
                                    type: "post",         //数据发送方式
                                    dataType:"json",    //接受数据格式
                                    data:{mid:mid,play_status:0,pos:2},  //要传递的数据
                                    success:function(data){
                                        //alert(data);
                                        if(data==0){
                                            if($('#btn-pause').css("display")!='none'){
                                                //alert("暂停");
                                                $('#btn-pause').trigger('click',[1]);
                                            }
                                        }
                                    },
                                    error:function(XMLHttpRequest, textStatus, errorThrown)
                                    {
                                        //alert(errorThrown);
                                    }
                                });
                            }
                        }
                        //确认已经暂停播放
                        if($('#btn-play').css("display")!='none'){
                            //$(".voice-masker").show();
                            window.AndroidJS.startSpeak();
                        }

                    });
					
					 $(".voice-close-btn").click(function(){
                       $(".voice-masker").hide();
                    });


                   
                });



                //接收识别的文字
               function receiveSpeak(str){
                    //alert(str);
                    var playing_id = $("#numbers1_value").val();
                    var mid = <?php if(!empty($mid)){echo $mid;}else{echo 0;}?>;

                    $.ajax({
                        url: "index.php?d=webios&c=webios&m=voice_distinguish",   //后台处理程序
                        type: "post",         //数据发送方式
                        dataType:"json",    //接受数据格式
                        data:{mid:mid,str:str,playing_id:playing_id},  //要传递的数据
                        success:function(data){
                            //alert("语音识别："+data) ;
                            //alert(data['str']) ;
                            if(data['code']==1){
                                var i=0;
                                for(i;i<data['step'];i++){
                                    $(".button3").trigger('click',[1]);
                                }

                            }else if(data['code']==2){
                                var i=0;
                                for(i;i<data['step'];i++){
                                    $(".button1").trigger('click',[2]);
                                }
                            }
                            //控制播放状态
                            //$('#btn-play').trigger('click');
                            if(data['play_status']==1){
                                if($('#btn-play').css("display")!='none'){
                                    //alert("播放");
                                    $('#btn-play').trigger('click');
                                }
                            }
                        },
                        error:function(XMLHttpRequest, textStatus, errorThrown)
                        {
                            //alert(errorThrown);
                        }
                    });
                }



                $(".zan").find("p a").click(function() {
                        var mid = <?php if(!empty($mid)){echo $mid;}else{echo 0;}?>;
                        if( mid > 0 || mid != undefined){
                            var id = $(this).attr("data-id");
                            var type = $(this).attr("data-type");
                            var channel_type = $(this).attr("channel-type");
                            $(".zan").find(".fa").removeClass("zanicon");
                            $(this).children(".fa").addClass("zanicon");
                            $(".zan").find("p a").removeClass("active");
                            $(this).addClass("active");
                            var j=$(this).children("span.zan_num").text();
                            var i= parseInt(j);
                            i=i+1;
                            $.ajax({
                                url: "index.php?d=webios&c=webios&m=support_negative",   //后台处理程序
                                type: "post",         //数据发送方式
                                dataType:"json",    //接受数据格式
                                data:{id:id,type:type,channel_type:channel_type,mid:mid},  //要传递的数据
                                success:function(data){
                                    if(parseInt(data)==1){
                                        //加 1
                                        $(".active").children("span.zan_num").text(i);
                                        niceIn($(this));
                                    }else{
                                        //已经点过赞或者差评过
                                        niceIn($(this));
                                    }
                                },
                                error:function(XMLHttpRequest, textStatus, errorThrown)
                                {
                                    //alert(errorThrown);
                                }
                            });
                        }
                });

                function niceIn(prop){
                    $('.active i').addClass('zanicon');
                    setTimeout(function(){
                        $('.active i').removeClass('zanicon');
                    },1000);
                }

                function sync_play(flag){
                    var playing_id = $("#numbers1_value").val();
                    var time = $("#time").val();
                    var mid = <?php if(!empty($mid)){echo $mid;}else{echo 0;}?>;
                    //alert(mid);
                    if(mid){
                        //alert("id为："+playing_id);
                        $.ajax({
                            url: "index.php?d=webios&c=webios&m=tong_bu",   //后台处理程序
                            type: "post",         //数据发送方式
                            dataType:"json",    //接受数据格式
                            data:{playing_id:playing_id,time:time,mid:mid,flag:flag},  //要传递的数据
                            success:function(data){
                                if(data['code']==1){
                                    var i=0;
                                    for(i;i<data['step'];i++){
                                        $(".button3").trigger('click',[1]);
                                    }

                                }else if(data['code']==2){
                                    var i=0;
                                    for(i;i<data['step'];i++){
                                        $(".button1").trigger('click',[2]);
                                    }
                                }
                                //控制播放状态
                                if(data['play_status']==1){
                                    if($('#btn-play').css("display")!='none'){
                                        //alert("播放");
                                        $('#btn-play').trigger('click',[1]);
                                    }
                                }else{
                                    if($('#btn-pause').css("display")!='none'){
                                        //alert("暂停");
                                        $('#btn-pause').trigger('click',[1]);
                                    }
                                }

                                setTimeout("sync_play(1)",700);

                            },
                            error:function(XMLHttpRequest, textStatus, errorThrown)
                            {
                                setTimeout("sync_play(1)",700);
                            }
                        });
                    }
                }
                sync_play(0);   //没登陆前，刚进来执行一次，但是因为mid为空，所以往后没有0.7秒执行一次 sync_play(1)；登陆之后，因为登陆成功重新刷新了界面，所以再次执行 sync_play(0)，此时mid不为空，所以往后每0.7秒执行一次 sync_play(1)。
                //setInterval(sync_play,700);

            </script>

            <div class="group">
                <a  class="button1" id="btn-next"></a>
                <a  class="button2" id="btn-play"></a>
                <a  id="btn-pause"></a>
                <a  class="button3" id="btn-pre"></a>
                <div class="list-icons">
                    <img src="static/webios/images/playlist_icon.png"/>
                </div>
                <div class="sound-icon"></div>
            </div>
           <!--语音识别界面开始-->
            <div class="voice-masker">
                <div class="wrapper">
                    <a href="#" onclick="return false" class="voice-close-btn">×</a>
                    <div class="voice-speak-btn press">
                        <div class="voice-speak-circle"></div>
                        <div class="voice-speak-wave level1"></div>
                        <div class="voice-speak-wave level2"></div>
                        <div class="voice-speak-wave level3"></div>
                        <span>完成</span>
                    </div>
                    <div class="voice-logo"></div>
                    <div class="voice-text">正在聆听中...</div>
                </div>
            </div>
            <!--语音识别界面结束-->

            <?php echo "开始进入时，从cookie中获得的username=".$username_ceshi." ||从cookie中获取的mid=".$mid_ceshi;echo "<br>"?>
            <?php echo "点击退出后，从cookie中获得的username=".$username_after." ||从cookie中获取的mid=".$mid_after;?>

            <div class="list-popup">
                <h3>播放列表</h3>
                <ul>
                    <?php foreach($program as $program_key=>$program_value) :?>
                    <li>
                        <span>
                            <img src="static/webios/images/music_default.png" width="30">
                        </span>
                        <span>
                            <a href="index.php?d=webios&c=webios&m=public_program_play&program_id=<?=$program_value['id']."&programme_id=".$programme['id']?>"><?=$program_value['title']?></a>
                        </span>
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>

        </div>
    </div>

    <!-- 其他的单个page内联页（如果有） -->
</div>

<!-- popup, panel 等放在这里 -->
<div class="panel-overlay"></div>
<!-- Left Panel with Reveal effect -->
<div class="panel panel-left panel-reveal">
    <div class="content-block">
        <dl>
            <dt><a href="index.php?d=webios&c=webios&m=upload_avatar_view&mid=<?=$mid?>" class="external"><img src="<?php if(!empty($user['avatar'])){echo $user['avatar'];}else{echo 'static/webios/img/play_bg.jpg';}?>"></a></dt>
            <dd><a href="#"><?=$user['username']?></a></dd>
        </dl>
        <ul>
            <li><i class="fa fa-file-text-o"></i><a href="index.php?d=webios&c=webios&m=my_programme&mid=<?=$mid?>" class="external">我的节目单</a></li>
            <li><i class="fa fa-heart-o"></i><a href="index.php?d=webios&c=webios&m=collect_view&mid=<?=$mid?>" class="external">我收藏的节目单</a></li>
            <li><i class="fa fa-pencil-square-o"></i><a href="index.php?d=webios&c=webios&m=feedback_view&mid=<?=$mid?>" class="external">意见反馈</a></li>
            <li><i class="fa fa-cog"></i><a href="index.php?d=webios&c=webios&m=setting_list&mid=<?=$mid?>" class="external">软件设置</a></li>
        </ul>
        <!--<p><input name="" type="button" value="+创建我的节目" class="pbtn"></p>-->
        <p><a href="index.php?d=webios&c=webios&m=creat_programme_view&mid=<?=$mid?>" class="pbtn external">+创建我的节目</a></p>
        <!-- Click on link with "close-panel" class will close panel -->
    </div>
</div>

<script type='text/javascript' src='http://g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<!--<script type='text/javascript' src='static/webios/js/jquery-1.8.1.min.js' charset='utf-8'></script>-->
<script type='text/javascript' src='static/webios/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='static/webios/js/sm-extend.min.js' charset='utf-8'></script>
</body>
</html>