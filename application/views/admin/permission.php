<?php $this->load->view('admin/header');?>
<style>
#sortTable tr:hover{background-color:#fff}
#sortTable2 tr:hover{background-color:#f2f9fd}
</style>                
                    
<div class="mainbox">
  
    <table width="99%" border="0" cellpadding="3" cellspacing="0" class="datalist" id="sortTable" >
        <tr>
           <td width="50" align="right" valign="top">用户组:</td>
           <td width="408">   
              <form action="<?=$this->baseurl?>&m=index" method="post" id="theform">     
    			
                <select name="catid" onchange="$('#theform').submit();" id="gender"><?=getSelect($group, $catid)?></select>
                &nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="button" value=" 保 存 " class="btn save"
               tabindex="3" />  <a style="cursor:pointer" class="checkalls">&nbsp;&nbsp;全选</a>
     		</form>            
            
               </td>
            </tr>	 
       <form action="<?=$this->baseurl?>&m=save" method="post">
            <input type="hidden" name="id" value="<?=$id?>">   
              <tr style="">
                  <td width="50" align="right" valign="top">  </td>
                <td width="408">  
                 <table width="99%" border="0" cellpadding="3" cellspacing="0" class="datalist" id="sortTable2" >         
               <?php 
			   foreach($main_menu as  $k => $menu) {
				   echo "<tbody><tr><td>";	
				   ?>	
                  <input type="checkbox" <?php if(in_array($k,$inmenu)) echo "checked"; ?> name="strmenu[]" value="<?=$k?>"
					class="checkbox" />&nbsp;<b><?=$menu?></b>&nbsp;&nbsp;&nbsp;&nbsp;  
                    <a style="cursor:pointer" class="checkall">全选/反选</a> 
                 <?php   		   				
				if(!array_key_exists($k,$menu_lists)) continue;
				
			   	foreach($menu_lists[$k] as $menu_list) {
					 echo "<tr><td>";	
					foreach($menu_list as $key=>$r) {
				     $i++;
				   ?>	              
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              
              <input type="checkbox" <?php if(in_array($key,$inmenu)) echo "checked"; ?> name="strmenu[]" value="<?=$key?>"
					class="checkbox" />&nbsp;<?=$r?>&nbsp;&nbsp;
                <?php
					}
					 echo "</td></tr>";
				 }
				  echo "</td></tr></tbody>";	
			   }?>	
               </table>	
                </td>
            </tr>	
            
              <tr>
                  <th>&nbsp;</th>
                  <td><input type="submit"  id="savemenu" name="submit" value=" 保 存 " class="btn"
                        tabindex="3" />  <a style="cursor:pointer" class="checkalls">&nbsp;&nbsp;全选</a></td>
              </tr>
                </form>
          </table>
      
</div>
<script language="javascript">
$(document).ready(function(){
 // chkItem事件
  $("[name = strmenu[]]:checkbox").bind("click", function () {
	   if($(this).is(":checked")){
           $(this).parent().find("input:eq(0)").attr("checked", true);//
		}
  })
 
 $(".checkall").click(function(){
	 p = $(this).parent().parent().parent();
	 p.find("input")
	  p.find("input").each(function(){
		$(this).attr("checked",!this.checked);              
	  });
   });
  
  $(".checkalls").click(function(){  
  	$("input[name='strmenu[]']").each(function(){
   		$(this).attr("checked",true);
  	});  
 });
 
 $(".save").click(function(){  
  	 $('#savemenu').trigger('click');
 });
   
});

</script>
<?php $this->load->view('admin/footer');?>