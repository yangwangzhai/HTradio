<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>无标题文档</title>
	<link href="static/ql/css/style.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="static/ql/js/jquery.js"></script>
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
			});

			$(".cancel").click(function(){
				$(".tip").fadeOut(100);
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
		<span style="float: right">
		<form action="<?=$this->baseurl?>&m=index" method="post">
			<input type="hidden" name="catid" value="<?=$catid?>">
			<input class="dfinput" type="text" name="keywords" value="" style="width: 150px;">
			<input class="btn btn-primary" type="submit" id="mysearch" name="submit" value=" 搜索" style="width: 50px;">
		</form>
	</span>
	</div>


	<table class="tablelist">
		<thead>
		<tr>
			<th></th>
			<th>用户名</th>
			<th>城市</th>
			<th>城区</th>
			<th>ip地址</th>
			<th>手机品牌</th>
			<th>手机型号</th>
			<th>手机系统</th>
			<th>客户端版本</th>
			<th width="60">首次安装</th>
			<th>访问时间</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($list as $key=>$r) {?>
			<tr>
				<td><?=$key+1?></td>
				<td><?=getNickName($r['mid'])?></td>
				<td><?=$r['city']?></td>
				<td><?=$r['district']?></td>
				<td><?=$r['ip']?></td>
				<td><?=$r['phone_brand']?></td>
				<td><?=$r['phone_model']?></td>
				<td><?php echo $r['phone_os']==1 ? 'android':'ios';?> <?=$r['os_version']?></td>
				<td><?=$r['version']?></td>
				<th width="50"><?=$r['isfirst'] == 0 ? '否':'是';?></th>
				<td><?=times($r['addtime'],1)?></td>
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

<script type="text/javascript">
	$('.tablelist tbody tr:odd').addClass('odd');
</script>

</body>

</html>
