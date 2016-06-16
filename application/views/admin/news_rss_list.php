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

		
$(document).ready(function(){ 
	   
	
	
});

var title = "aaaa";

// 填出添加页面
function addnews(title1, weburl){
	title = title1;	
	
	var dialog = mKindEditor.dialog({
					width : 600,
					height: 500,
					title : '选用新闻：',
					body : '<iframe	src="index.php?d=admin&c=news&m=add&weburl='+weburl+'" id="iframe1" width="100%" name="iframe1" height="100%" frameborder="0" scrolling="yes" style="overflow: auto;"></iframe>',
					closeBtn : {
						name : '关闭',
						click : function(e) {
							dialog.remove();
						}
					}					
				});				
		 
		
}

</script>
<div class="mainbox">
	<span style="float: right">
		<form action="<?=$this->baseurl?>&m=index" method="post">
			<input type="hidden" name="catid" value="<?=$catid?>"> <input
				type="text" name="keywords" value=""> <input type="submit"
				name="submit" value=" 搜索 " class="btn">
		</form>
	</span>
    <a href="<?=$this->baseurl?>&m=index" >返回<< </a> &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?=$this->baseurl?>&m=gather&web=sina" <?php if($web=='sina'){echo "class='rss_title_on'";}?> >新浪(综合)</a> | 
        <a href="<?=$this->baseurl?>&m=gather&web=people" <?php if($web=='people'){echo "class='rss_title_on'";}?> >人民网(国内)</a> |
        <a href="<?=$this->baseurl?>&m=gather&web=ifeng" <?php if($web=='ifeng'){echo "class='rss_title_on'";}?> >凤凰(国际)</a> |
        <a href="<?=$this->baseurl?>&m=gather&web=gxnews" <?php if($web=='gxnews'){echo "class='rss_title_on'";}?> >广西新闻网(区内)</a>

	<form action="<?=$this->baseurl?>&m=delete" method="post">
		<input type="hidden" name="catid" value="<?=$catid?>">
		<table width="99%" border="0" cellpadding="3" cellspacing="0"
			class="datalist fixwidth" id="sortTable">
			<tr>
				<th width="30"></th>
				<th width="30"></th>
				<th>标题</th>				
				<th width="160">发布时间</th>
				<th width="100">操作</th>
			</tr>
    <?php foreach($items as $key=>$r) {?>
    <tr class="sortTr">
				<td><input type="checkbox" name="delete[]" value="<?=$r['id']?>"
					class="checkbox" /></td>
				<td><?=$key+1?></td>
				<td><a href="<?=$r['link']?>" target="_blank" title="<?=$r['description']?>"><?=$r['title']?></a></td>				
				<td><?=times($r['pubDate'],1)?></td>
				<td><a href="javascript:;" onclick="addnews('<?=$r['title']?>','<?=$r['link']?>')">选用</a></td>
			</tr>
    <?php }?>
     <tr>
				<td colspan="11"><input type="checkbox" name="chkall" id="chkall"
					onclick="checkall('delete[]')" class="checkbox" /><label
					for="chkall">全选/反选</label>&nbsp; <input type="submit" value=" 删除 "
					class="btn" onclick="return confirm('确定要删除吗？');" /> &nbsp;</td>
			</tr>
		</table>

		<div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div>

	</form>

</div>


<?php $this->load->view('admin/footer');?>