<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ipad端</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="static/webios/pad/css/swiper.min.css">
    <link rel="stylesheet" href="static/webios/pad/css/style.css?22">
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
<input type="hidden" id="mid" value="<?=$mid?>">
<input type="hidden" id="time" value="<?=$time?>">
<input type="hidden" id="username_hide" value="<?=$username?>">
<!--<input type="hidden" id="password_hide" value="<?/*=$password*/?>">-->
<input type="hidden" id="numbers1_value"  value="4" >
<div class="bottom">
    <div class="group">
        <a  class="button1" id="btn-next"></a>
        <a  class="button2" id="btn-play"></a>
        <a  id="btn-pause"></a>
        <a  class="button3" id="btn-pre"></a>
        <div class="list-icons">
            <img src="static/webios/images/playlist_icon.png"/>
        </div>
        <div class="sound-icon"></div>
        <div class="login-icon">
          <?php if(!empty($avatar)){echo "<img class='avatar' width=60 height=60 style='margin-bottom:30px;' src=".$avatar.">";}?>
        </div>
    </div>
</div>
<!--登录框开始-->
<form id="form">
    <div class="login-bg">
        <div class="login-box">
            <h3 id="login_h3"><span class="login-close"></span>登录</h3>
                <ul>
                    <p><input type="text" class="login-text" id="username" value="<?=$username?>" placeholder="用户名"></p>
                    <p><input type="password" class="login-text" id="password" value="<?=$password?>" placeholder="密码"></p>
                    <input type="submit" class="login-btn" value="登录">
                </ul>
        </div>
    </div>
</form>
<div class="loginOut-bg">
    <div class="login-box">
        <h3 id="login_h3"><span class="login-close"></span>退出</h3>
        <ul>
            <p><input type="text" class="login-text" id="username_out" value="<?=$username?>" readonly="readonly" placeholder="用户名"></p>
            <!--<p><input type="password" class="login-text" id="password_out" value="<?/*=$password*/?>" readonly="readonly" placeholder="密码"></p>-->
            <a href="index.php?d=webios&c=webios&m=ipad_out"><input type="button" class="login-btn" value="退出"></a>
        </ul>
    </div>
</div>
<!--登录框结束-->
<script>
    $('.login-icon').click(function() {
        var mid = $("#mid").val();
        if(mid){
            $(".loginOut-bg").show();
            $("#username_out").val($("#username_hide").val());
            //$("#password_out").val($("#password_hide").val());
        }else{
            $(".login-bg").show();
        }

    });
    $('.login-close').click(function() {
        var mid = $("#mid").val();
        if(mid){
            $(".loginOut-bg").hide();
        }else{
            $(".login-bg").hide();
        }
    });

    $(document).ready(function(){
        // 使用 jQuery异步提交表单
        $('#form').submit(function() {
            var username = $("#username").val();
            var password = $("#password").val();
            $.ajax({
                url: "index.php?d=webios&c=webios&m=ipad_login",   //后台处理程序
                type: "post",         //数据发送方式
                dataType:"json",    //接受数据格式
                data:{username:username,password:password},  //要传递的数据
                success:function(data){
                    if(data['code']==0){
                        //alert(data['mes']);
                        $(".login_h4").remove();
                        $("#login_h3").after("<h4 class='login_h4' style='text-align: center;color: #990000;'>"+data['mes']+"</h4>");
                    }else{
                        //alert(data['mes']);
                        //alert(data['avatar']);
                        $(".login_h4").remove();
                        $(".avatar").remove();
                        $(".login-bg").hide();
                        $(".login-icon").append("<img class='avatar' width=60 height=60 style='margin-bottom:30px;' src="+data['avatar']+">");
                        $("#mid").val(data['mid']);
                        $("#username_hide").val(data['username']);
                        //$("#password_hide").val(data['password']);
                        var mid = data['mid'];
                        var channel_id = $("#numbers1_value").val();
                        $.ajax({
                            url: "index.php?d=webios&c=webios&m=save_play_status",   //后台处理程序
                            type: "post",         //数据发送方式
                            dataType:"json",    //接受数据格式
                            data:{channel_id:channel_id,mid:mid,play_status:1},  //要传递的数据
                            success:function(data){
                                $("#time").val(data);
                                sync_play(0);
                            },
                            error:function(XMLHttpRequest, textStatus, errorThrown)
                            {
                                //alert(errorThrown);
                            }
                        });

                    }

                },
                error:function(XMLHttpRequest, textStatus, errorThrown)
                {
                    //alert(errorThrown);
                }
            });
            return false;
        });
    });

</script>
<div id="btn">
</div>
<audio id="audio" controls style="width:0; height:0; position:absolute; left:-9999px;" preload="preload"></audio>
<script>

    var swiper;
    var Player;
    $(function() {

        // 播放器
         Player = {
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
                $("#btn-pause").show();
                $("#btn-play").hide();
                Player.audio = Player.$audio.get(0);
                $('#ctrl-area').on('click', 'button', function() {
                    Player.$rmusic.html(Player.data[Player.currentIndex]);
                });

                // 播放
                $('#btn-play').click(function(e,num) {
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
                    if (num==undefined) {   //num==undefined时，主动调整状态，不等于undefined时，被动调整
                        var mid = $("#mid").val();
                        if (mid) {
                            $.ajax({
                                url: "index.php?d=webios&c=webios&m=save_play_status",   //后台处理程序
                                type: "post",         //数据发送方式
                                dataType: "json",    //接受数据格式
                                data: {mid: mid, play_status: 1, pos: 1},  //要传递的数据
                                success: function (data) {
                                    //alert(data);
                                    if(data==1){
                                        if($('#btn-play').css("display")!='none'){
                                            //alert("播放");
                                            $('#btn-play').trigger('click',[1]);
                                        }
                                    }
                                },
                                error: function (XMLHttpRequest, textStatus, errorThrown) {
                                    //alert(errorThrown);
                                }
                            });
                        }
                    }
                });

                // 暂停
                $('#btn-pause').click(function(e,num) {
                    Player.audio.pause();
                    $(this).hide();
                    $("#btn-play").show();
                    $(".info_box").find(".info_l").removeClass("play");
                    //异步存储当前播放状态
                    if (num==undefined) {   //num==undefined时，主动调整状态，不等于undefined时，被动调整
                        var mid = $("#mid").val();
                        if (mid) {
                            $.ajax({
                                url: "index.php?d=webios&c=webios&m=save_play_status",   //后台处理程序
                                type: "post",         //数据发送方式
                                dataType: "json",    //接受数据格式
                                data: {mid: mid, play_status: 0, pos: 2},  //要传递的数据
                                success: function (data) {
                                    if(data==0){
                                        if($('#btn-pause').css("display")!='none'){
                                            $('#btn-pause').trigger('click',[1]);
                                        }
                                    }
                                },
                                error: function (XMLHttpRequest, textStatus, errorThrown) {
                                    //alert(errorThrown);
                                }
                            });
                        }
                    }
                });

                // 上一曲
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
                    var mid = $("#mid").val();
                    if(mid){
                        $.ajax({
                            url: "index.php?d=webios&c=webios&m=save_play_status",   //后台处理程序
                            type: "post",         //数据发送方式
                            dataType:"json",    //接受数据格式
                            data:{channel_id:Player.currentIndex,mid:mid,play_status:1},  //要传递的数据
                            success:function(data){
                                //alert("当期时间："+data) ;
                                $("#time").val(data);
                            },
                            error:function(XMLHttpRequest, textStatus, errorThrown)
                            {
                                //alert(errorThrown);
                            }
                        });
                    }
                });

                // 下一曲
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
                    //alert("点击下一曲："+Player.currentIndex);
                    $("#numbers1_value").val(Player.currentIndex);
                    Player.audio.src = Player.path + Player.data[Player.currentIndex];
                    console.log("Player.currentIndex :", Player.currentIndex);
                    Player.audio.play();
                    //异步存储当前播放状态
                    var mid = $("#mid").val();
                    if(mid){
                        $.ajax({
                            url: "index.php?d=webios&c=webios&m=save_play_status",   //后台处理程序
                            type: "post",         //数据发送方式
                            dataType:"json",    //接受数据格式
                            data:{channel_id:Player.currentIndex,mid:mid,play_status:1},  //要传递的数据
                            success:function(data){
                                //alert("当期时间："+data) ;
                                $("#time").val(data);
                            },
                            error:function(XMLHttpRequest, textStatus, errorThrown)
                            {
                                //alert(errorThrown);
                            }
                        });
                    }
                });
            }
        };


        swiper = new Swiper('.swiper-container', {
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
                $("#numbers1_value").val(swiper.activeIndex);
                //alert(swiper.activeIndex);
                $("#btn-pause").show();
                $("#btn-play").hide();
                var i=$("#numbers1_value").val();
                Player.currentIndex = i;
                Player.audio.src = Player.path + Player.data[i];
                Player.audio.play();
                //异步存储当前播放状态
                var mid = $("#mid").val();
                if(mid){
                    $.ajax({
                        url: "index.php?d=webios&c=webios&m=save_play_status",   //后台处理程序
                        type: "post",         //数据发送方式
                        dataType:"json",    //接受数据格式
                        data:{channel_id:i,mid:mid,play_status:1},  //要传递的数据
                        success:function(data){
                            //alert("当期时间："+data) ;
                            $("#time").val(data);
                        },
                        error:function(XMLHttpRequest, textStatus, errorThrown)
                        {
                            //alert(errorThrown);
                        }
                    });
                }
            }

        });
        Player.init();
        Player.ready();

        //点击语音按钮，开始录音
        $(".sound-icon").click(function(){
            //先暂停播放
            if($('#btn-pause').css("display")!='none'){
                $('#btn-pause').trigger('click',[1]);
                var mid = $("#mid").val();
                //异步存储当前播放状态
                if(mid){
                    $.ajax({
                        url: "index.php?d=webios&c=webios&m=save_play_status",   //后台处理程序
                        type: "post",         //数据发送方式
                        dataType:"json",    //接受数据格式
                        data:{mid:mid,play_status:0,pos:2},  //要传递的数据
                        success:function(data){
                            //alert(data);
                            if(data==0){
                                if($('#btn-pause').css("display")!='none'){
                                    //alert("暂停");
                                    $('#btn-pause').trigger('click',[1]);
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
            //确认已经暂停播放
            if($('#btn-play').css("display")!='none'){
                window.AndroidJS.startSpeak();
            }

        });


    });

    //接收识别的文字
    function receiveSpeak(str){
        var playing_id = $("#numbers1_value").val();
        var mid = $("#mid").val();

        $.ajax({
            url: "index.php?d=webios&c=webios&m=ipad_voice_distinguish",   //后台处理程序
            type: "post",         //数据发送方式
            dataType:"json",    //接受数据格式
            data:{mid:mid,str:str,playing_id:playing_id},  //要传递的数据
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
                }
            },
            error:function(XMLHttpRequest, textStatus, errorThrown)
            {
                //alert(errorThrown);
            }
        });
    }


    function sync_play (flag){
        var playing_id = $("#numbers1_value").val();
        var mid = $("#mid").val();
        if(mid==''){
            mid = 0;
        }
        var time = $("#time").val();
        if(time==''){
            time = 0;
        }
        if(mid){
            if(playing_id!='undefined'&&playing_id!=null){
                //alert("id为："+playing_id);
                $.ajax({
                    url: "index.php?d=webios&c=webios&m=ipad_tong_bu",   //后台处理程序
                    type: "post",         //数据发送方式
                    dataType:"json",    //接受数据格式
                    data:{playing_id:playing_id,time:time,mid:mid,flag:flag},  //要传递的数据
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
                                $('#btn-play').trigger('click',[1]);
                            }
                        }else{
                            if($('#btn-pause').css("display")!='none'){
                                //alert("暂停");
                                $('#btn-pause').trigger('click',[1]);
                            }
                        }

                        setTimeout("sync_play(1)",700);

                    },
                    error:function(XMLHttpRequest, textStatus, errorThrown)
                    {
                        setTimeout("sync_play(1)",700);
                        //alert(errorThrown);
                    }
                });
            }
        }

    }

    sync_play(0);

    function android_play(){
        var i=$("#numbers1_value").val();
        Player.currentIndex = i;
        Player.audio.src = Player.path + Player.data[i];
        //alert(i);
        //alert(Player.audio.src);
        Player.audio.play();

    }

    //setInterval(sync_play,700);


</script>

<!-- Swiper JS -->
<script src="static/webios/pad/js/swiper.min.js"></script>


</body>
</html>