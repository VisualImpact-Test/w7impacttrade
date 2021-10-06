<style>
* {
	font-family: Century Gothic,CenturyGothic,AppleGothic,sans-serif;
}

table.head {
	background-color: #1370C5;
	padding: 5px;
	font-family: Lucida Grande,Lucida Sans,Arial,sans-serif;
	font-size: 15px;
	width: 100%;
}

td.title {
	font-weight: bold;
	color: #fff;
	text-align: center;
}

.dot {
	height: 25px;
	width: 25px;
	background-color: #bbb;
	border-radius: 50%;
	display: inline-block;
}
</style>
<table class="head">
	<tr>
		<td class="title">LSCK - <?=$plaza['plaza']?></td>
	</tr>
</table>
<div style="margin-top: 3rem;">
	<?$numInfo = count($info);?>
	<?$colNumInfo = round($numInfo / 2);?>
	<?$i = $j = 1;?>
	<?foreach($info as $idInfo => $vinfo){?>
		<?$valor = '';?>
		<?$empresa = '';?>
		<?if( isset($plazaInfo[$idInfo]) ){?>
			<?$valor = !empty($plazaInfo[$idInfo]['valor']) ? $plazaInfo[$idInfo]['valor'] : '-';?>
			<?$empresa = !empty($plazaInfo[$idInfo]['empresa']) ? $plazaInfo[$idInfo]['empresa'] : '';?>
		<?}?>

		<?if( $j == 1 ){?>
			<div style="display: inline-block; float: left; width: 30%;">
				<div style="padding-left: 1rem;">
		<?}?>
		<div style="padding-bottom: .5rem;"><?=$vinfo['nombre']?>: <b><?=$valor.( !empty($empresa) ? " / {$empresa}" : "" )?></b></div>
		<?if( $i == $numInfo || $j == $colNumInfo ){?>
				</div>
			</div>
			<?$j = 1;?>
		<?}else{?>
			<?$j++;?>
		<?}?>
		<?$i++;?>
	<?}?>
	<div style="display: inline-block; float: left; width: 40%; text-align: center;">
		<table style="margin: 0 auto;">
			<thead>
				<tr>
					<th>Tipo Cliente</th>
					<th># Tiendas</th>
					<?foreach($extAudTipo as $vex){?>
						<th>Prom. <?=$vex['nombre']?></th>
					<?}?>
				</tr>
			</thead>
			<tbody>
				<?foreach($tipoCliente as $idTipoCliente => $vtc){?>
					<?$totalCliente = !isset($plazaTipoCliente[$idTipoCliente]) ? 0 : $plazaTipoCliente[$idTipoCliente]['totalTienda'];?>
				<tr>
					<td><?=$vtc['nombre']?></td>
					<td style="text-align: center;"><?=$totalCliente?></td>
					<?foreach($extAudTipo as $idExtAudTipo => $vex){?>
						<?$promedio = !isset($extAudTipoProm[$idTipoCliente][$idExtAudTipo]['valor']) ? 0 : $extAudTipoProm[$idTipoCliente][$idExtAudTipo]['valor'];?>
						<td style="text-align: center;"><?=$promedio?></td>
					<?}?>
				</tr>
				<?}?>
			</tbody>
		</table>
	</div>
</div>
<div style="clear: both;"></div>
<div style="margin-top: 3rem;">
	<div style="display: inline-block; float: left; width: 30%;">
		<div style="display: block; float: left; width: 100%;">
			<div style="padding-left: 1rem;">
				<h4 style="margin-top: 0">Perfect OMS:</h4>
				<p style="margin: 0;">Nota: <?=$plaza['perfNota']?></p>
				<p style="margin: 0;">porcentaje: <?=$plaza['perfPorcentaje']?></p>
				<p style="margin: 0;">Calificación: <?=$plaza['perfectOms']?></p>
			</div>
		</div>
		<div style="display: block; float: left; width: 100%; margin-top: 2rem;">
			<div style="padding-left: 1rem;">
				<h4 style="margin-top: 0">Preguntas:</h4>
				<p style="margin: 0;">Total: <?=$plaza['pregTotal']?></p>
				<p style="margin: 0;">Aprobadas: <?=$plaza['pregAprobadas']?></p>
				<p style="margin: 0;">Nota: <?=$plaza['pregNota']?>%</p>
			</div>
		</div>
	</div>
	<div style="display: inline-block; float: left; width: 70%;">
		<table>
			<?foreach($tipoIndicador as $idTipoIndicador => $vtind){?>
				<tr>
					<?$numCliente = !empty($indicadorCliente) ? count($indicadorCliente) : 0;?>
					<?$colspan = $idTipoIndicador == 1 ? $numCliente + 1 : 1;?>
					<th colspan="<?=$colspan?>" style="text-align: left;">Indicador <?=$vtind['nombre']?></th>
					<?if( $idTipoIndicador == 2 ){?>
						<?$i = 1;?>
						<?if( !empty($indicadorCliente) ){?>
						<?foreach($indicadorCliente as $idCliente => $vtind){?>
							<th>PDV <?=$i?></th>
							<?$i++;?>
						<?}?>
						<?}?>
					<?}?>
					<th>Total</th>
				</tr>
				<?foreach($indicador[$idTipoIndicador] as $idIndicador => $vind){?>
					<tr>
						<?$colspan = $idTipoIndicador == 1 ? $numCliente + 1 : 1;?>
						<td colspan="<?=$colspan?>"><?=$vind['nombre']?></td>
						<?if( $idTipoIndicador == 2 ){?>
							<?foreach($indicadorCliente as $idCliente => $vtind){?>
								<?$punto = isset($vtind[$idIndicador]['punto']) ? $vtind[$idIndicador]['punto'] : '-';?>
								<td style="text-align: center;"><?=$punto?></td>
							<?}?>
						<?}?>
						<?$punto = isset($indicadorPlaza[$idIndicador]['punto']) ? $indicadorPlaza[$idIndicador]['punto'] : '-';?>
						<td style="text-align: center;"><?=$punto?></td>
					</tr>
				<?}?>
			<?}?>
		</table>
	</div>
</div>
<div style="clear: both;"></div>
<?if( !empty($plazaEva) ){?>
<div style="page-break-before: always; margin-top: 3rem;">
	<?foreach($plazaEva as $idEvaluacion => $veval){?>
		<div style="padding-left: 1rem;">
			<h4><?=$veval['nombre']?> <small>(preguntas)</small></h4>
			<?foreach($plazaEvaDet[$idEvaluacion] as $idEvaluacionDet => $vevald){?>
				<div style="padding-left: 2.5rem;">
					<?$i = 0;?>
					<?foreach($plazaEvaDetPreg[$idEvaluacionDet] as $idPregunta => $vpreg){?>
					<div style="margin-right: 2rem;"><b><?=++$i?>) <?=$vpreg['nombre']?></b>
						<?if( isset($plazaEvaDetPregAlt[$idEvaluacionDet][$idPregunta]) ){?>
							<?if( !empty($plazaEvaDetPregAlt[$idEvaluacionDet][$idPregunta]) ){?>
								<div style="margin-left: 1rem; margin-top: .3rem;">
									<?$alternativas = [];?>
									<?foreach($plazaEvaDetPregAlt[$idEvaluacionDet][$idPregunta] as $idAlternativa => $valt){?>
										<?/*dt>- <?=$valt['nombre']?></dt*/?>
										<?$alternativas[] = $valt['nombre'];?>
									<?}?>
									- <?=implode(', ', $alternativas)?>
								</div>
							<?} else{?>
								<span>Sin responder</span>
							<?}?>
						<?} else{?>
							<div style="margin-left: 1rem; margin-top: .3rem;">- <?=( empty($vpreg['respuesta']) ? 'Sin responder' : $vpreg['respuesta'] )?></div>
						<?}?>
					</div>
					<?}?>
				</div>
			<?}?>
			<div style="clear: both;"></div>
			<div style="padding-left: 2.5rem;">
				<h4>Fotos</h4>
				<?if( isset($plazaEvaFoto[$idEvaluacion]) ){?>
					<?foreach($plazaEvaFoto[$idEvaluacion] as $idAudFoto){?>
						<img src="<?=base_url("../_archivos/pg/livestorecheck/{$idAudFoto}.png")?>" style="width: 300px; padding: 1px;">
					<?}?>
				<?} else{?>
					<span>No se encontró fotos.</span>
				<?}?>
			</div>
			<div style="clear: both;"></div>
		</div>
	<?}?>
</div>
<?}?>
<?if( !empty($cliente) ){?>
	<?$ii = 1;?>
	<div style="page-break-before: always;">
		<h4>Tiendas:</h4>
	</div>
	<?foreach($cliente as $idCliente => $vcliente){?>
		<div style="padding-left: 2rem; <?if( $ii == 2 ){?>page-break-before: always;<?}?>">
			<?$ii++;?>
			<h4 style="margin: 0;"><?=$vcliente['nombre']?></h4>
			<h4 style="margin: 0;">COD: <?=$idCliente?></h4>
			<h4 style="margin-top: 0;">TIPO TIENDA: <?=$vcliente['tipoCliente']?></h4>
			<?if( isset($clienteEnc[$idCliente]) ){?>
				<?foreach($clienteEnc[$idCliente] as $idEncuesta => $venc){?>
					<div style="padding-left: 3rem;">
						<h5 style="margin: 0;"><?=$venc['nombre']?></h5>
						<?if(
							isset($clienteEncPreg[$idCliente][$idEncuesta]) &&
							!empty($clienteEncPreg[$idCliente][$idEncuesta])
						){?>
							<ul>
								<?foreach($clienteEncPreg[$idCliente][$idEncuesta] as $idPregunta => $vpreg){?>
									<li style="margin-right: 2rem;"><b><?=$vpreg['nombre']?></b>
										<dl style="margin-top: .3rem;">
											<?
												if(
													isset($clienteEncAlt[$idCliente][$idPregunta]) &&
													!empty($clienteEncAlt[$idCliente][$idPregunta])
												){
													$alternativas = [];
													foreach($clienteEncAlt[$idCliente][$idPregunta] as $idAlternativa => $valt){
														$alternativas[] = $valt['nombre'];
													}

													echo '- '.implode(', ', $alternativas);
												}
												elseif(
													!empty($clienteEncPreg[$idCliente][$idEncuesta]['respuesta'])
												){
													echo '- '.$clienteEncPreg[$idCliente][$idEncuesta]['respuesta'];
												}
												else{
													echo 'Sin Responder';
												}
											?>
										</dl>
									</li>
								<?}?>
							</ul>
						<?}?>
					</div>
					<div style="clear: both;"></div>
				<?}?>
			<?}?>
			<?if( isset($clienteEva[$idCliente]) ){?>
				<?foreach($clienteEva[$idCliente] as $idEvaluacion => $veva){?>
					<div style="padding-left: 3rem; margin-bottom: 3rem;">
						<h5 style="margin: 0;"><?=$veva['nombre']?></h5>
						<ul>
							<?if( isset($clienteEvaDet[$idCliente][$idEvaluacion]) ){?>
								<?foreach($clienteEvaDet[$idCliente][$idEvaluacion] as $idEvaluacionDet => $vevad){?>
									<li style="margin-bottom: 1rem;">
										<span style="color: #000492; font-weight: bold;"><?=$vevad['nombre']?></span>
										<?if(
											isset($clienteEvaDetPreg[$idCliente][$idEvaluacionDet]) &&
											!empty($clienteEvaDetPreg[$idCliente][$idEvaluacionDet])
										){?>
										<ul>
											<?foreach($clienteEvaDetPreg[$idCliente][$idEvaluacionDet] as $idPregunta => $vpreg){?>
												<li>
													<p style="margin-bottom: 0px;">
														<span style="font-weight: bold;">Pregunta: </span>
														<?=$vpreg['nombre']?>
													</p>
													<p style="margin: 0px;">
														<span style="font-weight: bold;">Respuesta: </span>
														<?if( $vpreg['tipo'] == 1 ){?>
															<?=$vpreg['respuesta']?>
														<?} elseif( isset($clienteEvaDetPregAlt[$idCliente][$idEvaluacionDet][$idPregunta]) ){?>
															<?$numPregunta = 0;?>
															<?$numMarcados = 0;?>
															
															<?if( isset($clienteEvaDetPregAlt[$idCliente][$idEvaluacionDet][$idPregunta]['total']) ){?>
																<?$numPregunta = count($clienteEvaDetPregAlt[$idCliente][$idEvaluacionDet][$idPregunta]['total']);?>
															<?}?>
															<?if( isset($clienteEvaDetPregAlt[$idCliente][$idEvaluacionDet][$idPregunta]['marcados']) ){?>
																<?$numMarcados = count($clienteEvaDetPregAlt[$idCliente][$idEvaluacionDet][$idPregunta]['marcados']);?>
															<?}?>

															<?if( $numMarcados > 10 ){?>
																<?echo "$numMarcados / $numPregunta";?>
															<?} else{?>
																<?if( isset($clienteEvaDetPregAlt[$idCliente][$idEvaluacionDet][$idPregunta]['marcados']) ){?>
																	<?echo implode(', ', $clienteEvaDetPregAlt[$idCliente][$idEvaluacionDet][$idPregunta]['marcados']);?>
																<?} else{ echo '-'; }?>
															<?}?>
														<?} else{ echo '-'; }?>
													</p>
													<p style="margin: 0px;">
														<span style="font-weight: bold;">Orden Trabajo: </span>
														<?=empty($vpreg['ordenTrabajo']) ? '-' : $vpreg['ordenTrabajo']?>
													</p>
													<p style="margin: 0px;">
														<?$responsable = empty($vpreg['responsable']) ? '-' : implode(',', $vpreg['responsable']);?>
														<span style="font-weight: bold;">Responsable: </span>
														<?=$responsable?>
													</p>
													<p style="margin: 0px;">
														<span style="font-weight: bold;">Solución: </span>
														<?=empty($vpreg['ordenTrabajoEstado']) ? '-' : $vpreg['ordenTrabajoEstado']?>
													</p>
												</li>
											<?}?>
										</ul>
										<?}?>
									</li>
								<?}?>
							<?}?>
							<li style="margin-bottom: 1rem;">
								<span style="color: #000492; font-weight: bold;">Fotos</span>
								<div style="clear: both;"></div>
							<?if( isset($clienteEvaFoto[$idCliente][$idEvaluacion]) ){?>
								<?foreach($clienteEvaFoto[$idCliente][$idEvaluacion] as $idAudFoto){?>
									<img src="<?=base_url("../_archivos/pg/livestorecheck/{$idAudFoto}.png")?>" style="width: 300px; float: left; padding: 1px;">
								<?}?>
								<div style="clear: both;"></div>
							<?} else{?>
								<p>No se encontró fotos.</p>
							<?}?>
						</ul>
					</div>
				<?}?>
			<?}?>
		</div>
	<?}?>
<?}?>