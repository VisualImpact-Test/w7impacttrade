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
				<ul class="nav nav-tabs nav-justified">
					<li class="nav-item">
						<a class="nav-link btnReporte active" data-toggle="tab" href="#tab-content-1" data-value="2" data-tiporeporte="1" data-contenedor="tipoDetallado">Detallado</a>
					</li>
					<li class="nav-item">
						<a class="nav-link btnReporte" data-toggle="tab" href="#tab-content-0" data-value="1" data-tiporeporte="2">Resumen</a>
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
	<div class="customizer-content p-2 ps-container ps-theme-dark" data-ps-id="aca1f25c-4ed9-a04b-d154-95a5d6494748">
		<form id="frm-basemadre">
			<div class="card-header" style="margin-bottom: 14px;">
				<h4>CONFIGURACIÓN</h4>
			</div>
			<div>
				<input type="hidden" id="idTipoFormato" name="tipoFormato" value="2">
			</div>
			<div class="customizer-content-button">
				<button class="btn btn-outline-trade-visual border-0" data-url="filtrar" id="btn-filtrarBasemadre" title="Filtrar">
					<i class="fa fa-search"></i> <span class="txt_filtro"></span>
				</button>
			</div>
			<hr>
			<div class="customizer-content-filter">
				<h5 class="mt-1 mb-1 text-bold-500"><i class="fal fa-table"></i> Filtros</h5>
				<div class="form-row">
					<div class="col-md-12">
						<div id="filtro_cartera" class="mb-2 mr-sm-2 position-relative form-group">
							<label>En cartera:</label><br>
							<div role="group" class="btn-group btn-group-toggle" data-toggle="buttons">
								<label class="btn btn-outline-trade-visual border-0 active">
									<input type="radio" name="flag_cartera" value="0">
									No
								</label>
								<label class="btn btn-outline-trade-visual border-0">
									<input type="radio" name="flag_cartera" value="1" checked="checked">
									Sí
								</label>
							</div>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group">
							<div class="field">
								<div class="ui my_calendar">
									<div class="ui input left icon" style="width:100%">
										<i class="calendar icon"></i>
										<input type="text" name="txt-fechas" id="txt-fechas" placeholder="Date" value="<?= date("d/m/Y") . ' - ' . date("d/m/Y") ?>" class="form-control">
									</div>
								</div>
							</div>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia">
							<?= getFiltros(['cuenta' => ['label' => 'Cuenta', 'name' => 'cuenta_filtro', 'id' => 'cuenta_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia">
							<?= getFiltros(['proyecto' => ['label' => 'Proyecto', 'name' => 'proyecto_filtro', 'id' => 'proyecto_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
							<span class="tooltiptext">Grupo Canal</span>
							<?= getFiltros(['grupoCanal' => ['label' => false, 'name' => 'grupo_filtro', 'id' => 'grupo_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
							<span class="tooltiptext">Canal</span>
							<?= getFiltros(['canal' => ['label' => 'Canal', 'name' => 'canal_filtro', 'id' => 'canal_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
							<span class="tooltiptext">SubCanal</span>
							<?= getFiltros(['tipoCliente' => ['label' => 'Sub Canal', 'name' => 'subcanal_filtro', 'id' => 'subcanal_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]); ?>
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
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="row tipoGrafica" style="display:none">
	<div class="col-lg-6">
		<div class="main-card mb-3 card">
			<div class="card-header card-header-spotlight">
				<i class="fas fa-list-alt fa-lg"></i>&nbsp;Participación General
			</div>
			<div class="card-body">
				<div id="idContentGeneral" class="table-responsive">
					<?= getMensajeGestion('noResultados') ?>
				</div>
			</div>
		</div>
		<div class="main-card mb-3 card">
			<div class="card-header card-header-spotlight">
				<i class="fas fa-globe fa-lg"></i>&nbsp;Participación Regional
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
				<i class="fad fa-chart-pie fa-lg"></i>&nbsp;Participación por Canal
			</div>
			<div class="card-body">
				<div id="idContentCanal" class="">
					<?= getMensajeGestion('noResultados') ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row tipoGrafica" style="display:none">
	<div class="col-lg-12">
		<div class="main-card mb-3 card">
			<div class="card-header card-header-spotlight">
				<i class="fas fa-chart-bar fa-lg"></i>&nbsp;Participación por Segmento
			</div>
			<div class="card-body">
				<div id="idContentSegmento" class="">
					<?= getMensajeGestion('noResultados') ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row tipoDetallado">
	<div class="col-lg-12">
		<div class="main-card mb-3 card">
			<div class="card-body p-0">
				<div id="idContentDetallado">
					<?= getMensajeGestion('noResultados') ?>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="assets/libs/anychart/anychart-base.min.js"></script>
<script type="text/javascript" src="assets/libs/anychart/anychart-ui.min.js"></script>
<script type="text/javascript" src="assets/libs/anychart/anychart-map.min.js"></script>
<script type="text/javascript" src="assets/libs/anychart/countries/peru.js"></script>