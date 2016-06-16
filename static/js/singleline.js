/*
	单行线 
	tangjian 最后修改 20120518
*/

var map = null;
var g_color = [ "#4b8105", "#135ed8", "#934338", "#7f127f" ];  // 颜色
var g_activline = null;  // 点击激活的折线对象
var g_addline = null;    // 当前添加的折线对象
var g_addlinepath = [];  // 当前添加的折线对象路径数组
var g_banleft = null;  // 当前激活的禁左标注对象
var g_marker = null; // 当前激活的标注对象

// 网页初始化
function initialize()
{
    map = new BMap.Map("map_canvas");
	map.centerAndZoom(new BMap.Point(108.3157, 22.8219), 14);
	map.addControl(new BMap.NavigationControl());
	map.addControl(new BMap.ScaleControl());
	map.addControl(new BMap.OverviewMapControl());
	map.addControl(new BMap.MapTypeControl());
	map.enableScrollWheelZoom();
	map.setDefaultCursor("auto");
	
	// 显示线路
	showline();
	
	// 点击添加按钮
	$("#addbutton").click(function(){
		resetform();
		g_addline = 1;
		// 点击 地图开始 划线
		map.addEventListener("click", addline);
	});
	
	// 点击 禁左按钮
	$("#addbanleft").click(function(){
		resetform();	
		g_addline = 1;
		map.addEventListener("click", addbanleft);
	});
	
	// 点击提交按钮
	$("#submit").click(submitform);
	
	// 点击删除按钮
	$("#deletebutton").click(function(){	
		if(confirm("确定该线段吗？")){
			var id = $("#id").val();
			if( id > 0 ) {
				$.get("index.php?d=admin&c=singleline&m=delete&id="+id,function(data){
					location.reload();
					map.removeOverlay(g_activline);	
					resetform();
				});
			} else {
				map.removeOverlay(g_addline);	
				resetform();
			}
		}
	});
}

// 添加线路 划线
function addline(e)
{
	map.addOverlay(g_addline);
	map.removeOverlay(g_addline);	
	g_addlinepath.push(e.point);	
	g_addline = new BMap.Polyline(g_addlinepath, {strokeColor:"blue", strokeWeight:4, strokeOpacity:0.7});	
	map.addOverlay(g_addline);
	$("#path").val( $("#path").val() + e.point.lng + "," + e.point.lat + " " );
}

//添加 禁左
function addbanleft(e)
{
	var point = new BMap.Point(e.point.lng, e.point.lat);
	var marker = new BMap.Marker( point );  // 创建标注    
	map.addOverlay(marker);
	
	$("#path").val( e.point.lng + "," + e.point.lat);
	$("#status").val(2);
	map.removeEventListener("click", addbanleft);
}

// 提交表单
function submitform()
{
	var id = $("#id").val();
	var title = $("#title").val();
	var status = $("#status").val();
	var path = $("#path").val();
	var z_index = $("#z_index").val();
	var updatetime = $("#updatetime").val();
	
	if (path == "") {
		$("#path").focus();
		return ;
	}
	
	$.post("index.php?d=admin&c=singleline&m=save", { id:id, title:title, status:status, path:path, z_index:z_index, updatetime:updatetime }, function(dataid){		
		if (dataid) {	
			location.reload();
			if (status==10) {
				var icon = new BMap.Icon("./static/admin_img/banleft.png", new BMap.Size(40,67));
				icon.setAnchor( new BMap.Size(10,34) );
				addbanleft.setIcon(icon);					
			}
			if (status>10) {
				var icon = new BMap.Icon("./static/admin_img/single"+status+".png", new BMap.Size(40,67));
				icon.setAnchor( new BMap.Size(10,34) );
				addbanleft.setIcon(icon);
			}	
						
			addBanleftListener(addbanleft, id);  // 侦听改线段，点击线段的时候
			
			resetform();
			alert("成功！");		
		} 
	});		
}

// 显示线路
function showline()
{	
	$.get("index.php?d=admin&c=singleline&m=list_all", function(data) {	
		data = eval('('+ data +')');
		for( var i=0; i<data.length; i++) {	
			var id = data[i].id;
			var status = data[i].status;
			var path_array = data[i].path.split(' ');
			var Coordinates = [];
			var color = g_color[ status ];
			
			if (status > 1) { // 创建禁左标注
				var latlng = data[i].path.split(',');				
				var point = new BMap.Point(latlng[0], latlng[1]);
				var marker = new BMap.Marker( point );
				if (status==10) {
					var icon = new BMap.Icon("./static/admin_img/banleft.png", new BMap.Size(40,67));
					icon.setAnchor( new BMap.Size(10,34) );
					marker.setIcon(icon);					
				}
				if (status>10) {
					var icon = new BMap.Icon("./static/admin_img/single"+status+".png", new BMap.Size(40,67));
					icon.setAnchor( new BMap.Size(10,34) );
					marker.setIcon(icon);
				}			
				
				map.addOverlay(marker);				
				addBanleftListener(marker, id);  // 侦听改线段，点击线段的时候
				
			} else { // 正常的划线
				for(var n=0; n<path_array.length; n++) {			
					var latlng = path_array[n].split(',');		
					Coordinates.push( new BMap.Point(latlng[0],latlng[1]) );
				}
				
				var polyline = new BMap.Polyline(Coordinates, {strokeColor:color, strokeWeight:4, strokeOpacity:1});
				
				map.addOverlay(polyline);
				clickfn(polyline,id);  // 侦听改线段，点击线段的时候
			}		
		}
	});	
}

// 点击线段的时候 激活 用于修改
function clickfn(line,id)
{	
	line.addEventListener('click', function(event) {		
		if(g_addline != null) {  // 添加状态下 不可以点击修改
			return ;
		}
		
		if(g_activline != null){  // 把前一条被点击的线段颜色复原
			g_activline.setStrokeColor( g_color[$("#status").val()] );
		}
		
		line.setStrokeColor("#000");
		g_activline = line;
		$.get("index.php?d=admin&c=singleline&m=get_one&id="+id, function(data){
			data = eval('('+ data +')');
			
			$("#id").val( data.id );
			$("#title").val( data.title );
			$("#status").val( data.status );
			$("#path").val( data.path );
			$("#z_index").val( data.z_index );
			$("#updatetime").val( data.updatetime );
		});
	});
}

//禁左 监听事件
function addBanleftListener(marker,id)
{
	marker.addEventListener('click', function(event) {	
		g_banleft = marker;
		$.get("index.php?d=admin&c=singleline&m=get_one&id="+id, function(data){
			data = eval('('+ data +')');			
			$("#id").val( data.id );
			$("#title").val( data.title );
			$("#status").val( data.status );
			$("#path").val( data.path );
			$("#z_index").val( data.z_index );
			$("#updatetime").val( data.updatetime );
		});
	});
}

// 表单初始化
function resetform()
{	
	g_activline = null;
	g_addline = null;
	g_addlinepath = [];
	
	$("#id").val("");
	$("#title").val("");
	$("#status").val("0");
	$("#path").val("");
	$("#z_index").val("0");
	$("#updatetime").val(getTimes());
	
	map.removeEventListener("click", addline);
	map.removeEventListener("click", addbanleft);	
}

