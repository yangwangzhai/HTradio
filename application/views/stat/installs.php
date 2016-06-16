<?php $this->load->view('admin/header');?>
<script type="text/javascript" src="static/js/datepicker/WdatePicker.js"></script>
<style type="text/css">
    
    #date{background: url(static/js/datepicker/skin/datePicker.gif) no-repeat right;}
</style>
<script type="text/javascript">
$(function () {
    Highcharts.setOptions({
        colors: ['#DBC64F', '#00A9DC'],//颜色设置 按series顺序
        
    });

    $('#container').highcharts({
        title: {
            text: '安装量统计',
            x: -20 //center
        },
        exporting: {
        	enabled:false
        },
        subtitle: {
            text: '<?=$subtitle?>'+'&nbsp;&nbsp;&nbsp;&nbsp;安装量<b style="color:red">'+<?=$total?>+'</b>次',
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
                text: '安装次数'
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
            name: ' Android客户端',
            data: <?= json_encode($list['android'])?>
        },
        {
            name: 'IOS客户端',
            data: <?= json_encode($list['ios'])?>
        }]
    });
/*
    $('#pie').highcharts({
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Android IOS客户端安装比例',
            x: -20 //center
        },
        exporting: {
            enabled:false
        },
        tooltip: { 
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>' 
        }, 
        plotOptions: { 
            pie: { 
                allowPointSelect: true, 
                cursor: 'pointer',
                dataLabels: { 
                    enabled: true, 
                    color: '#000000',
                    connectorColor: '#000000', 
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %' 
                } 
            } 
        },
        credits:{
            enabled:false // 禁用版权信息
        },
        series: [{ 
            type: 'pie', 
            name: '客户端占比例', 
            data: [ 
                ['Android', 45.0], 
                ['IOS', 26.8]
            ]
                
        }]
    });
*/
    $('#stat_select').change(function(){
        var key = $(this).find('option:selected').val();
        var date = $('#date').val();
        location.href="index.php?d=admin&c=stat&m=Installs&key="+key+"&date="+date;
    });
    
});
</script>
<div style="float:right;">
    <span>选择日期</span>
    <input type="text" id="date" value="<?=times($date)?>" onclick="WdatePicker({readOnly:true,onpicked:function(){var key = $('#stat_select').find('option:selected').val();var date = $('#date').val();location.href='index.php?d=admin&c=stat&m=Installs&key='+key+'&date='+date;}})">
    <select id="stat_select">
        <?=getSelect($select,$key)?>
    </select>
</div>
<div style="clear:both;"></div>
<div id="container" style="min-width:700px;"></div>
<!--div id="pie" style="min-width:500px;"></div-->

<script src="static/js/highcharts/highcharts.js"></script>
<script src="static/js/highcharts/modules/exporting.js"></script>
<?php $this->load->view('admin/footer');?>