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

<div class="customizer border-left-blue-grey border-left-lighten-4 d-none d-xl-block">
	<a href="javascript:;" class="customizer-close"><i class="fal fa-times"></i></a>
	<a href="javascript:;" class="customizer-toggle box-shadow-3 bg-trade-visual-grad-left text-white">
		<i class="fal fa-cog fa-lg fa-spin"></i>
	</a>
	<div class="customizer-content p-2 ps-container ps-theme-dark" data-ps-id="aca1f25c-4ed9-a04b-d154-95a5d6494748">
		<form id="frm-visibilidad">
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
				<button type="button" class="btn btn-outline-trade-visual border-0" data-url="pdf" id="btn-visibilidad-pdf" title="PDF">
					<i class="fa fa-file-pdf"></i> <span class="txt_filtro"></span>
				</button>
			</div>
			<hr>
			<div class="customizer-content-filter">
				
				<div class="mb-2 mr-sm-2 position-relative form-group flt_sod">
					<div class="ui slider checkbox">
						<input type="checkbox" name="chk-nuevoFormatosod" id="chk-nuevoFormatosod">
						<label>Nuevo Formato</label>
					</div>
				</div>
				<div class="mb-2 mr-sm-2 position-relative form-group flt_soscat">
					<div class="ui slider checkbox">
						<input type="checkbox" name="chk-consolidado" id="chk-consolidado">
						<label>Consolidado</label>
					</div>
				</div>
				<div class="mb-2 mr-sm-2 position-relative form-group flt_soscat flt_sos flt_sod">
					<div class="ui slider checkbox">
						<input type="checkbox" name="chk-consolidado1q2q" id="chk-consolidado1q2q">
						<label>Consolidado 1Q - 2Q</label>
					</div>
				</div>

				<h5 class="mt-1 mb-1 text-bold-500"><i class="fal fa-table"></i> Filtros</h5>
				<div class="form-row">
					<div class="col-md-12">
						<div class="mb-2 mr-sm-2 position-relative form-group consolidado detallado">
							<div class="field">
								<div class="ui my_calendar">
									<div class="ui input left icon" style="width:100%">
										<i class="calendar icon"></i>
										<input type="text" name="txt-fechas" id="txt-fechas" placeholder="Date" value="<?= date("d/m/Y") . ' - ' . date("d/m/Y") ?>" class="form-control">
									</div>
								</div>
							</div>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip consolidado1q2q" >
							<span class="tooltiptext">Año</span>
							<select class="form-control my_select2Full"  name="anio" id="anio">
								<?=htmlSelectOptionArray2(['query'=>$anios,'id'=>'id','value'=>'nombre','selected'=>$tiempoHoy['anio']])?>
							</select>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip consolidado1q2q" >
							<span class="tooltiptext">Mes</span>
							<select class="form-control my_select2Full"  name="mes" id="mes">
								<?=htmlSelectOptionArray2(['query'=>$meses,'id'=>'id','value'=>'nombre','selected'=>$tiempoHoy['idMes']])?>
							</select>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia">
							<?= getFiltros(['cuenta' => ['label' => 'Cuenta', 'name' => 'cuenta_filtro', 'id' => 'cuenta_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia">
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
							<span class="tooltiptext">SubCanal</span>
							<?= getFiltros(['tipoCliente' => ['label' => 'Sub Canal', 'name' => 'subcanal_filtro', 'id' => 'subcanal_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]); ?>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip">
							<span class="tooltiptext">Elemento</span>
							<select id="idElemento" class="ui my_select2Full" name="idElemento" title="Elementos (Todo)">
								<option value="">-- Elemento --</option>
								<? foreach ($elementos as $row) { ?>
									<option value="<?= $row['idElementoVis'] ?>"><?= $row['nombre'] ?></option>
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

						<div class="mb-2 mr-sm-2 position-relative form-group chk_tipoReporte consolidado flt_sos" >
							<label for="chk-cadena"> Seleccionar Reporte: </label> <br>
							<div class="btn-group btn-group-toggle w-100 " data-toggle="buttons">
								<label class="btn btn-outline-secondary custom_tooltip">
									<span class="tooltiptextButton">Por Cadena</span>
									<input type="radio" name="chk-tipoReporte" id="chk-cadena" autocomplete="off" value="cadena"> Cadena </i>
								</label>
								<label class="btn btn-outline-secondary  custom_tooltip">
									<span class="tooltiptextButton">Por Tienda</span>
									<input type="radio" name="chk-tipoReporte" id="chk-tienda" autocomplete="off" checked="checked" value="tienda"> Tienda </i>
								</label>
							</div>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group chk_tipoReportecat flt_soscat" >
							<label for="chk-cadena"> Seleccionar Reporte: </label> <br>
							<div class="btn-group btn-group-toggle w-100 " data-toggle="buttons">
								<label class="btn btn-outline-secondary  custom_tooltip">
									<span class="tooltiptextButton">Por Tienda</span>
									<input type="radio" name="chk-tipoReporte-cat"  autocomplete="off" checked="checked" value="tienda"> Tienda </i>
								</label>
								<label class="btn btn-outline-secondary custom_tooltip">
									<span class="tooltiptextButton">Por Banner</span>
									<input type="radio" name="chk-tipoReporte-cat"  autocomplete="off" value="banner"> Banner </i>
								</label>
								<label class="btn btn-outline-secondary custom_tooltip">
									<span class="tooltiptextButton">Por Cadena</span>
									<input type="radio" name="chk-tipoReporte-cat"  autocomplete="off" value="cadena"> Cadena </i>
								</label>
								<label class="btn btn-outline-secondary custom_tooltip">
									<span class="tooltiptextButton">Por Cluster</span>
									<input type="radio" name="chk-tipoReporte-cat"  autocomplete="off" value="cluster"> Cluster </i>
								</label>
							</div>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group chk_tipoReporteConsolidadoSod flt_sod" >
							<label for="chk-cadena"> Seleccionar Reporte: </label> <br>
							<div class="btn-group btn-group-toggle w-100 " data-toggle="buttons">
								<label class="btn btn-outline-secondary custom_tooltip">
									<span class="tooltiptextButton">Por Marca</span>
									<input type="radio" name="chk-tipoReporte-sod"  autocomplete="off" value="marca"> Marca </i>
								</label>
								<label class="btn btn-outline-secondary  custom_tooltip">
									<span class="tooltiptextButton">Por Tienda</span>
									<input type="radio" name="chk-tipoReporte-sod" autocomplete="off" checked="checked" value="categoria"> Categoria </i>
								</label>
							</div>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group chk_tipoReporteNuevoSod flt_sod" >
							<label for="chk-cadena"> Seleccionar Reporte: </label> <br>
							<div class="btn-group btn-group-toggle w-100 " data-toggle="buttons">
								<label class="btn btn-outline-secondary custom_tooltip">
									<span class="tooltiptextButton">Por Tienda</span>
									<input type="radio" name="chk-tipoReporte-sod-nuevo"  autocomplete="off" value="tienda"> Tienda </i>
								</label>
								<label class="btn btn-outline-secondary  custom_tooltip">
									<span class="tooltiptextButton">Por Banner</span>
									<input type="radio" name="chk-tipoReporte-sod-nuevo" autocomplete="off" checked="checked" value="banner"> Banner </i>
								</label>
								<label class="btn btn-outline-secondary  custom_tooltip">
									<span class="tooltiptextButton">Por Cadena</span>
									<input type="radio" name="chk-tipoReporte-sod-nuevo" autocomplete="off"  value="cadena"> Cadena </i>
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
			<div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;">
				<div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
			</div>
			<div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px;">
				<div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div>
			</div>
		</form>
	</div>
</div>

<div class="main-card mb-3 card ">
	<div class="card-body p-0">
		<div class="tab-content" id="content-visib">
			<? foreach ($tabs as $k => $v) { ?>
				<div class="tab-pane fade <?= ($k == 0) ? 'show active' : '' ?>" id="<?= $v['contenedor'] ?>" role="tabpanel">
					<?= getMensajeGestion('noResultados') ?>
				</div>
			<? } ?>
		</div>
	</div>
</div>