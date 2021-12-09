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
					<li class="nav-item btnReporte"><a data-toggle="tab" href="#idContentAuditoria" class="active nav-link" url="visibilidad">Visibilidad</a></li>
					<li class="nav-item btnReporte"><a data-toggle="tab" href="#idContentPM" class="nav-link" url="preciomarcado">Precios Marcados</a></li>
					<li class="nav-item btnReporte"><a data-toggle="tab" href="#idContentResumen" class="nav-link" url="resumen">Resumen</a></li>
					<li class="nav-item btnReporte"><a data-toggle="tab" href="#idContentResultados" class="nav-link" url="resultados">Resultados</a></li>
					<li class="nav-item btnReporte"><a data-toggle="tab" href="#idContentCobertura" class="nav-link" url="cobertura">Cobertura</a></li>
					<li class="nav-item btnReporte"><a data-toggle="tab" href="#idContentObservaciones" class="nav-link" url="observaciones">Observaciones</a></li>
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
	<div class="customizer-content p-3 ps-container ps-theme-dark" data-ps-id="aca1f25c-4ed9-a04b-d154-95a5d6494748">
		<form id="frm-auditoria">
			<h4>CONFIGURACIÓN</h4>
			<hr>
			<div class="customizer-content-button">
				<button type="button" class="btn btn-outline-trade-visual border-0" data-url="filtrar" id="btn-filtrarAuditoria" title="Filtrar">
					<i class="fa fa-search"></i><span class="txt_filtro"></span>
				</button>
				<button id="exportar_excel" class="btn btn-outline-trade-visual border-0" title="Descargar Excel"> <i class="fas fa-file-excel"></i> </button>
			</div>
			<hr>
			<div class="customizer-content-filter">
				<h5 class="mt-1 mb-1 text-bold-500"><i class="fal fa-table"></i> Filtros</h5>
				<div class="form-row">
					<input type="hidden" name="tipoFormato" id="tipoFormato" value="1" />
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
						<div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip">
							<?= getFiltros(['cuenta' => ['label' => 'Cuenta', 'name' => 'cuenta_filtro', 'id' => 'cuenta_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip">
							<?= getFiltros(['proyecto' => ['label' => 'Proyecto', 'name' => 'proyecto_filtro', 'id' => 'proyecto_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip dv_grupoCanal">
							<span class="tooltiptext">Grupo Canal</span>
							<?= getFiltros(['grupoCanal' => ['label' => false, 'name' => 'grupo_filtro', 'id' => 'grupo_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip dv_canal">
							<span class="tooltiptext">Canal</span>
							<?= getFiltros(['canal' => ['label' => 'Canal', 'name' => 'canal_filtro', 'id' => 'canal_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip dv_subCanal">
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
						<div class="mb-2 mr-sm-2  position-relative form-group filtros_asistencia custom_tooltip dv_frecuencia">
							<span class="tooltiptext">Frecuencia</span>
							<?= getFiltros(['frecuencia' => ['label' => 'Frecuencia', 'name' => 'frecuencia_filtro', 'id' => 'frecuencia_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
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
						<div class="content-visib mb-2 mr-sm-2 position-relative form-group ">
							<label class="mb-0">Formato: </label>
							<div class="pl-2">
								<div class="form-check">
									<input type="radio" id="rd-visib-formato-1" class="rd-visib form-check-input" name="rd-visib-formato" value="1" checked>
									<label class="form-check-label" for="rd-visib-formato-1">Estandar</label>
								</div>
								<div class="form-check">
									<input type="radio" id="rd-visib-formato-2" class="rd-visib form-check-input" name="rd-visib-formato" value="2">
									<label class="form-check-label" for="rd-visib-formato-2">EO</label>
								</div>
							</div>
						</div>
						<div class="content-visib mb-2 mr-sm-2 position-relative form-group ">
							<label class="mb-0">Mostrar Columnas: </label>
							<div class="pl-2">
								<div class="form-check">
									<input type="checkbox" id="chk-visib-column-1" class="chk-visib form-check-input" name="chk-visib-column" value="1">
									<label class="form-check-label" for="chk-visib-column-1">Cantidad</label>
								</div>
								<div class="form-check">
									<input type="checkbox" id="chk-visib-column-2" class="chk-visib form-check-input" name="chk-visib-column" value="2">
									<label class="form-check-label" for="chk-visib-column-2">Observaciones</label>
								</div>
								<div class="form-check">
									<input type="checkbox" id="chk-visib-column-3" class="chk-visib form-check-input" name="chk-visib-column" value="3">
									<label class="form-check-label" for="chk-visib-column-3">Fotos</label>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 content-visib">
						<h6>Leyenda:</h6>
						<div class="pl-2">
							<p class="mb-0"><i class="fas fa-square text-gray"></i> No corresponde a la Tienda</p>
							<p class="mb-0"><i class="fas fa-square text-obligatorio"></i> Elemento Obligatorio</p>
							<p class="mb-0"><i class="fas fa-square text-iniciativa"></i> Iniciativa</p>
							<p class="mb-0"><i class="fas fa-square text-adicional"></i> Elemento Adicional</p>
							<p class="mb-0"><i class="fas fa-square" style="background:green;"></i> Elemento Modulado</p>
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
			<div class="tab-pane fade show active" id="idContentAuditoria" role="tabpanel">
				<?= getMensajeGestion('noResultados') ?>
			</div>
			<div class="tab-pane fade" id="idContentPM" role="tabpanel">
				<?= getMensajeGestion('noResultados') ?>
			</div>
			<div class="tab-pane fade" id="idContentObservaciones" role="tabpanel">
				<?= getMensajeGestion('noResultados')  ?>
			</div>
			<div class="tab-pane fade" id="idContentResultados" role="tabpanel">
				<?= getMensajeGestion('noResultados')  ?>
			</div>
			<div class="tab-pane fade" id="idContentCobertura" role="tabpanel">
				<?= getMensajeGestion('noResultados')  ?>
			</div>
			<div class="tab-pane fade" id="idContentResumen" role="tabpanel">
				<?= getMensajeGestion('noResultados')  ?>
			</div>
		</div>
	</div>
</div>