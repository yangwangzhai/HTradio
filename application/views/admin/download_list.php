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
function checknull(){
	 strfind = $("#find").val();
	 strreplac = $("#replacement").val();
	 if(strfind == '' || strreplac == ''){
		 alert('请输入信息完整！');
		 return false;
	 }
}


</script>
<div class="mainbox">

	
	<form action="<?=$this->baseurl?>&m=delete" method="post">
		<input type="hidden" name="catid" value="<?=$catid?>">
		<table width="99%" border="0" cellpadding="3" cellspacing="0"
			class="datalist fixwidth" id="sortTable">
			<tr>
				<th width="200">名称</th>	
				<th width="100">操作</th>
			</tr>

<?php foreach($list as $key=>$r) {?>
    <tr class="sortTr">
				
				<td><?=$r['name']?></td>              
				<td>                
                <a href="<?=$this->baseurl?>&m=downloads&id=<?=$r['id']?>">下载</a>             
                </td>
			</tr> 
     <?php }?>
		</table>

		

	</form>

</div>


<?php $this->load->view('admin/footer');?>