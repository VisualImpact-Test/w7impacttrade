<style>
	.customBoxShadow {
		box-shadow: 0 0.46875rem 0rem rgb(4 9 20 / 3%), 0 0.9375rem 1.40625rem rgb(4 9 20 / 3%), 0 0.25rem 20rem rgb(4 9 20 / 5%), 0 0.125rem 0.1875rem rgb(4 9 20 / 3%) !important;

	}

	.d-grid {
		display: grid !important;
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
					<? foreach ($tabs as $k => $v) { ?>
						<li class="nav-item btnReporte" id="tipoReporte" name="tipoReporte">
							<a data-toggle="tab" href="#<?= $v['contenedor'] ?>" class="<?= ($k == 0) ? 'active' : '' ?> nav-link" data-value="1" data-url="<?= $v['url'] ?>" data-contentdetalle="<?= $v['contenedor'] ?>"><?= $v['nombre'] ?></a>
						</li>
					<? } ?>
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
		<form id="frm-checklistproductos">
			<div class="card-header" style="margin-bottom: 14px;">
				<h4>CONFIGURACIÓN</h4>
			</div>
			<div>
				<input type="hidden" id="idTipoFormato" name="tipoFormato" value="1">
			</div>
			<div class="customizer-content-button">
				<button type="button" class="btn btn-outline-trade-visual border-0" data-url="filtrar" id="btn-filtrarVisibilidad" title="Filtrar">
					<i class="fa fa-search"></i> <span class="txt_filtro"></span>
				</button>
				<button type="button" class="btn btn-outline-trade-visual border-0 chk_quiebres" data-url="filtrar" id="btn-quiebres-pdf" title="Exportar PDF">
					<i class="fa fa-file-pdf"></i> <span class="txt_filtro"></span>
				</button>
				<button type="button" class="btn btn-outline-trade-visual border-0 " id="btn-detallado-excel" title="Exportar Excel">
					<i class="fa fa-file-excel"></i> <span class="txt_filtro"></span>
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
							<?= getFiltros(['canal' => ['label' => 'Canal', 'name' => 'canal_filtro', 'id' => 'canal_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>

						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
							<span class="tooltiptext">Sub canal</span>
							<?= getFiltros(['tipoCliente' => ['label' => 'Sub Canal', 'name' => 'subcanal_filtro', 'id' => 'subcanal_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]); ?>
						</div>
						<div class="mb-2 mr-sm-2  position-relative form-group filtros_asistencia custom_tooltip dv_tipoUsuario">
							<span class="tooltiptext">Tipo Usuario</span>
							<?= getFiltros(['tipoUsuario' => ['label' => 'Tipo usuario', 'name' => 'tipoUsuario_filtro', 'id' => 'tipoUsuario_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2  position-relative form-group filtros_asistencia custom_tooltip dv_usuario">
							<span class="tooltiptext">Usuarios <i class="clean_usuario_filtro fas fa-times"></i></span>
							<select class="form-control" id="usuario_filtro" name="usuario_filtro" multiple>
							</select>
						</div>
						<div class="filtros_secundarios">
							<div class="mb-2 mr-sm-2 position-relative form-group chk_quiebres" style="display: none;">
								<!-- <div class="position-relative form-check form-check-inline">
									<label class="form-check-label"><input type="checkbox" name="ch-quiebre" value="1" class="form-check-input"> Quiebre</label>
								</div> -->
								<label for="ch-quiebre-inactivo"> Quiebres: </label> <br>
								<div class="btn-group btn-group-toggle w-50 " data-toggle="buttons">
									<label class="btn btn-outline-secondary custom_tooltip">
										<span class="tooltiptextButton">Sin Quiebre</span>
										<input type="checkbox" name="ch-quiebre-inactivo" id="ch-quiebre-inactivo" autocomplete="off"> NO </i>
									</label>
									<label class="btn btn-outline-secondary  custom_tooltip">
										<span class="tooltiptextButton">Con Quiebre</span>
										<input type="checkbox" name="ch-quiebre-activo" id="ch-quiebre-activo" autocomplete="off" checked="checked"> SI </i>
									</label>
								</div>
							</div>
							<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip chk_quiebres" style="display: none;">
								<label for="motivo"> Motivo: </label> <br>
								<select class="form-control ui my_select2Full" id="motivo" name="motivo" multiple>
									<?= htmlSelectOptionArray2(['query' => $motivos, 'id' => 'idMotivo', 'value' => 'nombre', 'title' => '-- Seleccione --']) ?>
								</select>
							</div>
							<div class="mb-2 mr-sm-2 position-relative form-group chk_fifo" style="display: none;">
								<label for="ch-quiebre-inactivo"> Fifo: </label> <br>
								<div class="btn-group btn-group-toggle w-50 " data-toggle="buttons">
									<label class="btn btn-outline-secondary custom_tooltip">
										<span class="tooltiptextButton">Mostrar productos vencidos</span>
										<input type="checkbox" name="chk-fifo-vencido" id="chk-fifo-vencido" autocomplete="off"> Vencidos </i>
									</label>
									<label class="btn btn-outline-secondary  custom_tooltip">
										<span class="tooltiptextButton">Mostrar productos por vencer</span>
										<input type="checkbox" name="chk-fifo-porVencer" id="chk-fifo-porVencer" autocomplete="off" checked="checked"> Por Vencer </i>
									</label>
								</div>
							</div>
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
				<div id="dv-leyenda">
					<hr>
					<h5 class="mt-1 text-bold-500"><i class="far fa-info-circle"></i> Leyenda</h5>
					<div class="form-group">
						<div class="custom-control custom-checkbox mb-1">
							<input type="checkbox" class="custom-control-input " data-tipo="product-propio" id="ck-propios" name="ck-propios" checked="checked">
							<label class="custom-control-label" for="ck-propios"><span class="color-C"><i class="fa fa-circle"></i></span> Articulos Propios </label>
						</div>
						<div class="custom-control custom-checkbox mb-1">
							<input type="checkbox" class="custom-control-input " data-tipo="product-competencia" id="ck-competencia" name="ck-competencia">
							<label class="custom-control-label" for="ck-competencia"><span class="color-N"><i class="fa fa-circle"></i></span> Articulos de la Competencia </label>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<? if ($this->sessIdCuenta == "2") : ?>
	<div class="customizer customizerGraphics border-left-blue-grey border-left-lighten-4 d-none d-xl-block ">
		<a href="javascript:;" class="customizer-close "><i class="fal fa-times"></i></a>
		<a href="javascript:;" class="customizer-toggle box-shadow-3 bg-trade-visual-grad-left-gray text-white btnResumenChekProd" style="top:150px;">
			<i class="fal fa-analytics fa-lg "></i>
		</a>
		<div class="customizer-content p-2 ps-container ps-theme-dark" data-ps-id="aca1f25c-4ed9-a04b-d154-95a5d6494748" style="zoom: 65%;">
			<div class="card-header" style="margin-bottom: 14px;">
				<h3>Resumen Check Productos</h3>
				<div class="mb-2 mr-sm-2 position-relative form-group px-2">
					<div class="field">
						<div class="ui my_calendar">
							<div class="ui input left icon" style="width:100%">
								<i class="calendar icon"></i>
								<input type="text" name="txt-fechas-resumen" id="txt-fechas-resumen" placeholder="Date" value="<?= date("d/m/Y") ?>" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<div class="mb-2 mr-sm-2 position-relative form-group  dv-grupoCanal-resumen">
					<select name="sl-grupoCanal-resumen" id="sl-grupoCanal-resumen" class="w-100">
						<?=htmlSelectOptionArray2(['query'=>$gruposCanal,'id'=>'id','value'=>'nombre'])?>
					</select>
				</div>
				<div class="mb-2 mr-sm-2 position-relative form-group  dv-tipoReporte-resumen">
					<select name="cb-tipoReporte-resumen" id="cb-tipoReporte-resumen" class="w-100">
						<option value="2">
							<h5 class="card-title">
								<i class="fas fa-store-alt fa-lg"></i> ACUMULADO
							</h5>
						</option>
						<option value="1">
							<h5 class="card-title">
								<i class="fas fa-store-alt fa-lg"></i> DIARIO
							</h5>
						</option>
					</select>
				</div>
				<div class="mb-2 mr-sm-2 position-relative form-group ">
					<button type="button" class="btn btn-outline-trade-visual border-0" data-url="filtrar" id="btn-filtrar-resumen" title="Filtrar">
						<i class="fa fa-search"></i>
					</button>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-9 col-md-12 d-flex">
					<div class="main-card mb-3 card main-cobertura col-md-12 px-0">
						<div class="card-group">
							<div class="card">
								<div class="text-center card-header d-grid bg-trade-visual-grad-right text-white" style="height: 30px !important;padding:0px !important">
									<h5 class="card-title">
										<i class="fas fa-cog fa-lg"></i> OPCIONES
									</h5>
								</div>
								<div class="text-center card-footer botonesTable" style="display: inherit;">

								</div>
							</div>
							<div class="card customBoxShadow ">
								<div class="text-center card-header d-grid bg-trade-visual-grad-center text-white" style="height: 30px !important;padding:0px !important">
									<h5 class="card-title">
										<i class="fas fa-store-alt fa-lg"></i> TIENDAS VISITADAS
									</h5>
								</div>
								<div class="text-center card-footer txt-tiendasVisitadas">
									<h5 class="card-title">
										0
									</h5>
								</div>
							</div>
							<div class="card customBoxShadow dv-tipoReporte ">
								<div class="text-center card-header d-grid bg-trade-visual-grad-left text-white" style="height: 30px !important;padding:0px !important">
									<h5 class="card-title">
										<i class="far fa-filter"></i> TIPO REPORTE
									</h5>
								</div>
								<div class="text-center card-footer">
									<select name="cb-tipoResumen" id="cb-tipoResumen">
										<option value="presencia">
											<h5 class="card-title">
												<i class="fas fa-store-alt fa-lg"></i> PRESENCIA
											</h5>
										</option>
										<option value="quiebres">
											<h5 class="card-title">
												<i class="fas fa-store-alt fa-lg"></i> QUIEBRES
											</h5>
										</option>
									</select>
								</div>
							</div>
						</div>
						<div class="card-body centrarContenidoDiv vista-resumen-detallado" style="width: 100%;padding:0px !important">
							<i class="fas fa-spinner-third fa-spin icon-load"></i>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-12 d-flex">
					<div class="main-card mb-3 card main-efectividad col-md-12 px-0">
						<div class="card-header bg-trade-visual-grad-left text-white" style="width: 100%;height:30px !important">
							<h5 class="card-title">
								<i class="fas fa-tasks fa-lg"></i> TOP 5 <span class="segResumenTitlePresencia">CADENAS</span> CON PRESENCIA<sup><?= $this->sessNomCuentaCorto ?></sup>
							</h5>
						</div>
						<div class="card-body centrarContenidoDiv top-cadenas-presencia" style="width: 100%;">
							<i class="fas fa-spinner-third fa-spin icon-load"></i>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12 d-flex">
					<div class="main-card mb-3 card main-cobertura col-md-12 px-0">
						<div class="card-header bg-trade-visual-grad-right text-white" style="width: 100%;height:30px !important">
							<h5 class="card-title">
								<i class="fas fa-store-alt fa-lg"></i> TOP 10 PRODUCTOS CON PRESENCIA
							</h5>
						</div>
						<div class="card-body centrarContenidoDiv top-productos-mas-presencia" style="width: 100%;">
							<i class="fas fa-spinner-third fa-spin icon-load"></i>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12 d-flex">
					<div class="main-card mb-3 card main-efectividad col-md-12 px-0">
						<div class="card-header bg-trade-visual-grad-left text-white" style="width: 100%;height:30px !important">
							<h5 class="card-title">
								<i class="fas fa-tasks fa-lg"></i> TOP 10 PRODUCTOS CON QUIEBRE
							</h5>
						</div>
						<div class="card-body centrarContenidoDiv top-productos-menos-presencia" style="width: 100%;">
							<i class="fas fa-spinner-third fa-spin icon-load"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<? endif; ?>

<div class="main-card mb-3 card ">
	<div class="card-body p-0">
		<div class="tab-content" id="content-auditoria">
			<? foreach ($tabs as $k => $v) { ?>
				<div class="tab-pane fade <?= ($k == 0) ? 'show active' : '' ?>" id="<?= $v['contenedor'] ?>" role="tabpanel">
					<?= getMensajeGestion('noResultados') ?>
				</div>
			<? } ?>
		</div>
	</div>
</div>

<script type="text/javascript" src="assets/libs/anychart/anychart-base.min.js"></script>
<script type="text/javascript" src="assets/libs/anychart/anychart-ui.min.js"></script>
<script type="text/javascript" src="assets/libs/anychart/anychart-map.min.js"></script>
<script type="text/javascript" src="assets/libs/anychart/countries/peru.js"></script>
<script type="text/javascript" src="https://cdn.anychart.com/js/latest/anychart-bundle.min.js"></script>