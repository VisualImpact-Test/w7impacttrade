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
                    <li class="nav-item">
                        <a class="nav-link active btnReporte" data-toggle="tab" href="#tab-content-0" data-value="1">Principal</a>
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
    <div class="customizer-content p-3 ps-container ps-theme-dark">
        <form id="formFiltroStorecheck">
            <h4>CONFIGURACIÓN</h4>
            <hr>
            <div class="customizer-content-button">
                <button type="button" class="btn btn-outline-trade-visual border-0 btn-consultar" data-url="filtrar" id="btn-filtrarAsistencia" title="Filtrar">
                    <i class="fa fa-search"></i> <span class="txt"></span>
                </button>
                <button type="button" class="btn btn-outline-trade-visual border-0 btn-getPuntosDeVenta" title="Obtener puntos de venta">
                    <i class="fas fa-arrow-alt-circle-down"></i> <span class="txt"></span>
                </button>
            </div>
            <hr>
            <div class="customizer-content-filter">
                <h5 class="mt-1 mb-1 text-bold-500"><i class="fal fa-table"></i> Filtros</h5>
                <div class="form-row">
                    <input type="hidden" name="tipoFormato" id="tipoFormato" value="1" />
                    <div class="col-md-12">
                        <!-- <div class="mb-2 mr-sm-2 position-relative form-group">
                            <div class="field">
                                <div class="ui my_calendar">
                                    <div class="ui input left icon" style="width:100%">
                                        <i class="calendar icon"></i>
                                        <input type="text" name="txt-fechas" id="txt-fechas" placeholder="Date" value="<?= date("d/m/Y") . ' - ' . date("d/m/Y") ?>" class="form-control">
                                        <input type="text" name="txt-fechas_simple" id="txt-fechas_simple" placeholder="Date" value="<?= date("d/m/Y") . ' - ' . date("d/m/Y") ?>" class="form-control d-none">
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="mb-2 mr-sm-2 position-relative form-group">
                            <select id='idMes' name='idMes' class='form-control form-control-sm my_select2Full'>
                                <option value="">-- Mes --</option>
                                <option value="01">Enero</option>
                                <option value="02">Febrero</option>
                                <option value="03">Marzo</option>
                                <option value="04">Abril</option>
                                <option value="05">Mayo</option>
                                <option value="06">Junio</option>
                                <option value="07">Julio</option>
                                <option value="08">Agosto</option>
                                <option value="09">Setiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group">
                            <? $anioProyecto = 2020;
                            $anioActual = (int) date("Y");
                            ?>
                            <select class="form-control form-control-sm my_select2" id="idAnio" name="idAnio">
                                <option value="">-- Año --</option>
                                <option value="<?= $anioActual ?>"><?= $anioActual ?></option>
                                <?php
                                while ($anioActual != $anioProyecto) {
                                    $anioActual--; ?>
                                    <option value="<?= $anioActual ?>"><?= $anioActual ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia">
                            <?= getFiltros(['cuenta' => ['label' => 'Cuenta', 'name' => 'cuenta', 'id' => 'cuenta', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia">
                            <?= getFiltros(['proyecto' => ['label' => 'Proyecto', 'name' => 'proyecto', 'id' => 'proyecto', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
                        </div>

                        <div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
                            <span class="tooltiptext">Grupo Canal</span>
                            <?= getFiltros(['grupoCanal' => ['label' => false, 'name' => 'grupoCanal', 'id' => 'grupoCanal', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
                            <span class="tooltiptext">Canal</span>
                            <?= getFiltros(['canal' => ['label' => 'Canal', 'name' => 'canal', 'id' => 'canal', 'data' => false, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
                            <span class="tooltiptext">Punto de Venta</span>
                            <select id='idPuntoDeVenta' name='idPuntoDeVenta' class='form-control form-control-sm my_select2Full'>
                                <option value="">-- Seleccione --</option>
                            </select>
                        </div>
                        <div class="filtros_secundarios">
                            <div class="filtros_generados">
                                <h5 class="mt-1 mb-1 text-bold-500"><i class="fal fa-table"></i> Filtros Generados</h5>
                                <div class="filtros_gc filtros_HFS d-none">
                                    <div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
                                        <span class="tooltiptext">Distribuidora</span>
                                        <?= getFiltros(['distribuidora' => ['label' => 'Distribuidora', 'name' => 'distribuidora', 'id' => 'distribuidora', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]); ?>
                                    </div>
                                    <div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
                                        <span class="tooltiptext">Sucursal</span>
                                        <?= getFiltros(['distribuidoraSucursal' => ['label' => 'Sucursal', 'name' => 'distribuidoraSucursal', 'id' => 'distribuidoraSucursal', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]); ?>
                                    </div>
                                    <div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
                                        <span class="tooltiptext">Zona</span>
                                        <?= getFiltros(['zona' => ['label' => 'Zona', 'name' => 'zona', 'id' => 'zona', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]); ?>
                                    </div>
                                </div>
                                <div class="filtros_gc filtros_WHLS d-none">
                                    <div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
                                        <span class="tooltiptext">Plaza</span>
                                        <?= getFiltros(['plaza' => ['label' => 'Plaza', 'name' => 'plaza', 'id' => 'plaza', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]); ?>
                                    </div>
                                </div>
                                <div class="filtros_gc filtros_HSM filtros_Moderno d-none">
                                    <div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
                                        <span class="tooltiptext">Cadena</span>
                                        <?= getFiltros(['cadena' => ['label' => 'Cadena', 'name' => 'cadena', 'id' => 'cadena', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]); ?>
                                    </div>
                                    <div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia custom_tooltip">
                                        <span class="tooltiptext">Banner</span>
                                        <?= getFiltros(['banner' => ['label' => 'Banner', 'name' => 'banner', 'id' => 'banner', 'data' => false, 'select2' => 'ui my_select2Full', 'html' => '']]); ?>
                                    </div>
                                </div>

                                <div class="filtros_gc">
                                    <?= getFiltros(['zonaUsuario' => ['label' => 'zonausuario', 'name' => 'zonausuario', 'id' => 'zonausuario', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="main-card mb-3 card div-para-ocultar">
    <div class="card-body p-0">
        <div class="tab-content" id="content-auditoria">
            <div class="tab-pane fade show active tipoDetallado" id="contentStorecheck" role="tabpanel">
                <?= getMensajeGestion('noResultados') ?>
            </div>
        </div>
    </div>
</div>