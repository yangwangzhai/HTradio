<?php $this->load->view('header');?>

<div class="main">
	<div class="find_left">
        <!-- 代码 开始 -->
	<div id="fsD1" class="focus">  
    <div id="D1pic1" class="fPic">  
    <?php foreach($top_list as $r){?>
        <div class="fcon" style="display: none;">
            <a target="_blank" href="index.php?c=player&id=<?=$r['id']?>"><img src="<?php if(!empty($r['thumb'])){echo show_thumb( $r['thumb'] );}else{echo base_url()."uploads/default_images/default_jiemu.jpg";}?>" style="opacity: 1; "></a>
            <span class="shadow"><a target="_blank" href="#<?=$r['id']?>"><?=$r['title']?></a></span>
        </div>
    <?php }?>    
    </div>
    <div class="fbg">  
    <div class="D1fBt" id="D1fBt">  
    <?php foreach($top_list as $k=>$r){ $k++;?>
    	
        <a href="javascript:void(0)" hidefocus="true" target="_self" class="<?php if ($k==1){echo "current";} ?>"><i><?=$k?></i></a>  
     
    <?php }?>    
    </div>  
    </div>  
    <span class="prev"></span>   
    <span class="next"></span>    
</div>  
    <script type="text/javascript">
	Qfast.add('widgets', { path: "static/js/terminator2.2.min.js", type: "js", requires: ['fx'] });  
	Qfast(false, 'widgets', function () {
		K.tabs({
			id: 'fsD1',   //焦点图包裹id  
			conId: "D1pic1",  //** 大图域包裹id  
			tabId:"D1fBt",  
			tabTn:"a",
			conCn: '.fcon', //** 大图域配置class       
			auto: 1,   //自动播放 1或0
			effect: 'fade',   //效果配置
			eType: 'click', //** 鼠标事件
			pageBt:true,//是否有按钮切换页码
			bns: ['.prev', '.next'],//** 前后按钮配置class                          
			interval: 3000  //** 停顿时间  
		}) 
	})  
</script>
    <!-- 代码 结束 -->
        <div class="find_list">
        	<div class="find_title">
                <div class="icon">
                    <img src="static/images/icon.png" />
                </div>
                <div class="name">推荐</div>
                <div class="coutit">
                    <a href="./index.php?c=index&m=program">全部</a>
                </div>
            </div>
            <div class="find_pic">
                <?php foreach($hot_list as $r){?>
                    <dl>
                      <dt>
                          <a href="index.php?c=player&id=<?=$r['id']?>">
                              <div class="shade">
                                  <div class="ear"><?=$r['playtimes']?></div>
                                  <div class="play1"><img src="static/images/play1.png" /></div>
                              </div>
                              <img src="<?php if(!empty($r['thumb'])){echo show_thumb( $r['thumb'] );}else{echo base_url()."uploads/default_images/default_jiemu.jpg";}?>" />
                          </a>
                      </dt>
                      <dd>
                        <h3><a href="index.php?c=player&id=<?=$r['id']?>" title="<?=$r['title']?>"><?=str_cut($r['title'],45)?></a></h3>
                        <p><a target="_blank"  href="./index.php?c=zhubo&mid=<?=$r['mid']?>"><?=getNickName($r['mid'])?></a></p>
                      </dd>
                    </dl>
                  <?php }?>
            </div>
        </div>
        <?php foreach($type_list as $r){?>
            <?php if(!empty($r['program_list'])){?>
                <div class="find_list">
                    <div class="find_title">
                    <div class="icon"><img src="static/images/icon1.png" /></div>
                    <div class="name"><?=$r['title']?></div>
                    <div class="coutit">
                    <?php foreach($r['type_child'] as $c){?>
                    <a href="./index.php?c=index&m=program&type_id=<?=$c['id']?>"><?=$c['title']?></a>
                    <?php }?>
                     <a href="./index.php?c=index&m=program&type_id=<?=$r['id']?>">更多</a>
                    </div>
                  </div>
                    <div class="find_pic">
                    <?php foreach($r['program_list'] as $p){?>
                        <dl>
                          <dt><a href="index.php?c=player&id=<?=$p['id']?>">
                          <div class="shade">
                          <div class="ear"><?=$p['playtimes']?></div>
                          <div class="play1"><img src="static/images/play1.png" /></div></div>
                          <img src="<?php if(!empty($p['thumb'])){echo show_thumb( $p['thumb'] );}else{echo base_url()."uploads/default_images/default_jiemu.jpg";}?>" />
                          </a></dt>
                          <dd>
                            <h3><a href="index.php?c=player&id=<?=$p['id']?>" title="<?=$p['title']?>"><?=str_cut($p['title'],45)?></a></h3>
                            <p><a  target="_blank"  href="./index.php?c=zhubo&mid=<?=$p['mid']?>"><?=getNickName($p['mid'])?></a></p>
                          </dd>
                        </dl>
                     <?php }?>
                    </div>
                </div>
            <?php }?>
        <?php }?>
       </div>
    <div class="find_right">
    	<div class="login">
       	  <div class="land_title">扫描下载安卓版</div>
          <div class="land_btn">  
          <img src="static/images/android_ewm.png"/>
         <!-- <?php if (!$uid){ ?>        
            	<div class="btlogin"><a href="./index.php?c=member&m=login">登陆</a></div>
                <div class="btregister"><a href="./index.php?c=member&m=reg">注册</a></div>    
          <?php }else{    ?>   
           欢迎您，<?=$uname?>,<a href="./index.php?c=member&m=login_out">退出</a>
          <?php  } ?>   -->    
            </div>
      </div>
      <div class="title">热门电台<!--a href="#">/更多</a--></div>
      <div class="radiolist">
      <?php foreach($radio_list as $r){?>
      	<dl>
        <dt><a  target="_blank"  href="./index.php?c=zhubo&mid=<?=$r['id']?>"><img src="<?=show_thumb($r['avatar'])?>" /></a></dt>
        <dd>
        <h5><a  target="_blank"  href="./index.php?c=zhubo&mid=<?=$r['id']?>"><?=getNickName($r['id'])?></a></h5>
        <?php if ($r['is_attention']){ ?>
        <a href="javascript:" onclick="attention(<?=$r['id']?>)" data-attention="1" style=" color:#ff6600;" id="zid<?=$r['id']?>" class="ison">已关注</a>
        <?php }else{  ?>
        <a href="javascript:" onclick="attention(<?=$r['id']?>)" data-attention="0" id="zid<?=$r['id']?>" class="ison">关注</a>
        <?php }?>
        <!--<a href="#" class="ison1">收藏</a>-->
        </dd>
        </dl>
        
      <?php }?>
      </div>
      <div class="title">明星主播<!--a href="#">/更多</a--></div>
      <div class="anchorlist">
      <?php foreach($zhubo_list as $r){?>
      	<dl>
        	<dt><a  target="_blank"  href="./index.php?c=zhubo&mid=<?=$r['id']?>"><img src="<?=show_thumb($r['avatar'])?>" /></a></dt>
            <dd>
                <a  target="_blank"  href="./index.php?c=zhubo&mid=<?=$r['id']?>"><?=getNickName($r['id'])?></a>
                 <?php if ($r['is_attention']){ ?>
                <a href="javascript:" onclick="attention(<?=$r['id']?>)" style="padding-left:6px;color:#ff6600;background-image:url(static/images/is_cross.png)" data-attention="1" id="zid<?=$r['id']?>" class="atten">已关注</a>
                <?php }else{  ?>
                <a href="javascript:" onclick="attention(<?=$r['id']?>)" data-attention="0" id="zid<?=$r['id']?>" class="atten">关注</a>
                <?php }?>
           
            </dd>
        </dl>
     <?php }?>  
      </div>  
      <div class="title">新晋飙升榜<!--a href="#">/更多</a--></div>
      <div class="ranklist">
          <?php foreach ($new_top_list as $k => $val) { ?>
          <div class="tab"> <span><img src="static/images/tea<?=$k+1?>.jpg" /></span> <strong><a href="index.php?c=player&id=<?=$val['id']?>" target="_blank" title="<?=$val['title']?>"><?=str_cut($val['title'],35)?></a></strong> </div>
        <?php } ?>
       </div>
      <div class="title">热播排行榜<!--a href="#">/更多</a--></div>
      <div class="ranklist">
          <?php foreach ($hot_top_list as $k => $val) { ?>
          <div class="tab"> <span><img src="static/images/tea<?=$k+1?>.jpg" /></span> <strong><a href="index.php?c=player&meid=<?=$val['id']?>" target="_blank" title="<?=$val['title']?>"><?=str_cut($val['title'],35)?></a></strong> </div>
        <?php } ?>
          
       </div>
       <div class="title">人气排行榜<!--a href="#">/更多</a--></div>
      <div class="ranklist">
        <?php foreach ($popularity_list as $k => $val) { ?>
          <div class="tab"> <span><img src="static/images/tea<?=$k+1?>.jpg" /></span> <strong><a href="index.php?c=player&id=<?=$val['id']?>" target="_blank" title="<?=$val['title']?>"><?=str_cut($val['title'],35)?></a></strong> </div>
        <?php } ?>
          
      </div>
    </div>
</div>

<?php $this->load->view('footer');?>
