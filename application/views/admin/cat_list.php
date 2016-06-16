<?php $this->load->view('admin/header');?>

<input type="button" value=" + 添加信息 " class="btn"
	onclick="location.href='index.php?d=admin&c=category&m=add'" />
<ul class="memlist category">
	<?=$tree?>
</ul>

<?php $this->load->view('admin/footer');?>