<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="static/ql/css/style.css" rel="stylesheet" type="text/css" />
    <link href="static/ql/css/select.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="static/ql/js/jquery.js"></script>
    <script type="text/javascript" src="static/ql/js/jquery.idTabs.min.js"></script>
    <script type="text/javascript" src="static/ql/js/select-ui.min.js"></script>
    <script type="text/javascript" src="static/ql/editor/kindeditor.js"></script>

    <script type="text/javascript">
        KE.show({
            id : 'content7',
            cssPath : './index.css'
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(e) {
            $(".select1").uedSelect({
                width : 345
            });
            $(".select2").uedSelect({
                width : 167
            });
            $(".select3").uedSelect({
                width : 100
            });
        });
    </script>
</head>

<body>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#">系统设置</a></li>
    </ul>
</div>

<div class="formbody">

    <div id="usual1" class="usual">
        <form action="index.php?d=admin&c=common&m=android_version_save" method="post">

            <div id="tab1" class="tabson">
                <ul class="forminfo">
                    <li><label>版本号<b>*</b></label><input name="value[version]" value="<?=$web[version];?>" type="text" class="dfinput" style="width:518px;"/></li>
                    <li><label>是否强制更新<b>*</b></label><input name="value[isneed]" value="<?=$web[isneed];?>" type="text" class="dfinput" style="width:518px;"/> 0否 1是</li>
                    <li><label>维护提示语<b>*</b></label><input name="value[maintenance]" value="<?=$web[maintenance]?>" type="text" class="dfinput" style="width:518px;"/>服务器维护信息，如果信息不为空的话，客户端应提示出来</li>
                    <li><label>更新地址<b>*</b></label><input name="value[url]" value="<?=$web[url]?>" type="text" class="dfinput" style="width:518px;"/></li>
                    <li>
                        <label>更新说明<b>*</b></label>
                        <textarea id="content7" name="value[message]" style="width:700px;height:250px;visibility:hidden;"><?=$web[message];?></textarea>
                    </li>
                    <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="马上提交"/></li>
                </ul>
            </div>
        </form>
    </div>

</div>


</body>

</html>
