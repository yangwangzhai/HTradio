<?php $this->load->view('admin/header');?>

<div class="mainbox">
	<input type="button" value=" + 添加信息 " class="btn"
		onclick="location.href='<?=$this->baseurl?>&m=add&catid=<?=$catid?>'" />

	<form action="<?=$this->baseurl?>&m=delete" method="post">
		<input type="hidden" name="catid" value="<?=$catid?>">
		<table class="datalist fixwidth" width="99%">
			<tr>
				<th nowrap="nowrap" width="50">选择</th>
				<th nowrap="nowrap">标题</th>
				<th nowrap="nowrap">位置说明</th>
				<th nowrap="nowrap">网址</th>
				<th nowrap="nowrap" width="50">排序</th>
				<th nowrap="nowrap" width="160">添加时间</th>
				<th nowrap="nowrap" width="100">操作</th>
			</tr>

    <?php foreach($list as $r) {?>
    <tr>
				<td><input type="checkbox" name="delete[]" value="<?=$r['id']?>"
					class="checkbox" /></td>
				<td><a href="#" target="_blank"><?=$r['title']?></a></td>
				<td><?=$r['position']?></td>
				<td><?=$r['url']?></td>
				<td><?=$r['sort']?></td>
				<td><?=times($r['addtime'],1)?></td>
				<td><a href="<?=$this->baseurl?>&m=edit&id=<?=$r['id']?>">修改</a>&nbsp;&nbsp;<a
					href="<?=$this->baseurl?>&m=delete&catid=<?=$catid?>&id=<?=$r['id']?>"
					onclick="return confirm('确定要删除吗？');">删除</a></td>
			</tr>
    <?php }?>
     <tr>
				<td colspan="12"><input type="checkbox" name="chkall" id="chkall"
					onclick="checkall('delete[]')" class="checkbox" /><label
					for="chkall">全选/反选</label>&nbsp; <input type="submit" value=" 删除 "
					class="btn" onclick="return confirm('确定要删除吗？');" /> &nbsp;</td>
			</tr>
		</table>

		<div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div>

	</form>

</div>


<?php $this->load->view('admin/footer');?>