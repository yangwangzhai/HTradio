<?php $this->load->view('admin/header');?>
<script>
/**/
KindEditor.ready(function(K) {
	K.create('#content',{urlType :'relative',resizeType : 1,
					allowPreviewEmoticons : true,
					allowImageUpload : true,
					items : [
						'undo','redo', '|','fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
						'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
						'insertunorderedlist', '|', 'emoticons', 'image', 'link','unlink']});
});

</script>
<script>
$(document).ready(function(){
	<?php if($_GET['weburl']): ?>
		$("#title").val(parent.title);
		parent.dialog.remove();
	<?php endif; ?>
	
	<?php if($_GET['radio']): ?>
		$("#title").val(parent.title);
		$("#content").val(parent.content);		
	<?php endif; ?>
	
});
</script>
<div class="mainbox nomargin">
	<form action="<?=$this->baseurl?>&m=save" method="post">
		<input type="hidden" name="id" value="<?=$id?>"> 
		<table class="opt">			
			<tr>
				<th>系列台</th>
				<td><select name="value[catid]">
		  				<?=getSelect(config_item('radios'),$value['catid'],'key')?>
	  				</select></td>
			</tr>
			<tr>
				<th width="80" nowrap="nowrap">标题 *</th>
				<td><input type="text" class="txt" name="value[title]"
					value="<?=$value[title]?>" id="title" style="width: 400px;" /></td>
			</tr>			
 		<tr>
				<th nowrap="nowrap">图片 *</th>
				<td><input name="value[thumb]" class="txt" type="text" id="thumb" style="width: 400px;"
					value="<?=$value[thumb]?>" /><input type="button" value="选择.."
					onclick="upfile('thumb')" class="btn" /> &nbsp;&nbsp;<input type="button" value="预览"
					onclick="showImg('thumb',350,200)" class="btn" /> &nbsp;&nbsp;图片尺寸600*300像素</td>
			</tr>
			<tr>
				<th nowrap="nowrap">内容 *</th>
			<!-- 	<td colspan="3"><textarea id="contentss" name="value[content]"
						style="width: 700px; height: 300px;"><?=$value[content]?></textarea></td> -->
			<td colspan="3"><textarea  name="value[content]" id="content"
						style="width: 95%; height: 450px;"><?=$value[content]?></textarea></td>
			</tr>

			<tr>
				<th width="80" nowrap="nowrap">发布时间</th>
				<td><input type="text" class="txt" name="value[addtime]"
					value="<?=times($value[addtime],1)?>" id="title" style="width: 400px;" /></td>
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