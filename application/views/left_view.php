<div class="radio_left">
      <div class="userwrap">
      	<div class="userface" onclick="setPhotos('<?=$zb['nickname']?>','<?=$_SESSION['uid']?>')">
          <img width="200" height="200" title="点击修改图片"   id="img" src="<?php if($zb['avatar']){echo show_thumb($zb['avatar']);}else{echo 'uploads/default_images/default_avatar.jpg';}?>" />
        </div>
        <div class="usertitle">
          <h1><?=$zb['nickname']?></h1>
        <div class="pbtn">
      
        	<a href="index.php?c=setting" >修改资料</a>&nbsp; 
       <?php if($_SESSION['th']!=1){ ?> <a href="index.php?c=setting&m=password" >修改密码</a><?php } ?>
        </div>
        </div>
        <div class="count">
                  
          <div>
              <a href="index.php?c=personal"><?=$program_num['num']?><span>节目</span></a>
          </div>
          <div>
              <a href="index.php?c=personal&m=allattention"><?=$guanzhu_num['num']?><span>关注</span></a>
          </div>
          <div class="none-border">
              <a href="index.php?c=personal&m=allfans"><?=$fans_num['num']?><span>粉丝</span></a>
          </div>
        </div>
    </div>
	<div class="title">我关注的人(<?=$guanzhu_num['num']?>)<a href="index.php?c=personal&m=allattention">/更多</a></div>
    <div class="attener">
    <?php foreach($guanzhu_list as $val) { ?>
    <dl>
        <dt><a href="index.php?c=zhubo&mid=<?=$val['id']?>"><img src="<?php if($val['avatar']){echo show_thumb($val['avatar']);}else{echo 'uploads/default_images/default_avatar.jpg';}?>" /></a></dt>
    </dl>
    <?php } ?>
    
    </div>
    <div class="title">我的粉丝(<?=$fans_num['num']?>)<a href="index.php?c=personal&m=allfans">/更多</a></div>
    <div class="attener">
    <?php foreach($fans_list as $val) { ?>
    <dl>
        <dt><a href="index.php?c=zhubo&mid=<?=$val['id']?>"><img src="<?php if($val['avatar']){echo show_thumb2($val['avatar']);}else{echo 'uploads/default_images/default_avatar.jpg';}?>" /></a></dt>
    </dl>
    <?php } ?>
    </div>

    <div class="title">我收藏的节目单(<?=$sc_num['num']?>)<a href="index.php?c=personal&m=allsc">/更多</a></div>
    <div class="ranklist">
        <?php foreach($sc_list as $k=>$val) { ?>
        <div class="tab" style="padding-left: 10px;border-bottom: 1px dotted #ddd;height: 30px;line-height: 30px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">
            <span>
                <img style="position: relative; top: 3px;" src="static/images/tea<?=$k+1?>.jpg">
            </span>
            <strong>
                <a href="index.php?c=player&meid=<?=$val['programme_id']?>"target="_blank"title="<?=$val['title']?>"><?=$val['title']?></a>
            </strong>
        </div>
        <?php } ?>
    </div>

    </div>
 