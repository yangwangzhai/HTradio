
<?php $this->load->view('admin/header');?>

<div class="container">
<div class="mainbox">

<iframe name="iftest" width="700" frameborder="1" height="400" src="#"></iframe>

<form action="index.php?d=weixin&c=wxtest&m=wxtest_check" method="post" target="iftest">
<div>
<input name="sendtext" type="text" class="txt" style="width:450px; margin-top:10px;" value="" size="60" />
<input type="submit" name="submit" value=" 发送 " class="btn" tabindex="3" />	 
</form>
</div>

</div>
</body>
</html>
