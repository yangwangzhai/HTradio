<?php $this->load->view('header');?>
<script type="text/javascript" src="static/js/jplayer/jquery.jplayer.min.js"></script>
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
<style>
	.coutit em { color:red; }
	.find_title { padding-left:25px; }
  .find_list { height: auto;}
  .sum .files { float: left; }

.prolist dl { float: left; height: 100px; width: 280px; margin-bottom: 25px; }
.prolist dl dt { display: block; height: 100px; width: 100px; float: left; margin-right: 20px; }
.prolist dl dt img { height: 100px; width: 100px; }
.prolist dl dd { height: 100px; width: 160px; float: right; }
.prolist dl dd h1 { height: 24px; margin-bottom: 5px; font-size: 16px; font-weight: normal }
.prolist dl dd .details { color: #999 }
.prolist dl dd .num { height: 20px; margin: 4px 0 8px 0; }
.prolist dl dd .num a.icon {  width: 35px; height: 20px; line-height: 20px; padding-left: 15px; background: url(static/images/icon4.png) no-repeat left center; margin: 0 10px 0 0; }
.prolist dl dd .num a.icon1 { width: 35px; height: 20px; line-height: 20px; padding-left: 15px; background: url(static/images/icon5.png) no-repeat left center; }
.prolist dl dd .pbtn { height: 20px; }
.prolist dl dd .pbtn a.atten { display: block; height: 18px; line-height: 18px; padding-right: 6px; padding-left: 20px; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; border: 1px solid #ddd; background: url(static/images/cross.png) no-repeat 12% center; float: left; margin-right: 10px; }
.prolist dl dd .pbtn a.letter { display: block; height: 18px; line-height: 18px; width: 30px; padding-left: 20px; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; border: 1px solid #ddd; background: url(static/images/letter.png) no-repeat 12% center; float: left }

</style>
<div class="main">
    
  	<div>
	  	<div class="find_list">
        	<div class="find_title">
        		<div class="name">节目单</div>
        		<div class="coutit">
	        		<a href="">总共找到<?=count($me_list)?>个有关 <em><?=$keyword?></em> 的节目单</a>
	        	</div>
        	</div>
	        	
            <div class="find_pic">
                <?php foreach($me_list as $v) { ?>
            	<dl>
                  	<dt><a href="./index.php?c=player&meid=<?=$v['id']?>"><img src="<?php if(!empty($v['thumb'])){echo show_thumb( $v['thumb'] );}else{echo base_url()."uploads/default_images/default_programme.jpg";}?>" /></a></dt>
                  	<dd>
                    	<h3><a href="./index.php?c=player&meid=<?=$v['id']?>"><?=$v['title']?></a></h3>
                    	<p><a href="./index.php?c=zhubo&mid=<?=$v['mid']?>"><?=getNickName($v['mid'])?></a></p>
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
            </div>
        </div>
        <div class="find_list">
            <div class="find_title">
        		<div class="name">节目</div>
        		<div class="coutit">
	        		<a href="">总共找到<?=count($program_list)?>个有关 <em><?=$keyword?></em> 的节目单</a>
	        	</div>
        	</div>
	       	<div class="details_list">
		        <ul>
			        <?php foreach($program_list as $v) { ?>
			        <li data-id="<?=$v['id']?>">
			        <span><a href="javascript:;" class="c"></a>
			        <a href="javascript:;" class="d"></a>
			        <a href="javascript:;" class="e"></a>
			        <a href="javascript:;" class="f"></a></span>
			        <em><strong><?=$v['program_time']?$v['program_time']:'--:--'?></strong><strong><?=$v['playtimes']?>次播放</strong><strong><?=date('Y-m-d',$v['addtime'])?></strong></em>
			        <a href="./index.php?c=player&id=<?=$v['id']?>"><?=$v['title']?></a></li>
			        <?php } ?>
		        </ul>
		        <div class="page-navigator">
		            <div class="page-cont">
		                <div class="page-inner">
		                   	<?=$pages?>
		                </div>
		            </div>
		        </div>
			</div>
        </div>
        <div class="find_list">
        	<div class="find_title">
        		<div class="name">用户</div>
        		<div class="coutit">
        			<a href="">总共找到<?=count($member_list)?>个有关 <em><?=$keyword?></em> 的用户</a>
        		</div>
            
        	</div>
          <div class="prolist">
              <?php foreach($member_list as $r){?>
              <dl>
                  <dt><a href="./index.php?c=zhubo&mid=<?=$r['id']?>"><img src="<?php if(!empty($r['avatar'])){echo show_thumb( $r['avatar'] );}else{echo base_url()."uploads/default_images/default_avatar.jpg";}?>"/></a></dt>
                  <dd>
                      <h1><a href="./index.php?c=zhubo&mid=<?=$r['id']?>"><?=$r['nickname']?></a></h1>
                        <p style="color:#999"><?=$r['sign']?$r['sign']:'&nbsp;'?></p>
                        
                        <div class="num">
                            <a class="icon"><?=getProgramNum($r['id'])?></a>
                            <a class="icon1"><?=getFansNum($r['id'])?></a>
                        </div>
                      <div class="pbtn">
                             <?php if (is_attention($uid,$r['id'])){ ?>
                <a href="javascript:" onclick="attention_program(<?=$r['id']?>)" style="color:#ff6600;background-image:url(static/images/is_cross.png);" data-attention="1" id="programid<?=$r['id']?>" class="atten">已关注</a>
                <?php }else{  ?>
                <a href="javascript:" onclick="attention_program(<?=$r['id']?>)" data-attention="0" id="programid<?=$r['id']?>" class="atten">关注</a>
                <?php }?>
                            <a href="javascript:" onclick="message_dialog(<?=$r['id']?>,'<?=getNickName($r['id'])?>')" class="letter">私信</a>
                        </div>
                    </dd>
                </dl>
             <?php }?>

            </div>
          <div style="clear: both;"></div>
        </div>
	        
	</div>

<div id="cmplayer"></div><!--播放音频的flash隐藏窗口-->
<div class="music-wrap" id="jp_container_1">
    <div class="music-play">
        <div class="u-cover">
            <img src="<?=show_thumb($me_data['thumb'])?>" width="60px" height="60px">
        </div>
        <div class="u-infor">
            <div class="music-title jp-title"></div>
            <div class="u-control jp-progress">
                <div class="jp-seek-bar">
                    <div class="jp-play-bar"></div>
                </div>
            </div> 
            <div class="control jp-controls">
                <div class="rewind jp-previous"></div>
                <div class="play jp-play"></div>
                <div class="back jp-pause"></div>
                <div class="fastforward jp-next"></div>
            </div>
            <div class="u-time">
                <span class="jp-current-time"></span>/<span class="jp-duration"></span>
            </div>  
        </div>
    </div>
</div>

<?php $this->load->view('footer');?>