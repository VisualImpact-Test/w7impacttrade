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
                        <li class="nav-item tabSeccion " id="seccion<?= $v['contenedor'] ?>" name="tipoReporte">
                            <a data-toggle="tab" href="#<?= $v['contenedor'] ?>" class="<?= ($v['orden'] == 1) ? 'active' : '' ?> nav-link" data-url="<?= $v['url'] ?>" data-contentdetalle="<?= $v['contenedor'] ?>"><?= $v['nombre'] ?></a>
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
        <form id="formFiltrosPrecios">
            <div class="card-header" style="margin-bottom: 14px;">
                <h4>CONFIGURACIÓN</h4>
            </div>
            <div>
                <input type="hidden" id="idTipoFormato" name="tipoFormato" value="1">
            </div>
            <div class="customizer-content-button">
                <button type="button" class="btn btn-outline-trade-visual border-0 secciones seccioncontentPrecios  btn-detallado" title="Consultar">
                    <i class="fa fa-search"></i> <span class="txt_filtro"></span>
                </button>
                <button type="button" class="btn btn-outline-trade-visual border-0 secciones seccioncontentVariabilidadPrecios  btn-precio-variabilidad" title="Consultar">
                    <i class="fa fa-search"></i> <span class="txt_filtro"></span>
                </button>
                <button type="button" class="btn btn-outline-trade-visual border-0 secciones seccioncontentDetalladoPrecios  btn-consultar" title="Consultar">
                    <i class="fa fa-search"></i> <span class="txt_filtro"></span>
                </button>
                <!-- <button type="button" class="btn btn-outline-trade-visual border-0 secciones seccioncontentPrecios btn-detalladoExcel" title="Detallado (Excel)">
                    <i class="fa fa-file-excel"></i> <span class="txt_filtro"></span>
                </button> -->
                <button type="button" class="btn btn-outline-trade-visual border-0 secciones seccioncontentFinanzas btn-reporteFinanzas " title="Reporte Finanzas">
                    <i class="fa fa-search"></i> <span class="txt_filtro"></span>
                </button>
            </div>
            <hr>
            <div class="customizer-content-filter">
                <h5 class="mt-1 mb-1 text-bold-500"><i class="fal fa-table"></i> Filtros</h5>
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="mb-2 mr-sm-2 position-relative form-group secciones seccioncontentPrecios seccioncontentFinanzas seccioncontentDetalladoPrecios">
                            <div class="field">
                                <div class="ui my_calendar">
                                    <div class="ui input left icon" style="width:100%">
                                        <i class="calendar icon"></i>
                                        <input type="text" name="txt-fechas" id="txt-fechas" placeholder="Date" value="<?= date("d/m/Y") . ' - ' . date("d/m/Y") ?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="seccioncontentPrecios seccioncontentDetalladoPrecios seccioncontentVariabilidadPrecios secciones">
                            <div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
                                <span class="tooltiptext">Grupo Canal</span>
                                <?= getFiltros(['grupoCanal' => ['label' => false, 'name' => 'grupoCanal_filtro', 'id' => 'grupoCanal_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
                            </div>
                            <div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
                                <span class="tooltiptext">Canal</span>
                                <?= getFiltros(['canal' => ['label' => 'Canal', 'name' => 'canal_filtro', 'id' => 'canal_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
                            </div>
                            <div class="filtros_secundarios">
                                <div class="filtros_generados">
                                    <h5 class="mt-1 mb-1 text-bold-500"><i class="fal fa-table"></i> Filtros Generados</h5>
                                </div>
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
                        <div class="seccioncontentPrecios secciones">
                            <div>
                                <h5 class="mt-1 mb-1 text-bold-500"><i class="fal fa-table"></i> Filtros Adicionales</h5>
                            </div>
                            <div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip">
                                <span class="tooltiptext">Tipo Usuario</span>
                                <select id="tipoUsuario" class="ui my_select2Full" name="tipoUsuario" title="Tipo Usuario">
                                    <option value="">-- Tipo Usuario --</option>
                                    <? foreach ($tipoUsuario as $row) { ?>
                                        <option value="<?= $row['idTipoUsuario'] ?>"><?= $row['nombre'] ?></option>
                                    <? } ?>
                                </select>
                            </div>
                            <div class="mb-2 mr-sm-2  position-relative form-group filtros_asistencia custom_tooltip">
                                <span class="tooltiptext">Usuarios <i class="clean_usuario_filtro fas fa-times"></i></span>
                                <select class="form-control" id="usuario_filtro" name="usuario_filtro">
                                    <option value=""> Cod Usuario -- Nombre Usuario </option>
                                </select>
                            </div>
                            
                            <div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip">
                                <span class="tooltiptext">Categoria</span>
                                <select id="categoria" class="ui my_select2Full" name="categoria" title="Categoria">
                                    <option value="">-- Categoría --</option>
                                    <? foreach ($categorias as $row) { ?>
                                        <option value="<?= $row['idCategoria'] ?>"><?= $row['nombre'] ?></option>
                                    <? } ?>
                                </select>
                            </div>
                            <div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip">
                                <span class="tooltiptext">Marca</span>
                                <select id="marca" class="ui my_select2Full" name="marca" title="Marca">
                                    <option value="">-- Marca --</option>
                                    <? foreach ($marcas as $row) { ?>
                                        <option value="<?= $row['idMarca'] ?>"><?= $row['nombre'] ?></option>
                                    <? } ?>
                                </select>
                            </div>
                            <div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip">
                                <span class="tooltiptext">Producto</span>
                                <select id="producto" class="ui my_select2Full" name="producto" title="Producto">
                                    <option value="">-- Producto --</option>
                                    <? foreach ($productos as $row) { ?>
                                        <option value="<?= $row['idProducto'] ?>"><?= $row['nombre'] ?></option>
                                    <? } ?>
                                </select>
                            </div>
                            <div class="mb-2 mr-sm-2 position-relative form-group chk_quiebres">
								<label for="ch-precio-inactivo"> Precios: </label> <br>
								<div class="btn-group btn-group-toggle w-50" data-toggle="buttons" >
									<label class="btn btn-outline-secondary custom_tooltip"> 
										<span class="tooltiptextButton">Sin Precio</span>
										<input type="checkbox" name="ch-precio-inactivo" id="ch-precio-inactivo" autocomplete="off" > NO </i>
									</label>
									<label class="btn btn-outline-secondary  custom_tooltip">
										<span class="tooltiptextButton">Con Precio</span>
										<input type="checkbox"  name="ch-precio-activo" id="ch-precio-activo" autocomplete="off" checked="checked"> SI </i>
									</label>
								</div>
							</div>
                        </div>
                        
                        <div class="seccioncontentVariabilidadPrecios secciones">
                            <hr>
                            <div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip">
                                <span class="tooltiptext">Año</span>
                                <select name="sl_anio" id="sl_anio" class="form-control">
                                    <?= htmlSelectOptionArray2(['query' => $anios, 'id' => 'anio', 'value' => 'anio']) ?>
                                </select>
                            </div>
                            <div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip">
                                <span class="tooltiptext">Semana</span>
                                <select name="sl_semanas" id="sl_semanas" class="form-control" multiple>
                                    <?
                                    $primera_semana = $semanaActual - 7;
                                    foreach ($nsemanas as $k => $v) { ?>
                                        <option value="<?= $v['idSemana'] ?>" <?= ($v['idSemana'] >= $primera_semana && $v['idSemana'] <= $semanaActual) ? 'selected' : '' ?>><?= $v['idSemana'] ?></option>
                                    <? } ?>
                                </select>
                            </div>
                            <div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
                                <span class="tooltiptext">Empresa</span>
                                <select class="form-control form-control-sm ui my_select2Full" name="empresa_filtro" id="empresa_filtro" patron="requerido">
                                    <?= htmlSelectOptionArray2(['query' => $empresas, 'id' => 'idEmpresa', 'value' => 'empresa', 'title' => '-- Empresa --']) ?>
                                </select>
                            </div>
                            <div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia categoria_filtro_content custom_tooltip">
                                <span class="tooltiptext">Categoria</span>
                                <select class="form-control form-control-sm ui my_select2Full" name="categoria_filtro" id="categoria_filtro" patron="requerido">
                                    <option value=""> -- Categoria --</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group seccioncontentPrecios seccioncontentFinanzas secciones">
                            <label>Producto:</label><br>
                            <div class="position-relative form-check form-check-inline">
                                <label class="form-check-label"><input type="checkbox" name="ch-competencia" value="pg" class="form-check-input"> P&G</label>
                            </div>
                            <div class="position-relative form-check form-check-inline">
                                <label class="form-check-label"><input type="checkbox" name="ch-competencia" value="competencia" class="form-check-input"> Competencia</label>
                            </div>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group">
                            <div class="seccioncontentFinanzas d-none " style="display:none">
                                <label>Agrupar:</label><br>
                                <div role="group" class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-outline-trade-visual active seccion"><input type="radio" name="rd-agrupacion" value="zona" disabled> Zona</label>
                                    <label class="btn btn-outline-trade-visual seccion"><input type="radio" name="rd-agrupacion" value="ciudad" checked="checked" disabled> Ciudad</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
                            <?= getFiltros(['cuenta' => ['label' => 'Cuenta', 'name' => 'cuenta_filtro', 'id' => 'cuenta_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
                            <?= getFiltros(['proyecto' => ['label' => 'Proyecto', 'name' => 'proyecto_filtro', 'id' => 'proyecto_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
                        </div>
                        <br>
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
        <div class="tab-content" id="content-auditoria">
            <? foreach ($tabs as $k => $v) { ?>
                <div class="tab-pane fade <?= ($v['orden'] == 1) ? 'show active' : '' ?>" id="<?= $v['contenedor'] ?>" role="tabpanel">
                    <?= getMensajeGestion('noResultados') ?>
                </div>
            <? } ?>
        </div>
    </div>
</div>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3"></script>