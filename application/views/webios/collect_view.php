<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>我收藏的节目单</title>
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
    <link rel="stylesheet" type="text/css"	href="static/webios/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css"	href="static/webios/css/font-awesome-ie7.min.css" />
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
    <div id="page-tabs" class="page" style="margin-top: 0.5rem;">
        <header class="bar bar-nav">
            <a class="button button-link button-nav pull-left" href="index.php?d=webios&c=webios&m=main_view" class="external">
                <span class="icon icon-left"></span>
                返回
            </a>
            <h1 class="title">我收藏的节目单</h1>
            <a class="pull-right external" href="index.php?d=webios&c=webios&m=add_col_programme_view" style="margin-top: 10px;margin-right: 10px;"><i class="fa fa-plus"></i></a>
        </header>
        <div class="content">
            <?php if(!empty($list)){?>
                <?php foreach($list as $value) :?>
                    <div class="card facebook-card">
                        <a href="index.php?d=webios&c=webios&m=col_programme_detail&programme_id=<?=$value['programme_id']?>&programme_title=<?=$value['title']?>&col_num=<?=$value['col_num']?>">
                            <div class="card-header">
                                <div class="facebook-avatar"><img src="static/webios/img/play_bg.jpg" style='width: 2rem; height:2rem'></div>
                                <div class="facebook-name"><?=$value['title']?></div>
                                <div class="facebook-date"><?=$value['name']?></div>
                            </div>
                        </a>
                        <div class="card-footer"><a href="#" class="link">收藏 <?=$value['col_num']?></a> <a href="#" class="link">评论 4</a> <a href="#" class="link">分享 7</a> <a href="#" class="link">下载 5</a></div>
                    </div>
                <?php endforeach?>
            <?php }else{?>
                <div class="list-block">
                    <ul>
                        <li style="text-align: center;background: none;">您没有收藏的节目单！</li>
                    </ul>
                </div>
            <?php }?>
        </div>
    </div>

</div>
<script src="http://m.sui.taobao.org/dist/js/sm.js"></script>
<script src="http://m.sui.taobao.org/dist/js/sm-extend.js"></script>
<script src="http://m.sui.taobao.org/dist/js/sm-city-picker.js"></script>

</body>
</html>
