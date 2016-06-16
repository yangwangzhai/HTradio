<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?=$value[Title]?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport"
	content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" type="text/css"
	href="static/css/client-page1baa9e.css">
<!--[if lt IE 9]>
    <link rel="stylesheet" type="text/css" href="static/css/pc-page1b2f8d.css"/>
    <![endif]-->
<link media="screen and (min-width:1000px)" rel="stylesheet"
	type="text/css" href="static/css/pc-page1b2f8d.css">
<style>
body {
	-webkit-touch-callout: none;
	-webkit-text-size-adjust: none;
}
</style>
<style>
#nickname {
	overflow: hidden;
	white-space: nowrap;
	text-overflow: ellipsis;
	max-width: 90%;
}

ol,ul {
	list-style-position: inside;
}

#activity-detail .page-content .text {
	font-size: 16px;
}
</style>
</head>

<body id="activity-detail">
	<img style="position: absolute; top: -1000px;"
		src="static/css/ico_loading1984f1.gif" width="12px">

	<div class="page-bizinfo">
		<div class="header">
			<h1 id="activity-name"><?=$value[Title]?></h1>
			<p class="activity-info">
				<span id="post-date" class="activity-meta no-extra"><?=times($value[addtime])?></span>
				<a href="javascript:viewProfile();" id="post-user"
					class="activity-meta"> <span class="text-ellipsis"><?=WXRADIONAME?></span><i
					class="icon_link_arrow"></i>
				</a>
			</p>
		</div>
	</div>

	<div id="page-content" class="page-content">
		<div id="img-content">
			<div class="media" id="media">
				<?php if($value[PicUrl]){?><img src="<?=$value[PicUrl]?>"><?php }?>
			</div>

			<div class="text">
            	<?=$value[content]?>
            </div>
			<br>
		</div>
	</div>
</body>
</html>