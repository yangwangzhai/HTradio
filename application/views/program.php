<?php $this->load->view('header');?>

<div class="main">
    <div class="pro_left">
        <div class="sort">全部分类</div>
        <ul>
        <?php foreach($program_type_list as $r){?>
            <li data-id="<?=$r['id']?>">
                <a class="type_p" data-id="<?=$r['id']?>" <?php if ($r['id'] ==$cur_id ){ ?> style="background: #CE1006; color: #fff;" <?php }?> href="./index.php?c=index&m=program&type_id=<?=$r['id']?>"><?=$r['title']?>
                </a>
                <div class="float_box" id="float_box<?=$r['id']?>" style="display:none; padding:10px; border-radius: 3px; border:1px solid #CCC; width: 200px; background: #f5f5f5 none repeat; ">
                      <?php
                      $program_type_child = getTypeByPid($r['id']);
                      foreach($program_type_child as $v){?>
                         <a href="./index.php?c=index&m=program&type_id=<?=$v['id']?>"><?=$v['title']?></a>
                      <?php }?>
                </div>
            </li>
         <?php }?>
        </ul>
    </div>
    <div class="pro_right">
        <div class="site">您当前的位置：<a href="#">全部分类</a> > <?=$sub_link?></div>
        <div class="sum">
            <div class="files">共<?=$programme_count?>档节目单</div>
            <div class="best">
                <a style="color:<?=$new_color?>"href="./index.php?c=index&m=program&type_id=<?=$type_id?>&order=new">最新</a>|
                <a style="color:<?=$hot_color?>" href="./index.php?c=index&m=program&type_id=<?=$type_id?>&order=hot">最热</a>
            </div>
        </div>
        <div class="prolist">
             <?php foreach($programme_list as $r){?>
            	<dl>
                	<dt>
                        <a href="./index.php?c=player&meid=<?=$r['id']?>" target="_blank"><img src="<?php if(!empty($r['thumb'])){echo show_thumb( $r['thumb'] );}else{echo base_url()."uploads/default_images/default_jiemu2.jpg";}?>" />
                        </a>
                    </dt>
                    <dd>
                    	<h1>
                            <a target="_blank" href="./index.php?c=player&meid=<?=$r['id']?>" title="<?=$r['title']?>"><?=str_cut($r['title'],30)?></a>
                        </h1>
                        <p style="color:#999;"><?=$r['intro']?str_cut($r['intro'],50,'...'):'暂无描述'?></p>
                        <p>上传者：<a target="_blank"  href="./index.php?c=zhubo&mid=<?=$r['mid']?>"><?=getNickName($r['mid'])?></a></p>
                        <div class="num">
                            <a href="./index.php?c=player&meid=<?=$r['id']?>" class="icon" target="_blank"><?=$r['playtimes']?></a>
                            <a id="icon1_<?=$r['id']?>" class="icon1"><?=$r['fav_count']?></a>
                        </div>
                    	<div class="pbtn">
                            <?php if ($r['is_programme_data']){ ?>
                            <a href="javascript:" onclick="attention_programme(<?=$r['id']?>)" style="color:#ff6600;background-image:url(static/images/is_cross.png);" data-attention="1" id="programid<?=$r['id']?>" class="atten">已收藏</a>
                            <?php }else{  ?>
                            <a href="javascript:" onclick="attention_programme(<?=$r['id']?>)" data-attention="0" id="programid<?=$r['id']?>" class="atten">收藏</a>
                            <?php }?>
                            <a href="javascript:" onclick="message_dialog(<?php if($uid){echo 1;}else{echo 0;}?>,<?=$r['mid']?>,'<?=getNickName($r['mid'])?>')" class="letter">私信</a>
                        </div>
                    </dd>
                </dl>
             <?php }?>     
        </div>
        <!--分页-->
        <div class="page-navigator" style="float: left;">
            <div class="page-cont">
                <div class="page-inner">
                    <?=$pages?>
                </div>
            </div>
        </div>
    </div>

<script>
    //ready begin
    $(document).ready(function(){
        var curr = '';
        $('.ajax_fpage').live('click', function(eve){
            eve.preventDefault();
            var type_id=<?=$type_id?>;
            var href=$(this).attr("href");
            var arr=href.split('per_page=');
            if(arr[1]==''){arr[1]=1;}
            var per_page=arr[1];
            $.ajax({
                url:"index.php?c=index&m=programme_page",
                type:"get",
                dataType:"text",
                data: {
                    'type_id':type_id,
                    'per_page':per_page //当前第几页，用于生成分页
                },
                success: function(html) {
                    $('.prolist').detach();
                    $('.page-navigator').detach();
                    $('.sum').after(html);
                }
            });
        });
    }); /*end ready*/

</script>
<?php $this->load->view('footer');?>
