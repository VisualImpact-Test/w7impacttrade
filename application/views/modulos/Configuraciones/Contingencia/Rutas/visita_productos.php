<form id="frm-visitaProductos">
	<div class="hide">
		<input class="form-control" type="text" id="idVisita" name="idVisita" value="<?= $idVisita ?>">
	</div>
	<div class="row themeWhite" style="padding: 10px;padding-top: 0px;">
		<div class="col-lg-12 d-flex">
			<div class="w-100 mb-3 p-0">
				<div class="card-body p-0">
					<ul class="nav nav-tabs nav-justified">
						<? $ix = 1; ?>
						<? foreach ($listaCompetencia as $klc => $competencia) : ?>
							<? $active = ($ix == 1 ? 'active' : ''); ?>
							<li class="nav-item" id="nav-link-<?= $klc ?>"><a data-toggle="tab" href="#tab-competencia-<?= $klc ?>" class="nav-link <?= $active; ?> show"><?= $competencia['competencia']; ?></a></li>
							<? $ix++; ?>
						<? endforeach ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="tab-content">
				<!----DETALLE COMPETENCIA--->
				<? $ix = 1; ?>
				<? foreach ($listaCompetencia as $klc => $competencia) : ?>
					<? $active = ($ix == 1 ? 'active' : ''); ?>
					<div class="tab-pane <?= $active ?> show" id="tab-competencia-<?= $klc ?>" role="tabpanel">
						<!--h5 class="card-title"><? //=$competencia['competencia']
													?></h5-->
						<? $canalTradicional = '';
						$canalModerno = '';
						if ($grupoCanal == 1) {
							$canalModerno = 'hide';
						} elseif ($grupoCanal == 2) {
							$canalTradicional = 'hide';
						}
						?>
						<!----DETALLE CATEGORIAS---->
						<div class="table-responsive">
							<table id="tb-productos-<?= $klc ?>" class="mb-0 table table-bordered text-nowrap w-100" width="100%">
								<thead>
									<tr>
										<th class="text-center align-middle">#</th>
										<th class="text-center align-middle">CATEGORIA</th>
										<th class="text-center align-middle">MARCA</th>
										<th class="text-center align-middle">PRODUCTO</th>
										<th class="text-center align-middle">PRESENCIA</th>
										<th class="text-center align-middle ">UNIDAD MEDIDA</th>
										<th class="text-center align-middle ">MOTIVO</th>
										<th class="text-center align-middle <?=(!in_array('quiebre',$columnasAdicionales)) ? 'hide': '' ?>">QUIEBRE</th>
										<th class="text-center align-middle <?=(!in_array('stock',$columnasAdicionales)) ? 'hide': '' ?>">STOCK</th>
										<th class="text-center align-middle <?=(!in_array('precio',$columnasAdicionales)) ? 'hide': '' ?>">PRECIO</th>
										<th class="text-center align-middle">FOTO</th>
									</tr>
								</thead>
								<tbody class="tb-competencia" data-tbCompetencia="<?= $klc; ?>">
									<? $ixt = 1; ?>
									<? foreach ($competencia['listaCategorias'] as $klct => $categoria) : ?>
										<? foreach ($categoria['listaMarcas'] as $klm => $marca) : ?>
											<? foreach ($marca['listaProductos'] as $klp => $producto) : ?>
												<?
												$idVisitaProductos = (isset($listaVisitas[$klc][$klp]['idVisitaProductos']) && !empty($listaVisitas[$klc][$klp]['idVisitaProductos'])) ? $listaVisitas[$klc][$klp]['idVisitaProductos'] : '';
												$idVisitaProductosDet = (isset($listaVisitas[$klc][$klp]['idVisitaProductosDet']) && !empty($listaVisitas[$klc][$klp]['idVisitaProductosDet'])) ? $listaVisitas[$klc][$klp]['idVisitaProductosDet'] : '';
												?>
												<tr class="tr-checklistProductos" data-competencia="<?= $klc ?>" data-categoria="<?= $klct ?>" data-marca="<?= $klm ?>" data-producto="<?= $klp ?>" data-visitaProducto="<?= $idVisitaProductos; ?>" data-visitaProductoDet="<?= $idVisitaProductosDet; ?>">

													<td class=""><?= $ixt++; ?></td>
													<td class="text-uppercase"><?= $categoria['categoria'] ?></td>
													<td class=""><?= $marca['marca'] ?></td>
													<td class=""><?= $producto['producto'] ?></td>
													<td class="text-center">
														<div class="custom-checkbox custom-control">
															<? $checkedPresencia = (isset($listaVisitas[$klc][$klp]['presencia']) && !empty($listaVisitas[$klc][$klp]['presencia'])) ? 'checked' : ''; ?>
															<input <?= $checkedPresencia; ?> class="custom-control-input" type="checkbox" id="presencia-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>" name="presencia-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>" value="1">
															<label class="custom-control-label" for="presencia-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>"></label>
														</div>
													</td>
													<td class="text-center ">
														<? $unidadMedidaVisita = (isset($listaVisitas[$klc][$klp]['idUnidadMedida']) && !empty($listaVisitas[$klc][$klp]['idUnidadMedida'])) ? $listaVisitas[$klc][$klp]['idUnidadMedida'] : ''; ?>
														<select class="form-control form-control-sm slWidth" name="unidadMedida-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>" id="unidadMedida-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>">
															<option value="">Unidad de Medida</option>
															<? foreach ($unidadMedida as $kum => $unidad) : ?>
																<? $selected = ($unidad['idUnidadMedida'] == $unidadMedidaVisita ? 'selected' : ''); ?>
																<option value="<?= $unidad['idUnidadMedida'] ?>" <?= $selected; ?>><?= $unidad['unidadMedida'] ?></option>
															<? endforeach ?>
														</select>
													</td>
													<td class="text-center ">
														<? $motivoVisita = (isset($listaVisitas[$klc][$klp]['idMotivo']) && !empty($listaVisitas[$klc][$klp]['idMotivo'])) ? $listaVisitas[$klc][$klp]['idMotivo'] : ''; ?>
														<select class="form-control form-control-sm slWidth" id="motivo-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>" name="motivo-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>">
															<option value="">Motivo</option>
															<? foreach ($motivos as $km => $motivo) : ?>
																<? $selected = ($motivo['idMotivo'] == $motivoVisita ? 'selected' : ''); ?>
																<option value="<?= $motivo['idMotivo'] ?>" <?= $selected; ?>><?= $motivo['motivo'] ?></option>
															<? endforeach ?>
														</select>
													</td>
													<td class="text-center <?=(!in_array('quiebre',$columnasAdicionales)) ? 'hide': '' ?>">
														<div class="custom-checkbox custom-control">
															<? $checkedQuiebre = (isset($listaVisitas[$klc][$klp]['quiebre']) && !empty($listaVisitas[$klc][$klp]['quiebre'])) ? 'checked' : ''; ?>
															<input <?= $checkedQuiebre; ?> class="custom-control-input" type="checkbox" id="quiebre-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>" name="quiebre-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>" value="1">
															<label class="custom-control-label" for="quiebre-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>"></label>
														</div>
													</td>
													<td class="text-center <?=(!in_array('stock',$columnasAdicionales)) ? 'hide': '' ?>">
														<? $stockVisita = (isset($listaVisitas[$klc][$klp]['stock']) && !empty($listaVisitas[$klc][$klp]['stock'])) ? $listaVisitas[$klc][$klp]['stock'] : ''; ?>
														<input type="text" class="form-control form-control-sm ipWidth" placeholder="Stock" id="stock-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>" name="stock-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>" value="<?= $stockVisita; ?>">
													</td>
	
													<td class="text-center <?=(!in_array('precio',$columnasAdicionales)) ? 'hide': '' ?>">
														<? $precioVisita = (isset($listaVisitas[$klc][$klp]['precio']) && !empty($listaVisitas[$klc][$klp]['precio'])) ? $listaVisitas[$klc][$klp]['precio'] : ''; ?>
														<input class="form-control form-control-sm ipWidth" type="text" placeholder="Precio" id="precio-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>" name="precio-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>" value="<?= $precioVisita; ?>">
													</td>

													<td class="text-center">
														<div id="foto-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>" class="divContentImg" style="display:inline-flex;">
															<? $fotoImg = (isset($listaVisitas[$klc][$klp]['idVisitaFoto']) && !empty($listaVisitas[$klc][$klp]['idVisitaFoto'])) ? $this->fotos_url . 'checklist/' . $listaVisitas[$klc][$klp]['foto'] : ''; ?>
															<div>
																<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-<?= $klc ?>-<?= $klp ?>">
																	<img class="fotoMiniatura foto" id="img-fotoprincipal-<?= $klc ?>-<?= $klp ?>" src="<?= $fotoImg; ?>" alt="" style="width: 40px;display: none;">
																</a>
															</div>
															<div>
																<span class="btn border-0 btn-outline-secondary btn-file btnAbrirFoto disabled" title="Abrir imagen subida"><i class="fal fa-image-polaroid fa-lg" aria-hidden="true"></i></span>
															</div>
															<div>
																<div class="content-input-file">
																	<input type="text" readonly="readonly" id="txt-fotoprincipal-<?= $klc ?>-<?= $klp ?>" name="fotoprincipal-<?= $klc ?>-<?= $klp ?>" class="hide">
																	<input type="text" readonly="readonly" id="txt-fotoprincipal-<?= $klc ?>-<?= $klp ?>_show" class="text-file hide" placeholder="Solo .jpg">
																	<span class="btn border-0 btn-outline-secondary btn-file btnFoto" data-file="fl-fotoprincipal-<?= $klc ?>-<?= $klp ?>" title="Subir imagen JPG"><i class="fa fa-file-upload fa-lg" aria-hidden="true"></i></span>
																	<input type="file" id="fl-fotoprincipal-<?= $klc ?>-<?= $klp ?>" class="fl-control hide" name="filefotoprincipal-<?= $klc ?>-<?= $klp ?>" data-content="txt-fotoprincipal-<?= $klc ?>-<?= $klp ?>" accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal-<?= $klc ?>-<?= $klp ?>">
																</div>
															</div>
														</div>
													</td>
												</tr>
											<? endforeach ?>
										<? endforeach ?>
									<? endforeach ?>
								</tbody>
							</table>
						</div>
					</div>
					<? $ix++; ?>
				<? endforeach ?>
			</div>
		</div>
	</div>
</form>

<script>
	$('#tb-productos-0').DataTable();
	$('#tb-productos-1').DataTable();

	setTimeout(function() {
		$('#tb-productos-0').DataTable().columns.adjust();
		$('#tb-productos-1').DataTable().columns.adjust();
	}, 1000);
</script>