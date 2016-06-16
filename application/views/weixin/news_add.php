<?php $this->load->view('admin/header');?>
<script>
KindEditor.ready(function(K) {
	K.create('#content',{urlType :'domain'});
});
function chkFF(){
	<?php if($edittype!='rulenewsedit'){?>
		if($("#form-keyword").val() == '') {
			alert('关键字不能为空');
			$("#form-keyword").focus();
			return false;
		}
    <?php }?>
    <?php if($edittype!='ruleedit'){?>	
		if($("#form-title").val() == '') {
			alert('标题不能为空');
			$("#form-title").focus();
			return false;
		}		
	<?php }?>
	return true;
}
</script>
<div class="mainbox nomargin">
	<form action="<?=$this->baseurl?>&m=<?php echo $ruleid?'rulenewsadd_save':'save';?>" method="post" enctype="multipart/form-data" onsubmit="return chkFF();">
		<input type="hidden" name="id" value="<?=$id?>"> 
        <input type="hidden" name="ruleid" value="<?=$ruleid?>"> 
        <input type="hidden" name="edittype" value="<?=$edittype?>"> 
		<table border="0" cellpadding="0" cellspacing="0" class="opt">
         <?php if($edittype!='rulenewsedit'){?>
			<tr>
			  <th>类型：</th>
			  <td><select name="rvalue[types]"><?=$ops?></select></td>
		  </tr>
			<tr>
				<th width="90">关键字 *</th>
				<td><textarea name="rvalue[keyword]" id="form-keyword" class="txt" style="width:99%; height:50px;"><?=$rvalue[keyword]?></textarea>
                (多个关键词请用##号隔开，如:aa##bb)
                </td>
			</tr>
            <?php }?>
            <?php if($edittype!='ruleedit'){?>
			<tr>
			  <th>标题：</th>
			  <td><input name="cvalue[title]" id="form-title" type="text" class="txt" style="width:99%;" value="<?=$cvalue[Title]?>" /></td>
		  </tr>
		<tr>
				<th>封面：</th>
				<td><input name="cvalue[PicUrl]" class="txt" type="text" id="PicUrl" value="<?=$cvalue[PicUrl]?>" /><input type="button" value="选择.." onclick="upfile('PicUrl')" class="btn" /> <font color="#999999">大图片建议尺寸：700像素 * 300像素</font></td>
			</tr>
			<tr>
			  <th>描述：</th>
			  <td><textarea name="cvalue[Description]" class="txt" style="width:99%; height:80px;"><?=$cvalue[Description]?></textarea></td>
		  </tr>
			
			<tr>
				<th>内容：</th>
				<td><textarea id="content" name="cvalue[content]" style="width: 700px; height: 350px;"><?=$cvalue[content]?></textarea></td>
			</tr>
			<tr>
			  <th>来源：</th>
			  <td><input name="cvalue[Url]" type="text" class="txt" style="width:99%;" value="<?=$cvalue[Url]?>" />
              <br>
              <font color="#666666">设置来源后打开该条图文将跳转到指定链接（注：链接需加http://）</font>
              </td>
		  </tr>
		  <tr>
				<th>排序：</th>
				<td><input name="cvalue[sort]"  type="text" class="txt" style="width:50px;" value="<?=$cvalue[sort]?$cvalue[sort]:'10'?>" /></td>
			</tr>
          <?php }?>
			
			<tr>
				<th>&nbsp;</th>
				<td><input type="submit" name="submit" value=" 提 交 " class="btn"
					tabindex="3" /> &nbsp;&nbsp;&nbsp;<input type="button"
					name="submit" value=" 取消 " class="btn"
					onclick="javascript:history.back();" /> </td>
			</tr>
		</table>
	</form>

</div>

<?php $this->load->view('admin/footer');?>