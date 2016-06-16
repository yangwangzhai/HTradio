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
	
	
	// 点击图片放大
	$("#sortTable img").click(function(){
			$.dialog({				
				height: 600,
				id: 'a15',
				title: '大图',
				lock: true,
				max: false,
				min: false,
				content: '<img src="'+$(this).attr("alt")+'" height="600" />',
				padding: 0
			});
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
     
	<form action="<?=$this->baseurl?>&m=delete" method="post">
		<input type="hidden" name="catid" value="<?=$catid?>">
		<table width="99%" border="0" cellpadding="3" cellspacing="0"
			class="datalist fixwidth" id="sortTable">
			<tr>
				<th width="20"></th>
				<th width="100">发信人</th>				
                <th width="100">收信人</th>
				<th>文字内容</th> 
				<th width="100">语音</th>               
				<th width="100">图片</th>
				<th width="160">添加时间</th>
				<th width="100" align="center">操作</th>
			</tr>
    <?php foreach($list as $key=>$r) {?>
    <tr class="sortTr">
				<td><input type="checkbox" name="delete[]" value="<?=$r['id']?>"
					class="checkbox" /></td>				
               <td ><?=$r['from_name']?></td>
				 <td ><?=$r['to_name']?></td>
				<td ><?=$r['title']?></td> 
                 
				<td><?=$r['audio']?></td>             
				<td > <?php if($r['thumb']){?>
                <img src="<?=$r['thumb100']?>" width="30" height="30" title="点击放大" alt="<?=$r['thumb720']?>">
                 <?php }?></td> 	
				<td><?=times($r['addtime'],1)?></td>
				<td>
                 <?php if(checkAccess('message_edit')){?>	
                <a href="<?=$this->baseurl?>&m=edit&id=<?=$r['id']?>">修改</a>
                <?php }?>
                &nbsp;&nbsp;
                  <?php if(checkAccess('message_del')){?>	
                <a
					href="<?=$this->baseurl?>&m=delete&catid=<?=$catid?>&id=<?=$r['id']?>"
					onclick="return confirm('确定要删除吗？');">删除</a>
                      <?php }?>
                    </td>
			</tr>
    <?php }?>
     <tr>
				<td colspan="11"><input type="checkbox" name="chkall" id="chkall"
					onclick="checkall('delete[]')" class="checkbox" /><label
					for="chkall">全选/反选</label>&nbsp; 
                     <?php if(checkAccess('message_del')){?>	
                    <input type="submit" value=" 删除 "
					class="btn" onclick="return confirm('确定要删除吗？');" /> 
                      <?php }?>
                    &nbsp;</td>
			</tr>
		</table>

		<div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div>

	</form>

</div>


<?php $this->load->view('admin/footer');?>