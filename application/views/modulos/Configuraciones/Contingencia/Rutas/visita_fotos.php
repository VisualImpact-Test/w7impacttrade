<form id="frm-visitaFotos">
	<div class="hide">
		<input class="form-control" type="text" id="idVisita" name="idVisita" value="<?= $idVisita ?>">
	</div>
	<div class="row themeWhite" style="padding: 10px;padding-top: 0px;">
		<div class="col-lg-12 d-flex">
			<div class="w-100 mb-3 p-0">
				<div class="card-body p-0">
					<ul class="nav nav-tabs nav-justified">
						<li class="nav-item" id="nav-link-0"><a data-toggle="tab" href="#tab-competencia-0" class="nav-link active show">LISTA DE FOTOS DE LA VISITA</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="tab-content">
				<div class="table-responsive">
					<table id="tb-fotos" class="mb-0 table table-bordered table-sm text-nowrap" width="100%">
						<thead>
							<tr>
								<th class="text-center align-middle">
									<div class="ml-auto">
										<button type="button" id="btn-addRowFoto" class="btn btn-outline-secondary border-0" title="Agregar nueva fila"><i class="fas fa-plus fa-lg"></i></button>
									</div>
								</th>
								<th class="text-center align-middle">TIPO DE FOTO</th>
								<th class="text-center align-middle">FOTO</th>
								<th class="text-center align-middle">COMENTARIO</th>
								<th class="text-center align-middle">OPCIONES</th>
							</tr>
						</thead>
						<tbody class="tb-foto">
							<? $ix = 1; ?>
							<? if (isset($listaVisitas)) : ?>
								<? foreach ($listaVisitas as $kv => $visita) : ?>
									<tr class="tr-moduloFoto">
										<td class="text-center"><?= $ix++; ?></td>
										<td class="text-center"><?= $visita['nombreTipoFoto'] ?></td>
										<td class="text-center divContentImg">
											<a href="javascript:;" class="lk-foto-1" data-content="foto-<?= $kv ?>">
												<img id="foto-<?= $kv ?>" class="fotoMiniatura imgNormal" src="<?= site_url("controlFoto/obtener_carpeta_foto/moduloFotos/{$visita['foto']}") ?>" alt="" style="width: 40px;display: none;">
											</a>
											<div>
												<span class="btn border-0 btn-outline-secondary btn-file btnAbrirFoto" title="Abrir imagen subida"><i class="fal fa-image-polaroid fa-lg" aria-hidden="true"></i></span>
											</div>
										</td>
										<td class="text-center"><?= (!empty($visita['comentario'])) ? $visita['comentario'] : '-'; ?></td>
										<td class="text-center" id="visitaFoto-<?= $kv ?>">
											<button type="button" class="btn btn-outline-danger border-0 btn-deleteRowModuloFoto" data-visitaModuloFoto="<?= $kv; ?>"><i class="fas fa-trash fa-lg"></i></button>
										</td>
									</tr>
								<? endforeach ?>
							<? endif ?>
						</tbody>
					</table>
					<div class="hide">
						<? $ix = $ix - 1; ?>
						<input class="form-control" type="text" id="contNumberFotos" id="contNumberFotos" value="<?= $ix; ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<script>
	ContingenciaRutas.dataListaTipoFoto = JSON.parse('<?= json_encode($listaTipoFoto) ?>');
</script>