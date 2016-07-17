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
    <script charset="utf-8" src="static/js/kindeditor410/kindeditor.js?2"></script>
    <script charset="utf-8" src="static/js/kindeditor410/lang/zh_CN.js"></script>
    <script type="text/javascript" src="static/js/common.js?1"></script>
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="plugin/bootstrap/js/bootstrap.min.js"></script>
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

        function checknull(){
            strfind = $("#collect_num").val();

            if(strfind == ''){
                alert('请输入角色名称！');
                return false;
            }
        }
        function setvalue(id,strfind){
            $("#role_name").val(strfind);
            $("#id").val(id);
            $("#save").val(' 保存 ');
            $("#save").show();
            $("#cancel").show();
        }
        function setcancel(){
            //	$("#role_name").val('');
            //	$("#id").val('');
            //	$("#cancel").hide();
            //	$("#save").val(' + 添加 ');

            window.location.href='<?=$this->baseurl?>&m=index';
        }

    </script>
</head>

<body>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">媒资管理</a></li>
        <li><a href="#">媒资采集</a></li>
    </ul>
</div>

<div class="formbody">
    <div id="usual1" class="usual">
        <div id="tab2" class="tabson">
            <ul class="seachform">
                <form action="<?=$this->baseurl?>&m=collect_program" method="post">
                    <li>
                        <label>采集频道：</label>
                        <div class="vocation">
                            <select name="channel_id" class="select1">
                                <option value="4">新闻910</option>
                                <option value="6">私家车930</option>
                                <option value="12">950Musicradio</option>
                                <option value="8">970女主播</option>
                                <option value="2">交通1003</option>
                                <option value="11">北部湾之声</option>
                                <option value="13">风尚调频</option>
                                <option value="35">旅游频率</option>
                            </select>
                        </div>
                    </li>
                    <li>
                        <label>采集数量：</label>
                        <input type="text" name="collect_num" id="collect_num" class="scinput" />
                    </li>
                    <li>
                        <label>&nbsp;</label>
                        <input type="submit" id="save" class="scbtn" value="采集" onclick="return checknull()"/>
                        <input value=" 取消 " class="btn" style="display:none" id="cancel" type="button"
                               onclick="setcancel()" />
                    </li>
                </form>
                <li style="float: right;">
                    <form action="<?=$this->baseurl?>&m=collect_program_view" method="post">
                        <input class="dfinput" type="text" name="keywords" value="" style="width: 150px;">
                        <input class="btn btn-primary" type="submit" id="mysearch" name="submit" value=" 搜索" style="width: 50px;">
                    </form>
                </li>
            </ul>
            <form action="<?=$this->baseurl?>&m=delete" method="post">
                <input type="hidden" name="catid" value="<?=$catid?>">
                <table class="tablelist">
                    <thead>
                    <tr>
                        <th><input type="checkbox" name="chkall" id="chkall" onclick="checkall('delete[]')" class="checkbox" /></th>
                        <th>编号<i class="sort"><img src="static/ql/images/px.gif" /></i></th>
                        <th>采集者</th>
                        <th>采集频道</th>
                        <th>采集数量</th>
                        <th>采集时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($list as $key=>$r) {?>
                        <tr>
                            <td><input type="checkbox" name="delete[]" value="<?=$r['id']?>" class="checkbox" /></td>
                            <td><?=$key+1?></td>
                            <td><?=getNickName_admin($r['uid'])?></td>
                            <td><?=getLiveChannelName($r['collect_channel_id'])?></td>
                            <td><?=$r['collect_num']?></td>
                            <td><?=date("Y-m-d H:i:s",$r['addtime'])?></td>
                            <td>
                                <?php if(checkAccess('role_edit')){?>
                                    <a href="javascript:void(0)" onclick="setvalue('<?=$r['id']?>','<?=$r['role_name']?>')">修改</a>
                                <?php }else{echo '--';}?>
                                &nbsp;&nbsp;
                                <?php if(checkAccess('role_del')){?>
                                    <a href="<?=$this->baseurl?>&m=delete&catid=<?=$catid?>&id=<?=$r['id']?>" onclick="return confirm('确定要删除吗？');">删除</a>
                                <?php }else{echo '--';}?>
                            </td>
                        </tr>
                    <?php }?>
                    <tr>
                        <td colspan="11"><input type="checkbox" name="chkall" id="chkall" onclick="checkall('delete[]')" class="checkbox" />
                            <label for="chkall">全选/反选</label>&nbsp;
                            <?php if(checkAccess('role_del')){?>
                                <input type="submit" value=" 删除 " onclick="return confirm('确定要删除吗？');" />
                            <?php }?>&nbsp;
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
            <div class="pagin">
                <div class="message">共<i class="blue"><?=$count?></i>条记录</div>
                <ul class="paginList">
                    <li><?=$pages?></li>
                </ul>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        $("#usual1 ul").idTabs();
    </script>

    <script type="text/javascript">
        $('.tablelist tbody tr:odd').addClass('odd');
    </script>





</div>


</body>

</html>
