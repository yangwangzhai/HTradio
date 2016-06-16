<?php $this->load->view('admin/header');?>
<style>
	.errortip{ color: red}
</style>
<script>
KindEditor.ready(function(K) {
	K.create('#content',{urlType :'relative'});
});
</script>
<script type="text/javascript">
 function playQtime(id,u,p) {
	var w = 100;
	var h = 14;
	var pv='';
	pv += '<object width="'+w+'" height="'+h+'" classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab">';
	pv += '<param name="src" value="'+u+'">';
	pv += '<param name="controller" value="true">';
	pv += '<param name="type" value="video/quicktime">';
	pv += '<param name="autoplay" value="true">';
	pv += '<param name="target" value="myself">';
	pv += '<param name="bgcolor" value="black">';
	pv += '<param name="pluginspage" value="http://www.apple.com/quicktime/download/index.html">';
	pv += '<embed src="'+u+'" width="'+w+'" height="'+h+'" controller="true" align="middle" bgcolor="black" target="myself" type="video/quicktime" pluginspage="http://www.apple.com/quicktime/download/index.html"></embed>';
	pv += '</object><br>';
	$("#playbtn-"+id+p).css("display","none");
	$("#player-"+id+p).html( pv );
}

 function changeQtime(){
 	$('#play-btn').html('<a href="javascript:void(0)" id="playbtn-1" onclick="playQtime(1,$(\'#path\').val(),\'\')">试听</a>');
 	$('#player-1').html('');
 }

 function checkForm(){
 	$('.errortip').html('');
 	var flag = true;

 	if(!$('#title').val()){
 		$('#title').siblings(".errortip").html('*必须输入节目名');
 		flag = false;
 	}

 	if(!$('#type_id').val()){
 		$('#type_id').siblings(".errortip").html('*请选择分类');
 		flag = false;
 	}

 	if(!$('#path').val()){
 		$('#path').siblings(".errortip").html('*请上传音频文件');
 		flag = false;
 	}

 	if(!$('#channel_id').val()){
 		$('#channel_id').siblings(".errortip").html('*请选择频道');
 		flag = false;
 	}
 	return flag;
 }
</script>
<div class="mainbox nomargin">
	<form action="<?=$this->baseurl?>&m=save" method="post" onsubmit="return checkForm()">
		<input type="hidden" name="id" value="<?=$id?>"> 
        <input type="hidden" name="typeid" value="<?=$value[type_id]?>">
        <!--input type="hidden"
			name="value[catid]" value="<?=$value[catid]?>"-->
		<table class="opt">
        <!--th width="90">分组 </th>
				<td><select name="value[catid]" id="gender"><?=getSelect($group, $value['catid'])?></select></td>
			</tr-->		
			<tr>
				<th >节目名称</th>
				<td><input name="value[title]" type="text" class="txt"
					value="<?=$value[title]?>" id="title" /><span class="errortip"></span></td>
				<th>&nbsp;&nbsp;&nbsp;&nbsp;节目类型</th>
				<td><select name="type" id="type_id"> 
                             <option value="" >--请选择类型--</option>
                         
                       <?php  foreach ($program_types  as $k => $v) {
						if($v['pid']=='0'){
							  if($value['type_id']==$v['id']){
								  $seled = 'selected="selected"';
								  }elseif($pid==$v['id']){
									 $seled = 'selected="selected"';
								  }else{$seled ='';}
									?>
									<option value="<?=$v['id']?>" <?=$seled?> ><?=$v['title'] ?></option>
									
					   <?php }}?>
                      
                     </select> <span class="errortip" ></span>
                      <span id="type_pid">
                      
                      <?php if($pid!='0'){?>
                      <select name="value[type_id]"> 
                             <option value="" >--请选择类型--</option>
                           <?php  foreach ($program_types  as $k => $v) {
							if($v['pid']==$pid){
							 ?>  
                            <?php  $seled = ($value['type_id'] == $v['id'] && $id) ? 'selected="selected"' : '';?>
							<option value="<?=$v['id']?>" <?=$seled?> ><?=$v['title'] ?></option>
							
					       <?php }}?>
                      
                     </select>
                      <?php } ?>
                      
                      </span></td>
                         
                         
			</tr>
			<tr>
				<th>节目简介</th>
				<td><input name="value[description]" class="txt" type="text" value="<?=$value[description]?>" /></td>
				<th>&nbsp;&nbsp;&nbsp;&nbsp;缩略图</th>
				<td>
					<input name="value[thumb]" class="txt" type="text" id="thumb" value="<?=$value[thumb]?>" />
					<input type="button" value="选择.." onclick="upfile('thumb')" class="btn" />&nbsp;&nbsp;
					<input type="button" value="预览" onclick="showImg('thumb',350,200)" class="btn" />
				</td>
			</tr>
			<tr>
				<th>排序</th>
				<td><input name="value[sort]" class="txt" type="text" value="<?=$value[sort]?$value[sort]:0?>" /></td>
				<th>&nbsp;&nbsp;&nbsp;&nbsp;音频</th>
				<td><input name="value[path]" class="txt" type="text" id="path" 
					value="<?=$value[path]?>" onchange="changeQtime()" />
				<input type="button" value="选择.."
					onclick="upfile_audio2('path')" class="btn" />&nbsp;&nbsp;
					<span id="play-btn">
						<a href="javascript:void(0)" id="playbtn-1" onclick="playQtime(1,$('#path').val(),'')">试听</a>
					</span>
					<span id="player-1"></span><span class="errortip"></span></td>
			</tr>
			<tr>
				<th>创建者ID</th>
				<td><input name="value[mid]" class="txt" type="text" value="<?=$value[mid]?>" /></td>
				<th>&nbsp;&nbsp;&nbsp;&nbsp;所属频道</th>
				<td><select name="value[channel_id]" id="channel_id"><?=getSelect($channel,$value[channel_id],'--请选择频道--')?></select><span class="errortip"></span></td>
			</tr>
			<tr>
				<td>内容</td>
				<td colspan="3"><textarea id="content" name="value[content]"
						style="width: 700px; height: 300px;"><?=$value[content]?></textarea></td>
			</tr>
            <tr>
				<td></td>
				<td colspan="3"><input name="add_too" type="checkbox" value="1" />添加后返回页面继续添加</td>
			</tr>
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
				url:'index.php?d=admin&c=program&m=nextbox&id='+id,
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

<?php $this->load->view('admin/footer');?>