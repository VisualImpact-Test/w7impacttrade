<form id="frm-visitaInteligencia">
	<div class="hide">
		<input class="form-control" type="text" id="idVisita" name="idVisita" value="<?= $idVisita ?>">
	</div>
	<div class="row themeWhite" style="padding: 10px;padding-top: 0px;">
		<div class="col-lg-12 d-flex">
			<div class="w-100 mb-3 p-0">
				<div class="card-body p-0">
					<ul class="nav nav-tabs nav-justified">
						<li class="nav-item" id="nav-link-0"><a data-toggle="tab" href="#tab-competencia-0" class="nav-link active show">LISTA DE COMPETENCIAS</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="tab-content">
				<div class="table-responsive">
					<table id="tb-competencias" class="mb-0 table table-bordered table-sm text-nowrap">
						<thead>
							<tr>
								<th class="text-center align-middle">
									<div class="ml-auto">
										<button type="button" id="btn-addRowInteligencia" class="btn btn-outline-secondary border-0" title="Agregar nueva fila"><i class="fas fa-plus fa-lg"></i></button>
									</div>
								</th>
								<th class="text-center align-middle">CATEGORÍA</th>
								<th class="text-center align-middle">MARCA</th>
								<th class="text-center align-middle">TIPO COMPETENCIA</th>
								<th class="text-center align-middle">COMENTARIO</th>
								<th class="text-center align-middle">FOTO</th>
							</tr>
						</thead>
						<tbody class="tb-competencia">
							<? $ixt = 1; ?>
							<? if (!empty($listaVisitas)) : ?>
								<? foreach ($listaVisitas as $klv => $visitas) : ?>
									<tr class="tr-competencias" data-visitaInteligencia="1" data-visitaInteligenciaCompetitiva="<?= $klv ?>">
										<td class="text-center"><?= $ixt++; ?></td>
										<td class="text-center"><?= $visitas['categoria']; ?>
											<div class="hide">
												<input type="text" class="form-control" id="categoria-<?= $klv ?>" name="categoria-<?= $klv ?>" value="<?= $visitas['idCategoria']; ?>">
											</div>
										</td>
										<td class="text-center"><?= $visitas['marca']; ?>
											<div class="hide">
												<input type="text" class="form-control" id="marca-<?= $klv ?>" name="marca-<?= $klv ?>" value="<?= $visitas['idMarca']; ?>">
											</div>
										</td>
										<td class="text-center"><?= $visitas['tipoCompetencia']; ?>
											<div class="hide">
												<input type="text" class="form-control" id="competencia-<?= $klv ?>" name="competencia-<?= $klv ?>" value="<?= $visitas['idTipoCompetencia']; ?>">
											</div>
										</td>
										<td class="text-center"><?= $visitas['comentario']; ?>
											<div class="hide">
												<input type="text" class="form-control" id="comentario-<?= $klv ?>" name="comentario-<?= $klv ?>" value="<?= $visitas['comentario']; ?>">
											</div>
										</td>
										<td class="text-center">
											<? $fotoImg = (isset($visitas['foto']) && !empty($visitas['foto'])) ? $this->fotos_url . 'inteligencia/' . $visitas['foto'] : ''; ?>
											<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-<?= $klv ?>">
												<img class="fotoMiniatura foto" name="img-fotoprincipal-<?= $klv ?>" id="img-fotoprincipal-<?= $klv ?>" src="<?= $fotoImg; ?>" alt="">
											</a>
										</td>
									</tr>
								<? endforeach ?>
							<? else : ?>
								<? foreach ($listaCategorias as $klct => $categorias) : ?>
									<? foreach ($categorias['listaMarcas'] as $klm => $marcas) : ?>
										<tr class="tr-competencias" data-visitaInteligencia="0" data-visitaInteligenciaCompetitiva="<?= $klct ?>-<?= $klm ?>">
											<td class="text-center"><?= $ixt++; ?></td>
											<td class="text-center">
												<?= $categorias['categoria']; ?>
												<div class="hide">
													<input type="text" class="form-control" id="categoria-<?= $klct ?>-<?= $klm ?>" name="categoria-<?= $klct ?>-<?= $klm ?>" value="<?= $categorias['idCategoria']; ?>" style="width: 100%;">
												</div>
											</td>
											<td class="text-center">
												<?= $marcas['marca']; ?>
												<div class="hide">
													<input type="text" class="form-control" id="marca-<?= $klct ?>-<?= $klm ?>" name="marca-<?= $klct ?>-<?= $klm ?>" value="<?= $categorias['idCategoria']; ?>" style="width: 100%;">
												</div>
											</td>
											<td class="text-center">
												<select class="form-control slWidth" name="competencia-<?= $klct ?>-<?= $klm ?>" id="competencia-<?= $klct ?>-<?= $klm ?>" style="width: 100%;">
													<option value="">Tipo Competencia</option>
													<? foreach ($tipoCompetencias as $ktc => $competencias) : ?>
														<option value="<?= $competencias['idTipoCompetencia'] ?>"><?= $competencias['tipoCompetencia'] ?></option>
													<? endforeach ?>
												</select>
											</td>
											<td class="text-center">
												<input type="text" class="form-control ipWidth" placeholder="Comentario" id="comentario-<?= $klct ?>-<?= $klm ?>" name="comentario-<?= $klct ?>-<?= $klm ?>" value="" style="width: 100%;">
											</td>
											<td class="text-center">
												<div id="foto-<?= $klct ?>-<?= $klm ?>" style="display:inline-flex;" class="divContentImg">
													<div>
														<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-<?= $klct ?>-<?= $klm ?>">
															<img class="fotoMiniatura foto" name="img-fotoprincipal-<?= $klct ?>-<?= $klm ?>" id="img-fotoprincipal-<?= $klct ?>-<?= $klm ?>" src="" alt="" style="width: 40px;display: none;">
														</a>
													</div>
													<div>
														<span class="btn border-0 btn-outline-secondary btn-file btnAbrirFoto disabled" title="Abrir imagen subida"><i class="fal fa-image-polaroid fa-lg" aria-hidden="true"></i></span>
													</div>
													<div>
														<div class="content-input-file">
															<input type="text" readonly="readonly" id="txt-fotoprincipal-<?= $klct ?>-<?= $klm ?>" name="fotoprincipal-<?= $klct ?>-<?= $klm ?>" class="hide">
															<input type="text" readonly="readonly" id="txt-fotoprincipal-<?= $klct ?>-<?= $klm ?>_show" class="text-file hide" placeholder="Solo .jpg">
															<span class="btn border-0 btn-outline-secondary btn-file btnFoto" data-file="fl-fotoprincipal-<?= $klct ?>-<?= $klm ?>" title="Subir imagen JPG"><i class="fa fa-file-upload fa-lg" aria-hidden="true"></i></span>
															<input type="file" id="fl-fotoprincipal-<?= $klct ?>-<?= $klm ?>" class="fl-control hide" name="filefotoprincipal-<?= $klct ?>-<?= $klm ?>" data-content="txt-fotoprincipal-<?= $klct ?>-<?= $klm ?>" accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal-<?= $klct ?>-<?= $klm ?>">
														</div>
													</div>
												</div>
											</td>
										</tr>
									<? endforeach ?>
								<? endforeach ?>
							<? endif ?>
						</tbody>
					</table>
				</div>
				<div class="hide">
					<input class="form-control" type="text" id="contNumberCompetencias" id="contNumberCompetencias" value="<?= $ixt; ?>">
				</div>
			</div>
		</div>
	</div>
</form>

<script>
	ContingenciaRutas.dataListaCategoriaCompetencia = JSON.parse('<?= json_encode($listaCategorias) ?>');
	ContingenciaRutas.dataListaTipoCompetencia = JSON.parse('<?= json_encode($tipoCompetencias) ?>');
</script>