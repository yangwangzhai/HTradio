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
		<form action="<?=$this->baseurl?>&m=save" method="post">
			<input type="hidden" name="id" value="<?=$id?>">
			<div id="tab1" class="tabson">
				<ul class="forminfo">
					<li><label>分组<b>*</b></label>
						<div class="vocation">
							<select class="select1" name="value[catid]" id="gender"><?=getSelect($group, $value['catid'])?></select>
						</div>
					</li>
					<li><label>用户名<b>*</b></label><input name="value[username]" value="<?=$value[username]?>" type="text" class="dfinput" style="width:518px;"<?php if($id==$_SESSION[id]){?> readonly="readonly" /><?php }?></li>
					<li><label>密码<b>*</b></label><input name="value[password]" value="<?=$value[password]?>" type="password" class="dfinput" style="width:518px;"/>不修改请留空</li>
					<li><label>姓名<b>*</b></label><input name="value[truename]" value="<?=$value[truename]?>" type="text" class="dfinput" style="width:518px;"/></li>
					<li><label>手机<b>*</b></label><input name="value[telephone]" value="<?=$value[telephone]?>" type="text" class="dfinput" style="width:518px;"/></li>
					<li><label>邮箱<b>*</b></label><input name="value[email]" value="<?=$value[email]?>" type="text" class="dfinput" style="width:518px;"/></li>
					<li><label>备注<b>*</b></label><input name="value[remarks]" value="<?=$value[remarks]?>" type="text" class="dfinput" style="width:518px;"/></li>
					<li><label>&nbsp;</label><input name="" type="submit" class="btn" value="马上提交"/></li>
				</ul>
			</div>
		</form>
	</div>

</div>


</body>

</html>
