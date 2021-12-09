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
						<a data-toggle="tab" href="#contentPremiaciones" class="active nav-link" data-value="1">Principal</a>
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
		<form id="formFiltroPremiaciones">
			<div class="card-header" style="margin-bottom: 14px;">
				<h4>CONFIGURACIÓN</h4>
			</div>
			<div>
				<input type="hidden" id="idTipoFormato" name="tipoFormato" value="1">
			</div>
			<div class="customizer-content-button">
				<button type="button" class="btn btn-outline-trade-visual border-0" data-url="filtrar" id="btn-consultar" title="Filtrar">
					<i class="fa fa-search"></i> <span class="txt_filtro"></span>
				</button>
				<button type="button" class="btn btn-outline-trade-visual border-0" data-url="pdf" id="btn-pdf" title="PDF">
					<i class="fa fa-file-pdf"></i> <span class="txt_filtro"></span>
				</button>
				<button type="button" class="btn btn-outline-trade-visual border-0" data-url="configuracion" id="btn-configuracion" title="Configuracion">
					<i class="far fa-cog"></i> <span class="txt_filtro"></span>
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
							<span class="tooltiptext">Grupo canal</span>
							<?= getFiltros(['grupoCanal' => ['label' => false, 'name' => 'grupoCanal_filtro', 'id' => 'grupoCanal_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
							<span class="tooltiptext">Canal</span>
							<?= getFiltros(['canal' => ['label' => 'Canal', 'name' => 'canal_filtro', 'id' => 'canal_filtro', 'data' => false, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
							<span class="tooltiptext">Canal</span>
							<?= getFiltros(['tipoCliente' => ['label' => 'Subcanal', 'name' => 'subcanal_filtro', 'id' => 'subcanal_filtro', 'data' => false, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip">
							<span class="tooltiptext">Premiaciones</span>
							<select id="sel-premiacion" class="ui my_select2Full" name="sel-premiacion" title="Premiación (Todo)">
								<option value="">-- Premiaciones --</option>
								<? foreach ($premiaciones as $row) { ?>
									<option value="<?= $row['idPremiacion'] ?>"><?= $row['nombre']." - Vigencia del ".$row['fecIni']." al ".$row['fecFin'] ?></option>
								<? } ?>
							</select>
						</div>

						<div class="mb-2 mr-sm-2  position-relative form-group filtros_asistencia custom_tooltip">
							<span class="tooltiptext">Tipo Usuario</span>
							<?= getFiltros(['tipoUsuario' => ['label' => 'Tipo usuario', 'name' => 'tipoUsuario_filtro', 'id' => 'tipoUsuario_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2  position-relative form-group filtros_asistencia custom_tooltip">
							<span class="tooltiptext">Usuarios <i class="clean_usuario_filtro fas fa-times"></i></span>
							<select class="form-control" id="usuario_filtro" name="usuario_filtro">
								<option value=""> Cod Usuario -- Nombre Usuario </option>
							</select>
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
			<div class="tab-pane fade show active" id="contentPremiaciones" role="tabpanel">
				<?= getMensajeGestion('noResultados') ?>
			</div>
		</div>
	</div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcH2xfbm8z-5iSE4knkRJiNKRhKQrhH6E&callback=initMap"></script>