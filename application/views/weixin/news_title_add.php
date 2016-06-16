<?php $this->load->view('admin/header');?>

<script>
KindEditor.ready(function(K) {
	K.create('#content',{urlType :'relative'});
});
</script>
<div class="mainbox nomargin" style="margin:10px;">
	<form action="<?=$this->baseurl?>&m=save" method="post">
		<input type="hidden" name="id" value="<?=$value[id]?>">
		<table class="opt">
			<tr>
				<th width="90">标题 </th>
				<td><input type="text" class="txt" name="value[title]" value="<?=$value[title]?>" style="width:800px;"/></td>
			</tr>
			<tr>
				<th width="90">内容 </th>
				<td><textarea id="content" name="value[content]" style="width: 800px; height: 400px;"><?=$value[content]?></textarea></td>
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