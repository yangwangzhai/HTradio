<?php $this->load->view('header');?>
<script type="text/javascript">
$(document).ready(function(){
	 $(".pbtn a:eq(0)").css('color','#ff6600');	
  $(".details_list ul li").mouseover(function(){
    $(this).addClass("current");
  });
$(".details_list ul li").mouseout(function(){
    $(this).removeClass("current");
  });
});
</script>
<style>
	#myform li { margin: 15px 0;}
	#myform span { display: inline-block; text-align: right; width: 80px; margin-right: 5px; }
	#myform input[type="text"] { border: 1px solid #e1e1e1; height: 34px; line-height: 34px; padding-left: 3px; transition: box-shadow 0.3s ease-in 0s; width: 260px; }
	#myform input:hover,#myform input:focus,#myform textarea:hover,#myform textarea:focus { box-shadow: 0 0 5px #095e9f; opacity: 0.5; }
	#myform textarea { border: 1px solid #dddddd; height: 60px; padding: 5px; width: 370px; resize:none;vertical-align: top; }
</style>
<div class="main">
     <?php left_view();?>   
  	<div class="radio_right">
	  <div class="radio_list">
        	<div class="radio_title">个人信息</div>
            <div class="find_pic">
                <form id="myform" action="" method="post">
			        <ul>
			            <li><span>您的账号</span>
			              	
			              	<label style="color:blue;"><?=$udata['username']?></label>
			            </li>
			            
			             <li><span>昵称</span>
			              	<input type="text" id="login-form-nickname" value="<?=$udata['nickname']?>" name="nickname">
			              	<div class="" ></div>
			            </li>

			            <li><span>性别</span>
			            	<input type="radio" name="gender" <?php if($udata['gender'] =='1'){echo 'checked';}?> value="1">男&nbsp;&nbsp;
			            	<input type="radio" name="gender" <?php if($udata['gender'] =='0'){echo 'checked';}?> value="0">女&nbsp;&nbsp;
			            	<input type="radio" name="gender" <?php if($udata['gender'] =='2'){echo 'checked';}?> value="2">保密
			            	<div class="" ></div>
			            </li>
			            
			            <li><span>真实姓名</span>
			              	<input type="text" id="check-form-truename" value="<?=$udata['truename']?>">
			              	<div class="" ></div>
			            </li>
			            
			               	<li><span>手机号码</span>
			              	<input type="text" id="login-form-tel"  value="<?=$udata['tel']?>">
			              	<div class="" ></div>
			            </li>
			            
			               	<li><span>邮箱账号</span>
			              	<input type="text" id="login-form-email"  value="<?=$udata['email']?>">
			              	<div class="" ></div>
			            </li>

			            <li><span>个性签名</span>
			              	<textarea id="sign" placeholder="" name="sign"><?=$udata['sign']?></textarea>
			              	<div class=""  ></div>
			            </li>
			        </ul>
			        
			        <div class="login-btn">
			            <button name="dosubmit" class="btn_login" id="dosubmit" type="button">保存设置</button>
			        </div>
			    </form>
                
            </div>
        </div>
        
	</div>

    
    </div>
</div>
<script>
$(document).ready(function(){
	function checkNull(obj,nickname){
		if($(obj).val() == ''){			
			$(obj).siblings('div').html('必填!');
			$(obj).siblings('div').addClass('onShow');				
			return false;
		}else{
			$(obj).siblings('div').html('');
			$(obj).siblings('div').removeClass('onShow');	
		}
		var check = check_used(nickname,'nickname');
		
		if( !check ){
			$(obj).siblings('div').html('已被使用!');
			$(obj).siblings('div').addClass('onError');				
			return false;
		}else{
			$(obj).siblings('div').html('&nbsp;&nbsp;');
			$(obj).siblings('div').removeClass('onError');
			$(obj).siblings('div').addClass('onCorrect');
			return true;	
		}
	 }
	function check_tel(obj,tel){
		var telReg = !!tel.match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/);
		//如果手机号码不能通过验证
		if(telReg == false){
		 	$(obj).siblings('div').html('不是合法的手机号');
			$(obj).siblings('div').addClass('onShow');				
			return false;
		}else{
			$(obj).siblings('div').html('');
			$(obj).siblings('div').removeClass('onShow');	
		}
		 
		 
		var check = check_used(tel,'tel');
		
		if( !check ){
			$(obj).siblings('div').html('已被使用!');
			$(obj).siblings('div').addClass('onError');				
			return false;
		}else{
			$(obj).siblings('div').html('&nbsp;&nbsp;');
			$(obj).siblings('div').removeClass('onError');
			$(obj).siblings('div').addClass('onCorrect');
			return true;	
		}
		 
	}
	 
	function check_email(obj,email){
		var myReg = /^[_a-zA-Z0-9\-]+(\.[_a-zA-Z0-9\-]*)*@[a-zA-Z0-9\-]+([\.][a-zA-Z0-9\-]+)+$/;
		//如果手机号码不能通过验证
		if(!myReg.test(email)){
		 	$(obj).siblings('div').html('不是合法的邮箱地址!');
			$(obj).siblings('div').addClass('onShow');				
			return false;
		}else{
			$(obj).siblings('div').html('');
			$(obj).siblings('div').removeClass('onShow');	
		}
		
		var check = check_used(email,'email');
		
		if( !check ){
			$(obj).siblings('div').html('已被使用!');
			$(obj).siblings('div').addClass('onError');				
			return false;
		}else{
			$(obj).siblings('div').html('&nbsp;&nbsp;');
			$(obj).siblings('div').removeClass('onError');
			$(obj).siblings('div').addClass('onCorrect');
			return true;	
		}
	}

	function check_length(obj,len) {
		if($(obj).val().length ==0 ) {
			return true;
		}
		if($(obj).val().length >= len) {
			$(obj).siblings('div').html('长度不能超过'+len+'个字符');
			$(obj).siblings('div').addClass('onError');
			return false;
		}else {
			$(obj).siblings('div').html('&nbsp;&nbsp;');
			$(obj).siblings('div').removeClass('onError');
			$(obj).siblings('div').addClass('onCorrect');
			return true;
		}
	}
	 
	 
	function check_used(val,field){
		var check = false;
		$.ajaxSetup({ 
	    	async : false 
		});   
		$.post("index.php?c=setting&m=check_used",{"val":val,"field":field},function(data){				
			if(data == 0){				
				check = true;
			}
		})
		return check;
	}

	 
		
	$("#login-form-nickname").blur(function(){
		nickname = $.trim($(this).val());
		checkNull(this,nickname);
			
	});
			
	$("#login-form-tel").blur(function(){
		tel = $.trim($(this).val());
		check_tel(this,tel);
		
	});
	$("#login-form-email").blur(function(){
		email = $.trim($(this).val());
		check_email(this,email);
		
	});  

	$("#sign").blur(function(){
		sign = $.trim($(this).text());
		check_length(this,255);
		
	}); 

	$('.btn_login').click(function(){		
		nickname = $.trim($('#login-form-nickname').val());			
		gender = $('input[type="radio"]:checked').val();
		truename = $.trim($('#check-form-truename').val());
		tel = $.trim($('#login-form-tel').val());			
		email = $.trim($('#login-form-email').val());	
		sign = $.trim($('#sign').val());

		if(!checkNull($('#login-form-nickname'),nickname)) {
			return false;
		}else if(!check_tel($('#login-form-tel'),tel)) {
			return false;
		}else if(!check_email($('#login-form-email'),email)) {
			return false;
		}else if(!check_length($('#sign'),255)) {
			return false;
		}
		
		
		$.post("index.php?c=setting&m=save",{
			"nickname":nickname,
			'gender':gender,
			'truename':truename,
			"tel":tel,
			"email":email,
			'sign':sign
			},function(data){	
			if(data == 1){				
				$.dialog({
					title: '提示',
					time: 3, 
					icon: 'success.gif',
					titleIcon: 'lhgcore.gif',
					content: '保存成功！',
				});
				
			}else if(data == 0) {
				$.dialog({
					title: '提示',
					time: 3, 
					icon: 'success.gif',
					titleIcon: 'lhgcore.gif',
					content: '你没有更新任何数据！',
				});
			}
		})
	})
        

        
});


</script>
<?php $this->load->view('footer');?>