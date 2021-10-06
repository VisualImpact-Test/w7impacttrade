<style>
	.tablaFotografico th {
		vertical-align: middle !important;
		text-transform: uppercase;
		color: #FFF;
		/* background-color: #002856; */
		background: linear-gradient( 90deg, var(--color-vi), var(--color-vi-2));
		text-align: center !important;
		padding: 5px;
		border-top: none !important;
		border-bottom: 1px dotted #6f6f6f;
		border-right: 1px dotted #6f6f6f;
	}
</style>
<div class="col-lg-12">
	<div class="main-card mb-3 card">
		<div class="card-header">
			<i class="fas fa-camera fa-lg"></i>&nbsp Realizar Auditoría
		</div>
		<div class="card-body">
			<div id="idContentIniciativa1" class="table-responsive">
				<!----------------------------------------------------------->
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<? $i = 1; ?>
						<? foreach ($visitasAuditar as $row) {
							// $arrayFecha = explode("/", $row->fecha);
							//$idConcat = $arrayFecha[0].'_'.$arrayFecha[1].'_'.$arrayFecha[2].'_'.$row->idEmpleado.'_'.$row->idCliente;
						?>
							<div class="widget">
								<div class="widget-head">#<?= $i++; ?> </div>
								<div class="widget-content row-content">
									<div class="row">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<table class="table tablaFotografico">
												<thead>
													<tr>
														<th colspan="4">INFORMACIÓN VISITA</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>FECHA</td>
														<td style="font-weight:bold;"><?= $row['fecha'] ?></td>
														<td></td>
														<td></td>
													</tr>
													<tr>
														<td>COD GTM</td>
														<td style="font-weight:bold;"><?= $row['idUsuario']; ?></td>
														<td>GTM</td>
														<td style="font-weight:bold;"><?= $row['nombreUsuario']; ?></td>
													</tr>
													<tr>
														<td>COD POS</td>
														<td style="font-weight:bold;"><?= $row['idCliente']; ?></td>
														<td>POS</td>
														<td style="font-weight:bold;"><?= $row['razonSocial']; ?></td>
													</tr>
													<tr>
														<td>GRUPO CANAL</td>
														<td style="font-weight:bold;"><?= $row['grupoCanal']; ?></td>
														<td>CANAL</td>
														<td style="font-weight:bold;"><?= $row['canal']; ?></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<div class="row">
										<?/*?>
										<div class="col-md-6 col-sm-12 col-xs-12">
											<table class="table">
												<thead>
													<tr>
														<th>FOTOS (3)</th>
													</tr>
												</thead>
											</table>
											<div class="container owl" style="width: 100%">

												<div class="right nav-r">
													<a class="prev-owl-<?= $row['idVisita'] ?>"><i class="fa fa-arrow-left"></i></a>
													<a class="next-owl-<?= $row['idVisita'] ?>"><i class="fa fa-arrow-right"></i></a>
												</div>

												<div class="cell-clear-max"></div>
												<div class="rp">
													<div class="recent-news block">
														<div class="recent-item">
															<div id="owl-<?= $row['idVisita'] ?>" class="owl-carousel">
																<div class="item">
																	<a href="https://ww7.visualimpact.com.pe/impactTrade/public/assets/images/sin_imagen.jpg" rel="prettyPhoto[myGallery-<?= $row['idVisita'] ?>]"><img src="https://ww7.visualimpact.com.pe/impactTrade/public/assets/images/sin_imagen.jpg" class="img-responsive" style="width:150px;height:200px;" /></a>
																	<div class="clearfix"></div>
																	<p>
																		#1<br />
																		TIPO FOTO:DEMO
																	</p>
																</div>
																<div class="item">
																	<a href="https://ww7.visualimpact.com.pe/impactTrade/public/assets/images/sin_imagen.jpg" rel="prettyPhoto[myGallery-<?= $row['idVisita'] ?>]"><img src="https://ww7.visualimpact.com.pe/impactTrade/public/assets/images/sin_imagen.jpg" class="img-responsive" style="width:150px;height:200px;" /></a>
																	<div class="clearfix"></div>
																	<p>
																		#2<br />
																		TIPO FOTO:DEMO
																	</p>
																</div>
																<div class="item">
																	<a href="https://ww7.visualimpact.com.pe/impactTrade/public/assets/images/sin_imagen.jpg" rel="prettyPhoto[myGallery-<?= $row['idVisita'] ?>]"><img src="https://ww7.visualimpact.com.pe/impactTrade/public/assets/images/sin_imagen.jpg" class="img-responsive" style="width:150px;height:200px;" /></a>
																	<div class="clearfix"></div>
																	<p>
																		#3<br />
																		TIPO FOTO:DEMO
																	</p>
																</div>
															</div>

														</div>
													</div>
												</div>
											</div>
										</div>
										<?*/?>
									
										<? if (isset($fotosVisita[$row['idVisita']])) { ?>
											<div class="col-md-6 col-sm-12 col-xs-12">
												<table class="table tablaFotografico">
													<thead>
														<tr>
															<th>FOTOS (<?= count($fotosVisita[$row['idVisita']]) ?>)</th>
														</tr>
													</thead>
												</table>
												<div class="container owl" style="width: 100%">
													<? if (count($fotosVisita[$row['idVisita']]) > 3) { ?>
														<div class="right nav-r">
															<a class="prev-owl-<?= $row['idVisita'] ?> btn-outline-trade-visual"><i class="fa fa-arrow-left"></i></a>
															<a class="next-owl-<?= $row['idVisita'] ?> btn-outline-trade-visual"><i class="fa fa-arrow-right"></i></a>
														</div>
													<? } ?>
													<div class="cell-clear-max"></div>
													<div class="rp">
														<div class="recent-news block">
															<div class="recent-item">
																<div id="owl-<?= $row['idVisita'] ?>" class="owl-carousel my-gallery">
																	<? $j = 1; ?>
																	<? foreach ($fotosVisita[$row['idVisita']] as $ix_foto => $row_foto) { ?>
																		<? $urlFotoVisita = site_url().'ControlFoto/obtener_carpeta_foto/'.obtener_carpeta_foto($row_foto['fotoUrl']) ?>
																		<div class="item">
																			<a class="verImagenModal" href="<?= $urlFotoVisita; ?>" rel="prettyPhoto[myGallery-<?= $row['idVisita'] ?>]"><img src="<?= $urlFotoVisita; ?>" class="img-responsive" /></a>
																			<div class="clearfix"></div>
																			<p>
																				#<?= $j++; ?><br />
																				TIPO FOTO: <?= $row_foto['tipoFoto'] ?>
																			</p>
																		</div>
																	<? } ?>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

										<? } else { ?>
											<!--<table class="table">
												<thead>
													<tr><th>FOTOS</th></tr>
												</thead>
											</table>-->
										<? } ?>
										<!--</div>-->
										<div class="col-md-6 col-sm-12 col-xs-12" id="resultado-auditoria-<?= $row['idVisita'] ?>">
											<? if (isset($elementos[$row['idVisita']])) { ?>
												<form id="form-visita-<?= $row['idVisita'] ?>">
													<div class="form-group">
														<label>TIENE ESTRELLAS MARCA PRECIOS&nbsp;</label>
														<div class="btn-group " data-toggle="buttons">
															<label class="btn btn-sm btn-outline-secondary active">
																<input type="radio" name="marca-precios-<?= $row['idVisita'] ?>" value="1" checked /> SI
															</label>
															<label class="btn btn-sm btn-outline-secondary">
																<input type="radio" name="marca-precios-<?= $row['idVisita'] ?>" value="0" /> NO
															</label>
														</div>
													</div>
													<div style="max-height:250px !important;overflow-y:scroll;">
														<table id="tabla-visita-<?= $row['idVisita'] ?>" class="table tablaFotografico">
															<thead>
																<tr>
																	<th colspan="4">ELEMENTOS OBLIGATORIOS - RESULTADO AUDITORIA <span id="resultado-visita-<?= $row['idVisita'] ?>">100</span>%</th>
																</tr>
																<tr>
																	<th colspan="1">ELEMENTO</th>
																	<th colspan="1">PC</th>
																	<th colspan="1">PL</th>
																	<th colspan="1">VALOR</th>
																</tr>
															</thead>

															<tbody>
																<? foreach ($elementos[$row['idVisita']] as $ix_storecheck => $row_storecheck) { ?>
																	<tr data-elemento="<?= $ix_storecheck ?>">
																		<td><?= $row_storecheck['elemento'] ?></td>
																		<td class="text-center">
																			<select id="pc-elemento-<?= $row['idVisita'] ?>-<?= $ix_storecheck ?>" name="pc-elemento-<?= $row['idVisita'] ?>-<?= $ix_storecheck ?>" class="calcular-valor" data-visita="<?= $row['idVisita'] ?>" data-elemento="<?= $ix_storecheck ?>" data-cantidad="<?= count($elementos[$row['idVisita']]) ?>">
																				<option value="0">No Cumple</option>
																				<option value="1" selected>Si Cumple</option>
																				<option value="2">No Presente</option>
																				<option value="3">Foto Errada</option>
																			</select>
																		</td>
																		<td class="text-center">
																			<select id="pl-elemento-<?= $row['idVisita'] ?>-<?= $ix_storecheck ?>" name="pl-elemento-<?= $row['idVisita'] ?>-<?= $ix_storecheck ?>" class="calcular-valor" data-visita="<?= $row['idVisita'] ?>" data-elemento="<?= $ix_storecheck ?>" data-cantidad="<?= count($elementos[$row['idVisita']]) ?>">
																				<option value="0">No Cumple</option>
																				<option value="1" selected>Si Cumple</option>
																				<option value="2">No Presente</option>
																				<option value="3">Foto Errada</option>
																			</select>
																		</td>
																		<td class="text-center"><span id="resultado-elemento-<?= $row['idVisita'] ?>-<?= $ix_storecheck ?>">SI CUMPLE</span></td>
																	</tr>
																<? } ?>
															</tbody>
														</table>
													</div>
												</form>
												<a type="submit" class="form-control btn btn-outline-trade-visual btn-registrar-auditoria-cartera" data-visita="<?= $row['idVisita'] ?>" style="margin-top: 5px;float: right !important"><i class="fa fa-save "></i> Guardar</a>
											<? } else { ?>
												<table class="table tablaFotografico">
													<thead>
														<tr>
															<th>ELEMENTOS OBLIGATORIOS</th>
														</tr>
													</thead>
												</table>
											<? } ?>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 col-sm-12 col-xs-12">
											<? if (isset($lomitoVisita)) { ?>
												<div style="max-height:200px !important;overflow-y:scroll;">
													<table class="table tablaFotografico">
														<thead>
															<tr>
																<th colspan="2">LOMITO</th>
															</tr>
															<tr>
																<th colspan="1">PRODUCTO</th>
																<th colspan="1">ESTADO</th>
															</tr>
														</thead>
														<tbody>
															<? foreach ($lomitoVisita[$row->fecha][$row->idEmpleado][$row->idCliente] as $ix_lomito => $row_lomito) { ?>
																<tr>
																	<td><?= $row_lomito['producto'] ?></td>
																	<td class="text-center"><?= $row_lomito['estado'] ?></td>
																</tr>
															<? } ?>
														</tbody>
													</table>
												</div>
											<? } else { ?>
												<table class="table tablaFotografico">
													<thead>
														<tr>
															<th>LOMITO</th>
														</tr>
													</thead>
												</table>
											<? } ?>
										</div>
										<div class="col-md-6 col-sm-12 col-xs-12">
											<? if (isset($elementos[$row['idVisita']])) { ?>
												<div style="max-height:200px !important;overflow-y:scroll;">
													<table class="table tablaFotografico">
														<thead>
															<tr>
																<th colspan="2">STORECHECK</th>
															</tr>
															<tr>
																<th colspan="1">ELEMENTO</th>
																<th colspan="1">ESTADO</th>
															</tr>
														</thead>
														<tbody>
															<? foreach ($elementos[$row['idVisita']] as $ix_storecheck => $row_storecheck) { ?>
																<tr>
																	<td><?= $row_storecheck['elemento'] ?></td>
																	<td class="text-center"><?= ($row_storecheck['presencia'] == 1) ? 'PRESENTE' : 'NO PRESENTE'; ?></td>
																</tr>
															<? } ?>
														</tbody>
													</table>
												</div>
											<? } else { ?>
												<table class="table tablaFotografico">
													<thead>
														<tr>
															<th>STORECHECK</th>
														</tr>
													</thead>
												</table>
											<? } ?>
										</div>
									</div>
								</div>
							</div>
						<? } ?>
					</div>
				</div>
				<!-- input hidden -->

		

				<!----------------------------------------------------------->
			</div>
		</div>
	</div>
</div>
<div>
<script>
					$(document).ready(function() {
						$("a[rel^='prettyPhoto']").prettyPhoto({
							opacity: 0.70,
							default_width: 640,
							default_height: 480,
							modal: true,
							overlay_gallery: false,
							social_tools: ''
						});

						<? foreach ($visitasAuditar as $row) {
							$idConcat = $row['idVisita'];
						?>
							var owl_<?= $idConcat ?> = $("#owl-<?= $idConcat ?>");
							owl_<?= $idConcat ?>.owlCarousel({
								autoPlay: false, //Set AutoPlay to 3 seconds
								items: 3,
								mouseDrag: true,
								pagination: true
							});
							$(".next-owl-<?= $idConcat ?>").click(function() {
								owl_<?= $idConcat ?>.trigger('owl.next');
							})
							$(".prev-owl-<?= $idConcat ?>").click(function() {
								owl_<?= $idConcat ?>.trigger('owl.prev');
							})

						<? } ?>

						console.log()
					});


					$(document).on('change', '.calcular-valor', function(e) {
						e.preventDefault();
						var idVisita = $(this).attr('data-visita');
						var idElemento = $(this).attr('data-elemento');
						var cantidadElementos = $(this).attr('data-cantidad');
						//
						var pc_valor = $("#pc-elemento-" + idVisita + "-" + idElemento).val();
						var pl_valor = $("#pl-elemento-" + idVisita + "-" + idElemento).val();
						//
						if ((pc_valor == '1') && (pl_valor == '1')) {
							$("#resultado-elemento-" + idVisita + "-" + idElemento).text('SI CUMPLE');
						} else {
							$("#resultado-elemento-" + idVisita + "-" + idElemento).text('NO CUMPLE');
						}
						//
						var totalElementos = parseInt(cantidadElementos);
						var totalOK = 0;
						$("#tabla-visita-" + idVisita + " tbody>tr").each(function(index, value) {
							var idElemento = $(this).attr('data-elemento');
							var pc_valor = $("#pc-elemento-" + idVisita + "-" + idElemento).val();
							var pl_valor = $("#pl-elemento-" + idVisita + "-" + idElemento).val();
							if ((pc_valor == '1') && (pl_valor == '1')) {
								totalOK = totalOK + 1;
							} else {
								totalOK = totalOK + 0;
							}
						});
						//
						var resultadoEO = parseFloat(totalOK / totalElementos) * 100;
						$("#resultado-visita-" + idVisita).text(Math.round(resultadoEO));
					});
				</script>