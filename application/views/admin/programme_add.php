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
 		$('#title').siblings(".errortip").html('*必须输入节目单名称');
 		flag = false;
 	}
 	
 	/*if(!$('#mid').val()){
 		$('#mid').siblings(".errortip").html('*必须填写创建者');
 		flag = false;
 	}*/
	/*
 	if(!$('#program_ids').val()){
 		$('#program_ids').siblings(".errortip").html('*请上传音频文件');
 		flag = false;
 	}
	*/
 	/*if(!$('#channel_id').val()){
 		$('#channel_id').siblings(".errortip").html('*请选择频道');
 		flag = false;
 	}*/
 	return flag;
 }

function showList(id,w,h,len){
	var ids = $('#'+id+len).val();
	var dg = $.dialog({
			id: 'list',
			title: '添加节目',		
			content: 'url:index.php?d=admin&c=programme&m=getTypeList&len='+len+'&ids='+ids,			
			min: false,
			max: false,
			padding:0,	
			margin:0,
			width:w,
			height:h
			
	});
	
	$('.ui_title').css('text-align','left');
}


function showList2(id,w,h,len){
	var ids = $('#'+id+len).val();
	var dg = $.dialog({
			id: 'list',
			title: '添加类别',		
			content: 'url:index.php?d=admin&c=programme&m=getTypeList&type=1&len='+len+'&ids='+ids,			
			min: false,
			max: false,
			padding:0,	
			margin:0,
			width:w,
			height:h
			
	});
	
	$('.ui_title').css('text-align','left');
}

function add(){
	var html;
	var length=$(".add").length;
	var len=length+1;
	//alert(typeof len);
	html+='<tr class="add me'+len+'"><th>&nbsp;&nbsp;&nbsp;&nbsp;音频</th>';
	html+='<td>时长：<input name="list['+len+'][timespan]" value="00:00:00" style="width:100px;" />格式：XX:XX:XX</td>';
	html+='<th>&nbsp;&nbsp;&nbsp;&nbsp;播放方法</th>';
	html+='<td>';
    html+='<select name="list['+len+'][type_id]" class="type" onchange="select_type(this.value,'+len+')">';
	html+='<option value="" >--请选择</option> ';
	html+='<option value="1" >播放分类</option>';
	html+='<option value="2" >播放具体节目</option>';
	html+='</select>';
	html+='<span class="pra'+len+'"></span>';
	html+='<span id="player-1"></span><span class="errortip"></span>';
	html+='</td>';

	$(".me"+length).after(html);

	
	}
	
function select_type(id,len){
	if(id==1){
	var html='选择分类<input name="list['+len+'][program_id]" class="txt fanhui'+len+' "  style=" width:50px;" type="text" id="program_ids'+len+'" value="" />';
	html+='<input type="button"  value="选择.." ';
	html+='onclick="showList2(\'program_ids\',600,430,'+len+')" class="btn" />&nbsp;&nbsp;';
    $(".pra"+len).html(html);      
		}
	if(id==2){
	var html='选择节目<input name="list['+len+'][program_id]" " class="txt fanhui'+len+' "  style=" width:150px;" class="txt" type="text" id="program_ids'+len+'" value="" />';
	html+='<input type="button" value="选择.." ';
	html+='onclick="showList(\'program_ids\',600,430,'+len+')" class="btn" />&nbsp;&nbsp;';
    $(".pra"+len).html(html);
		
	}
	
	}

    $(document).ready(function(){
        $("#channel_type").change(function(){
            var channel_type = $("#channel_type").val();
            if(channel_type==1){
                $(".vbd").css("display","none");
                $(".me1").show();
            }else{
                $(".vbd").show();
                $(".me1").css("display","none");
            }
        })
    })

</script>


<div class="mainbox nomargin">
	<form action="<?=$this->baseurl?>&m=<?php echo$flag?'personal_programme_save':'save'?>" method="post" onsubmit="return checkForm()">
		<input type="hidden" name="id" value="<?=$id?>">
        <input type="hidden" name="public_flag" value="<?=$public_flag?>">
		<table class="opt">
			<tr>
				<th >频道名称</th>
				<td><input name="value[title]" type="text" class="txt"
					value="<?=$value[title]?>" id="title" /><span class="errortip"></span></td>
				<th>&nbsp;&nbsp;&nbsp;&nbsp;封面图片</th>
				<td>
					<input type="text" class="txt" name="value[thumb]" value="<?=$value[thumb]?>" id="thumb" />
					<input type="button" value="选择.." onclick="upfile('thumb')" class="btn" />
					<input type="button" value="预览" onclick="showImg('thumb',400,300)" class="btn" />
					<span class="errortip"></span>
				</td>
			</tr>
            <tr>
                <th>频道类型</th>
                <td style="width: 250px;">
                    <select name="channel_type" id="channel_type">
                        <option value="1">录播</option>
                        <option value="2">语音播报</option>
                    </select>
                </td>
                <th class="vbd" style="display: none;">&nbsp;&nbsp;&nbsp;&nbsp;播报内容</th>
                <td class="vbd" style="display: none;">
                    <select name="vbd_type">
                        <option value="1">欧洲杯</option>
                        <option value="2">奥运会</option>
                        <option value="3">世界杯</option>
                    </select>
                </td>
            </tr>
            
            <tr class="add me1">
                <th>音频时长</th>
                <td><input name="list[1][timespan]" value="00:00:00" style="width:100px;" />格式：XX:XX:XX</td>
                <th>&nbsp;&nbsp;&nbsp;&nbsp;播放方法</th>
                <td>
                 <select name="list[1][type_id]" class="type" data-len="1" onchange="select_type(this.value,1)" >
                    <option value="" >--请选择</option>
                    <option value="1" >播放分类</option>
                    <option value="2" >播放具体节目</option>
                 </select>
                  <span class="pra1"></span>
                  <span id="player-1"></span><span class="errortip"></span><a href="javascript:" onclick="add()">+</a>
              </td>
            </tr>
            <tr>
                <th>频道简介</th>
                <td><input name="value[intro]" class="txt"  type="text" value="<?=$value[intro]?>"/></td>
                <th>&nbsp;&nbsp;&nbsp;&nbsp;标签</th>
                <td><input name="tag_name" class="txt"  type="text" value="<?=$tag_name?>"/></td>
            </tr>
             <tr>
				<td>内容</td>
				<td colspan="3"><textarea id="content" name="value[content]"
						style="width: 700px; height: 300px;"><?=$value[content]?></textarea></td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<td>
                    <input type="submit" name="submit" value=" 提 交 " class="btn" tabindex="3" /> &nbsp;&nbsp;&nbsp;
                    <input type="button" name="submit" value=" 取消 " class="btn" onclick="javascript:history.back();" /></td>
                  
			</tr>
		</table>
	</form>

</div>

<?php $this->load->view('admin/footer');?>