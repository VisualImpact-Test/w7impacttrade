<style>
	.table-responsive-ipp {
		min-height: 80px;
		/* max-height: 450px; */
		overflow-y: auto;
		border: none;
	}
</style>
<div class="row mt-4">
	<div class="col-lg-4 d-flex justify-content-center align-items-center">
		<h3 class="card-title mb-3">
			<i class="<?= $icon ?>"></i>
			<?= $title ?>
		</h3>
	</div>
	<div class="col-lg-8 d-flex">
		<div class="card w-100 mb-3 p-0">
			<div class="card-body p-0">
				<ul class="nav nav-tabs nav-justified">
					<li class="nav-item btnReporte" id="tipoReporte" name="tipoReporte">
						<a data-toggle="tab" href="#idContentResumenNews" class="active nav-link" data-value="1" data-contentdetalle="idContentResumenNews" data-url="resumen_nuevo">Resumen Nuevo</a>
					</li>
					<li class="nav-item btnReporte" id="tipoReporte" name="tipoReporte">
						<a data-toggle="tab" href="#idContentDetallado" class=" nav-link" data-value="2" data-contentdetalle="idContentDetallado" data-url="detallado_nuevo">Detallado</a>
					</li>
					<li class="nav-item btnReporte" id="tipoReporte" name="tipoReporte">
						<a data-toggle="tab" href="#idContentResumen" class=" nav-link" data-value="3" data-contentdetalle="idContentResumen" data-url="resumen">Resumen</a>
					</li>
					<li class="nav-item btnReporte" id="tipoReporte" name="tipoReporte">
						<a data-toggle="tab" href="#idContentPdv" class=" nav-link" data-value="4" data-contentdetalle="idContentPdv" data-url="tienda">PDV</a>
					</li>
					<li class="nav-item btnReporte" id="tipoReporte" name="tipoReporte">
						<a data-toggle="tab" href="#idContentPdvHorizontal" class=" nav-link" data-value="5" data-contentdetalle="idContentPdvHorizontal" data-url="detallado">Horizontal</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="customizer border-left-blue-grey border-left-lighten-4 d-none d-xl-block ">
	<a href="javascript:;" class="customizer-close"><i class="fal fa-times"></i></a>
	<a href="javascript:;" class="customizer-toggle box-shadow-3 bg-trade-visual-grad-left text-white">
		<i class="fal fa-cog fa-lg fa-spin"></i>
	</a>
	<div class="customizer-content p-2 ps-container ps-theme-dark" data-ps-id="aca1f25c-4ed9-a04b-d154-95a5d6494748">
		<form id="form-ipp">
			<div class="card-header" style="margin-bottom: 14px;">
				<h4>CONFIGURACIÓN</h4>
			</div>
			<div>
				<input type="hidden" id="idTipoFormato" name="tipoFormato" value="1">
			</div>
			<div class="customizer-content-button">
				<button type="button" class="btn btn-outline-trade-visual border-0" id="btn-ipp-consultar" title="Filtrar">
					<i class="fa fa-search"></i> <span class="txt_filtro"></span>
				</button>
				<button id="btn-mas-filtros" type="submit" class="btn btn-outline-trade-visual border-0" style="margin-bottom: 0px;" data-toggle="modal" data-target="#modal-filtros">
					<i class="fa fa-filter"></i>
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
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
							<span class="tooltiptext">Año</span>
							<select class="form-control input-sm my_select2Full" id="sl-anio" name="sl-anio" title="Año (Todo)">
								<option value="" class="label label-success">Año (Todo)</option>
								<? for ($i = DATE('Y'); $i >= 2019; $i--) { ?>
									<option value="<?= $i ?>" <?= ($i == DATE('Y')) ? "SELECTED" : "" ?>><?= $i ?></option>
								<? } ?>
							</select>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
							<span class="tooltiptext">Mes</span>
							<select class="form-control input-sm my_select2Full" id="sl-mes" name="sl-mes" title="Mes (Todo)">
								<option value="" class="label label-success">Mes (Todo)</option>
								<? //foreach($tiempo['mes'] as $ix => $row){
								?>
								<option value="1" <?= (DATE('m') == 1) ? "SELECTED" : "" ?>>ENERO</option>
								<option value="2" <?= (DATE('m') == 2) ? "SELECTED" : "" ?>>FEBRERO</option>
								<option value="3" <?= (DATE('m') == 3) ? "SELECTED" : "" ?>>MARZO</option>
								<option value="4" <?= (DATE('m') == 4) ? "SELECTED" : "" ?>>ABRIL</option>
								<option value="5" <?= (DATE('m') == 5) ? "SELECTED" : "" ?>>MAYO</option>
								<option value="6" <?= (DATE('m') == 6) ? "SELECTED" : "" ?>>JUNIO</option>
								<option value="7" <?= (DATE('m') == 7) ? "SELECTED" : "" ?>>JULIO</option>
								<option value="8" <?= (DATE('m') == 8) ? "SELECTED" : "" ?>>AGOSTO</option>
								<option value="9" <?= (DATE('m') == 9) ? "SELECTED" : "" ?>>SETIEMBRE</option>
								<option value="10" <?= (DATE('m') == 10) ? "SELECTED" : "" ?>>OCTUBRE</option>
								<option value="11" <?= (DATE('m') == 11) ? "SELECTED" : "" ?>>NOVIEMBRE</option>
								<option value="12" <?= (DATE('m') == 12) ? "SELECTED" : "" ?>>DICIEMBRE</option>
								<? //}
								?>
							</select>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
							<span class="tooltiptext">Cuenta</span>
							<?= getFiltros(['cuenta' => ['label' => 'Cuenta', 'name' => 'cuenta_filtro', 'id' => 'cuenta_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
							<span class="tooltiptext">Proyecto</span>
							<?= getFiltros(['proyecto' => ['label' => 'Proyecto', 'name' => 'proyecto_filtro', 'id' => 'proyecto_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
							<span class="tooltiptext">Grupo Canal</span>
							<?= getFiltros(['grupoCanal' => ['label' => false, 'name' => 'grupoCanal_filtro', 'id' => 'grupoCanal_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>

						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
							<span class="tooltiptext">Canal</span>
							<?= getFiltros(['canal' => ['label' => 'Canal', 'name' => 'canal_filtro', 'id' => 'canal_filtro', 'data' => false, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>

						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
							<span class="tooltiptext">Sub canal</span>
							<?= getFiltros(['tipoCliente' => ['label' => 'Sub Canal', 'name' => 'subcanal_filtro', 'id' => 'subcanal_filtro', 'data' => false, 'select2' => 'ui my_select2Full', 'html' => '']]); ?>
						</div>
						<!-- <div class="mb-2 mr-sm-2  position-relative form-group filtros_asistencia custom_tooltip dv_pdv">
							<span class="tooltiptext">PDV <i class="clean_pdv_filtro fas fa-times"></i></span>
							<select class="form-control" id="pdv_filtro" name="pdv_filtro" multiple>
							</select>
						</div> -->
						<!--MAS FILTROS-->
						<div id="modal-filtros" class="modal fade" role="dialog" data-keyboard="false" tabindex="" style="z-index: 1025;">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title"><i class="fa fa-search"></i> Impact Trade - Más Filtros</h4>
									</div>
									<div class="modal-body">
										<ul class="nav nav-tabs nav-justified p-2">
											<li id="tabUbicacion" class="nav-item"><a data-toggle="tab" class="active" href="#tab-ubicacion">Ubicación</a></li>
											<li id="tabEncargado" class="nav-item"><a data-toggle="tab" href="#tab-encargado">Colaboradores</a></li>
											<!-- <li id="tabTradicionales" class="hidden nav-item"><a data-toggle="tab" href="#tab-tradicionales">Tradicional</a></li> -->
										</ul>
										<div class="tab-content x_panel">
											<div id="tab-ubicacion" class="tab-pane fade in active">
												<div class="form-group">
													<select class="form-control input-sm selectpicker" id="sl-departamento" name="sl-departamento" title="Departamento (Todo)" data-actions-box="true" data-live-search="true">
														<option value="" class="label label-success">Departamento (Todo)</option>
													</select>
												</div>
												<div class="form-group">
													<select class="form-control input-sm selectpicker" id="sl-provincia" name="sl-provincia" title="Provincia (Todo)" data-actions-box="true" data-live-search="true">
														<option value="" class="label label-success">Provincia (Todo)</option>
													</select>
												</div>
												<div class="form-group">
													<select class="form-control input-sm selectpicker" id="sl-distrito" name="sl-distrito" title="Distrito (Todo)" data-actions-box="true" data-live-search="true">
														<option value="" class="label label-success">Distrito (Todo)</option>
													</select>
												</div>
											</div>
											<div id="tab-encargado" class="tab-pane">
												<div class="form-group">
													<select class="form-control input-sm selectpicker" id="sl-encargado" name="sl-encargado" title="Encargado (Todo)" data-actions-box="true" data-live-search="true">
														<option value="" class="label label-success">Encargado (Todo)</option>
													</select>
												</div>
											</div>
											<div id="tab-tradicionales" class="tab-pane fade in hidden">
												<div class="form-group">
													<select class="form-control input-sm selectpicker" id="sl-hfs" name="sl-hfs" title="Tradicional HFS (Todo)" data-actions-box="true" data-live-search="true">
														<option value="" class="label label-success">Tradicional HFS (Todo)</option>
													</select>
												</div>
												<div class="form-group">
													<select class="form-control input-sm selectpicker" id="sl-whls" name="sl-whls" title="Tradicional WHLS (Todo)" data-actions-box="true" data-live-search="true">
														<option value="" class="label label-success">Tradicional WHLS (Todo)</option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-outline-secondary border-0" data-dismiss="modal">Cerrar</button>
										<button type="button" id="btn-filtrar-modal" class="btn btn-outline-trade-visual">Filtrar</button>
									</div>
								</div>
							</div>
						</div>

						<!--MÁS FILTROS-->
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

<div class="main-card mb-3 card ">
	<div class="card-body p-0">
		<div class="tab-content" id="content-auditoria">
			<div class="tab-pane fade show active" id="idContentResumenNews" role="tabpanel">
				<?= getMensajeGestion('noResultados') ?>
			</div>
			<div class="tab-pane fade" id="idContentDetallado" role="tabpanel">
				<?= getMensajeGestion('noResultados') ?>
			</div>
			<div class="tab-pane fade" id="idContentResumen" role="tabpanel">
				<?= getMensajeGestion('noResultados') ?>
			</div>
			<div class="tab-pane fade" id="idContentPdv" role="tabpanel">
				<?= getMensajeGestion('noResultados') ?>
			</div>
			<div class="tab-pane fade" id="idContentPdvHorizontal" role="tabpanel">
				<?= getMensajeGestion('noResultados') ?>
			</div>
		</div>
	</div>
</div>

<script src="assets/libs/anychart/anychart-base.min.js"></script>
<script src="assets/libs/anychart/anychart-exports.min.js"></script>
<script src="assets/libs/anychart/anychart-ui.min.js"></script>