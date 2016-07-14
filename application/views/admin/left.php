<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>无标题文档</title>
    <link href="static/ql/css/style.css" rel="stylesheet" type="text/css"/>
    <script language="JavaScript" src="static/ql/js/jquery.js"></script>

    <script type="text/javascript">
        $(function () {
            //导航切换
            $(".menuson li").click(function () {
                $(".menuson li.active").removeClass("active")
                $(this).addClass("active");
            });

            $('.title').click(function () {
                var $ul = $(this).next('ul');
                $('dd').find('ul').slideUp();
                if ($ul.is(':visible')) {
                    $(this).next('ul').slideUp();
                } else {
                    $(this).next('ul').slideDown();
                }
            });
        })
    </script>


</head>

<body style="background:#015c95;">

<dl class="leftmenu">

    <dd>
        <div class="title">统计展示</div>
        <ul class="menuson">
            <li><cite></cite><a href="index.php?d=admin&c=stat&m=PV" target="rightFrame">客户端访问量统计</a><i></i></li>
            <li><cite></cite><a href="index.php?d=admin&c=stat&m=Installs" target="rightFrame">客户端安装量统计</a><i></i></li>
            <!--<li><cite></cite><a href="index.php?d=admin&c=stat&m=res_type" target="rightFrame">资源分类统计</a><i></i></li>-->
            <li><cite></cite><a href="index.php?d=admin&c=stat&m=program_stat" target="rightFrame">节目统计</a><i></i></li>
<!--            <li><cite></cite><a href="index.php?d=admin&c=stat&m=renqi_stat&type=1" target="rightFrame">主持人气统计</a><i></i></li>-->
<!--            <li><cite></cite><a href="index.php?d=admin&c=stat&m=renqi_stat&type=0" target="rightFrame">用户人气统计</a><i></i></li>-->
        </ul>
    </dd>

    <dd>
        <div class="title">互动管理</div>
        <ul class="menuson">
            <!--<li><cite></cite><a href="index.php?d=admin&c=comment&m=index" target="rightFrame">评论管理</a><i></i></li>
            <li><cite></cite><a href="index.php?d=admin&c=message&m=index" target="rightFrame">私信管理</a><i></i></li>-->
            <li><cite></cite><a href="index.php?d=admin&c=feedback&m=index" target="rightFrame">意见管理</a><i></i></li>
            <!--<li><cite></cite><a href="index.php?d=admin&c=report_all&m=index" target="rightFrame">举报管理</a><i></i></li>-->
        </ul>
    </dd>

    <dd>
        <div class="title">会员管理</div>
        <ul class="menuson">
            <li><cite></cite><a href="index.php?d=admin&c=member&m=index" target="rightFrame">会员管理</a><i></i></li>
        </ul>
    </dd>


    <dd>
        <div class="title">媒资管理</div>
        <ul class="menuson">
            <li><cite></cite><a href="index.php?d=admin&c=channel&m=live_channel_list" target="rightFrame">直播频道</a><i></i></li>
            <li><cite></cite><a href="index.php?d=admin&c=programme&m=public_index" target="rightFrame">公共频道</a><i></i></li>
            <li><cite></cite><a href="index.php?d=admin&c=programme&m=index" target="rightFrame">个人频道</a><i></i></li>
            <li><cite></cite><a href="index.php?d=admin&c=program&m=index" target="rightFrame">节目列表</a><i></i></li>
            <li><cite></cite><a href="index.php?d=admin&c=program_type&m=index" target="rightFrame">节目类型</a><i></i></li>
            <!--<li><cite></cite><a href="index.php?d=admin&c=tag&m=index" target="rightFrame">标签管理</a><i></i></li>-->
        </ul>

    </dd>

    <dd>
        <div class="title">系统管理</div>
        <ul class="menuson">
            <li><cite></cite><a href="index.php?d=admin&c=admin&m=index" target="rightFrame">管理员管理</a><i></i></li>
            <li><cite></cite><a href="index.php?d=admin&c=role_group&m=index" target="rightFrame">用户角色管理</a><i></i></li>
            <li><cite></cite><a href="index.php?d=admin&c=permission&m=index" target="rightFrame">角色权限管理</a><i></i></li>
            <li><cite></cite><a href="index.php?d=admin&c=link&m=index" target="rightFrame">友情链接</a><i></i></li>
            <li><cite></cite><a href="index.php?d=admin&c=common&m=website" target="rightFrame">通用设置</a><i></i></li>
            <li><cite></cite><a href="index.php?d=admin&c=badword&m=index" target="rightFrame">敏感词管理</a><i></i></li>
            <li><cite></cite><a href="index.php?d=admin&c=database&m=index" target="rightFrame">数据库管理</a><i></i></li>
            <li><cite></cite><a href="index.php?d=admin&c=adminlog&m=index" target="rightFrame">后台操作日志</a><i></i></li>
            <li><cite></cite><a href="index.php?d=admin&c=stat&m=index" target="rightFrame">访问日志</a><i></i></li>
            <li><cite></cite><a href="index.php?d=admin&c=cache" target="rightFrame">更新缓存</a><i></i></li>
            <li><cite></cite><a href="index.php?d=admin&c=download" target="rightFrame">软件下载</a><i></i></li>
            <li><cite></cite><a href="index.php?d=admin&c=common&m=android_version" target="rightFrame">安卓版更新</a><i></i></li>
            <li><cite></cite><a href="index.php?d=admin&c=ioscrash" target="rightFrame">iOScrash管理</a><i></i></li>
        </ul>

    </dd>

</dl>

</body>
</html>
