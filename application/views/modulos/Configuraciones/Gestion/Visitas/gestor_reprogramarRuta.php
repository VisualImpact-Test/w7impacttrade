<form id="frm-gestorReprogramarRutaVisita">
	<div class="row themeWhite">
		<div class="col-md-12">
			<div class="mb-3 mt-3 card">
				<div class="card-header">
					<h5 class="card-title">LISTADO DE RUTAS</h5>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="form-row">
							<div class="col-md-12">
								<div class="position-relative form-group">
									<div>
										<div class="custom-radio custom-control">
											<input type="radio" id="fechaIndividual" name="asignarFecha" class="custom-control-input" value="1" checked>
											<label class="custom-control-label" for="fechaIndividual">Asignar <strong>fecha individual</strong></label>
										</div>
										<div class="custom-radio custom-control">
											<input type="radio" id="fechaGrupal" name="asignarFecha" class="custom-control-input" value="2">
											<label class="custom-control-label" for="fechaGrupal">Asignar <strong>fecha grupal</strong></label>
										</div>
									</div>
									<div class="dvFechaGrupal">
										<div class="divider"></div>
										<div class="input-group input-group-lg">
											<div class="input-group-prepend"><span class="input-group-text">FECHA (TODOS): </span></div>
											<input type="date" name="fechaNuevaGrupal" id="fechaNuevaGrupal" placeholder="Fecha" class="form-control" value="<?=date("d/m/Y")?>">
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="divider"></div>
								<h5 class="card-title">Rutas : <?=count($listaRutas)?></h5>
								<div class="table-responsive">
									<table id="tb-gestorReprogramarRuta" class="mb-0 table table-bordered table-sm text-nowrap" width="100%">
										<thead>
											<tr>
												<th class="text-center align-middle" rowspan="2">#</th>
												<th class="text-center align-middle" colspan="3">NUEVA RUTA</th>
												<th class="text-center align-middle" colspan="2">ACTUAL RUTA</th>
											</tr>
											<tr>
												<th class="text-center align-middle">FECHA NUEVO</th>
												<th class="text-center align-middle">USUARIO NUEVO</th>
												<th class="text-center align-middle">TIPO USUARIO</th>
												<th class="text-center align-middle">FECHA</th>
												<th class="text-center align-middle">USUARIO</th>
											</tr>
										</thead>
										<tbody>
											<? $ix=1; ?>
											<? foreach ($listaRutas as $klr => $row): ?>
												<tr class="tr-reprogramarRuta" data-ruta="<?=$row['idRuta']?>" data-usuario = "<?=$row['idUsuario']?>">
													<td class="text-center"><?=$ix++;?></td>
													<td class="text-center">
														<input type="date" name="fecha" id="fecha-<?=$row['idRuta']?>" placeholder="Fecha" class="form-control" patron="requerido" value="<?=date("d/m/Y")?>">
													</td>
													<td class="text-center">
														<select class="form-control slWidth my-select2-usuarios" id="usuario-<?=$row['idRuta']?>" name="usuario" patron="requerido">
															<? foreach ($listaUsuarios as $klu => $usuario): ?>
																<? $usuarioSelected = ($row['idUsuario']==$usuario['idUsuario']?'selected':''); ?>
																<option value="<?=$usuario['idUsuario']?>" <?=$usuarioSelected?>><?=$usuario['nombreUsuario']?></option>
															<? endforeach ?>
														</select>
														
													</td>
													<td class="text-center">
														<select class="form-control slWidth my-select2-tipousuario" id="tipoUsuario-<?=$row['idRuta']?>" name="tipoUsuario" patron="requerido">
															<? foreach ($listaTiposUsuario[$row['idUsuario']] as $klut => $tipoUsuario): ?>
																<? $usuarioTipoSelected = ($row['idTipoUsuario']==$tipoUsuario['idTipoUsuario']?' selected':''); ?>
																<option value="<?=$tipoUsuario['idTipoUsuario']?>" <?=$usuarioTipoSelected?>><?=$tipoUsuario['tipoUsuario']?></option>
															<? endforeach ?>
														</select>
													</td>
													<td class="text-center"><?=(!empty($row['fecha'])?$row['fecha']:'-')?></td>
													<td class=""><?=(!empty($row['nombreUsuario'])?$row['nombreUsuario']:'-')?></td>
												</tr>
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
<script>
	$('.my-select2-usuarios').select2({
		dropdownParent: $("#frm-gestorReprogramarRutaVisita"),
		width: '100%'
	});
	$('.my-select2-tipousuario').select2({
		dropdownParent: $("#frm-gestorReprogramarRutaVisita"),
		width: '100%'
	});
	$(document).ready(function(){
		Visitas.usuariosTipo = <?=json_encode($listaTiposUsuario)?>
	});
</script>