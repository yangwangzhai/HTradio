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
</head>
<body>
<!-- page集合的容器，里面放多个平行的.page，其他.page作为内联页面由路由控制展示 -->
<div class="page-group">
    <!-- 单个page ,第一个.page默认被展示-->
    <div class="page" id="check_box" style="margin-top: 0.5rem;">
        <!-- 标题栏 -->
        <header class="bar bar-nav  regtitle">
            <a class="button button-link button-nav pull-left" href="index.php?d=webios&c=webios&m=creat_programme_view" class="external" >
                返回
            </a>
            <h1 class="title" >添加节目</h1>
        </header>

        <!-- 这里是页面内容区 -->
        <div class="content">
            <input type="hidden" name="ids" id="ids" value="<?=$ids?>">
            <input type="hidden" name="title" id="search" value="<?=$title?>">
            <?php if(!empty($list)) {?>
                <?php foreach($list as $value) : ?>
                    <div class="list-block media-list">
                        <ul>
                            <li>
                                <label class="label-checkbox item-content">
                                    <div class="item-media"><img src="static/webios/img/play_bg.jpg" style='width: 2.8rem; height:2.6rem'></div>
                                    <div class="item-inner">
                                        <div class="item-title-row">
                                            <div class="item-title"><?=$value['title']?></div>
                                        </div>
                                        <div class="item-subtitle">上传者：xxxx</div>
                                    </div>
                                    <input type="checkbox" name="my-radio" value="<?=$value['id']?>">
                                    <div class="item-media"><i class="icon icon-form-checkbox"></i></div>
                                </label>
                            </li>
                        </ul>
                    </div>
                <?php endforeach?>
            <?php }else{?>
                <p style="color: #000000;">暂时类型没有资源</p>
            <?php }?>
            <div class="fbtn">完成</div>
        </div>
    </div>
</div>
<script type='text/javascript' src='http://g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<!--<script type='text/javascript' src='static/webios/js/jquery-1.8.1.min.js' charset='utf-8'></script>-->
<script type='text/javascript' src='static/webios/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='static/webios/js/sm-extend.min.js' charset='utf-8'></script>
<script type='text/javascript' src='static/webios/js/demo.js' charset='utf-8'></script>
</body>
</html>