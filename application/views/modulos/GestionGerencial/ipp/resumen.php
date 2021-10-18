<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading card-header">
			<div id="lb-num-rows" class="pull-left">Resultados: 0</div>
				<div class="widget-icons pull-right" style="margin-inline-start: auto;">
					<a href="javascript:;" class="default lk-export-excel" data-content="tb-resumen" data-title="IPP - RESUMEN" >Exportar <i class="fa fa-file-excel"></i></a>
				</div>  
			<div class="clearfix"></div>
		</div>
			<div class="panel-body" style="min-height: 100px; padding: 0px !important;"> 
				<div id="tb-resumen" class="widget-content table-responsive-ipp  table-content">
					<table id="tb-detalle" class="table table-bordered" ><!--class="table tb-scroll- tb-scroll"-->
						<thead>
							<tr>
								<th rowspan="2"></th>
								<?foreach($canal as $ix_ca => $row_ca){?>
									<th colspan="<?=count($banner[$ix_ca])?>" style="<?=($ix_ca%3 == 0)? 'background-color: #353535;color: whitesmoke ' : ''?>"><?=$row_ca['canal']?></th>
									<th rowspan="2" style="background-color: #000000;color:white">TOTAL</th>
								<?}?>
							</tr>
							<tr>
								<?foreach($canal as $ix_ca => $row_ca){?>
									<?foreach($banner[$ix_ca] as $ix_ba => $row_ba){?>
										<th style="<?=($ix_ca%3 == 0)? 'background-color: #353535; color: whitesmoke' : ''?>" ><?=$row_ba['banner']?></th>
									<?}?>
								<?}?>
							</tr>
						</thead>
						<tbody>
							<?$array_ca = array();?>
							<?foreach($criterios as $ix_cr => $row_cr){?>
								<tr>
									<td style="text-transform: uppercase;background-color: #ccc; font-weight: bold;" ><a href="javascript:;" class="lk-row-1" data-indicador="<?='cr-'.$ix_cr?>" data-show="false"  ><i class="fas fa-plus-circle"></i></a> <?=$row_cr['criterio']?></td>
									<?foreach($canal as $ix_ca => $row_ca){?>
										<?$sum_ca = 0; $count_ca = 0;?>
										<?foreach($banner[$ix_ca] as $ix_ba => $row_ba){?>
											<?
												$prom = isset($puntos_criterio[$ix_ba][$ix_cr])? $puntos_criterio[$ix_ba][$ix_cr] : '';
												$sum_ca = $sum_ca + $prom;
												$count_ca++;
											?>
											<td class="text-center" style="text-transform: uppercase;background-color: #ccc; font-weight: bold;" ><?=is_numeric($prom)? $prom : '-';?></td>
										<?}?>
										<? 
											$prom = ($count_ca > 0 )? round($sum_ca/$count_ca,2) : '';
											$array_ca[$ix_ca] = isset($array_ca[$ix_ca])? $array_ca[$ix_ca] + $prom: $prom;
										?>
										<td  class="text-center" style="text-transform: uppercase;background-color: #9c9898; font-weight: bold;"  ><?=is_numeric($prom)? $prom : '-';?></td>
									<?}?>
								</tr>
								<?foreach($preguntas[$ix_cr] as $ix_p => $row_p){?>
									<tr class="row-2-<?='cr-'.$ix_cr?> hide">
										<td><?=$row_p['pregunta']?></td>
										<?foreach($canal as $ix_ca => $row_ca){?>
											<?$sum_ca = 0; $prom = 0; $count_ca = 0;?>
											<?foreach($banner[$ix_ca] as $ix_ba => $row_ba){?>
												<?
													$prom = isset($puntos_pregunta[$ix_ba][$ix_cr][$ix_p])? $puntos_pregunta[$ix_ba][$ix_cr][$ix_p] : '0';
													$sum_ca = $sum_ca + $prom;
													$count_ca++;
												?>
												<td class="text-center" ><?=is_numeric($prom)? $prom : '-';?></td>
											<?}?>
											<?
												$prom = ($count_ca > 0 )? round($sum_ca/$count_ca,2) : '';
											?>
											<td class="text-center" style="background-color: #e8e5e5;" ><?=is_numeric($prom)? $prom : '-';?></td>
										<?}?>
									</tr>
								<?}?>
							<?}?>
							<tr>
								<td class="text-center" style="text-transform: uppercase;background-color: #ed2c2f; color: #ffffff; font-weight: bold;" >Punt. Obtenido</td>
								<?foreach($canal as $ix_ca => $row_ca){?>
									<?$sum_ca = 0;?>
									<?foreach($banner[$ix_ca] as $ix_ba => $row_ba){?>
										<?
											$cant = isset($puntos_banner[$ix_ba])? $puntos_banner[$ix_ba] : 0;
										?>
										<td class="text-center" style="text-transform: uppercase;background-color: #ed2c2f; color: #ffffff; font-weight: bold;" ><?=isset($puntos_banner[$ix_ba])? '<strong>'.$puntos_banner[$ix_ba].'</strong>' : '-'?></td>
									<?}?>
									<?
										$sum_ca = isset($array_ca[$ix_ca])? $array_ca[$ix_ca] : '';
									?>
									<td class="text-center" style="text-transform: uppercase;background-color: #a91719; color: #ffffff; font-weight: bold;" ><?=is_numeric($sum_ca)? $sum_ca : '-'?></td>
								<?}?>
							</tr>
							<tr>
								<td class="text-center" style="text-transform: uppercase;background-color: #000000; color: #ffffff; font-weight: bold;" >Max. Puntaje</td>
								<?foreach($canal as $ix_ca => $row_ca){?>
									<?foreach($banner[$ix_ca] as $ix_ba => $row_ba){?>
										<td class="text-center" style="text-transform: uppercase;background-color: #000000; color: #ffffff; font-weight: bold;" ><?=isset($puntaje_maximo)? '<strong>'.$puntaje_maximo.'</strong>' : '-'?></td>
									<?}?>
									<td class="text-center" style="text-transform: uppercase;background-color: #000000; color: #ffffff; font-weight: bold;" ><?=isset($puntaje_maximo)? '<strong>'.$puntaje_maximo.'</strong>' : '-'?></td>
								<?}?>
							</tr>
							<tr>
								<td class="text-center" style="text-transform: uppercase;background-color: #000000; color: #ffffff; font-weight: bold;" >% Visib. X Cadena</td>
								<?foreach($canal as $ix_ca => $row_ca){?>
									<?$sum_ca = 0;?>
									<?foreach($banner[$ix_ca] as $ix_ba => $row_ba){?>
										<?
											$cant = isset($puntos_banner[$ix_ba])? $puntos_banner[$ix_ba] : 0;
											$por = ($puntaje_maximo > 0)? round(($cant/$puntaje_maximo)*100,2) : '';
										?>
										<td class="text-center" style="text-transform: uppercase;background-color: #000000; color: #ffffff; font-weight: bold;" ><?=is_numeric($por)? '<strong>'.$por.'%</strong>' : '-'?></td>
									<?}?>
									<?
										$sum_ca = isset($array_ca[$ix_ca])? $array_ca[$ix_ca] : '';
										$por = ($puntaje_maximo > 0)? round(($sum_ca/$puntaje_maximo)*100,2) : '';
									?>
									<td class="text-center" style="text-transform: uppercase;background-color: #000000; color: #ffffff; font-weight: bold;" ><?=is_numeric($por)? $por.'%' : '-'?></td>
								<?}?>
							</tr>
							<tr>
								<td class="text-center" style="text-transform: uppercase;background-color: #ffe318; color: #000000; font-weight: bold;" >N° Encuestas</td>
								<?foreach($canal as $ix_ca => $row_ca){?>
									<?$sum_ca = 0;?>
									<?foreach($banner[$ix_ca] as $ix_ba => $row_ba){?>
										<?
											$cant = isset($encuestas[$ix_ba])? count($encuestas[$ix_ba]) : 0;
											$sum_ca = $sum_ca + $cant;
										?>
										<td class="text-center" style="text-transform: uppercase;background-color: #ffe318; color: #000000; font-weight: bold;" ><?=isset($encuestas[$ix_ba])? '<strong>'.count($encuestas[$ix_ba]).'</strong>' : '-'?></td>
									<?}?>
									<td class="text-center" style="text-transform: uppercase;background-color: #e2ad16; color: #ffffff; font-weight: bold;" ><?=$sum_ca?></td>
								<?}?>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading card-header">
			<div id="lb-num-rows" class="pull-left">Resultados: 0</div>
				<div class="widget-icons pull-right" style="margin-inline-start: auto;">
					<a href="javascript:;" class="default lk-export-excel" data-content="tb-resumen-2" data-title="IPP - RESUMEN" >Exportar <i class="fa fa-file-excel"></i></a>
				</div>  
			<div class="clearfix"></div>
		</div>
			<div class="panel-body" style="min-height: 100px; padding: 0px !important;"> 
				<div id="tb-resumen-2" class="widget-content table-responsive-ipp  table-content">
					<table id="tb-detalle" class="table table-bordered" ><!--class="table tb-scroll- tb-scroll"-->
						<thead>
							<tr>
								<th rowspan="2"></th>
								<?foreach($canal as $ix_ca => $row_ca){?>
									<th colspan="<?=count($banner[$ix_ca])?>" style="<?=($ix_ca%3 == 0)? 'background-color: #353535; color: whitesmoke' : ''?>"><?=$row_ca['canal']?></th>
									<th rowspan="2" style="background-color: #000000;color: white">TOTAL</th>
								<?}?>
							</tr>
							<tr>
								<?foreach($canal as $ix_ca => $row_ca){?>
									<?foreach($banner[$ix_ca] as $ix_ba => $row_ba){?>
										<th style="<?=($ix_ca%3 == 0)? 'background-color: #353535; color: whitesmoke' : ''?>" ><?=$row_ba['banner']?></th>
									<?}?>
								<?}?>
							</tr>
						</thead>
						<tbody>
							<?$array_ca = array();?>
							<?foreach($criterios as $ix_cr => $row_cr){?>
								<tr>
									<td style="text-transform: uppercase;background-color: #ccc; font-weight: bold;" ><?=$row_cr['criterio']?></td>
									<?foreach($canal as $ix_ca => $row_ca){?>
										<?$sum_ca = 0; $count_ca = 0;?>
										<?foreach($banner[$ix_ca] as $ix_ba => $row_ba){?>
											<?
												$prom = isset($puntos_criterio[$ix_ba][$ix_cr])? $puntos_criterio[$ix_ba][$ix_cr] : '';
												$sum_ca = $sum_ca + $prom;
												$count_ca++;
												$por = round(($prom/2) *100,2);
											?>
											<td class="text-center" style="text-transform: uppercase;background-color: #ccc; font-weight: bold;" ><?=is_numeric($por)? $por.'%' : '-';?></td>
										<?}?>
										<? 
											$prom = ($count_ca > 0 )? round($sum_ca/$count_ca,2) : '';
											$array_ca[$ix_ca] = isset($array_ca[$ix_ca])? $array_ca[$ix_ca] + $prom: $prom;
											$por = round(($prom/2) *100,2);
										?>
										<td  class="text-center" style="text-transform: uppercase;background-color: #9c9898; font-weight: bold;"  ><?=is_numeric($por)? $por.'%' : '-';?></td>
									<?}?>
								</tr>
							<?}?>
							<tr>
								<td class="text-center" style="text-transform: uppercase;background-color: #ed2c2f; color: #ffffff; font-weight: bold;" >Punt. Obtenido</td>
								<?foreach($canal as $ix_ca => $row_ca){?>
									<?$sum_ca = 0;?>
									<?foreach($banner[$ix_ca] as $ix_ba => $row_ba){?>
										<?
											$cant = isset($puntos_banner[$ix_ba])? $puntos_banner[$ix_ba] : 0;
											$por = ($puntaje_maximo > 0)? round(($cant/$puntaje_maximo)*100,2) : '';
										?>
										<td class="text-center" style="text-transform: uppercase;background-color: #ed2c2f; color: #ffffff; font-weight: bold;" ><?=is_numeric($por)? '<strong>'.$por.'%</strong>' : '-'?></td>
									<?}?>
									<?
										$sum_ca = isset($array_ca[$ix_ca])? $array_ca[$ix_ca] : '';
										$por = ($puntaje_maximo > 0)? round(($sum_ca/$puntaje_maximo)*100,2) : '';
									?>
									<td class="text-center" style="text-transform: uppercase;background-color: #a91719; color: #ffffff; font-weight: bold;" ><?=is_numeric($por)? $por.'%' : '-'?></td>
								<?}?>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>