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
		KE.show({
			id : 'content8',
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
					<li><label>标题<b>*</b></label><input name="value[title]" value="<?=$value[title]?>" type="text" class="dfinput" style="width:518px;"/></li>
					<li><label>关键词<b>*</b></label><input name="value[keywords]" value="<?=$value[keywords]?>" type="text" class="dfinput" style="width:518px;"/></li>
					<li>
						<label>描述<b>*</b></label>
						<textarea id="content7" name="value[description]" style="width:700px;height:150px;visibility:hidden;"><?=$web[description];?></textarea>
					</li>
					<li style="height: 154px;">
						<label>系统简介<b>*</b></label>
						<textarea id="content8" name="value[aboutus]" style="width:700px;height:150px;visibility:hidden;"><?=$web[aboutus];?></textarea>
					</li>
					<li><label>错误登陆次数<b>*</b></label><input name="value[error_times]" value="<?=$value[error_times]?>" type="text" class="dfinput" style="width:518px;"/></li>
					<li><label>错误登陆间隔<b>*</b></label><input name="value[error_time_gaps]" value="<?=$value[error_time_gaps]?>" type="text" class="dfinput" style="width:518px;"/></li>
					<li><label>&nbsp;</label><input name="" type="submit" class="btn" value="马上提交"/></li>
				</ul>
			</div>
		</form>
	</div>

</div>


</body>

</html>
