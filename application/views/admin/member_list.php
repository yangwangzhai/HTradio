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
				var tid = $(this).attr("name");
				var mystatus = 0;
				if($(this).text() == "已审")
				{
					$(this).text("未审");
					$(this).css("color","red");
				} else {
					mystatus = 1;
					$(this).text("已审");
					$(this).css("color","");
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
			<li class="add_click"><span><img src="static/ql/images/t01.png" /></span>添加</li>
			<li class="click"><span><img src="static/ql/images/t03.png" /></span>删除</li>
		</ul>

		<span style="float: right">
		<form action="<?=$this->baseurl?>&m=index" method="post">
			群名称:
			<select class="select1" id="groupname" name="groupname" onchange="getgroup()" style="border: inset;height: 30px;width: auto;">
				<option value="">全部</option>
				<option value="新闻910">新闻910</option>
				<option value="私家车930">私家车930</option>
				<option value="950MusicRadio">950MusicRadio</option>
				<option value="970女主播">970女主播</option>
				<option value="交通1003">交通1003</option>
				<option value="北部湾之声">北部湾之声</option>
				<option value="北部湾在线">北部湾在线</option>
				<option value="风尚调频">风尚调频</option>
				<option value="广西互联网＋创业博览会">广西互联网＋创业博览会</option>
				<option value="路友粉">路友粉</option>
				<option value="other">普通会员</option>
			</select>
			<input type="hidden" name="catid" value="<?=$catid?>">
			<input class="dfinput" type="text" name="keywords" value="" style="width: 150px;">
			<input class="btn btn-primary" type="submit" name="submit" value=" 搜索 " id="mysearch" style="width: 50px;">
		</form>
	</span>
	</div>

	<form action="<?=$this->baseurl?>&m=delete" method="post" id="my_form">
	<input type="hidden" name="catid" value="<?=$catid?>">
	<table class="tablelist">
		<thead>
		<tr>
			<th><input type="checkbox" name="chkall" id="chkall" onclick="checkall('delete[]')" class="checkbox" /></th>
			<th>uid</th>
			<th>会员组</th>
			<th>头像</th>
			<th>用户名</th>
			<th>昵称</th>
			<th>邮箱</th>
			<th>排序</th>
			<th>节目数</th>
			<th>等级</th>
			<th>登录次数</th>
			<th>查看粉丝</th>
			<th>操作</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($list as $key=>$r) {?>
			<tr>
				<td><input type="checkbox" name="delete[]" value="<?=$r['id']?>"
						   class="checkbox" /></td>
				<td><?=$r['id']?></td>
				<td><?=$category[$r['catid']]?></td>
				<td><?php if($r['avatar']){?>
					<a onclick="vPics('<?=$r['nickname']?>','<?=$r['avatar']?>');" href="javascript:;"><img src="<?php if($r['avatar']){ echo new_thumbname($r['avatar'],100,100);}else{echo "uploads/default_images/default_avatar.jpg";}?>" width="30" height="30"></a><?php }?>
				</td>
				<td><?=$r['username']?></td>
				<td><?=$r['nickname']?></td>
				<td><?=$r['email']?></td>
				<td><?=$r['sort']?></td>
				<td><?=$r['program_num']?></td>
				<td ><?=$r['level']?></td>
				<td align="center"><?=$r['logincount']?></td>
				<th>  <a href="./index.php?d=admin&c=favorite&uid=<?=$r['id']?>">查看粉丝(<font color="#FF0000"><?=$r['favorite_num']?></font>)</a></th>
				<td>
					<?php if(checkAccess('member_check')){?>
						<a href="javascript:" title="点击更改状态" class="updatestatus <?php if($r[status]==0){echo 'red';} ?>" name="<?=$r['id']?>"><?=$this->status[$r[status]]?></a>
					<?php }else{echo '--';}?>
					&nbsp;&nbsp;
					<?php if(checkAccess('member_edit')){?>
						<a href="<?=$this->baseurl?>&m=edit&id=<?=$r['id']?>">修改</a>
					<?php }else{echo '--';}?>
					<?php if(checkAccess('member_del')){?>
						&nbsp;&nbsp;<a href="<?=$this->baseurl?>&m=delete&catid=<?=$catid?>&id=<?=$r['id']?>" onclick="return confirm('确定要删除吗？');">删除</a>
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
