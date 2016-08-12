<?php $this->load->view('header');?>

    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no,minimal-ui" />
    <meta charset="utf-8">
    <title>节目播放</title>
    <link href="static/css/comment_style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="static/flowplayer/flowplayer-3.2.12.min.js"></script>
    <script type="text/javascript" src="static/flowplayer/flowplayer.ipad-3.2.12.min.js"></script>

    <script>
        $(document).ready(function(){
            $(".details_list ul li").mouseover(function(){
                $(this).addClass("current");
            });
            $(".details_list ul li").mouseout(function(){
                $(this).removeClass("current");
            });
            //异步删除节目
            $(".g").live("click", function () {
                var meid = $(this).attr("data-meid");
                var id = $(this).attr("data-id");
                var com = confirm("确定要删除该节目？");
                if(com){
                    $(this).parent().parent().addClass("active");
                    $.ajax({
                        url:"index.php?c=player&m=delete_progarm",
                        type: "post",         //数据发送方式
                        dataType:"json",    //接受数据格式
                        data:{meid:meid,id:id},  //要传递的数据
                        success:function(data){
                            if(data){
                                $(".active").remove();
                                var title = $(".playmenu").eq(0).attr("data-title");
                                $("#header h2").text(title);
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
            $("#tag").live("click",function(){
                if($(this).next().css("display")=="none"){
                    $(this).next().show();
                    $(this).text("-");
                }else{
                    $(this).next().hide();
                    $(this).text("+");
                }
            });

            $("#tag_submit").live("click",function(){
                var tag_name = $("#tag_name").val();
                var id = $("#tag_name").attr("data-id");
                if(tag_name){
                    $.ajax({
                        url:"index.php?c=player&m=save_tag",
                        type:"post",
                        dataType:"json",
                        data:{tag_name:tag_name,id:id,tag_flag:2},
                        success:function(data){
                            if(data){
                                $.each(data,function(key,value){
                                    $("#tag").before('<a class="bd_d1" href="index.php?c=search&keyword='+value+'">'+value+'</a>');
                                });
                                $("#tag").next().hide();
                                $("#tag").text("+");
                                $("#tag_name").val("");
                            }
                        },
                        error:function(XMLHttpRequest, textStatus, errorThrown)
                        {
                            //alert(errorThrown);
                        }
                    });
                }else{
                    alert("标签不能为空");
                }
            });
            //下载
            $(".f").live("click",function(){
                var download_path = $(this).attr("data-download-path");
                var title = $(this).attr("data-title");
                var meid = $(this).attr("data-meid");
                location.href="index.php?c=player&m=download&download_path="+download_path+"&title="+title+"&meid="+meid;
            });
            //跳转到具体节目详情页
            $(".program_detail").live("click",function(){
                var id = $(this).attr("data-id");
                location.href="index.php?c=player&m=index&id="+id;
            });
            //节目列表和评论切换
            $(".f18").live("click",function(){
                if(!$(this).hasClass("cur")){
                    var data = $(this).attr("data");
                    var qh_class = 'qh_'+data;
                    $(".f18").removeClass("cur");
                    $(this).addClass("cur");
                    if(qh_class=='qh_comment'){
                        $("."+qh_class).css("display","block");
                        $(".qh_program").css("display","none");
                    }else{
                        $("."+qh_class).css("display","block");
                        $(".qh_comment").css("display","none");
                    }

                }
            });
            $("#ta-comment").live("focus",function(){
                var mid = $("#ta-comment").attr("data-mid");
                if(mid){

                }else{
                    alert("请先登录");
                }
            });
            //异步保存评论
            $(".c-submit").live("click",function(){
                var comment = $("#ta-comment").text();
                var mid = $("#ta-comment").attr("data-mid");
                if(comment){
                    var me_id = <?=$meid?>;
                    $.ajax({
                        url:"index.php?c=player&m=save_comment",
                        type:"post",
                        dataType:"json",
                        data:{me_id:me_id,mid:mid,comment:comment},
                        success:function(data){
                            if(data){
                                $(".cmt-list").empty();
                                $(".cmt-list").append(data[0]);
                                $("#ta-comment").text('');
                                $(".cur").children("var").text('('+data[1]+')');
                            }else{

                            }
                        },
                        error:function(XMLHttpRequest, textStatus, errorThrown)
                        {
                            //alert(errorThrown);
                        }
                    });
                }else{
                    alert("评论不能为空！")
                }
            });
            //异步获取评论分页
            $('.ajax_mpage').live('click', function(eve){
                //阻止默认动作，此处阻止<a>连接直接跳转
                eve.preventDefault();
                var me_id=<?=$meid?>;
                var href=$(this).attr("href");
                //alert(href);
                var arr=href.split('per_page=');
                if(arr[1]==''){arr[1]=1;}
                var per_page=arr[1];
                $.ajax({
                    url:"index.php?c=player&m=comment_page",
                    type:"get",
                    dataType:"text",
                    data: {
                        'me_id':me_id,
                        'mper_page':per_page //当前第几页，用于生成分页
                    },
                    success: function(html) {
                        //alert(html);
                        $(".qh_comment").detach();
                        $(".k_til_02").after(html);
                    }
                });
            });
            //展开回复对话框
            $(".reply").live("click",function(){
                
                if(!$(this).parent().next().hasClass("active_reply")){
                    $(this).parent().next().css("display","block");
                    $(this).parent().next().addClass("active_reply");
                }

            })
        });
    </script>
    <div class="main">
        <div class="pro_details" style="height: 1000px;">
            <div class="details_top">
                <div class="dleft"><img src="<?php if(!empty($me_data['thumb'])){echo show_thumb( $me_data['thumb'] );}else{echo base_url()."uploads/default_images/default_programme.jpg";}?>" /></div>
                <div class="dright">
                    <!--不是本人不可编辑，只能查看，播放-->
                    <h1>
                        <a href="<?php if($is_owner){echo 'index.php?c=player&m=edit&id='.$meid;}else{echo 'javascript:void(0);';} ?>" title="<?php if($is_owner){echo '点击可进行编辑';}else{echo '不是本人不可编辑';} ?>" target="_blank" ><?=$me_data['title']?></a>
                    </h1>
                    <p>主播：<?=getNickName($me_data['mid'])?></p>
                    <p>最后更新: <?=date('Y-m-d',$me_data['addtime'])?></p>
                    <p style=" padding:10px 0;margin-bottom: 50px;"><a style="text-decoration: none;" href="javascript:void(0);" id="sss" class="dbtn">播放次数：<?=$me_data['playtimes']+1?></a><!--<span><?/*=$me_data['playtimes']+1*/?></span>次播放--></p>
                    <!-- JiaThis Button BEGIN -->
                    <!-- JiaThis Button BEGIN -->
                    <div class="jiathis_style_24x24">
                        <a class="jiathis_button_qzone"></a>
                        <a class="jiathis_button_tsina"></a>
                        <a class="jiathis_button_tqq"></a>
                        <a class="jiathis_button_weixin"></a>
                        <a class="jiathis_button_renren"></a>
                        <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
                        <a class="jiathis_counter_style"></a>
                    </div>
                    <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
                    <!-- JiaThis Button END -->
                </div>
            </div>

            <div class="mt25 mb10">
                标签:
                <?php if(!empty($result_tag)){?>
                    <?php foreach($result_tag as $tag_value) :?>
                        <a class="bd_d1" href="index.php?c=search&keyword=<?=$tag_value['tag_name']?>"><?=$tag_value['tag_name']?></a>
                    <?php endforeach?>
                <?php }?>
                <a class="bd_d1" id="tag" href="javascript:void(0);">+</a>
                <span style="display: none">
                    <input id="tag_name" data-id="<?=$meid;?>" type="text" style="width: 100px;">
                    <input id="tag_submit" type="button" value="提交" style="cursor: pointer;">
                </span>
            </div>

            <div class="details_infro" style="padding: 0;">简介：<?=$me_data['intro']?></div>


            <h2 class="k_til_02 mt20 alg_c bdb_f1565e">
                <a class="fl clear-line f18 cur" data="program" href="javascript:void(0)">节目列表<var>(<?=$count?>)</var></a>
                <a class="fl clear-line f18" data="comment" href="javascript:void(0)">评论<var>(<?=$result_comment_num?>)</var></a>
            </h2>
            <?php if($list){ ?>
                <div id="jp-playlist" class="details_list qh_program">
                    <ul>
                    <?php foreach($list as $key=>$val) { ?>
                        <li style="padding-left: 0;">
                            <span>
                                <!--<a data-meid="<?/*=$meid*/?>" data-id="<?/*=$val['id']*/?>" href="javascript:void(0);" class="c"></a>-->
                                <!--<a data-meid="<?/*=$meid*/?>" data-id="<?/*=$val['id']*/?>" href="javascript:void(0);" class="d"></a>-->
                                <!--<a data-meid="<?/*=$meid*/?>" data-id="<?/*=$val['id']*/?>" href="javascript:void(0);" class="e"></a>-->
                                <a data-meid="<?=$meid?>" data-title="<?=$val['title']?>" data-download-path="<?=$val['download_path']?>" href="javascript:void(0);" class="f"></a>
                                <a data-meid="<?=$meid?>" data-id="<?=$val['id']?>" href="javascript:void(0);" class="g"></a>
                            </span>
                            <em>
                                <strong><?=$val['program_time']?$val['program_time']:'--:--'?></strong>
                                <strong><?=$val['playtimes']?>次播放</strong>
                                <strong><?=date('Y-m-d',$val['addtime'])?></strong>
                            </em>
                            <img class="playmenu" data-id="<?=$val['id']?>" data-title="<?=$val['title']?>" data-thumb="<?=$val['thumb']?>" data-url="<?=$val['path']?>" data-flag="0" src="static/images/playbox.png" style="display: inline-block;padding-right: 5px; position: relative; top: 3px;">
                            <b class="program_detail" data-id="<?=$val['id']?>"><?=$val['title']?></b>
                        </li>
                        <?php }?>
                    </ul>
                </div>

                <div class="page-navigator qh_program">
                    <div class="page-cont">
                        <div class="page-inner">
                            <span style="display: inline-block;float: right;margin-right: 15px;font-size: 14px;"><?=$pages?></span>
                        </div>
                    </div>
                </div>
            <?php } ?>


            <!--评论开始部分-->
            <div id="jp-playlist" class="qh qh_comment" style="display: none;padding: 20px">
                <div class="hidden bg_1 pt14 pb10">
                    <img id="user-pic" class="fl" src="static/admin_img/audio.png" onerror="noSrc(event)">
                    <div class="fr c-sub">
                        <div id="ta-comment" myplaceholder="聊聊你的想法？" data-mid="<?=$mid?>" contenteditable="true" class="curEmojiIpt emojiIpt clear-line c1 ipt-overflow" ></div>
                        <div class="face-div hidden">
                            <a class="fl face"></a>
                            <a class="fr c-submit dis" commenttype="0" style="cursor: pointer;">评论</a>
                            <span class="fr iptLen">140</span>
                        </div>
                    </div>
                </div>
                <?php if($result_comment){ ?>
                <ul class="cmt-list">
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
                                <a class="reply" style="cursor: pointer;">回复</a>
                            </div>
                            <div class="c-sub reply-div hide" style="display: none;">
                                <div class="bg_1 pl10 pb10 pt15">
                                    <div contenteditable="true" class="emojiIpt clear-line ipt-overflow" myplaceholder="回复嘉怡" style="color: rgb(153, 153, 153);">回复嘉怡</div>
                                    <div class="face-div hidden"><a class="fl face"></a><a class="fr c-submit dis" commenttype="1">回复</a><span class="fr iptLen">140</span></div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php endforeach ?>
                </ul>
                <?php } ?>
            </div>

            <div id="comment-page" class="page-navigator qh_comment" style="display: none;float: right;">
                <div class="page-cont">
                    <div class="page-inner">
                        <?=$mpages?>
                    </div>
                </div>
            </div>
            <!--评论结束部分-->



        </div>



        <div class="find_right" style="position: absolute;top: 91px;left: 70%;width: 280px;">
            <div class="down"><a href="./index.php?c=download&m=getApk"><img src="static/images/down.png" /></a></div>
            <div class="title">Ta的其他节目单<a href="index.php?c=zhubo&mid=<?=$me_data['mid']?>">/更多</a></div>
            <div class="radiolist" style="width: 280px;">
                <?php foreach($other as $val) { ?>
                    <dl style="width: 280px;">
                        <dt><a href="index.php?c=player&meid=<?=$val['id']?>"><img src="<?php if(!empty($val['thumb'])){echo show_thumb( $val['thumb'] );}else{echo base_url()."uploads/default_images/default_programme.jpg";}?>" /></a></dt>
                        <dd style="width: 190px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">
                            <h5><a href="index.php?c=player&meid=<?=$val['id']?>"title="<?=$val['title']?>"><?=$val['title']?></a></h5>
                            <p>类别：<?=getProgramTypeName($val['type_id'])?></p>
                        </dd>
                    </dl>
                <?php } ?>

            </div>

            <div class="title">大家还在听的节目<!--a href="#">/更多</a--></div>
            <div class="radiolist">
                <?php foreach($listen as $val) { ?>
                    <dl style="width: 280px;">
                        <dt><a href="index.php?c=player&id=<?=$val['id']?>"><img src="<?php if(!empty($val['thumb'])){echo show_thumb( $val['thumb'] );}else{echo base_url()."uploads/default_images/default_jiemu.jpg";}?>" /></a></dt>
                        <dd style="width: 190px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">
                            <h5><a href="index.php?c=player&id=<?=$val['id']?>"title="<?=$val['title']?>"><?=$val['title']?></a></h5>
                            <p>类别：<?=getProgramTypeName($val['type_id'])?></p>
                        </dd>
                    </dl>
                <?php } ?>

            </div>
        </div>
    </div>

<div class="link" style="padding-top: 50px">
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
/*    flowplayer("flashls_vod", "static/flowplayer/flowplayer.swf", {
        plugins: {
            flashls: {
                url: 'static/flowplayer/flashlsFlowPlayer.swf'
            },
            controls:{
                autoHide: false,//功能条是否自动隐藏
                backgroundColor: '#0a8ddf'
            }
        },
        clip: {
            url: "<?=$list[0]['path']?>",
            live: true,
            autoPlay: false,//关闭自动播放
            urlResolvers: "flashls",
            provider: "flashls"
        },
        onFinish: function() {
            //统计播完率
            var id = <?=$list[0]['id']?>;
            $.ajax({
                url: 'index.php?c=player&m=play_over',
                type: 'post',
                dataType:'json',
                data: {id:id},
                success:function(data) {
                    //alert(data);
                }
            });
        }

    }).ipad();*/

    $(".playmenu").click(function(){
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
</body>
</html>
