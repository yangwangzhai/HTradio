<?php $this->load->view('admin/header');?>
<script type="text/javascript" src="static/js/datepicker/WdatePicker.js"></script>
<style type="text/css">
    #date{background: url(static/js/datepicker/skin/datePicker.gif) no-repeat right;}
</style>
<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'bar'
        },
        exporting: {
            enabled:false
        },
        title: {
            text: '<?=$type?'主持':'用户'?>人气排行榜'
        },
        subtitle: {
            text: '<?=$subtitle?>',
        },
        xAxis: {
            categories: <?= json_encode($categories)?>,
            title: {
                text: '<?=$type?'主持':'用户'?>名称'
            }
        },
        yAxis: {
            opposite: true,
            allowDecimals: false,
            min: 0,
            title: {
                text: '粉丝数量'
            }
        },
        tooltip: {                                                         
            followPointer: true,
            shared: true,
            useHTML: true,
            headerFormat: '<b>{point.key}</b><br>',
            pointFormat: '粉丝数量<span style="color:red;">{point.y}</span><br>',
            footerFormat: ''
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        legend: {
            enabled: false
        },
        credits:{
            enabled:false // 禁用版权信息
        },
        series: <?= json_encode($num)?>
            
    });

    $('#stat_select').change(function(){
        var key = $(this).find('option:selected').val();
        var date = $('#date').val();
        location.href="index.php?d=admin&c=stat&m=renqi_stat&type=<?=$type?>&key="+key+"&date="+date;
    });
});
</script>
<div style="float:right;">
    <span>选择日期</span>
    <input type="text" id="date" value="<?=times($date)?>" onclick="WdatePicker({readOnly:true,onpicked:function(){var key = $('#stat_select').find('option:selected').val();var date = $('#date').val();location.href='index.php?d=admin&c=stat&m=renqi_stat&type=<?=$type?>&key='+key+'&date='+date;}})">
    <select id="stat_select">
        <?=getSelect($select,$key)?>
    </select>
</div>
<div style="clear:both;"></div>
<div id="container" style="min-width:700px;min-height:500px;"></div>
<!--div id="pie" style="min-width:500px;"></div-->

<script src="static/js/highcharts/highcharts.js"></script>
<script src="static/js/highcharts/modules/exporting.js"></script>
<?php $this->load->view('admin/footer');?>