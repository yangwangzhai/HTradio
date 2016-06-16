<?php $this->load->view('admin/header');?>

    <script>
        KindEditor.ready(function(K) {
            K.create('#content',{urlType :'relative'});
        });
    </script>
    <div class="mainbox nomargin">
        <form action="<?=$this->baseurl?>&m=live_channel_save" method="post">
            <input type="hidden" name="id" value="<?=$id?>">
            <table class="opt">
                <tr>
                    <th >频道名称</th>
                    <td><input name="value[title]" type="text" class="txt" value="<?=$value[title]?>" /></td>
                </tr>
                <tr>
                    <th>频道简介</th>
                    <td><textarea name="value[description]" id='address' cols="" rows="" class="text" placeholder=""><?=$value[description]?></textarea></td>
                </tr>
                <tr>
                    <th >直播地址</th>
                    <td><input name="value[add_channel]" type="text" class="txt" value="<?=$value[add_channel]?>" /></td>
                </tr>
                <tr>
                    <th>频道logo</th>
                    <td>
                        <input name="value[logo]" class="txt" type="text" id="thumb" value="<?=$value[logo]?>" />
                        <input type="button" value="选择.." onclick="upfile('thumb')" class="btn" />&nbsp;&nbsp;
                        <input type="button" value="预览" onclick="showImg('thumb',350,200)" class="btn" />
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