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
                    <div class="files">共<?=$program_count?>档节目</div>
                    <div class="best">
                    	
                        <a style="color:<?=$new_color?>"href="./index.php?c=index&m=program&type_id=<?=$type_id?>&order=new">最新</a>|
                        <a style="color:<?=$hot_color?>" href="./index.php?c=index&m=program&type_id=<?=$type_id?>&order=hot">最热</a>
                    </div>
                </div>
            <div class="prolist">
             <?php foreach($program_list as $r){?>
            	<dl>
                	<dt><a href="./index.php?c=player&id=<?=$r['id']?>"><img src="<?=show_thumb($r['thumb'])?>" /></a></dt>
                  <dd>
                    	<h1><a href="./index.php?c=player&id=<?=$r['id']?>" title="<?=$r['title']?>"><?=str_cut($r['title'],30)?></a></h1>
                        <p style="color:#999;"><?=$r['description']?str_cut($r['description'],50,'...'):'&nbsp;'?></p>
                        <p>主播：<a target="_blank"  href="./index.php?c=zhubo&mid=<?=$r['mid']?>"><?=getNickName($r['mid'])?></a></p>
                        <div class="num">
                            <a href="./index.php?c=player&id=<?=$r['id']?>" class="icon"><?=$r['playtimes']?></a>
                            <a id="icon1_<?=$r['id']?>" class="icon1"><?=$r['fav_count']?></a>
                        </div>
                    	<div class="pbtn">
                             <?php if ($r['is_program_data']){ ?>
                <a href="javascript:" onclick="attention_program(<?=$r['id']?>)" style="color:#ff6600;background-image:url(static/images/is_cross.png);" data-attention="1" id="programid<?=$r['id']?>" class="atten">已关注</a>
                <?php }else{  ?>
                <a href="javascript:" onclick="attention_program(<?=$r['id']?>)" data-attention="0" id="programid<?=$r['id']?>" class="atten">关注</a>
                <?php }?>
                            <a href="javascript:" onclick="message_dialog(<?=$r['mid']?>,'<?=getNickName($r['mid'])?>')" class="letter">私信</a>
                        </div>
                    </dd>
                </dl>
             <?php }?>     
            </div>
        </div>
    </div>

<?php $this->load->view('footer');?>
