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
function vPics(url) {
	comDialog('<img src='+url+' border=0 />','封面图');	
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
    
      <?php if(checkAccess('weixin_news_add')){?>
<input type="button" value=" + 添加图文规则 " class="btn" 
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
			  <th width="120" nowrap="nowrap">关键词</th>
			  <th  nowrap="nowrap">回复内容</th>
			  <th width="70" align="center" nowrap="nowrap">添加时间</th>
			  <th width="100" align="center" nowrap="nowrap">操作</th>
			</tr>
    <?php foreach($list as $key=>$r) {?>
    		<tr class="sortTr">
				<td><input type="checkbox" name="delete[]" value="<?=$r['id']?>" class="checkbox" /></td>
				<td><?=$key+1?></td>
				<td nowrap="nowrap" ><?=$r['keyword']?></td>
				<td >
                	<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
                    <?php if($newsItemArr[$r[id]]){foreach($newsItemArr[$r[id]] as $val){ 
					$pic=$this->config->item('base_url').$val[PicUrl];
					$tos = $val[Url]?1:0;
					$turl = $this->config->item('base_url')."index.php?d=weixin&c=page&m=news_show&id=".$val['id']."&tourl=".$tos;
					?>
                      <tr>
                        <td width="60" rowspan="2" nowrap="nowrap" >
						<?php if($val[PicUrl]){?>
                        	<img src="<?=$pic?>" width="60" onclick="vPics('<?=$pic?>');"/>
                        <?php }?>
                        </td>
                        <td width="91%"><span style="float:right;">
                          <?php if(checkAccess('weixin_news_edit')){?>
                        <a href="<?=$this->baseurl?>&m=rulenewsedit&id=<?=$val['id']?>">修改</a>
                         <?php }else{echo '--';}?>
                            <?php if(checkAccess('weixin_news_del')){?>
                         <a href="<?=$this->baseurl?>&m=rulenewsdel&id=<?=$val['id']?>" onclick="return confirm('确定要删除吗？');">删除</a>
                          <?php }else{echo '--';}?>
                         </span>
                        标题：<a href="<?=$turl?>" target="_blank"><?=$val[Title]?></a> &nbsp;<font color="#999999">(点击:<?=$val[hit]?>/<?=$r[hit]?>)</font></td>
                      </tr>
                      <tr>
                        <td valign="top">描述：<?=$val[Description]?></td>
                      </tr>
                    <?php }}?>  
                    </table>
                    <div style="text-align:right;">
                     <?php if(checkAccess('weixin_news_add')){?>
                    <a href="<?=$this->baseurl?>&m=rulenewsadd&ruleid=<?=$r['id']?>" title="添加图文">添加</a>
                    <?php }?>
                    
                    </div>

      </td>  		
				<td align="center" nowrap="nowrap"><?=timeFromNow($r['addtime'])?></td>
				<td nowrap="nowrap">
                    <?php if(checkAccess('weixin_news_edit')){?>
                    <a href="<?=$this->baseurl?>&m=ruleedit&id=<?=$r['id']?>">修改</a>
                     <?php }else{echo '--';}?>
                    &nbsp;&nbsp;&nbsp;
                     
                            <?php if(checkAccess('weixin_news_del')){?>
                    <a href="<?=$this->baseurl?>&m=delete&catid=<?=$catid?>&id=<?=$r['id']?>" onclick="return confirm('确定要删除吗？');">删除</a> 
					<?php }else{echo '--';}?>
                    
                </td>
			</tr>
    <?php }?>
     <tr>
				<td colspan="11">
                <input type="checkbox" name="chkall" id="chkall" onclick="checkall('delete[]')" class="checkbox" />
                <label for="chkall">全选/反选</label>&nbsp; 
                  <?php if(checkAccess('weixin_news_del')){?>
                   <input type="submit" value=" 删除 " class="btn" onclick="return confirm('确定要删除吗？');" /> &nbsp;   <?php }?>
                </td>
			</tr>
		</table>

		<div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div>

	</form>

</div>


<?php $this->load->view('admin/footer');?>