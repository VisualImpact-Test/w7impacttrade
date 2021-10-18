
<div class="col-md-8 p-2">
	<div class="panel panel-default">
		<div class="panel-heading card-header">
			<div id="lb-num-rows" class="pull-left"> Resumen IPP - Cliente</div>
				<div class="widget-icons pull-right" style="margin-inline-start: auto;">
					<a href="javascript:;" class="default lk-export-excel-old" data-content="content-ipp-tienda" data-title="IPP - Tienda" >Exportar <i class="fa fa-file-excel"></i></a>
				</div>
				<div class="clearfix"></div>
			</div>
			<div> <!-- style="min-height: 300px; padding: 0px !important;"-->
				<div id="content-ipp-tienda" class="widget-content table-responsive-ipp  table-content " style="max-height: 700px;">
					<table id="tb-detalle" class="table tb-scroll- tb-scroll w-100 table-bordered" style="font-size: 15px;">
						<thead class="thead-dark">
							<tr>
								<th>PREGUNTAS</th>
								<th>ALTERNATIVAS</th>
								<th>PUNTAJE</th>
								<th>MARCACIÓN</th>
							</tr>
						</thead>
						<tbody>
							<? $idPregunta=0; $idCriterio=0;
							foreach ($visitas as $key => $visita) { 
							?>	
								<tr style="background-color: firebrick; color: white; height: 30px; font-weight: 900">
									<td class="text-center" colspan="2"><strong>FECHA: <?=$visita['fecha']?></strong></td>
									<td class="text-center" colspan="2"><strong>PUNTACIÓN GLOBAL : <?=$visita['puntajeGlobal']?></strong></td>
								</tr>
							<?	foreach ($preguntas as $key => $pregunta):
									foreach ($pregunta['alternativas'] as $key => $alternativa) {
										if ($idCriterio!=$pregunta['idCriterio']) {
										?>
											<tr style="background-color: mediumseagreen; color: white; height: 30px; font-weight: 900">
												<td colspan="2" class="text-center"><?=$pregunta['criterio']?></td>
												<td colspan="2" class="text-center">PUNTAJE CRITERIO: <?=( isset($criterios[$pregunta['idCriterio']]['puntaje'])? $criterios[$pregunta['idCriterio']]['puntaje']:0)?></td>
											</tr>
										<?			
										}
											$idCriterio = $pregunta['idCriterio'];
										?>
										<tr>
											<? if ($idPregunta!=$pregunta['idPregunta']): ?>
												<td rowspan="<?=count($pregunta['alternativas'])?>" ><?=$pregunta['pregunta']?></td>
											<? endif ?>
											
											<? if ( isset($pregAlternativas[$visita['idVisita']]['preguntas'][$pregunta['idPregunta']]['alternativas'][$alternativa['idAlternativa']] ) ){ ?>
												<td style="font-weight: bold;"><?=$alternativa['alternativa']?></td>
												<td style="font-weight: bold;" class="text-center"><?=(is_null($alternativa['puntaje']))?0:$alternativa['puntaje']?></td>
												<td style="font-weight: bold;"class="text-center">Sí</td>
											<? } else { ?>
												<td><?=$alternativa['alternativa']?></td>
												<td class="text-center"><?=(is_null($alternativa['puntaje']))?0:$alternativa['puntaje']?></td>
												<td class="text-center">*</td>
											<? } ?>
										</tr>
								<?			
										
									$idPregunta = $pregunta['idPregunta'];
									}	
								endforeach ;
							} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>