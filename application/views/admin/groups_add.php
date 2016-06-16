<?php $this->load->view('admin/header');?>

<div class="mainbox nomargin">
<form action="<?=$this->baseurl?>&m=save" method="post">
		<input type="hidden" name="id" value="<?=$id?>">
		<table width="99%" border="0" cellpadding="5" cellspacing="0" class="opt">
			<tr>
				<th width="100">群名称</th>
				<td><input type="text" class="txt" name="value[title]"
					value="<?=$value[title]?>" style="width: 400px;" /></td>
			</tr>
			<tr>
				<th >关键词</th>
				<td><input type="text" class="txt" name="value[keywords]"
					value="<?=$value[keywords]?>" style="width: 400px;" />一句话广告</td>
			</tr>
			
			<tr>
				<th>详细简介</th>
				<td><textarea name="value[description]" rows="5" id="description" style="width: 400px;"><?=$value[description]?></textarea></td>
			</tr>
			<tr>
				<th>广告文字</th>
				<td><textarea name="value[ad_des]" rows="5" id="description" style="width: 400px;"><?=$value[ad_des]?></textarea></td>
			</tr>
			<tr>
				<th>群标志</th>
				<td><input name="value[thumb]" class="txt" type="text" id="thumb" style="width: 400px;"
					value="<?=$value[thumb]?>" /><input type="button" value="选择.."
					onclick="upfile('thumb')" class="btn" /> &nbsp;&nbsp;<input type="button" value="预览"
					onclick="showImg('thumb',170,170)" class="btn" />&nbsp;&nbsp;图片尺寸600*300像素</td>
			</tr>
			<tr>
				<th>广告图片</th>
				<td><input name="value[ad_pic]" class="txt" type="text" id="ad_pic" style="width: 400px;"
					value="<?=$value[ad_pic]?>" /><input type="button" value="选择.."
					onclick="upfile('ad_pic')" class="btn" /> &nbsp;&nbsp;<input type="button" value="预览"
					onclick="showImg('ad_pic',170,170)" class="btn" />&nbsp;&nbsp;图片尺寸600*300像素</td>
			</tr>
			<tr>
				<th >群类型</th>
				<td><input type="text" class="txt" name="value[type]"
					value="<?=$value[type]?>" style="width: 400px;" />系列台需要，如果要跳转到某链接请填写'url'这三个字母，下个框再填地址</td>
			</tr>
            
            <tr>
				<th >跳转地址</th>
				<td><input type="text" class="txt" name="value[url]"
					value="<?=$value[url]?>" style="width: 400px;" /></td>
			</tr>
            
			<tr>
				<th>首页显示</th>
				<td><input name="value[hot]" type="checkbox" id="checkbox" value="1" 
				<?=$value[hot]==1?'checked="checked"':''?> 
				 />是</td>
			</tr>
			<tr>
				<th>排序位</th>
				<td><input name="value[sort]" type="text"  size=4  id="sort"  value="<?=$value['sort']?$value['sort']:100?>"
				 />值越小越靠前，默认为100</td>
			</tr>
            <tr>
				<th>uid</th>
				<td><input name="value[uid]" type="text"  size=4  id="uid"  value="<?=$value[uid]?$value[uid]:0?>"
				 /></td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<td><input type="submit" name="submit" value=" 提 交 " class="btn"
					tabindex="3" /></td>
			</tr>
		</table>

	</form>

</div>

<?php $this->load->view('admin/footer');?>