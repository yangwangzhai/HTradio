<?php $this->load->view('header');?>
<script type="text/javascript" src="static/js/jplayer/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="static/flowplayer/flowplayer-3.2.12.min.js"></script>
<script type="text/javascript" src="static/flowplayer/flowplayer.ipad-3.2.12.min.js"></script>
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
<style>
  .radio_title img{line-height:40px;vertical-align:middle;margin-left:10px;}
</style>
<div class="main">
	  <?php left_view();?>
  <div class="radio_right">
	  <div class="radio_list">
        	<div class="radio_title">我的节目单<!--a href="index.php?c=personal&m=addprogramme"><img src="static/images/notification_add.png"></a--></div>
            <div class="find_pic">
                <?php foreach($me_list as $v) { ?>
            	<dl>
                  <dt><a href="./index.php?c=player&meid=<?=$v['id']?>"><img src="<?php if(!empty($v['thumb'])){echo show_thumb( $v['thumb'] );}else{echo base_url()."uploads/default_images/default_programme.jpg";}?>" /></a></dt>
                  <dd>
                    <h3><a href="./index.php?c=player&meid=<?=$v['id']?>"><?=$v['title']?></a></h3>
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
        <div class="radio_title">我的节目</div>
       <div class="details_list" id="jp-playlist">
        <ul>
            <?php foreach($program_list as $k=>$v) { ?>
                <li data-id="<?=$v['id']?>">
                    <span>
                        <a href="" class="c"></a>
                        <a href="" class="d"></a>
                        <a href="" class="e"></a>
                        <a href="" class="f"></a>
                        <a href="index.php?c=upload&m=edit_audio&id=<?=$v['id']?>" title="编辑" class="edit"></a>
                    </span>
                    <em><strong><?=$v['program_time']?$v['program_time']:'--:--'?></strong><strong><?=$v['playtimes']?>次播放</strong><strong><?=date('Y-m-d',$v['addtime'])?></strong></em>
                    <b><?=$v['title']?></b>
                    <a style="display: block; width: 300px; height: 25px;float: left;margin-top: 10px;" id="flashls_vod<?=$k?>"></a>
                    <script type="text/javascript">
                        flowplayer("flashls_vod<?=$k?>", "static/flowplayer/flowplayer.swf", {
                            plugins: {
                                flashls: {
                                    url: 'static/flowplayer/flashlsFlowPlayer.swf',
                                }
                            },
                            clip: {
                                url: "<?=$v['path']?>",
                                //live: true,
                                autoPlay:false,
                                urlResolvers: "flashls",
                                provider: "flashls"
                            }
                        }).ipad();
                    </script>
                </li>
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
<!--播放音频的flash隐藏窗口-->
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
    //ready begin
    $(document).ready(function(){
        $('#jp-playlist li span').bind('click',function(){
		 		$.dialog({
					id: 'LHG76D',
					title: '请扫描下载APP，在APP上面操作！',		
					content: '<img src="./static/images/android_ewm.png"  />',			
					min: false,
					max: false,
					padding:0,	
					margin:0		
				});
				  return false;
		   })

        $('#jp-playlist .edit').bind('click',function(){
		  		var href = $(this).attr('href');
				 location.href = href;
				 return false;
		   })

        $('.ajax_fpage').live('click', function(eve){
            eve.preventDefault();       
                 
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
                        $('li[data-id='+curr+']').addClass('curr').css({background:'url("static/images/pause.png") no-repeat scroll 1% center'}).siblings().css({background:''});
                        mouseover_event();
               }
            });        
         });   

        $('.ajax_mpage').live('click', function(eve){
            eve.preventDefault();       
                 
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
                  //    offset:offset,  
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
          $(this).siblings().css({backgroundImage:''});
          addPtimes(id);
        });

        $('.jp-next').click(function(){
            next();
        });

        $('.jp-previous').click(function(){
            previous();
        }) 
    }); /*end ready*/

    var curr = null;

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