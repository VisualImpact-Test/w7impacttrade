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
                    <li class="nav-item btnReporte" name="tipoReporte">
                        <a data-toggle="tab" href="#tab-content-0" class="active nav-link" data-value="1">Cuenta</a>
                    </li>
                    <li class="nav-item btnReporte" name="tipoReporte">
                        <a data-toggle="tab" href="#tab-content-1" class="nav-link" data-value="2">Tipo Usuario Cuenta</a>
                    </li>
                    <li class="nav-item btnReporte" name="tipoReporte">
                        <a data-toggle="tab" href="#tab-content-2" class="nav-link" data-value="2">Proyecto</a>
                    </li>
                    <li class="nav-item btnReporte" name="tipoReporte">
                        <a data-toggle="tab" href="#tab-content-3" class="nav-link" data-value="3">Grupo Canal</a>
                    </li>
                    <li class="nav-item btnReporte" name="tipoReporte">
                        <a data-toggle="tab" href="#tab-content-4" class="nav-link" data-value="4">Canal</a>
                    </li>
                    <li class="nav-item btnReporte" name="tipoReporte">
                        <a data-toggle="tab" href="#tab-content-5" class="nav-link" data-value="5">Sub Canal</a>
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
        <form id="seccionFiltros">
            <div class="card-header" style="margin-bottom: 14px;">
                <h4>CONFIGURACIÓN</h4>
            </div>
            <div>
                <input type="hidden" id="idTipoFormato" name="tipoFormato" value="1">
            </div>
            <div class="customizer-content-button">
                <button type="button" class="btn btn-outline-trade-visual border-0 btn-Consultar" title="Filtrar">
                    <i class="fa fa-search"></i> <span class="txt_filtro"></span>
                </button>
                <button type="button" class="btn btn-outline-trade-visual border-0 btn-New-Foto" title="Agregar">
                    <i class="fa fa-plus"></i> <span class="txt_filtro"></span>
                </button>
                <button type="button" class="btn btn-outline-trade-visual border-0 btn-New" title="Agregar">
                    <i class="fa fa-plus"></i> <span class="txt_filtro"></span>
                </button>
                <button type="button" class="btn btn-outline-trade-visual border-0 btn-CargaMasiva d-none" title="Carga Masiva">
                    <i class="fal fa-lg fa-border-none"></i> <span class="txt_filtro"></span>
                </button>
                <button type="button" class="btn btn-outline-trade-visual border-0 btn-CambiarEstadoMultiple" data-estado="0" title="Activar">
                    <i class="fa fa-toggle-on"></i> <span class="txt_filtro"></span>
                </button>
                <button type="button" class="btn btn-outline-trade-visual border-0 btn-CambiarEstadoMultiple" data-estado="1" title="Desactivar">
                    <i class="fa fa-toggle-off"></i> <span class="txt_filtro"></span>
                </button>
            </div>
            <hr>
            <div class="customizer-content-filter">
                <h5 class="mt-1 mb-1 text-bold-500"><i class="fal fa-table"></i> Filtros</h5>
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia">
                            <?= getFiltros(['cuenta' => ['label' => 'Cuenta', 'name' => 'cuenta_filtro', 'id' => 'cuenta_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia">
                            <?= getFiltros(['proyecto' => ['label' => 'Proyecto', 'name' => 'proyecto_filtro', 'id' => 'proyecto_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group">
                            <select id="grupoFiltro" class="ui my_select2Full" name="grupoFiltro" title="Grupo">
                                <option value="">-- Grupo --</option>
                                <? foreach ($grupos as $row) { ?>
                                    <option value="<?= $row['idGrupo'] ?>"><?= $row['nombre'] ?></option>
                                <? } ?>
                            </select>
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
        <div class="tab-content" id="content-auditoria">
            <div class="tab-pane fade show active contentGestion" id="tab-content-0" role="tabpanel">
                <?= getMensajeGestion('noResultados') ?>
            </div>
            <div class="tab-pane fade show contentGestion" id="tab-content-1" role="tabpanel">
                <?= getMensajeGestion('noResultados') ?>
            </div>
            <div class="tab-pane fade show contentGestion" id="tab-content-2" role="tabpanel">
                <?= getMensajeGestion('noResultados') ?>
            </div>
            <div class="tab-pane fade show contentGestion" id="tab-content-3" role="tabpanel">
                <?= getMensajeGestion('noResultados') ?>
            </div>
            <div class="tab-pane fade show contentGestion" id="tab-content-4" role="tabpanel">
                <?= getMensajeGestion('noResultados') ?>
            </div>
            <div class="tab-pane fade show contentGestion" id="tab-content-5" role="tabpanel">
                <?= getMensajeGestion('noResultados') ?>
            </div>
        </div>
    </div>
</div>