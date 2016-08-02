<?php $this->load->view('admin/header');?>
    <script type="text/javascript" src="static/js/datepicker/WdatePicker.js"></script>
    <script src="static/js/echarts/echarts.js" type="text/javascript"></script>
    <style type="text/css">
        #date{background: url(static/js/datepicker/skin/datePicker.gif) no-repeat right;}
    </style>

    <script type="text/javascript">
        $(function(){
            $('#stat_select').change(function(){
                var key = $(this).find('option:selected').val();
                var date = $('#date').val();
                location.href="index.php?d=admin&c=stat&m=program_stat&key="+key+"&date="+date;
            });
        });
    </script>

    <div style="float:right;">
        <span>选择日期</span>
        <input type="text" id="date" value="<?=times($date)?>" onclick="WdatePicker({readOnly:true,onpicked:function(){var key = $('#stat_select').find('option:selected').val();var date = $('#date').val();location.href='index.php?d=admin&c=stat&m=program_stat&key='+key+'&date='+date;}})">
        <select id="stat_select">
            <?=getSelect($select,$key)?>
        </select>
    </div>
    <div style="clear:both;"></div>
<?php if(!$yAxis) { ?>
    <div style="position:relative;left:550px;width:300px;color:red;">当前日期没有数据</div>
<?php } ?>
    <div id="container" style="min-width:600px;min-height:600px;"></div>
    <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
    <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('container'));

        var option = {
            title: {
                text: '节目收听量排行榜',
                subtext: '当前统计数：<?php echo $total?$total:0;?>'
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            legend: {
                data: ['收听次数', '完整收听次数']
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: {
                type: 'value',
                boundaryGap: [0, 0.01]
            },
            yAxis: {
                type: 'category',
                data: [<?=$yAxis?>]
            },
            series: [
                {
                    name: '收听次数',
                    type: 'bar',
                    data: [<?=$series1?>]
                },
                {
                    name: '完整收听次数',
                    type: 'bar',
                    data: [<?=$series2?>]
                }
            ]
        };

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    </script>


<?php $this->load->view('admin/footer');?>