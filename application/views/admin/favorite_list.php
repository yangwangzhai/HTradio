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
	
	
	$('#groupname').val('<?=$groupname?>');
});

function getgroup(){
	$('#mysearch').trigger('click');
	}
</script>
<div class="mainbox">
    <span style="float: right">
		<form action="<?=$this->baseurl?>&m=index" method="post">
       
			<input type="hidden" name="catid" value="<?=$catid?>"> 
            <input type="hidden" name="uid" value="<?=$uid?>"> 
            <input
				type="text" name="keywords" value=""> <input type="submit"
				name="submit" value=" 搜索 " id="mysearch" class="btn">
		</form>
	</span>
    
		  <input type="button" value=" 返回 " class="btn"
		onclick="location.href='./index.php?d=admin&c=member&catid=<?=$catid?>'" />
		
	<form action="<?=$this->baseurl?>&m=delete" method="post">
		<input type="hidden" name="catid" value="<?=$catid?>">
		<table width="99%" border="0" cellpadding="3" cellspacing="0"
			class="datalist fixwidth">
			<tr>
				
				<th  width="30">uid</th>				
				<th  width="50">头像</th>                		
				<th  width="100">用户名</th>
				<th  width="80">昵称</th>
				
				
			</tr>

    <?php foreach($list as $key=>$r) {?>
    		<tr>
				
				<td><?=$r['id']?></td>			
				<td><?php if($r['avatar']){?><img src="<?=new_thumbname($r['avatar'],100,100)?>" width="30" height="30"><?php }?></td>
				<td><?=$r['username']?></td>
				<td><?=$r['nickname']?></td>
               					
				
			</tr>
    <?php }?>
    
		</table>

		<div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div>

	</form>

</div>


<?php $this->load->view('admin/footer');?>