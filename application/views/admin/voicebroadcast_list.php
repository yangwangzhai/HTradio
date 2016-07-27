<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>语音播报列表</title>
    <link href="static/ql/css/style.css" rel="stylesheet" type="text/css" />

    <script charset="utf-8" src="static/js/kindeditor410/kindeditor.js?2"></script>
    <script charset="utf-8" src="static/js/kindeditor410/lang/zh_CN.js"></script>
    <script type="text/javascript" src="static/js/common.js?1"></script>
    <script type="text/javascript" src="static/js/jquery-3.1.0.min.js"></script>
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="static/plugin/bootstrap/js/bootstrap.min.js"></script>
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
            });

            $(".cancel").click(function(){
                $(".tip").fadeOut(100);
            });

            $(".add_click").click(function(){
                location.href="<?=$this->baseurl?>&m=add&catid=<?=$catid?>'";
            });

            // 点击更改状态
            $(".updatestatus").click(function(){
                var tid = $(this).attr("name");
                var mystatus = 0;
                if($(this).text() == "已审")
                {	 mystatus = 1;
                    $(this).text("未审");
                    $(this).addClass("red");
                    $(this).css("color","red");
                    $(this).next().attr("data-toggle","");
                } else {
                    $(this).text("已审");
                    $(this).removeClass("red");
                    $(this).css("color","");
                    $(this).next().attr("data-toggle","modal");
                }

                $.get("<?=$this->baseurl?>&m=updatestatus", { id: tid, status: mystatus , field: 'status' },function(data){

                });
            });

            $(".info").click(function(){
                var id = $(this).data("id");
                var title = $(this).data("title");
                $.dialog({
                    id: 'list',
                    title: '查看---'+title,
                    content: 'url:<?=$this->baseurl?>&m=getProgramInfo&id='+id,
                    min: false,
                    max: false,
                    padding:0,
                    margin:0,
                    width:600,
                    height:250,
                    ok:true,
                });
                $('.ui_title').css('text-align','left');
            });

            $('#type_id').val('<?=$type_id?>');

            $(".a").on("click",function(){
                var data_toggle = $(this).attr("data-toggle");
                if(data_toggle!='modal'){
                    alert("请先审核，再推送");
                }
            })


        });

        function gettype(){
            $('#mysearch').trigger('click');
        }

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
                location.reload();
            });

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

		<span style="float: right">
		<form action="<?=$this->baseurl?>&m=index" method="post">
            <input type="hidden" name="catid" value="<?=$catid?>">
            分类
            <select class="select1" id="type_id" name="type_id" onchange="gettype()" style="border: inset;height: 30px;">
                <?=getSelect($program_type,'','全部')?>
            </select>
            <input class="dfinput" type="text" name="keywords" value="" style="width: 150px;">
            <input class="btn btn-primary" type="submit" id="mysearch" name="submit" value=" 搜索" style="width: 50px;">
        </form>
	</span>

        <form action="<?=$this->baseurl?>&m=delete" method="post" name="program_list">
            <input type="hidden" name="catid" value="<?=$catid?>">
            <ul class="toolbar">
                <li style="padding-right: 0px;" class="add_click">
                    <input class="btn btn-primary" style="width: 100%;height: 35px;" type="button" value="添加"/>
                </li>
                <li style="padding-right: 0px;">
                    <input class="btn btn-danger" style="width: 100%;height: 35px;" type="submit" value="删除 " name="del" onclick="return confirm('确定要删除吗？');" />
                </li>
                <li style="padding-right: 0px;">
                    <input class="btn btn-success" style="width: 100%;height: 35px;" type="submit" value=" 推荐 " name="tj" onclick="return confirm('确定要推荐吗？');" />
                </li>
                <li style="padding-right: 0px;">
                    <input class="btn btn-warning" style="width: 100%;height: 35px;" type="submit" value=" 取消推荐 " name="qxtj" onclick="return confirm('确定要取消推荐吗？');" />
                </li>
                <li style="padding-right: 0px;">
                    <input class="btn btn-info" style="width: 100%;height: 35px;" type="submit" value=" 置顶 " name="zd" onclick="return confirm('确定要置顶吗？');" />
                </li>
                <li style="padding-right: 0px;">
                    <input class="btn btn-warning" style="width: 100%;height: 35px;" type="submit" value=" 取消置顶 " name="qxzd"  onclick="return confirm('确定要取消置顶吗？');" />
                </li>
            </ul>
    </div>


    <table class="tablelist">
        <thead>
        <tr>
            <th><input type="checkbox" name="chkall" id="chkall" onclick="checkall('delete[]')" class="checkbox" /></th>
            <th></th>
            <!--<th width="50">封面</th>-->
            <th>标题</th>
            <th>内容</th>
            <th>采集时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($list as $key=>$r) {?>
            <tr>
                <td><input type="checkbox" name="delete[]" value="<?=$r['id']?>"
                           class="checkbox" /></td>
                <td><?=$key+1?></td>
                <!--<td style="text-indent: 0;"><a onclick="vPics('<?/*=$r['title']*/?>','<?/*=$r['thumb']*/?>');" href="javascript:;"><img width="100%" src="<?/*=$r['thumb']*/?>"/></a></td>-->
                <td style="overflow:hidden;white-space:nowrap;text-overflow:ellipsis;"><?=$r['title']?></a></td>
                <td style="overflow:hidden;white-space:nowrap;text-overflow:ellipsis;"><?=$r['content']?></td>
                <td><?=times($r['addtime'],1)?></td>
                <td>
                    <?php if(checkAccess('program_check')){?>
                        <a href="javascript:" title="点击更改状态" class="updatestatus <?php if($r[status]==0){echo 'red';} ?>" style="<?php if($r[status]==0){echo 'color:red';} ?>" name="<?=$r['id']?>"><?=$this->status[$r[status]]?></a>
                    <?php }else{echo '--';}?>
                    &nbsp;&nbsp;
                    <a onclick="return false" class="a" data-status="<?=$r['status'];?>" data-target="#push<?=$key?>" data-toggle="<?php echo $r['status'] ? 'modal' : ''; ?>" style="cursor: pointer;">推送</a>
                    &nbsp;&nbsp;
                    <?php if(checkAccess('program_edit')){?>
                        <a href="<?=$this->baseurl?>&m=edit&id=<?=$r['id']?>">修改</a>
                    <?php }else{echo '--';}?>
                    &nbsp;&nbsp;
                    <?php if(checkAccess('program_del')){?>
                        <a
                            href="<?=$this->baseurl?>&m=delete&catid=<?=$catid?>&id=<?=$r['id']?>"
                            onclick="return confirm('确定要删除吗？');">删除</a>
                    <?php }else{echo '--';}?>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>

    <div class="pagin" style="padding: 0 0 30px;margin-bottom: 15px">
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
                <p>是否确认对信息的修改 ？</p>
                <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
            </div>
        </div>
        <div class="tipbtn">
            <input name="" type="button"  class="sure" value="确定" />&nbsp;
            <input name="" type="button"  class="cancel" value="取消" />
        </div>
    </div>


</div>
</div>

<script type="text/javascript">
    $('.tablelist tbody tr:odd').addClass('odd');
</script>

<?php foreach($list as $key=>$r) {?>
    <!-- 模态框（Modal） -->
    <form action="index.php?d=admin&c=program&m=save_push" method="post">
        <input type="hidden" name="program_id" value="<?=$r[id]?>"/>
        <div class="modal fade" id="push<?=$key?>" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close"
                                data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            选择推送频道
                        </h4>
                    </div>
                    <div class="modal-body">
                        <?php foreach($public_channel_list as $value) :?>
                            <input type="checkbox" name="value[<?=$value[id]?>]" value="1" <?php echo empty($r['channel_id']) ? '' : in_array($value['id'],$r['channel_id']) ? "checked=checked" : '';?>/><?=$value['title']?> &nbsp;&nbsp;&nbsp;&nbsp;
                        <?php endforeach?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">关闭
                        </button>
                        <button type="submit" class="btn btn-primary">
                            提交更改
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
    </form>
<?php }?>

<div id="player_box" style="display:none;position: fixed;bottom: 0px;height: 50px;width: 100%;background: #272727;">
    <div style="margin-left: auto;margin-right: auto;width: 50%;clear: both;">
        <p id="player_title" style="color:#d1d1d1;font-size: 12px;text-decoration: none;margin-bottom: 0;">私家车上班路上2016-07-21</p>
        <a style="display: block; width: 100%; height: 30px;" id="flashls_vod"></a>
    </div>
</div>


</body>

<script type="text/javascript">
    $(".playmenu").click(function(){
        $("#player_box").show();
        var id="flashls_vod";
        var title=$(this).attr("data-title");
        var url=$(this).attr("data-url");
        var flag=$(this).attr("data-flag");
        if(flag==0){
            fplayer(id,url)
            //当前播放的节目，高亮
            /*$(".playmenu").css("color","#0097BD");
             $(this).css("color","red");*/
            $("#player_title").text(title);
            $(".playmenu").attr("src","static/images/play_h.png");
            $(this).attr("src","static/images/pause.png");
            $(this).attr("data-flag","1");
        }else{
            $("#player_title").text(title);
            flowplayer(id, "static/flowplayer/flowplayer.swf", {
                // configure the required plugins
                plugins: {
                    flashls: {
                        url: 'static/flowplayer/flashlsFlowPlayer.swf'
                    },
                    controls:{
                        autoHide: false, //功能条是否自动隐藏
                        tooltips: {
                            buttons: true,//是否显示
                            fullscreen: '全屏',//全屏按钮，鼠标指上时显示的文本
                            stop:'停止',
                            play:'开始',
                            volume:'音量',
                            mute: '静音',
                            next:'下一个',
                            previous:'上一个'
                        }
                    }
                },
                clip: {
                    url: url,
                    live: true,
                    autoPlay: false,
                    urlResolvers: "flashls",
                    provider: "flashls"
                }
            }).stop();
            $(this).attr("data-flag","0");
            $(this).attr("src","static/images/play_h.png");
        }
    });

    function fplayer(id,url){
        flowplayer(id, "static/flowplayer/flowplayer.swf", {
            // configure the required plugins
            plugins: {
                flashls: {
                    url: 'static/flowplayer/flashlsFlowPlayer.swf'
                },
                controls:{
                    autoHide: false, //功能条是否自动隐藏
                    tooltips: {
                        buttons: true,//是否显示
                        fullscreen: '全屏',//全屏按钮，鼠标指上时显示的文本
                        stop:'停止',
                        play:'开始',
                        volume:'音量',
                        mute: '静音',
                        next:'下一个',
                        previous:'上一个'
                    }
                }
            },
            clip: {
                url: url,
                live: true,
                urlResolvers: "flashls",
                provider: "flashls"
            }
        }).ipad();
    }
</script>

</html>
