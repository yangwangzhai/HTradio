<?php $this->load->view('admin/header');?>
    <script src="./static/js/jquery-ui.min.js"></script>
    <style>
        .wrap{float:left;margin-left: 20px;}
        ul{width:150px;height:300px;border:1px solid gray;overflow:auto;}
        li{border-bottom: 1px solid gray;cursor: pointer;height:25px;line-height:25px;}
        li:hover{background-color: #c3dde0;}
        .type_selected{background-color: #c3dde0;}
        .has_selected{background:url(/static/admin_img/correct.gif) no-repeat right}
        .tips{
            font-size: 12px;
            height: 30px;
            background-color: #E5F3B8;
            line-height: 30px;
            border-radius: 5px;
            padding-left: 5px;
        }
        .delete_bnt{
            text-align: center;
            line-height: 14px;
            display: inline-block;
            width: 14px;
            height: 14px;
            background-color: pink;
            border-radius: 7px;
            color:red;
        }
    </style>
    <div class="tips">提示（选择“节目分类”->“节目列表”，已选择节目列表可鼠标拖动排序，点击红色“x”可移除节目）</div>
    <div id="type_list" class="wrap">
        <div>节目分类：</div>
        <ul>
            <?php foreach ($list as $k => $v) { ?>
                <li onclick="getProgram(this,<?=$v['id']?>)"><?='├'.$v['title']?></li>
            <?php } ?>
        </ul>
    </div>

    <div id="program_list" class="wrap">
        <div>节目列表：</div>
        <ul>

        </ul>
    </div>

    <div id="selected_list" class="wrap">
        <div>已选择节目：</div>
        <ul class="sortable">
            <?php if($value) { ?>
                <?php foreach ($value as $val) { ?>
                    <li  data-id="<?=$val[id]?>"><?=$val[title]?>&nbsp;<span class="delete_bnt" onclick="delete_one(this)">x</span></li>
                <?php } ?>
            <?php } ?>
        </ul>
    </div>

    <div style="clear:both;"></div>
    <div>
        <input type="button" value="确定" class="btn" onclick="result()">
        <input type="button" value="取消" class="btn" onclick="cancel()">
    </div>
    <script>
        $(function(){
            $('.sortable').sortable();//拖动排序
        });

        //获取节目列表
        function getProgram(obj,id){
            $(obj).addClass('type_selected').siblings().removeClass('type_selected');

            $.ajax({
                url:'index.php?d=admin&c=programme&m=getSecondProgramType&id='+id,
                type:'get',
                success:function(res){
                    var json = eval(res);
                    var html = '';

                    for (var i in json) {
                        var has_selected = '';
                        if (in_list(json[i].id)) {
                            has_selected = 'has_selected';
                        }
                        html += '<li class="'+has_selected+'" data-id="'+json[i].id+'" onclick="select_one(this,'+json[i].id+',\''+json[i].title+'\')">'+json[i].title+'</li>';
                    }
                    $('#program_list ul').eq(0).html(html);
                }
            })
        }

        //选择节目
        function select_one(obj,id,title){
            if(in_list(id)){//判断是否已选
                return;
            }
            $('#selected_list ul').eq(0).append('<li data-id="'+id+'">'+title+'&nbsp;<span class="delete_bnt" onclick="delete_one(this)">x</span></li>');
            $(obj).addClass('has_selected');

        }

        //判断是否已选函数
        function in_list(id){
            var flag = 0;
            $('#selected_list li').each(function(){
                if(parseInt($(this).attr('data-id')) == id){
                    flag = 1;
                }
            });
            if(flag){
                return true;
            }
            return false;
        }

        //删除一个已选节目
        function delete_one(obj){
            $(obj).parent().remove();
            $('#program_list li').each(function(){
                if($(this).attr('data-id') == $(obj).parent().attr('data-id'))
                {
                    $(this).removeClass('has_selected');
                }
            })
        }

        //确定按钮，返回数据并关闭窗口
        function result(){
            var data = new Array();
            $('#selected_list li').each(function(i){
                data.push($(this).attr('data-id'));
            });
            $('.fanhui<?=$len?>', window.parent.document).val(data.join());
            var api = frameElement.api, W = api.opener;
            W.$.dialog({id:'list'}).close()
        }

        //取消按钮
        function cancel(){
            var api = frameElement.api, W = api.opener;
            W.$.dialog({id:'list'}).close();
        }



    </script>

<?php $this->load->view('admin/footer');?>