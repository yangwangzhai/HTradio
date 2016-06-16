<!DOCTYPE HTML>
<html>
<head>
    <script type="text/javascript" src="static/hls/flowplayer-3.2.12.min.js"></script>
    <script type="text/javascript" src="static/hls/flowplayer.ipad-3.2.12.min.js"></script>
</head>

<body>
<!-- player container-->
<a style="display: block; width: 560px; height: 225px;" id="flashls_vod">
</a>
<!-- Flowplayer installation and configuration -->
<script type="text/javascript">
    flowplayer("flashls_vod", "static/hls/flowplayer.swf", {
        // configure the required plugins
        plugins: {
            flashls: {
                url: 'static/hls/flashlsFlowPlayer.swf',
            }
        },
        clip: {
            url: "160509043852_668569.m3u8",
            //url: "http://devimages.apple.com/iphone/samples/bipbop/bipbopall.m3u8",
            //live: true,
            autoPlay: false,
            urlResolvers: "flashls",
            provider: "flashls"
        }
    }).ipad();
</script>


</body>
</html>