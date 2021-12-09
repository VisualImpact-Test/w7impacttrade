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
					<li class="nav-item " id="nav-link-0"><a data-toggle="tab" href="#tab-content-0" class="active nav-link" data-value="1"> Rutas</a></li>
					<li class="nav-item "><a data-toggle="tab" id="nav-link-1" href="#tab-content-1" class="nav-link" data-value="2"> Visitas</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="customizer border-left-blue-grey border-left-lighten-4 d-none d-xl-block ">
	<a href="javascript:;" class="customizer-close"><i class="fal fa-times"></i></a>
	<a href="javascript:;" class="customizer-toggle box-shadow-3 bg-trade-visual-grad-left text-white">
		<i class="fal fa-cog  fa-spin"></i>
	</a>
	<div class="customizer-content p-2 ps-container ps-theme-dark" data-ps-id="aca1f25c-4ed9-a04b-d154-95a5d6494748">
		<form id="frm-rutasVisitas">
			<div class="card-header" style="margin-bottom: 14px;">
				<h4>CONFIGURACIÓN</h4>
			</div>
			<div class="customizer-content-button" style="min-height:80px;">
				<input type="hidden" name="tipoGestor" id="tipoGestor" value="1">
				<button id="btn-filtrarRutasVisitas" class="btn btn-outline-trade-visual border-0" data-url="filtrar" title="Filtrar">
					<i class="fas fa-search"></i>
				</button>
				<button id="btn-actualizarListas" class="btn btn-outline-trade-visual border-0" title="Actualizar Listas">
					<i class="fas fa-sync-alt"></i>
				</button>
				<!-- rutas -->
				<button id="btn-rutaCambiarEstado" class="btn btn-outline-trade-visual border-0" title="Cambiar Estado">
					<i class="fas fa-toggle-on"></i>
				</button>
				<button id="btn-rutaNuevo" class="btn btn-outline-trade-visual border-0" title="Nueva Ruta">
					<i class="fas fa-user-plus"></i>
				</button>
				<!--<button id="btn-rutaNuevoMasivo" class="btn btn-outline-trade-visual border-0" title="Nueva Ruta Masiva">
					<i class="fas fa-users"></i>
				</button>-->
				<button id="btn-rutaDuplicar" class="btn btn-outline-trade-visual border-0" title="Duplicar Ruta">
					<i class="fas fa-clone"></i>
				</button>
				<button id="btn-rutaReprogramar" class="btn btn-outline-trade-visual border-0" title="Reprogramar Ruta">
					<i class="fas fa-calendar-edit"></i>
				</button>
				<!-- visitas -->
				<button id="btn-visitaCambiarEstado" class="btn btn-outline-trade-visual border-0" title="Cambiar Estado" style="display:none;">
					<i class="fas fa-toggle-on"></i>
				</button>
				<button id="btn-visitaReprogramar" class="btn btn-outline-trade-visual border-0" title="Reprogramar Visita" style="display:none;">
					<i class="fas fa-random"></i>
				</button>
				<button id="btn-visitaCargaMasiva" class="btn btn-outline-trade-visual border-0" title="Carga Masiva Visita" style="display:none;">
					<i class="fas fa-layer-group"></i>
				</button>
				<button id="btn-visitaExcluir" class="btn btn-outline-trade-visual border-0" title="Excluir Visita" style="display:none;">
					<i class="fas fa-exclamation-circle"></i>
				</button>
				<button id="btn-visitaExcluirActivar" class="btn btn-outline-trade-visual border-0" title="Desactivar Exclusion" style="display:none;">
					<i class="fas fa-check-circle"></i>
				</button>

				<button id="btn-visitaContingencia" class="btn btn-outline-trade-visual border-0" title="HABILITAR CONTINGENCIA VISITA" style="display:none;"><i class="fas fa-user-clock"></i></button>
				<button id="btn-visitaContingenciaDes" class="btn btn-outline-trade-visual border-0" title="DESHABILITAR CONTINGENCIA VISITA" style="display:none;"><i class="fas fa-user-times"></i></button>
				<button id="btn-cargaMasivaRutas" class="btn btn-outline-trade-visual border-0" title="Carga masiva visitas excel" style=""><i class="fas fa-plus-square"></i></button>
				<button id="btn-cargaMasivaExclusiones" class="btn btn-outline-trade-visual border-0" title="Carga masiva exclusiones excel" style=""><i class="fas fa-plus-square"></i></button>
			</div>
			<div class="customizer-content-filter">
				<h5 class="mt-1 mb-1 text-bold-500"><i class="fal fa-table"></i> Filtros</h5>
				<div class="form-row">

					<div class="col-md-12">
						<div class="mb-2 mr-sm-2  position-relative form-group">
							<div class="field">
								<div class="ui my_calendar">
									<div class="ui input left icon" style="width:100%">
										<i class="calendar icon"></i>
										<input type="text" name="txt-fechas" id="txt-fechas" placeholder="Date" value="<?= date("d/m/Y") . ' - ' . date("d/m/Y") ?>" class="form-control">
									</div>
								</div>
							</div>
						</div>

						<div class="mb-2 mr-sm-2  position-relative form-group ">

							<select id="tipoUsuario_filtro" name="tipoUsuario_filtro" class="form-control form-control-sm my_select2Full sl-width-150">
								<option value="">-- Tipo Usuario --</option>
								<? foreach ($tipoUsuario as $key => $user) : ?>
									<option value="<?= $user['idTipoUsuario'] ?>"><?= $user['nombre'] ?></option>
								<? endforeach ?>
							</select>
						</div>
						<div class="mb-2 mr-sm-2  position-relative form-group ">

							<?= getFiltros(['cuenta' => ['label' => 'Cuenta', 'name' => 'cuenta_filtro', 'id' => 'cuenta_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2  position-relative form-group ">
							<?= getFiltros(['proyecto' => ['label' => 'Proyecto', 'name' => 'proyecto_filtro', 'id' => 'proyecto_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>

						<div class="mb-2 mr-sm-2  position-relative form-group " id="combo_grupocanal">
							<?= getFiltros(['grupoCanal' => ['label' => 'Grupo Canal', 'name' => 'grupo_filtro', 'id' => 'grupo_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2  position-relative form-group " id="combo_canal">
							<?= getFiltros(['canal' => ['label' => 'Canal', 'name' => 'canal_filtro', 'id' => 'canal_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>

						<div class="mb-2 mr-sm-2 position-relative form-group">
							<select id="usuario" name="usuario" class="ui my_select2Full" style="width:100%" title="Usuario">
								<option value="">-- Usuario --</option>
								<? foreach ($listaUsuarios as $key => $user) : ?>
									<option value="<?= $user['idUsuario'] ?>"><?= $user['nombreUsuario'] ?></option>
								<? endforeach ?>
							</select>
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


						<div class="mb-2 mr-sm-2 position-relative form-group">
							<input id="cod_usuario" name="cod_usuario" class="form-control" style="width:100%" title="CODIGO USUARIO" placeholder="CODIGO USUARIO">
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group">
							<input id="cod_cliente" name="cod_cliente" class="form-control" style="width:100%" title="CODIGO CLIENTE" placeholder="CODIGO CLIENTE">
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="main-card mb-3 card ">
	<div class="card-body p-0">
		<div class="tab-content" id="content-live-storecheckconf">
			<div class="tab-pane fade show active" id="tab-content-0" role="tabpanel">
				<?= getMensajeGestion('noResultados') ?>
			</div>
			<div class="tab-pane fade " id="tab-content-1" role="tabpanel">
				<?= getMensajeGestion('noResultados') ?>
			</div>
		</div>
	</div>
</div>