<?php $this->load->view('admin/header');?>
<script>
/*
KindEditor.ready(function(K) {
	K.create('#content',{urlType :'domain'});
});
*/
</script>
<div class="mainbox nomargin">
	<form action="<?=$this->baseurl?>&m=save" method="post">
		<input type="hidden" name="id" value="<?=$id?>"> 
		<table class="opt">
			<tr>
				<th width="90">关键字 *</th>
				<td><textarea name="value[keyword]" class="txt" style="width:99%; height:50px;"><?=$value[keyword]?></textarea>
                (多个关键词请用##号隔开，如:aa##bb)
                </td>
			</tr>
			
			<tr>
				<th>回复内容</th>
				<td><textarea  name="value[recontent]" style="width: 700px; height: 400px;"><?=$value[recontent]?></textarea></td>
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