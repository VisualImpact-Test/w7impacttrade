<style>
	.anychart-credits-text {
		display: none !important;
	}
</style>
	<div class="col-md-12">
		<div id="content-grafico-segmento" class="chart-column-small" style="width: 100% !important; height: 300px !important; " ></div>
	</div>
</div>

<?
$new_segmento = array();
if(!empty($segmento)){
	foreach($segmento as $ix =>  $row){
		$new_segmento[$ix][0] =  !empty($row[0])? $row[0] : 'No Segmentado';
		$new_segmento[$ix][1] =  isset($row[1])? $row[1] : null;
		$new_segmento[$ix][2] =  isset($row[2])? $row[2] : null;
		$new_segmento[$ix][3] =  isset($row[3])? moneda($row[3]) : null;
		$new_segmento[$ix][4] =  isset($row[4])? moneda($row[4]) : null;
		$por = isset($row[3])? ((round($total_venta,2) > 0)? round((round($row[3],2)/round($total_venta,2)) *100, 2).'%' : '-') : '-';  
		$new_segmento[$ix][5] = $por;
		$por = isset($row[4])? ((round($total_venta,2) > 0)? round((round($row[4],2)/round($total_venta,2)) *100, 2).'%' : '-') : '-';  
		$new_segmento[$ix][6] = $por;
	}
}
?>
<script>
anychart.onDocumentReady(function () {
	var array = [];
	$.each(<?=json_encode($new_segmento)?>, function( index, value ) { 
		var arr = [value[0], value[1], value[2], value[3], value[4], value[5], value[6]];
		array.push(arr);
	});
    var dataSet = anychart.data.set(array);
    var seriesData_1 = dataSet.mapAs({x: [0], value: [1]});
    var seriesData_2 = dataSet.mapAs({x: [0], value: [2]});
    chart = anychart.column();
    chart.animation(true);
    chart.title(false);
	//
	var column = chart.column(seriesData_1);
	//
	column.fill('<?=colorCuenta();?>');
	column.selected().fill('<?=colorCuenta();?>');
	column.stroke('<?=colorCuenta();?>').name("En Cartera");
	column.labels()
            .enabled(true)
			.fontSize(10)
			.fontColor('#000')
            .format('{%Value}');
	column.tooltip()
			.useHtml(true)
			.width(250)
			//.textWrap('byWord')
			.title({fontColor: '#7c868e'})
			.format(function () {
				return '<span style="color: #545f69; font-size: 10px; font-weight: bold">PDV: ' + this.value + '</span><br />'+
				'<span style="color: #545f69; font-size: 10px; font-weight: bold">Venta: ' + array[this.index][3] + '</span><br />'+
				'<span style="color: #545f69; font-size: 10px; font-weight: bold">Participación: ' + array[this.index][5] + '</span><br />';
			});
	column.tooltip().background()
			.enabled(true)
			.fill('#fff')
			.stroke('#ccc')
			.corners(3)
			.cornerType('round');
	//
	var column_2 = chart.column(seriesData_2);
	column_2.fill('#bbbbbb');
	column_2.selected().fill('#bbbbbb');
	column_2.stroke('#bbbbbb').name("Fuera de Cartera");
	column_2.labels()
            .enabled(true)
			.fontSize(10)
			.fontColor('#000')
            .format('{%Value}');
	column_2.tooltip()
			.useHtml(true)
			.width(250)
			//.textWrap('byWord')
			.title({fontColor: '#7c868e'})
			.format(function () {return '<span style="color: #545f69; font-size: 12px; font-weight: bold">PDV: ' + this.value + '</span><br />'+
					'<span style="color: #545f69; font-size: 10px; font-weight: bold">Venta: ' + array[this.index][4] + '</span><br />'+
					'<span style="color: #545f69; font-size: 10px; font-weight: bold">Participación: ' + array[this.index][6] + '</span><br />';
				});
	column_2.tooltip().background()
			.enabled(true)
			.fill('#fff')
			.stroke('#ccc')
			.corners(3)
			.cornerType('round');
	
	//
	chart.yScale().minimum(0).ticks({interval: 10});
    chart.container('content-grafico-segmento');
	//chart.xAxis().labels().rotation(-90);
	chart.legend(true);
    chart.draw();
});
</script>