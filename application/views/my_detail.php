<?php $this->load->view('header');?>

    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no,minimal-ui" />
    <meta charset="utf-8">
    <title>节目播放</title>
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
        });
    </script>
    <div class="main">
        <div class="pro_details">
            <div class="details_top">
                <div class="dleft"><img src="<?php if(!empty($me_data['thumb'])){echo show_thumb( $me_data['thumb'] );}else{echo base_url()."uploads/default_images/default_programme.jpg";}?>" /></div>
                <div class="dright">
                    <h1><?=$me_data['title']?></h1>
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
            <div class="details_infro"><?=$me_data['intro']?></div>
            <?php if($list){ ?>
                <div id="jp-playlist" class="details_list">
                    <ul>
                    <?php foreach($list as $key=>$val) { ?>
                        <li class="playmenu" data-title="<?=$val['title']?>" data-thumb="<?=$val['thumb']?>" data-url="<?=$val['path']?>">
                            <span>
                                <a href="" class="c"></a>
                                <a href="" class="d"></a>
                                <a href="" class="e"></a>
                                <a href="" class="f"></a>
                            </span>
                            <em>
                                <strong><?=$val['program_time']?$val['program_time']:'--:--'?></strong>
                                <strong><?=$val['playtimes']?>次播放</strong>
                                <strong><?=date('Y-m-d',$val['addtime'])?></strong>
                            </em>
                            <b><?=$val['title']?></b>
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
                        <dt><a href="index.php?c=player&id=<?=$val['id']?>"><img src="<?=show_thumb($val['thumb'])?>" /></a></dt>
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
                        <dt><a href="index.php?c=player&id=<?=$val['id']?>"><img src="<?=show_thumb($val['thumb'])?>" /></a></dt>
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