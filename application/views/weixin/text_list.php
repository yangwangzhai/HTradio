<?php $this->load->view('admin/header');?>
<script type="text/javascript">
$(function($)
{
	// 数据列表 点击开始排序
	var sortFlag = 0;	
	$("#sortTable th").click(function()
	{
		var tdIndex = $(this).index();		
		var temp = "";
		var trContent = new Array();
		//alert($(this).text());	
		
		// 把要排序的字符放到行的最前面，方便排序
		$("#sortTable .sortTr").each(function(i){ 
			temp = "##" + $(this).find("td").eq(tdIndex).text() + "##";			
			trContent[i] = temp + '<tr class="sortTr">' + $(this).html() + "</tr>";			
		});
		
		// 排序
		if(sortFlag==0) {
			trContent.sort(sortNumber);
			sortFlag = 1;
		} else {
			trContent.sort(sortNumber);
			trContent.reverse();
			sortFlag = 0;
		}
		
		// 删除原来的html 添加排序后的
		$("#sortTable .sortTr").remove();
		$("#sortTable tr").first().after( trContent.join("").replace(/##(.*?)##/, "") );
		
	});
	
});
</script>
<div class="mainbox">

	<span style="float: right">
		<form action="<?=$this->baseurl?>&m=index" method="post">
			<input type="hidden" name="catid" value="<?=$catid?>"> <input
				type="text" name="keywords" value=""> <input type="submit"
				name="submit" value=" 搜索 " class="btn">
		</form>
 	</span> 
     <?php if(checkAccess('weixin_text_add')){?>
<input type="button" value=" + 添加文本规则 " class="btn" 
		onclick="location.href='<?=$this->baseurl?>&m=add&catid=<?=$catid?>'" />
        <?php }?>
        
		<?=$this->type[ $_GET[table] ]?>
	
	<form action="<?=$this->baseurl?>&m=delete" method="post">
		<input type="hidden" name="catid" value="<?=$catid?>">
		<table width="99%" border="0" cellpadding="3" cellspacing="0"
			class="datalist fixwidth" id="sortTable">
			<tr>
				<th width="20" nowrap="nowrap">&nbsp;</th>
				<th width="18" nowrap="nowrap">&nbsp;</th>
			  <th width="160" nowrap="nowrap">关键词</th>
			  <th  nowrap="nowrap">回复内容</th>
			  <th width="71" align="center">添加时间</th>
				<th width="110" align="center">操作</th>
			</tr>
    <?php foreach($list as $key=>$r) {?>
    		<tr class="sortTr">
				<td><input type="checkbox" name="delete[]" value="<?=$r['id']?>" class="checkbox" /></td>
				<td><?=$key+1?></td>
				<td ><?=$r['keyword']?></td>
				<td ><?=$r['recontent']?></td>  		
				<td nowrap="nowrap" title="<?=times($r['addtime'],1)?>"><?=timeFromNow($r['addtime'])?></td>
				<td nowrap="nowrap">
                        <?php if(checkAccess('weixin_text_edit')){?>
                    <a href="<?=$this->baseurl?>&m=edit&id=<?=$r['id']?>">修改</a>
                     <?php }else{echo '--';}?>
                    &nbsp;&nbsp;&nbsp;
                  
                       <?php if(checkAccess('weixin_text_del')){?>
                    <a href="<?=$this->baseurl?>&m=delete&catid=<?=$catid?>&id=<?=$r['id']?>" onclick="return confirm('确定要删除吗？');">删除</a>
                     <?php }else{echo '--';}?>
                </td>
			</tr>
    <?php }?>
     <tr>
				<td colspan="11">
                <input type="checkbox" name="chkall" id="chkall" onclick="checkall('delete[]')" class="checkbox" />
                <label for="chkall">全选/反选</label>&nbsp; 
                <?php if(checkAccess('weixin_text_del')){?>  <input type="submit" value=" 删除 " class="btn" onclick="return confirm('确定要删除吗？');" /> &nbsp; <?php }?>
                </td>
			</tr>
		</table>

		<div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div>

	</form>

</div>


<?php $this->load->view('admin/footer');?>