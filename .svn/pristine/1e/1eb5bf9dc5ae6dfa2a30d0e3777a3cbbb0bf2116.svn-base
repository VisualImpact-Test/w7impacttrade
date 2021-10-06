<style>
    .my-custom-scrollbar {
        position: relative;
        height: 200px;
        overflow: auto;
    }

    .table-wrapper-scroll-y {
        display: block;
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
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab-content-1">Lista Categoría <small>(Marca Competencia)</small></a>
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
        <form id="seccionLista">
            <div class="card-header" style="margin-bottom: 14px;">
                <h4>CONFIGURACIÓN</h4>
            </div>
            <div>
                <input type="hidden" id="idTipoFormato" name="tipoFormato" value="2">
            </div>
            <div class="customizer-content-button">
                <button class="btn btn-outline-trade-visual border-0 btn-Consultar" data-url="filtrar" id="btn-consultar" title="Consultar">
                    <i class="fa fa-search"></i>
                </button>
                <button class="btn btn-outline-trade-visual border-0 btn-New" title="Agregar"><i class="fa fa-plus"></i></button>
                <button class="btn btn-outline-trade-visual border-0 btn-CargaMasiva" title="Carga Masiva"><i class="far fa-folder-plus"></i></button>
                <button class="btn btn-outline-trade-visual border-0 btn-CambiarEstadoMultiple" data-estado="0" title="Activar"><i class="far fa-toggle-on"></i></button>
                <button class="btn btn-outline-trade-visual border-0 btn-CambiarEstadoMultiple" data-estado="1" title="Desactivar"><i class="far fa-toggle-off"></i></button>
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
                        <div class="mb-2 mr-sm-2 position-relative form-group">
                            <?= getFiltros(['cuenta' => ['label' => 'Cuenta', 'name' => 'cuenta', 'id' => 'cuenta', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                        </div>

                        <div class="mb-2 mr-sm-2 position-relative form-group">
                            <!-- <label for='proyecto'>Proyecto</label><br> -->
                            <?= getFiltros(['proyecto' => ['label' => 'Proyecto', 'name' => 'proyecto', 'id' => 'proyecto', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group">
                            <!-- <label for='grupoCanal'>Grupo Canal</label><br> -->
                            <?= getFiltros(['grupoCanal' => ['label' => 'Grupo Canal', 'name' => 'sl_grupoCanal', 'id' => 'sl_grupoCanal', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                        </div>

                        <div class="mb-2 mr-sm-2 position-relative form-group">
                            <!-- <label for='canal'>Canal</label><br> -->
                            <?= getFiltros(['canal' => ['label' => 'Canal', 'name' => 'sl_canal', 'id' => 'sl_canal', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="main-card mb-3 card ">
    <div class="card-body p-0">
        <div class="tab-content" id="content-icompetitiva">
            <div class="tab-pane fade " id="tab-content-0" role="tabpanel">
                <?= getMensajeGestion('noResultados') ?>
            </div>
            <div class="tab-pane fade show active" id="tab-content-1" role="tabpanel">
                <?= getMensajeGestion('noResultados') ?>
            </div>
        </div>
    </div>
</div>