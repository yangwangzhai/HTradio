<?php $this->load->view('header');?>


<div class="mainbox nomargin">
	<form action="<?=$this->baseurl?>&m=save" method="post" onsubmit="return checkForm()">
		
        <input name="value[path]" class="txt" type="hidden" id="path" 
					value="<?=$path?>" />
        <!--input type="hidden"
			name="value[catid]" value="<?=$value[catid]?>"-->
		<table class="opt">
        <!--th width="90">分组 </th>
				<td><select name="value[catid]" id="gender"><?=getSelect($group, $value['catid'])?></select></td>
			</tr-->		
			<tr>
				<th >节目名称</th>
				<td><input name="value[title]" type="text" class="txt"
					value="录音" id="title" /><span class="errortip"></span></td>
				<th>&nbsp;&nbsp;&nbsp;&nbsp;节目类型</th>
				<td><select name="type_id" id="type_id"> 
                             <option value="" >--请选择类型--</option>
				      <?php  foreach ($program_types  as $k => $v) {
							 if($v['pid']=='0'){
							 ?>  
                            
							<option value="<?=$v['id']?>" ><?=$v['title'] ?></option>
							
					   <?php }}?>
                      
                     </select> <span class="errortip" ></span>
                      <span id="type_pid"></span></td>
                         
                         
			</tr>
			<tr>
				<th>节目简介</th>
				<td><input name="value[description]" class="txt" type="text" value="<?=$value[description]?>" /></td>
				
			</tr>

			
			
				<input name="value[path]" type="hidden" class="txt" type="text" id="path" 
					value=""  />
			<tr>
				<th>&nbsp;</th>
				<td><input type="submit" name="submit" value=" 提 交 " class="btn"
					tabindex="3" /> &nbsp;&nbsp;&nbsp;<input type="button"
					name="submit" value=" 取消 " class="btn"
					onclick="javascript:history.back();" /></td>
			</tr>
		</table>
	</form>

</div>

<script>
    $(document).ready(function(e){
		
		$("#type_id ").live("change",function(){
			var id=$(this).attr("value"); 
			
			$.ajax({
				type:"GET",
				url:'index.php?c=upload&m=nextbox&id='+id,
				dataType:"json",
				success: function(msg){
					
					var str='';
					if(msg.length !=0){
						str+='<select name="value[type_id]" >';
						str+='<option value="" >--请选择频道--</option>';
						for(var i=0;i<msg.length;i++){
							str+='<option value="'+msg[i].id+'">';
							str+=msg[i].title;
							str+='</option>';
				    	}
						str+=' </select>';
             		}
             		$("#type_pid").html(str);
					
				}
					
			});
			
			
			return false;
		});
		
		
	})
</script>

<?php $this->load->view('footer');?>