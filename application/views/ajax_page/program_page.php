<div class="prolist">
    <?php foreach($program_list as $r){?>
        <dl>
            <dt><a href="./index.php?c=player&id=<?=$r['id']?>"><img src="<?php if(!empty($r['thumb'])){echo show_thumb( $r['thumb'] );}else{echo base_url()."uploads/default_images/default_jiemu2.jpg";}?>" /></a></dt>
            <dd>
                <h1><a href="./index.php?c=player&id=<?=$r['id']?>" title="<?=$r['title']?>"><?=str_cut($r['title'],30)?></a></h1>
                <p style="color:#999;"><?=$r['description']?str_cut($r['description'],50,'...'):'&nbsp;'?></p>
                <p>上传者：<a target="_blank"  href="./index.php?c=zhubo&mid=<?=$r['mid']?>"><?=getNickName($r['mid'])?></a></p>
                <div class="num">
                    <a href="./index.php?c=player&id=<?=$r['id']?>" class="icon"><?=$r['playtimes']?></a>
                    <a id="icon1_<?=$r['id']?>" class="icon1"><?=$r['fav_count']?></a>
                </div>
                <div class="pbtn">
                    <?php if ($r['is_program_data']){ ?>
                        <a href="javascript:" onclick="attention_program(<?=$r['id']?>)" style="color:#ff6600;background-image:url(static/images/is_cross.png);" data-attention="1" id="programid<?=$r['id']?>" class="atten">已关注</a>
                    <?php }else{  ?>
                        <a href="javascript:" onclick="attention_program(<?=$r['id']?>)" data-attention="0" id="programid<?=$r['id']?>" class="atten">关注</a>
                    <?php }?>
                    <a href="javascript:" onclick="message_dialog(<?php if($uid){echo 1;}else{echo 0;}?>,<?=$r['mid']?>,'<?=getNickName($r['mid'])?>')" class="letter">私信</a>
                </div>
            </dd>
        </dl>
    <?php }?>
</div>
<!--分页-->
<div class="page-navigator" style="float: left;">
    <div class="page-cont">
        <div class="page-inner">
            <?=$pages?>
        </div>
    </div>
</div>