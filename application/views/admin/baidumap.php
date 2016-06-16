<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>系统管理中心</title>
<link rel="stylesheet" type="text/css"	href="static/admin_img/admincp.css" />
<link rel="stylesheet"	href="static/js/kindeditor410/themes/default/default.css" />
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>
<script type="text/javascript" src="static/js/jquery-1.7.1.min.js"></script>
<script charset="utf-8" src="static/js/kindeditor410/kindeditor.js?2"></script>
<script charset="utf-8" src="static/js/kindeditor410/lang/zh_CN.js"></script>
<script type="text/javascript" src="static/js/lhgdialog/lhgdialog.min.js"></script>
<script type="text/javascript" src="static/js/common.js?1"></script>

<script>
var map = null;
var marker = null;
var LocalSearch = null;  // 搜索

$(document).ready(function(){
	
});

// 地图初始化
function intiBaiduMap()
{	
	map = new BMap.Map("map_canvas");
	map.centerAndZoom(new BMap.Point(108.353863,22.819552), 14);
	map.addControl(new BMap.NavigationControl());
	map.addControl(new BMap.ScaleControl());
	map.addControl(new BMap.OverviewMapControl());
	map.addControl(new BMap.MapTypeControl());
	map.enableScrollWheelZoom();
	map.setDefaultCursor("auto");
	
	map.addEventListener("click", addbanleft);	
	
	// 点击搜索按钮
	$("#search").click(search_local);
	
}

//添加 标注
function addbanleft(e)
{
	if(marker !== null) map.removeOverlay(marker);
	var point = new BMap.Point(e.point.lng, e.point.lat);
	marker = new BMap.Marker( point );  // 创建标注    
	map.addOverlay(marker);
	
	$(window.parent.document).find("#longlat").val( e.point.lng + "," + e.point.lat);
	//$("#longlat").val( e.point.lng + "," + e.point.lat);	
	//map.removeEventListener("click", addbanleft);
}

// 本地搜索 根据关键词
function search_local()
{
	var keywords = $("#keywords").val();	
	if(keywords){
		if(LocalSearch != null) LocalSearch.clearResults(); // 先清除上次搜索结果
		
		LocalSearch = new BMap.LocalSearch(map, {    
			renderOptions: {map: map, panel: "results"}    
		});
		LocalSearch.search(keywords);  
	}	
}
</script>
</head>

<body onLoad="intiBaiduMap()">
<input name="keywords" type="text" class="text" id="keywords"> <input type="button" value="搜索" class="btn" id="search"><hr />
<div id="map_canvas" style="width:560px;height:400px;"></div>

</body>
</html>
