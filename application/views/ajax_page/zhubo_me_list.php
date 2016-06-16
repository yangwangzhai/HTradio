<?php foreach($me_list as $v) { ?>
<dl>
  <dt><a href="./index.php?c=player&meid=<?=$v['id']?>"><img src="<?=show_thumb($v['thumb'])?>" /></a></dt>
  <dd>
    <h3><a href="./index.php?c=player&meid=<?=$v['id']?>" title="<?=$v['title']?>"><?=str_cut($v['title'],28)?></a></h3>
    <p><a><?=getNickName($v['mid'])?></a></p>
  </dd>
</dl>
<?php } ?>
<div style="clear:both;"></div>
<div class="page-navigator">
    <div class="page-cont">
        <div class="page-inner">
            <?=$mpages?>
            <div style="display:none;">
                <span class="page-item page-navigator-prev-disable">上一页</span>
                <span class="page-item page-navigator-current">1</span><a href="#" class="page-item">2</a>
                <a href="#" class="page-item">3</a>
                <a href="#" class="page-item">4</a>
                <a href="#" class="page-item">5</a>
                <a href="#" class="page-item">6</a>
                <a href="#" class="page-item">7</a>
                <a href="#" class="page-item">8</a>
                <a href="#" class="page-item">9</a>
                <span class="page-navigator-dots">...</span>
                <a class="page-item page-navigator-number PNNW-D" href="#">550</a>
                <a href="#" class="page-item page-navigator-next">下一页</a>
            </div>
        </div>
    </div>
</div>