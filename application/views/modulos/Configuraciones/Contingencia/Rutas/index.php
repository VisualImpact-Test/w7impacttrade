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
					<li class="nav-item btnReporte">
						<a data-toggle="tab" href="#contentGtm" class="active nav-link" data-value="1">Visitas</a>
					</li>
					<!-- <li class="nav-item btnReporte">
						<a data-toggle="tab" href="#contentSupervisor" class="nav-link" data-value="2">Supervisor</a>
					</li> -->
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
		<form id="frm-contingenciaRutas">
			<input type="hidden" name="tipoFormato" value="1">
			<div class="card-header" style="margin-bottom: 14px;">
				<h4>CONFIGURACIÓN</h4>
			</div>
			<div class="customizer-content-button">
				<button type="button" class="btn btn-outline-trade-visual border-0 btn-Consultar" data-url="filtrar" id="btn-filtrarContingenciaRutas" title="Consultar">
					<i class="fa fa-search"></i> <span class="txt_filtro"></span>
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
										<input type="text" name="txt-fechas_simple" id="txt-fechas_simple" placeholder="Date" value="<?= date("d/m/Y") . ' - ' . date("d/m/Y") ?>" class="form-control">
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
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia">
							<?= getFiltros(['grupoCanal' => ['label' => false, 'name' => 'grupoCanal_filtro', 'id' => 'grupoCanal_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia">
							<?= getFiltros(['canal' => ['label' => 'Canal', 'name' => 'canal_filtro', 'id' => 'canal_filtro', 'data' => false, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
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
										<?= getFiltros(['distribuidoraSucursal' => ['label' => 'Distribuidora Sucursal', 'name' => 'distribuidoraSucursal_filtro', 'id' => 'distribuidoraSucursal_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]); ?>
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
				
				<div class="mb-2 mr-sm-2 position-relative form-group chk_cesados">
					<label for="ch-quiebre-inactivo"> Estado Usuarios: </label> <br>
					<div class="btn-group btn-group-toggle w-100 " data-toggle="buttons">
						<label class="btn btn-outline-secondary custom_tooltip">
							<span class="tooltiptextButton">Usuarios Cesados</span>
							<input type="checkbox" name="chk-usuario-inactivo" id="chk-usuario-inactivo" autocomplete="off" checked="checked"> Cesados </i>
						</label>
						<label class="btn btn-outline-secondary  custom_tooltip">
							<span class="tooltiptextButton">Usuarios Vigentes</span>
							<input type="checkbox" name="chk-usuario-activo" id="chk-usuario-activo" autocomplete="off" checked="checked"> Activos </i>
						</label>
					</div>
				</div>
				<div id="dv-leyenda">
					<hr>
					<h5 class="mt-1 text-bold-500"><i class="far fa-info-circle"></i> Leyenda</h5>
					<div class="form-group">
						<div class="leyenda custom-checkbox mb-1">
							<label for="ck-efectivaa"><span class="color-C"><i class="fa fa-circle"></i></span> Efectiva </label>
						</div>
						<div class="leyenda custom-checkbox mb-1">
							<label for="ck-noEfectiva"><span class="color-N"><i class="fa fa-circle"></i></span> No Efectiva </label>
						</div>
						<div class="leyenda custom-checkbox mb-1">
							<label for="ck-sinVisitar"><span class="color-F"><i class="fa fa-circle"></i></span> Sin Visitar </label>
						</div>
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

<div class="main-card mb-3 card div-para-ocultar">
	<div class="card-body p-0">
		<div class="tab-content" id="content-contingencia-rutas">
			<div class="tab-pane fade show active " id="contentGtm" role="tabpanel">
				<?= getMensajeGestion('noResultados') ?>
			</div>
			<!-- <div class="tab-pane fade  " id="contentSupervisor" role="tabpanel">
                <? //= getMensajeGestion('noResultados') 
				?>
            </div> -->
		</div>
	</div>
</div>