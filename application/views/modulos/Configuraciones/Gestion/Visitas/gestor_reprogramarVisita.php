<form id="frm-gestorReprogramarRutaVisita">
	<div class="row themeWhite">
		<div class="col-md-12">
			<div class="mb-3 card">
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
								<div class="alert alert-warning fade show" role="alert">
									<i class="fas fa-exclamation-triangle"></i> Si la visita se encuentra <strong>iniciada o trabajada</strong>, no se puede <strong>transferir</strong>.<br>
								</div>
							</div>
							<div class="col-md-12">
								
								<h5 class="card-title">Visitas : <?=count($listaVisitas)?></h5>
								<div class="table-responsive">
									<table id="tb-gestorReprogramarRuta" class="mb-0 table table-bordered table-sm text-nowrap" width="100%">
										<thead>
											<tr>
												<th class="text-center align-middle" rowspan="2">#</th>
												<th class="text-center align-middle" colspan="3">NUEVA RUTA</th>
												<th class="text-center align-middle" colspan="3">ACTUAL RUTA</th>
												<th class="text-center align-middle" colspan="2">DATOS CLIENTE</th>
											</tr>
											<tr>
												<th class="text-center align-middle">FECHA NUEVO</th>
												<th class="text-center align-middle">USUARIO NUEVO</th>
												<th class="text-center align-middle">TIPO USUARIO</th>
												<th class="text-center align-middle">ESTADO</th>
												<th class="text-center align-middle">FECHA</th>
												<th class="text-center align-middle">USUARIO</th>
												<th class="text-center align-middle">RAZÓN SOCIAL</th>
												<th class="text-center align-middle">DIRECCIÓN</th>
											</tr>
										</thead>
										<tbody>
											<? $ix=1; ?>
											<? foreach ($listaVisitas as $klr => $row): ?>
												<tr class="tr-reprogramarVisita" data-ruta="<?=$row['idRuta']?>" data-visita="<?=$row['idVisita']?> " data-disponible = "<?= empty($row['horaIni']) ? 1 : 0 ?>">
													<td class="text-center"><?=$ix++;?><input type="hidden" name="flagProgramar" value="<?=(empty($row['horaIni'])?'1':'0')?>"></td>
													<td class="text-center">
														<? if ( empty($row['horaIni'])): ?>
															<input type="date" name="fecha" id="fecha-<?=$row['idRuta']?>-<?=$row['idCliente']?>" placeholder="Fecha" class="form-control" patron="requerido" value="<?=date("d/m/Y")?>">
														<? else: ?>
															<span><strong>-</strong></span>
														<? endif ?>
													</td>
													<td class="text-center">
														<? if (empty($row['horaIni'])): ?>
															<select class="form-control slWidth my-select2-usuarios" id="usuario-<?=$row['idRuta']?>-<?=$row['idCliente']?>" name="usuario" patron="requerido">
																<? foreach ($listaUsuarios as $klu => $usuario): ?>
																	<? $usuarioSelected = ($row['idUsuario']==$usuario['idUsuario']?'selected':''); ?>
																	<option value="<?=$usuario['idUsuario']?>" <?=$usuarioSelected?>><?=$usuario['nombreUsuario']?></option>
																<? endforeach ?>
															</select>
														<? else: ?>
															<span><strong>-</strong></span>
														<? endif ?>
													</td>
													<td class="text-center">
														<? if (empty($row['horaIni'])): ?>
														<select class="form-control slWidth my-select2-tipousuario" id="tipoUsuario-<?=$row['idRuta']?>-<?=$row['idCliente']?>" name="tipoUsuario" patron="requerido">
															<? foreach ($listaTiposUsuario[$row['idUsuario']] as $klut => $tipoUsuario): ?>
																<? $usuarioTipoSelected = ($row['idTipoUsuario']==$tipoUsuario['idTipoUsuario']?' selected':''); ?>
																<option value="<?=$tipoUsuario['idTipoUsuario']?>" <?=$usuarioTipoSelected?>><?=$tipoUsuario['tipoUsuario']?></option>
															<? endforeach ?>
														</select>
														<? else: ?>
															<span><strong>-</strong></span>
														<? endif ?>
													</td>
													<? $estadoVisita= ( !empty($row['horaIni']) ? '<div><span class="color-C"><i class="fa fa-circle"></i></span> TRABAJADO</div>' : '<div><span class="color-F"><i class="fa fa-circle"></i></span> NO TRABAJADO</div>' );	?>
													<td class="text-center"><?=$estadoVisita;?></td>
													<td class="text-center"><?=(!empty($row['fecha'])?$row['fecha']:'-')?></td>
													<td class=""><?=(!empty($row['nombreUsuario'])?$row['nombreUsuario']:'-')?></td>
													<td class="">

														<?=(!empty($row['razonSocial'])?$row['razonSocial']:'-')?>
														<div class="hide">
															<input type="text" class="form-control" name="cliente" id="cliente-<?=$row['idCliente']?>" value="<?=$row['idCliente']?>">
															<input type="text" class="form-control" name="clienteTexto" id="clienteTexto-<?=$row['idCliente']?>" value="<?=$row['razonSocial']?>">
														</div>
													</td>
													<td class=""><?=(!empty($row['direccion'])?$row['direccion']:'-')?></td>
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
</script>