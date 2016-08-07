$(function(){
	
	//关注主播
	$('.radiolist2222 .ison').click(function(){
		var zid = $(this).data('id');
		var text = $(this).html();
		var action = 'add';
		if(text == '关注'){
		}else{
			
		}
		$.post("index.php?c=ajax&m=attention",{"zid":zid},
				function(data){	
					if(data == 1){
						location.href ="index.php?c=member&m=login";
					}
			
			
		})	
	})	
	
	//节目类型也的节目子类型显示与隐藏
	$(".type_p").mousemove(function () {
			
		var ps = $(this).position();
		var id = $(this).data('id');
		if($("#float_box"+id).children().length	< 1 ){
		   $("#float_box"+id).html('<a> 暂无子类型 </a>');
		}
		$("#float_box"+id).css("position", "absolute");
		$("#float_box"+id).css("left", ps.left + 120); //距离左边距
		$("#float_box"+id).css("top", ps.top + 20); //距离上边距				
		$("#float_box"+id).show();
    });
    $(".pro_left li").mouseleave(function () {
		var id = $(this).data('id');
	   $("#float_box"+id).hide();
    });
})

function attention(zid){
	  
		var referUrl = getReferUrl('index.php');
		var is_attention = $('#zid'+zid).data('attention');
		var new_attention = is_attention == '1' ? '0' : '1' ;
		var action = 'add';
		var new_text = '已关注';
		var padding = '6px';
		var color = '#ff6600';
		var bg_url = 'url(static/images/is_cross.png) ';
		if(is_attention == '1'){
			action = 'del';
			new_text = '关注';
			padding = '0px';
			color = '#333';
			bg_url = 'url(static/images/cross.png)';
		}
		$.post("index.php?c=ajax&m=attention",{"zid":zid,"action":action},
				function(data){	
					if(data == 1){
						location.href ="index.php?c=member&m=login&returnUrl="+escape(referUrl);
					}
					if(data == 0){
						 $('#zid'+zid).data('attention',new_attention);
						 $('#zid'+zid).html(new_text);
						 $('#zid'+zid).css('color',color);
						 $('#zid'+zid).css('background-image',bg_url);
						 if($('#zid'+zid).hasClass('atten') && !$('#zid'+zid).hasClass('zhubo')){ 
							 $('#zid'+zid).css('padding-left',padding);
						 }
						 if($('#zid'+zid).hasClass('zhubo')){ 
						     width = is_attention == '1' ? '30px':'45px';
							 $('#zid'+zid).css('width',width);
						 }
					}
					if(data == 3){
						$.dialog.alert('不能关注自己');
					}
			
			
		})
}

function attention2(zid){

    var referUrl = getReferUrl('index.php');
    var is_attention = $('#zid'+zid).data('attention');
    var new_attention = is_attention == '1' ? '0' : '1' ;
    var action = 'add';
    var new_text = '已关注';
    var padding = '6px';
    var color = '#ff6600';
    //var bg_url = 'url(static/images/is_cross.png) ';
    if(is_attention == '1'){
        action = 'del';
        new_text = '关注';
        padding = '0px';
        color = '#333';
        //bg_url = 'url(static/images/cross.png)';
    }
    $.post("index.php?c=ajax&m=attention",{"zid":zid,"action":action},
        function(data){
            if(data == 1){
                location.href ="index.php?c=member&m=login&returnUrl="+escape(referUrl);
            }
            if(data == 0){
                $('#zid'+zid).data('attention',new_attention);
                $('#zid'+zid).html(new_text);
                $('#zid'+zid).css('color',color);
                $('#zid'+zid).css('background-image',bg_url);
                if($('#zid'+zid).hasClass('atten') && !$('#zid'+zid).hasClass('zhubo')){
                    $('#zid'+zid).css('padding-left',padding);
                }
                if($('#zid'+zid).hasClass('zhubo')){
                    width = is_attention == '1' ? '30px':'45px';
                    $('#zid'+zid).css('width',width);
                }
            }
            if(data == 3){
                $.dialog.alert('不能关注自己');
            }


        })
}

function attention_program(id){
	    var referUrl = getReferUrl('index.php');
		
		var is_attention = $('#programid'+id).data('attention');
		var new_attention = is_attention == '1' ? '0' : '1' ;
		var action = 'add';
		var new_text = '已关注';		
		var color = '#ff6600';
		var bg_url = 'url(static/images/is_cross.png) ';
		if(is_attention == '1'){
			action = 'del';
			new_text = '关注';			
			color = '#333';
			bg_url = 'url(static/images/cross.png)';
		}
		$.post("index.php?c=ajax&m=attention_program",{"id":id,"action":action},
				function(data){	
					if(data == 1){						
						location.href ="index.php?c=member&m=login&returnUrl="+escape(referUrl);
					}
					if(data == 0){
						 $('#programid'+id).data('attention',new_attention);
						 $('#programid'+id).html(new_text);
						 $('#programid'+id).css('color',color);
						 $('#programid'+id).css('background-image',bg_url);
						 var count = $('#icon1_'+id).html();
						 if(action == 'add'){
							 count = (parseInt(count) + 1 );
						 }
						 if(action == 'del'){
							 count = (parseInt(count) - 1 );
						 }
						 $('#icon1_'+id).html(count);
					}
			
			
		})
}

function message_dialog(zid,name){
	
	var content  = '<table id="login-form"> ';
		content += '<tr><td>发给：</td><td><input readonly type="text" value="'+name+'" name="username" id="login-form-username"></td></tr>';
		content += '<tr><td>内容：</td><td><textarea name="" id="msg_conetent" cols="" rows=""></textarea></td></tr>';
		content += '<tr><td colspan="2"  align="right"><a href="javascript:;" onclick="send_message('+zid+')" class="submitBtn"><span>发送</span></a></td></tr>';
		content += '</table>';
	
	$.dialog({
		id:'msg_dialog',
		content:content,
		title:'@'+name,
		lock: true,
		background: '#000', /* 背景色 */
		opacity: 0.5,       /* 透明度 */
		max:false,
		min:false,
		close:function(){
		var duration = 400 , /*动画时长*/
			api = this,
			opt = api.config,
			wrap = api.DOM.wrap,
			top = $(window).scrollTop() - wrap[0].offsetHeight;
			
		wrap.animate({top:top + 'px', opacity:0}, duration, function(){
			opt.close = function(){};
			api.close();
   		 });
        
    		return false;
		} 
	
	});
}

function send_message(zid){	
	var referUrl = getReferUrl('index.php');
	var content = $.trim( $('#msg_conetent').val() );
	if(content == ''){
		$.dialog.alert('您还没有输入内容喔！');
		return false;
	}
	$.post("index.php?c=ajax&m=send_message",{"zid":zid,"content":content},
				function(data){	
					if(data == 1){
						
						location.href ="index.php?c=member&m=login&returnUrl="+(referUrl);
					}
					if(data == 0){
						$.dialog.tips('发送成功.....',1,'success.gif',function(){ 
								$.dialog({id: 'msg_dialog'}).time(1);
						});
					}
			
			
		})
	
	
	
}

/********
接收地址栏
**********/
function getReferUrl(key){
	var urlArr = window.location.href.split(key);
	var refer = urlArr[1];
	return refer;
}

function setPhotos(name,id) {
	 src=$("#img").attr('src');
	$.post("index.php?&c=ajax&m=sphoto",{"src":src,"id":id},function(data){	
		$.dialog({
			top:50,	 
			id:"comDialogID",
			background: '#FFF', /* 背景色 默认的遮罩背景色为:#DCE2F1浅蓝护眼色 */
    		opacity: 0.5,       /* 透明度 */				 
			content: data,
			title: "设置相片-"+name+"-(上传选择完照片后点击确认修改修改头像)",
			max:false,
			lock: true,			
			button: [
					{
						name: '确认修改',
						focus: true,
						callback: function () {
							$.post("sphoto/tosave.php",{"getfilename":'yes'},function(fsrc){
									if(fsrc != '') {
										$("#img").attr('src',fsrc);
										//$("#img-"+id).html('<img src="'+fsrc+'" border="0" width="20" height="25">');
									}
							});
						},
														//focus: true
					},				
					{
						name: '取消',
														
					}				
				]
			,
			close: function(){
				$.post("sphoto/tosave.php",{"getfilename":'yes'},function(fsrc){
					if(fsrc != '') {
						$("#img").attr('src',fsrc);
						//$("#img-"+id).html('<img src="'+fsrc+'" border="0" width="20" height="25">');
					}
				});
			}
		});																		   
	});
}
