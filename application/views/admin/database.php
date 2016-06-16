<?php $this->load->view('admin/header');?>
<script type="text/javascript">
	function __$(id) {
		return document.getElementById(id);
	}
	
	//全选、反选、取消
	function allSelCbox(n,id) {
		if(n==1) { //全选
			$("input[id='"+id+"']").each(function(){this.checked=true;});
		} else if(n==2) { //反选
			$("[id='"+id+"']").each(function(){     
				if($(this).attr("checked")) {
				  $(this).removeAttr("checked");
				} else{
				 $(this).attr("checked",'true');
				}
			});
		} else { //取消选择
			$("input[id='"+id+"']").each(function(){this.checked=false;});
		}
	}
	$(function(){
		$('#maintable td').click(function(){
		 	// $(this).children().first().trigger("click") 	
		  if( $(this).children().first().attr("checked")) {
				$(this).children().first().removeAttr("checked");
		  } else{
				$(this).children().first().attr("checked",'true');
		  }
		})
		
		
	});
	</script>
    
<style>
.maintable {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-collapse: collapse;
    border-color: #86b9d6 #d8dde5 #d8dde5;
    border-image: none;
    border-style: solid;
    border-width: 2px 1px 1px;
    width: 100%;
}
.maintable th, .maintable td {
    border: 1px solid #d8dde5;
    padding: 5px;
}
.maintable th {
    background: #f3f7ff none repeat scroll 0 0;
    color: #0d58a5;
    font-weight: normal;
    text-align: left;
    width: 210px;
}
.maintable td th, .maintable td td {
    border: medium none;
    padding: 1px;
}
.maintable th p {
    color: #909dc6;
    margin: 0;
}
.input {
    cursor: pointer;
    font-size: 16px;
    height: 25px;
    width: 200px;
}
.input2 {
    cursor: pointer;
    font-size: 14px;
    height: 22px;
    width: auto;
}

</style>    
<div class="mainbox nomargin">
 <?php if(checkAccess('database_res')){?>
 <input type="button" value=" 还原数据库 " class="btn" onclick="location.href='<?=$this->baseurl?>&m=import_index'" />
<?php }?>
<form action="<?=$this->baseurl?>&m=backup" method="post">
<table width="99%" border="0" cellpadding="3" cellspacing="0"  class="maintable">	
		
			<tr>
				<td  style="width: 120px;">
                <input type="radio" onclick="__$('showtables').style.display='none'" checked="" value="all" name="type">全部数据
                </td>
                <td >
               	备份全部表
                </td>
			</tr>			
			<tr>
				<td >
               <input type="radio" onclick="__$('showtables').style.display=''" value="custom" name="type">自定义备份
                </td>
                 <td >
               	 选择部分表数据备份
                 </td>
			</tr>
		    <tr>
				<td  style="width: 120px;">
                <input type="radio"   value="shell" name="method">不分卷备份
                </td>
                <td >
               
                </td>
			</tr>			
			<tr>
				<td >
               <input type="radio" checked="" value="multivol" name="method">分卷备份
                </td>
                 <td >
               	 分卷备份 - 文件长度限制<input type="text" name="sizelimit" value="2048" size="10">(kb)
                 </td>
			</tr>
            <tr>
				<td>备份文件名</td>
				<td><input type="text" name="filename" value="<?=$filename?>" size="30">.sql</td>
			</tr>
		</table>
            
            <div id="showtables" style="display:none">
                <table cellspacing="0" cellpadding="0" width="100%" id="maintable"  class="maintable">
                <tr><th colspan="4"><strong>数据表</strong> 
                <a href="javascript:;" onclick="allSelCbox(1,'customtabless')">[全选]</a>
                <a href="javascript:;" onclick="allSelCbox(2,'customtabless')">[反选]<a href="javascript:;">
                <a href="javascript:;" onclick="allSelCbox(0,'customtabless')">[取消选择]<a href="javascript:;"></th>
                <?=$tablelist?>
                </table>
			</div>
            <div class="buttons">
              <?php if(checkAccess('database_bak')){?>
				<input type="submit" name="exportsubmit" value="开始备份" class="btn">
              <?php  }?>
			</div>
            
			


	</form>
    
    
   
</div>


<?php $this->load->view('admin/footer');?>