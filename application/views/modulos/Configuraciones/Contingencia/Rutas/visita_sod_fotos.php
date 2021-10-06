<form id="frm-visitaSodFotos">
	<div class="">
		<div class="alert alert-warning" role="alert">
			<i class="fas fa-check-circle"></i> En esta sección se podra visualizar las fotos que pertenecen a la categoría, marca y tipo de elemento de visibilidad seleccionado.<br>
			<i class="fas fa-check-circle"></i> Para cargar una nueva foto a esta sección, se debe de seleccionar el botón con el sigo "+".<br>
			<i class="fas fa-check-circle"></i> Para que se pueda almacenar la foto se debe de seleccionar el botón de Guardar, sino se realiza dicho procedimiento, la foto se perderá y no se podrá almacenar.<br>
			<div class="divider"></div>
			<i class="fas fa-question-circle"></i> Si existe alguna mejora en el diseñor, por favor de informa.<br>
		</div>
	</div>
	<div class="row themeWhite">
		<div class="col-md-12">
			<div class="mb-3 mt-3 card">
				<div class="card-header">
					LISTA DE FOTOS SOD
					<div class="ml-auto">
						<button type="button" id="btn-addRowSodFoto" class="btn btn-primary" data-visita="<?=$datos['idVisita']?>" data-categoria="<?=$datos['idCategoria']?>" data-marca="<?=$datos['idMarca']?>" data-tipoElemento="<?=$datos['idTipoElementoVisibilidad']?>"><i class="fas fa-plus-circle fa-lg"></i></button>
					</div>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="table-responsive">
							<table id="tb-sod-fotos" class="mb-0 table table-bordered table-sm text-nowrap">
								<thead>
									<tr>
										<th class="text-center align-middle">#</th>
										<th class="text-center align-middle">FOTO</th>
										<th class="text-center align-middle">OPCIONES</th>
									</tr>
								</thead>
								<tbody class="tb-sod-foto">
									<? $ix=1; ?>
									<? foreach ($listaSodFotos as $ksf => $fotos): ?>
										<tr>
											<td class="text-center"><?=$ix++?></td>
											<td class="text-center">
												<a href="javascript:;" class="lk-foto-1" data-content="foto-<?=$ix?>">
													<img id="foto-<?=$ix?>" class="imgNormal" src="<?=$this->fotos_url.'sod/'.$fotos['foto']?>" alt="">
												</a>
											</td>
											<td class="text-center tdBloqueado"></td>
										</tr>
									<? endforeach ?>
								</tbody>
							</table>
							<div class="hide">
								<input class="form-control" type="text" id="contNumberSodFotos" id="contNumberSodFotos" value="<?=$ix;?>">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</form>