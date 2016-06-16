<?php $this->load->view('admin/header');?>

<div class="mainbox">
	<form action="<?=$this->baseurl?>&m=save" method="post">
		<input type="hidden" name="id" value="<?=$id?>"> <input type="hidden"
			name="value[catid]" value="<?=$value[catid]?>">
		<table border="0" cellpadding="0" cellspacing="0" class="opt">

			<tr>
				<th width="119">标题 *</th>
				<td><input type="text" class="txt" name="value[title]"
					value="<?=$value['title']?>" /></td>
			</tr>
			<tr>
				<th>位置说明</th>
				<td><input type="text" class="txt" name="value[position]"
					value="<?=$value['position']?>" /></td>
			</tr>
			<tr>
				<th>链接网址</th>
				<td><input type="text" class="txt" name="value[url]"
					value="<?=$value['url']?>" /></td>
			</tr>
			<tr>
				<th>图片</th>
				<td><input type="text" class="txt" id="thumb" name="value[img]"
					value="<?=$value['img']?>" /> <input type="button"
					id="uploadButton" value="选择.." class="btn"
					onclick="upfile('thumb')" /> &nbsp;</td>
			</tr>
			<tr>
				<th>排序</th>
				<td><input name="value[sort]" type="text" class="txt" id="sort"
					value="<?=$value[sort]?$value[sort]:0;?>" style="width: 50px;" />
					&nbsp;数字大排前面</td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<td><input type="submit" name="submit" value=" 提 交 " class="btn"
					tabindex="3" /> &nbsp;&nbsp;&nbsp;<input type="button"
					name="submit" value=" 取消 " class="btn"
					onclick="javascript:history.back();" /></td>
			</tr>
		</table>

	</form>
</div>

<?php $this->load->view('admin/footer');?>
