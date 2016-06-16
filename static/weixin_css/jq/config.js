// JavaScript Document

//背景变换
$(document).ready(function(){
$('body').bgStretcher({
  images: ['img/bg_1.png', 'img/bg_2.png','img/bg_3.png','img/bg_4.png','img/bg_5.png'],
  imageWidth:1920, 
  imageHeight:1080, 
  slideDirection: 'N',
  nextSlideDelay:10000,
  slideShowSpeed:'normal',
  transitionEffect: 'fade',
  sequenceMode: 'random',
  anchoring: 'left center',
  anchoringImg: 'left center'
  });
});

//NAV MENU
$(function(){

(function(){
var $navcur = $(".nav-current");
var $nav = $("#menu");
var current = ".current";
var itemW = $nav.find(current).innerWidth();	//默认当前位置宽度
var defLeftW = $nav.find(current).position().left;	//默认当前位置Left值

//添加默认下划线
$navcur.width(itemW);

//hover事件
$nav.find("a").hover(function(){
	var index = $(this).index();	//获取滑过元素索引值
	var leftW = $(this).position().left;	//获取滑过元素Left值
	var currentW = $nav.find("a").eq(index).innerWidth();	//获取滑过元素Width值
	$navcur.stop().animate({
		left: leftW,
		width: currentW
	},300);
	
},function(){
	$navcur.stop().animate({
		left: defLeftW,
		width: itemW
	},300)
})
})();

});

//自定义动画
$(document).ready(function(){
	
  $(".qg_act .list1").mouseover(function(){$(".qg_act .list1 div").animate({ right:'-5px'},"fast");});
  $(".qg_act .list1").mouseleave(function(){$(".qg_act .list1 div").animate({ right:'0'},"fast");});
  
  $(".qg_act .list3 .all").mouseover(function(){$(".qg_act .list3 div").animate({ bottom:'-10px'},"fast");});
  $(".qg_act .list3 .all").mouseleave(function(){$(".qg_act .list3 div").animate({ bottom:'-15px'},"fast");});
   
  $(".qg_rcm a").mouseover(function(){$(".qg_rcm a").animate({ bottom:'5px'},"fast");});
  $(".qg_rcm a").mouseleave(function(){$(".qg_rcm a").animate({ bottom:'0'},"fast");});
  
  $(".qg_xz a").mouseover(function(){$(".qg_xz a").animate({ bottom:'5px'},"fast");});
  $(".qg_xz a").mouseleave(function(){$(".qg_xz a").animate({ bottom:'0'},"fast");});
;})

$(document).ready(function(){

    $.each($(".icolink"),function(i,n){
        $(n).mouseover(function(){
			$('em',this).addClass(".dn");
            $('span',this).fadeIn();
			$('em',this).fadeOut();
        }).mouseleave(function(){
            $('span',this).fadeOut();
			$('em',this).fadeIn();

        });
    });
});

$(document).ready(function(){

    $.each($(".icolink2"),function(i,n){
        $(n).mouseover(function(){
            $('span',this).fadeIn();
        }).mouseleave(function(){
            $('span',this).fadeOut();
        });
    });
});


$(document).ready(function(){

    $.each($(".qg_com ul li"),function(i,n){
        $(n).mouseover(function(){
            $('em',this).fadeIn();
        }).mouseleave(function(){
            $('em',this).fadeOut();

        });
    });
});

$(document).ready(function(){

    $.each($(".qg_show .y .sml ul li"),function(i,n){
        $(n).mouseover(function(){
            $('.hdp_font',this).fadeIn();
        }).mouseleave(function(){
            $('.hdp_font',this).fadeOut();

        });
    });
});

$(document).ready(function(){

    $.each($(".vote_review .box_a"),function(i,n){
        $(n).mouseover(function(){
            $('a',this).fadeIn();
        }).mouseleave(function(){
            $('a',this).fadeOut();

        });
    });
});

$(document).ready(function(){

    $.each($(".vote_review .box_b"),function(i,n){
        $(n).mouseover(function(){
            $('a',this).fadeIn();
        }).mouseleave(function(){
            $('a',this).fadeOut();

        });
    });
});


$(document).ready(function(){

    $.each($(".vote_review .box_c"),function(i,n){
        $(n).mouseover(function(){
            $('a',this).fadeIn();
        }).mouseleave(function(){
            $('a',this).fadeOut();

        });
    });
});

$(document).ready(function(){

    $.each($(".qg_uni .up li"),function(i,n){
        $(n).mouseover(function(){
            $('img',this).fadeOut();
        }).mouseleave(function(){
            $('img',this).fadeIn();
        });
    });
});