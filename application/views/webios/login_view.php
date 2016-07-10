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
<div class="page-group loginbg" >
    <!-- 单个page ,第一个.page默认被展示-->
    <div class="page" style="margin-top: 0.5rem;">
        <header class="bar bar-nav" >
            <a class="button button-link button-nav pull-left external" href="index.php?d=webios&c=webios&m=main_view" >
                返回
            </a>
        </header>
        <!-- 这里是页面内容区 -->
        <div class="content">
            <form method="post" action="index.php?d=webios&c=webios&m=check_login">
                <div class="login">
                    <ul>
                        <li>
                            <input name="username" type="text" class="loginuser" placeholder="用户名" value="<?php echo $_COOKIE['username'];?>">
                        </li>
                        <li>
                            <input name="password" type="password" class="loginpwd" placeholder="密码" value="<?php echo $_COOKIE['password'];?>">
                        </li>
                        <li>
                            <input type="submit" class="loginbtn" value="登  录">
                        </li>
                        <li>
                            <label>
                                <input name="remember" type="checkbox" value="1" checked="checked">
                                记住密码</label>
                            <label><a href="#" class="forget">忘记密码？</a></label>
                        </li>
                        <li class="loginreg"><a href="index.php?d=webios&c=webios&m=regist_view" class="external">新注册</a></li>
                    </ul>
                </div>
            </form>
        </div>
    </div>
</div>

<script type='text/javascript' src='http://g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<!--<script type='text/javascript' src='static/webios/js/jquery-1.8.1.min.js' charset='utf-8'></script>-->
<script type='text/javascript' src='static/webios/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='static/webios/js/sm-extend.min.js' charset='utf-8'></script>
</body>
</html>