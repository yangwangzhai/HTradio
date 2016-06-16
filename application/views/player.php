<?php $this->load->view('header');?>

<script type="text/javascript" src="static/js/jplayer/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="static/js/jplayer/jplayer.playlist.min.js"></script>
<style>
    #jp_container_1{
    	margin-left: 50px;
        width:450px;
        height:90px;
        background-color: #EDEDED;
        padding-top: 10px;
    }

    .jp-progress{
        margin-top: 10px;
    }

    .jp-seek-bar{
        background: url('static/images/jplayer.blue.monday.jpg') repeat-x 0 -202px;
        height: 12px;
    }

    .jp-play-bar{
        height: 12px;
        background: url('static/images/jplayer.blue.monday.jpg') repeat-x 0 -220px;
    }

    .jp-volume-controls{
         width:60px;
         height:7px;
         display:inline-block;
         cursor: pointer;
    }

    .jp-volume-bar{
        background: url('static/images/jplayer.blue.monday.jpg') repeat-x 0 -250px;
        height:5px;
    }

    .jp-volume-bar-value{
        background: url('static/images/jplayer.blue.monday.jpg') repeat-x 0 -256px;
        height: 5px;
    }

    .jp-duration{
        float: right;
    }

    .jp-repeat{
        display: inline-block;
        width:25px;
        height: 19px;
        background: url('static/images/jplayer.blue.monday.jpg') repeat-x 0 -290px;
    }
    .jp-repeat:hover{
        background: url('static/images/jplayer.blue.monday.jpg') repeat-x -30px -290px;
    }
    .jp-repeat-off{
        display: inline-block;
        width:25px;
        height: 19px;
        background: url('static/images/jplayer.blue.monday.jpg') repeat-x -60px -290px;
    }
    .jp-repeat-off:hover{
        background: url('static/images/jplayer.blue.monday.jpg') repeat-x -90px -290px;
    }

    #jp-playlist {
    	margin: 20px 0 0 50px;
        border: 1px solid gray;
        min-height: 200px;
        width:450px;
        background-color: #EDEDED;
    }

    #jp-playlist ul{
        line-height: 25px;

        list-style: none;
        min-width: 200px;
        
    }

    .curr{
    	color: red;
    }

    
</style>
	<div id="jquery_jplayer_1"></div><!--播放音频的flash隐藏窗口-->
    <div id="jp_container_1">
        <div class="jp-title">
            
        </div>

        <div class="jp-progress">
            <div class="jp-seek-bar">
                <div class="jp-play-bar"></div>
            </div>
        </div>
        <div>
            <span class="jp-current-time"></span>
            <span class="jp-duration"></span>
        </div>
        <span class="jp-controls">
            <input type="button" class="jp-previous" value="上一首" />
            <input type="button" class="jp-play" value="播放" />
            <input type="button" class="jp-pause" value="暂停" />
            <input type="button" class="jp-next"  value="下一首" />
            <input type="button" class="jp-stop" value="停止" />
            <input type="button" class="jp-mute" value="静音" />
            <input type="button" class="jp-unmute" value="取消静音" />
        </span>
        <span class="jp-volume-controls">
            <div class="jp-volume-bar">
                <div class="jp-volume-bar-value"></div>
            </div>
        </span>

        <span class="jp-toggles">
            <span class="jp-repeat"></span>
            <span class="jp-repeat-off"></span>
            <a href="javascript:toggle_list();" style="float:right;margin-right:5px;">列表</a>
        </span>

    
    </div>
    <?php if(isset($list)) { ?>
    <div id="jp-playlist">
        <ul>
            <?php foreach($list as $val) { ?>
            <li data-id="<?=$val['id']?>" class="<?=$id==$val['id']?'curr':''?>"><?=$val['title']?></li>
            <?php } ?>
        </ul>
    </div>
    <?php } ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#jp-playlist li').click(function(){
        	var id = $(this).attr('data-id');
        	geturl(id);
        	$(this).addClass('curr').siblings().removeClass('curr');
        });

        $('.jp-next').click(function(){
        	next();
        });

        $('.jp-previous').click(function(){
        	previous();
        })
        
    });

    var player = $("#jquery_jplayer_1").jPlayer({
		ready: function (event) {
			geturl( <?php echo $id; ?> );
		},
		ended:function(event) {
			next();
			
		},
		play:function(event){
			$('.curr').css({marginLeft:'10px'}).siblings().css({marginLeft:'0px'});

		},
		pause:function(event){
			$('.curr').css({marginLeft:'0px'});
		},
		swfPath: "static/js/jplayer",
		supplied: "m4a, mp3",
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
    	var obj = $('#jp-playlist .curr').eq(0);
		var next = $('.curr').next();

		var id = next.attr('data-id');
		if(id == undefined){
			if($('#jp_container_1').hasClass('jp-state-looped')) {
				id = $('#jp-playlist li').first().attr('data-id');
				geturl(id);
				$('.curr').removeClass('curr');
				$('#jp-playlist li').first().addClass('curr');
				return;
			}else{
				return false;
			}
			
		}
		geturl(id);
		obj.removeClass('curr');
		next.addClass('curr');
		return true;
    }

    function previous() {
    	var obj = $('#jp-playlist .curr').eq(0);
		var prev = $('.curr').prev();

		var id = prev.attr('data-id');
		if(id == undefined){
			return false;
		}
		geturl(id);
		obj.removeClass('curr');
		prev.addClass('curr');
		return true;
    }

    function toggle_list(){

        $('#jp-playlist').toggle(500);
    }
</script>
<?php $this->load->view('footer');?>