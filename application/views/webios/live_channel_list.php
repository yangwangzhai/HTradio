<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>电台直播</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/sm.min.css">
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/sm-extend.min.css">

    <script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm.min.js' charset='utf-8'></script>
    <script>
        //打开自动初始化页面的功能
        //建议不要打开自动初始化，而是自己调用 $.init 方法完成初始化
        $.config = {
            swipePanelOnlyClose: false;
        }
    </script>
</head>
<body>
<div class="page-group">
    <div class="page">
        <header class="bar bar-nav">
            <h1 class='title'>侧栏</h1>
        </header>
        <div class="content">
            <div class="content-block">
                <p><a href="#" class="button button-fill open-panel" data-panel='#panel-left-demo'>打开左侧栏</a></p>
            </div>
        </div>
    </div>
    <div class="panel-overlay"></div>
    <!-- Left Panel with Reveal effect -->
    <div class="panel panel-left panel-reveal theme-dark" id='panel-left-demo'>
        <div class="content-block">
            <p>这是一个侧栏</p>
            <p>你可以在这里放用户设置页面</p>
            <p><a href="#" class="close-panel">点击关闭</a> 或者你可以滑动关闭哦</p>
        </div>

<script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm-extend.min.js' charset='utf-8'></script>

</body>
</html>