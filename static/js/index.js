$(function(){
	var t1_1,t1_2,t2_1,t2_2;
	function clear_animation(){
			clearTimeout(t1_1);
			clearTimeout(t1_2);
			clearTimeout(t2_1);
			clearTimeout(t2_2);
	}
	function waveloop1(){
		$("#banner_bolang_bg_1").css({"left":"-236px"}).animate({"left":"-1233px"},25000,'linear',waveloop1);
	}
	function waveloop2(){
		$("#banner_bolang_bg_2").css({"left":"0px"}).animate({"left":"-1009px"},60000,'linear',waveloop2);
	}
	waveloop1();
	waveloop2();
});