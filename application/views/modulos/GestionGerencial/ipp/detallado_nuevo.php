<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading card-header">
			<div id="lb-num-rows" class="pull-left">Resultados: 0</div>
				<div class="widget-icons pull-right " style="margin-inline-start: auto;">
					<a href="javascript:;" class="default lk-export-excel" data-content="tb-detallado-nuevo" data-title="IPP - RESUMEN" >Exportar <i class="fa fa-file-excel"></i></a>
				</div>  
			<div class="clearfix"></div>
		</div>
			<div class="panel-body" style="min-height: 100px; padding: 0px !important;"> 
				<div id="tb-detallado-nuevo" class="widget-content table-responsive-ipp  table-content">
					<table id="tb-detalle" class="table table-bordered" ><!--class="table tb-scroll- tb-scroll"-->
						<thead>
							<tr>
								<th rowspan="2" ></th>
								<?foreach($banner as $row){?>
									<th colspan="5"><?=$row['banner']?></th>
								<?}?>
							</tr>
							<tr>
								<?foreach($banner as $row){?>
									<th>1</th>
									<th>2</th>
									<th>3</th>
									<th>4</th>
									<th>5</th>
								<?}?>
							</tr>
						</thead>
						<tbody>
							<?$array_ca = array();?>
							<?foreach($criterios as $ix_cr => $row_cr){?>
								<tr>
									<td style="text-transform: uppercase;background-color: #ccc; font-weight: bold;" ><a href="javascript:;" class="lk-row-1" data-indicador="<?='cr-'.$ix_cr?>" data-show="false"  ><i class="fas fa-plus-circle"></i></a> <?=$row_cr['criterio']?></td>
									<?foreach($banner as $row){?>
										<? for($i=1;$i<6;$i++){ ?>
										<td style="text-transform: uppercase;background-color: #ccc; font-weight: bold;text-align:center;"><?=isset($totalCriterio[$row['idBanner']][$i][$ix_cr]['totalCriterio'])?$totalCriterio[$row['idBanner']][$i][$ix_cr]['totalCriterio']:'-'; ?></td>
										<? } ?>
									<?}?>
								</tr>
								<?foreach($preguntas[$ix_cr] as $ix_p => $row_p){?>
									<tr class="row-2-<?='cr-'.$ix_cr?> hide">
										<td><?=$row_p['pregunta']?></td>
										<?foreach($banner as $row){?>
											<? for($i=1;$i<6;$i++){ ?>
												<td style="text-align:center;"><?=isset($puntajes[$row['idBanner']][$i][$ix_cr][$ix_p]['puntaje'])?$puntajes[$row['idBanner']][$i][$ix_cr][$ix_p]['puntaje']:'-'; ?></td>
											<? } ?>
										<?}?>
									</tr>
								<?}?>
							<?}?>
							<tr>
								<td class="text-center" style="text-transform: uppercase;background-color: #ed2c2f; color: #ffffff; font-weight: bold;" >Punt. Obtenido</td>
								<?foreach($banner as $row){?>
									<? for($i=1;$i<6;$i++){ ?>
										<td style="text-transform:uppercase;background-color:#ed2c2f;color:#ffffff;font-weight:bold;text-align:center;"><?=isset($totalGeneral[$row['idBanner']][$i]['totalGeneral'])?$totalGeneral[$row['idBanner']][$i]['totalGeneral']:'-'; ?></td>
									<? } ?>
								<?}?>

								
							</tr>
							<tr>
								<td class="text-center" style="text-transform: uppercase;background-color: #000000; color: #ffffff; font-weight: bold;" >Max. Puntaje</td>
								<?foreach($banner as $row){?>
									<? for($i=1;$i<6;$i++){ ?>
										<td style="text-transform: uppercase;background-color: #000000; color: #ffffff; font-weight: bold;text-align:center;"><?=isset($totalGeneral[$row['idBanner']][$i]['objetivo'])?$totalGeneral[$row['idBanner']][$i]['objetivo']:'-'; ?></td>
									<? } ?>
								<? } ?>
							</tr>
							<tr>
								<td class="text-center" style="text-transform: uppercase;background-color: #000000; color: #ffffff; font-weight: bold;" >% Visib. X Cadena</td>
								<?foreach($banner as $row){?>
									<? for($i=1;$i<6;$i++){ ?>
										<? $total = isset($totalGeneral[$row['idBanner']][$i]['totalGeneral'])?$totalGeneral[$row['idBanner']][$i]['totalGeneral']:0; ?>
										<? $objetivo = isset($totalGeneral[$row['idBanner']][$i]['objetivo'])?$totalGeneral[$row['idBanner']][$i]['objetivo']:0; ?>
										<? $porcentaje = ($objetivo>0)?ROUND($total/$objetivo*100,2).'%':'-'; ?>
										<td class="text-center" style="text-transform: uppercase;background-color: #000000; color: #ffffff; font-weight: bold;" ><?=$porcentaje?></td>
									<? } ?>
								<? } ?>
							</tr>
							<tr>
								<td class="text-center" style="text-transform: uppercase;background-color: #ffe318; color: #000000; font-weight: bold;" >N° Encuestas</td>
								<?foreach($banner as $row){?>
									<? for($i=1;$i<6;$i++){ ?>
										<td style="text-transform: uppercase;background-color: #ffe318; color: #000000; font-weight: bold;text-align:center;"><?=isset($totalGeneral[$row['idBanner']][$i]['encuestas'])?$totalGeneral[$row['idBanner']][$i]['encuestas']:'-'; ?></td>
									<? } ?>
								<? } ?>
							</tr>
							<tr>
								<td><div style="padding:5px;"></div></td>
								<? $count=0;foreach($banner as $row){$count++;}?>
								<td colspan="<?=$count*5+1?>"></td>
							</tr>
							<tr>
								<td></td>
								<?foreach($banner as $row){?>
									<td colspan="5">
										<!---------------------------------------------------------->
										<div id="banner_<?=$row['idBanner']?>" style="height:200px;width:500px;"></div>
										<script>
											anychart.onDocumentReady(function(){
												var dataSet = anychart.data.set([
													
														<? for($i=1;$i<6;$i++){ ?>
															<? 
																$total_mes = isset($totalGeneral[$row['idBanner']][$i]['totalGeneral'])?$totalGeneral[$row['idBanner']][$i]['totalGeneral']:0;
																$objetivo  =isset($totalGeneral[$row['idBanner']][$i]['objetivo'])?$totalGeneral[$row['idBanner']][$i]['objetivo']:0;
																$porcentaje = ($objetivo>0)?ROUND($total_mes/$objetivo*100,2):0;
																$encuestas = isset($totalGeneral[$row['idBanner']][$i]['encuestas'])?$totalGeneral[$row['idBanner']][$i]['encuestas']:0;
															?>
															["Semana <?=$i?>", <?=$encuestas?>,<?=$encuestas*$porcentaje/100?>, "#222a35", '#f2bd12', {enabled: true},<?=$porcentaje?>],
														<? } ?>
										
												
												]);
												var seriesData_1 = dataSet.mapAs({'x': 0, 'value': 2, 'data_valor': 6});
												var seriesData_2 = dataSet.mapAs({'x': 0, 'value': 1, 'data_valor': 1, fill: 3, stroke:3, label: 5});

												var chart = anychart.column();
												chart.animation(true);
												chart.title('<?=$row['banner']?>');
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
												chart.container("banner_<?=$row['idBanner']?>");
												chart.draw();
											});
										</script>
										<!---------------------------------------------------------->
									</td>
								<?}?>
							</tr>
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
	</div>
	
	
