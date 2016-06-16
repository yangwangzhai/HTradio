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
	
	
	// 点击更改状态 
	$(".updatestatus").click(function(){
			var tid = $(this).attr("name");
			var mystatus = 0;
			if($(this).text() == "已审") 
			{				
				$(this).text("未审");
				$(this).addClass("red");
			} else {
				mystatus = 1;
				$(this).text("已审");
				$(this).removeClass("red");
			}
			
			$.get("<?=$this->baseurl?>&m=updatestatus", { id: tid, status: mystatus },function(data){
			
			});
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
      <?php if(checkAccess('news_add')){?>
    <input type="button" value=" + 添加新闻 " class="btn"
		onclick="location.href='<?=$this->baseurl?>&m=add&catid=<?=$catid?>'" /> 
        <?php }?>
        &nbsp;&nbsp;
         <?php if(checkAccess('news_template_manager')){?>
	</span> <input type="button" value="  模板管理 " class="btn"
		onclick="location.href='<?=$this->baseurl?>&m=template_manager&catid=<?=$catid?>'" /> 
         <?php }?>
        &nbsp;&nbsp;
         <?php if(checkAccess('news_template')){?>
		<input type="button" value=" 显示模板设置 " class="btn"
		onclick="location.href='<?=$this->baseurl?>&m=template&catid=<?=$catid?>'" /> 
          <?php }?>
        &nbsp;&nbsp;	
         <?php if(checkAccess('gather')){?>	
        <a href="<?=$this->baseurl?>&m=gather">采集网上新闻</a>  
          <?php }?>	
		&nbsp;&nbsp;	
        <?php if(checkAccess('list910')){?>	
        <a href="<?=$this->baseurl?>&m=list_910&radio=910">采集系列台新闻</a>
		  <?php }?>	
        <form action="<?=$this->baseurl?>&m=delete" method="post">
    <input type="hidden" name="catid" value="<?=$catid?>">
		<table width="99%" border="0" cellpadding="3" cellspacing="0"
			class="datalist fixwidth" id="sortTable">
			<tr>
				<th width="30"></th>
				<th width="30"></th>
				<th width="50">图片</th>
				<th>标题</th>
				<th width="100">系列台</th>				
				<th width="100">添加时间</th>
				<th width="100">操作</th>
			</tr>
    <?php $radios = config_item('radios');foreach($list as $key=>$r) {?>
    <tr class="sortTr">
				<td><input type="checkbox" name="delete[]" value="<?=$r['id']?>"
					class="checkbox" /></td>
				<td><?=$key+1?></td>
				<td><?php if($r['thumb']){ ?><img src="<?=$r['thumb']?>" width="40" height="20"><?php }?></td>
				<td><?=$r['title']?></td>
				<td><?=$radios[$r['catid']]?></td>
				<td><?=timeFromNow($r['addtime'])?></td>
				<td>
                
                 <?php if(checkAccess('news_edit')){?>	
                <a href="<?=$this->baseurl?>&m=edit&id=<?=$r['id']?>">修改</a>
                  <?php }else{echo '--';}?>
                &nbsp;&nbsp;
                 <?php if(checkAccess('news_del')){?>	
                <a	href="<?=$this->baseurl?>&m=delete&catid=<?=$catid?>&id=<?=$r['id']?>"
					onclick="return confirm('确定要删除吗？');">删除</a>
                     <?php }else{echo '--';}?> 
                    </td>
			</tr>
    <?php }?>
     <tr>
				<td colspan="12"><input type="checkbox" name="chkall" id="chkall"
					onclick="checkall('delete[]')" class="checkbox" /><label
					for="chkall">全选/反选</label>&nbsp;
                      <?php if(checkAccess('news_del')){?>	
                    <input type="submit" value=" 删除 "
					class="btn" onclick="return confirm('确定要删除吗？');" /> 
                    <?php }?>&nbsp;</td>
			</tr>
		</table>

		<div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div>

	</form>

</div>


<?php $this->load->view('admin/footer');?>