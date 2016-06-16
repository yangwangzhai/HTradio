<?php $this->load->view('admin/header');?>

<script>
$(document).ready(function(){
		
		$(".mainbox").click( function() {
		 	$("#showimg").attr("src", $("#bottom_pic").val());
		});
});
</script>
<div class="mainbox nomargin">
	<form action="<?=$this->baseurl?>&m=template_save" method="post">		 
		<table width="100%" border="0" cellpadding="5" cellspacing="0" class="opt">			
			<tr>
				<th>新闻标题</th>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<th width="80">新闻内容</th>
				<td>&nbsp;</td>
			</tr>			
			<tr>
				<th>底部图片</th>
				<td><input name="value[bottom_pic]" class="txt" type="text" id="bottom_pic"
					value="<?=$value[bottom_pic]?>" /><input type="button" value="选择.."
					onclick="upfile('bottom_pic')" class="btn" /> 
					底部统一图片<br />
					<img src="<?=$value[bottom_pic]?>" id="showimg">
</td>
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