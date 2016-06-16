<?php $this->load->view('admin/header');?>
<script type="text/javascript">

		
$(function () {
	
	$('#traffic_list').highcharts({
            title: {
                text: '最近10日-时段统计表：',
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
                    text: '数量'
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
                name: '访问数量',
                data: [<?=$visits;?>]
            },{
                name: '发布路况',
                data: [<?=$add_list;?>]
            }]
        });
});


</script>
<div class="mainbox">
	最近10日客户端访问统计：
	<form action="<?=$this->baseurl?>&m=delete" method="post">
		<input type="hidden" name="catid" value="<?=$catid?>">
		<table width="99%" border="0" cellpadding="3" cellspacing="0"
			class="datalist fixwidth" id="sortTable">
			<tr>				
				<th width="30"></th>
				<th width="100">日期</th>
				<th width="100">主页访问数</th>
                <th width="100">新增路况数</th>
                <th width="100">新增会员数</th>
                <th width="100">新闻播报访问数</th>
				<th width="100">广播收听次数</th>				
			</tr>

    <?php foreach($list as $key=>$r) {?>
    <tr class="sortTr">				
				<td><?=$key+1?></td>
                <td><?=$r['dates']?></td>
				<td><?=$r['traffic_list']?></td>
				<td><?=$r['traffic_add']?></td>
                <td><?=$r['members']?></td>
                <td><?=$r['news']?></td>
                <td><?=$r['radios']?></td>
			</tr>
    <?php }?>     
		</table>
	</form>
    <br />
<br />

    
<script src="static/js/highcharts/highcharts.js"></script>
<script src="static/js/highcharts/modules/exporting.js"></script>

<div id="traffic_list" style="min-width: 310px; height: 500px; margin: 0 auto"></div>



<?php $this->load->view('admin/footer');?>