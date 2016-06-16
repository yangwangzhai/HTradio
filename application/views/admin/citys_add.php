<?php $this->load->view('admin/header');?>

<div class="mainbox nomargin">

	<form action="index.php?d=admin&c=citys&m=save" method="post">
		<input type="hidden" name="id" value="<?=$id?>">
		<table class="opt">
			<tr>
				<th width="90">上级分类</th>
				<td><select name="form[parentid]">
						<option value="0">作为一级分类</option>
                    <?=$tree?>
                </select></td>
			</tr>
			<tr>
				<th>名称</th>
				<td><input type="text" class="txt" name="form[name]"
					value="<?=$name?>" /></td>
			</tr>
			<tr>
				<th>url</th>
				<td><input type="text" class="txt" name="form[url]"
					value="<?=$url?>" /></td>
			</tr>
			<tr>
				<th>简介</th>
				<td><textarea name="form[description]" rows="3" class="txt"><?=$description?></textarea></td>
			</tr>
			<tr>
				<th>排序</th>
				<td><input name="form[sort]" type="text" class="txt"
					style="width: 50px" value="<?=$sort?>" /> &nbsp; 数字大靠前</td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<td><input type="submit" name="submit" value=" 提 交 " class="btn"
					tabindex="3" /></td>
			</tr>
		</table>

	</form>

</div>


<?php $this->load->view('admin/footer');?>