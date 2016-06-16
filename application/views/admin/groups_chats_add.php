<?php $this->load->view('admin/header');?>

<script>
$(document).ready(function(){
	 
});
</script>
<div class="mainbox nomargin">
	<form action="<?=$this->baseurl?>&m=save" method="post">
		<input type="hidden" name="id" value="<?=$id?>">
        <input type="hidden" name="value[isbase64]" value="<?=$value[isbase64]?>">
		<table width="99%" border="0" cellpadding="3" cellspacing="0" class="opt">
			<tr>
				<th width="90">群名称</th>
				<td><select name="value[groupid]">
		  				<?=getSelect($this->groups,$value['groupid'])?>
	  				</select></td>
			</tr>		
		<tr>
				<th width="90">发布人ID</th>
				<td><input type="text" class="txt" name="value[uid]"
					value="<?=$value[uid]?>" /></td>
			</tr>			
			<tr>
				<th>图片</th>
				<td><input name="value[thumb]" class="txt" type="text" id="thumb"
					value="<?=$value[thumb]?>" /><input type="button" value="选择.."
					onclick="upfile('thumb')" class="btn" />&nbsp;&nbsp;<input type="button" value="预览"
					onclick="showImg('thumb',170,170)" class="btn" /></td>
			</tr>
			<tr>
				<th width="80">文字内容</th>
				<td ><textarea id="title" name="value[title]"
						style="width: 310px; height:100px;"><?=$value[title]?></textarea>
					最多400个字</td>				
			</tr>			
			
			<tr>
				<th>&nbsp;</th>
				<td colspan="2"><input type="submit" name="submit" value=" 提 交 " class="btn"
					tabindex="3" /> &nbsp;&nbsp;&nbsp;<input type="button"
					name="submit" value=" 返回 " class="btn"
					onclick="javascript:history.back();" /></td>
			</tr>
		</table>
	</form>

</div>

<?php $this->load->view('admin/footer');?>