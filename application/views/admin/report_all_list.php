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

		});

		function getstate(){
			$('#submit').trigger("click");
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
			<li class="click"><span><img src="static/ql/images/t03.png" /></span>删除</li>
		</ul>
		<span style="float: right">
		<form action="<?=$this->baseurl?>&m=index" method="post" id="my_form2">
			状态：
			<select class="select1" onchange="getstate()" style="width:auto;height: 30px;border: inset;"  name="status">
				<option <?php if($status ==0) echo "selected"; ?> value="0">举报中</option>
				<option <?php if($status ==1) echo "selected"; ?> value="1">正常</option>
			</select>
			&nbsp;&nbsp;举报原因：
			<input type="hidden" name="catid" value="<?=$catid?>">
			<input class="dfinput" type="text" name="keywords" value="" style="width: 150px;">
			<input class="btn btn-primary" type="submit" name="submit" id="submit" value=" 搜索 " style="width: 50px;">
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
			<th>被举报节目</th>
			<th>举报原因</th>
			<th>被举报人</th>
			<th>举报人</th>
			<th>举报类型</th>
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
				<td><?=getProgramName($r['program_id'])?></td>
				<td><?=$r['content']?></td>
				<td><?=$r['publisher']?></td>
				<td><?=getNickName($r['mid'])?></td>
				<td><?=$r['type']?></td>
				<td><?=times($r['addtime'],1)?></td>
				<td>
					<?php if(checkAccess('report_all_edit')){?>
						<a href="javascript:void(0)" title="点击更改状态" class="updatestatus" data-id="<?=$r['status']?>" name="<?=$r['id']?>">
							<?php if($r['status'] == 0){ echo '设为正常';}else{echo '设为举报中';} ?>
						</a>
					<?php }else{echo '--';}?>
					&nbsp;&nbsp;
					<?php if(checkAccess('report_all_del')){?>
						<a href="<?=$this->baseurl?>&m=delete&catid=<?=$catid?>&id=<?=$r['id']?>"
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
