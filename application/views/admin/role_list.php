<?php $this->load->view('admin/header');?>


<div class="mainbox">

	<form action="index.php?d=admin&c=role&m=delete" method="post">
		<table class="datalist fixwidth">
			<tr>
				<th nowrap="nowrap"><input type="checkbox" name="chkall" id="chkall"
					onclick="checkall('delete[]')" class="checkbox" /><label
					for="chkall">删除</label></th>
				<th nowrap="nowrap">ID</th>
				<th nowrap="nowrap">名称</th>
				<th nowrap="nowrap">描述</th>
				<th nowrap="nowrap">&nbsp;</th>
				<th nowrap="nowrap">控制</th>
			</tr>

		<?php foreach($list as $r) {?>
        <tr>
				<td width="30"><input type="checkbox" name="delete[]"
					value="<?=$r['id']?>" class="checkbox" /></td>
				<td width="30"><?=$r['id']?></td>
				<td width="100"><strong><?=$r['name']?></strong></a></td>
				<td width="100"><?=$category[$r[catid]][name];?></td>
				<td width="100">&nbsp;</td>
				<td><a href="index.php?d=admin&c=role&m=purview">权限管理</a> &nbsp;修改</td>
			</tr>
		<?php }?>
           <tr class="nobg">
				<td colspan="8"><input type="submit" value="提 交" class="btn"
					onclick="return confirm('确定要删除吗？');" /></td>
			</tr>

		</table>

		<div class="margintop"></div>

	</form>

</div>


<?php $this->load->view('admin/footer');?>