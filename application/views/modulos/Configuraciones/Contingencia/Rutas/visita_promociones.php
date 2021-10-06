<form id="frm-visitaPromociones">
	<div class="hide">
		<input class="form-control" type="text" id="idVisita" name="idVisita" value="<?= $idVisita ?>">
	</div>
	<div class="row themeWhite" style="padding: 10px;padding-top: 0px;">
		<div class="col-lg-12 d-flex">
			<div class="w-100 mb-3 p-0">
				<div class="card-body p-0">
					<ul class="nav nav-tabs nav-justified">
						<li class="nav-item" id="nav-link-0"><a data-toggle="tab" href="#tab-competencia-0" class="nav-link active show">LISTA DE PROMOCIONES</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="tab-content">
				<div class="table-responsive">
					<table id="tb-promociones" class="mb-0 table table-bordered text-nowrap w-100" width="100%">
						<thead>
							<tr>
								<th class="text-center align-middle">
									<div class="ml-auto">
										<button type="button" id="btn-addRowPromociones" class="btn btn-outline-secondary border-0" title="Agregar nueva fila"><i class="fas fa-plus fa-lg"></i></button>
									</div>
								</th>
								<th class="text-center align-middle">TIPO DE PROMOCIÓN</th>
								<th class="text-center align-middle">PROMOCIÓN</th>
								<th class="text-center align-middle">PRESENCIA</th>
								<th class="text-center align-middle">FOTO</th>
							</tr>
						</thead>
						<tbody class="tb-promocion">
							<? $ixt = 1; ?>
							<? if (!empty($listaVisitas)) : ?>
								<? foreach ($listaVisitas as $kv => $visita) : ?>
									<tr class="tr-promociones" data-visitaPromociones="1" data-visitaPromocionesDet="<?= $kv ?>" data-promocion="<?= $visita['idPromocion'] ?>">
										<td class="text-center"><?= $ixt++; ?></td>
										<td class="text-center">
											<?= (!empty($visita['tipoPromocion']) ? $visita['tipoPromocion'] : '-'); ?>
											<div class="hide">
												<? $idTipoPromocion = (!empty($visita['idTipoPromocion']) ? $visita['idTipoPromocion'] : ''); ?>
												<input type="text" id="tipoPromocion-<?= $kv ?>" name="tipoPromocion-<?= $kv ?>" value="<?= $idTipoPromocion; ?>">
											</div>
										</td>
										<td class="text-center">
											<?= (!empty($visita['nombrePromocion']) ? $visita['nombrePromocion'] : '-'); ?>
											<div class="hide">
												<? $nombrePromocion = (!empty($visita['nombrePromocion']) ? $visita['nombrePromocion'] : ''); ?>
												<input type="text" id="nombrePromocion-<?= $kv ?>" name="nombrePromocion-<?= $kv ?>" value="<?= $nombrePromocion; ?>">
											</div>
										</td>
										<td class="text-center">
											<div class="custom-checkbox custom-control">
												<? $checkedPresencia = (isset($visita['presencia']) && !empty($visita['presencia'])) ? 'checked' : ''; ?>
												<input <?= $checkedPresencia; ?> class="custom-control-input" type="checkbox" id="presencia-<?= $kv; ?>" name="presencia-<?= $kv; ?>" value="1">
												<label class="custom-control-label" for="presencia-<?= $kv; ?>"></label>
											</div>
										</td>
										<td class="text-center">
											<div id="foto-<?= $kv; ?>" style="display:inline-flex;">
												<? $fotoImg = (isset($visita['foto']) && !empty($visita['foto'])) ? $this->fotos_url . 'promociones/' . $visita['foto'] : ''; ?>
												<div>
													<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-<?= $kv ?>">
														<img class="fotoMiniatura foto" name="img-fotoprincipal-<?= $kv ?>" id="img-fotoprincipal-<?= $kv ?>" src="<?= $fotoImg; ?>" alt="" style="width: 40px;display: none;">
													</a>
												</div>
												<div>
													<span class="btn border-0 btn-outline-secondary btn-file btnAbrirFoto disabled" title="Abrir imagen subida"><i class="fal fa-image-polaroid fa-lg" aria-hidden="true"></i></span>
												</div>
												<div>
													<div class="content-input-file">
														<input type="text" readonly="readonly" id="txt-fotoprincipal-<?= $kv ?>" name="fotoprincipal-<?= $kv ?>" class="hide">
														<input type="text" readonly="readonly" id="txt-fotoprincipal-<?= $kv ?>_show" class="text-file hide" placeholder="Solo .jpg">
														<span class="btn border-0 btn-outline-secondary btn-file btnFoto" data-file="fl-fotoprincipal-<?= $kv ?>" title="Subir imagen JPG"><i class="fa fa-file-upload fa-lg" aria-hidden="true"></i></span>
														<input type="file" id="fl-fotoprincipal-<?= $kv ?>" class="fl-control hide" name="filefotoprincipal-<?= $kv ?>" data-content="txt-fotoprincipal-<?= $kv ?>" accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal-<?= $kv ?>">
													</div>
												</div>
											</div>
										</td>
									</tr>
								<? endforeach ?>
							<? else : ?>
								<? foreach ($listaPromociones as $kp => $promocion) : ?>
									<tr class="tr-promociones" data-visitaPromociones="0" data-visitaPromocionesDet="<?= $kp ?>" data-promocion="<?= $kp ?>">
										<td class="text-center"><?= $ixt++; ?></td>
										<td class="text-center">
											<?= (!empty($promocion['tipoPromocion']) ? $promocion['tipoPromocion'] : '-'); ?>
											<div class="hide">
												<? $idTipoPromocion = (!empty($promocion['idTipoPromocion']) ? $promocion['idTipoPromocion'] : ''); ?>
												<input type="text" id="tipoPromocion-<?= $kp ?>" name="tipoPromocion-<?= $kp ?>" value="<?= $idTipoPromocion; ?>">
											</div>
										</td>
										<td class="">
											<?= (!empty($promocion['promocion']) ? $promocion['promocion'] : '-'); ?>
											<div class="hide">
												<? $nombrePromocion = (!empty($promocion['promocion']) ? $promocion['promocion'] : ''); ?>
												<input type="text" id="nombrePromocion-<?= $kp ?>" name="nombrePromocion-<?= $kp ?>" value="<?= $nombrePromocion; ?>">
											</div>
										</td>
										<td class="text-center">
											<div class="custom-checkbox custom-control">
												<input class="custom-control-input" type="checkbox" id="presencia-<?= $kp; ?>" name="presencia-<?= $kp; ?>" value="1">
												<label class="custom-control-label" for="presencia-<?= $kp; ?>"></label>
											</div>
										</td>
										<td class="text-center">
											<div id="foto-<?= $kp; ?>" style="display:inline-flex;" class="divContentImg">
												<div>
													<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-<?= $kp ?>">
														<img class="fotoMiniatura foto" name="img-fotoprincipal-<?= $kp ?>" id="img-fotoprincipal-<?= $kp ?>" src="" alt="" style="width: 40px;display: none;">
													</a>
												</div>
												<div>
													<span class="btn border-0 btn-outline-secondary btn-file btnAbrirFoto disabled" title="Abrir imagen subida"><i class="fal fa-image-polaroid fa-lg" aria-hidden="true"></i></span>
												</div>
												<div>
													<div class="content-input-file">
														<input type="text" readonly="readonly" id="txt-fotoprincipal-<?= $kp ?>" name="fotoprincipal-<?= $kp ?>" class="hide">
														<input type="text" readonly="readonly" id="txt-fotoprincipal-<?= $kp ?>_show" class="text-file hide" placeholder="Solo .jpg">
														<span class="btn border-0 btn-outline-secondary btn-file btnFoto" data-file="fl-fotoprincipal-<?= $kp ?>" title="Subir imagen JPG"><i class="fa fa-file-upload fa-lg" aria-hidden="true"></i></span>
														<input type="file" id="fl-fotoprincipal-<?= $kp ?>" class="fl-control hide" name="filefotoprincipal-<?= $kp ?>" data-content="txt-fotoprincipal-<?= $kp ?>" accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal-<?= $kp ?>">
													</div>
												</div>
											</div>
										</td>
									</tr>
								<? endforeach ?>
							<? endif ?>
						</tbody>
					</table>
					<div class="hide">
						<input class="form-control" type="text" id="contNumberPromociones" id="contNumberPromociones" value="<?= $ixt; ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<script>
	$('#tb-promociones').DataTable();
	setTimeout(function() {
		$('#tb-promociones').DataTable().columns.adjust();
	}, 1000);
	ContingenciaRutas.dataListaTipoPromociones = JSON.parse('<?= json_encode($listaTipoPromociones) ?>');
</script>