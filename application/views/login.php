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
 function checkNull(id){
	 if($('#'+id).val() == ''){	
	 			$('#'+id).siblings('div').addClass('onShow');		
				$('#'+id).siblings('div').show();
								
				return false;
			}else{
				$('#'+id).siblings('div').hide();
				$('#'+id).siblings('div').removeClass('onShow');	
			}
 }
$(document).ready(function(){
	$('.floatHeader').hide();
	var referUrl = unescape(getReferUrl('&returnUrl='));	
	if(typeof(referUrl) =='undefined' || referUrl=='' ||  referUrl=='undefined'){
		referUrl = '?c=personal'; 
	}
	$('#yzm-img').click(function(){		
		var myDate = new Date();    
		$(this).attr("src","index.php?c=member&m=verify&guid=" + myDate.getTime());
	})
	
	
	$("#login-form-username").blur(function(){
		checkNull('login-form-username');
		});
		
	$("#login-form-password").blur(function(){
		checkNull('login-form-password');
		
		});
			
	$("#login-form-yzm").blur(function(){
		checkNull('login-form-yzm');
		
		});
			
	
	$('.btn_login').click(function(){		
		login();
	});

	$("#login-form-yzm").keypress(function(e){
		var keycode = e.keyCode|| e.which;
    	if(keycode == '13') {
      		login();
    	}
	});
	
	function login(){
		var username = $.trim($('#login-form-username').val());
		var password = $.trim($('#login-form-password').val());	
		var yzm = $.trim($('#login-form-yzm').val());	
		var remember = 0 ;

		
		if(username == ''){			
			checkNull('login-form-username');
			return false;
		}
		
		if(password == ''){			
			checkNull('login-form-password');
			return false;
		}
		if(yzm == ''){			
			checkNull('login-form-yzm');
			return false;
		}
		
		if($('#remember').attr("checked")){
			remember = 1;
		}
		
		$.post("index.php?c=member&m=check_login",{"u":username,"p":password,"y":yzm ,"r":remember},function(data){	
			if(data == 1){			
				$.dialog({
					title: '提示',
					icon: 'error.gif',
					titleIcon: 'lhgcore.gif',
					content: '验证码错误！',
					ok:true,
					close: function(){
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
					content: '登录成功！',
					ok:true,
					close:function(){
	  			 		location.href ="index.php"+referUrl;
					}

				});	
			}
			
			if(data == 2){
				$.dialog({
					title: '提示',
					icon: 'error.gif',
					titleIcon: 'lhgcore.gif',
					content: '用户名密码错误！',
					ok:true,
					close: function(){
						var myDate = new Date();    
						$("#yzm-img").attr("src","index.php?c=member&m=verify&guid=" + myDate.getTime());
					}
				});
				
			}
		})
	}
	
});

	

</script>

<div class="login-boxbg">
    <div class="login-box">
      <div class="login-ioc">用户登录</div>
      <div class="login-min">
        <form id="myform" action="" method="post">
          <ul>
            <li><span>登录账号</span>
              <input type="text" id="login-form-username" value="" name="username">
              <div class="" style="display:none;">请输入用户名</div>
            </li>
            <li><span>登录密码</span>
              <input type="password" id="login-form-password" name="password" value="">
              <div class=""  style="display:none;">请输入密码</div>
            </li>
            <li><span>验证码</span>
              <input type="text" id="login-form-yzm" name="password"  style="width: 100px;" value="">
              <img id="yzm-img" align="absmiddle" src="<?php echo base_url('index.php?c=member&m=verify') ?>" />
              <div class=""  style="display:none;">请输入验证码</div>
            </li>
            
            
          </ul>
          <div class="remember" >
            <div class="fl">
              <input type="checkbox" value="" id="remember" name="">
              <label for="r_1">保持登录状态</label>
               <a class="blue" href="#">密码找回</a>
            </div>
           
          </div>
          <div class="login-btn">
            <button name="dosubmit" class="btn_login" id="dosubmit" type="button">立即登陆</button>
          </div>
        </form>
      </div>
      <div class="col-md-4 login-reg">
        <div class="tit">还没有平台账号，立即注册</div>
        <div class="login-btn reg">
          <button class="reg_now" onClick="location.href='./index.php?c=member&m=reg'" >立即注册</button>
        </div>
      </div>
     </div>
</div>




<?php $this->load->view('footer');?>

