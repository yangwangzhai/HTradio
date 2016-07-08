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
    <div class="page" id="creat_programme" style="margin-top: 0.5rem;">
        <!-- 标题栏 -->
        <header class="bar bar-nav  regtitle">
            <a class="button button-link button-nav pull-left" href="index.php?d=webios&c=webios&m=main_view" class="external" >
                返回
            </a>
            <h1 class="title" >选择节目类型</h1>
        </header>
        <form method="post" action="index.php?d=webios&c=webios&m=save_creat_programme">
            <div class="bar bar-header-secondary">
                <div class="searchbar"> <a class="searchbar-cancel">取消</a>
                    <div class="search-input">
                        <input type="text" name="title" id='search' placeholder='输入节目单名称' value="<?=$title?>"/>
                        <input type="hidden" name="ids" id="ids" value="<?=$ids?>">
                    </div>
                </div>
            </div>

            <!-- 这里是页面内容区 -->
            <div class="content">
                <div class="select">已选择（<?=$num?>）个节目<input type="submit" name="" value="提交" class="tbtn"></div>
                <?php foreach($list as $value) : ?>
                    <div class="list-block media-list">
                        <ul>
                            <li class="creat_programme_li" data-id="<?=$value['id']?>">
                                <div class="item-link item-content">
                                    <div class="item-media"><img src="<?=$value['thumb']?>" style='width: 2.8rem; height:2.6rem'></div>
                                    <div class="item-inner">
                                        <div class="item-title-row">
                                            <div class="item-title"><?=$value['title']?></div>
                                        </div>
                                        <div class="item-subtitle">413</div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                <?php endforeach?>
            </div>
        </form>
    </div>
</div>
<script type='text/javascript' src='http://g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<!--<script type='text/javascript' src='static/webios/js/jquery-1.8.1.min.js' charset='utf-8'></script>-->
<script type='text/javascript' src='static/webios/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='static/webios/js/sm-extend.min.js' charset='utf-8'></script>
<script type='text/javascript' src='static/webios/js/demo.js' charset='utf-8'></script>
</body>
</html>