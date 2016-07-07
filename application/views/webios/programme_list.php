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
    <div id="page-tabs" class="page">
        <header class="bar bar-nav">
            <a class="button button-link button-nav pull-left" href="index.php?d=webios&c=webios&m=main_view" class="external">
                <span class="icon icon-left"></span>
                返回
            </a>
            <h1 class="title">我的节目单</h1>
        </header>
        <div class="content">
            <div class="list-block">
                <ul>
                    <?php if(!empty($list)){?>
                        <?php foreach($list as $value) :?>
                            <li>
                                <a href="index.php?d=webios&c=webios&m=programme_detail&programme_id=<?=$value['id']?>" class="item-link item-content">
                                    <div class="item-inner">
                                        <div class="item-title"><?=$value['title']?></div>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach?>
                    <?php }else{?>
                        <li style="text-align: center;">您还未创建有节目单！</li>
                    <?php }?>
                </ul>
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
