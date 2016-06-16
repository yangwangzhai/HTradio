<?php $this->load->view('header');?>

<div class="main">
		<div class="slideTxtBox">
			<div class="hd">
		    <ul><li>节目收听榜</li><li>电台收听榜</li></ul>
			</div>
			<div class="bd">
				<ul>
                <?php foreach($program_list as $k=>$r){ $k++;
				$color = '';
				if($k == 1){$color = '#bf0000';}else if($k == 2){$color = '#ff4e00';}else if($k == 3){$color = '#ffa200';} ?>
					<li>
                   	  <div class="numbers" style="color:<?=$color?>"><?=$k?></div>
                      <div class="picture"><a href="index.php?c=player&id=<?=$r['id']?>"><img src="<?=show_thumb($r['thumb'])?>" /></a></div>
                      <div class="informat">
                        	<h1><a href="index.php?c=player&id=<?=$r['id']?>"><?=$r['title']?></a></h1>
                            <p><a href="index.php?c=zhubo&mid=<?=$r['mid']?>"><?=getNickName($r['mid'])?></a></p>
                        </div>
                        <div class="button"><a href="index.php?c=player&id=<?=$r['id']?>">立即收听</a></div>
                  </li>				
                 <?php }?>
				</ul>
                
				<ul>
					<ul>
                <?php foreach($radio_list as $k=>$r){ $k++;
				$color = '';
				if($k == 1){$color = '#bf0000';}else if($k == 2){$color = '#ff4e00';}else if($k == 3){$color = '#ffa200';} ?>
					<li>
                   	  <div class="numbers" style="color:<?=$color?>"><?=$k?></div>
                      <div class="picture"><a href="./index.php?c=zhubo&mid=<?=$r['mid']?>"><img title="<?=$r['avatar']?>" src="<?=show_thumb($r['avatar'])?>" /></a></div>
                      <div class="informat">
                        	<h1><a  target="_blank"  href="./index.php?c=zhubo&mid=<?=$r['mid']?>"><?=$r['nickname']?></a></h1>
                        </div>
                        <div class="button"><a href="./index.php?c=zhubo&mid=<?=$r['mid']?>">立即收听</a></div>
                  </li>
	 			<?php }?>
				</ul>
				</ul>
				<script type="text/javascript">jQuery(".slideTxtBox").slide();</script>
			</div>
    </div>
    <div class="find_right">
    <div class="chat"><a href="#"><img src="static/images/chat.png" /></a></div>
      <div class="title">新晋飙升榜<!--a href="#">/更多</a--></div>
      <div class="ranklist">
        <?php foreach ($new_top_list as $k => $val) { ?>
          <div class="tab"> <span><img src="static/images/tea<?=$k+1?>.jpg" /></span> <strong><a href="index.php?c=player&id=<?=$val['id']?>" target="_blank" title="<?=$val['title']?>"><?=str_cut($val['title'],35)?></a></strong> </div>
        <?php } ?>

          
       </div>
      <div class="title">热播排行榜<!--a href="#">/更多</a--></div>
      <div class="ranklist">
        <?php foreach ($hot_top_list as $k => $val) { ?>
          <div class="tab"> <span><img src="static/images/tea<?=$k+1?>.jpg" /></span> <strong><a href="index.php?c=player&meid=<?=$val['id']?>" target="_blank" title="<?=$val['title']?>"><?=str_cut($val['title'],35)?></a></strong> </div>
        <?php } ?>
          
       </div>
       <div class="title">人气排行榜<!--a href="#">/更多</a--></div>
      <div class="ranklist">
        <?php foreach ($popularity_list as $k => $val) { ?>
          <div class="tab"> <span><img src="static/images/tea<?=$k+1?>.jpg" /></span> <strong><a href="index.php?c=player&id=<?=$val['id']?>" target="_blank" title="<?=$val['title']?>"><?=str_cut($val['title'],35)?></a></strong> </div>
        <?php } ?>
          
       </div>
    </div>
</div>

<?php $this->load->view('footer');?>
