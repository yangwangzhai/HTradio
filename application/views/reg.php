<?php $this->load->view('header');?>
<style>
.login-min li span {
  display: inline-block;
    text-align: right;
    width: 80px;
}
#yzm-img{
	cursor:pointer;
	 margin-top: -5px;
}
</style>

<script>
 function checkNull(obj){
	 if($(obj).val() == ''){			
		  $(obj).siblings('div').html('必填!');
		  $(obj).siblings('div').addClass('onShow');				
		  return false;
	 }else{
		  $(obj).siblings('div').html('');
		  $(obj).siblings('div').removeClass('onShow');	
	 }
 }
 
 function check_username(obj,username){
	 var reg=/^[a-zA-Z]\w{5,19}$/;  
	 if(username == '' || !reg.test(username)){	 	
		  $(obj).siblings('div').html('只能够包含字母、数字和下划线，长度在6-20之间');
		  $(obj).siblings('div').addClass('onShow');
		 			
		  return false;		  
	 }else{
		  $(obj).siblings('div').html('');
		  $(obj).siblings('div').removeClass('onShow');
	 }
	 
	 var check = check_used(username,'username');
	
	 if( !check ){
			  $(obj).siblings('div').html('已被使用!');
			  $(obj).siblings('div').addClass('onError');				
			  return false;
	 }else{
			  $(obj).siblings('div').html('可以使用！');
			  $(obj).siblings('div').addClass('onCorrect');	
	 }
	 
 }
 
  function check_pwd(obj,pwd){
	 
	 if(pwd.length < 6){			
		  $(obj).siblings('div').html('长度至少六位!');
		  $(obj).siblings('div').addClass('onShow');				
		  return false;
	 }else{
		  $(obj).siblings('div').html('');
		  $(obj).siblings('div').removeClass('onShow');	
	 }
 }
 
 function confirmed_pwd(obj,pwd){
	var password = $.trim($('#login-form-password').val());
	 if(pwd != password || pwd == ''){		 	
		  $(obj).siblings('div').html('两次密码不一致');
		  $(obj).siblings('div').addClass('onShow');				
		  return false;
	 }else{
		  $(obj).siblings('div').html('');
		  $(obj).siblings('div').removeClass('onShow');	
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
			  $(obj).siblings('div').html('可以使用!');
			  $(obj).siblings('div').addClass('onCorrect');	
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
			  $(obj).siblings('div').html('可以使用!');
			  $(obj).siblings('div').addClass('onCorrect');	
	 }
 }
 
 
 function check_used(val,field){
	 var check = false;
	 $.ajaxSetup({ 
    	async : false 
	 });   
	 $.post("index.php?c=member&m=check_used",{"val":val,"field":field},function(data){				
				if(data == 0){				
					check = true;
				}
	})
	 return check;
 }
 
$(document).ready(function(){
	$('.floatHeader').hide();
	$('#yzm-img').click(function(){		
		var myDate = new Date();    
		$(this).attr("src","index.php?c=member&m=verify&guid=" + myDate.getTime());
	})
	
	
	$("#login-form-username").blur(function(){
		var username = $.trim($(this).val());
		check_username(this,username);		
		});
		
			
	$("#login-form-nickname").blur(function(){
		var nickname = $.trim($(this).val());
		checkNull(this,nickname);		
	});	
		
	$("#login-form-password").blur(function(){
		var password = $.trim($(this).val());
		check_pwd(this,password);
		
		});
			
	$("#check-form-password").blur(function(){
		var password = $.trim($(this).val());
		confirmed_pwd(this,password);
		
	});
	
	$("#login-form-tel").blur(function(){
		var tel = $.trim($(this).val());
		check_tel(this,tel);
		
	});
	$("#login-form-email").blur(function(){
		var email = $.trim($(this).val());
		check_email(this,email);
		
	});
	
	$("#login-form-yzm").blur(function(){
		var yzm = $.trim($(this).val());
		checkNull(this,yzm);
		
	});
	
	$('.btn_login').click(function(){		
		var username = $.trim($('#login-form-username').val());
		var nickname = $.trim($('#login-form-nickname').val());
		var password = $.trim($('#login-form-password').val());	
		var password2 = $.trim($('#check-form-password').val());			
		
		var tel = $.trim($('#login-form-tel').val());			
		var email = $.trim($('#login-form-email').val());		
		var yzm = $.trim($('#login-form-yzm').val());	
		
		check_username($('#login-form-username'),username);	
		checkNull($('#login-form-nickname'),nickname);	
		check_pwd($('#login-form-password'),password);	
		confirmed_pwd($('#check-form-password'),password2);	
		checkNull($('#login-form-nickname'),nickname);	
		check_tel($('#login-form-tel'),tel);	
		check_email($('#login-form-email'),email);	
		checkNull($('#login-form-yzm'),yzm);	
		
		if(!$('#protocol').attr("checked")){
			 $('#protocol').siblings('div').show();
		  					
		     return false;
		 }else{
			   $('#protocol').siblings('div').hide();
		 }
		
		$.post("index.php?c=member&m=check_reg",{
			"username":username,
			"password":password,
			"nickname":nickname,
			"tel":tel,
			"email":email,			
			"yzm":yzm
			},function(data){	
			if(data == 1){			
				$.dialog({
					title: '提示',
					icon: 'error.gif',
					titleIcon: 'lhgcore.gif',
					content: '验证码错误！',
					ok: true,
					close:function(){
						var myDate = new Date();    
						$("#yzm-img").attr("src","index.php?c=member&m=verify&guid=" + myDate.getTime());
					}
				});
			}
			
			if(data == 0){				
				$.dialog({
					title: '提示',
					time: 3, 
					icon: 'success.gif',
					titleIcon: 'lhgcore.gif',
					content: '注册成功！',
					ok:true,
					cancel:false,
					close:function(){
      			 		location.href ="index.php?c=Index&m=find";
    				}

				});
				
			//$.dialog({id: 'login'}).title('3秒后关闭').time(3);
			//window.parent.frames.location.href ="cpi.php?c=Index&m=index";
			}
		})
	})
	
	
	
})

</script>



<div class="login-boxbg">
    <div class="login-box">
      <div class="login-ioc">用户注册</div>
      <div class="login-min" style="width:700px;">
        <form id="myform" action="" method="post">
          <ul>
            <li><span>登录账号</span>
              <input type="text" id="login-form-username" value="" name="username">
              <div class="" ></div>
            </li>
            
             <li><span>昵称</span>
              <input type="text" id="login-form-nickname" value="" name="username">
              <div class="" ></div>
            </li>
            
            <li><span>登录密码</span>
              <input type="password" id="login-form-password" name="password" value="">
              <div class=""  ></div>
            </li>
            
             <li><span>确认密码</span>
              <input type="password" id="check-form-password" value="">
              <div class="" ></div>
            </li>
            
               <li><span>手机号码</span>
              <input type="text" id="login-form-tel"  value="">
              <div class="" ></div>
            </li>
            
               <li><span>邮箱账号</span>
              <input type="text" id="login-form-email"  value="">
              <div class="" ></div>
            </li>
            
            
            <li><span>验证码</span>
              <input type="text" id="login-form-yzm" name="password"  style="width: 100px;" value="">
              <img id="yzm-img" align="absmiddle" src="<?php echo base_url('index.php?c=member&m=verify') ?>" />
              <div class="" ></div>
            </li>
            
            
          </ul>
           <div class="remember" style="padding-bottom:10px;">
                    	 <input type="checkbox" value="" id="protocol" name="protocol">
                         <label for="r_1">我已阅读并接受<a  href="#">《注册协议和版权申明》</a></label>
                    <div class="onShow" style="display:none;">请阅读协议!</div>
         </div>
          <div class="login-btn">
            <button name="dosubmit" class="btn_login" id="dosubmit" type="button">立即注册</button>
          </div>
        </form>
      </div>
      <div class="col-md-4 login-reg"  style="width:250px;">
        <div class="tit">已经有平台账号？请直接登录</div>
        <div class="login-btn reg">
          <button class="reg_now" onClick="location.href='./index.php?c=member&m=login'" >现在登录</button>
        </div>
      </div>
     </div>
</div>



<?php $this->load->view('footer');?>

