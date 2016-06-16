<?php $this->load->view('header');?>
<script type="text/javascript">
$(document).ready(function(){
   $(".pbtn a:eq(1)").css('color','#ff6600');	
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
	#myform input[type="password"] { border: 1px solid #e1e1e1; height: 34px; line-height: 34px; padding-left: 3px; transition: box-shadow 0.3s ease-in 0s; width: 260px; }
	#myform input:hover,#myform input:focus { box-shadow: 0 0 5px #095e9f; opacity: 0.5; }
	
	.userwrap ul { margin: 10px 0 0 15px;}
	.userwrap li { height:30px; line-height: 30px;}
</style>
<div class="main">
      <?php left_view();?>
  	<div class="radio_right">
	  <div class="radio_list">
        	<div class="radio_title">密码修改</div>
            <div class="find_pic">
                <form id="myform" method="post">
			        <ul>
			            <li><span>您的账号</span>
			              	
			              	<label style="color:blue;"><?=$udata['username']?></label>
			            </li>
			            
			             <li><span>请输入旧密码</span>
			              	<input type="password" id="form-oldpwd" value="<?=$udata['nickname']?>" name="nickname">
			              	<div class="" ></div>
			            </li>

			            
			            
			            <li><span>请输入新密码</span>
			              	<input type="password" id="form-newpwd" value="<?=$udata['truename']?>">
			              	<div class="" ></div>
			            </li>
			            
			               	<li><span>确认新密码</span>
			              	<input type="password" id="form-repwd"  value="<?=$udata['tel']?>">
			              	<div class="" ></div>
			            
			        </ul>
			        
			        <div class="login-btn">
			            <button name="dosubmit" class="btn_login" id="dosubmit" type="button">修改密码</button>
			        </div>
			    </form>
                
            </div>
        </div>
        
	</div>

    
    </div>
</div>
<script>
$(document).ready(function(){
	function checkNull(obj){
		if($(obj).val() == ''){			
			$(obj).siblings('div').html('请输入密码!');
			$(obj).siblings('div').addClass('onShow');				
			return false;
		}else{
			$(obj).siblings('div').html('');
			$(obj).siblings('div').removeClass('onShow');	
		}
		return true;
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
	 return true;
 }
 
 function confirmed_pwd(){
	 password = $.trim($('#form-newpwd').val());
	 repassword = $.trim($('#form-repwd').val());
	 if(repassword != password || repassword == '' || password == ''){		 	
		  $('#form-newpwd').siblings('div').html('两次密码不一致');
		  $('#form-repwd').siblings('div').html('两次密码不一致');
		  $('#form-newpwd').siblings('div').addClass('onShow');	
		  $('#form-repwd').siblings('div').addClass('onShow');				
		  return false;
	 }else{
		  $('#form-newpwd').siblings('div').html('');
		  $('#form-repwd').siblings('div').html('');
		  $('#form-newpwd').siblings('div').removeClass('onShow');	
		  $('#form-repwd').siblings('div').removeClass('onShow');
	 }
	 return true;
	 
 }

	 
		
	$("#form-oldpwd").blur(function(){
		checkNull(this);
	});
			
	$("#form-newpwd").blur(function(){
		newpwd = $.trim($(this).val());
		if(check_pwd(this,newpwd)) {
			confirmed_pwd();
		}
		
		
	});
	$("#form-repwd").blur(function(){
		repwd = $.trim($(this).val());
		if(check_pwd(this,repwd)) {
			confirmed_pwd();
		}
		
	});  

	$('.btn_login').click(function(){		
		oldpwd = $.trim($('#form-oldpwd').val());			
		newpwd = $.trim($('#form-newpwd').val());
		repwd = $.trim($('#form-repwd').val());
		

		if(!checkNull($('#form-oldpwd'))) {
			return false;
		}else if(!check_pwd($('#form-newpwd'),newpwd)) {
			return false;
		}else if(!check_pwd($('#form-repwd'),repwd)) {
			return false;
		}else if(!confirmed_pwd()) {
			return false;
		}
		
		
		$.post("index.php?c=setting&m=changepwd",{
			"oldpwd":oldpwd,
			'newpwd':newpwd
			},function(data){	
			if(data == 1){				
				$.dialog({
					title: '提示',
					time: 3, 
					icon: 'success.gif',
					titleIcon: 'lhgcore.gif',
					content: '密码修改成功！',
					ok:true,
					close:function(){
						window.reload();
					}
				});
				
			}else if(data == 0) {
				$.dialog.alert('旧密码不正确！');
			}else if(data == 2) {
				$.dialog.alert('请输入新密码！');
			}else if(data == 3) {
				$.dialog.alert('旧密码和新密码一致！');
			}
		})
	})
        

        
});


</script>
<?php $this->load->view('footer');?>