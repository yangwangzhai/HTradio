<?php $this->load->view('admin/header');?>

	<script>
		KindEditor.ready(function(K) {
			K.create('#content',{urlType :'relative'});
		});
	</script>
	<div class="mainbox nomargin">
		<form action="<?=$this->baseurl?>&m=save" method="post">
			<input type="hidden" name="id" value="<?=$id?>"> <!--input type="hidden"
			name="value[catid]" value="<?=$value[catid]?>"-->
			<table class="opt">
				<!--th width="90">分组 </th>
				<td><select name="value[catid]" id="gender"><?=getSelect($group, $value['catid'])?></select></td>
			</tr-->
				<tr>
					<th >类型名称</th>
					<td><input name="value[title]" type="text" class="txt"
							   value="<?=$value[title]?>" /></td>
				</tr>
				<tr>
					<th>排序</th>
					<td><input name="value[sort]" class="txt" type="text" value="<?=$value[sort] ? $value[sort] : 100 ?>" /></td>
				</tr>
				<tr>
					<th>缩略图</th>
					<td><input name="value[thumb]" class="txt" type="text" id="thumb"
							   value="<?=$value[thumb]?>" />
						<input type="button" value="选择.."
							   onclick="upfile('thumb')" class="btn" />&nbsp;&nbsp;<input type="button" value="预览"
																						  onclick="showImg('thumb',350,200)" class="btn" /></td>
				</tr>

				<tr>
					<th>首页显示</th>
					<td><input name="value[hot]" type="radio" <?php if($value[hot]==1){echo 'checked';} ?> value="1" />是
						<input name="value[hot]" type="radio" <?php if($value[hot]==0 || empty($value) ){echo 'checked';} ?> value="0" />否</td>
				</tr>

				<tr>
					<th>类型介绍</th>
					<td>
						<textarea name="value[content]" id='address' cols="" rows="" class="text" placeholder=""><?=$value[content]?></textarea>
					</td>
				</tr>



				<tr>
					<th>&nbsp;</th>
					<td><input type="submit" name="submit" value=" 提 交 " class="btn"
							   tabindex="3" /> &nbsp;&nbsp;&nbsp;<input type="button"
																		name="submit" value=" 取消 " class="btn"
																		onclick="javascript:history.back();" /></td>
				</tr>
			</table>
		</form>

	</div>

<?php $this->load->view('admin/footer');?>