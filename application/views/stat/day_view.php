<?php $this->load->view('admin/header');?>
    <script type="text/javascript" src="static/js/datepicker/WdatePicker.js"></script>
    <style type="text/css">
        #date{background: url(static/js/datepicker/skin/datePicker.gif) no-repeat right;}
    </style>
    <script type="text/javascript">
        $(function () {
            $('#container').highcharts({
                title: {
                    text: '访问量统计',
                    x: -20 //center
                },
                exporting: {
                    enabled:false
                },
                subtitle: {
                    text: '<?=$subtitle?>'+'&nbsp;&nbsp;&nbsp;&nbsp;访问量<b style="color:red">'+<?=$total?>+'</b>次',
                    x: -20,
                    useHTML:true
                },
                xAxis: {
                    categories: <?= json_encode($categories)?>
                },
                yAxis: {
                    min: 0,
                    allowDecimals: false,
                    title: {
                        text: '访问次数'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    valueSuffix: '次'
                },

                credits:{
                    enabled:false // 禁用版权信息
                },
                series: [{
                    name: '访问量',
                    data: <?= json_encode($list)?>
                }]
            });

            $('#stat_select').change(function(){
                var key = $(this).find('option:selected').val();
                var date = $('#date').val();
                location.href="index.php?d=admin&c=stat&m=PV&key="+key+"&date="+date;
            });

        });
    </script>
    <div style="float:right;">
        <span>选择日期</span>
        <input type="text" id="date" value="<?=times($date)?>" onclick="WdatePicker({readOnly:true,onpicked:function(){var key = $('#stat_select').find('option:selected').val();var date = $('#date').val();location.href='index.php?d=admin&c=stat&m=PV&key='+key+'&date='+date;}})">
        <select id="stat_select">
            <?=getSelect($select,$key)?>
        </select>
    </div>
    <div style="clear:both;"></div>
    <div id="container" style="min-width:700px;"></div>

    <script src="static/js/highcharts/highcharts.js"></script>
    <script src="static/js/highcharts/modules/exporting.js"></script>
<?php $this->load->view('admin/footer');?>