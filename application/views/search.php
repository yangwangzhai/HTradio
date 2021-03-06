<?php $this->load->view('header');?>
<script type="text/javascript" src="static/flowplayer/flowplayer-3.2.12.min.js"></script>
<script type="text/javascript" src="static/flowplayer/flowplayer.ipad-3.2.12.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    //异步删除节目
    $(".g").live("click", function () {
        //var meid = $(this).attr("data-meid");
        var id = $(this).attr("data-id");
        var com = confirm("确定要删除该节目？");
        if(com){
            $(this).parent().parent().addClass("active");
            $.ajax({
                url:"index.php?c=personal&m=delete_personal_progarm",
                type: "post",         //数据发送方式
                dataType:"json",    //接受数据格式
                data:{id:id},  //要传递的数据
                success:function(data){
                    if(data){
                        $(".active").remove();
                    }else{
                        alert("删除失败");
                    }
                },
                error:function(XMLHttpRequest, textStatus, errorThrown)
                {
                    //alert(errorThrown);
                }
            });
        }
    });
    //下载
    $(".f").live("click",function(){
        var download_path = $(this).attr("data-download-path");
        var title = $(this).attr("data-title");
        location.href="index.php?c=personal&m=download&download_path="+download_path+"&title="+title;
    });

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
            	<dl style="width: 162px;height: 210px;margin: 30px 0 0 30px;">
                  	<dt style="width: 162px;height: 162px;">
                        <a href="./index.php?c=player&meid=<?=$v['id']?>">
                            <img style="width: 162px;height: 162px;" src="<?php if(!empty($v['thumb'])){echo show_thumb( $v['thumb'] );}else{echo base_url()."uploads/default_images/default_programme.jpg";}?>" />
                        </a>
                    </dt>
                  	<dd>
                    	<h3 style="text-align: center;">
                            <a href="./index.php?c=player&meid=<?=$v['id']?>"><?=$v['title']?></a>
                        </h3>
                    	<p style="text-align: center;">
                            <a href="./index.php?c=zhubo&mid=<?=$v['mid']?>"><?=getNickName($v['mid'])?></a>
                        </p>
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
	        		<a href="">总共找到<?=count($program_list)?>个有关 <em><?=$keyword?></em> 的节目</a>
	        	</div>
        	</div>
	       	<div class="details_list">
		        <ul>
			        <?php foreach($program_list as $v) { ?>
			        <li data-id="<?=$v['id']?>" style="padding-left: 0px;">
			        <span>
                        <a href="javascript:;" class="c"></a>
			            <a href="javascript:;" class="d"></a>
			            <a href="javascript:;" class="e"></a>
			            <a href="javascript:;" class="f"></a>
                    </span>
			            <em>
                            <strong><?=$v['program_time']?$v['program_time']:'--:--'?></strong>
                            <strong><?=$v['playtimes']?>次播放</strong>
                            <strong><?=date('Y-m-d',$v['addtime'])?></strong>
                        </em>
                        <img class="playmenu" data-id="<?=$v['id']?>" data-title="<?=$v['title']?>" data-thumb="<?=$v['thumb']?>" data-url="<?=$v['path']?>" data-flag="0" src="static/images/playbox.png" style="display: inline-block;padding-right: 5px; position: relative; top: 3px;">
                        <b class="program_detail" data-id="<?=$v['id']?>"><a href="index.php?c=player&m=index&id=<?=$v['id']?>" target="-_blank"><?=$v['title']?></a></b>
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
                  <dt>
                      <a href="./index.php?c=zhubo&mid=<?=$r['id']?>">
                          <img src="<?php if(!empty($r['avatar'])){echo show_thumb( $r['avatar'] );}else{echo base_url()."uploads/default_images/default_avatar.jpg";}?>"/>
                      </a>
                  </dt>
                  <dd>
                      <h1>
                          <a href="./index.php?c=zhubo&mid=<?=$r['id']?>"><?=$r['nickname']?></a>
                      </h1>
                        <p style="color:#999"><?=$r['sign']?$r['sign']:'&nbsp;'?></p>
                        <div class="num">
                            <a class="icon"><?=getProgramNum($r['id'])?></a>
                            <a class="icon1"><?=getFansNum($r['id'])?></a>
                        </div>
                      <div class="pbtn">
                             <?php if (is_attention($uid,$r['id'])){ ?>
                                 <a href="javascript:" onclick="attention2(<?=$r['id']?>)" data-attention="1" style=" color:#ff6600;" id="zid<?=$r['id']?>" class="ison">已关注</a>
                <?php }else{  ?>
                                 <a href="javascript:" onclick="attention2(<?=$r['id']?>)" data-attention="0" id="zid<?=$r['id']?>">关注</a>
                <?php }?>
                            <a href="javascript:" onclick="message_dialog(<?php if($uid){echo 1;}else{echo 0;}?>,<?=$r['id']?>,'<?=getNickName($r['id'])?>')" class="letter">私信</a>
                        </div>
                    </dd>
                </dl>
             <?php }?>
          </div>
          <div style="clear: both;"></div>
        </div>
	</div>

    <script>
        //ready begin
        $(document).ready(function(){
            var curr = '';
            $('.ajax_fpage').live('click', function(eve){
                eve.preventDefault();
                var keyword = '<?=$keyword?>';
                var href=$(this).attr("href");
                var arr=href.split('per_page=');
                if(arr[1]==''){arr[1]=1;}
                var per_page=arr[1];
                var offset=arr[1];
                $.ajax({
                    url:"index.php?c=search&m=program_page",
                    type:"get",
                    dataType:"text",
                    data: {
                        'keyword':keyword,
                        'per_page':per_page //当前第几页，用于生成分页
                    },
                    success: function(html) {
                        $('.details_list').html(html);
                        $('li[data-id='+curr+']').addClass('curr').css({background:'url("static/images/pause.png") no-repeat scroll 1% center'}).siblings().css({background:''});
                    }
                });
            });

            $('.ajax_mpage').live('click', function(eve){
                eve.preventDefault();
                var keyword = '<?=$keyword?>';
                var href=$(this).attr("href");
                var arr=href.split('per_page=');
                if(arr[1]==''){arr[1]=1;}
                var per_page=arr[1];
                var offset=arr[1];
                $.ajax({
                    url:"index.php?c=search&m=programme_page",
                    type:"get",
                    dataType:"text",
                    data: {
                        //    offset:offset,
                        'keyword':keyword,
                        'mper_page':per_page //当前第几页，用于生成分页
                    },
                    success: function(html) {
                        //alert(html);
                        $('.find_pic').html(html);
                    }
                });

            });


        }); /*end ready*/

    </script>

    <div class="link">
        <div class="link_title">友情链接</div>
        <div class="link_con">
            <?php
            $this->db->order_by("id", "desc");
            $query_top = $this->db->get_where('fm_link', array());
            $list = $query_top->result_array();
            foreach($list as $r){
                ?>
                <a href="<?=$r['url']?>"><?=$r['name']?></a>
            <?php }?>
        </div>
    </div>
    <div class="footer" style="height: 120px;">
        <div class="fmain">
            <div class="copyright">
                <p>版权所有 2004-2014 未经广西人民广播电台 同意请勿转载</p>
                <p> 信息网络传播视听节目许可证号:2005125　桂ICP备05004840</p>
                <p> 广西网警备案号：45010302000046　互联网新闻信息服务备案许可证：4510020100001</p>
                <p> Copyright © 2009-2014 GuangXi people's Broadcasting Station, All Rights Reserved </p>
            </div>
            <div class="about">
                <div class="ftitle">&nbsp;&nbsp;关于我们</div>
                <p><img src="static/images/about.png" usemap="#Map" border="0" />
                    <map name="Map" id="Map">
                        <area shape="rect" coords="2,7,50,80" href="#" />
                        <area shape="rect" coords="64,7,110,80" href="#" />
                        <area shape="rect" coords="125,7,170,80" href="#" />
                        <area shape="rect" coords="184,7,230,80" href="#" />
                    </map>
                </p>
            </div>
            <!--<div class="service">
                 <div class="ftitle">客服中心</div>
                <p>400-8888-910</p>
              <div class="ftitle">客服邮箱</div>
                <p>4008888910@nawaa.com</p>
            </div>-->
        </div>
    </div>
    <div id="play_box" style="display: none;width: 100%;height:50px;background-color: #aedaff;">
        <!--<div style="width: 800px;">
        <h6 style="color: #6A6AFF;line-height: 46px; text-align: center;">私家车上班路上<?/*=$list[0]['title']*/?></h6>
    </div>-->
        <!--flowplayer代码开始-->
        <a style="display: block; margin: 0 auto; padding-top: 20px; width: 800px; height: 25px;" id="flashls_vod"></a>
        <!--flowplayer代码结束-->
    </div>
    <script type="text/javascript">

        $(".playmenu").live("click",function(){
            $("#play_box").show();
            var id="flashls_vod";
            var url=$(this).attr("data-url");
            var pid=$(this).attr("data-id");
            var flag=$(this).attr("data-flag");
            if(flag==0){
                $.ajax({
                    url: 'index.php?c=index&m=playtimes',
                    type: 'post',
                    dataType:'json',
                    data: {pid:pid},
                    success:function(data) {
                        //alert(data);
                    }
                });
                fplayer(id,url,pid);
                var title=$(this).attr("data-title");
                $("#header h2").text(title);
                $(".playmenu").attr("src","static/images/playbox.png");
                $(this).attr("src","static/images/pause.png");
                $(this).attr("data-flag","1");
            }else{
                flowplayer(id, "static/flowplayer/flowplayer.swf", {
                    // configure the required plugins
                    plugins: {
                        flashls: {
                            url: 'static/flowplayer/flashlsFlowPlayer.swf'
                        },
                        controls:{
                            autoHide: false, //功能条是否自动隐藏
                            tooltips: {
                                buttons: true,//是否显示
                                fullscreen: '全屏',//全屏按钮，鼠标指上时显示的文本
                                stop:'停止',
                                play:'开始',
                                volume:'音量',
                                mute: '静音',
                                next:'下一个',
                                previous:'上一个'
                            }
                        }
                    },
                    clip: {
                        url: url,
                        live: true,
                        autoPlay: false,
                        urlResolvers: "flashls",
                        provider: "flashls"
                    }
                }).stop();
                $(this).attr("data-flag","0");
                $(this).attr("src","static/images/playbox.png");
            }

        });

        function fplayer(id,url,pid){
            flowplayer(id, "static/flowplayer/flowplayer.swf", {
                // configure the required plugins
                plugins: {
                    flashls: {
                        url: 'static/flowplayer/flashlsFlowPlayer.swf'
                    },
                    controls:{
                        autoHide: false ,//功能条是否自动隐藏
                        backgroundColor: '#0a8ddf'
                    }
                },
                clip: {
                    url: url,
                    live: true,
                    urlResolvers: "flashls",
                    provider: "flashls"
                },
                onFinish: function() {
                    //统计播完率
                    $.ajax({
                        url: 'index.php?c=player&m=play_over',
                        type: 'post',
                        dataType:'json',
                        data: {id:pid},
                        success:function(data) {
                            //alert(data);
                        }
                    });
                }

            }).ipad();
        }
    </script>
</div>
</body>
</html>