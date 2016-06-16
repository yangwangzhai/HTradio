<?php $this->load->view('admin/header');?>

<script>
KindEditor.ready(function(K) {
	K.create('#content',{urlType :'relative'});
});
</script>
<div class="mainbox nomargin">
	<form action="<?=$this->baseurl?>&m=save" method="post">
		<input type="hidden" name="id" value="<?=$id?>"> <!--input type="hidden"
			name="value[catid]" value="<?=$value[catid]?>"-->
		<table class="opt">
        <!--th width="90">分组 </th>
				<td><select name="value[catid]" id="gender"><?=getSelect($group, $value['catid'])?></select></td>
			</tr-->		
			<tr>
				<th >网站名称</th>
				<td><input name="value[name]" type="text" class="txt"
					value="<?=$value[name]?>" /></td>
			</tr>
            <tr>
				<th >网站网址</th>
				<td><input name="value[url]" type="text" class="txt"
					value="<?=$value[url]?>" /></td>
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