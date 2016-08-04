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
                location.href="<?=$this->baseurl?>&m=add&catid=<?=$catid?>&public_flag=<?=$public_flag?>";
            });

            // 点击更改状态
            $(".updatestatus").click(function(){
                var tid = $(this).attr("name");
                var mystatus = 0;
                if($(this).text() == "已审")
                {
                    $(this).text("未审");
                    $(this).addClass("red");
                } else {
                    mystatus = 1;
                    $(this).text("已审");
                    $(this).removeClass("red");
                }

                $.get("<?=$this->baseurl?>&m=updatestatus", { id: tid, status: mystatus },function(data){

                });
            });

            $(".tuijian").click(function(){
                var tid = $(this).attr("name");
                var mystatus = 0;
                if($(this).text() == "推荐")
                {
                    $(this).text("未推荐");
                } else {
                    mystatus = 1;
                    $(this).text("推荐");
                }

                $.get("<?=$this->baseurl?>&m=showInHomePage", { id: tid, show_homepage: mystatus },function(data){
                    window.location.reload();
                });
            });

            $('#type_id').val('<?=$type_id?>');

            function gettype(){
                $('#mysearch').trigger('click');
            }

            $(".push").click(function(){
                $(".push").removeClass("activ_status");
                $(this).addClass("activ_status");
                var val = $(this).text();
                var id = $(this).attr("data-id");
                if(val=='已发布'){
                    var publish_flag = 0;
                    $.ajax({
                        url: "index.php?d=admin&c=programme&m=set_status",   //后台处理程序
                        type: "post",         //数据发送方式
                        dataType:"json",    //接受数据格式
                        data:{publish_flag:publish_flag,id:id},  //要传递的数据
                        success:function(data){
                            //alert(data)
                            $(".activ_status").text('未发布');
                            $(".activ_status").css("color","red");
                        },
                        error:function(XMLHttpRequest, textStatus, errorThrown)
                        {
                            //alert(errorThrown);
                        }
                    });
                }else{
                    var publish_flag = 1;
                    $.ajax({
                        url: "index.php?d=admin&c=programme&m=set_status",   //后台处理程序
                        type: "post",         //数据发送方式
                        dataType:"json",    //接受数据格式
                        data:{publish_flag:publish_flag,id:id},  //要传递的数据
                        success:function(data){
                            //alert(data)
                            $(".activ_status").text('已发布');
                            $(".activ_status").css("color","");
                        },
                        error:function(XMLHttpRequest, textStatus, errorThrown)
                        {
                            //alert(errorThrown);
                        }
                    });
                }
            });

            $(".show_homepage").click(function(){
                $(".show_homepage").removeClass("activ_show_homepage");
                $(this).addClass("activ_show_homepage");
                var val = $(this).text();
                var id = $(this).attr("data-id");
                if(val=='已置顶'){
                    var show_homepage = 0;
                    $.ajax({
                        url: "index.php?d=admin&c=programme&m=show_homepage",   //后台处理程序
                        type: "post",         //数据发送方式
                        dataType:"json",    //接受数据格式
                        data:{show_homepage:show_homepage,id:id},  //要传递的数据
                        success:function(data){
                            //alert(data)
                            $(".activ_show_homepage").text('未置顶');
                            $(".activ_show_homepage").css("color","red");
                        },
                        error:function(XMLHttpRequest, textStatus, errorThrown)
                        {
                            //alert(errorThrown);
                        }
                    });
                }else{
                    var show_homepage = 1;
                    $.ajax({
                        url: "index.php?d=admin&c=programme&m=show_homepage",   //后台处理程序
                        type: "post",         //数据发送方式
                        dataType:"json",    //接受数据格式
                        data:{show_homepage:show_homepage,id:id},  //要传递的数据
                        success:function(data){
                            //alert(data)
                            $(".activ_show_homepage").text('已置顶');
                            $(".activ_show_homepage").css("color","");
                        },
                        error:function(XMLHttpRequest, textStatus, errorThrown)
                        {
                            //alert(errorThrown);
                        }
                    });
                }
            });

            $(".hot").click(function(){
                $(".hot").removeClass("activ_hot");
                $(this).addClass("activ_hot");
                var val = $(this).text();
                var id = $(this).attr("data-id");
                if(val=='已推荐'){
                    var hot = 0;
                    $.ajax({
                        url: "index.php?d=admin&c=programme&m=hot",   //后台处理程序
                        type: "post",         //数据发送方式
                        dataType:"json",    //接受数据格式
                        data:{hot:hot,id:id},  //要传递的数据
                        success:function(data){
                            //alert(data)
                            $(".activ_hot").text('未推荐');
                            $(".activ_hot").css("color","red");
                        },
                        error:function(XMLHttpRequest, textStatus, errorThrown)
                        {
                            //alert(errorThrown);
                        }
                    });
                }else{
                    var hot = 1;
                    $.ajax({
                        url: "index.php?d=admin&c=programme&m=hot",   //后台处理程序
                        type: "post",         //数据发送方式
                        dataType:"json",    //接受数据格式
                        data:{hot:hot,id:id},  //要传递的数据
                        success:function(data){
                            //alert(data)
                            $(".activ_hot").text('已推荐');
                            $(".activ_hot").css("color","");
                        },
                        error:function(XMLHttpRequest, textStatus, errorThrown)
                        {
                            //alert(errorThrown);
                        }
                    });
                }
            })


        });

        function updateStatus( id,status,field ){
            var text_id = '#'+field+'_'+id;
            var text = $.trim($(text_id).html());
            $.get("<?=$this->baseurl?>&m=updateStatus", { id: id, status: status,field: field },function(data){
                if( text== "推荐")
                {
                    $(text_id).html("未推荐");
                } else if(text== "未推荐"){
                    $(text_id).html("推荐");
                }else if(text== "置顶"){
                    $(text_id).html("未置顶");
                }else if(text== "未置顶"){
                    $(text_id).html("置顶");
                }
            });

        }

        function showList(obj,title,w,h)
        {

            var ids = $(obj).attr('data-ids');


            $.dialog({
                id: 'list',
                title: title,
                content: 'url:index.php?d=admin&c=programme&m=getProgramList&ids='+ids,
                min: false,
                max: false,
                padding:0,
                margin:0
            });
            $('.ui_title').css('text-align','left');
        }

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
            <?php /*if($public_flag){*/?>
                <li class="add_click"><span><img src="static/ql/images/t01.png" /></span>添加</li>
            <?php /*}*/?>
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

    <form action="<?=$this->baseurl?>&m=delete" method="post" name="program_list" id="my_form">
    <input type="hidden" name="catid" value="<?=$catid?>">
    <table class="tablelist">
        <thead>
        <tr>
            <th><input type="checkbox" name="chkall" id="chkall" onclick="checkall('delete[]')" class="checkbox" /></th>
            <th></th>
            <th width="60">封面图片</th>
            <th>频道名称</th>
            <th>频道简介</th>
            <th>频道内容</th>
           <!--<th>所属频道</th>-->
            <th>创建人</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($list as $key=>$r) {?>
            <tr>
                <td><input type="checkbox" name="delete[]" value="<?=$r['id']?>"
                           class="checkbox" /></td>
                <td><?=$key+1?></td>
                <td style="text-indent: 0;"><img src="<?php if(!empty($r['thumb'])){echo $r['thumb'];}else{echo base_url()."uploads/default_images/default_programme.jpg";}?>" width="100%"/></td>
                <td><?=$r['title']?></td>
                <td><?=$r['intro']?></td>
                <td><?=$r['content']?></td>
                <!--<td><?/*=getChannelName($r['channel_id'])*/?></td>-->
                <td><?=getNickName_admin($r['uid'])?></td>
                <td><?=times($r['addtime'],1)?></td>
                <td>
                    <a href="javascript:void(0)" class="push" data-id="<?=$r['id']?>" style="text-decoration: none;<?php if($r['publish_flag']==0){echo 'color:red;';}?>"><?php if($r['publish_flag']==0){echo '未发布';}else{echo '已发布';}?></a>
                    &nbsp;&nbsp;
                    <a href="javascript:void(0)" class="show_homepage" data-id="<?=$r['id']?>" style="text-decoration: none;<?php if($r['show_homepage']==0){echo 'color:red;';}?>"><?php if($r['show_homepage']==0){echo '未置顶';}else{echo '已置顶';}?></a>
                    &nbsp;&nbsp;
                    <a href="javascript:void(0)" class="hot" data-id="<?=$r['id']?>" style="text-decoration: none;<?php if($r['hot']==0){echo 'color:red;';}?>"><?php if($r['hot']==0){echo '未推荐';}else{echo '已推荐';}?></a>
                    &nbsp;&nbsp;
                    <?php if(checkAccess('programme_edit')){?>
                        <a href="<?=$this->baseurl?>&m=edit&id=<?=$r['id']?>">修改</a>
                    <?php }else{echo '--';}?>
                    &nbsp;&nbsp;
                    <?php if(checkAccess('programme_del')){?>
                        <a
                            href="<?=$this->baseurl?>&m=delete&catid=<?=$catid?>&id=<?=$r['id']?>"
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
