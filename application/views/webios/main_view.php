<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>我的生活</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/sm.min.css">
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/sm-extend.min.css">

</head>
<body>

<!-- page集合的容器，里面放多个平行的.page，其他.page作为内联页面由路由控制展示 -->
<div class="page-group">
    <!-- 单个page ,第一个.page默认被展示-->
    <div class="page">
        <!-- 标题栏 -->
        <header class="bar bar-nav">
            <a class="icon icon-me pull-left open-panel"></a>
            <h1 class="title">标题</h1>
        </header>

        <!-- 工具栏 -->
        <nav class="bar bar-tab">
            <a class="tab-item external active" href="#">
                <span class="icon icon-home"></span>
                <span class="tab-label">首页</span>
            </a>
            <a class="tab-item external" href="#">
                <span class="icon icon-star"></span>
                <span class="tab-label">收藏</span>
            </a>
            <a class="tab-item external" href="#">
                <span class="icon icon-settings"></span>
                <span class="tab-label">设置</span>
            </a>
        </nav>

        <!-- 这里是页面内容区 -->
        <div class="content">
            <div class="content-block">这里是content</div>
        </div>
    </div>

</div>

<!-- popup, panel 等放在这里 -->
<div class="panel-overlay"></div>
<!-- Left Panel with Reveal effect -->
<div class="panel panel-left panel-reveal">
    <div class="content-block">
        <div class="content">
            <div class="list-block cards-list">
                <ul>
                    <li class="card">
                        <div class="card-header">卡头</div>
                        <div class="card-content">
                            <div class="card-content-inner">卡内容</div>
                        </div>
                        <div class="card-footer">卡脚</div>
                    </li>
                    <li class="card">
                        <div class="card-header">卡头</div>
                        <div class="card-content">
                            <div class="card-content-inner">卡内容</div>
                        </div>
                        <div class="card-footer">卡脚</div>
                    </li>
                    <li class="card">
                        <div class="card-header">卡头</div>
                        <div class="card-content">
                            <div class="card-content-inner">卡内容</div>
                        </div>
                        <div class="card-footer">卡脚</div>
                    </li>
                </ul>
            </div>
        </div>
        <p><a href="#" class="close-panel">关闭</a></p>
    </div>
</div>

<script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm-extend.min.js' charset='utf-8'></script>
<!-- 默认必须要执行$.init(),实际业务里一般不会在HTML文档里执行，通常是在业务页面代码的最后执行 -->
</body>
</html>
