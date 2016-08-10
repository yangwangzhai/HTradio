﻿<!DOCTYPE html>
<head>
    <title>合成测试示例</title>
</head>

<body>
	<h2>这是一个合成测试示例</h2>
	<!--<script src="http://blog.faultylabs.com/files/md5.js"></script>	-->
	<script src="http://webapi.openspeech.cn/socket.io/socket.io.js"></script>
	<script src='http://webapi.openspeech.cn/fingerprint.js'></script>
	<script src="http://webapi.openspeech.cn/tts.min.js"></script>
	<script type="text/javascript">
	    /**
		  * 初始化Session对象
		  */
	    var session = new IFlyTtsSession({
                                      'url' : 'http://webapi.openspeech.cn/',
                                      'interval' : '30000',
								      'disconnect_hint' : 'disconnect',
								      'sub' : 'tts'
                                        //'reconnection' : true,
                                        //'reconnectionDelay' : 30000
						         });
		var audio = null;
		
		/**
		  * 输入文本，输出语音播放链接 
		  * @content 待合成文本(不超过4096字节)
		  */
		function play(content) {
		    /***********************************************************以下签名过程需根据实际应用信息填入***************************************************/
		 
		    var appid = "<?=$appid?>";                              //应用APPID，在open.voicecloud.cn上申请即可获得
		    var timestamp = <?=$timestamp?>;                      //当前时间戳，例new Date().toLocaleTimeString()
            var expires = 600000;                          //签名失效时间，单位:ms，例60000
		    //!!!为避免secretkey泄露，签名函数调用代码建议在服务器上完成
		    var signature = "<?=$signature?>";
		   /************************************************************以上签名过程需根据实际应用信息填入**************************************************/
		   
			var params = { "params" : "aue = speex-wb;7,vcn = xiaoyan, ent = intp65, spd = 50, vol = 50, tte = utf8, caller.appid=" + appid + ",timestamp=" + timestamp + ",expires=" + expires, "signature" : signature, "gat" : "mp3"};
			session.start(params, content, function (err, obj)
	        {
			    if(err) {
				    alert("语音合成发生错误，错误代码 ：" + err);
			    } else {
			        if(audio != null)
					{
					    audio.pause();
					}
					audio = new Audio();
					audio.src = '';
	                audio.play();
					audio.src = "http://webapi.openspeech.cn/" + obj.audio_url;
					audio.play();
			    }
		    });
		};
		play("<?=$content?>");
	</script>
</body>
</html>
