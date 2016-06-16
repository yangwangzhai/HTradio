<ul>
<?php foreach($program_list as $v) { ?>
<li data-id="<?=$v['id']?>">
<span><a href="" class="c"></a>
<a href="" class="d"></a>
<a href="" class="e"></a>
<a href="" class="f"></a>
<a href="index.php?c=upload&m=edit_audio&id=<?=$v['id']?>" title="编辑" class="edit"></a>
</span>
<em><strong><?=$v['program_time']?$v['program_time']:'--:--'?></strong><strong><?=$v['playtimes']?>次播放</strong><strong><?=date('Y-m-d',$v['addtime'])?></strong></em>
<b><?=$v['title']?></b></li>
<?php } ?>

</ul>
<div class="page-navigator">
        <div class="page-cont">
            <div class="page-inner">
               <?=$pages?>    
             </div>
        </div>
</div>