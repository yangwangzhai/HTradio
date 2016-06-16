 function playQtime(id,u,p) {
	var w = 100;
	var h = 14;
	var pv='';
	pv += '<object width="'+w+'" height="'+h+'" classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab">';
	pv += '<param name="src" value="'+u+'">';
	pv += '<param name="controller" value="true">';
	pv += '<param name="type" value="video/quicktime">';
	pv += '<param name="autoplay" value="true">';
	pv += '<param name="target" value="myself">';
	pv += '<param name="bgcolor" value="black">';
	pv += '<param name="pluginspage" value="http://www.apple.com/quicktime/download/index.html">';
	pv += '<embed src="'+u+'" width="'+w+'" height="'+h+'" controller="true" align="middle" bgcolor="black" target="myself" type="video/quicktime" pluginspage="http://www.apple.com/quicktime/download/index.html"></embed>';
	pv += '</object><br>';
	$("#playbtn-"+id+p).css("display","none");
	$("#player-"+id+p).html( pv );
}

function showImg(id,w,h)
{
	url = '';
	if($('#'+id).length >0){		
		url = $('#'+id).val();
	}
	
	$.dialog({
			id: 'pic',
			title: '图片预览',		
			content: '<img src="./'+url+'" width="'+w+'" height="'+h+'" />',			
			min: false,
			max: false,
			padding:0,	
			margin:0		
	});
	$('.ui_title').css('text-align','left');
}

//弹出选择节目对话框

