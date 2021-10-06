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
                            <div class="field">
                                <input type="text" id="codCliente" class="form-control" name="codCliente" value="" placeholder="Cod. Cliente">
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
                            <span class="tooltiptext">Tipo Foto</span>
                            <select class="pt-0 custom-select my_select2Full" name="tipoFoto" id="tipoFoto">
                                <option value="">-- Tipo Foto --</option>
                                <?php foreach ($tipoFotos as $row) { ?>
                                    <option value="<?= $row['idTipoFoto'] ?>"><?= $row['nombre'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group custom_tooltip">
                            <span class="tooltiptext">Tipo Cliente</span>
                            <select class="pt-0 custom-select my_select2Full" name="idClienteTipo" id="idClienteTipo">
                                <option value="">-- Tipo Cliente --</option>
                                <?php foreach ($tipoCliente as $row) { ?>
                                    <option value="<?= $row['idClienteTipo'] ?>"><?= $row['nombre'] ?></option>
                                <?php } ?>
                            </select>
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