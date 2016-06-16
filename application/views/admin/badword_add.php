<?php $this->load->view('admin/header');?>

<script>
$(document).ready(function(){

	$("#city").click(function(){
	    showCitys("city");
	});	
	 
});
KindEditor.ready(function(K) {
	K.create('#content',{urlType :'relative'});
});
</script>
<div class="mainbox nomargin">
	<form action="<?=$this->baseurl?>&m=save" method="post">
		<input type="hidden" name="id" value="<?=$id?>"> 
		<table class="opt">
			
			<tr>
				<th width="90">不良词语 *</th>
				<td><input type="text" class="txt" name="value[find]"
					value="<?=$value[find]?>" /></td>
			</tr>			
			<tr>
				<th>替换字符</th>
				<td><input type="text" class="txt" name="value[replacement]"
					value="<?=$value[replacement]?>" /></td>
			</tr>
			
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