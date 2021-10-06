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
                        <a data-toggle="tab" href="#tab-content-0" class="active nav-link" data-value="1">Usuarios</a>
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
        <form id="seccionUsuarios">
            <div class="card-header" style="margin-bottom: 14px;">
                <h4>CONFIGURACIÓN</h4>
            </div>
            <div>
                <input type="hidden" id="idTipoFormato" name="tipoFormato" value="1">
            </div>
            <div class="customizer-content-button">
                <button type="button" class="btn btn-outline-trade-visual border-0 btn-Consultar" data-url="" id="btn-Consultar" title="Filtrar">
                    <i class="fa fa-search"></i> <span class="txt_filtro"></span>
                </button>
                <button type="button" class="btn btn-outline-trade-visual border-0 btn-CargaMasivaConCheck" data-url="" id="btn-CargaMasivaConCheck" title="Permisos Masivo">
                    <i class="fa fa-users"></i> <span class="txt_filtro"></span>
                </button>
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
                        <div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia">
                            <?= getFiltros(['cuenta' => ['label' => 'Cuenta', 'name' => 'idCuenta', 'id' => 'idCuenta', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia">
                            <?= getFiltros(['proyecto' => ['label' => 'Proyecto', 'name' => 'idProyecto', 'id' => 'idProyecto', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group">
                            <select id="tipoDocumentoFiltro" class="ui my_select2Full" name="tipoDocumentoFiltro" title="Tipo Documento">
                                <option value=''>-- Tipo Documento --</option>
                                <? foreach ($tiposDeDocumento as $tipoDeDocumento) { ?>
                                    <option value='<?= $tipoDeDocumento['idTipoDocumento'] ?>'><?= $tipoDeDocumento['breve'] ?></option>
                                <? } ?>
                            </select>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group">
                            <input id='numDocumentoFiltro' name='numDocumentoFiltro' type='text' class='form-control form-control-sm' placeholder='Num. Documento'>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group">
                            <input id='nombresApellidosFiltro' name='nombresApellidosFiltro' type='text' class='form-control form-control-sm' placeholder='Nombres y/o Apellidos'>
                        </div>
                        <? if ($this->session->idTipoUsuario == 4) { ?>
                            <div class='mb-2 mr-sm-2 position-relative form-group'>
                                <div class="form-check form-check-inline" id="usuariosActivos">
                                    <input id="checkUsuariosActivos" name="usuariosActivos" class="form-check-input" type="checkbox" value="1" checked>
                                    <label for="checkUsuariosActivos" class="form-check-label">Usuarios activos</label>
                                </div>
                            </div>
                        <? } ?>
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
			<div class="tab-pane fade show active" id="tab-content-0" role="tabpanel">
				<?= getMensajeGestion('noResultados') ?>
			</div>
		</div>
	</div>
</div>