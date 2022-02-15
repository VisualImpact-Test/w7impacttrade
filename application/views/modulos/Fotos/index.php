<div class="row mt-4">
    <div class="col-lg-2 d-flex justify-content-center align-items-center">
        <h4 class="card-title mb-3">
            <i class="<?= $icon ?>"></i>
            <?= $title ?>
        </h4>
    </div>
    <div class="col-lg-10 d-flex">
        <div class="card w-100 mb-3 p-0">
            <div class="card-body p-0">
                <ul class="nav nav-tabs nav-justified">
                    <li class="nav-item">
                        <a class="nav-link active btnReporte" data-toggle="tab" href="#tab-content-0" data-value="1">Detalle</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="customizer border-left-blue-grey border-left-lighten-4 d-none d-xl-block">
    <a href="javascript:;" class="customizer-close">
        <i class="fal fa-times"></i>
    </a>
    <a href="javascript:;" class="customizer-toggle box-shadow-3 bg-trade-visual-grad-left text-white">
        <i class="fal fa-cog fa-lg fa-spin"></i>
    </a>
    <div class="customizer-content p-3 ps-container ps-theme-dark">
        <form id="formFiltrosFotos">
            <h4>CONFIGURACIÓN</h4>
            <hr>
            <div class="customizer-content-button">
                <button type="button" class="btn btn-outline-trade-visual btn-buscar" data-url="filtrar" title="Filtrar">
                    <i class="fa fa-search"></i>
                </button>
                <button type="button" class="btn btn-outline-trade-visual btn-getFormExportarPdf" title="Exportar a PDF">
                    <i class="fal fa-file-pdf"></i>
                </button>
                <button type="button" class="btn btn-outline-trade-visual border-0" data-url="excel" id="btn-descargarExcel" title="Excel">
                    <i class="far fa-file-excel"></i> <span class="txt_filtro"></span>
                </button>
            </div>
            <hr>
            <div class="customizer-content-filter">
                <h5 class="mt-1 mb-1 text-bold-500"><i class="fal fa-table"></i> Filtros</h5>
                <div class="form-row">
                    <input type="hidden" name="tipoFormato" id="tipoFormato" value="1" />
                    <div class="col-md-12">
                        <div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip">
                            <div class="field">
                                <div class="ui my_calendar">
                                    <div class="ui input left icon" style="width:100%">
                                        <i class="calendar icon"></i>
                                        <input type="text" id="txt-fechas" class="form-control" name="txt-fechas" value="<?= date("d/m/Y") . ' - ' . date("d/m/Y") ?>" placeholder="Date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip">
                            <?= getFiltros(['cuenta' => ['select2' => 'my_select2Full']]); ?>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip">
                            <?= getFiltros(['proyecto' => ['label' => 'Proyecto', 'name' => 'proyecto_filtro', 'id' => 'proyecto_filtro', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip">
                            <span class="tooltiptext">Grupo Canal</span>
                            <?= getFiltros(['grupoCanal' => ['label' => false, 'name' => 'grupoCanal_filtro', 'id' => 'grupoCanal_filtro', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip">
                            <span class="tooltiptext">Canal</span>
                            <?= getFiltros(['canal' => ['label' => 'Canal', 'name' => 'canal_filtro', 'id' => 'canal_filtro', 'data' => false, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip">
                            <span class="tooltiptext">Canal</span>
                            <?= getFiltros(['tipoCliente' => ['label' => 'Subcanal', 'name' => 'idClienteTipo', 'id' => 'idClienteTipo', 'data' => false, 'select2' => 'my_select2Full', 'html' => '']]) ?>
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

                        <div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip">
                            <span class="tooltiptext">Tipo Foto</span>
                            <select class="pt-0 custom-select my_select2Full" name="tipoFoto" id="tipoFoto">
                                <option value="">-- Tipo Foto --</option>
                                <?php foreach ($tipoFotos as $row) { ?>
                                    <option value="<?= $row['idTipoFoto'] ?>"><?= $row['nombre'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip">
                            <span class="tooltiptext">Modulo</span>
                            <select class="pt-0 custom-select my_select2Full" name="tipoModulo" id="tipoModulo">
                                <?=htmlSelectOptionArray($modulos)?>
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
								<div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip">
									<div class="field">
										<input type="text" id="codCliente" class="form-control" name="codCliente" value="" placeholder="Cod. Cliente">
									</div>
								</div>
								<div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip">
									<div class="field">
										<input type="text" id="codVisual" class="form-control" name="codVisual" value="" placeholder="Cod. Visual">
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

<div id="fotosContent" class="row">
    <div class="col-md-12">
        <div class="card mb-3">
            <div class="card-body">
                <?= getMensajeGestion('noResultados') ?>
            </div>
        </div>
    </div>
</div>