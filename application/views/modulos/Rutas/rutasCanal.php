<style>
	.anychart-credits-text {
		display: none !important;
	}
</style>

<? $n=0; ?>
<?foreach ($canales as $ix => $row): ?>
	<? $n++; ?>
	<? if ($n==1): ?>
		<div class="row">
	<? endif ?>
			
			<div class="col-md-6">
				<div id="content-grafico-canal-<?=$ix;?>" class="chart-pie-small" style="width: 100% !important; height: 300px !important">
				</div>
			</div>

	<? if ( $n%2==0 ): $n=0; ?>
		</div>	
	<? endif ?>

	<script>
		//GRÁFICA POR CANAL
		anychart.onDocumentReady(function(){
			var array=[
				{ x:"EF", value: <?=!empty($row['valueEF']) ? $row['valueEF']: 0;?> },
				{ x:"NE", value: <?=!empty($row['valueNE']) ? $row['valueNE']: 0;?> },
				{ x:"IN", value: <?=!empty($row['valueIN']) ? $row['valueIN']: 0;?> },
				{ x:"SV", value: <?=!empty($row['valueSV']) ? $row['valueSV']: 0;?> }
			];

			//Asignamos la DATA
			chart = anychart.pie(array);
			//Asignamos el contenedor
			chart.container('content-grafico-canal-<?=$ix;?>');
			//Asignamos el título
			chart.animation(true);
			chart.title("<strong>Canal <?=$row['nombre'];?></strong>");
			chart.title().fontSize(12);
			chart.title().fontColor('#455a64');
			chart.title().useHtml(true);
			//Asignamos el color a cada paleta
			chart.palette(['#5cb85c', '#666', '#f6ea67', '#d9534f']);
			//
			chart.draw();
		});
	</script>

<?endforeach ?>