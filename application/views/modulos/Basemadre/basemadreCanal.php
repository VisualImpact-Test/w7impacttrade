<style>
	.anychart-credits-text {
		display: none !important;
	}
</style>
<? $n=0; ?>
<? foreach ($canal as $ix => $row): ?>
<?
	$array_grafico = array();
	if(isset($row['en_cartera'])){
		$por = isset($row['total_en_cartera_venta'])? ((round($total_venta,2) > 0)? round((round($row['total_en_cartera_venta'],2)/round($total_venta,2)) *100, 2).'%' : '-') : '-';  
		$array_ = array( 'x' => 'En Cartera', 'value' => $row['en_cartera'], 'venta' => moneda($row['total_en_cartera_venta']), 'por' => $por );
		array_push($array_grafico, $array_);
	}

	if(isset($row['fuera_cartera'])){
		$por = isset($row['total_fuera_cartera_venta'])? ((round($total_venta,2) > 0)? round((round($row['total_fuera_cartera_venta'],2)/round($total_venta,2)) *100, 2).'%' : '-') : '-'; 
		$array_ = array( 'x' => 'Fuera de Cartera', 'value' => $row['fuera_cartera'], 'venta' => moneda($row['total_fuera_cartera_venta']), 'por' => $por );
		array_push($array_grafico, $array_);
	}
?>

<? $n++; ?>
<? if($n==1) { ?>
	<div class="row">
<? } ?>

	<div class="col-md-6">
		<div id="content-grafico-canal-<?=$ix?>" class="chart-pie-small" style="width: 100% !important; height: 220px !important; " ></div>
		<?if( $n%2 == 0) $n = 0;?>
<? if($n==0){ ?>
	</div>
<? } ?>
	</div>

<script>
	//GRAFICA POR CANAL
	anychart.onDocumentReady(function() {
		var array = [];
		//
		$.each(<?=json_encode($array_grafico)?>, function( index, value ) { array.push(value);})
		chart = anychart.pie(array);
		//
		chart.container('content-grafico-canal-<?=$ix?>');
		// set chart title text settings
		chart.animation(true);
		chart.title("<strong>PDV <?=$row['nombre'].' ';?></strong>");
		chart.title().fontSize(12);
		chart.title().fontColor('#000');
		chart.title().useHtml(true);
		//
		chart.legend(true);
		chart.legend().title(false);
		chart.legend().fontColor('#000');
		chart.legend().fontSize(10);
		chart.legend().title().padding([0,0,10,0]);
		chart.legend().position('bottom');
		chart.legend().itemsLayout('horizontal');
		chart.legend().align('center');
		//
		chart.labels()
				.fontSize(10)
				.fontColor('#000');
		chart.labels().position("outside");
		chart.connectorStroke({color: "#595959", thickness: 1, dash:"1 1"});
		//
		
		chart.tooltip()
				.useHtml(true)
				.width(250)
				//.textWrap('byWord')
				.title({fontColor: '#FFFFFF'})
				.format(function () { return '<span style="color: #545f69; font-size: 10px; font-weight: bold">PDV: ' + this.value + '</span><br /><span style="color: #545f69; font-size: 10px; font-weight: bold">Venta: ' + array[this.index]['venta'] + '</span><br /><span style="color: #545f69; font-size: 10px; font-weight: bold">Participación: ' + array[this.index]['por'] + '</span>';});
		chart.tooltip().background()
				.enabled(true)
				.fill('#FFFFFF')
				.stroke('#ccc')
				.corners(3)
				.cornerType('round');
		//
		//chart.palette(['<?=colorCuenta();?>', "#bbbbbb"]);
		//chart.hoverFill("#04725a", 0.6);
		chart.stroke("#fff", 3);
		//chart.hoverStroke("#04725a", 3);
		chart.draw();
	});
</script>

<? endforeach ?>