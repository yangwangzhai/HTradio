<?php $this->load->view('header');?>
<script type="text/javascript">
$(document).ready(function(){
  $(".details_list ul li").mouseover(function(){
    $(this).addClass("current");
  });
$(".details_list ul li").mouseout(function(){
    $(this).removeClass("current");
  });
});
</script>

<div class="main">
    <div class="radio_left">
      <div class="userwrap">
      	<div class="userface">
          <img width="200" height="200" src="<?=show_thumb($zb['avatar'])?>" />
        </div>
        <div class="usertitle">
          <h1><?=$zb['nickname']?></h1>
        <div class="pbtn">
      
        
          <?php if ($is_attention){ ?>
            <a href="javascript:" onclick="attention(<?=$mid?>)" style="width:45px;color:#ff6600; background-image:url(static/images/is_cross.png)" data-attention="1" id="zid<?=$mid?>" class="atten zhubo">已关注</a>
            <?php }else{  ?>
            <a href="javascript:" onclick="attention(<?=$mid?>)" data-attention="0" id="zid<?=$mid?>" class="atten zhubo">关注</a>
            <?php }?>
        
          <a href="javascript:" onclick="message_dialog(<?=$mid?>,'<?=getNickName($mid)?>')" class="letter">私信</a></div>
        </div>
        <div class="count">
                  
          <div>
              <a href="index.php?c=zhubo&mid=<?=$mid?>"><?=$program_num['num']?><span>节目</span></a>
          </div>
          <div>
              <a href="index.php?c=zhubo&m=allattention&mid=<?=$mid?>"><?=$guanzhu_num['num']?><span>关注</span></a>
          </div>
          <div class="none-border">
              <a href="index.php?c=zhubo&m=allfans&mid=<?=$mid?>"><?=$fans_num['num']?><span>粉丝</span></a>
          </div>
        </div>
    </div>
	<div class="title">Ta关注的人(<?=$guanzhu_num['num']?>)<a href="index.php?c=zhubo&m=allattention&mid=<?=$mid?>">/更多</a></div>
    <div class="attener">
    <?php foreach($guanzhu_list as $val) { ?>
    <dl>
        <dt><a href="index.php?c=zhubo&mid=<?=$val['id']?>"><img src="<?=show_thumb( $val['avatar'] )?>" /></a></dt>
    </dl>
    <?php } ?>
    
    </div>
    <div class="title">Ta的粉丝(<?=$fans_num['num']?>)<a href="index.php?c=zhubo&m=allfans&mid=<?=$mid?>">/更多</a></div>
    <div class="attener">
    <?php foreach($fans_list as $val) { ?>
    <dl>
        <dt><a href="index.php?c=zhubo&mid=<?=$val['id']?>"><img src="<?=show_thumb( $val['avatar'] )?>" /></a></dt>
    </dl>
    <?php } ?>
    
    </div>
    </div>
  	<div class="radio_right">
        <div class="radio_title"><?=$title?>(<?=$count?>)</div>
        <div class="fans_list">
        	<?php foreach($list as $v) { ?>
        	<dl>
            	<dt><a href="index.php?c=zhubo&mid=<?=$v['id']?>"><img src="<?=show_thumb($v['avatar'])?>" /></a></dt>
              <dd>
                	<h1><a href="index.php?c=zhubo&mid=<?=$v['id']?>"><?=$v['nickname']?></a></h1>
                    <p style="color:#999"><?=$v['sign']?></p>
                    
                <div class="num"><a href="index.php?c=zhubo&mid=<?=$v['id']?>" class="icon"><?=getProgramNum($v['id'])?></a><a href="index.php?c=zhubo&m=allfans&mid=<?=$v['id']?>" class="icon1"><?=getFansNum($v['id'])?></a></div>
                <div class="pbtn">
                	
                	<?php if (is_attention($uid , $v['id'])){ ?>
			            <a href="javascript:" onclick="attention(<?=$v['id']?>)" style="width:45px;color:#ff6600; background-image:url(static/images/is_cross.png)" data-attention="1" id="zid<?=$v['id']?>" class="atten zhubo">已关注</a>
			            <?php }else{  ?>
			            <a href="javascript:" onclick="attention(<?=$v['id']?>)" data-attention="0" id="zid<?=$v['id']?>" class="atten zhubo">关注</a>
			            <?php }?>
			        
			          <a href="javascript:" onclick="message_dialog(<?=$v['id']?>,'<?=getNickName($v['id'])?>')" class="letter">私信</a>
                </div>
                </dd>
            </dl>
            <?php } ?>
        </div>     
       
	    <div class="page-navigator">
	        <div class="page-cont">
	            <div class="page-inner">
                <?=$pages?>
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
    </div>
</div>

<?php $this->load->view('footer');?>