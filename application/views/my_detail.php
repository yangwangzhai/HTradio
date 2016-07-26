<?php $this->load->view('header');?>

    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no,minimal-ui" />
    <meta charset="utf-8">
    <title>节目播放</title>
    <script type="text/javascript" src="static/flowplayer/flowplayer-3.2.12.min.js"></script>
    <script type="text/javascript" src="static/flowplayer/flowplayer.ipad-3.2.12.min.js"></script>

    <style>
        div.mt25 {
            margin-top: 5px;
            margin-bottom: 4px;
        }
        div.mt25 a {
            padding: 0 14px;
            line-height: 18px;
            border-radius: 9px;
            margin-left: 12px;
            color: #666;
            background-color: #fff;
            margin-bottom: 6px;
        }
        .bd_d1 {
            border: 1px solid #d1d1d1;
        }
        a.bd_d1{
            display: inline-block;
            color: #333;
            text-decoration: none;
            cursor: pointer;
        }
        a.bd_d1:hover{
            border: 2px solid #d1d1d1;
        }
    </style>

    <script>
        $(document).ready(function(){
            $(".details_list ul li").mouseover(function(){
                $(this).addClass("current");
            });
            $(".details_list ul li").mouseout(function(){
                $(this).removeClass("current");
            });
            //异步删除节目
            $(".g").on("click", function () {
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
            })
            //下载
            $(".f").on("click",function(){
                var download_path = $(this).attr("data-download-path");
                var title = $(this).attr("data-title");
                var meid = $(this).attr("data-meid");
                location.href="index.php?c=player&m=download&download_path="+download_path+"&title="+title+"&meid="+meid;
            })

        });
    </script>
    <div class="main">
        <div class="pro_details">
            <div class="details_top">
                <div class="dleft"><img src="<?php if(!empty($me_data['thumb'])){echo show_thumb( $me_data['thumb'] );}else{echo base_url()."uploads/default_images/default_programme.jpg";}?>" /></div>
                <div class="dright">
                    <h1><a href="index.php?c=player&m=edit&id=<?=$meid?>" title="点击可进行编辑" target="_blank" ><?=$me_data['title']?></a></h1>
                    <p>主播：<?=getNickName($me_data['mid'])?></p>
                    <p>最后更新: <?=date('Y-m-d',$me_data['addtime'])?></p>
                    <p style=" padding:10px 0;"><a href="javascript:void(0);" id="sss" class="dbtn">立即收听</a><span><?=$me_data['playtimes']?></span>次播放</p>
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
            </div>

            <div class="details_infro" style="padding: 0;">简介：<?=$me_data['intro']?></div>
            <?php if($list){ ?>
                <div id="jp-playlist" class="details_list">
                    <ul>
                    <?php foreach($list as $key=>$val) { ?>
                        <li>
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
                            <b class="playmenu" data-title="<?=$val['title']?>" data-thumb="<?=$val['thumb']?>" data-url="<?=$val['path']?>"><?=$val['title']?></b>
                        </li>
                        <?php }?>
                    </ul>
                </div>

                <div class="page-navigator" style="display:none;">
                    <div class="page-cont">
                        <div class="page-inner">
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
            <?php } ?>
        </div>

        <div class="pro_details" style="height: 500px;">
            <!--header/begin-->
            <div id="header" style="width: 800px;">
                <h2 style="color: #6A6AFF;line-height: 46px; text-align: center;"><?=$list[0]['title']?></h2>
            </div>
            <!--header/end-->
            <!--content/begin-->
            <div id="content" style="width: 800px;">
                <!--flowplayer代码开始-->
                <a style="display: block; width: 800px; height: 500px;" id="flashls_vod"></a>
                <!--flowplayer代码结束-->
            </div>
        </div>

        <div class="find_right" style="margin-top: -360px;">
            <div class="down"><a href="./index.php?c=download&m=getApk"><img src="static/images/down.png" /></a></div>
            <div class="title">Ta的其他节目<a href="index.php?c=zhubo&mid=<?=$me_data['mid']?>">/更多</a></div>
            <div class="radiolist">
                <?php foreach($other as $val) { ?>
                    <dl>
                        <dt><a href="index.php?c=player&id=<?=$val['id']?>"><img src="<?php if(!empty($val['thumb'])){echo show_thumb( $val['thumb'] );}else{echo base_url()."uploads/default_images/default_jiemu.jpg";}?>" /></a></dt>
                        <dd>
                            <h5><a href="index.php?c=player&id=<?=$val['id']?>" title="<?=$val['title']?>"><?=str_cut($val['title'],20)?></a></h5>
                            <p>类别：<?=getProgramTypeName($val['type_id'])?></p>
                        </dd>
                    </dl>
                <?php } ?>

            </div>

            <div class="title">大家还在听<!--a href="#">/更多</a--></div>
            <div class="radiolist">
                <?php foreach($listen as $val) { ?>
                    <dl>
                        <dt><a href="index.php?c=player&id=<?=$val['id']?>"><img src="<?php if(!empty($val['thumb'])){echo show_thumb( $val['thumb'] );}else{echo base_url()."uploads/default_images/default_jiemu.jpg";}?>" /></a></dt>
                        <dd>
                            <h5><a href="index.php?c=player&id=<?=$val['id']?>" title="<?=$val['title']?>"><?=str_cut($val['title'],25)?></a></h5>
                            <p>类别：<?=getProgramTypeName($val['type_id'])?></p>
                        </dd>
                    </dl>
                <?php } ?>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        flowplayer("flashls_vod", "static/flowplayer/flowplayer.swf", {
            plugins: {
                flashls: {
                    url: 'static/flowplayer/flashlsFlowPlayer.swf'
                },
                controls:{
                    autoHide: false//功能条是否自动隐藏
                }
            },
            clip: {
                url: "<?=$list[0]['path']?>",
                live: true,
                autoPlay: false,//关闭自动播放
                urlResolvers: "flashls",
                provider: "flashls"
            }
        }).ipad();

        $(".playmenu").click(function(){
            var id="flashls_vod";
            var url=$(this).attr("data-url");
            fplayer(id,url);
            var title=$(this).attr("data-title");
            $("#header h2").text(title);
            //当前播放的节目，高亮
           /* $(".playmenu").css("color","#aaa");
            $(this).css("color","#ffffff");
            //播放器标题
            var title=$(this).attr("data-title");
            $("#playtitle").text(title);
            //节目缩略图
            var thumb=$(this).attr("data-thumb");
            $("#playthumb").attr("src",thumb);*/
        });

        function fplayer(id,url){
            flowplayer(id, "static/flowplayer/flowplayer.swf", {
                // configure the required plugins
                plugins: {
                    flashls: {
                        url: 'static/flowplayer/flashlsFlowPlayer.swf'
                    },
                    controls:{
                        autoHide: false //功能条是否自动隐藏
                    }
                },
                clip: {
                    url: url,
                    live: true,
                    urlResolvers: "flashls",
                    provider: "flashls"
                }
            }).ipad();
        }

    </script>

<?php $this->load->view('footer');?>