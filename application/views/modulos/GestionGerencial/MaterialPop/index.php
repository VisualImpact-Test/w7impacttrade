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
					<li class="nav-item btnReporte" id="tipoReporte" name="tipoReporte">
						<a data-toggle="tab" href="#idContentMaterialPop" class="active nav-link" data-contentdetalle="idContentMaterialPop"  data-url="filtrar">Detallado</a>
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
		<form id="frm-material-pop">
			<div class="card-header" style="margin-bottom: 14px;">
				<h4>CONFIGURACIÓN</h4>
			</div>
			<div>
				<input type="hidden" id="idTipoFormato" name="tipoFormato" value="1">
			</div>
			<div class="customizer-content-button">
				<button type="button" class="btn btn-outline-trade-visual border-0" data-url="filtrar" id="btn-filtrar" title="Filtrar">
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
							<div class="filtros_generados">
								<h5 class="mt-1 mb-1 text-bold-500 " ><i class="fal fa-table"></i> Filtros Generados</h5>
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
			</div>
		</form>
	</div>
</div>

<div class="main-card mb-3 card ">
	<div class="card-body p-0">
		<div class="tab-content" id="content-material-pop">
			<div class="tab-pane fade show active" id="idContentMaterialPop" role="tabpanel">
				<?= getMensajeGestion('noResultados') ?>
			</div>
		</div>
	</div>
</div>
