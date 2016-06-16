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
<script language="javascript">
function vPics(name,src){
	$.dialog({id:"comDialogID",content:'<img src="'+src+'" />',title:name,max:false});	
}
</script>
<div class="mainbox">

	<span style="float: right">
		<form action="<?=$this->baseurl?>&m=index" method="post">
			<input type="hidden" name="catid" value="<?=$catid?>"> 
			标题：
			<input
				type="text" name="content" value=""> <input type="submit"
				name="submit" value=" 搜索 " class="btn">
		</form>
 	</span>
    
       <?php if(checkAccess('news_title_add')){?>
    <input type="button" value=" + 添加 " class="btn"
		onclick="location.href='<?=$this->baseurl?>&m=add&catid=<?=$catid?>'" /> 
      <?php }?>
	<?=$this->type[ $_GET[table] ]?>
	
	<form action="<?=$this->baseurl?>&m=delete" method="post">
		<input type="hidden" name="catid" value="<?=$catid?>">
		<table width="99%" border="0" cellpadding="3" cellspacing="0"
			class="datalist fixwidth" id="sortTable">
			<tr>
			  <th width="410" align="left" nowrap="nowrap">标题</th>
			  <th width="595" align="left" nowrap="nowrap">内容</th>
			  <th width="104" align="center">发表时间</th>
				<th width="100" align="center">操作</th>
			</tr>
    <?php foreach($list as $key=>$r) {?>
    		<tr class="sortTr">
			 <td align="left" ><a href="index.php?d=weixin&c=news_title&m=news_pic&titleid=<?=$r['id']?>"><?=$r['title']?></a></td>
			 <td align="left" nowrap="nowrap" >
			   <?=str_cut(strip_tags($r['content']),120,'...')?>
		</td>
			  <td nowrap="nowrap" title="<?=times($r['addtime'],1)?>"><?=times($r['addtime'],0)?></td>
				<td nowrap="nowrap">     
                	
                     <?php if(checkAccess('news_title_check')){?>
                    <a target="_blank" href="./index.php?d=weixin&c=page&m=picnews&id=<?=$r['id']?>" >预览</a>   <?php }else{echo '--';}?>
                    
                    &nbsp;&nbsp; 
                     <?php if(checkAccess('news_title_edit')){?>          	
                    <a href="<?=$this->baseurl?>&m=edit&id=<?=$r['id']?>">修改</a>
                       <?php }else{echo '--';}?>
                    &nbsp;&nbsp;
                    
                     <?php if(checkAccess('news_title_del')){?>
                    <a href="<?=$this->baseurl?>&m=delete&catid=<?=$catid?>&id=<?=$r['id']?>" onclick="return confirm('确定要删除吗？');">删除</a>   <?php }else{echo '--';}?>
                </td>
			</tr>
    <?php }?>
		</table>

		<div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div>

	</form>

</div>


<?php $this->load->view('admin/footer');?>