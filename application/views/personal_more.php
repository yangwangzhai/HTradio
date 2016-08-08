<?php $this->load->view('header');?>
<script type="text/javascript">
$(document).ready(function(){
    $(".talk_send").on("click",function(){
        var message = $(".messages").val();
        if(message){
            var avatar = $("#talk_avatar").val();
            var to_uid = $("#talk_to_uid").val();
            var from_uid = $("#talk_from_uid").val();
            var date = '<?php date_default_timezone_set("Asia/Shanghai");echo date("Y-m-d H:i:s", time())?>';
            $(".jspPane").append(
                '<div class="talk_recordboxme">' +
                '<div class="user"><img width="45" height="45" src="'+avatar+'"/>我</div>'+
                '<div class="talk_recordtextbg">&nbsp;</div>'+
                '<div class="talk_recordtext">'+
                '<h3>'+message+'</h3>'+
                '<span class="talk_time">'+date+'</span>'+
                '</div>'+
                '</div>');
            $(function(){

                // the element we want to apply the jScrollPane
                var $el= $('#jp-container').jScrollPane({
                        verticalGutter 	: -16
                    }),

                // the extension functions and options
                    extensionPlugin 	= {

                        extPluginOpts	: {
                            // speed for the fadeOut animation
                            mouseLeaveFadeSpeed	: 500,
                            // scrollbar fades out after hovertimeout_t milliseconds
                            hovertimeout_t		: 1000,
                            // if set to false, the scrollbar will be shown on mouseenter and hidden on mouseleave
                            // if set to true, the same will happen, but the scrollbar will be also hidden on mouseenter after "hovertimeout_t" ms
                            // also, it will be shown when we start to scroll and hidden when stopping
                            useTimeout			: true,
                            // the extension only applies for devices with width > deviceWidth
                            deviceWidth			: 980
                        },
                        hovertimeout	: null, // timeout to hide the scrollbar
                        isScrollbarHover: false,// true if the mouse is over the scrollbar
                        elementtimeout	: null,	// avoids showing the scrollbar when moving from inside the element to outside, passing over the scrollbar
                        isScrolling		: false,// true if scrolling
                        addHoverFunc	: function() {

                            // run only if the window has a width bigger than deviceWidth
                            if( $(window).width() <= this.extPluginOpts.deviceWidth ) return false;

                            var instance		= this;

                            // functions to show / hide the scrollbar
                            $.fn.jspmouseenter 	= $.fn.show;
                            $.fn.jspmouseleave 	= $.fn.fadeOut;

                            // hide the jScrollPane vertical bar
                            var $vBar			= this.getContentPane().siblings('.jspVerticalBar').hide();

                            /*
                             * mouseenter / mouseleave events on the main element
                             * also scrollstart / scrollstop - @James Padolsey : http://james.padolsey.com/javascript/special-scroll-events-for-jquery/
                             */
                            $el.bind('mouseenter.jsp',function() {

                                // show the scrollbar
                                $vBar.stop( true, true ).jspmouseenter();

                                if( !instance.extPluginOpts.useTimeout ) return false;

                                // hide the scrollbar after hovertimeout_t ms
                                clearTimeout( instance.hovertimeout );
                                instance.hovertimeout 	= setTimeout(function() {
                                    // if scrolling at the moment don't hide it
                                    if( !instance.isScrolling )
                                        $vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
                                }, instance.extPluginOpts.hovertimeout_t );


                            }).bind('mouseleave.jsp',function() {

                                // hide the scrollbar
                                if( !instance.extPluginOpts.useTimeout )
                                    $vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
                                else {
                                    clearTimeout( instance.elementtimeout );
                                    if( !instance.isScrolling )
                                        $vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
                                }

                            });

                            if( this.extPluginOpts.useTimeout ) {

                                $el.bind('scrollstart.jsp', function() {

                                    // when scrolling show the scrollbar
                                    clearTimeout( instance.hovertimeout );
                                    instance.isScrolling	= true;
                                    $vBar.stop( true, true ).jspmouseenter();

                                }).bind('scrollstop.jsp', function() {

                                    // when stop scrolling hide the scrollbar (if not hovering it at the moment)
                                    clearTimeout( instance.hovertimeout );
                                    instance.isScrolling	= false;
                                    instance.hovertimeout 	= setTimeout(function() {
                                        if( !instance.isScrollbarHover )
                                            $vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
                                    }, instance.extPluginOpts.hovertimeout_t );

                                });

                                // wrap the scrollbar
                                // we need this to be able to add the mouseenter / mouseleave events to the scrollbar
                                var $vBarWrapper	= $('<div/>').css({
                                    position	: 'absolute',
                                    left		: $vBar.css('left'),
                                    top			: $vBar.css('top'),
                                    right		: $vBar.css('right'),
                                    bottom		: $vBar.css('bottom'),
                                    width		: $vBar.width(),
                                    height		: $vBar.height()
                                }).bind('mouseenter.jsp',function() {

                                    clearTimeout( instance.hovertimeout );
                                    clearTimeout( instance.elementtimeout );

                                    instance.isScrollbarHover	= true;

                                    // show the scrollbar after 100 ms.
                                    // avoids showing the scrollbar when moving from inside the element to outside, passing over the scrollbar
                                    instance.elementtimeout	= setTimeout(function() {
                                        $vBar.stop( true, true ).jspmouseenter();
                                    }, 100 );

                                }).bind('mouseleave.jsp',function() {

                                    // hide the scrollbar after hovertimeout_t
                                    clearTimeout( instance.hovertimeout );
                                    instance.isScrollbarHover	= false;
                                    instance.hovertimeout = setTimeout(function() {
                                        // if scrolling at the moment don't hide it
                                        if( !instance.isScrolling )
                                            $vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
                                    }, instance.extPluginOpts.hovertimeout_t );

                                });

                                $vBar.wrap( $vBarWrapper );

                            }

                        }

                    },

                // the jScrollPane instance
                    jspapi 			= $el.data('jsp');

                // extend the jScollPane by merging
                $.extend( true, jspapi, extensionPlugin );
                jspapi.addHoverFunc();

            });
            //异步存入数据库
            $.ajax({
                url:"index.php?c=personal&m=save_talk",
                type: "post",         //数据发送方式
                dataType:"json",    //接受数据格式
                data:{to_uid:to_uid,from_uid:from_uid,date:date,message:message},  //要传递的数据
                success:function(data){
                    //alert(data);
                    $(".messages").val('');
                },
                error:function(XMLHttpRequest, textStatus, errorThrown)
                {
                    //alert(errorThrown);
                }
            });
        }
    });

  $(".details_list ul li").mouseover(function(){
    $(this).addClass("current");
  });
$(".details_list ul li").mouseout(function(){
    $(this).removeClass("current");
  });


});
</script>

<div class="main">
    <?php left_view();?>
  	<div class="radio_right">
        <div class="radio_title"><?=$title?>(<?=$count?>)</div>
        <div class="fans_list">
        	<?php foreach($list as $v) { ?>
        	<dl>
            	<dt><a href="index.php?c=zhubo&mid=<?=$v['id']?>"><img src="<?php if($v['avatar']){echo show_thumb($v['avatar']);}else{echo 'uploads/default_images/default_avatar.jpg';}?>" /></a></dt>
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
			        
			          <!--<a class="letter" href="javascript:void(0);">私信</a>-->
                </div>
                </dd>
            </dl>
            <?php } ?>
        </div>

	    <div class="page-navigator" style="margin-bottom: 0px;">
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

        <div class="radio_title" style="height: 20px;"></div>
        <input id="talk_avatar" type="hidden" value="<?php echo$zb['avatar']?$zb['avatar']:'uploads/default_images/default_avatar.jpg'?>">
        <input id="talk_to_uid" type="hidden" value="<?=$uid?>">
        <input id="talk_from_uid" type="hidden" value="<?=$list[0]['id']?>">

            <div class="fans_list" style="padding: 0px;">
                <!--讨论区滚动条begin-->
                <link rel="stylesheet" type="text/css" href="static/talk/css/jscrollpane1.css" />
                <!--<script src="static/talk/js/jquery-1.4.2.min.js" type="text/javascript"></script>-->
                <!--引用jquery-1.4.2.min.js会影响添加表情，不引用jquery-1.4.2.min.js就不支持IE、火狐浏览器的鼠标滚轮插件-->
                <!-- the mousewheel plugin -->
                <script type="text/javascript" src="static/talk/js/jquery.mousewheel.js"></script>
                <!-- the jScrollPane script -->
                <script type="text/javascript" src="static/talk/js/jquery.jscrollpane.min.js"></script>
                <script type="text/javascript" src="static/talk/js/scroll-startstop.events.jquery.js"></script>
                <!--讨论区滚动条end-->
                <br>
                <div class="talk">
                    <div class="talk_title"><span>与<?= getNickName($list[0]['id'])?>的私信</span></div>
                    <div class="talk_record">
                        <div id="jp-container" class="jp-container">
                            <?php if(!empty($message)){?>
                                <?php foreach($message as $mess_value):?>
                                <?php if($mess_value['to_uid']==$uid){?>
                                        <div class="talk_recordbox">
                                            <div class="user"><img width="45" height="45" src="<?=getUserAvatar($mess_value['from_uid'])?>"/><?= getNickName($mess_value['from_uid'])?></div>
                                            <div class="talk_recordtextbg">&nbsp;</div>
                                            <div class="talk_recordtext">
                                                <h3><?= $mess_value['title']?></h3>
                                                <span class="talk_time"><?php date_default_timezone_set("Asia/Shanghai");echo date("Y-m-d H:i:s", $mess_value['addtime'])?></span>
                                            </div>
                                        </div>
                                <?php }else{?>
                                        <div class="talk_recordboxme">
                                            <div class="user"><img width="45" height="45" src="<?=getUserAvatar($mess_value['from_uid'])?>"/>我</div>
                                            <div class="talk_recordtextbg">&nbsp;</div>
                                            <div class="talk_recordtext">
                                                <h3><?= $mess_value['title']?></h3>
                                                <span class="talk_time"><?php date_default_timezone_set("Asia/Shanghai");echo date("Y-m-d H:i:s", $mess_value['addtime'])?></span>
                                            </div>
                                        </div>
                                <?php }?>
                                <?php endforeach?>
                            <?php }?>
                        </div>

                    </div>

                    <div class="talk_word">
                        &nbsp;
                        <!--<input class="add_face" id="facial" type="button" title="添加表情" value="" />-->
                        <input class="messages emotion" autocomplete="off" value="在这里输入文字" onFocus="if(this.value=='在这里输入文字'){this.value='';}"  onblur="if(this.value==''){this.value='在这里输入文字';}"  />
                        <input class="talk_send" type="button" title="发送" value="发送" />
                    </div>
                </div>

                <script type="text/javascript">
                    $(function(){

                        // the element we want to apply the jScrollPane
                        var $el= $('#jp-container').jScrollPane({
                                verticalGutter 	: -16
                            }),

                        // the extension functions and options
                            extensionPlugin 	= {

                                extPluginOpts	: {
                                    // speed for the fadeOut animation
                                    mouseLeaveFadeSpeed	: 500,
                                    // scrollbar fades out after hovertimeout_t milliseconds
                                    hovertimeout_t		: 1000,
                                    // if set to false, the scrollbar will be shown on mouseenter and hidden on mouseleave
                                    // if set to true, the same will happen, but the scrollbar will be also hidden on mouseenter after "hovertimeout_t" ms
                                    // also, it will be shown when we start to scroll and hidden when stopping
                                    useTimeout			: true,
                                    // the extension only applies for devices with width > deviceWidth
                                    deviceWidth			: 980
                                },
                                hovertimeout	: null, // timeout to hide the scrollbar
                                isScrollbarHover: false,// true if the mouse is over the scrollbar
                                elementtimeout	: null,	// avoids showing the scrollbar when moving from inside the element to outside, passing over the scrollbar
                                isScrolling		: false,// true if scrolling
                                addHoverFunc	: function() {

                                    // run only if the window has a width bigger than deviceWidth
                                    if( $(window).width() <= this.extPluginOpts.deviceWidth ) return false;

                                    var instance		= this;

                                    // functions to show / hide the scrollbar
                                    $.fn.jspmouseenter 	= $.fn.show;
                                    $.fn.jspmouseleave 	= $.fn.fadeOut;

                                    // hide the jScrollPane vertical bar
                                    var $vBar			= this.getContentPane().siblings('.jspVerticalBar').hide();

                                    /*
                                     * mouseenter / mouseleave events on the main element
                                     * also scrollstart / scrollstop - @James Padolsey : http://james.padolsey.com/javascript/special-scroll-events-for-jquery/
                                     */
                                    $el.bind('mouseenter.jsp',function() {

                                        // show the scrollbar
                                        $vBar.stop( true, true ).jspmouseenter();

                                        if( !instance.extPluginOpts.useTimeout ) return false;

                                        // hide the scrollbar after hovertimeout_t ms
                                        clearTimeout( instance.hovertimeout );
                                        instance.hovertimeout 	= setTimeout(function() {
                                            // if scrolling at the moment don't hide it
                                            if( !instance.isScrolling )
                                                $vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
                                        }, instance.extPluginOpts.hovertimeout_t );


                                    }).bind('mouseleave.jsp',function() {

                                        // hide the scrollbar
                                        if( !instance.extPluginOpts.useTimeout )
                                            $vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
                                        else {
                                            clearTimeout( instance.elementtimeout );
                                            if( !instance.isScrolling )
                                                $vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
                                        }

                                    });

                                    if( this.extPluginOpts.useTimeout ) {

                                        $el.bind('scrollstart.jsp', function() {

                                            // when scrolling show the scrollbar
                                            clearTimeout( instance.hovertimeout );
                                            instance.isScrolling	= true;
                                            $vBar.stop( true, true ).jspmouseenter();

                                        }).bind('scrollstop.jsp', function() {

                                            // when stop scrolling hide the scrollbar (if not hovering it at the moment)
                                            clearTimeout( instance.hovertimeout );
                                            instance.isScrolling	= false;
                                            instance.hovertimeout 	= setTimeout(function() {
                                                if( !instance.isScrollbarHover )
                                                    $vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
                                            }, instance.extPluginOpts.hovertimeout_t );

                                        });

                                        // wrap the scrollbar
                                        // we need this to be able to add the mouseenter / mouseleave events to the scrollbar
                                        var $vBarWrapper	= $('<div/>').css({
                                            position	: 'absolute',
                                            left		: $vBar.css('left'),
                                            top			: $vBar.css('top'),
                                            right		: $vBar.css('right'),
                                            bottom		: $vBar.css('bottom'),
                                            width		: $vBar.width(),
                                            height		: $vBar.height()
                                        }).bind('mouseenter.jsp',function() {

                                            clearTimeout( instance.hovertimeout );
                                            clearTimeout( instance.elementtimeout );

                                            instance.isScrollbarHover	= true;

                                            // show the scrollbar after 100 ms.
                                            // avoids showing the scrollbar when moving from inside the element to outside, passing over the scrollbar
                                            instance.elementtimeout	= setTimeout(function() {
                                                $vBar.stop( true, true ).jspmouseenter();
                                            }, 100 );

                                        }).bind('mouseleave.jsp',function() {

                                            // hide the scrollbar after hovertimeout_t
                                            clearTimeout( instance.hovertimeout );
                                            instance.isScrollbarHover	= false;
                                            instance.hovertimeout = setTimeout(function() {
                                                // if scrolling at the moment don't hide it
                                                if( !instance.isScrolling )
                                                    $vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
                                            }, instance.extPluginOpts.hovertimeout_t );

                                        });

                                        $vBar.wrap( $vBarWrapper );

                                    }

                                }

                            },

                        // the jScrollPane instance
                            jspapi 			= $el.data('jsp');

                        // extend the jScollPane by merging
                        $.extend( true, jspapi, extensionPlugin );
                        jspapi.addHoverFunc();

                    });
                </script>

            </div>




    </div>
</div>

<?php $this->load->view('footer');?>