<?php $this->load->view('admin/header');?>

<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: '最近30天，广播台收听率统计'
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.percentage}%</b>',
            	percentageDecimals: 1
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Browser share',
                data: [
                    ['新闻综合广播',   10.2],
                    ['私家车930',       25.6],
                    {
                        name: '95.0MusicRadio',
                        y: 25.8,
                        sliced: true,
                        selected: true
                    },
                    ['970女主播',    20.7],
                    ['广西交通台',     9.3],
                    ['北部湾之声',   8.4]					
                ]
            }]
        });
    });
	
	$('#traffic_list').highcharts({
            title: {
                text: '最近30日-时段统计表：',
                x: -20 //center
            },
            subtitle: {
                text: '<?=date('Y-m-d');?>',
                x: -20
            },
            xAxis: {
                categories: ['0点','1点','2点','3点','4点','5点','6点','7点','8点','9点','10点','11点','12点','13点','14点','15点','16点','17点','18点','19点','20点','21点','22点','23点']
            },
            yAxis: {
                title: {
                    text: '收听次数'
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
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                name: '新闻综合广播',
                data: [3,2,0,12,0,12,25,2,45,25,53,36,78,45,52,55,26,45,75,45,4,8,6,3]},{            
                name: '私家车930',
                data: [3,2,0,1,0,0,25,25,40,25,15,24,27,52,45,123,26,82,56,7,5,4,2,0]},{
					 name: '95.0MusicRadio',
                data: [3,2,0,1,0,0,25,25,42,20,15,24,127,152,145,45,26,82,56,7,5,4,2,0]},{
					 name: '970女主播',
                data: [3,2,0,1,0,0,25,25,43,28,115,124,27,52,45,145,26,82,56,7,5,4,2,0]},{
					 name: '广西交通台',
                data: [3,2,0,1,0,0,25,25,47,56,15,24,127,52,45,145,26,82,56,7,5,4,2,0]},{
					 name: '北部湾之声',
                data: [3,2,0,1,0,0,25,25,50,41,115,124,27,152,45,45,26,82,56,7,5,4,2,0]}]
        });
    
});
</script>

<div class="mainbox nomargin">

<script src="static/js/highcharts/highcharts.js"></script>
<script src="static/js/highcharts/modules/exporting.js"></script>

<div id="container"	style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<br />
<br />
<br />

<div id="traffic_list" style="min-width: 310px; height: 500px; margin: 0 auto"></div>
</div>


<?php $this->load->view('admin/footer');?>