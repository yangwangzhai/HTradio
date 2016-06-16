<?php $this->load->view('header');?>
<script type="text/javascript" src="static/js/jplayer/jquery.jplayer.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
   mouseover_event();
});
function mouseover_event(){
    $(".details_list ul li").mouseover(function(){
      $(this).addClass("current");
    });
  $(".details_list ul li").mouseout(function(){
      $(this).removeClass("current");

  }); 
}
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
              <a href="javascript:;"><?=$program_num['num']?><span>节目</span></a>
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
	  <div class="radio_list">
        	<div class="radio_title">Ta的节目单</div>
            <div class="find_pic">
                <?php foreach($me_list as $v) { ?>
            	<dl>
                  <dt><a href="./index.php?c=player&meid=<?=$v['id']?>"><img src="<?=show_thumb( $v['thumb'] )?>" /></a></dt>
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
            </div>
        </div>
        <div class="radio_title">Ta的节目</div>
       <div class="details_list" id="jp-playlist">
        <ul>
        <?php foreach($program_list as $v) { ?>
        <li data-id="<?=$v['id']?>">
        <span><a href="" class="c"></a>
        <a href="" class="d"></a>
        <a href="" class="e"></a>
        <a href="" class="f"></a>       
        </span>
        <em><strong><?=$v['program_time']?$v['program_time']:'--:--'?></strong><strong><?=$v['playtimes']?>次播放</strong><strong><?=date('Y-m-d',$v['addtime'])?></strong></em>
        <b><?=$v['title']?></b></li>
        <?php } ?>
        
        </ul>
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
<script>
    $(document).ready(function(){    	
		 
		   $('#jp-playlist li span').bind('click',function(){			
			  return false;
		   })
		
        $('.ajax_fpage').live('click', function(eve){
            eve.preventDefault();       //屏蔽当前a标签的默认动作：
                 
            var mid=<?=$mid?>;      
            var href=$(this).attr("href");    
            var arr=href.split('per_page=');  
            if(arr[1]==''){arr[1]=1;}     
            var per_page=arr[1];
            
            var offset=arr[1];              
            $.ajax({
              url:"index.php?c=zhubo&m=program_page",
              type:"get",
              dataType:"text",
              data: {
                  
                      'mid':mid, 
                      'per_page':per_page //当前第几页，用于生成分页
              },
               success: function(html) {
                        $('.details_list').html(html);
                        $('li[data-id='+curr+']').addClass('curr').css({backgroundImage:'url("static/images/pause.png")'}).siblings().css({backgroundImage:''});
                        mouseover_event();
               }
            });        
         });   

        $('.ajax_mpage').live('click', function(eve){
            eve.preventDefault();       //屏蔽当前a标签的默认动作：
                 
            var mid=<?=$mid?>;     
            var href=$(this).attr("href");    
            var arr=href.split('per_page=');  
            if(arr[1]==''){arr[1]=1;}     
            var per_page=arr[1];
            
            var offset=arr[1];              
            $.ajax({
              url:"index.php?c=zhubo&m=programme_page",
              type:"get",
              dataType:"text",
              data: {
                  
                      'mid':mid, 
                      'mper_page':per_page //当前第几页，用于生成分页
              },
               success: function(html) {
                        $('.find_pic').html(html);
               }
            });        
         });  

        $('#jp-playlist li').live('click',function(){
          var id = $(this).attr('data-id');
          geturl(id);
          curr = id;
          $(this).addClass('curr').siblings().removeClass('curr');
          $(this).css({backgroundImage:'url("static/images/pause.png")'});
          $(this).siblings().css({backgroundImage:''})
          addPtimes(id);
        });

        $('.jp-next').click(function(){
            next();
        });

        $('.jp-previous').click(function(){
            previous();
        }) 
    });
var curr = null;
var player = $("#cmplayer").jPlayer({
    
    ended:function(event) {
        next();
        
    },
    play:function(event){
        
        $('#jp_container_1').show();

    },
    pause:function(event){
        
    },

    error:function(event){
        if(event.jPlayer.error.type == 'e_url' || event.jPlayer.error.type == 'e_url_not_set') {
            $('#jp_container_1').show();
            $('.jp-title').eq(0).html('<span style="color:red;">音频文件加载失败</span>');
        }
    },
    swfPath: "static/js/jplayer",
    supplied: "m4a, mp3",
    solution: 'flash,html',
    wmode: "window",
    useStateClassSkin: true,
    autoBlur: false,
    smoothPlayBar: true,
    keyEnabled: true,
    toggleDuration: true
});

function geturl(id){
    $.ajax({
        url:'index.php?c=player&m=getUrl&id='+id,
        type:'get',
        dataType:'json',
        success:function(res){
            player.jPlayer("setMedia",res).jPlayer('play');
        }
    });
}

function next() {
    $.ajax({
      url: 'index.php?c=player&m=next_one&curr='+curr+'&mid=<?=$mid?>',
      type: 'get',
      dataType: 'json',
      success: function(res){
        if(res) {
          curr = res.id;
          player.jPlayer("setMedia",res.list).jPlayer('play');
          $('li[data-id='+res.id+']').addClass('curr').css({backgroundImage:'url("static/images/pause.png")'});
          $('li[data-id!='+res.id+']').removeClass('curr').css({backgroundImage:''});
          addPtimes(curr);
        }
        
      }
    });
    
    return true;
}

function previous() {
    $.ajax({
      url: 'index.php?c=player&m=prev_one&curr='+curr+'&mid=<?=$mid?>',
      type: 'get',
      dataType: 'json',
      success: function(res){
        if(res) {
          curr = res.id;
          player.jPlayer("setMedia",res.list).jPlayer('play');
          $('li[data-id='+res.id+']').addClass('curr').css({backgroundImage:'url("static/images/pause.png")'});
          $('li[data-id!='+res.id+']').removeClass('curr').css({backgroundImage:''});
          addPtimes(curr);
        }
        
      }
    });
    
    return true;
}



function addPtimes(id) {
    if(id){
        var times = parseInt($('.dbtn').eq(0).next('span').text());
        $.ajax({
            url: 'index.php?c=ajax&m=addPlayTimes',
            type: 'post',
            data: 'id='+id,
            success:function(res) {
                if(res == '0'){
                    if($('.curr').attr('data-id') == undefined) {
                        $('.dbtn').eq(0).next('span').text(times+1);
                    }
                    
                }
            }
        });
    }
}

</script>
<?php $this->load->view('footer');?>