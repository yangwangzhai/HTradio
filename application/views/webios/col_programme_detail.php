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
    <link rel="stylesheet" href="static/webios/css/style_play.css">
</head>
<body>
<!-- page集合的容器，里面放多个平行的.page，其他.page作为内联页面由路由控制展示 -->
<div class="page-group">
    <!-- 单个page ,第一个.page默认被展示-->
    <div class="page" id="programme_detail" style="margin-top: 0.5rem;">
        <header class="bar bar-nav">
            <a class="button button-link button-nav pull-left external" href="index.php?d=webios&c=webios&m=collect_view&mid=<?=$mid?>">
                <span class="icon icon-left"></span>
                返回
            </a>
            <h1 class="title">收藏的节目单</h1>
        </header>
        <!-- 这里是页面内容区 -->
        <div class="content">
            <div class="card facebook-card">
                <div class="card-header">
                    <div class="facebook-avatar"><img src="<?=$avatar;?>" style='width: 2rem; height:2rem'></div>
                    <div class="facebook-name"><?=$programme_title;?></div>
                    <div class="facebook-date"><?=$username;?></div>
                </div>
                <div class="card-footer">
                    <a href="#" class="link">收藏 <?=$col_num?></a>
                    <a href="#" class="link">评论 <?=$con_num?></a>
                    <a href="#" class="link" style="visibility:hidden;">分享 7</a>
                    <a href="#" class="link" style="visibility:hidden;">下载 5</a>
                </div>
            </div>
            <?php foreach($program_list as $value) :?>
                <div class="list-block media-list">
                    <ul>
                        <li>
                            <a href="index.php?d=webios&c=webios&m=col_program_play&programme_id=<?=$programme_id?>&program_id=<?=$value['program_id']?>&programme_title=<?=$programme_title;?>&col_num=<?=$col_num?>&mid=<?=$mid?>">
                                <label class="label-checkbox item-content">
                                    <div class="item-media"><img src="static/webios/img/program_default.jpg" style='width: 2.8rem; height:2.6rem'></div>
                                    <div class="item-inner">
                                        <div class="item-title-row">
                                            <div class="item-title"><?=$value['title']?></div>
                                        </div>
                                        <div class="item-subtitle">上传者：<?=$value['nickname']?> <!--.时长：xx分钟--></div>
                                    </div>
                                </label>
                            </a>
                        </li>
                    </ul>
                </div>
            <?php endforeach?>
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