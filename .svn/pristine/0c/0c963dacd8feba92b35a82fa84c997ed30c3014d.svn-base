<form id="frm-gestorEditarRuta">
	<div class="hide">
		<input type="text" id="ruta" name="ruta" value="<?=$idRuta?>">
	</div>
	<div class="row themeWhite">
		<div class="col-md-12">
			<div class="mb-3 mt-3 card">
				<div class="card-header">
					<h5 class="card-title">EDITAR RUTA</h5>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="form-row">
							<div class="col-md-6">
								<div class="position-relative form-group">
									<label><i class="fas fa-calendar-alt"></i> FECHA : <strong><?=$ruta['fecha']?></strong></label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="position-relative form-group">
									<label><i class="fas fa-user"></i> USUARIO : <strong><?=$ruta['nombreUsuario']?></strong></label>
								</div>
							</div>
						</div>
						<div class="divider"></div>
						<div class="form-row">
							<div class="col-md-12">
								<div class="position-relative form-group">
									<label for="cliente"><i class="fas fa-map-marker-alt"></i> LISTA DE CLIENTES: </label>
									<div class="input-group">
										<select class="form-control form-control-sm my_select2Update" id="cliente" name="cliente">
											<option value="">-- CLIENTES --</option>
											<? foreach ($listaClientes as $klc => $row): ?>
												<option value="<?=$row['idCliente']?>" data-direccion="<?=$row['direccion']?>"><?=$row['razonSocial']?></option>
											<? endforeach ?>
										</select>
										<div class="input-group-append">
											<button id="addCliente" class="btn btn-primary"><i class="fas fa-plus-square"></i> Añadir</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id="tb-clientesAñadidos" class="mb-0 table table-bordered table-sm text-nowrap" width="100%">
										<thead>
											<tr>
												<th class="text-center">#</th>
												<th class="text-center">RAZON SOCIAL</th>
												<th class="text-center">DIRECCIÓN</th>
												<th class="text-center">OPCIONES<br>(QUITAR)</th>
											</tr>
										</thead>
										<tbody>
											<? $ix=1; ?>
											<? if (!empty($ruta['listaClientes'])): ?>
												<? foreach ($ruta['listaClientes'] as $klc => $row): ?>
													<tr class="tr-listadoClientes">
														<td class="text-center"><?=$ix++;?></td>
														<td class=""><?=(!empty($row['razonSocial'])?$row['razonSocial']:'-')?></td>
														<td class=""><?=(!empty($row['direccion'])?$row['direccion']:'-')?></td>
														<td class="text-center">
															<div class="custom-checkbox custom-control">
																<input class="custom-control-input chkb-clienteActivo" type="checkbox" id="cliente-<?=$row['idCliente']?>" name="cliente" value="<?=$row['idCliente']?>" checked>
																<label class="custom-control-label custom-control-label-danger" for="cliente-<?=$row['idCliente']?>"></label>
															</div>
														</td>
													</tr>
												<? endforeach ?>
											<? else: ?>
												<tr class="noData">
													<td class="text-center" colspan="4">No se ha AÑADIDO a ningún cliente.</td>
												</tr>
											<? endif ?>
										</tbody>
									</table>
								</div>
								<div class="hide"><input type="text" id="contCliente" name="contCliente" value="<?=($ix-1)?>"></div>
							</div>
						</div>
						<div class="divider"></div>
						<div class="row">
							<div class="col-md-12">
								<div class="alert alert-warning" role="alert">
									<i class="fas fa-check-circle"></i> Para quitar un <strong>cliente</strong> del listado de clientes, debe de <strong>desmarcar</strong> el casillero azul.<br>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<script>
	$('.my_select2Update').select2({
        dropdownParent: $("div.modal-content"),
        width: '90%'
    });
</script>