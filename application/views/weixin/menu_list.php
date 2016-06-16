<?php $this->load->view('admin/header');?>
<?php
function viewOpss($oldval) {
	$arr = array('click'=>'点击(click)','view'=>'显示(view)');
	foreach($arr as $k=>$v){
			$seled = ($oldval==$k) ? "selected" : "";
			$re.= "<option value=\"{$k}\" {$seled}>{$v}</option>";
	}
	return $re;
}
$buttonArr = $list['button'];

?>
<script language="javascript">
function selCHK(sel,id) {
	if(sel=='') return '值';
	document.getElementById(id).innerHTML = (sel == 'click')?'值':'url';	
}
</script>
<div class="mainbox">
    <form action="<?=$this->baseurl?>&m=save" method="post" id="theform" onsubmit="return confirm('确定要执行此操作吗？');">
            <input type="hidden" name="id" value="1"> 
          <table width="99%" border="0" cellpadding="3" cellspacing="0" class="datalist" id="sortTable">	
              <tr>
                <td colspan="2">
                  <?php if(checkAccess('weixin_menu_saveandapply')){?> 
                <input type="submit" name="btnSaveAndTo" value="保存并同步创建微信自定义菜单" class="btn" tabindex="3" />  
                <?php }?>
                  <?php if(checkAccess('weixin_menu_edit')){?> 
                <input type="submit" name="btnSave" value="仅保存不同步" class="btn" tabindex="3" />
                 <?php }?>
                
                <input type="reset" name="btnreset" value=" 重置 " class="btn"/>
                <span style="float:right">
                <input type="submit" name="btnToken" value="取access_token" class="btn" tabindex="3" />
                <input type="submit" name="btnSearch" value="查询微信自定义菜单" class="btn" tabindex="3" />
               
                  <?php if(checkAccess('weixin_menu_del')){?> 
                <input type="submit" name="btnDelete" value="删除微信自定义菜单" class="btn" tabindex="3" />
                  <?php }?>
                </span>
                </td>
              </tr>
              <tr>
                <th colspan="2" align="left" nowrap="nowrap">
                <strong>微信开发者凭据</strong> 
                AppId:<input type="text" class="txt" name="checkArr[appID]" style="width:180px;" value="<?=$chkdata['appID']?>" />
                AppSecret:<input type="text" class="txt" name="checkArr[appsecret]" style="width:350px;" value="<?=$chkdata['appsecret']?>" /> <font color="red">(可登录微信公号后台的开发模式获取)</font>
                </th>
              </tr>
          <?php for($c=1;$c<=3;$c++){$cl=$c-1;?>
              <tr style="background:#EEE">
                <th colspan="2" align="left" nowrap="nowrap">
                <strong>一级菜单<?=$c?></strong> 
                名称:<input name="button[<?=$cl?>][name]" type="text" class="txt" style="width:100px;" value="<?=$buttonArr[$cl]['name']?>" maxlength="10" /> 
                类型:<select name="button[<?=$cl?>][type]" onchange="selCHK(this.options[this.selectedIndex].value,'spans-<?=$cl?>');"><?=viewOpss($buttonArr[$cl]['type'])?></select> 
                <span id="spans-<?=$cl?>">值</span>:<input type="text" class="txt" name="button[<?=$cl?>][key]" style="width:450px;" value="<?php echo ($buttonArr[$cl]['type']=='click')?$buttonArr[$cl]['key']:$buttonArr[$cl]['url'];?>" /> 
                <font color="red">(若有二级菜单"值"需留空；类型为&quot;显示&quot;请输入url地址，如:http://www.a.com/)</font></th>
              </tr>
              <script language="javascript">selCHK('<?=$buttonArr[$cl]['type']?>','spans-<?=$cl?>')</script>
              <?php for($i=1;$i<=5;$i++){$il=$i-1;?>
                  <tr>
                    <th width="121" nowrap="nowrap">
                    <span style="float:right">|----二级菜单<?=$i?></span></th>
                    <td width="1119">
                    名称:<input name="button[<?=$cl?>][sub_button][<?=$il?>][name]" type="text" class="txt" style="width:100px;" value="<?=$buttonArr[$cl]['sub_button'][$il]['name']?>" maxlength="15" /> 
                	类型:<select name="button[<?=$cl?>][sub_button][<?=$il?>][type]" onchange="selCHK(this.options[this.selectedIndex].value,'spans-<?=$cl?>-<?=$il?>');"><?=viewOpss($buttonArr[$cl]['sub_button'][$il]['type'])?></select> 
                	<span id="spans-<?=$cl?>-<?=$il?>">值</span>:<input type="text" class="txt" name="button[<?=$cl?>][sub_button][<?=$il?>][key]" style="width:450px;" value="<?php echo ($buttonArr[$cl]['sub_button'][$il]['type']=='click')?$buttonArr[$cl]['sub_button'][$il]['key']:$buttonArr[$cl]['sub_button'][$il]['url'];?>" /></td>
                    <td width="1">              
                  </tr> 
                  <script language="javascript">selCHK('<?=$buttonArr[$cl]['sub_button'][$il]['type']?>','spans-<?=$cl?>-<?=$il?>')</script>
               <?php }?>    
          <?php }?>          
          </table>
        </form>
</div>
<div style="color:red; margin-top:10px; line-height:20px;">备注：目前自定义菜单最多包括3个一级菜单，每个一级菜单最多包含5个二级菜单。一级菜单最多4个汉字，二级菜单最多7个汉字，多出来的部分将会以“...”代替。请注意，创建自定义菜单后，由于微信客户端缓存，需要24小时微信客户端才会展现出来。建议测试时可以尝试取消关注公众账号后再次关注，则可以看到创建后的效果。 </div>

<?php $this->load->view('admin/footer');?>