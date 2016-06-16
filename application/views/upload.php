<?php $this->load->view('header');?>
<script type="text/javascript" src="static/rec/html/js/swfobject.js"></script>
<script type="text/javascript" src="static/rec/html/js/recorder.js"></script>
<script type="text/javascript" src="static/rec/html/js/main.js"></script>
<link rel="stylesheet" href="static/rec/html/style.css">
<link rel="stylesheet"  href="static/js/kindeditor410/themes/default/default.css" />
<script charset="utf-8" src="static/js/kindeditor410/kindeditor.js?2"></script>
<script charset="utf-8" src="static/js/kindeditor410/lang/zh_CN.js"></script>
<script type="text/javascript" src="static/js/common.js?1"></script>


<script>



 function checkForm(){
 	$('.errortip').html('').removeClass('onShow');
 	if(!$('#title').val()){
 		$('#title').siblings(".errortip").html('必填').addClass('onShow');
 		flag = false;
 	}

 	if(!$('#type_id').val()){
 		$('#type_id').siblings(".errortip").html('必选').addClass('onShow');
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
table tr{ line-height:41px; }

	#myform span { display: inline-block; text-align: right; }
	#myform input[type="text"] { border: 1px solid #e1e1e1; height: 34px; padding-left: 3px; transition: box-shadow 0.3s ease-in 0s; width: 260px; }
	#myform input:hover,#myform input:focus,#myform textarea:hover,#myform textarea:focus { box-shadow: 0 0 5px #095e9f; opacity: 0.5; }
	#myform textarea { border: 1px solid #dddddd; height: 60px; padding: 5px; width: 370px; resize:none;vertical-align: top; }

  #tag_wrap{width: 370px; border: 1px solid #ddd;display: inline-block;padding:5px;min-height: 30px;vertical-align: text-top;}
  #tags {padding: 5px 5px;}
  #tag_wrap:hover{ box-shadow: 0 0 5px #095e9f;opacity: 0.5;}
  .tag_hover{box-shadow: 0 0 5px #095e9f;opacity: 0.5;}
  .tag {border: 1px solid #ddd;padding: 2px 5px;margin-right: 10px;text-align: center; position: relative;display: inline-block;line-height: 20px;}
  .del_btn {display:none;font-size:12px;border-radius: 6px;width: 12px;height: 12px;border: 1px solid #ddd;position: absolute;top:-8px;right: -8px;line-height: 12px;text-align: center;cursor: pointer;color: #FFF;background: red;}
</style>
<div class="main">
  <?php left_view();?>
  <div class="radio_right">
    <div class="radio_list">
      <div class="radio_title">录音上传</div>
      <div class="details_list" id="jp-playlist">
        <div class="container" style="display: ;"  id="container"  >
          <h1><a href=""></a></h1>
          <p><strong>录制您的声音</strong>(<a href="./index.php?c=upload&m=upload_audio" style="color: rgb(255, 102, 0);">已有音频？点击此处，上传声音文件！
</a>)</p>
          <div  class="control_panel ">
            <div class="level"></div>
          </div>
          <div id="recorder-audio" class="control_panel idle">
            <button class="record_button" onclick="FWRecorder.record('audio', 'audio.wav');" title="开始录音"> <img src="static/rec/html/images/record.png" alt="开始"/> </button>
            <button class="stop_recording_button" onclick="FWRecorder.stopRecording('audio');" title="结束录音"> <img src="static/rec/html/images/stop.png" alt="结束录音"/> </button>
            <button class="play_button" onclick="FWRecorder.playBack('audio');" title="试听"> <img src="static/rec/html/images/play.png" alt="试听"/> </button>
            <button class="pause_playing_button" onclick="FWRecorder.pausePlayBack('audio');" title="Pause Playing"> <img src="static/rec/html/images/pause.png" alt="Pause Playing"/> </button>
            <button class="stop_playing_button" onclick="FWRecorder.stopPlayBack();" title="Stop Playing"> <img src="static/rec/html/images/stop.png" alt="Stop Playing"/> </button>
           
          </div>
          <div class="details">
              <div>
              <button class="show_settings" onclick="microphonePermission()">检测麦克风</button>
            </div>
            
           <!-- <div id="status"> 录音状态... </div>-->
            <div>录音时长：<span id="duration">未录音</span></div>
            <!--<div>Activity Level: <span id="activity_level"></span></div>-->
          <!--  <div>上传状态： <span id="upload_status"></span></div>-->
            <div>
            <span id="save_button"> <span id="flashcontent">
            <p>您的浏览器必须支持Javascript,而且安装了Flash播放器！</p>
            </span> </span>
            </div>
          </div>
          <form id="uploadForm" name="uploadForm" action="static/rec/html/upload.php">
            <input name="authenticity_token" value="xxxxx" type="hidden">
            <input name="upload_file[parent_id]" value="1" type="hidden">
            <input name="format" value="json" type="hidden">
          </form>
         
       
        </div>
        <div  style="display:none;"  id="add"  >
          <form action="<?=$this->baseurl?>&m=save" method="post" id="myform" onsubmit="return checkForm()">
            <input name="value[path]" type="hidden" class="txt" id="path" value=""  />
            <table class="opt">
              <tr>
                <td>节目名称</td>
                <td><input name="value[title]" type="text" class="txt"
					value="录音" id="title" />
                  <label class="errortip"></label></td>
              </tr>
              <tr>    
                <td>节目类型</td>
                <td><select name="type" id="type_id">
                    <option value="" >--请选择类型--</option>
                    <?php  foreach ($program_types  as $k => $v) {
                                 if($v['pid']=='0'){?>
                    <option value="<?=$v['id']?>" >
                    <?=$v['title'] ?>
                    </option>
                    <?php }}?>
                  </select>
                   <label class="errortip" ></label></td>
              </tr>
              <tr>
                <td>节目封面图</td>
                <td>
                 
                  <span style="width:200px;">
          			<img width="200" id="login-form-thumb-img" height="200" src="<?=show_thumb($data['thumb'])?>"  onclick="upload_image('login-form-thumb')"  title="点击修改图片">
                    <input type="button" value="选择图片" class="btn" onclick="upload_image('login-form-thumb')" style="width: 200px; line-height: 25px; height: 25px; margin-top: 8px;">
                    <input type="hidden" id="login-form-thumb"  name="value[thumb]"  value="<?=$data['thumb']?>">
       		  </span>
                 
                  <label class="errortip"></label>
                </td>
                
              </tr>
              <tr>
                <td>节目简介</td>
                <td><textarea id="sign" placeholder=""  name="value[description]"  ></textarea>
                </td>
              </tr>
              <tr style="line-height:20px;">
                <td>标签</td>
                <td>
                  <div id="tag_wrap">
                            <div id="tags"></div>
                            <div>
                                <input type="hidden" id="tag" name="value[tag]" />
                                <div id="tag_input" style="width:370px;height:25px;" contenteditable="true"></div>
                            </div>
                            <div id="default_tag">
                              <div class="tag">asfi</div>
                            </div>
                          </div>
                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><div class="login-btn">
              <button name="dosubmit" class="btn_login" style="margin-left:0px;" id="dosubmit" type="submit">提 交</button>
            </div>
                 </td>
              </tr>
            </table>
          </form>
        </div>
      </div>
    </div>
  </div>
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
					
					var str='&nbsp;';
					if(msg.length !=0){
						str+='<select name="value[type_id]" >';
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