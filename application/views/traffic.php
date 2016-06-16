<?php $this->load->view('header');?>

<div class="clear"></div>
<div class="content_box">
<div class="road">
<div class="road_body">
<h3>
<span class="gf <?php if($_GET[groupid]==3){echo 'current';}?>"><a href="index.php?c=front&m=traffic&groupid=3">官方路况</a></span>
<span class="ly <?php if($_GET[groupid]==0){echo 'current';}?>"><a href="index.php?c=front&m=traffic&groupid=0">网友路况</a></span>
</h3>
<div class="road_r">
<div class="wp">
	<ul id="slider" class="slider">
	<?php foreach($list as $value):?>
		<li><a class="fl" ><img src="<?=$value[avatar]?>"  align="left"/></a>
		<p><strong><?=$value[nickname]?>：</strong><?=$value[title]?></p>
        <p><span><?=$value[addtime]?></span></p>
	    </li>
	<?php endforeach;?>
	</ul>
</div>
</div>
<div class="road_r" style="display:none">
<div class="wp">
	<ul id="slider" class="slider">
	
	<?php foreach($list as $value):?>
		<li><a class="fl" ><img src="<?=$value[thumb]?>"  align="left"/></a>
		<p><strong><?=$value[nickname]?>：</strong><?=$value[title]?></p>
        <p><span><?=$value[addtime]?></span></p>
	    </li>
	<?php endforeach;?>
	
		
		
	</ul>
</div>
</div>
<script type="text/javascript">	
$(".road_body").viTab({	
tabTime : 4000,
tabScroll : 0,
tabEvent : 0
});
</script>
</div>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>
</div>

<?php $this->load->view('footer');?>