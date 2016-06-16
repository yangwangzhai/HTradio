<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//新浪微博登录回调入口文件，将路径转移到login/callback方法里，并将code值传过去


$code ='';
$url = '';
$str ='';
$code = $_REQUEST['code'];
$url  = "index.php?c=sin_login&m=callback";
if($code) {
    $str = "<!doctype html>
<html>
    <head>
    <meta charset=\"UTF-8\">
    <title>自动跳转</title>
    </head>
<body>";
    $str .= "<form action=\"{$url}\" method=\"post\" id=\"form\" autocomplete='off'>";
    $str .= "<input type='hidden' name='code' value='{$code}'>";
    $str .= "</form>
        </body>
        </html>
        <script type=\"text/javascript\">
           document.getElementById('form').submit();
        </script>";
    echo $str;
}
echo '<script src="http://tjs.sjs.sinajs.cn/t35/apps/opent/js/frames/client.js" language="JavaScript"></script>';