<?php $this->load->view('admin/header');?>

<script>
KindEditor.ready(function(K) {
	K.create('#content',{urlType :'relative'});
});
function checkNull(){
	if($('#thumb').val() == ''){
		alert('请选择上传图片！');
		return false;
	}
}

var dialog;
function editPic(id,url){
	var htmltxt = $('#formtable').html();
	htmltxt = htmltxt.replace(/thumb/gm,'dialogthumb');
	htmltxt = htmltxt.replace('checkNull()','checkNulls()');
	htmltxt = htmltxt.replace('+添加','保存');
	$('#picid').val(id);	

	 dialog = KindEditor.dialog({
					width : 600,
					height: 120,
					title : '修改图片：',
					body : '<div>'+htmltxt+'</div>',
					closeBtn : {
						name : '关闭',
						click : function(e) {
							dialog.remove();
						}
					}					
				});	
	 
	
}

function checkNulls(){
	if($('#dialogthumb').val() == ''){
		alert('请选择上传图片！');
		return false;
	}
	id = $('#picid').val();
	url = $('#dialogthumb').val();
	//这里就是AJAX载入的数据
	$.ajax({
		type:"post", 
		url:"<?=$this->baseurl?>&m=savepic", 
		dataType: "text", 
		data:{'id':id,'value[pic_url]':url } , 
		success:function(data){
			$('#pic'+id).attr('src',data);
			dialog.remove();
		}
		
	})
	
}
</script>
<div class="mainbox nomargin" style="margin-top:-35px;">
<form action="<?=$this->baseurl?>&m=savepic" method="post">
    <input type="hidden"  id="picid" value="">
    <input type="hidden" name="value[newstitle_id]" id="picid" value="<?=$titleid?>">
    <div id="formtable">
    	<div style="margin-left: 10px; margin-top: 20px;">
    <table class="opt" >
			<tr>
				<th width="40"  class="choose" nowrap="nowrap">图片：</th>
				<td nowrap="nowrap">
                
                <input name="value[pic_url]" class="txt" type="text" id="thumb" value="" readonly="readonly"/><input type="button" value="选择.." onclick="upfile('thumb')" class="btn" /> &nbsp;&nbsp;&nbsp;
        <input type="submit" name="submit" id="submit"  onclick="return checkNull()" value="+添加" class="btn"
					tabindex="3" /> <br><font color="#FF0000">(建议所有图片宽高保持一致)</font>
                </td>
			</tr>
    </table>
		</div>
	</div>	
</form>


<div class="ke-swfupload-body" style="position: relative; border:none; overflow:hidden; height:auto; margin-top:1px; clear:both">
      <?php   foreach($list as $key=>$r) {?>  
    
         <div data-id="SWFUpload_3_0" class="ke-inline-block sortitmes" style="width:45%;padding: 5px;">
         	<div class="ke-photo" style="width:width:100%;">
        		<img  id="pic<?=$r['id']?>" alt="<?=$r['title']?>"  style="height:300px;width:100%;" src="<?=($r['pic_url'])?>">
         			       
         	</div>
         	
            <div style="height: 18px; margin-top: 2px;width:180px;" align="center">                
                  <a href="javascript:void(0)" style="cursor:pointer;" onclick="editPic(<?=$r['id']?>,'<?=$r['pic_url']?>','<?=$r['title']?>')" >编辑</a>
                &nbsp;&nbsp;                
				  <a href="<?=$this->baseurl?>&m=deletepic&id=<?=$r['id']?>"onclick="return confirm('确定要删除吗？');">删除</a>
            </div>
         </div>
         
          <?php }?>   
         </div>

</div>

<?php $this->load->view('admin/footer');?>