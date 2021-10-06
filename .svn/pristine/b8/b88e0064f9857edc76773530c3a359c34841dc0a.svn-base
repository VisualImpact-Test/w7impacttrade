<form id="frm-gestorNuevaRuta">
	<div class="row themeWhite">
		<div class="col-md-12">
			<div class="card-header-tab card-header">
				<ul class="nav">
					<li class="nav-item active"><a data-toggle="tab" href="#tab-datosRuta" class="nav-link active">REGISTRAR RUTA</a></li>
					<li class="nav-item"><a data-toggle="tab" href="#tab-datosVisita" class="nav-link">REGISTRAR VISITAS</a></li>
				</ul>
			</div>
			<div class="card-body">
				<div class="tab-content">
					<div class="tab-pane fade show active" id="tab-datosRuta" role="tabpanel">
						<div class="form-row">
							<div class="col-md-4">
								<div class="position-relative form-group">
									<label for="fecha">FECHA :</label>
									<input type="date" name="fecha" id="fecha" placeholder="Fecha" class="form-control" patron="requerido" value="<?=date("Y-m-d")//date("d/m/Y")?>">
								</div>
							</div>
							<div class="col-md-4">
								<div class="position-relative form-group">
									<label for="cuenta">CUENTA :</label>
									<select class="form-control slWidth my-select2" id="cuenta" name="cuenta" patron="requerido">
										<option value="">-- Cuenta --</option>
										<? foreach ($listaCuentaProyecto as $klcp => $row): ?>
											<? $cuentaSelected = '';//($klcp==$idCuenta?'selected':''); ?>
											<option value="<?=$row['idCuenta']?>" <?=$cuentaSelected?>><?=$row['cuenta']?></option>
										<? endforeach ?>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="position-relative form-group">
									<label for="proyecto">PROYECTO :</label>
									<select class="form-control slWidth my-select2" id="proyecto" name="proyecto" patron="requerido">
										<option value="">-- Proyecto --</option>
									</select>
								</div>
							</div>
						</div>
						<div class="divider"></div>
						<div class="form-row">
							<div class="col-md-4">
								<div class="position-relative form-group">
									<label for="tipoUsuario">TIPO USUARIO :</label>
									<select class="form-control slWidth my-select2" id="tipoUsuario" name="tipoUsuario">
										<option value="">-- Tipo Usuario --</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="position-relative form-group">
									<label for="usuario">USUARIO :</label>
									<select class="form-control slWidth my-select2 usuarioModal" id="usuario" name="usuario" patron="requerido">
										<option value="">-- Usuario --</option>
									</select>
								</div>
							</div>
						</div>
						<div class="divider"></div>
						<div class="row">
							<div class="col-md-12">
								<div class="alert alert-warning" role="alert">
									<i class="fas fa-check-circle"></i> Para seleccionar un <strong>tipo de usuario</strong> debe de seleccionar el <strong>proyecto</strong>.<br>
									<i class="fas fa-check-circle"></i> Solo se mostrarán los <strong>tipos de usuarios</strong> de los usuarios registrados deacuerdo al <strong>proyecto y cuenta</strong>.<br>
									<i class="fas fa-check-circle"></i> Solo se mostrarán los <strong>usuarios</strong> que tenga dentro de su histórico el acceso al <strong>aplicativo</strong> que le corresponde.<br>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="tab-datosVisita" role="tabpanel">
						<div class="form-row">
							<div class="col-md-4">
								<div class="position-relative form-group">
									<label for="grupoCanal">GRUPO CANAL :</label>
									<select class="form-control slWidth my-select2" id="grupoCanal" name="grupoCanal">
										<option value="">-- Grupo Canal --</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="position-relative form-group">
									<label for="canal">CANAL :</label>
									<select class="form-control slWidth my-select2" id="canal" name="canal" patron="requerido">
										<option value="">-- Canal --</option>
									</select>
								</div>
							</div>
						</div>
						<div class="divider"></div>
						<div class="form-row">
							<div class="col-md-12">
								<div class="position-relative form-group">
									<label for="cliente">LISTA DE CLIENTES: </label>
									<div class="input-group">
										<select class="form-control my-select2-clientes" id="cliente" name="cliente">
											<option value="">-- CLIENTES --</option>
											<? /*foreach ($listacliente as $klds => $row): ?>
												<option value="<?=$row['idcliente']?>"><?=$row['cliente']?></option>
											<? endforeach */?>
										</select>
										<div class="input-group-append">
											<button id="addCliente" class="btn btn-primary"><i class="fas fa-plus-square"></i> Añadir</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="divider"></div>
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id="tb-clientesAñadidos" class="mb-0 table table-bordered table-sm text-nowrap" width="100%">
										<thead>
											<tr>
												<th class="text-center">#</th>
												<th class="text-center">RAZON SOCIAL</th>
												<th class="text-center">DIRECCIÓN</th>
												<th class="text-center">OPCIONES</th>
											</tr>
										</thead>
										<tbody>
											<tr class="noData">
												<td class="text-center" colspan="4">No se ha AÑADIDO a ningún cliente.</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="hide"><input type="text" id="contCliente" name="contCliente" value="0"></div>
							</div>
						</div>
						<div class="divider"></div>
						<div class="row">
							<div class="col-md-12">
								<div class="alert alert-warning" role="alert">
									<i class="fas fa-check-circle"></i> Debe de seleccionar <strong>la fecha, la cuenta, el proyecto y el canal</strong> para poder cargar la lista de clientes.<br>
									<i class="fas fa-check-circle"></i> Solo se mostrarán los <strong>clientes</strong> que estén dentro de los parámetros mencionados en la linea anterior.<br>
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
	Visitas.dataListaCuentaProyecto = JSON.parse('<?=json_encode($listaCuentaProyecto)?>');
	Visitas.dataListaCuentaGrupoCanalCanal = JSON.parse('<?=json_encode($listaCuentaGrupoCanal)?>');
	Visitas.dataListaCuentaProyectoTipoUsuarioUsuario = JSON.parse('<?=json_encode($listaCuentaProyectoTipoUsuarioUsuario)?>');
	$('.my-select2').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });

    $('.my-select2-clientes').select2({
        dropdownParent: $("div.modal-content"),
        width: '90%'
	});
	console.log(Visitas.dataListaCuentaProyectoTipoUsuarioUsuario);
</script>