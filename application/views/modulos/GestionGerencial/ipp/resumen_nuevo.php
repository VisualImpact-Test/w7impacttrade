<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading card-header">
			<div id="lb-num-rows" class="pull-left">Resultados: 0</div>
				<div class="widget-icons pull-right" style="margin-inline-start: auto;">
					<a href="javascript:;" class="default lk-export-excel" data-content="tb-resumen-nuevo" data-title="IPP - RESUMEN" >Exportar <i class="fa fa-file-excel"></i></a>
				</div>  
			<div class="clearfix"></div>
		</div>
			<div class="panel-body" style="min-height: 100px; padding: 0px !important;"> 
				<div id="tb-resumen-nuevo" class="widget-content table-responsive-ipp  table-content">
					<table id="tb-detalle" class="table table-bordered" ><!--class="table tb-scroll- tb-scroll"-->
						<thead>
							<tr>
								<th></th>
								<?foreach($meses as $row){?>
									<th><?=$row['mes']?></th>
								<?}?>
							</tr>
						</thead>
						<tbody>
							<?$array_ca = array();?>
							<?foreach($criterios as $ix_cr => $row_cr){?>
								<tr>
									<td style="text-transform: uppercase;background-color: #ccc; font-weight: bold;" ><a href="javascript:;" class="lk-row-1" data-indicador="<?='cr-'.$ix_cr?>" data-show="false"  ><i class="fas fa-plus-circle"></i></a> <?=$row_cr['criterio']?></td>
									<?foreach($meses as $row){?>
									<td style="text-transform: uppercase;background-color: #ccc; font-weight: bold;text-align:center;"><?=isset($totalCriterio[$anio][$row['idMes']][$ix_cr]['totalCriterio'])?$totalCriterio[$anio][$row['idMes']][$ix_cr]['totalCriterio']:'-'; ?></td>
									<?}?>
								</tr>
								<?foreach($preguntas[$ix_cr] as $ix_p => $row_p){?>
									<tr class="row-2-<?='cr-'.$ix_cr?> hide">
										<td><?=$row_p['pregunta']?></td>
										<?foreach($meses as $row){?>
											<? /*$row['anio']*/ ?>
											<td style="text-align:center;"><?=isset($puntajes[$anio][$row['idMes']][$ix_cr][$ix_p]['puntaje'])?$puntajes[$anio][$row['idMes']][$ix_cr][$ix_p]['puntaje']:'-'; ?></td>
										<?}?>
									</tr>
								<?}?>
							<?}?>
							<tr>
								<td class="text-center" style="text-transform: uppercase;background-color: #ed2c2f; color: #ffffff; font-weight: bold;" >Punt. Obtenido</td>
								<?foreach($meses as $row){?>
									<? /*$row['anio']*/ ?>
									<td style="text-transform: uppercase;background-color: #ed2c2f; color: #ffffff; font-weight: bold;text-align:center;" ><?=isset($totalGeneral[$anio][$row['idMes']]['totalGeneral'])?$totalGeneral[$anio][$row['idMes']]['totalGeneral']:'-'; ?></td>
								<?}?>
							</tr>
							<tr>
								<td class="text-center" style="text-transform: uppercase;background-color: #000000; color: #ffffff; font-weight: bold;" >Max. Puntaje</td>
								<?foreach($meses as $row){?>
								<td style="text-transform: uppercase;background-color: #000000; color: #ffffff; font-weight: bold;text-align:center;" ><?=isset($totalGeneral[$anio][$row['idMes']]['objetivo'])?$totalGeneral[$anio][$row['idMes']]['objetivo']:'-'; ?></td>
								<? } ?>
							</tr>
							<tr>
								<td class="text-center" style="text-transform: uppercase;background-color: #000000; color: #ffffff; font-weight: bold;" >% Visib. X Cadena</td>
								<?foreach($meses as $row){?>
								<? 
									$total_mes = isset($totalGeneral[$anio][$row['idMes']]['totalGeneral'])?$totalGeneral[$anio][$row['idMes']]['totalGeneral']:0;
									$objetivo  =isset($totalGeneral[$anio][$row['idMes']]['objetivo'])?$totalGeneral[$anio][$row['idMes']]['objetivo']:0;
									$porcentaje = ($objetivo>0)?ROUND($total_mes/$objetivo*100,2).'%':'-';
								?>
								<td style="text-transform: uppercase;background-color: #000000; color: #ffffff; font-weight: bold;text-align:center;" ><?=$porcentaje;?></td>
								<? } ?>
							</tr>
							<tr>
								<td class="text-center" style="text-transform: uppercase;background-color: #ffe318; color: #000000; font-weight: bold;" >N° Encuestas</td>
								<?foreach($meses as $row){?>
								<td style="text-transform: uppercase;background-color: #ffe318; color: #000000; font-weight: bold;text-align:center;" ><?=isset($totalGeneral[$anio][$row['idMes']]['encuestas'])?$totalGeneral[$anio][$row['idMes']]['encuestas']:'-'; ?></td>
								<? } ?>
								
							</tr>
						</tbody>
					</table>
				</div>
				<!---------------------------------------------------------->
				<div id="container" style="height:300px;"></div>
<script>
anychart.onDocumentReady(function(){

    var dataSet = anychart.data.set([
		<?foreach($meses as $row){?>
			<? 
				$total_mes = isset($totalGeneral[$anio][$row['idMes']]['totalGeneral'])?$totalGeneral[$anio][$row['idMes']]['totalGeneral']:0;
				$objetivo  =isset($totalGeneral[$anio][$row['idMes']]['objetivo'])?$totalGeneral[$anio][$row['idMes']]['objetivo']:0;
				$porcentaje = ($objetivo>0)?ROUND($total_mes/$objetivo*100,2):0;
				$encuestas = isset($totalGeneral[$anio][$row['idMes']]['encuestas'])?$totalGeneral[$anio][$row['idMes']]['encuestas']:0;
			?>
			["<?=$row['mes']?>", <?=$encuestas?>,<?=$encuestas*$porcentaje/100?>, "#222a35", '#f2bd12', {enabled: true},<?=$porcentaje?>],
		<? } ?>
    ]);
    var seriesData_1 = dataSet.mapAs({'x': 0, 'value': 2, 'data_valor': 6});
    var seriesData_2 = dataSet.mapAs({'x': 0, 'value': 1, 'data_valor': 1, fill: 3, stroke:3, label: 5});
  
  
    var chart = anychart.column();
    chart.animation(true);
    chart.title('VISIBILIDAD');
    chart.yScale().stackMode('value');
	chart.tooltip().format("Encuestas: {%data_valor}");
	
    var scale = anychart.scales.linear();
    scale.minimum(0)
            .maximum(100)
            .ticks({interval: 20});

    chart.column(seriesData_2);
  
    chart.crosshair(true);
    var lineSeries = chart.line(seriesData_1);
            lineSeries.markers(true);
	lineSeries.tooltip().format("Porcentaje Visibilidad: {%data_valor}%");
	lineSeries.normal().stroke("#f2bd12", 9);
	lineSeries.hovered().stroke("#f2bd12", 18);
	lineSeries.selected().stroke("#f2bd12", 9);
    chart.container('container');
    chart.draw();
});
</script>

				<!---------------------------------------------------------->
			</div>
		</div>
	</div>
	
	
