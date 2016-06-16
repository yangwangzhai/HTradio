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

			$(".back_click").click(function(){
				location.href="<?=$this->baseurl?>&m=import_index";
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

			$('#groupname').val('<?=$groupname?>');

		});

		function getgroup(){
			$('#mysearch').trigger('click');
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
			<li class="back_click"><span><img src="static/ql/images/back.png" /></span>返回</li>
			<li class="click"><span><img src="static/ql/images/t03.png" /></span>删除</li>
		</ul>
	</div>

	<form action="<?=$this->baseurl?>&m=delete" method="post" id="my_form">
		<input type="hidden" name="catid" value="<?=$catid?>">
		<table class="tablelist">
			<thead>
			<tr>
				<th><input type="checkbox" name="chkall" id="chkall" onclick="checkall('delete[]')" class="checkbox" /></th>
				<th>文件名称</th>
				<th>操作</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach($list as $key=>$r) {?>
				<tr>
					<td><input type="checkbox" name="dir[]" value="<?=$r['filename']?>" class="checkbox" /></td>
					<td><?=$r['name']?></td>
					<td>
						&nbsp;&nbsp;
						<?php if(checkAccess('database_res')){?>
							<a href="<?=$this->baseurl?>&m=restore&sqlfile=<?=$r['filename']?>">导入</a>
						<?php }else{echo '--';}?>
						<?php if(checkAccess('database_del')){?>
							&nbsp;&nbsp;<a href="<?=$this->baseurl?>&m=delete&dir=<?=$r['filename']?>" onclick="return confirm('确定要删除吗？');">删除</a>
						<?php }else{echo '--';}?>
					</td>
				</tr>
			<?php }?>
			</tbody>
		</table>

		<!--<div class="pagin">
			<div class="message">共<i class="blue"><?/*=$count*/?></i>条记录</div>
			<ul class="paginList">
				<li><?/*=$pages*/?></li>
			</ul>
		</div>-->
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
