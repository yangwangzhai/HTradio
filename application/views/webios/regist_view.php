<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>用户注册</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/sm.min.css">
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/sm-extend.min.css">
</head>
<body>
<div class="page-group">
    <div class="page page-current" style="margin-top: 0.5rem;">
        <!-- 你的html代码 -->
        <header class="bar bar-nav">
            <h1 class='title'>注册</h1>
        </header>
        <div class="content">
            <form method="post" action="index.php?d=webios&c=webios&m=regist">
                <div class="list-block">
                    <ul>
                        <!-- Text inputs -->
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-name"></i></div>
                                <div class="item-inner">
                                    <div class="item-title label">用户名称</div>
                                    <div class="item-input">
                                        <input type="text" name="username" id="username" placeholder="Your name" value="<?php echo $_COOKIE['username'];?>">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-name"></i></div>
                                <div class="item-inner">
                                    <div class="item-title label">昵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称</div>
                                    <div class="item-input">
                                        <input type="text" name="nickname" placeholder="nickname" value="<?php echo $_COOKIE['nickname'];?>">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-email"></i></div>
                                <div class="item-inner">
                                    <div class="item-title label">手机号码</div>
                                    <div class="item-input">
                                        <input type="text" name="tel" placeholder="tel" value="<?php echo $_COOKIE['tel'];?>">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-email"></i></div>
                                <div class="item-inner">
                                    <div class="item-title label">身份证号</div>
                                    <div class="item-input">
                                        <input type="text" name="IDcard" placeholder="IDcard" value="<?php echo $_COOKIE['IDcard'];?>">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-email"></i></div>
                                <div class="item-inner">
                                    <div class="item-title label">邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱</div>
                                    <div class="item-input">
                                        <input type="email" name="email" placeholder="E-mail" value="<?php echo $_COOKIE['email'];?>">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-password"></i></div>
                                <div class="item-inner">
                                    <div class="item-title label">密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码</div>
                                    <div class="item-input">
                                        <input type="password" name="password" placeholder="Password" id="pre_password" class="" value="<?php echo $_COOKIE['password'];?>">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-password"></i></div>
                                <div class="item-inner">
                                    <div class="item-title label">确认密码</div>
                                    <div class="item-input">
                                        <input type="password" name="password2" id="com_password" placeholder="Password" class="" value="<?php echo $_COOKIE['password2'];?>">
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="content-block">
                    <div class="row">
                        <div class="col-50"><a href="index.php?d=webios&c=webios&m=main_view" class="button button-big button-fill button-danger external">取消</a></div>
                        <div class="col-50"><input type="submit" class="button button-big button-fill button-success" value="提交"></div>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

<script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm-extend.min.js' charset='utf-8'></script>
</body>
</html>