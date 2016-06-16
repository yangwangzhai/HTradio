<?php $this->load->view('admin/header');?>

<script>
KindEditor.ready(function(K) {
	K.create('#content',{urlType :'relative'});
});
</script>
<div class="mainbox nomargin">
	<form action="<?=$this->baseurl?>&m=save" method="post">
		<input type="hidden" name="id" value="<?=$id?>">
		<table width="99%" border="0" cellpadding="3" cellspacing="0" class="opt">	
		<tr>
				<td width="70">会员组 </td>
				<td><select name="value[catid]" id="gender"><?=getSelect($category, $value['catid'])?></select></td>
				<td>群名称</td>
				<td><input type="text" class="txt" name="value[groupname]" value="<?=$value[groupname]?>" />
					所属群（<font color="#FF0000">如有"+"号请填写全角的"＋"，如：广西互联网＋创业博览会</font>）</td>
			</tr>			
			<tr>
				<td>用户名</td>
				<td width="300"><?php if(empty($id)){?>
				<input type="text" class="txt" name="value[username]" value="<?=$value[username]?>" />
				<?php } else { echo $value[username]; }?></td>
				<td width="70">新密码 </td>
				<td ><input type="text" class="txt" name="value[password]" value="" />
				不修改密码，请留空</td>
			</tr>
			
			
			<tr>
				<td>昵称 </td>
				<td><input type="text" class="txt" name="value[nickname]" value="<?=$value[nickname]?>" /></td>
				<td>真实姓名</td>
				<td><input type="text" class="txt" name="value[truename]" value="<?=$value[truename]?>" /></td>
			</tr>			
			<tr>
				<td>性别 </td>
				<td><select name="value[gender]" id="gender"><?=getSelect($this->config->item('gender'), $value['gender'])?></select></td>
				<td>头像</td>
				<td><input name="value[avatar]" class="txt" type="text" id="avatar" 
					value="<?=$value[avatar]?>" />
				<input type="button" value="选择.."
					onclick="upfile('avatar')" class="btn" />&nbsp;&nbsp;<input type="button" value="预览"
					onclick="showImg('avatar',350,200)" class="btn" /></td>
			</tr>
			<tr>
				<td>邮箱 </td>
				<td><input type="text" class="txt" name="value[email]" value="<?=$value[email]?>" /></td>
				<td>电话 </td>
				<td><input type="text" class="txt" name="value[tel]" value="<?=$value[tel]?>" /></td>
			</tr>
			
			<tr>
				<td>地址</td>
				<td><input type="text" class="txt" name="value[address]" value="<?=$value[address]?>" /></td>
				<td>个性签名</td>
				<td><input type="text" class="txt" name="value[sign]" value="<?=$value[sign]?>" /></td>
			</tr>	
            <tr>
				<th>排序位</th>
				<td><input name="value[sort]" type="text"  size=4  id="sort"  value="<?=$value['sort']?$value['sort']:100?>"
				 />值越小越靠前，默认为100</td>
				<td>身份证号</td>
				<td><input type="text" class="txt" name="value[IDcard]" value="<?=$value[IDcard]?>"></td>
			</tr>	
            
            <tr>
				<td>是否主持人</td>
				<td>
					<input type="radio" name="value[type]" value="1" <?=$value['type']?'checked':''?> />是
					<input type="radio" name="value[type]" value="0" <?=!$value['type']?'checked':''?> />否
				</td>
				<td>背景图片</td>
				<td colspan="3"><input name="value[backgroundpic]" class="txt" type="text" id="backgroundpic" 
					value="<?=$value[backgroundpic]?>" />
				<input type="button" value="选择.."
					onclick="upfile('backgroundpic')" class="btn" />&nbsp;&nbsp;<input type="button" value="预览"
					onclick="showImg('backgroundpic',350,200)" class="btn" /></td>
			</tr>
            	
			<tr>
				<td>备注</td>
				<td colspan="3"><textarea id="content" name="value[content]"
						style="width: 700px; height: 300px;"><?=$value[content]?></textarea></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3"><input type="submit" name="submit" value=" 提 交 " class="btn"
					tabindex="3" /> &nbsp;&nbsp;&nbsp;<input type="button"
					name="submit" value=" 取消 " class="btn"
					onclick="javascript:history.back();" /></td>
			</tr>
		</table>
	</form>

</div>

<?php $this->load->view('admin/footer');?>