<?php $this->load->view('admin/header');?>

设置表情音乐：
<div class="mainbox">
	<form action="index.php?d=weixin&c=music&m=save" method="post" id="theform">
		<table width="99%" border="0" cellpadding="3" cellspacing="0" class="datalist" id="sortTable" >
		<tr>
				<th width="20"></th>
				<th width="120">表情</th>	
				<th width="50">歌曲</th>
				<th width="50">歌手</th>	
				<th >歌曲文件 （文件最大20M, 格式.mp3）</th>
			</tr>
			<?php $i=1;foreach($list as $key=>$value) {?>
			<tr>
				<td><?=$i?></td>
				<td >
<input type="text" name="expression[]" class="txt" style="width:50px;" value="<?=$key?>" />  <input type="text" name="comment[]" class="txt" style="width:50px;" value="<?=$value['comment']?>" /></td>				
				<td >
<input type="text" name="title[]" class="txt" style="width:150px;"
					value="<?=$value['title']?>" /> 
				</td>
				<td ><input type="text" name="info[]" class="txt" style="width:80px;"
					value="<?=$value['info']?>" />
				</td>
				<td ><input type="text" id="url<?=$i?>" name="url[]" class="txt" style="width:420px;"
					value="<?=$value['url']?>" /> <input type="button" value="上传歌曲.." class="btn"
					onclick="upfile('url<?=$i?>')" />&nbsp;&nbsp;&nbsp;&nbsp;<?=QuickTimeJS($i,$value['url'],'')?><span id="player-<?=$i?>"></span></td>
			</tr>
			<?php $i++;}?>
			<tr>
				<td>&nbsp;</td>
				<td colspan="5">
                <?php if(checkAccess('music_edit')){?> 
                <input type="submit" name="submit" value=" 保 存 " class="btn"
                        tabindex="3" />
                    <?php }?>    
					&nbsp;&nbsp;&nbsp;
				<input type="reset"
                        name="submit" value=" 取消 " class="btn"/></td>
			</tr>
		</table>
	</form>
</div>
<?php $this->load->view('admin/footer');?>
