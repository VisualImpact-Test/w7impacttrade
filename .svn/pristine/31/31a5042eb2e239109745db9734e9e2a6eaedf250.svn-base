<form id="frm-visitaMantenimiento">
	<div class="hide">
		<input class="form-control" type="text" id="idVisita" name="idVisita" value="<?= $idVisita ?>">
		<? $idVisitaMantCliente = (isset($visita['idVisitaMantCliente']) && !empty($visita['idVisitaMantCliente'])) ? $visita['idVisitaMantCliente'] : ''; ?>
		<input class="form-control" type="text" id="idVisitaMantCliente" name="idVisitaMantCliente" value="<?= $idVisitaMantCliente ?>">
	</div>
	<div class="row themeWhite" style="padding: 10px;padding-top: 0px;">
		<div class="col-lg-12 d-flex">
			<div class="w-100 mb-3 p-0">
				<div class="card-body p-0">
					<ul class="nav nav-tabs nav-justified">
						<li class="nav-item" id="nav-link-0"><a data-toggle="tab" href="#tab-competencia-0" class="nav-link active show">REGISTRAR DATOS DEL CLIENTE</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="tab-content">
				<div class="form-row">
					<div class="col-md-2">
						<? $codCliente = (isset($visita['codCliente']) && !empty($visita['codCliente'])) ? $visita['codCliente'] : '';  ?>
						<div class="position-relative form-group">
							<label for="codCliente">
								<label class="card-title">CÓDIGO CLIENTE:</label>
							</label>
							<input type="text" placeholder="Código Cliente" name="codCliente" id="codCliente" class="form-control" value="<?= $codCliente; ?>" style="width: 100%;">
						</div>
					</div>
					<div class="col-md-3">
						<? $nombreComercial = (isset($visita['nombreComercial']) && !empty($visita['nombreComercial'])) ? $visita['nombreComercial'] : ''; ?>
						<div class="position-relative form-group">
							<label for="nombreComercial">
								<label class="card-title">NOMBRE COMERCIAL:</label>
							</label>
							<input type="text" placeholder="Nombre Comercial" name="nombreComercial" id="nombreComercial" class="form-control" value="<?= $nombreComercial; ?>" style="width: 100%;">
						</div>
					</div>
					<div class="col-md-3">
						<? $razonSocial = (isset($visita['razonSocial']) && !empty($visita['razonSocial'])) ? $visita['razonSocial'] : ''; ?>
						<div class="position-relative form-group">
							<label for="razonSocial">
								<label class="card-title">RAZÓN SOCIAL:</label>
							</label>
							<input type="text" placeholder="Razón Social" name="razonSocial" id="razonSocial" class="form-control" value="<?= $razonSocial; ?>" style="width: 100%;">
						</div>
					</div>
					<div class="col-md-2">
						<? $ruc = (isset($visita['ruc']) && !empty($visita['ruc'])) ? $visita['ruc'] : ''; ?>
						<div class="position-relative form-group">
							<label for="ruc">
								<label class="card-title">RUC:</label>
							</label>
							<input type="text" placeholder="Ruc" name="ruc" id="ruc" class="form-control" value="<?= $ruc; ?>" style="width: 100%;">
						</div>
					</div>
					<div class="col-md-2">
						<? $dni = (isset($visita['dni']) && !empty($visita['dni'])) ? $visita['dni'] : ''; ?>
						<div class="position-relative form-group">
							<label for="ruc">
								<label class="card-title">DNI:</label>
							</label>
							<input type="text" placeholder="DNI" name="dni" id="dni" class="form-control" value="<?= $dni; ?>" style="width: 100%;">
						</div>
					</div>
				</div>
				<div class="divider"></div>
				<div class="form-row">
					<div class="col-md-2">
						<div class="position-relative form-group">
							<label for="cod_departamento">
								<label class="card-title">DEPARTAMENTO</label>
							</label>
							<? $visitaDepartamento = (isset($visita['cod_departamento']) && !empty($visita['cod_departamento'])) ? $visita['cod_departamento'] : ''; ?>
							<? $visitaDepartamento = TRIM($visitaDepartamento); ?>
							<select class="form-control slWidth" id="cod_departamento" name="cod_departamento" style="width: 100%;">
								<option value="">-- Departamentos --</option>
								<? foreach ($listaRegiones as $klr => $regiones) : ?>
									<? $selected = ($regiones['cod_departamento'] == $visitaDepartamento ? 'selected="selected"' : ''); ?>
									<option value="<?= $regiones['cod_departamento'] ?>" <?= $selected; ?>><?= $regiones['departamento'] ?></option>
								<? endforeach ?>
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="position-relative form-group">
							<label for="cod_provincia">
								<label class="card-title">PROVINCIA</label>
							</label>
							<? $visitaProvincia = (isset($visita['cod_provincia']) && !empty($visita['cod_provincia'])) ? $visita['cod_provincia'] : ''; ?>
							<? $visitaProvincia = TRIM($visitaProvincia) ?>
							<select class="form-control slWidth" id="cod_provincia" name="cod_provincia" style="width: 100%;">
								<option value="">-- Provincias --</option>
								<? if (!empty($visitaDepartamento)) : ?>
									<? $arrayProvincias = $listaRegiones[$visitaDepartamento]['listaProvincias']; ?>
									<? foreach ($arrayProvincias as $klp => $provincias) { ?>
										<? $selectedProvincia = $klp == $visitaProvincia ? 'selected="selected"' : ''; ?>
										<option value="<?= $provincias['cod_provincia']; ?>" <?= $selectedProvincia; ?>><?= $provincias['provincia']; ?></option>
									<? } ?>
								<? endif ?>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="position-relative form-group">
							<label for="cod_distrito">
								<label class="card-title">DISTRITO</label>
							</label>
							<? $visitaDistrito = (isset($visita['cod_distrito']) && !empty($visita['cod_distrito'])) ? $visita['cod_distrito'] : ''; ?>
							<? $visitaDistrito = TRIM($visitaDistrito); ?>
							<select class="form-control slWidth" id="cod_distrito" name="cod_distrito" style="width: 100%;">
								<option value="">-- Distritos --</option>
								<? if (!empty($visitaProvincia)) : ?>
									<? $arrayDistritos = $listaRegiones[$visitaDepartamento]['listaProvincias'][$visitaProvincia]['listaDistritos']; ?>
									<? foreach ($arrayDistritos as $kld => $distritos) : ?>
										<? $selectedDistrito = $kld == $visitaDistrito ? 'selected="selected"' : ''; ?>
										<option value="<?= $distritos['cod_distrito']; ?>" <?= $selectedDistrito ?> data-ubigeo="<?= $distritos['cod_ubigeo']; ?>"><?= $distritos['distrito']; ?></option>
									<? endforeach ?>
								<? endif ?>
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<? $cod_ubigeo = (isset($visita['cod_ubigeo']) && !empty($visita['cod_ubigeo'])) ? $visita['cod_ubigeo'] : ''; ?>
						<div class="position-relative form-group">
							<label for="cod_ubigeo">
								<label class="card-title">CÓDIGO UBIGEO</label>
							</label>
							<input type="text" placeholder="Código Ubigeo" name="cod_ubigeo" id="cod_ubigeo" class="form-control" value="<?= $cod_ubigeo; ?>" readonly="readonly" patron="requerido" style="width: 100%;">
						</div>
					</div>
					<div class="col-md-3">
						<? $direccion = (isset($visita['direccion']) && !empty($visita['direccion'])) ? $visita['direccion'] : ''; ?>
						<div class="position-relative form-group">
							<label for="direccion">
								<label class="card-title">DIRECCIÓN</label>
							</label>
							<input type="text" placeholder="Dirección" name="direccion" id="direccion" class="form-control" value="<?= $direccion; ?>" style="width: 100%;">
						</div>
					</div>
					<div class="col-md-12 hide">
						<label class="card-title">POSICIÓN</label>
						<div class="row">
							<div class="col-md-6">
								<div class="input-group input-group-lg">
									<? $visitaLatitud = (isset($visita['latitud']) && !empty($visita['latitud'])) ? $visita['latitud'] : ''; ?>
									<div class="input-group-prepend"><span class="input-group-text">LATITUD</span></div>
									<input id="latitud" name="latitud" type="text" class="form-control" value="<?= $visitaLatitud; ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="input-group input-group-lg">
									<? $visitaLongitud = (isset($visita['longitud']) && !empty($visita['longitud'])) ? $visita['longitud'] : ''; ?>
									<div class="input-group-prepend"><span class="input-group-text">LONGITUD</span></div>
									<input id="longitud" name="longitud" type="text" class="form-control" value="<?= $visitaLongitud; ?>">
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
	ContingenciaRutas.dataListaRegiones = JSON.parse('<?= json_encode($listaRegiones) ?>');
</script>