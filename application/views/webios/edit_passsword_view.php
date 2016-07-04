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
    <div class="page page-current">
        <!-- 你的html代码 -->
        <header class="bar bar-nav">
            <h1 class='title'>修改密码</h1>
        </header>
        <div class="content">
            <form method="post" action="index.php?d=webios&c=webios&m=password_save" id="form">
                <div class="list-block">
                    <ul>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-password"></i></div>
                                <div class="item-inner">
                                    <div class="item-title label">旧&nbsp;&nbsp;密&nbsp;&nbsp;码</div>
                                    <div class="item-input">
                                        <input type="password" name="old_password" placeholder="Password" class="">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-password"></i></div>
                                <div class="item-inner">
                                    <div class="item-title label">新&nbsp;&nbsp;密&nbsp;&nbsp;码</div>
                                    <div class="item-input">
                                        <input type="password" name="new_password" placeholder="Password" id="pre_password" class="">
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
                                        <input type="password" name="password" id="com_password" placeholder="Password" class="">
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="content-block">
                    <div class="row">
                        <div class="col-50"><a href="#" class="button button-big button-fill button-danger">取消</a></div>
                        <div class="col-50"><a href="#" class="button button-big button-fill button-success">提交</a></div>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

<script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm-extend.min.js' charset='utf-8'></script>
<script type="text/javascript" src="static/js/common.js?1"></script>
<script>
    $(document).ready(function(){
        //表单提交
        $(".button-success").click(function(){
            //校验两次密码是否一致
            var pre_password = $("#pre_password").val();
            var com_password = $("#com_password").val();
            if(pre_password==com_password){
                $("#form").submit();
            }else{
                alert("两次密码不一致");
            }
        });
    })
</script>
</body>
</html>