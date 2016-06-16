<?php $this->load->view('admin/header');?>
                	
                    
<div class="mainbox">
    <form action="<?=$this->baseurl?>&m=save" method="post" id="theform">
            <input type="hidden" name="id" value="1"> 
          <table width="99%" border="0" cellpadding="3" cellspacing="0" class="datalist" id="sortTable" >
             <?php foreach($list as $key=>$r) {?>	
              <tr>
                  <td width="189" nowrap="nowrap"><?=$r['names']?></td>
                <td width="1058">
                <?php if($r['ismore']==1){?>
					 <textarea id="content-<?=$r[id]?>" name="value[<?=$r[id]?>]" style="width: 600px; height: 100px;"><?=$r[values]?></textarea>
                <?php }else{?>
                	<input type="text" class="txt" name="value[<?=$r[id]?>]" style="width:<?=$r['iwidth']?>px;" value="<?=$r[values]?>" />
                <?php }?>		
                </td>
            </tr>	
              <?php }?>		
              <tr>
                  <th>&nbsp;</th>
                  <td>
                     <?php if(checkAccess('weixin_set_save')){?>
                  <input type="submit" name="submit" value=" 保 存 " class="btn"
                        tabindex="3" /> 
                       <?php }?>	  
                        &nbsp;&nbsp;&nbsp;<input type="reset"
                        name="submit" value=" 取消 " class="btn"/></td>
              </tr>
          </table>
        </form>
</div>

<?php $this->load->view('admin/footer');?>