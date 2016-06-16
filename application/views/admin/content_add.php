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
		<input type="hidden" name="id" value="<?=$id?>"> <input type="hidden"
			name="value[catid]" value="<?=$value[catid]?>">
		<table class="opt">
			<!--  <tr>
				<th>分类</th>
				<td><?=$value[catname]?></td>
			</tr>-->
			<tr>
				<th width="90">标题 *</th>
				<td><input type="text" class="txt" name="value[title]"
					value="<?=$value[title]?>" /></td>
			</tr>			
			<tr>
				<th>缩略图</th>
				<td><input name="value[thumb]" class="txt" type="text" id="thumb"
					value="<?=$value[thumb]?>" /><input type="button" value="选择.."
					onclick="upfile('thumb')" class="btn" /></td>
			</tr>
			<tr>
				<th>内容</th>
				<td><textarea id="content" name="value[content]"
						style="width: 700px; height: 400px;"><?=$value[content]?></textarea></td>
			</tr>
			<th>排序</th>
			<td><input name="value[sort]" type="text" class="txt" id="sort"
				value="<?=$value[sort]?$value[sort]:0;?>" style="width: 50px;" />
				&nbsp;数字大靠前</td>
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