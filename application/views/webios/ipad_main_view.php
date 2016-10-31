<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ipad端</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="static/webios/pad/css/swiper.min.css">
    <link rel="stylesheet" href="static/webios/pad/css/style.css">
    <script src="static/webios/pad/js/jquery-1.9.1.js"></script>
</head>
<body>
<!-- Swiper -->
<div class="swiper-container">
    <div class="swiper-wrapper">
        <?php foreach($channel_list as $key=>$value) :?>
            <div class="swiper-slide"  style="background-image:url(<?=$value['logo'];?>)">
                <div class="reflection">
                    <p><?=$value['title'];?></p>
                </div>
            </div>
        <?php endforeach?>
            <div class="swiper-slide"  style="background-image:url(static/webios/images/music_default.png)">
                <div class="reflection">
                    <p><?=$programme['title']?></p>
                </div>
            </div>
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
</div>
<input type="text" class="values" id="numbers1_value"  value="4" style="width:0; height:0; position:absolute; left:-9999px;">
<div class="bottom"><div class="group"> <a  class="button1" id="btn-next"></a><a  class="button2" id="btn-play"></a><a  id="btn-pause"></a><a  class="button3" id="btn-pre"></a>
        <div class="list-icons"><img src="static/webios/images/playlist_icon.png"/></div>
    </div>
</div>
<div id="btn">
</div>
<audio id="audio" controls style="width:0; height:0; position:absolute; left:-9999px;" autoplay preload="preload"></audio>
<script>
    $(function() {

        // 播放器
        var Player = {
            // 歌曲路径
            path : '',

            // 歌曲数据
            data : null,

            // 当前播放歌曲的 索引
            currentIndex : 4,

            //  播放器元素jquery对象
            $audio : $('audio'),

            // 歌曲列表
            $mList : $('#m-list'),

            //正在播放的歌曲
            $rmusic : $('#rmusic'),

            // 初始化 数据
            init : function() {

                // 数据一般来自服务器端,通过ajax 加载数据,这里是模拟
                Player.data = [
                    <?php foreach($channel_list as $key=>$value) :?>
                    <?php if($key==count($channel_list)-1){?>
                    '<?=$value['add_channel'];?>',
                    <?php }else{?>
                    '<?=$value['add_channel'];?>',
                    <?php }?>
                    <?php endforeach?>
                    "<?=$program[0]['path']?>"
                ];

                // 一般用模板引擎,把数据 与 模板 转换为 视图,来显示,这里是模拟
                var mhtml = '';
                var len = Player.data.length;
                for (var i =0; i < len; i++) {
                    mhtml += '<li><a index="' + i + '">' + Player.data[i] + '</a></li>';
                }
                Player.$mList.html(mhtml);
            },

            // 就绪
            ready : function() {
                // 控制
                //Player.currentIndex=4;
                Player.audio = Player.$audio.get(0);
                $('#ctrl-area').on('click', 'button', function() {
                    Player.$rmusic.html(Player.data[Player.currentIndex]);
                });

                // 播放
                $('#btn-play').click(function() {
                    $(this).hide();
                    $("#btn-pause").show();
                    Player.audio.play();
                    $(".info_box").find(".info_l").removeClass("play");
                    $(".on").find(".info_l").addClass("play");
                    if (Player.currentIndex == 4) {
                        if (Player.currentIndex == -1) {
                            Player.currentIndex = 0;
                        } else if (Player.currentIndex == 0) {
                            Player.currentIndex = (Player.data.length - 1);
                        } else {
                            //Player.currentIndex--;
                        }
                        Player.audio.src = Player.path + Player.data[Player.currentIndex];
                        Player.audio.play();
                    }
                    //异步存储当前播放状态
                    $.ajax({
                        url: "index.php?d=webios&c=webios&m=save_play_status",   //后台处理程序
                        type: "post",         //数据发送方式
                        dataType:"json",    //接受数据格式
                        data:{mid:636,play_status:1,pos:1},  //要传递的数据
                        success:function(data){
                            //alert(data);
                        },
                        error:function(XMLHttpRequest, textStatus, errorThrown)
                        {
                            //alert(errorThrown);
                        }
                    });
                });

                // 暂停
                $('#btn-pause').click(function() {
                    Player.audio.pause();
                    $(this).hide();
                    $("#btn-play").show();
                    $(".info_box").find(".info_l").removeClass("play");
                    //异步存储当前播放状态
                    $.ajax({
                        url: "index.php?d=webios&c=webios&m=save_play_status",   //后台处理程序
                        type: "post",         //数据发送方式
                        dataType:"json",    //接受数据格式
                        data:{mid:636,play_status:0,pos:2},  //要传递的数据
                        success:function(data){
                            //alert(data);
                        },
                        error:function(XMLHttpRequest, textStatus, errorThrown)
                        {
                            //alert(errorThrown);
                        }
                    });
                });

                // 下一曲
                $('#btn-next').click(function() {
                    $("#btn-pause").show();
                    $("#btn-play").hide();
                    Player.currentIndex = $("#numbers1_value").val();
                    if (Player.currentIndex == -1) {
                        Player.currentIndex = 0;
                    } else if (Player.currentIndex == 0) {
                        //Player.currentIndex = Player.data.length-1;
                    } else {
                        Player.currentIndex--;
                    }
                    $("#numbers1_value").val(Player.currentIndex);
                    console.log("Player.currentIndex : " + Player.currentIndex);
                    Player.audio.src = Player.path + Player.data[Player.currentIndex];
                    Player.audio.play();
                    //异步存储当前播放状态
                    $.ajax({
                        url: "index.php?d=webios&c=webios&m=save_play_status",   //后台处理程序
                        type: "post",         //数据发送方式
                        dataType:"json",    //接受数据格式
                        data:{mid:636,play_status:1,pos:3},  //要传递的数据
                        success:function(data){
                            //alert(data);
                        },
                        error:function(XMLHttpRequest, textStatus, errorThrown)
                        {
                            //alert(errorThrown);
                        }
                    });
                });

                // 上一曲
                $('#btn-pre').click(function() {
                    $("#btn-pause").show();
                    $("#btn-play").hide();
                    Player.currentIndex = $("#numbers1_value").val();
                    if (Player.currentIndex == -1) {
                        Player.currentIndex = 0;
                    } else if (Player.currentIndex == (Player.data.length - 1)) {
                        //Player.currentIndex = 0;
                    } else {
                        Player.currentIndex++;
                    }
                    //alert("点击上一曲："+Player.currentIndex);
                    $("#numbers1_value").val(Player.currentIndex);
                    Player.audio.src = Player.path + Player.data[Player.currentIndex];
                    console.log("Player.currentIndex :", Player.currentIndex);
                    Player.audio.play();
                    //异步存储当前播放状态
                    $.ajax({
                        url: "index.php?d=webios&c=webios&m=save_play_status",   //后台处理程序
                        type: "post",         //数据发送方式
                        dataType:"json",    //接受数据格式
                        data:{mid:636,play_status:1,pos:3},  //要传递的数据
                        success:function(data){
                            //alert(data);
                        },
                        error:function(XMLHttpRequest, textStatus, errorThrown)
                        {
                            //alert(errorThrown);
                        }
                    });
                });

                // 单曲循环
                $('#btn-loop').click(function() {
                    console.log("Player.currentIndex :", Player.currentIndex);
                    Player.audio.onended = function() {
                        Player.audio.load();
                        Player.audio.play();
                    };
                });

                // 顺序播放
                $('#btn-order').click(function() {
                    console.log("Player.currentIndex :", Player.currentIndex);
                    Player.audio.onended = function() {
                        $('#btn-next').click();
                    };
                });

                // 随机播放
                $('#btn-random').click(function() {
                    Player.audio.onended = function() {
                        var i = parseInt((Player.data.length - 1) * Math.random());
                        playByMe(i);
                    };
                });

                // 播放指定歌曲
                function playByMe(i) {
                    console.log("index:", i);
                    Player.audio.src = Player.path + Player.data[i];
                    Player.audio.play();
                    Player.currentIndex = i;
                    Player.$rmusic.html(Player.data[Player.currentIndex]);
                }

                // 歌曲被点击
                $('#m-list a').click(function() {
                    playByMe($(this).attr('index'));
                });
            }
        };


        var swiper = new Swiper('.swiper-container', {
            pagination: '.swiper-pagination',
            effect: 'coverflow',
            grabCursor: true,
            //loop : true,
            //loopAdditionalSlides : 0,
            centeredSlides: true,
            slidesPerView: 'auto',
            initialSlide :4,//默认频道
            prevButton:'#btn-next',
            nextButton:'#btn-pre',
            coverflow: {
                rotate: 30,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows : true
            },
            onTouchEnd: function(swiper){
                //alert(swiper.activeIndex);
                $("#numbers1_value").val(swiper.activeIndex);
                //alert(swiper.activeIndex);
                $("#btn-pause").show();
                $("#btn-play").hide();
                var i=$("#numbers1_value").val();
                Player.currentIndex = i;
                Player.audio.src = Player.path + Player.data[i];
                Player.audio.play();
                //异步存储当前播放状态
                $.ajax({
                    url: "index.php?d=webios&c=webios&m=save_play_status",   //后台处理程序
                    type: "post",         //数据发送方式
                    dataType:"json",    //接受数据格式
                    data:{channel_id:Player.currentIndex,mid:636,play_status:1,pos:4},  //要传递的数据
                    success:function(data){
                        //alert(data);
                    },
                    error:function(XMLHttpRequest, textStatus, errorThrown)
                    {
                        //alert(errorThrown);
                    }
                });
            }

        });
        Player.init();
        Player.ready();

        /*$('#btn').click(function(){
            swiper.slideTo(5, 1000, false);//切换到第一个slide，速度为1秒
        });
        function test(){
            $("#btn").trigger('click');
        };*/

        function sync_play(){
            //var playing_channel_type = $(".play").attr("channel-type");
            //var mid = $(".play").attr("mid");
            var playing_id = $("#numbers1_value").val();
            var mid = 636;
            if(mid){
                if(playing_id!='undefined'&&playing_id!=null){
                    //alert("id为："+playing_id);
                    $.ajax({
                        url: "index.php?d=webios&c=webios&m=ipad_tong_bu",   //后台处理程序
                        type: "post",         //数据发送方式
                        dataType:"json",    //接受数据格式
                        data:{playing_id:playing_id,mid:mid},  //要传递的数据
                        success:function(data){
                            if(data['code']==1){
                                $("#numbers1_value").val(data['step']);
                                $('#btn').click(function(){
                                    swiper.slideTo(data['step'], 1000, false);//切换到第一个slide，速度为1秒
                                });
                                $("#btn").trigger('click');
                                Player.audio.src = Player.path + Player.data[data['step']];
                                console.log("Player.currentIndex :", Player.currentIndex);
                                Player.audio.play();
                            }
                            //控制播放状态
                            if(data['play_status']==1){
                                if($('#btn-play').css("display")!='none'){
                                    //alert("播放");
                                    $('#btn-play').trigger('click');
                                }
                            }else{
                                if($('#btn-pause').css("display")!='none'){
                                    //alert("暂停");
                                    $('#btn-pause').trigger('click');
                                }
                            }
                        },
                        error:function(XMLHttpRequest, textStatus, errorThrown)
                        {
                            //alert(errorThrown);
                        }
                    });
                }
            }


        }

        setInterval(sync_play,700);


    });




</script>

<!-- Swiper JS -->
<script src="static/webios/pad/js/swiper.min.js"></script>


</body>
</html>