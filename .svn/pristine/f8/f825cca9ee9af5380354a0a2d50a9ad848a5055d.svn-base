<form id="frm-basemadreNuevoEditarPunto">
	<div class="hide">
		<input type="text" class="form-control" id="tabla" name="tabla" value="<?=$tabla?>">
		<input type="text" class="form-control" id="deTodosModos" name="deTodosModos" value="0">
		<?
			$cliente = (isset($clienteHistorico['idCliente']) && !empty($clienteHistorico['idCliente'])) ? $clienteHistorico['idCliente'] : NULL;
			$clienteHist = (isset($clienteHistorico['idClienteHist']) && !empty($clienteHistorico['idClienteHist'])) ? $clienteHistorico['idClienteHist'] : NULL;
		?>
		<input type="text" class="form-control" id="cliente" name="cliente" value="<?=$cliente?>">
		<input type="text" class="form-control" id="clienteHistorico" name="clienteHistorico" value="<?=$clienteHist?>">
	</div>
	<div class="row themeWhite">
		<div class="col-md-12">
			<div class="mb-3 mt-3 card">
				<!--div class="card-header card-header-tab-animation">
					<ul class="nav nav-justified">
						<li class="nav-item"><a data-toggle="tab" href="#tab-datosGenerales" class="nav-link active">DATOS GENERALES</a></li>
						<li class="nav-item"><a data-toggle="tab" href="#tab-clienteHistorico" class="nav-link">REGISTRO HISTÓRICO</a></li>
					</ul>
				</div-->
				<div class="card-header-tab card-header">
				<ul class="nav">
						<li class="nav-item active"><a data-toggle="tab" href="#tab-datosGenerales" class="nav-link active">DATOS GENERALES</a></li>
						<li class="nav-item"><a data-toggle="tab" href="#tab-clienteHistorico" class="nav-link">REGISTRO HISTÓRICO</a></li>
					</ul>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane fade show active" id="tab-datosGenerales" role="tabpanel">
							<h5 class="card-title">REGISTRAR DATOS GENERALES</h5>
							<div class="form-row">
								<div class="col-md-6">
									<div class="position-relative form-group">
										<? $nombreComercial = (isset($clienteHistorico['nombreComercial']) && !empty($clienteHistorico['nombreComercial'])) ? $clienteHistorico['nombreComercial']:NULL; ?>
										<? $readOnlyNC = (isset($clienteHistorico['nombreComercial']) && !empty($clienteHistorico['nombreComercial'])) ? 'readonly':''; ?>
										<label for="nombreComercial">NOMBRE COMERCIAL</label>
										<input type="text" name="nombreComercial" placeholder="Ingrese nombre comercial" id="nombreComercial" class="form-control" value="<?=$nombreComercial?>" patron="requerido" <?=$readOnlyNC?>>
									</div>
									<div class="position-relative form-group">
										<? $razonSocial = (isset($clienteHistorico['razonSocial']) && !empty($clienteHistorico['razonSocial'])) ? $clienteHistorico['razonSocial']:NULL; ?>
										<? $readOnlyRS = (isset($clienteHistorico['razonSocial']) && !empty($clienteHistorico['razonSocial'])) ? 'readonly':''; ?>
										<label for="razonSocial">RAZÓN SOCIAL</label>
										<input type="text" name="razonSocial" placeholder="Ingrese razón social" id="razonSocial" class="form-control" value="<?=$razonSocial?>" patron="requerido" <?=$readOnlyRS?>>
									</div>
									<div class="position-relative form-group">
										<? $ruc = (isset($clienteHistorico['ruc']) && !empty($clienteHistorico['ruc'])) ? trim($clienteHistorico['ruc']):NULL; ?>
										<? $readOnlyRuc = (isset($ruc) && !empty($ruc)) ? 'readonly':''; ?>
										<label for="numeroRuc">RUC</label>
										<input type="text" name="numeroRuc" placeholder="Ingrese ruc" id="numeroRuc" class="form-control" value="<?=$ruc?>" patron="ruc" <?=$readOnlyRuc?>>
									</div>
									<div class="position-relative form-group">
										<? $dni = (isset($clienteHistorico['dni']) && !empty($clienteHistorico['dni'])) ? trim($clienteHistorico['dni']):NULL; ?>
										<? $readOnlyDni = (isset($dni) && !empty($dni)) ? 'readonly':''; ?>
										<label for="numeroDni">DNI</label>
										<input type="text" name="numeroDni" placeholder="Ingrese dni" id="numeroDni" class="form-control" value="<?=$dni?>" patron="dni" <?=$readOnlyDni?>>
									</div>
									<div class="divider"></div>
									<div class="position-relative form-group">
										<? $cod_departamento = (isset($clienteHistorico['cod_departamento']) && !empty($clienteHistorico['cod_departamento'])) ? $clienteHistorico['cod_departamento']:NULL; ?>
										<label for="departamento">DEPARTAMENTO</label>
										<select class="form-control slWidth" id="departamento" name="departamento" patron="requerido">
											<option value="">-- Departamento --</option>
											<? foreach ($listaRegiones as $klr => $row): ?>
												<? $departamentoSelected = ( $klr==$cod_departamento ? 'selected':''); ?>
												<option value="<?=$row['cod_departamento']?>" <?=$departamentoSelected?>><?=$row['departamento']?></option>
											<? endforeach ?>
										</select>
									</div>
									<div class="position-relative form-group">
										<? $cod_provincia = (isset($clienteHistorico['cod_provincia']) && !empty($clienteHistorico['cod_provincia'])) ? $clienteHistorico['cod_provincia']:NULL; ?>
										<label for="provincia">PROVINCIA</label>
										<select class="form-control slWidth" id="provincia" name="provincia" patron="requerido">
											<option value="">-- Provincia--</option>
											<? if ( !empty($cod_departamento) && !empty($cod_provincia)): ?>
												<? foreach ($listaRegiones[$cod_departamento]['listaProvincias'] as $klp => $row): ?>
													<? $provinciaSelected = ( $klp==$cod_provincia ? 'selected':''); ?>
													<option value="<?=$row['cod_provincia']?>" <?=$provinciaSelected?>><?=$row['provincia']?></option>
												<? endforeach ?>
											<? endif ?>
										</select>
									</div>
									<div class="position-relative form-group">
										<? $cod_distrito = (isset($clienteHistorico['cod_distrito']) && !empty($clienteHistorico['cod_distrito'])) ? $clienteHistorico['cod_distrito']:NULL; ?>
										<label for="distrito">DISTRITO</label>
										<select class="form-control slWidth" id="distrito" name="distrito" patron="requerido">
											<option value="">-- Distrito --</option>
											<? if ( !empty($cod_provincia) && !empty($cod_distrito)): ?>
												<? foreach ($listaRegiones[$cod_departamento]['listaProvincias'][$cod_provincia]['listaDistritos'] as $kld => $row): ?>
													<? $distritoSelected = ( $kld==$cod_distrito ? 'selected':''); ?>
													<option value="<?=$row['cod_distrito']?>" <?=$distritoSelected?>><?=$row['distrito']?></option>
												<? endforeach ?>
											<? endif ?>
										</select>
									</div>
									<div class="hide">
										<? $cod_ubigeo = (isset($clienteHistorico['cod_ubigeo']) && !empty($clienteHistorico['cod_ubigeo'])) ? $clienteHistorico['cod_ubigeo']:NULL; ?>
										<label for="cod_ubigeo">CÓDIGO UBIGEO</label>
										<input type="text" name="cod_ubigeo" id="cod_ubigeo" placeholder="Código Ubigeo" class="form-control" value="<?=$cod_ubigeo?>">
									</div>
									<div class="divider"></div>
									<div class="position-relative form-group">
										<? $direccionCliente = (isset($clienteHistorico['direccion']) && !empty($clienteHistorico['direccion'])) ? $clienteHistorico['direccion']:NULL; ?>
										<label for="direccion">DIRECCIÓN</label>
										<div class="input-group">
											<input type="text" name="direccion" id="direccion" placeholder="Dirección" class="form-control" value="<?=$direccionCliente?>">
											<div class="input-group-append">
												<button class="btn btn-success" id="buscarDireccionMapa"><i class="fas fa-globe-americas"></i> Buscar</button>
											</div>
										</div>
										
									</div>
									<div class="position-relative form-group">
										<? $referenciaCliente = (isset($clienteHistorico['referencia']) && !empty($clienteHistorico['referencia'])) ? $clienteHistorico['referencia']:NULL; ?>
										<label for="referencia">REFERENCIA</label>
										<input type="text" name="referencia" id="referencia" placeholder="Referencia" class="form-control" value="<?=$referenciaCliente?>">
									</div>
									<div class="position-relative form-group">
										<? $idZonaPeligrosa = (isset($clienteHistorico['idZonaPeligrosa']) && !empty($clienteHistorico['idZonaPeligrosa'])) ? $clienteHistorico['idZonaPeligrosa']:NULL; ?>
										<label for="zonaPeligrosa">ZONA PELIGROSA</label>
										<select class="form-control slWidth" id="zonaPeligrosa" name="zonaPeligrosa">
											<option value="">-- Zona Peligrosa --</option>
											<? foreach ($listaZonaPeligrosa as $klzp => $row): ?>
												<? $zonaPeligrosaSelected = ( $klzp==$idZonaPeligrosa ? 'selected':'' ); ?>
												<option value="<?=$row['idZonaPeligrosa']?>" <?=$zonaPeligrosaSelected?>><?=$row['descripcion']?></option>
											<? endforeach ?>
										</select>
									</div>
								</div>

								<div class="col-md-6">
									<div>
										<label>UBICACIÓN GEOGRÁFICA</label>
										<div class="dv-maps" id="map_canvas_inicio"></div>
									</div>
									<div class="divider"></div>
									<div class="position-relative form-group">
										<? $latitudCliente = (isset($clienteHistorico['latitud']) && !empty($clienteHistorico['latitud'])) ? $clienteHistorico['latitud']:NULL; ?>
										<label for="latitud">LATITUD</label>
										<input type="text" name="latitud" id="latitud" placeholder="Latitud" class="form-control" value="<?=$latitudCliente?>">
									</div>
									<div class="position-relative form-group">
										<? $longitudCliente = (isset($clienteHistorico['longitud']) && !empty($clienteHistorico['longitud'])) ? $clienteHistorico['longitud']:NULL; ?>
										<label for="longitud">LONGITUD</label>
										<input type="text" name="longitud" id="longitud" placeholder="Longitud" class="form-control" value="<?=$longitudCliente?>">
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade " id="tab-clienteHistorico" role="tabpanel">
							<h5 class="card-title">REGISTRAR DATOS HISTÓRICOS</h5>
							<div class="form-row">
								<div class="col-md-6">
									<div class="position-relative form-group">
										<? $codCliente = (isset($clienteHistorico['codCliente']) && !empty($clienteHistorico['codCliente'])) ? $clienteHistorico['codCliente']:NULL; ?>
										<label for="codCliente">CÓDIGO CLIENTE</label>
										<input type="text" name="codCliente" id="codCliente" placeholder="Código Cliente" class="form-control" value="<?=$codCliente?>">
									</div>
								</div>
								<div class="col-md-6">
									<? $flagCarteraChecked = (isset($clienteHistorico['flagCartera']) && !empty($clienteHistorico['flagCartera'])) ? ( $clienteHistorico['flagCartera']==1?'checked':''):''; ?>
									<label for="codCliente">PRESENCIA</label>
									<div class="input-group">
                                        <div class="input-group-prepend">
                                        	<span class="input-group-text"><input id="flagCartera" name="flagCartera" aria-label="Checkbox for following text input" type="checkbox" value="1" <?=$flagCarteraChecked?>></span>
                                        </div>
                                        <label class="form-control">¿CLIENTE CARTERA?</label>
                                    </div>
								</div>
							</div>
							<div class="divider"></div>
							<div class="form-row">
								<div class="col-md-6">
									<div class="position-relative form-group">
										<? $fecIni = (isset($clienteHistorico['fecIni']) && !empty($clienteHistorico['fecIni'])) ? $clienteHistorico['fecIni']:NULL; ?>
										<? $readOnlyFecIni = (isset($clienteHistorico['fecIni']) && !empty($clienteHistorico['fecIni'])) ? 'readonly':''; ?>
										<label for="fechaInicio">FECHA INICIO</label>
										<input type="date" name="fechaInicio" id="fechaInicio" placeholder="Fecha Inicio" class="form-control" patron="requerido" value="<?=$fecIni?>" <?=$readOnlyFecIni?>>
									</div>
								</div>
								<div class="col-md-6">
									<div class="position-relative form-group">
										<? $fecFin = (isset($clienteHistorico['fecFin']) && !empty($clienteHistorico['fecFin'])) ? $clienteHistorico['fecFin']:NULL; ?>
										<label for="fechaFin">FECHA FIN</label>
										<input type="date" name="fechaFin" id="fechaFin" placeholder="Fecha Fin" class="form-control" value="<?=$fecFin?>">
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-6">
									<div class="position-relative form-group">
										<? $idCuenta = (isset($clienteHistorico['idCuenta']) && !empty($clienteHistorico['idCuenta'])) ? $clienteHistorico['idCuenta']:NULL; ?>
										<? $cuenta = ( !empty($clienteHistorico['cuenta'])) ? $clienteHistorico['cuenta']:NULL; ?>
										<label for="cuenta">CUENTA</label>
										<input type="text" class="form-control" value="<?=$cuenta?>" readonly disabled>
										<input type="hidden" id="cuenta" name="cuenta" value="<?=$idCuenta?>">


										<!-- <? $readOnlyDisabledCuenta = (isset($clienteHistorico['idCuenta']) && !empty($clienteHistorico['idCuenta'])) ? 'readonly disabled':''; ?>
										
										<select class="form-control slWidth" id="cuenta" name="cuenta" patron="requerido" <?=$readOnlyDisabledCuenta?>>
											<option value="">-- Cuenta --</option>
											<? foreach ($listaCuentaProyecto as $klcp => $row): ?>
												<? $cuentaSelected = ($klcp==$idCuenta?'selected':''); ?>
												<option value="<?=$row['idCuenta']?>" <?=$cuentaSelected?>><?=$row['cuenta']?></option>
											<? endforeach ?>
										</select> -->
									</div>
								</div>
								<div class="col-md-6">
									<div class="position-relative form-group">
										<? $idProyecto = (isset($clienteHistorico['idProyecto']) && !empty($clienteHistorico['idProyecto'])) ? $clienteHistorico['idProyecto']:NULL; ?>
										<? $proyecto = ( !empty($clienteHistorico['proyecto'])) ? $clienteHistorico['proyecto']:NULL; ?>
										<? $readOnlyDisabledProyecto = (isset($clienteHistorico['idProyecto']) && !empty($clienteHistorico['idProyecto'])) ? 'readonly disabled':''; ?>
										<label for="proyecto">PROYECTO</label>
										<input type="text" class="form-control" patron="requerido" value="<?=$proyecto?>" readonly disabled>
										<input type="hidden" id="proyecto" name="proyecto" value="<?=$idProyecto?>">

										<!-- <select class="form-control slWidth" id="proyecto" name="proyecto" patron="requerido" <?=$readOnlyDisabledProyecto?> >
											<option value="">-- Proyecto --</option>
											<? if (!empty($idCuenta) && !empty($idProyecto)): ?>
												<? foreach ($listaCuentaProyecto[$idCuenta]['listaProyectos'] as $klcpp => $row): ?>
													<? $proyectoSelected = ($klcpp==$idProyecto?'selected':''); ?>
													<option value="<?=$row['idProyecto']?>" <?=$proyectoSelected?>><?=$row['proyecto']?></option>
												<? endforeach ?>
											<? endif ?>
										</select> -->
									</div>
								</div>
							</div>
							<div class="divider"></div>
							<div class="form-row">
								<div class="col-md-6">
									<div class="position-relative form-group">
										<? $idFrecuencia = (isset($clienteHistorico['idFrecuencia']) && !empty($clienteHistorico['idFrecuencia'])) ? $clienteHistorico['idFrecuencia']:NULL; ?>
										<label for="frecuencia">FRECUENCIA</label>
										<select class="form-control slWidth" id="frecuencia" name="frecuencia">
											<option value="">-- Frecuencia --</option>
											<? foreach ($listaFrecuencia as $klf => $row): ?>
												<? $frecuenciaSelected = ($klf==$idFrecuencia ? 'selected':''); ?>
												<option value="<?=$row['idFrecuencia']?>" <?=$frecuenciaSelected?> ><?=$row['frecuencia']?></option>
											<? endforeach ?>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="position-relative form-group">
										<? $idZona = (isset($clienteHistorico['idZona']) && !empty($clienteHistorico['idZona'])) ? $clienteHistorico['idZona']:NULL; ?>
										<label for="zona">ZONA</label>
										<select class="form-control slWidth" id="zona" name="zona">
											<option value="">-- Zona --</option>
											<? if (!empty($idCuenta) && !empty($idProyecto) ): ?>
												<? foreach ($listaCuentaProyectoZona[$idCuenta][$idProyecto]['listaZonas'] as $klcpz => $row): ?>
													<? $zonaSelected = ($klcpz==$idZona?'selected':''); ?>
													<option value="<?=$row['idZona']?>" <?=$zonaSelected?>><?=$row['zona']?></option>
												<? endforeach ?>
											<? endif ?>
										</select>
									</div>
								</div>
							</div>
							<div class="divider"></div>
							<div class="form-row">
								<h5 class="col-md-12 card-title">SEGMENTACIÓN NEGOCIO</h5>
								<div class="col-md-4">
									<div class="position-relative form-group">
										<? $idGrupoCanal = (isset($clienteHistorico['idGrupoCanal']) && !empty($clienteHistorico['idGrupoCanal'])) ? $clienteHistorico['idGrupoCanal']:NULL; ?>
										<label for="grupoCanal">GRUPO CANAL</label>
										<select class="form-control slWidth" id="grupoCanal" name="grupoCanal">
											<option value="">-- Grupo Canal --</option>
											<? if (!empty($listaCuentaGrupoCanalSubCanalClienteTipo) && !empty($idCuenta) ): ?>
												<? foreach ($listaCuentaGrupoCanalSubCanalClienteTipo[$idCuenta]['listaGrupoCanal'] as $klgc => $row): ?>
													<? $grupoCanalSelected = ($klgc==$idGrupoCanal?'selected':''); ?>
													<option value="<?=$row['idGrupoCanal']?>" <?=$grupoCanalSelected?>><?=$row['grupoCanal']?></option>
												<? endforeach ?>
											<? endif ?>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="position-relative form-group">
										<? $idCanal = (isset($clienteHistorico['idCanal']) && !empty($clienteHistorico['idCanal'])) ? $clienteHistorico['idCanal']:NULL; ?>
										<label for="canal">CANAL</label>
										<select class="form-control slWidth" id="canal" name="canal" patron="requerido">
											<option value="">-- Canal --</option>
											<? if (!empty($idCuenta) && !empty($idGrupoCanal)): ?>
												<? foreach ($listaCuentaGrupoCanalSubCanalClienteTipo[$idCuenta]['listaGrupoCanal'][$idGrupoCanal]['listaCanal'] as $klgcc => $row): ?>
													<? $canalSelected = ($klgcc==$idCanal ? 'selected':''); ?>
													<option value="<?=$row['idCanal']?>" <?=$canalSelected?>><?=$row['canal']?></option>
												<? endforeach ?>
											<? endif ?>
										</select>
									</div>
								</div>
								<!--div class="col-md-4">
									<div class="position-relative form-group">
										<? /*$idSubCanal = (isset($clienteHistorico['idSubCanal']) && !empty($clienteHistorico['idSubCanal'])) ? $clienteHistorico['idSubCanal']:NULL; ?>
										<label for="subCanal">SUB CANAL</label>
										<select class="form-control slWidth" id="subCanal" name="subCanal">
											<option value="">-- SubCanal --</option>
											<? if (!empty($idCanal)): ?>
												<? foreach ($listaCanalSubCanal[$idCanal]['listaSubCanal'] as $klcsb => $row): ?>
													<? $subCanalSelected = ($klcsb==$idSubCanal ? 'selected':''); ?>
													<option value="<?=$row['idSubCanal']?>" <?=$subCanalSelected?>><?=$row['subCanal']?></option>
												<? endforeach ?>
											<? endif*/ ?>
										</select>
									</div>
								</div-->
								<div class="col-md-4">
									<div class="position-relative form-group">
										<label for="clienteTipo">CLIENTE TIPO</label>
										<select class="form-control slWidth" id="clienteTipo" name="clienteTipo">
											<option value="">-- Cliente Tipo --</option>
										</select>
									</div>
								</div>
							</div>
							<div class="divider"></div>
							<div class="segmentacionCliente">
								<h5 class="card-title">SEGMENTACIÓN CLIENTE</h5>
								<div class="alert alert-info fade show" role="alert">
									<i class="fas fa-exclamation-triangle"></i> Debe de seleccionar un <strong>grupo canal</strong>, para poder registrar la <strong>segmentación del cliente</strong>.<br>
									<i class="fas fa-exclamation-triangle"></i> Si el <strong>grupo canal</strong> no le figura, es porque falta enlazar <strong>grupoCanal-canal-cuenta</strong>.<br>
									<i class="fas fa-exclamation-triangle"></i> Si no le figura una <strong>segmentación tradicional o moderna</strong>, es porque a dicho <strong>grupoCanal no</strong> se le ha considerado para ello.
								</div>
							</div>
							
							<div class="form-row segmentacionClienteTradicional">
								<h5 class="col-md-12 card-title">SEGMENTACIÓN CLIENTE TRADICIONAL</h5>
								<div class="col-md-6">
									<div class="position-relative form-group">
										<? $idPlaza = (isset($clienteHistorico['idPlaza']) && !empty($clienteHistorico['idPlaza'])) ? $clienteHistorico['idPlaza']:NULL; ?>
										<label for="plaza">PLAZA</label>
										<select class="form-control slWidth" id="plaza" name="plaza">
											<option value="">-- Plaza --</option>
											<? if (!empty($idGrupoCanal) && !empty($idPlaza)): ?>
												<? if ( in_array($idGrupoCanal, [4])): ?>
													<? foreach ($listaPlazaTodo as $klp => $row): ?>
														<? $plazaSelected = ($klp==$idPlaza?'selected':''); ?>
														<option value="<?=$row['idPlaza']?>" <?=$plazaSelected?>><?=$row['plaza']?></option>
													<? endforeach ?>
												<? else: ?>
													<? foreach ($listaPlazaMayorista as $klp => $row): ?>
														<? $plazaSelected = ($klp==$idPlaza?'selected':''); ?>
														<option value="<?=$row['idPlaza']?>" <?=$plazaSelected?>><?=$row['plaza']?></option>
													<? endforeach ?>
												<? endif ?>
											<? endif ?>
											<? /*foreach ($listaPlaza as $klp => $row): ?>
												<option value="<?=$row['idPlaza']?>"><?=$row['plaza']?></option>
											<? endforeach*/ ?>
										</select>
									</div>
								</div>
								<div class="col-md-6 divDistribuidoraSucursal">
									<div class="position-relative form-group">
										<label for="distribuidoraSucursal">DISTRIBUIDORA SUCURSAL</label>
										<div class="input-group">
											<select class="js-example-basic-multiple js-states form-control" id="distribuidoraSucursal" name="distribuidoraSucursal">
												<option value="">-- DISTRIBUIDORA SUCURSAL --</option>
												<? foreach ($listaDistribuidoraSucursal as $klds => $row): ?>
													<option value="<?=$row['idDistribuidoraSucursal']?>"><?=$row['distribuidoraSucursal']?></option>
												<? endforeach ?>
											</select>
											<div class="input-group-append">
												<button id="addDistribuidoraSucursal" class="btn btn-primary"><i class="fas fa-plus-square"></i> Añadir</button>
											</div>
										</div>
									</div>
									
									<div class="position-relative form-group">
										<div class="table-responsive">
											<table id="tb-distribuidoraSucursal" class="mb-0 table table-bordered table-sm text-nowrap">
												<thead>
													<tr>
														<!--th class="text-center">#</th-->
														<th class="text-center">DISTRIBUIDORA SUCURSAL</th>
														<th class="text-center">OPCIONES</th>
													</tr>
												</thead>
												<tbody>
													<? if (!empty($clienteHistorico['distribuidoraSucursal']) && isset($clienteHistorico['distribuidoraSucursal'])): ?>
														<? $ix=1; ?>
														<? foreach ($clienteHistorico['distribuidoraSucursal'] as $kld => $row): ?>
															<? if (!empty($kld)): ?>
																<tr>
																	<!--td class="text-center"><?=$ix++;?></td-->
																	<td><div class="hide"><input type="text" name="distribuidoraSucursalSelected" value="<?=$kld?>"></div><?=$row['distribuidoraSucursal']?></td>
																	<td class="text-center"><button type="button" class="btn-deleteRow btn btn-danger" ><i class="fas fa-trash fa-lg"></i></button></td>
																</tr>
															<? endif ?>
														<? endforeach ?>
													<? endif ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>

							<div class="form-row segmentacionClienteModerno">
								<h5 class="col-md-12 card-title">SEGMENTACIÓN CLIENTE MODERNO</h5>
								<div class="col-md-6">
									<div class="position-relative form-group">
										<? $idCadena = (isset($clienteHistorico['idCadena']) && !empty($clienteHistorico['idCadena'])) ? $clienteHistorico['idCadena']:NULL; ?>
										<label for="cadena">CADENA</label>
										<select class="form-control slWidth" id="cadena" name="cadena">
											<option value="">-- Cadena --</option>
											<? foreach ($listaCadenaBanner as $klcb => $row): ?>
												<? $cadenaSelected = ($klcb==$idCadena ? 'selected':''); ?>
												<option value="<?=$row['idCadena']?>" <?=$cadenaSelected?>><?=$row['cadena']?></option>
											<? endforeach ?>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="position-relative form-group">
										<? $idBanner = (isset($clienteHistorico['idBanner']) && !empty($clienteHistorico['idBanner'])) ? $clienteHistorico['idBanner']:NULL; ?>
										<label for="banner">BANNER</label>
										<select class="form-control slWidth" id="banner" name="banner">
											<option value="">-- Banner --</option>
											<? if (!empty($idCadena) && !empty($idBanner)): ?>
												<? foreach ($listaCadenaBanner[$idCadena]['listaBanner'] as $klcb => $row): ?>
													<? $bannerSelected = ($klcb==$idBanner?'selected':''); ?>
													<option value="<?=$row['idBanner']?>" <?=$bannerSelected?>><?=$row['banner']?></option>
												<? endforeach ?>
											<? endif ?>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">
	$('.my_select2').select2({
		dropdownParent: $("div.modal-content"),
		width: '100%'
    });
	$('.segmentacionClienteTradicional').hide();
	$('.segmentacionClienteModerno').hide();

	Basemadre.dataListaRegiones = JSON.parse('<?=json_encode($listaRegiones)?>');
	Basemadre.dataListaCuentaProyecto = JSON.parse('<?=json_encode($listaCuentaProyecto)?>');
	Basemadre.dataListaCuentaGrupoCanalCanalSubCanalClienteTipo = JSON.parse('<?=json_encode($listaCuentaGrupoCanalSubCanalClienteTipo)?>');
	Basemadre.dataListaCadenaBanner = JSON.parse('<?=json_encode($listaCadenaBanner)?>');
	//Basemadre.dataListaCuentaProyectoZona = JSON.parse('<?=json_encode($listaCuentaProyectoZona)?>');
	Basemadre.dataListaPlazaTodo = JSON.parse('<?=json_encode($listaPlazaTodo)?>');
	Basemadre.dataListaPlazaMayorista = JSON.parse('<?=json_encode($listaPlazaMayorista)?>');
	
	var geocoder;
	var map;
	var markers=[];
	/*Inicializar mapa*/
	Basemadre.initialize();
</script>