<?php $this->load->view('header');?>
<link href="static/swfupload/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="static/swfupload/swfupload.js"></script>
<script type="text/javascript" src="static/swfupload/swfupload.queue.js"></script>
<script type="text/javascript" src="static/swfupload/fileprogress.js"></script>
<script type="text/javascript" src="static/swfupload/handlers.js"></script>
<link rel="stylesheet"  href="static/js/kindeditor410/themes/default/default.css" />
<script charset="utf-8" src="static/js/kindeditor410/kindeditor.js?2"></script>
<script charset="utf-8" src="static/js/kindeditor410/lang/zh_CN.js"></script>
<script type="text/javascript" src="static/js/common.js?1"></script>
<style>
  #tag_wrap{width: 370px; border: 1px solid #ddd;display: inline-block;padding:5px;min-height: 30px;vertical-align: text-top;}
  #tags {padding: 5px 5px;}
  #tag_wrap:hover{ box-shadow: 0 0 5px #095e9f;opacity: 0.5;}
  .tag_hover{box-shadow: 0 0 5px #095e9f;opacity: 0.5;}
  .tag {border: 1px solid #ddd;padding: 2px 5px;margin-right: 10px;text-align: center; position: relative;display: inline-block;}
  .del_btn {display:none;font-size:12px;border-radius: 6px;width: 12px;height: 12px;border: 1px solid #ddd;position: absolute;top:-8px;right: -8px;line-height: 12px;text-align: center;cursor: pointer;color: #FFF;background: red;}
</style>
<script type="text/javascript">
		var swfu;
		window.onload = function() {
			var settings = {
				flash_url : "static/swfupload/swfupload.swf",	
				upload_url: "upload_audio.php",	// Relative to the SWF file
				use_query_string : true, //就可以传递参数了；
				post_params: {"PHPSESSID" : "<?php echo session_id(); ?>"},
				file_size_limit : "<?= $file_size_limit?>",
				file_types : "<?= $file_types?>",
				file_types_description : "<?= $file_types_description?>",
				file_upload_limit : <?= $file_upload_limit?>,
				file_queue_limit : 10,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel"
				},
				debug: false,

				// Button settings
				button_image_url: "static/swfupload/btn1.gif",	//Relative to the Flash file
				button_width: "125",
				button_height: "25",
				button_placeholder_id: "spanButtonPlaceHolder",
				button_text: '',
				button_text_style: "",
				button_text_left_padding: 0,
				button_text_top_padding: 0,
				
				button_cursor: SWFUpload.CURSOR.HAND, //鼠标样式
				button_action: SWFUpload.BUTTON_ACTION.SELECT_FILES, //单文件上传还是多文件上传
				button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT, //按钮的flash模式，这里用透明才好使用css样式
			//	button_disabled:true,
				
				
				// The event handler functions are defined in handlers.js
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete	// Queue plugin event
			};

			swfu = new SWFUpload(settings);
	     };



	function checkForm(){
 	$('.errortip').html('').removeClass('onShow');
 	var flag = true;

 	if(!$('#login-form-title').val()){
 		$('#login-form-title').siblings('.errortip').text('必填').addClass('onShow');
 		flag = false;
 	}

 	if(!$('#type_id').val()){
 		$('#type_id').siblings('.errortip').text('请选择分类').addClass('onShow');
 		flag = false;
 	}

 	if(!$('#login-form-path').val()){
 		$('#login-form-path').siblings('.errortip').text('请上传音频文件').addClass('onShow');
 		flag = false;
 	}

 	if(!$('#login-form-thumb').val()){
 		$('#login-form-thumb').parent().next().text('请上传封面图片').addClass('onShow');
 		flag = false;
 	}

 	
 	return flag;
 }
	</script>
<style>
.errortip{ }
</style>

<div class="main">
  <?php left_view();?>
  <div class="radio_right">
    <div class="radio_list" style="height:850px;">
      <div class="radio_title">上传音频 <a style="font-size:12px;color:#ff6600" href="./index.php?c=upload&m=upload">(喜欢录音？点击此处，录制您的声音！)</a></div>
      <div class="">
        <div class="find_pic">
          <form id="myform" action="./index.php?c=upload&m=save" method="post" onsubmit="return checkForm()">
          <input name="id" type="hidden" value="<?=$data['id']?>" />
           <input id="type_id_hidden" type="hidden" value="<?=$data['type_id']?>" />
            <ul>
              <li><span>节目名称</span>
                <input type="text" id="login-form-title" value="<?=$data['title']?>" name="value[title]" >
                <label class="errortip" ></label>
              </li>
              
               <li><span>节目路径</span>
                <input type="text" id="login-form-path" name="value[path]"  readonly="readonly"  value="<?=$data['path']?>" >
                <label class="errortip" ></label>
              </li>
             <li> 
              <div id="content" class="mainbox nomargin" style="display:none;">
                <div id="cmain">
                  <div id="uploadform">
                    <div class="button1"> <span id="spanButtonPlaceHolder"></span>
                      <input id="btnUpload" type="button" value="" onclick="swfu.startUpload();" disabled="disabled" style="margin-left: 2px; width:121px; height: 25px; background:url(static/images/btn2.gif) no-repeat; border:0;" />
                      <input id="btnCancel" type="button" value="" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; width:121px; height: 25px; background:url(static/images/btn3.gif) no-repeat; border:0;" />
                      <span id="divStatus" class="status">0 个文件被上传</span> </div>
                    <div class="textads"> 上传页面正在加载中如果未出现选择上传按扭请捎等片刻... </div>
                    <div class="fieldset flash" id="fsUploadProgress" style="height:120px;"> <span class="legend">上传队列</span> </div>
                  </div>
                  <span style="color: #0000FF;display:none;">以下是论坛专用的贴图代码全部复制发贴的时候粘贴上去即可</span>
                  <div id="cmainbottom" style="color: #0000FF;display:none;">
                    <div id="imglist"></div>
                  </div>
                </div>
              </div>
                </li>
              <li><span>节目类型</span>
                <select name="type" id="type_id">
                  <option value="" >--请选择类型--</option>
                  <?php  foreach ($program_types  as $k => $v) {
                                 if($v['pid']=='0'){?>
                  <option value="<?=$v['id']?>" <?php if($v['id'] ==$data['type_id'] ) {echo "selected";}  ?>>
                  <?=$v['title'] ?>
                  </option>
                  <?php }}?>
                </select>
               
                <label class="errortip" ></label>
              <li><span>节目封面图</span>
              
              <span style="width:200px;">
          			<img width="200" id="login-form-thumb-img" height="200" src="<?=show_thumb($data['thumb'])?>"  onclick="upload_image('login-form-thumb')"  title="点击修改图片">
                    <input type="button" value="选择图片" class="btn" onclick="upload_image('login-form-thumb')" style="width: 200px; line-height: 25px; height: 25px; margin-top: 8px;">
                    <input type="hidden" id="login-form-thumb"  name="value[thumb]"  value="<?=$data['thumb']?>">
       		  </span>
             
                <label class="errortip" ></label>
              </li>
              <li><span>节目简介</span>
                <textarea id="sign" placeholder=""  name="value[description]"  ><?=$data['description']?>
</textarea>
                <label class="errortip" ></label>
              </li>
              <li><span>标签</span>
                  <input name="tag_name" class="txt"  type="text" value="" placeholder="多个标签以逗号分隔"/>
              </li>
            </ul>
            <div class="login-btn">
              <button name="dosubmit" style="margin-left:88px;"  class="btn_login" id="dosubmit" type="submit">提 交</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!--<div class="bg-fa">
                  <p class="c02 mgl-5">推荐标签</p>
                  <div id="sound_tagPanel" class="tagBtnList tags-selecter-tagPanel cl js-hottags">
    <a href="javascript:;" class="tagBtn2">
        <span>排行榜</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>电影原声</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>华语</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>日韩</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>粤语</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>流行</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>古典</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>摇滚</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>民谣</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>电子</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>嘻哈</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>爵士</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>神曲</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>80后</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>90后</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>小清新</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>文艺</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>咖啡</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>午后</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>新歌</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>纯音乐</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>独立</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>钢琴曲</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>民乐</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>串烧</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>翻唱</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>模仿秀</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>remix</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>DJ</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>舞曲</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>乡村</span>
    </a>

    <a href="javascript:;" class="tagBtn2">
        <span>老歌</span>
    </a>
</div>
                </div>
-->
<script>
    $(document).ready(function(e){
		var type_id = $("#type_id_hidden ").val();
		if(type_id != '' && type_id != null){
			selectType(type_id)
		}
		$("#type_id ").bind("change",function(){
			var id=$(this).attr("value"); 			
			$.ajax({
				type:"GET",
				url:'index.php?c=upload&m=nextbox&id='+id,
				dataType:"json",
				success: function(msg){					
					var str='';
					if(msg.length !=0){
						str+='&nbsp;&nbsp;<select name="value[type_id]" >';
						str+='<option value="" >--请选择类型--</option>';
						for(var i=0;i<msg.length;i++){
							str+='<option value="'+msg[i].id+'">';
							str+=msg[i].title;
							str+='</option>';
				    	}
						str+=' </select>';
             		}
             		$("#type_id").after(str);					
				}					
			});
			return false;
		});
		
	$("#login-form-path").focus(function(){
		$('#content').slideDown();
		
	});		

  $('#tag_input').keypress(function(e){

    if(e.which == 13 || e.which == 32) {
      var text = $.trim($(this).text());
      var tag_ids = $('#tag').val();
      var tag = $('#tags .tag_txt');
      if(text == ''){return false;}
      if(tag.length >= 5){
        alert('最多只能添加5个标签');
        $(this).html('');
        return false;
      }
      if(GetLength(text) > 16){
        alert('超过最大字符限制');
        return false;
      }
	  
	  
	     var btns = new Array(); 
        jQuery('.tag_txt').each(function(key,value){
		btns[key] = $(value).html();
		});
		
		// var tag_1 = $('.tag_txt').html();
		var rs =jQuery.inArray(text, btns);
		
		//alert (rs);
		if(rs!=-1){
        alert('已有的标签');
        return false;
      }
   
        
	  
      /*tag.each(function(i){
        if(tag.eq(i).text() == text){
          $('#tag_input').html('');
          return
        }
      });*/
      if(!tag_ids){
        $('#tag').val(text);
      }else{
        var tags = '';
        tag.each(function(i){
          tags += tag.eq(i).text()+',';
        });
        tags = tags.substring(0,tags.length - 1);
        $('#tag').val(tags+','+text);
      }
      $(this).html('');
      
      $('#tags').append('<div class="tag"><div class="tag_txt">'+text+'</div><div class="del_btn">X</div></div>');

    }
    
  });

  $('#tag_wrap').on('click','.del_btn',function(){
    $(this).parent().remove();
    var tag = $('.tag_txt');
    var tags = '';
    tag.each(function(i){
      tags += tag.eq(i).text()+',';
    });
    tags = tags.substring(0,tags.length - 1);
    $('#tag').val(tags);
  });

  $('#default_tag .tag').click(function(){
    var text = $.trim($(this).text());
    var tag_ids = $('#tag').val();
    var tag = $('#tags .tag_txt');
    if(text == ''){return false;}
    if(tag.length >= 5){
      alert('最多只能添加5个标签');
      return false;
    }
    if(GetLength(text) > 16){
      alert('超过最大字符限制');
      return false;
    }
	 var btns = new Array(); 
        jQuery('.tag_txt').each(function(key,value){
		btns[key] = $(value).html();
		});
		// var tag_1 = $('.tag_txt').html();
		var rs =$.inArray(text, btns);
		//alert (rs);
		if(rs!=-1){
        alert('已有的标签');
        return false;
      }
	
	
    if(!tag_ids){
      $('#tag').val(text);
    }else{
      var tags = '';
      tag.each(function(i){
        tags += tag.eq(i).text()+',';
      });
      tags = tags.substring(0,tags.length - 1);
      $('#tag').val(tags+','+text);
    }
    
    $('#tags').append('<div class="tag"><div class="tag_txt">'+text+'</div><div class="del_btn">X</div></div>');
  });

  $('#tag_wrap').on('mouseover','.tag',function(){
    $(this).children('.del_btn').css({display:'inline-block'});
  });

  $('#tag_wrap').on('mouseout','.tag',function(){
    $(this).children('.del_btn').hide();
  });

  $('#tag_input').focus(function(){
    $('#tag_wrap').addClass('tag_hover');
  });

  $('#tag_input').blur(function(){
    $('#tag_wrap').removeClass('tag_hover');
  });

  $('#tag_wrap').click(function(){
    $('#tag_input').focus();
  })
  
		
	})
	
function selectType(id){
	
	$.ajax({
				type:"GET",
				url:'index.php?c=upload&m=checkType&id='+id,
				dataType:"json",
				success: function(pid){					
					if(pid != '0' ){
						$.ajax({
							type:"GET",
							url:'index.php?c=upload&m=nextbox&id='+pid,
							dataType:"json",
							success: function(msg){					
								var str='';
								if(msg.length !=0){
									str+='&nbsp;&nbsp;<select id="type_cid" name="value[type_id]" >';
									str+='<option value="" >--请选择类型--</option>';
									for(var i=0;i<msg.length;i++){
										str+='<option value="'+msg[i].id+'">';
										str+=msg[i].title;
										str+='</option>';
									}
									str+=' </select>';
								}
								$("#type_id").after(str);	
								//赋值	
								$("#type_cid").val(id);	
								$("#type_id").val(pid);				
							}					
						});
						
					}		
				}					
			});
	
	
}

function GetLength(str) {
    ///<summary>获得字符串实际长度，中文2，英文1</summary>
    ///<param name="str">要获得长度的字符串</param>
    var realLength = 0, len = str.length, charCode = -1;
    for (var i = 0; i < len; i++) {
        charCode = str.charCodeAt(i);
        if (charCode >= 0 && charCode <= 128) realLength += 1;
        else realLength += 2;
    }
    return realLength;
}; 
	
</script>
<?php $this->load->view('footer');?>
