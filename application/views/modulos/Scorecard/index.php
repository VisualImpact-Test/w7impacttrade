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
					<li class="nav-item btnReporte" id="tipoReporte" name="tipoReporte" url="visibilidad">
						<a data-toggle="tab" href="#idContentScorecard" class="active nav-link" data-value="1">Resultado</a>
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
		<form id="frm-scorecard">
			<div class="card-header" style="margin-bottom: 14px;">
				<h4>CONFIGURACIÓN</h4>
			</div>
			<div>
				<input type="hidden" id="idTipoFormato" name="tipoFormato" value="1">
			</div>
			<div class="customizer-content-button">
				<button type="button" class="btn btn-outline-trade-visual border-0" data-url="filtrar" id="btn-filtrarScorecard" title="Filtrar">
					<i class="fa fa-search"></i> <span class="txt_filtro"></span>
				</button>
				<button type="button" class="btn btn-outline-trade-visual border-0" data-url="excel" id="btn-descargarExcel" title="Excel">
					<i class="far fa-file-excel"></i> <span class="txt_filtro"></span>
				</button>
			</div>
			<hr>
			<div class="customizer-content-filter">
				<h5 class="mt-1 mb-1 text-bold-500"><i class="fal fa-table"></i> Filtros</h5>
				<div class="form-row">
					<div class="col-md-12">
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
							<?= getFiltros(['grupoCanal' => ['label' => 'Grupo Canal', 'name' => 'grupoCanal_filtro', 'id' => 'grupoCanal_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
							<span class="tooltiptext">Canal</span>
							<?= getFiltros(['canal' => ['label' => 'Canal', 'name' => 'canal_filtro', 'id' => 'canal_filtro', 'data' => false, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<!-- <div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia">
							<?= getFiltros(['subCanal' => ['label' => 'Sub Canal', 'name' => 'subcanal_filtro', 'id' => 'subcanal_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]); ?>
						</div> -->
					</div>
				</div>
			</div>
			<div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;">
				<div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
			</div>
			<div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px;">
				<div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div>
			</div>
		</form>
	</div>
</div>

<div class="main-card mb-3 card">
	<div class="card-body p-0">
		<div class="tab-content" id="content-auditoria">
			<div class="tab-pane fade show active" id="idContentScorecard" role="tabpanel">
				<?= getMensajeGestion('noResultados') ?>
			</div>
		</div>
	</div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcH2xfbm8z-5iSE4knkRJiNKRhKQrhH6E&callback=initMap"></script>
<script type="text/javascript" src="assets/libs/anychart/anychart-base.min.js"></script>
<script type="text/javascript" src="assets/libs/anychart/anychart-ui.min.js"></script>
<script type="text/javascript" src="assets/libs/anychart/anychart-map.min.js"></script>
<script type="text/javascript" src="assets/libs/anychart/countries/peru.js"></script>