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
			strfind = $("#find").val();
			strreplac = $("#replacement").val();
			if(strfind == '' || strreplac == ''){
				alert('请输入信息完整！');
				return false;
			}
		}
		function setvalue(id,strfind,strreplac){
			$("#find").val(strfind);
			$("#replacement").val(strreplac);
			$("#id").val(id);
			$("#save").val(' 保存 ');
			$("#cancel").show();
		}
		function setcancel(){
			$("#find").val('');
			$("#replacement").val('');
			$("#id").val('');
			$("#cancel").hide();
			$("#save").val(' + 添加 ');
		}

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
		<div id="tab2" class="tabson">
			<ul class="seachform">
				<form action="<?=$this->baseurl?>&m=save" method="post">
					<input type="hidden" name="id" value="" id="id">
					<li>
						<label>不良词语：</label>
						<input type="text" name="value[find]" id="find" class="scinput" />
						替换字符：<input type="text" name="value[replacement]" id="replacement" class="scinput">
					</li>
					<li>
						<label>&nbsp;</label>
						<?php if(checkAccess('badword_add')){?>
							<input value="添加 " class="scbtn" id="save" type="submit" onclick="return checknull()" />
						<?php }?>
						<input value=" 取消 " class="btn" style="display:none" id="cancel" type="button" onclick="setcancel()" />
					</li>
				</form>
				<li style="float: right;">
					<form action="<?=$this->baseurl?>&m=index" method="post">
						<input type="hidden" name="catid" value="<?=$catid?>">
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
						<th>不良词语</th>
						<th>替换字符</th>
						<th>添加时间</th>
						<th>操作</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach($list as $key=>$r) {?>
						<tr>
							<td><input type="checkbox" name="delete[]" value="<?=$r['id']?>" class="checkbox" /></td>
							<td><?=$key+1?></td>
							<td><?=$r['find']?></td>
							<td><?=$r['replacement']?></td>
							<td><?=times($r['addtime'],1)?></td>
							<td>
								<?php if(checkAccess('badword_edit')){?>
									<a href="<?=$this->baseurl?>&m=edit&id=<?=$r['id']?>">修改</a>
								<?php }else{ echo "--";}?>
								&nbsp;&nbsp;
								<?php if(checkAccess('badword_del')){?>
									<a href="<?=$this->baseurl?>&m=delete&catid=<?=$catid?>&id=<?=$r['id']?>" onclick="return confirm('确定要删除吗？');">删除</a>
								<?php }else{ echo "--";}?>
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
