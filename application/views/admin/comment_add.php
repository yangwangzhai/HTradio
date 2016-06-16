<?php $this->load->view('admin/header');?>

<script>
$(document).ready(function(){

});
</script>
<div class="mainbox nomargin">
	<form action="<?=$this->baseurl?>&m=save" method="post">
		<input type="hidden" name="id" value="<?=$id?>"> 
		<table class="opt">
			
			<tr>
				<th width="90">语音</th>
				<td><input type="text" class="txt" name="value[audio]"
					value="<?=$value[audio]?>" /></td>
			</tr>
			
			<tr>
				<th>内容</th>
				<td><textarea id="content" name="value[content]"
						style="width: 400px; height: 100px;"><?=$value[content]?></textarea></td>
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