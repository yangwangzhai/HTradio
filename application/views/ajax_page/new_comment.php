<?php foreach($result_comment as $comment_value) :?>
    <li cid="476820" class="bdb_e5">
        <a href="/u/2951814.html"><img class="fl user-pic" src="<?php if($comment_value['avatar']){echo show_thumb($comment_value['avatar']);}else{echo 'uploads/default_images/default_avatar.jpg';}?>" onerror="headSrc(event)"></a>
        <div class="fr c-sub">
            <p class="comment-t">
                <a href="/u/2951814.html"><?php echo $comment_value['nickname']?$comment_value['nickname']:$comment_value['username']?></a>
                <span class="fr"><?= date('Y-m-d H:i:s',$comment_value['addtime'])?></span>
            </p>
            <p class="clear-line word-break "><?=$comment_value['content']?></p>
            <div class="c-operation">
                <a class="bd report">举报</a>
                <a class="bd zan" content="叶文，支持你" uid="2951814"><span>(0)</span></a>
                <a class="reply">回复</a>
            </div>
        </div>
    </li>
<?php endforeach ?>
