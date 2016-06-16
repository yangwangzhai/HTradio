<?php $this->load->view('admin/header');?>
<script type="text/javascript" src="static/js/datepicker/WdatePicker.js"></script>
<style type="text/css">
    
    #date{background: url(static/js/datepicker/skin/datePicker.gif) no-repeat right;}
</style>
<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        exporting: {
            enabled:false
        },
        title: {
            text: '节目分类统计表'
        },
        subtitle: {
            text: '<?=$subtitle?>'+'&nbsp;&nbsp;&nbsp;&nbsp;节目数量<b style="color:red">'+<?=$total?>+'</b>个',
            x: -20,
            useHTML:true
        },
        xAxis: {
            categories: <?= json_encode($categories)?>,
            title: {
                text: '节目分类'
            },
            max: 15


        },
        rangeSelector: {
                selected: 2
        },
        scrollbar: {
            enabled: true
        },
        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: '节目数量'
            }
        },
        tooltip: {                                                         
            followPointer: true,
            shared: true,
            useHTML: true,
            headerFormat: '<b>{point.key}</b><br>',
            pointFormat: <?=$key=='quarter'?'"{series.name}"':'""'?>+'节目数<span style="color:red;">{point.y}个</span><br>',
            footerFormat: ''
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        legend: {
            enabled:<?=$key=='quarter'?'true':'false'?>
        },
        credits:{
            enabled:false // 禁用版权信息
        },
        series: <?= json_encode($num)?>

        
    });

    $('#stat_select').change(function(){
        var key = $(this).find('option:selected').val();
        var date = $('#date').val();
        location.href="index.php?d=admin&c=stat&m=res_type&key="+key+"&date="+date;
    });
});
</script>
<div style="float:right;">
    <span>选择日期</span>
    <input type="text" id="date" value="<?=times($date)?>" onclick="WdatePicker({readOnly:true,onpicked:function(){var key = $('#stat_select').find('option:selected').val();var date = $('#date').val();location.href='index.php?d=admin&c=stat&m=res_type&key='+key+'&date='+date;}})">
    <select id="stat_select">
        <?=getSelect($select,$key)?>
    </select>
</div>
<div style="clear:both;"></div>

<div id="container" style="min-width:700px;"></div>


<!--div id="pie" style="min-width:500px;"></div-->

<script src="static/js/highcharts/highstock.js"></script>
<script src="static/js/highcharts/modules/exporting.js"></script>
<?php $this->load->view('admin/footer');?>