<?php $this->load->view('admin/header');?>

<h3 class="marginbot">权限管理</h3>
<form action="index.php?d=admin&c=ask&m=delete" method="post">
	<table class="datalist fixwidth">
		<tr>
			<th>栏目</th>
			<th>显示</th>
			<th>添加</th>
			<th>修改</th>
			<th>删除</th>
			<th>&nbsp;</th>
		</tr>
  <?=$tree?>
  <tr>
			<td></td>
			<td><input type="submit" name="submit" value=" 提 交 " class="btn"
				tabindex="3" /></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>

	</table>
</form>

<?php $this->load->view('admin/footer');?>