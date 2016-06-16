<?php $this->load->view('admin/header');?>

<h3 class="marginbot">更新缓存：</h3>

<ul class="memlist">
	<?php foreach($list as $value): ?>	
	<li>· <?=$value?></li>
	<?php endforeach; ?>	
</ul>

<input type="submit" name="submit" value=" 更新 " class="btn" onclick="location.href='index.php?d=admin&c=cache&m=save'">

<?php $this->load->view('admin/footer');?>