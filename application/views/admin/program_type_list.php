<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="static/ql/css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="static/ql/js/jquery.js"></script>
    <script charset="utf-8" src="static/js/kindeditor410/kindeditor.js?2"></script>
    <script charset="utf-8" src="static/js/kindeditor410/lang/zh_CN.js"></script>
    <script type="text/javascript" src="static/js/common.js?1"></script>
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="plugin/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".click").click(function(){
                $(".tip").fadeIn(200);
            });

            $(".tiptop a").click(function(){
                $(".tip").fadeOut(200);
            });

            $(".sure").click(function(){
                $(".tip").fadeOut(100);
                $("#my_form").submit();
            });

            $(".cancel").click(function(){
                $(".tip").fadeOut(100);
            });

            $(".add_click").click(function(){
                location.href="<?=$this->baseurl?>&m=add&catid=<?=$catid?>'";
            });

            // 点击更改状态
            $(".updatestatus").click(function(){
                var id = $(this).data("id");
                var mystatus = $(this).data("hot");
                if(mystatus == "0")
                {
                    mystatus = 1;
                }else if(mystatus == "1"){
                    mystatus = 0;
                }

                $.get("<?=$this->baseurl?>&m=updatestatus", { id: id, status: mystatus , field: 'status' },function(data){
                    location.reload();
                });
            });

        });


    </script>


</head>


<body>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#">数据表</a></li>
        <li><a href="#">基本内容</a></li>
    </ul>
</div>

<div class="rightinfo">

    <div class="tools">

        <ul class="toolbar">
            <li class="add_click"><span><img src="static/ql/images/t01.png" /></span>添加</li>
            <li class="click"><span><img src="static/ql/images/t03.png" /></span>删除</li>
        </ul>

		<span style="float: right">
		<form action="<?=$this->baseurl?>&m=index" method="post">
            <input type="hidden" name="catid" value="<?=$catid?>">
            <input class="dfinput" type="text" name="keywords" value="" style="width: 150px;">
            <input class="btn btn-primary" type="submit" id="mysearch" name="submit" value=" 搜索" style="width: 50px;">
        </form>
	</span>
    </div>

    <form action="<?=$this->baseurl?>&m=delete" method="post" id="my_form">
    <input type="hidden" name="catid" value="<?=$catid?>">
    <table class="tablelist">
        <thead>
        <tr>
            <th><input type="checkbox" name="chkall" id="chkall" onclick="checkall('delete[]')" class="checkbox" /></th>
            <th></th>
            <th width="50">缩略图</th>
            <th>类型名称</th>
            <th>排序</th>
            <th>子类型</th>
            <th>添加时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($list as $key=>$r) {?>
            <tr>
                <td><input type="checkbox" name="delete[]" value="<?=$r['id']?>"
                           class="checkbox" /></td>
                <td><?=$key+1?></td>
                <td style="text-indent: 0;">
                    <a onclick="vPics('<?=$r['title']?>','<?=$r['thumb']?>');" href="javascript:;">
                        <img width="100%" src="<?=$r['thumb']?>" id="thumb" />
                    </a>
                </td>
                <td><?=$r['title']?></td>
                <td><?=$r['sort']?></td>
                <td>
                    <?php foreach($list_sub as $k=>$v) {
                        if($r['id']==$v['pid']){ ?>
                            <span style="display: inline;height:20px;border: 1px solid #ccc;padding: 2px; line-height: 20px; margin-right: 3px;">
                            <a href="<?=$this->baseurl?>&m=edit&id=<?=$v['id']?>" title="点击修改"><?=$v['title']?></a>
                            <a	href="<?=$this->baseurl?>&m=delete&catid=<?=$catid?>&id=<?=$v['id']?>" onclick="return confirm('确定要删除吗？');">
                                <font style="color:#F00">&nbsp;x</font>
                            </a>
                            </span>
                        <?php	 }?>
                    <?php	 }?>

                </td>

                <td><?=times($r['addtime'],1)?></td>
                <td>
                    <?php if(checkAccess('program_type_add')){?>
                        <a href="<?=$this->baseurl?>&m=add_sub&id=<?=$r['id']?>">添加子分类</a>
                    <?php }else{echo '--';}?>
                    &nbsp;&nbsp;
                    <?php if(checkAccess('program_check')){?>
                        <a href="javascript:" title="点击更改状态" class="updatestatus" style="color:<?php if($r[hot]==1){echo 'green';} ?>" data-id="<?=$r['id']?>" data-hot="<?=$r['hot']?>"><?=$status[$r[hot]]?></a>
                    <?php }else{echo '--';}?>

                    &nbsp;&nbsp;
                    <?php if(checkAccess('program_type_edit')){?>
                        <a href="<?=$this->baseurl?>&m=edit&id=<?=$r['id']?>">修改</a>
                    <?php }else{echo '--';}?>
                    &nbsp;&nbsp;
                    <?php if(checkAccess('program_type_del')){?>
                        <a	href="<?=$this->baseurl?>&m=delete&catid=<?=$catid?>&id=<?=$r['id']?>"
                              onclick="return confirm('确定要删除吗？');">删除</a>
                    <?php }else{echo '--';}?>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>

    <div class="pagin">
        <div class="message">共<i class="blue"><?=$count?></i>条记录</div>
        <ul class="paginList">
            <li><?=$pages?></li>
        </ul>
    </div>
    </form>


    <div class="tip">
        <div class="tiptop"><span>提示信息</span><a></a></div>

        <div class="tipinfo">
            <span><img src="static/ql/images/ticon.png" /></span>
            <div class="tipright">
                <p>是否删除所选信息 ？</p>
                <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
            </div>
        </div>

        <div class="tipbtn">
            <input name="" type="button"  class="sure" value="确定" />&nbsp;
            <input name="" type="button"  class="cancel" value="取消" />
        </div>

    </div>




</div>

<script type="text/javascript">
    $('.tablelist tbody tr:odd').addClass('odd');
</script>

</body>

</html>
