<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>抓取欧洲杯新闻</title>
    <script type="text/javascript" src="http://127.0.0.1/HTradio/static/js/jquery-1.8.3.min.js"></script>
</head>
<body >
<input type="button" value="显示！" onClick = "aa()">
<iframe src="http://127.0.0.1/HTradio/index.php?d=android&c=program&m=get_news">
</iframe>
</body>
<script>
    setTimeout(aa(),600000);
    function aa(){
        window.location.href="http://127.0.0.1/HTradio/index.php?d=android&c=program&m=get_news_view";
    }
</script>
</html>