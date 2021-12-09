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
                        <a data-toggle="tab" href="#tab-content-0" class="active nav-link" data-value="1">Gestor</a>
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
        <form id="seccionReprogramacion">
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
							<?= getFiltros(['cuenta' => ['label' => 'Cuenta', 'name' => 'idCuentaFiltro', 'id' => 'idCuentaFiltro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia">
							<?= getFiltros(['proyecto' => ['label' => 'Proyecto', 'name' => 'idProyectoFiltro', 'id' => 'idProyectoFiltro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
                        <div class="mb-2 mr-sm-2 position-relative form-group">
                            <select id="estadoReprogramacionFiltro" class="ui my_select2Full" name="estadoReprogramacionFiltro" title="Grupo">
                                <option value="">-- Estado Programacion --</option>
                                <option value='100'>Pendiente</option>
                                <? foreach ($estadosReprogramacion as $row) { ?>
                                    <option value="<?= $row['idEstadoReprogramacion'] ?>"><?= $row['nombre'] ?></option>
                                <? } ?>
                            </select>
                        </div>
                        <div class="mb-2 mr-sm-2 position-relative form-group chk_cesados">
							<label for="ch-quiebre-inactivo"> Estado Usuarios: </label> <br>
							<div class="btn-group btn-group-toggle w-100 " data-toggle="buttons">
								<label class="btn btn-outline-secondary custom_tooltip">
									<span class="tooltiptextButton">Usuarios Cesados</span>
									<input type="checkbox" name="chk-usuario-inactivo" id="chk-usuario-inactivo" autocomplete="off" checked="checked"> Cesados </i>
								</label>
								<label class="btn btn-outline-secondary  custom_tooltip">
									<span class="tooltiptextButton">Usuarios Vigentes</span>
									<input type="checkbox" name="chk-usuario-activo" id="chk-usuario-activo" autocomplete="off" checked="checked"> Activos </i>
								</label>
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
        <div class="tab-content" id="content-auditoria">
            <div class="tab-pane fade show active contentGestion" id="tab-content-0" role="tabpanel">
                <?= getMensajeGestion('noResultados') ?>
            </div>
        </div>
    </div>
</div>