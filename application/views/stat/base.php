<?php $this->load->view('admin/header');?>

		<script type="text/javascript">
$(function () {
        $('#container').highcharts({
            title: {
                text: '今日访问统计',
                x: -20 //center
            },
            subtitle: {
                text: '<?=date('Y-m-d');?>',
                x: -20
            },
            xAxis: {
                categories: [<?=$day;?>]
            },
            yAxis: {
                title: {
                    text: '访问数量 (次)'
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
                name: '访问次数',
                data: [<?=$visits;?>]
            }]
        });


        $('#newuser').highcharts({
            title: {
                text: '今日新增会员',
                x: -20 //center
            },
            subtitle: {
                text: '<?=date('Y-m-d');?>',
                x: -20
            },
            xAxis: {
                categories: [<?=$day;?>]
            },
            yAxis: {
                title: {
                    text: '人数'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: '个'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                name: '新增人数',
                data: [<?=$new_user;?>]
            }]
        });
});
</script>
		
<div class="mainbox nomargin">

<script src="static/js/highcharts/highcharts.js"></script>
<script src="static/js/highcharts/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<hr />
<div id="newuser" style="min-width: 310px; height: 400px; margin: 0 auto; margin-top: 20px;"></div>
</div>


<?php $this->load->view('admin/footer');?>