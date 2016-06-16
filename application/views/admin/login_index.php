<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!--<meta http-equiv="X-UA-Compatible" content="IE=10;chrome=1">-->

    <title><?=$website['title']?></title>
    <style type="text/css">
        *
        {
            margin: 0px;
        }
        html
        {
            overflow-y: hidden;
        }
        #cont
        {
            background-color: #f9f9f9;
            width: 100%;
            position: relative;
        }
        .stage
        {
            width: 100%;
            height: 100%;
            display: block;
            position: relative;
            overflow: hidden;
        }
        .stage_box
        {
            width: 950px;
            height: 75%;
            margin: auto;
            position: relative;
            text-align: left;
            overflow: hidden;
        }
        .stage_box img
        {
            margin-top: -40px;
        }
      
        
        .index_ins
        {
            position: absolute;
            left: 30px;
            top: 180px;
            width: 222px;
            height: 145px;
            background: url(images/features4.2preview/index_ins.png) no-repeat; /*filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, sizingMethod=scale, src="images/features4.2preview/index_ins.png");+background-image: none;*/
        }
        
        .index_link
        {
            cursor: pointer;
            text-align: center;
        }
        .index_link1
        {
            position: absolute;
            width: 120px;
            height: 19px;
            left: 673px;
            top: 181px;
            background: url(static/admin_img/index_link1.png) no-repeat 0 3px;
            padding: 0 0 0 10px;
            font-family: "微软雅黑";
            color: #666;
        }
        .index_link1:hover
        {
            left: 683px;
        }
        .index_link2
        {
            position: absolute;
            width: 167px;
            height: 19px;
            left: 703px;
            top: 232px;
            background: url(static/admin_img/index_link2.png) no-repeat  0 4px;
            padding: 0 0 0 5px;
            font-family: "微软雅黑";
            color: #666;
        }
        .index_link2:hover
        {
            left: 713px;
        }
        
        .index_link3
        {
            position: absolute;
            width: 167px;
            height: 19px;
            left: 733px;
            top: 280px;
            background: url(static/admin_img/index_link_plus.png) no-repeat 0 1px;
            padding: 0 0 0 10px;
            font-family: "微软雅黑";
            color: #666;
        }
        .index_link3:hover
        {
            left: 743px;
			
        }
        
        .index_link4
        {
            position: absolute;
            width: 167px;
            height: 19px;
            left: 703px;
            top: 328px;
            background: url(static/admin_img/index_link3.png) no-repeat;
            padding: 0 0 0 10px;
            font-family: "微软雅黑";
            color: #666;
        }
        .index_link4:hover
        {
            left: 713px;
        }
        .index_link5
        {
            position: absolute;
            width: 147px;
            height: 19px;
            left: 673px;
            top: 374px;
            background: url(static/admin_img/index_link4.png) no-repeat;
            padding: 0 0 0 10px;
            font-family: "微软雅黑";
            color: #666;
        }
        .index_link5:hover
        {
            left: 683px;
        }
        
        
        
     
        
        #logo
        {
            position: absolute;
            top: 2px;
            left: 2.5px;
        }
        
        a
        {
            text-decoration: none;
        }
        
        a:link
        {
            color: #666666;
            text-decoration: none;
        }
        a:visited
        {
            color: #666666;
            text-decoration: none;
        }
        a:hover
        {
            color: #666666;
            text-decoration: none;
        }
        a:active
        {
            color: #666666;
            text-decoration: none;
        }
    </style>
</head>
<body scroll="no">
    <div id="cont">
        <div style="height: 763px;" class="stage">
            <div style="top: 95.5px;" class="stage_box">
                <div class="index_link1 index_link" index="1">
                    <a target="_blank" href="index.php">网站首页</a>
                </div>
                <div class="index_link2 index_link" index="2">
                    <a target="_blank" href="index.php?d=admin&c=common&m=logins">后台管理登录</a>
                </div>
                <div class="index_link3 index_link" index="3">
		    <a target="_blank" href="index.php?d=audio&c=common&m=login"></a>
                </div>
                <div class="index_link4 index_link" index="4">
                </div>
                <div class="index_link5 index_link" index="5">
                </div>
                <img src="static/admin_img/logo_bg.png">
            </div>
        </div>
    </div>
    <script type="text/javascript" src="static/js/jquery_1.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
            if (is_chrome) {
                //判断是chrome、搜狗chrome内核, 供scrollTop兼容性使用
                windowobject = "body";
            } else {
                //支持ie和ff
                windowobject = "html";
            }

            //当前窗口大小
            windowHeight = document.documentElement.clientHeight;

            $(".stage").css("height", windowHeight);
            $(".stage_box").css("top", (windowHeight - $(".stage_box").height()) / 2 + "px");
            //            $("#guider").css("top", $("body").height() - windowHeight / 2 - $("#guider").height() / 2);

            var opt = { step: windowHeight, f: 1 };
            var div = document.body;

            //窗口大小变化时，触发每个屏幕大小变化
            var resizeHandler = function () {
                $("body").stop(true, true);
                //阻止碰撞
                stop = 1;

                windowHeight = document.documentElement.clientHeight;

                $(".stage").css("height", windowHeight);
                $(".stage_box").css("top", (windowHeight - $(".stage_box").height()) / 2 + "px");
                //                $("#guider").css("top", $("body").height() - windowHeight / 2 - $("#guider").height() / 2);
                var opt = { step: windowHeight, f: 1 };
                var div = document.body;

                var index = Math.floor($(window).scrollTop() / windowHeight);
                $(windowobject).animate({ "scrollTop": index * windowHeight + "px" });
                //                if (index != 0) {
                //                    var tmpheight = index * windowHeight + (windowHeight - $("#guider").height()) / 2;
                //                    $("#guider").animate({ "top": tmpheight }, 0, function () {
                //                        $(".guider_link").removeClass("select");
                //                        $(".guider_link").eq(index).addClass("select");
                //                    });
                //                }
                //300毫秒后执行stop=0,目的是保证ie下crash函数（也是timer）执行完。
                setTimeout(function () {
                    stop = 0;
                }, 300);
            }
            $(window).resize(function () {
                //bugfix ie内核只有在定时器触发这个函数才能正确执行
                setTimeout(resizeHandler, 10);
            });

            $(windowobject).animate({ "scrollTop": "0px" });



        });
    
    
    </script>


<script src="static/js/_tts_browser_center.js" data-version="1.4.1" data-browser="iexplore" data-source="Firefox" data-guid="000000001955B6EBB8A9847F8E30338C" data-id="0011000820131018" charset="utf-8" type="text/javascript" id="J---TK-load"></script></body></html>