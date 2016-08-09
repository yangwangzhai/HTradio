<ul>
    <?php foreach($program_list as $k=>$v) { ?>
        <li style="padding-left: 0;">
                            <span>
                                <!--<a data-meid="<?/*=$meid*/?>" data-id="<?/*=$val['id']*/?>" href="javascript:void(0);" class="c"></a>-->
                                <!--<a data-meid="<?/*=$meid*/?>" data-id="<?/*=$val['id']*/?>" href="javascript:void(0);" class="d"></a>-->
                                <!--<a data-meid="<?/*=$meid*/?>" data-id="<?/*=$val['id']*/?>" href="javascript:void(0);" class="e"></a>-->
                                <a  data-title="<?=$v['title']?>" data-download-path="<?=$v['download_path']?>" href="javascript:void(0);" class="f"></a>
                                <a  data-id="<?=$v['id']?>" href="javascript:void(0);" class="g"></a>
                            </span>
            <em>
                <strong><?=$v['program_time']?$v['program_time']:'--:--'?></strong>
                <strong><?=$v['playtimes']?>次播放</strong>
                <strong><?=date('Y-m-d',$v['addtime'])?></strong>
            </em>
            <img class="playmenu" data-id="<?=$v['id']?>" data-title="<?=$v['title']?>" data-thumb="<?=$v['thumb']?>" data-url="<?=$v['path']?>" data-flag="0" src="static/images/playbox.png" style="display: inline-block;padding-right: 5px; position: relative; top: 3px;">
            <b class="program_detail" data-id="<?=$v['id']?>"><?=$v['title']?></b>
        </li>
    <?php } ?>
</ul>
<div class="page-navigator">
        <div class="page-cont">
            <div class="page-inner">
               <?=$pages?>    
             </div>
        </div>
</div>