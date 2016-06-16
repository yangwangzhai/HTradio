<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
<style type="text/css">
::selection {
	background-color: #E13300;
	color: white;
}

::moz-selection {
	background-color: #E13300;
	color: white;
}

::webkit-selection {
	background-color: #E13300;
	color: white;
}

body {
	background-color: #fff;
	margin: 40px;
	font: 14px/20px normal;
	color: #4F5155;
}

a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #444;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 14px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	margin: 10px auto;
	width: 450px;
	border: 1px solid #D0D0D0;
	-webkit-box-shadow: 0 0 8px #D0D0D0;
}

p {
	margin: 12px 15px 12px 15px;
}

.btnok {
	background: url(static/images/btnok.png) no-repeat;
	width: 75px;
	height: 29px;
	color: #fff;
	font-weight: bold;
	cursor: pointer;
	border: none;
	display: block;
	text-align: center;
	line-height: 29px;
}
</style>
</head>

<body>
	<div id="container">
		<h1>提示信息：</h1>

		<p style="padding: 5px; font-size: 14px;"><?php echo $message; ?></p>

		<p align="right" style="margin: 20px; font-weight: bold;">
		     
            <?php if($url_forward){?>
                <a href="<?=$url_forward?>" tabindex="0" class="btnok">
				确定 </a>
			<script type="text/javascript">
					
                        function redirect(url, time) {
                            setTimeout("window.location='" + url + "'", time * 1000);
                        }
                        redirect('<?=$url_forward?>', <?=$second?>);
                </script>
                
            <?php }else{?>
            	<a href="javascript:history.back();" class="btnok"> 返 回 </a>
            <?php }?>
          </p>
	</div>
</body>
</html>