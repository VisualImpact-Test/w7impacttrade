<div class="row mt-4">
    <div class="col-lg-3 d-flex justify-content-center align-items-center">
        <h3 class="card-title mb-3">
            <i class="<?= $icon ?>"></i>
            <?= $title ?>
        </h3>
    </div>
    <div class="col-lg-9 d-flex">
        <div class="card w-100 mb-3 p-0">
            <div class="card-body p-0">
                <ul class="nav nav-tabs nav-justified">
                    <li class="nav-item">
                        <a class="nav-link active btnReporte" data-toggle="tab" href="#idDivResumen" data-value="1">Resumen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btnReporte" data-toggle="tab" href="#idDivCobertura" data-value="2">Cobertura</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btnReporte" data-toggle="tab" href="#idDivServicio" data-value="3">Servicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btnReporte" data-toggle="tab" href="#idDivRecuperacion" data-value="4">Recuperacion SPOC</a>
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
    <div class="customizer-content p-3 ps-container ps-theme-dark" data-ps-id="aca1f25c-4ed9-a04b-d154-95a5d6494748">
        <form id="frm-servicioCobertura">
            <h4>CONFIGURACIÓN</h4>
            <hr>
            <div class="customizer-content-button">
                <button type="button" class="btn btn-outline-trade-visual border-0" data-url="filtrar" id="btn-filtrarServicioCobertura" title="Filtrar">
                    <i class="fa fa-search"></i> <span class="txt_filtro"></span>
                </button>
                <button type="button" class="btn btn-outline-trade-visual border-0" data-url="filtrar" id="btn-actualizarData" title="Refrescar Data">
                    <i class="fa fa-sync"></i> <span class="txt_filtro"></span>
                </button>
            </div>
            <hr>
            <div class="customizer-content-filter">
                <h5 class="mt-1 mb-1 text-bold-500"><i class="fal fa-table"></i> Filtros</h5>
                <div class="form-row">
                    <input type="hidden" name="tipoFormato" id="tipoFormato" value="1" />
                    <div class="col-md-12">
                        <div class="mb-2 mr-sm-2 position-relative form-group filtros_servicioCobertura custom_tooltip">
                            <span class="tooltiptext">Año</span>
                            <select class="form-control ui my_select2Full" id="anno_filtro" name="anno_filtro">
                                <option value="2022" <?= date("Y") == "2022" ? "selected" : "" ?>> 2022 </option>
                                <option value="2021" <?= date("Y") == "2021" ? "selected" : "" ?>> 2021 </option>
                                <option value="2020" <?= date("Y") == "2020" ? "selected" : "" ?>> 2020 </option>
                            </select>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group filtros_servicioCobertura custom_tooltip">
                            <span class="tooltiptext">Mes</span>
                            <select class="form-control ui my_select2Full" id="mes_filtro" name="mes_filtro">
                                <option value="01" <?= date("m") == "01" ? "selected" : "" ?> >Enero</option>
                                <option value="02" <?= date("m") == "02" ? "selected" : "" ?> >Febrero</option>
                                <option value="03" <?= date("m") == "03" ? "selected" : "" ?> >Marzo</option>
                                <option value="04" <?= date("m") == "04" ? "selected" : "" ?> >Abril</option>
                                <option value="05" <?= date("m") == "05" ? "selected" : "" ?> >Mayo</option>
                                <option value="06" <?= date("m") == "06" ? "selected" : "" ?> >Junio</option>
                                <option value="07" <?= date("m") == "07" ? "selected" : "" ?> >Julio</option>
                                <option value="08" <?= date("m") == "08" ? "selected" : "" ?> >Agosto</option>
                                <option value="09" <?= date("m") == "09" ? "selected" : "" ?> >Septiembre</option>
                                <option value="10" <?= date("m") == "10" ? "selected" : "" ?> >Octubre</option>
                                <option value="11" <?= date("m") == "11" ? "selected" : "" ?> >Noviembre</option>
                                <option value="12" <?= date("m") == "12" ? "selected" : "" ?> >Diciembre</option>
                            </select>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group filtros_servicioCobertura custom_tooltip">
                            <span class="tooltiptext">Quincena</span>
                            <select class="form-control ui my_select2Full" id="quincena_filtro" name="quincena_filtro">
                                <option value="1" <?= date("d") <= 15 ? "selected" : "" ?>>Primera Quincena</option>
                                <option value="2" <?= date("d") > 15 ? "selected" : "" ?>>Segunda Quincena</option>
                            </select>
                        </div>
                        <!-- <div class="mb-2 mr-sm-2  position-relative form-group">
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
                        <div class="mb-2 mr-sm-2  position-relative form-group filtros_servicioCobertura">

                            <?= getFiltros(['cuenta' => ['label' => 'Cuenta', 'name' => 'cuenta_filtro', 'id' => 'cuenta_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
                        </div>
                        <div class="mb-2 mr-sm-2  position-relative form-group filtros_servicioCobertura">
                            <?= getFiltros(['proyecto' => ['label' => 'Proyecto', 'name' => 'proyecto_filtro', 'id' => 'proyecto_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
                        </div>

                        <div class="mb-2 mr-sm-2  position-relative form-group filtros_servicioCobertura custom_tooltip">
                            <span class="tooltiptext">Grupo Canal</span>
                            <?= getFiltros(['grupoCanal' => ['label' => 'Grupo Canal', 'name' => 'grupo_filtro', 'id' => 'grupo_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
                        </div>
                    </div>
                </div>

                <!-- <div id="dv-leyenda">
                    <hr>
                    <h5 class="mt-1 text-bold-500"><i class="far fa-info-circle"></i> Leyenda</h5>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox mb-1">
                            <input type="checkbox" class="custom-control-input" id="ckb-todos" name="ckb-todos" checked="">
                            <label class="custom-control-label" for="ckb-todos"><span class="color-C"><i class="fa fa-circle"></i></span> Todo </label>
                        </div>
                        <div class="custom-control custom-checkbox mb-1">
                            <input type="checkbox" class="custom-control-input filtroCondicion" id="ckb-completa" name="ckb-completa" value="C" checked data-name="completa">
                            <label class="custom-control-label" for="ckb-completa"> <span class="color-C"><i class="fa fa-circle"></i></span> Completa (C)</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-1">
                            <input type="checkbox" class="custom-control-input filtroCondicion" id="ckb-incompleta" name="ckb-incompleta" value="I" checked data-name="incomp">
                            <label class="custom-control-label" for="ckb-incompleta"><span class="color-I"><i class="fa fa-circle"></i></span> Incompleta (I)</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-1">
                            <input type="checkbox" class="custom-control-input filtroCondicion" id="ckb-falta" name="ckb-falta" value="F" checked data-name="falta">
                            <label class="custom-control-label" for="ckb-falta"><span class="color-F"><i class="fa fa-circle"></i></span> Falta (F)</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-1">
                            <input type="checkbox" class="custom-control-input filtroCondicion" id="ckb-ocurrencia" name="ckb-ocurrencia" value="O" checked data-name="ocurrencia">
                            <label class="custom-control-label" for="ckb-ocurrencia"><span class="color-O"><i class="fa fa-circle"></i></span> Ocurrencia (O)</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-1">
                            <input type="checkbox" class=" custom-control-input filtroCondicion" id="ckb-vacaciones" name="ckb-vacaciones" value="V" checked data-name="vacaciones">
                            <label class="custom-control-label" for="ckb-vacaciones"><span class="color-V"><i class="fa fa-circle"></i></span> Vacaciones (V)</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-1">
                            <input type="checkbox" class=" custom-control-input filtroCondicion" id="ckb-feriado" name="ckb-feriado" value="Fe" checked data-name="feriado">
                            <label class="custom-control-label" for="ckb-feriado"><span class="color-Fe"><i class="fa fa-circle"></i></span> Feriado (Fe)</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-1">
                            <input type="checkbox" class=" custom-control-input filtroCondicion" id="ckb-nolaborable" name="ckb-nolaborable" value="NL" checked data-name="NL">
                            <label class="custom-control-label" for="ckb-nolaborable"><span class="color-NL"><i class="fa fa-circle"></i></span> No Laborable NL </label>
                        </div>
                    </div>
                </div> -->
            </div>
        </form>
    </div>
</div>

<div class="main-card mb-3 card div-para-ocultar">
    <div class="card-body p-0">
        <div class="tab-content" id="content-auditoria">
            <div class="tab-pane fade show active contentGestion" id="idDivResumen" role="tabpanel">
                <?= getMensajeGestion('noResultados') ?>
            </div>
            <div class="tab-pane fade show contentGestion" id="idDivCobertura" role="tabpanel">
                <?= getMensajeGestion('noResultados') ?>
            </div>
            <div class="tab-pane fade show contentGestion" id="idDivServicio" role="tabpanel">
                <?= getMensajeGestion('noResultados') ?>
            </div>
            <div class="tab-pane fade show contentGestion" id="idDivRecuperacion" role="tabpanel">
                <?= getMensajeGestion('noResultados') ?>
            </div>
        </div>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcH2xfbm8z-5iSE4knkRJiNKRhKQrhH6E&callback=initMap"></script>
<script type="text/javascript" src="assets/libs/anychart/anychart-base.min.js"></script>