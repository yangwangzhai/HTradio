<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SUI Mobile Demo</title>
    <meta name="description" content="MSUI: Build mobile apps with simple HTML, CSS, and JS components.">
    <meta name="author" content="阿里巴巴国际UED前端">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">

    <!-- Google Web Fonts -->

    <link rel="stylesheet" href="http://m.sui.taobao.org/dist/css/sm.css">
    <link rel="stylesheet" href="http://m.sui.taobao.org/dist/css/sm-extend.css">
    <link rel="stylesheet" href="http://m.sui.taobao.org/assets/css/demos.css">

    <link rel="apple-touch-icon-precomposed" href="http://m.sui.taobao.org/assets/img/apple-touch-icon-114x114.png">
    <script src="http://m.sui.taobao.org/assets/js/zepto.js"></script>
    <script src="http://m.sui.taobao.org/assets/js/config.js"></script>
    <script>
        //ga
    </script>
    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "//hm.baidu.com/hm.js?ba76f8230db5f616edc89ce066670710";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>

</head>
<body>
<div class="page-group">
    <div id="show_message" class="page">
        <header class="bar bar-nav">
            <h1 class="title">提示信息</h1>
        </header>
        <div class="content">
                <div class="list-block">
                    <ul>
                        <li class="align-top">
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-input">
                                        <h3 style="text-align: center;"><?=$mess?></h3>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="content-block">
                    <div class="row">
                        <div class="col-50" style="width: 80%;margin-left: 30px;"><a href="index.php?d=webios&c=webios&m=<?=$url?>" class="button button-big button-fill button-success external">确定</a></div>
                    </div>
                </div>
        </div>
    </div>

</div>
<script src="http://m.sui.taobao.org/dist/js/sm.js"></script>
<script src="http://m.sui.taobao.org/dist/js/sm-extend.js"></script>
<script src="http://m.sui.taobao.org/dist/js/sm-city-picker.js"></script>
<script src="http://m.sui.taobao.org/assets/js/demos.js"></script>
</body>
</html>