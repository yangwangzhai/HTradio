<?php $this->load->view('admin/header');?>

<script>
KindEditor.ready(function(K) {
	K.create('#content',{urlType :'relative'});
});
</script>
<div class="mainbox nomargin">
	<form action="<?=$this->baseurl?>&m=add_sub" method="post">
		<input type="hidden" name="id" value="<?=$id?>"> 
        <input type="hidden" name="value[pid]" value="<?=$id?>"> 
		<table class="opt">
        	
			<tr>
				<th >类型名称</th>
				<td><input  type="text" class="txt" disabled="true"
					value="<?=$value[title]?>" /></td>
			</tr>
            <tr>
				<th >子类型名称</th>
				<td><input name="value[title]" type="text" class="txt"
					value="" /></td>
			</tr>
            <tr>
				<th>排序</th>
				<td><input name="value[sort]" class="txt" type="text" value="<?=$value[sort]?>" /></td>
			</tr>
            <tr>
				<th>缩略图</th>
				<td><input name="value[thumb]" class="txt" type="text" id="thumb" 
					value="<?=$value[thumb]?>" />
				<input type="button" value="选择.."
					onclick="upfile('thumb')" class="btn" />&nbsp;&nbsp;<input type="button" value="预览"
					onclick="showImg('thumb',350,200)" class="btn" /></td>
			</tr>
             <tr>
				<th>类型介绍</th>
				<td>
                <textarea name="value[content]" id='address' cols="" rows="" class="text" placeholder=""><?=$value[content]?></textarea>
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