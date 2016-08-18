<?php foreach($me_list as $v) { ?>
<dl>
  <dt><a href="./index.php?c=player&meid=<?=$v['id']?>"><img src="<?php if(!empty($v['thumb'])){echo show_thumb( $v['thumb'] );}else{echo base_url()."uploads/default_images/default_programme.jpg";}?>" /></a></dt>
  <dd>
      <h3 style="text-align: center;"><a href="./index.php?c=player&meid=<?=$v['id']?>"><?=$v['title']?></a></h3>
    <p style="text-align: center;"><a><?=getNickName($v['mid'])?></a></p>
  </dd>
</dl>
<?php } ?>
<div style="clear:both;"></div>
<div class="page-navigator">
    <div class="page-cont">
        <div class="page-inner">
            <?=$mpages?>
        </div>
    </div>
</div>
