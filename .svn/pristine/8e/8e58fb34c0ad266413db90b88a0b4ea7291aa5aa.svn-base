<form id="frm-visitaIniciativaTrad">
	<div class="hide">
		<input class="form-control" type="text" id="idVisita" name="idVisita" value="<?= $idVisita ?>">
	</div>
	<div class="row themeWhite" style="padding: 10px;padding-top: 0px;">
		<div class="col-lg-12 d-flex">
			<div class="w-100 mb-3 p-0">
				<div class="card-body p-0">
					<ul class="nav nav-tabs nav-justified">
						<? $ix = 1; ?>
						<? foreach ($listaIniciativas as $kli => $iniciativas) : ?>
							<? $active = ($ix == 1 ? 'active' : ''); ?>
							<li class="nav-item" id="nav-link-<?= $kli ?>"><a data-toggle="tab" href="#tab-iniciativas-<?= $kli ?>" class="nav-link <?= $active; ?> show text-uppercase"><?= $iniciativas['iniciativa']; ?></a></li>
							<? $ix++; ?>
						<? endforeach ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="tab-content">
				<!----DETALLE LISTA INICIATIVAS---->
				<? $ix = 1; ?>
				<? foreach ($listaIniciativas as $kli => $iniciativas) : ?>
					<? $active = ($ix == 1 ? 'active' : ''); ?>
					<div class="tab-pane <?= $active ?> show" id="tab-iniciativas-<?= $kli ?>" role="tabpanel">
						<div class="table-responsive">
							<table id="tb-iniciativas-<?= $kli ?>" class="mb-0 table table-bordered table-sm text-nowrap">
								<thead>
									<tr>
										<th class="text-center align-middle">#</th>
										<th class="text-center align-middle">ELEMENTO</th>
										<th class="text-center align-middle">CHECK</th>
										<th class="text-center align-middle">CANTIDAD</th>
										<th class="text-center align-middle">ESTADO</th>
										<th class="text-center align-middle">PRODUCTO</th>
										<th class="text-center align-middle">FOTO</th>
									</tr>
								</thead>
								<tbody class="tb-iniciativas" data-iniciativas="<?= $kli ?>">
									<? $ixt = 1; ?>
									<? foreach ($iniciativas['listaElementosIniciativa'] as $klev => $elementos) : ?>
										<?
										$dataVisitaIniciativaTrad = (isset($listaVisitas[$kli]['listaElementosIniciativa'][$klev]['idVisitaIniciativaTrad']) && !empty($listaVisitas[$kli]['listaElementosIniciativa'][$klev]['idVisitaIniciativaTrad'])) ? $listaVisitas[$kli]['listaElementosIniciativa'][$klev]['idVisitaIniciativaTrad'] : '';
										$dataVisitaIniciativaTradDet = (isset($listaVisitas[$kli]['listaElementosIniciativa'][$klev]['idVisitaIniciativaTradDet']) && !empty($listaVisitas[$kli]['listaElementosIniciativa'][$klev]['idVisitaIniciativaTradDet'])) ? $listaVisitas[$kli]['listaElementosIniciativa'][$klev]['idVisitaIniciativaTradDet'] : '';
										?>
										<tr class="tr-iniciativas" data-visitaIniciativaTrad="<?= $dataVisitaIniciativaTrad ?>" data-visitaIniciativaTradDet="<?= $dataVisitaIniciativaTradDet ?>" data-iniciativa="<?= $kli ?>" data-elementoIniciativa="<?= $klev ?>">
											<td class="text-center"><?= $ixt++; ?></td>
											<td class="text-center"><?= $elementos['elementoIniciativa'] ?>
												<div class="hide">
													<input type="text" class="form-control" id="elementoIniciativa-<?= $kli ?>-<?= $klev ?>" name="elementoIniciativa-<?= $kli ?>-<?= $klev ?>" value="<?= $elementos['idElementoIniciativa']; ?>">
												</div>
											</td>
											<td class="text-center">
												<? $checkedPresencia = (isset($listaVisitas[$kli]['listaElementosIniciativa'][$klev]['presencia']) && !empty($listaVisitas[$kli]['listaElementosIniciativa'][$klev]['presencia'])) ? 'checked' : ''; ?>
												<div class="custom-checkbox custom-control">
													<input <?= $checkedPresencia; ?> class="custom-control-input" type="checkbox" id="presencia-<?= $kli ?>-<?= $klev ?>" name="presencia-<?= $kli ?>-<?= $klev ?>" value="1">
													<label class="custom-control-label" for="presencia-<?= $kli ?>-<?= $klev ?>"></label>
												</div>
											</td>
											<td class="text-center">
												<? $cantidadVisita = (isset($listaVisitas[$kli]['listaElementosIniciativa'][$klev]['cantidad']) && !empty($listaVisitas[$kli]['listaElementosIniciativa'][$klev]['cantidad'])) ? $listaVisitas[$kli]['listaElementosIniciativa'][$klev]['cantidad'] : ''; ?>
												<input type="text" class="form-control ipWidth" placeholder="Cantidad" id="cantidad-<?= $kli ?>-<?= $klev ?>" name="cantidad-<?= $kli ?>-<?= $klev ?>" value="<?= $cantidadVisita; ?>">
											</td>
											<td class="text-center">
												<? $visitaEstadoIniciativa = (isset($listaVisitas[$kli]['listaElementosIniciativa'][$klev]['idEstadoIniciativa']) && !empty($listaVisitas[$kli]['listaElementosIniciativa'][$klev]['idEstadoIniciativa'])) ? $listaVisitas[$kli]['listaElementosIniciativa'][$klev]['idEstadoIniciativa'] : ''; ?>
												<select class="form-control slWidth" name="estadoIniciativa-<?= $kli ?>-<?= $klev ?>" id="estadoIniciativa-<?= $kli ?>-<?= $klev ?>">
													<option value="">--- Estado ---</option>
													<?foreach($elementos['estado'] as $kele_estado => $vele_estado){?>
														<? $checkedEstadoIniciativas = $kele_estado == $visitaEstadoIniciativa ? 'selected' : ''; ?>
														<option value="<?= $kele_estado ?>" <?= $checkedEstadoIniciativas; ?>><?= $vele_estado ?></option>
													<?}?>
												</select>
											</td>
											<td class="text-center">
												<? $checkedProducto = (isset($listaVisitas[$kli]['listaElementosIniciativa'][$klev]['producto']) && !empty($listaVisitas[$kli]['listaElementosIniciativa'][$klev]['producto'])) ? 'checked' : ''; ?>
												<div class="custom-checkbox custom-control">
													<input <?= $checkedProducto; ?> class="custom-control-input" type="checkbox" id="producto-<?= $kli ?>-<?= $klev ?>" name="producto-<?= $kli ?>-<?= $klev ?>" value="1">
													<label class="custom-control-label" for="producto-<?= $kli ?>-<?= $klev ?>"></label>
												</div>
											</td>
											<td class="text-center">
												<div id="foto-<?= $kli ?>-<?= $klev ?>" style="display:inline-flex;" class="divContentImg">
													<? $fotoImg = (isset($listaVisitas[$kli]['listaElementosIniciativa'][$klev]['idVisitaFoto']) && !empty($listaVisitas[$kli]['listaElementosIniciativa'][$klev]['idVisitaFoto'])) ? $this->fotos_url . 'iniciativa/' . $listaVisitas[$kli]['listaElementosIniciativa'][$klev]['foto'] : ''; ?>
													<div>
														<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-<?= $kli ?>-<?= $klev ?>">
															<img class="fotoMiniatura foto" name="img-fotoprincipal-<?= $kli ?>-<?= $klev ?>" id="img-fotoprincipal-<?= $kli ?>-<?= $klev ?>" src="<?= $fotoImg; ?>" alt="" style="width: 40px;display: none;">
														</a>
													</div>
													<div>
														<span class="btn border-0 btn-outline-secondary btn-file btnAbrirFoto<?=(empty($fotoImg) ? " disabled" : "")?>" title="Abrir imagen subida"><i class="fal fa-image-polaroid fa-lg" aria-hidden="true"></i></span>
													</div>
													<div>
														<div class="content-input-file">
															<input type="text" readonly="readonly" id="txt-fotoprincipal-<?= $kli ?>-<?= $klev ?>" name="fotoprincipal-<?= $kli ?>-<?= $klev ?>" class="hide">
															<input type="text" readonly="readonly" id="txt-fotoprincipal-<?= $kli ?>-<?= $klev ?>_show" class="text-file hide" placeholder="Solo .jpg">
															<span class="btn border-0 btn-outline-secondary btn-file btnFoto" data-file="fl-fotoprincipal-<?= $kli ?>-<?= $klev ?>" title="Subir imagen JPG"><i class="fa fa-file-upload fa-lg" aria-hidden="true"></i></span>
															<input type="file" id="fl-fotoprincipal-<?= $kli ?>-<?= $klev ?>" class="fl-control hide" name="filefotoprincipal-<?= $kli ?>-<?= $klev ?>" data-content="txt-fotoprincipal-<?= $kli ?>-<?= $klev ?>" accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal-<?= $kli ?>-<?= $klev ?>">
														</div>
													</div>
												</div>
											</td>
										</tr>
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