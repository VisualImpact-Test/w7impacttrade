<div class="row mt-4">
	<div class="col-lg-2 d-flex justify-content-center align-items-center">
		<h3 class="card-title mb-3">
			<i class="<?= $icon ?>"></i>
			<?= $title ?>
		</h3>
	</div>
	<div class="col-lg-10 d-flex">
		<div class="card w-100 mb-3 p-0">
			<div class="card-body p-0">
				<ul class="nav nav-tabs nav-underline nav-justified">
					<li class="nav-item">
						<a class="nav-link active btnReporte" data-toggle="tab" href="#tab-content-0" data-value="1">Detallado</a>
					</li>
					<li class="nav-item">
						<a class="nav-link btnReporte" data-toggle="tab" href="#tab-content-1" data-value="2">Resumen</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="customizer border-left-blue-grey border-left-lighten-4 d-none d-xl-block">
	<a href="javascript:;" class="customizer-close"><i class="fal fa-times"></i></a>
	<a href="javascript:;" class="customizer-toggle box-shadow-3 bg-trade-visual-grad-left text-white">
		<i class="fal fa-cog fa-lg fa-spin"></i>
	</a>
	<div class="customizer-content p-2 ps-container ps-theme-dark">
		<form id="frm-rutas">
			<h4>CONFIGURACIÓN</h4>
			<hr>
			<div class="customizer-content-button">
				<button type="button" class="btn btn-outline-trade-visual border-0" data-url="filtrar" id="btn-filtrarRutas" title="Consultar">
					<i class="fa fa-search"></i> <span class="txt_filtro"></span>
				</button>
			</div>
			<hr>
			<div class="customizer-content-filter">
				<h5 class="mt-1 mb-1 text-bold-500"><i class="fal fa-table"></i> Filtros</h5>
				<div class="form-row">
					<input type="hidden" name="tipoFormato" id="idTipoFormato" value="1" />
					<div class="col-md-12">
						<div class="mb-2 mr-sm-2  position-relative form-group">
							<div class="field">
								<div class="ui my_calendar">
									<div class="ui input left icon" style="width:100%">
										<i class="calendar icon"></i>
										<input type="text" class="form-control" id="txt-fechas" name="txt-fechas" value="<?= date("d/m/Y") . ' - ' . date("d/m/Y") ?>" placeholder="Date">
									</div>
								</div>
							</div>
						</div>
						<div class="mb-2 mr-sm-2  position-relative form-group filtros_asistencia">
							<?= getFiltros(['cuenta' => ['label' => 'Cuenta', 'name' => 'cuenta_filtro', 'id' => 'cuenta_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2  position-relative form-group filtros_asistencia">
							<?= getFiltros(['proyecto' => ['label' => 'Proyecto', 'name' => 'proyecto_filtro', 'id' => 'proyecto_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>

						<div class="mb-2 mr-sm-2  position-relative form-group filtros_asistencia custom_tooltip">
							<span class="tooltiptext">Grupo Canal</span>
							<?= getFiltros(['grupoCanal' => ['label' => false, 'name' => 'grupo_filtro', 'id' => 'grupo_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2  position-relative form-group filtros_asistencia custom_tooltip">
							<span class="tooltiptext">Canal</span>
							<?= getFiltros(['canal' => ['label' => 'Canal', 'name' => 'canal_filtro', 'id' => 'canal_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
							<span class="tooltiptext">SubCanal</span>
							<?= getFiltros(['tipoCliente' => ['label' => 'Sub Canal', 'name' => 'subcanal_filtro', 'id' => 'subcanal_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]); ?>
						</div>
						<div class="mb-2 mr-sm-2  position-relative form-group filtros_asistencia custom_tooltip">
							<span class="tooltiptext">Tipo Usuario</span>
							<?= getFiltros(['tipoUsuario' => ['label' => 'Tipo usuario', 'name' => 'tipoUsuario_filtro', 'id' => 'tipoUsuario_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2  position-relative form-group filtros_asistencia custom_tooltip">
							<span class="tooltiptext">Usuarios <i class="clean_usuario_filtro fas fa-times"></i></span>
							<select class="form-control" id="usuario_filtro" name="usuario_filtro" multiple>
							</select>
						</div>
						<div class="mb-2 mr-sm-2  position-relative form-group filtros_asistencia custom_tooltip">
							<span class="tooltiptext">Frecuencia</span>
							<?= getFiltros(['frecuencia' => ['label' => 'Frecuencia', 'name' => 'frecuencia_filtro', 'id' => 'frecuencia_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="btn-group btn-group-toggle w-100 " data-toggle="buttons" >
							<label class="btn btn-outline-secondary custom_tooltip"> 
								<span class="tooltiptextButton">Visita con incidencia desactivada</span>
								<input type="checkbox" name="inc_desactivado"  id="inc_desactivado" autocomplete="off"> <i class= "fas fa-times"></i>
							</label>
							<label class="btn btn-outline-secondary  custom_tooltip">
								<span class="tooltiptextButton">Visita con incidencia activada</span>
								<input type="checkbox"  name="inc"  id="inc" autocomplete="off"> <i class= "fas fa-check"></i>
							</label>
							<label class="btn btn-outline-secondary  custom_tooltip">
								<span class="tooltiptextButton">Visitas con Observación</span>
								<input type="checkbox"  name="obs" id="obs" autocomplete="off"> <i class= "fas fa-eye"></i>
							</label>
							<label class="btn btn-outline-secondary  custom_tooltip">
								<span class="tooltiptextButton">Visitas con fotos registradas</span>
								<input type="checkbox"  name="foto" id="foto" autocomplete="off"> <i class= "fas fa-images"></i>
							</label>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group chk_cesados">
							<label for="ch-quiebre-inactivo"> Estado Usuarios: </label> <br>
							<div class="btn-group btn-group-toggle w-100 " data-toggle="buttons">
								<label class="btn btn-outline-secondary custom_tooltip">
									<span class="tooltiptextButton">Usuarios Cesados</span>
									<input type="checkbox" name="chk-usuario-inactivo" id="chk-usuario-inactivo" autocomplete="off" checked="checked"> Cesados </i>
								</label>
								<label class="btn btn-outline-secondary  custom_tooltip">
									<span class="tooltiptextButton">Usuarios Vigentes</span>
									<input type="checkbox" name="chk-usuario-activo" id="chk-usuario-activo" autocomplete="off" checked="checked" > Activos </i>
								</label>
							</div>
						</div>
						<div class="content-visib mb-2 mr-sm-2  form-group row pl-3">
							<div class="pl-2 col-6">
								<label class="mb-0">GPS: </label>
								<div class="form-check">
									<input type="radio" id="gps_si" class="rd-rutas form-check-input" name="gps" value="1" >
									<label class="form-check-label" for="gps_si">Con GPS registrado</label>
								</div>
								<div class="form-check">
									<input type="radio" id="gps_no" class="rd-rutas form-check-input" name="gps" value="2">
									<label class="form-check-label" for="gps_no">Sin GPS registrado</label>
								</div>
							</div>
							<div class="pl-2 col-6">
								<label class="mb-0">Tienda Perfecta: </label>
								<div class="form-check">
									<input type="radio" id="tienda_perfecta_si" class="rd-rutas form-check-input" name="tienda_perfecta" value="1" >
									<label class="form-check-label" for="tienda_perfecta_si">SI</label>
								</div>
								<div class="form-check">
									<input type="radio" id="tienda_perfecta_no" class="rd-rutas form-check-input" name="tienda_perfecta" value="2">
									<label class="form-check-label" for="tienda_perfecta_si">NO</label>
								</div>
							</div>
						</div>

						<div class="filtros_secundarios">
							<div class="filtros_generados">
								<h5 class="mt-1 mb-1 text-bold-500"><i class="fal fa-table"></i> Filtros Generados</h5>
								<div class="filtros_gc filtros_HFS d-none">
									<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
										<span class="tooltiptext">Distribuidora</span>
										<?= getFiltros(['distribuidora' => ['label' => 'Distribuidora', 'name' => 'distribuidora_filtro', 'id' => 'distribuidora_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]); ?>
									</div>
									<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
										<span class="tooltiptext">Sucursal</span>
										<?= getFiltros(['distribuidoraSucursal' => ['label' => 'Sucursal', 'name' => 'distribuidoraSucursal_filtro', 'id' => 'distribuidoraSucursal_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]); ?>
									</div>
									<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
										<span class="tooltiptext">Zona</span>
										<?= getFiltros(['zona' => ['label' => 'Zona', 'name' => 'zona_filtro', 'id' => 'zona_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]); ?>
									</div>
								</div>
								<div class="filtros_gc filtros_WHLS d-none">
									<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
										<span class="tooltiptext">Plaza</span>
										<?= getFiltros(['plaza' => ['label' => 'Plaza', 'name' => 'plaza_filtro', 'id' => 'plaza_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]); ?>
									</div>
								</div>
								<div class="filtros_gc filtros_HSM filtros_Moderno d-none">
									<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
										<span class="tooltiptext">Cadena</span>
										<?= getFiltros(['cadena' => ['label' => 'Cadena', 'name' => 'cadena_filtro', 'id' => 'cadena_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]); ?>
									</div>
									<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
										<span class="tooltiptext">Banner</span>
										<?= getFiltros(['banner' => ['label' => 'Banner', 'name' => 'banner_filtro', 'id' => 'banner_filtro', 'data' => false, 'select2' => 'ui my_select2Full', 'html' => '']]); ?>
									</div>
								</div>
								<div class="filtros_gc filtros_ubigeo d-none">
									<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
										<span class="tooltiptext">Departamento</span>
										<?= getFiltros(['departamento' => ['label' => 'Departamento', 'name' => 'departamento_filtro', 'id' => 'departamento_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]); ?>
									</div>
									<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
										<span class="tooltiptext">Provincia</span>
										<?= getFiltros(['provincia' => ['label' => 'Provincia', 'name' => 'provincia_filtro', 'id' => 'provincia_filtro', 'data' => false, 'select2' => 'ui my_select2Full', 'html' => '']]); ?>
									</div>
									<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
										<span class="tooltiptext">Distrito</span>
										<?= getFiltros(['distrito' => ['label' => 'Distrito', 'name' => 'distrito_filtro', 'id' => 'distrito_filtro', 'data' => false, 'select2' => 'ui my_select2Full', 'html' => '']]); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div id="dv-leyenda">
					<hr>
					<h5 class="mt-1 text-bold-500"><i class="far fa-info-circle"></i> Leyenda</h5>
					<div class="form-group">
						<div class="custom-control custom-checkbox mb-1">
							<input type="checkbox" class="custom-control-input" id="ckb-todos" name="ckb-todos" checked="">
							<label class="custom-control-label" for="ckb-todos"><span class="color-C"><i class="fa fa-circle"></i></span> Todo </label>
						</div>
						<div class="custom-control custom-checkbox mb-1">
							<input type="checkbox" class="custom-control-input filtroCondicion" id="ck-efectivaa" name="ck-efectiva" value="EF" checked>
							<label class="custom-control-label" for="ck-efectivaa"><span class="color-C"><i class="fa fa-circle"></i></span> Efectiva </label>
						</div>
						<div class="custom-control custom-checkbox mb-1">
							<input type="checkbox" class="custom-control-input filtroCondicion" id="ck-noEfectiva" name="ck-noEfectiva" value="NE" checked>
							<label class="custom-control-label" for="ck-noEfectiva"><span class="color-N"><i class="fa fa-circle"></i></span> No Efectiva </label>
						</div>
						<div class="custom-control custom-checkbox mb-1">
							<input type="checkbox" class="custom-control-input filtroCondicion" id="ck-incidencia" name="ck-incidencia" value="IN" checked>
							<label class="custom-control-label" for="ck-incidencia"><span class="color-I"><i class="fa fa-circle"></i></span> Incidencia </label>
						</div>
						<div class="custom-control custom-checkbox mb-1">
							<input type="checkbox" class="custom-control-input filtroCondicion" id="ck-sinVisitar" name="ck-sinVisitar" value="SV" checked>
							<label class="custom-control-label" for="ck-sinVisitar"><span class="color-F"><i class="fa fa-circle"></i></span> Sin Visitar </label>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="row tipoDetallado">
	<div class="col-lg-12">
		<div class="main-card mb-3 card">
			<div class="card-body p-0" id="idContentRutas">
				<?= getMensajeGestion('noResultados') ?>
			</div>
		</div>
	</div>
</div>

<div class="row tipoGrafica" style="display:none">
	<div class="col-lg-6">
		<div class="main-card mb-3 card">
			<div class="card-header card-header-spotlight">
				<i class="fal fa-list-alt fa-lg"></i><strong>&nbsp;Participación General</strong>
			</div>
			<div class="card-body">
				<div id="idContentGeneral" class="table-responsive">
					<?= getMensajeGestion('noResultados') ?>
				</div>
			</div>
		</div>

		<div class="main-card mb-3 card">
			<div class="card-header card-header-spotlight">
				<i class="far fa-globe fa-lg"></i><strong>&nbsp;Participación Regional</strong>
			</div>
			<div class="card-body">
				<div id="idContentRegional" class="">
					<?= getMensajeGestion('noResultados') ?>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-6">
		<div class="main-card mb-3 card">
			<div class="card-header card-header-spotlight">
				<i class="fad fa-chart-pie fa-lg"></i><strong>&nbsp;Participación por Canal</strong>
			</div>
			<div class="card-body">
				<div id="idContentCanal" class="">
					<?= getMensajeGestion('noResultados') ?>
				</div>
			</div>
		</div>
	</div>
</div>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcH2xfbm8z-5iSE4knkRJiNKRhKQrhH6E&callback=initMap"></script>
<script type="text/javascript" src="assets/libs/anychart/anychart-base.min.js"></script>
<script type="text/javascript" src="assets/libs/anychart/anychart-ui.min.js"></script>
<script type="text/javascript" src="assets/libs/anychart/anychart-map.min.js"></script>
<script type="text/javascript" src="assets/libs/anychart/countries/peru.js"></script>