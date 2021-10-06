<style>
    .nav {
        overflow-x: auto !important;
        overflow-y: hidden;
        white-space: nowrap !important;
        flex-wrap: inherit !important;
    }
    .nav.nav-tabs .active {
    border: 0;
    border-bottom: 3px solid #e2001a;
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
                        <a class="nav-link active" data-toggle="tab" href="#tab-content-0">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#tab-content-4">Marcas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-content-7">Categorias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-content-8">Motivos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#tab-content-1">Lista Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#tab-content-2">Precio Sugerido</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#tab-content-3">Configuración de Precios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#tab-content-5">Unidad Medida Producto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#tab-content-6">Surtido</a>
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
        <form id="formFiltroProductos">
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
                            <?= getFiltros(['cuenta' => ['label' => 'Cuenta', 'name' => 'cuenta', 'id' => 'cuenta', 'data' => true, 'select2' => 'my_select2Full ', 'html' => '']]) ?>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group">
                            <?= getFiltros(['proyecto' => ['label' => 'Proyecto', 'name' => 'proyecto', 'id' => 'proyecto', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group dv_grupoCanal">
                            <?= getFiltros(['grupoCanal' => ['label' => 'Grupo Canal', 'name' => 'sl_grupoCanal', 'id' => 'sl_grupoCanal', 'data' => true, 'select2' => 'my_select2Full ', 'html' => '']]) ?>
                        </div>

                        <div class="mb-2 mr-sm-2 position-relative form-group dv_canal">
                            <?= getFiltros(['canal' => ['label' => 'Canal', 'name' => 'sl_canal', 'id' => 'sl_canal', 'select2' => 'my_select2Full fl_canal', 'html' => '']]) ?>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group dv_cadena">
                            <?= getFiltros(['cadena' => ['label' => 'Cadena', 'name' => 'sl_cadena', 'id' => 'sl_cadena', 'data' => true, 'select2' => 'my_select2Full ', 'html' => '']]) ?>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group dv_banner">
                            <?= getFiltros(['banner' => ['label' => 'Banner', 'name' => 'sl_banner_filtro', 'id' => 'sl_banner_filtro', 'select2' => 'my_select2Full ', 'html' => '']]) ?>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </form>
</div>

<div class="main-card mb-3 card ">
    <div class="card-body p-0">
        <div class="tab-content" id="content-productos">
            <div class="tab-pane fade show active" id="tab-content-0" role="tabpanel">
                <?= getMensajeGestion('noResultados') ?>
            </div>
            <div class="tab-pane fade" id="tab-content-1" role="tabpanel">
                <?= getMensajeGestion('noResultados') ?>
            </div>
            <div class="tab-pane fade " id="tab-content-2" role="tabpanel">
                <?= getMensajeGestion('noResultados') ?>
            </div>
            <div class="tab-pane fade" id="tab-content-3" role="tabpanel">
                <?= getMensajeGestion('noResultados') ?>
            </div>
            <div class="tab-pane fade" id="tab-content-4" role="tabpanel">
                <?= getMensajeGestion('noResultados') ?>
            </div>
            <div class="tab-pane fade" id="tab-content-5" role="tabpanel">
                <?= getMensajeGestion('noResultados') ?>
            </div>
            <div class="tab-pane fade" id="tab-content-6" role="tabpanel">
                <?= getMensajeGestion('noResultados') ?>
            </div>
            <div class="tab-pane fade" id="tab-content-7" role="tabpanel">
                <?= getMensajeGestion('noResultados') ?>
            </div>
            <div class="tab-pane fade" id="tab-content-8" role="tabpanel">
                <?= getMensajeGestion('noResultados') ?>
            </div>
        </div>
    </div>
</div>