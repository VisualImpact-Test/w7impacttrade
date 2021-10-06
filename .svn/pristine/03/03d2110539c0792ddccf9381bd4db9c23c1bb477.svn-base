<form id="frm-modulacionCliente">
	<div class="row themeWhite">
		<div class="col-md-12">
			<div class="mb-3 card">
				<div class="card-header">
					MODULACIÓN CLIENTE
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="hide">
							<input type="text" name="permiso" id="permiso" class="form-control" value="<?=$idPermiso?>">
							<input type="text" name="cliente" id="cliente" class="form-control" value="<?=$idCliente?>">
						</div>
						<div class="position-relative row form-group">
							<label for="clienteNombre" class="col-sm-3 col-form-label">Cliente:</label>
							<div class="col-sm-9">
								<input name="clienteNombre" id="clienteNombre" value="<?=$clienteNombre;?>" type="text" class="form-control text-center" readOnly="readOnly">
							</div>
						</div>
						<div class="divider"></div>
						<div class="div-elementos">
							<h5 class="card-title">ELEMENTOS DE VISIBILIDAD:</h5>
							<div class="position-relative form-group">
								<div class="table-responsive">
									<table id="idClienteElementos" class="mb-0 table table-bordered table-sm text-nowrap">
										<thead>
											<tr>
												<th class="text-center">CATEGORÍA</th>
												<th class="text-center">ELEMENTOS</th>
												<th class="text-center">CANTIDAD</th>
											</tr>
										</thead>
										<tbody>
											<? $ix=1; ?>
											<? foreach ($listaCategoria as $klc => $categoria): ?>
												<tr>
													<td class="text-center" rowspan="<?=count($categoria['listaElementos'])+1;?>"><?=$categoria['categoria'] ?></td>
												</tr>
												<?foreach ($categoria['listaElementos'] as $kle => $elemento): ?>
													<tr>
														<td class="text-center">
															<input type="hidden" name="elemento" class="form-control" value="<?=$elemento['idElementoVis']?>">
															<?=$elemento['elemento']?></td>
														<td class="text-center">
															<? $cantidadElemt = isset($listaModuElementos[$elemento['idElementoVis']]['elemento']) ? $listaModuElementos[$elemento['idElementoVis']]['cantidad']:'';?>
															<? $cssInputData = isset($listaModuElementos[$elemento['idElementoVis']]['cantidad']) ? ( $listaModuElementos[$elemento['idElementoVis']]['cantidad']>0 ? 'ip-data':'') :'';?>
															<input class="form-control text-center <?=$cssInputData;?> ipCantidadElemento" data-elemento="<?=$elemento['idElementoVis']?>" type="numeric" placeholder="0" id="cantidad-<?=$elemento['idElementoVis']?>"  name="cantidadElemento" value="<?=$cantidadElemt?>">
														</td>
													</tr>
												<?endforeach ?>
											<? endforeach ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>