<?php $this->load->view('header');?>

<div class="clear"></div>
<div class="content_box">
<div class="guestbook">
<h3>问题反馈</h3>
<form action="index.php?c=front&m=guestbook_save" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<td width="29%" align="right" valign="top"><font color="#FF0000">*</font> 反馈内容：</td>
  	<td colspan="2"><textarea name="content" cols="" rows=""></textarea></td>
  	</tr>
  <tr>
  	<td align="right">您的姓名：</td>
  	<td colspan="2"><input name="username" type="text" class="text" style="width:200px;"/></td>
  	</tr>
  <tr>
  	<td align="right">您的电话：</td>
  	<td colspan="2"><input name="phone" type="text" class="text" style="width:200px;"/></td>
  	</tr>
  <tr>
  	<td align="right"><font color="#FF0000">*</font> 验证码：</td>
  	<td width="8%"><input name="checkcode" type="text" class="text" style="width: 80px" id="checkcode" /></td>
  	<td width="63%"><img src='index.php?c=common&m=checkcode'
						name="code_img" id='code_img' title="点击更换"
						onclick='this.src=this.src+"&"+Math.random()' /></td>
  	</tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="2"><p>
    	<input type="submit" value="提 交"  class="ok_btn"/>
    </p>
    	<p>&nbsp;</p>
    	<p>&nbsp; </p></td>
  </tr>
</table>
</form>

<div class="clear"></div>
</div>
<div class="clear"></div>
</div>
</div>

<?php $this->load->view('footer');?>
