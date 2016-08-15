<?php foreach($result_comment as $comment_value) :?>
    <li cid="476820" class="bdb_e5">
        <a href="/u/2951814.html"><img class="fl user-pic" src="<?php if($comment_value['avatar']){echo show_thumb($comment_value['avatar']);}else{echo 'uploads/default_images/default_avatar.jpg';}?>" onerror="headSrc(event)"></a>
        <div class="fr c-sub">
            <p class="comment-t">
                <a href="/u/2951814.html"><?php echo $comment_value['nickname']?$comment_value['nickname']:$comment_value['username']?></a>
                <span class="fr"><?= date('Y-m-d H:i:s',$comment_value['addtime'])?></span>
            </p>
            <p class="clear-line word-break "><?php if(!empty($comment_value['replyed_name'])){echo "回复<a style='color: #0000FF;'>".$comment_value['replyed_name']."</a>"."：".$comment_value['content'];}else{echo $comment_value['content'];}?></p>
            <div class="c-operation">
                <a class="bd report">举报</a>
                <a class="bd zan" content="叶文，支持你" uid="2951814"><span>(0)</span></a>
                <?php if($mid!=$comment_value['mid']){?>
                    <a class="reply" style="cursor: pointer;" data-mid="<?=$mid?>">回复</a>
                <?php }else{?>
                    <a class="delete_comment" style="cursor: pointer;" data-id="<?=$comment_value['id']?>" data-mid="<?=$mid?>">删除</a>
                <?php }?>
            </div>
            <div class="c-sub reply-div hide" style="display: none;">
                <div class="bg_1 pl10 pb10 pt15">
                    <div contenteditable="true" class="emojiIpt clear-line ipt-overflow"  style="color: rgb(153, 153, 153);"></div>
                    <div class="face-div hidden">
                        <!-- <a class="fl face"></a>-->
                        <a style="cursor: pointer;" class="fr c-submit dis reply-submit" data-name="<?php echo $comment_value['nickname']?$comment_value['nickname']:$comment_value['username']?>" commenttype="1">回复</a>
                        <span class="fr iptLen">140</span>
                    </div>
                </div>
            </div>
        </div>
    </li>
<?php endforeach ?>
