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
                        <a class="nav-link active" data-toggle="tab" href="#contentIniciativas">Principal</a>
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
        <form id="formFiltroIniciativas">
            <div class="card-header" style="margin-bottom: 14px;">
                <h4>CONFIGURACIÓN</h4>
            </div>
            <div>
                <input type="hidden" id="idTipoFormato" name="tipoFormato" value="2">
            </div>
            <div class="customizer-content-button">
                <button class="btn btn-outline-trade-visual border-0 btn-consultar" data-url="filtrar" id="btn-consultar" title="Consultar">
                    <i class="fa fa-search"></i>
                </button>
                <button class="btn btn-pdf btn-outline-trade-visual border-0" title=" PDF" ><i class="fa fa-file-pdf" aria-hidden="true"></i></button>
                <button class="btn btn-inhabilitar btn-outline-trade-visual border-0" title=" Inhabilitar" ><i class="fa fa-times" aria-hidden="true"></i></button>
                <button class="btn btn-validar btn-outline-trade-visual border-0" title=" Validar" ><i class="fa fa-check" aria-hidden="true"></i></button>
            </div>
            <hr>
            <div class="customizer-content-filter">
                <h5 class="mt-1 mb-1 text-bold-500"><i class="fal fa-table"></i> Filtros</h5>
                <div class="form-row">
                    <div class="col-md-12">

						<div class="mb-2 mr-sm-2 position-relative form-group">
							<label>Fotos:</label><br>
							<div role="group" class="btn-group btn-group-toggle" data-toggle="buttons">
								<label class="btn btn-outline-trade-visual border-0 active">
									<input type="radio" name="conFoto" value="todo" checked="checked">
									Todo
								</label>
                                <label class="btn btn-outline-trade-visual border-0">
									<input type="radio" name="conFoto" value="si">
									Si
								</label>
								<label class="btn btn-outline-trade-visual border-0">
									<input type="radio" name="conFoto" value="no">
									No
								</label>
							</div>
						</div>

                        <div class="mb-2 mr-sm-2 position-relative form-group">
							<label>Validado:</label><br>
							<div role="group" class="btn-group btn-group-toggle" data-toggle="buttons">
								<label class="btn btn-outline-trade-visual border-0 active">
									<input type="radio" name="validado" value="todo" checked="checked">
									Todo
								</label>
								<label class="btn btn-outline-trade-visual border-0">
									<input type="radio" name="validado" value="si">
									Si
								</label>
                                <label class="btn btn-outline-trade-visual border-0">
									<input type="radio" name="validado" value="no">
									No
								</label>
							</div>
						</div>

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

                        

                        <!-- <div class="mb-2 mr-sm-2 position-relative form-group">
							<label for="idDistribuidoraSucursal">Distribuidora Sucursal:</label>
							<div class="col-xs-10">
								<select class="selectpicker ui my_select2Full" id="idDistribuidoraSucursal" name="idDistribuidoraSucursal" title="Distribuidora Sucursal (Todo)" data-live-search="true" multiple data-actions-box="true">
									<?php foreach ($distribuidoras as $row) { ?>
										<option class="dropdown-item" value="<?= $row['idDistribuidoraSucursal'] ?>"><?= $row['distribuidoraSucursal'] ?></option>
									<? } ?>
								</select>
							</div>
						</div> -->
                        

                        <div class="mb-2 mr-sm-2 position-relative form-group filtros_iniciativa">
							<?= getFiltros(['cuenta' => ['label' => 'Cuenta', 'name' => 'cuenta_filtro', 'id' => 'cuenta_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_iniciativa">
							<?= getFiltros(['proyecto' => ['label' => 'Proyecto', 'name' => 'proyecto_filtro', 'id' => 'proyecto_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_iniciativa custom_tooltip">
							<span class="tooltiptext">Grupo Canal</span>
							<?= getFiltros(['grupoCanal' => ['label' => false, 'name' => 'grupoCanal_filtro', 'id' => 'grupoCanal_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_iniciativa custom_tooltip">
							<span class="tooltiptext">Canal</span>
							<?= getFiltros(['canal' => ['label' => 'Canal', 'name' => 'canal_filtro', 'id' => 'canal_filtro', 'data' => false, 'select2' => 'ui my_select2Full', 'html' => '']]) ?>
						</div>
						<div class="mb-2 mr-sm-2 position-relative form-group filtros_iniciativa custom_tooltip">
							<span class="tooltiptext">SubCanal</span>
							<?= getFiltros(['subCanal' => ['label' => 'Sub Canal', 'name' => 'subcanal_filtro', 'id' => 'subcanal_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '']]); ?>
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

						


                        <div class="mb-2 mr-sm-2 position-relative form-group">
							<label for="idElemento">Elementos:</label>
							<div class="col-xs-10">
								<select class="selectpicker ui my_select2Full" id="idElemento" name="idElemento" title="Elementos (Todo)" data-live-search="true" multiple data-actions-box="true">
									<?php foreach ($elementos as $row) { ?>
										<option class="dropdown-item" value="<?= $row['idElementoVis'] ?>"><?= $row['nombre'] ?></option>
									<? } ?>
								</select>
							</div>
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
		<div class="tab-content" id="content-iniciativas">
			<div class="tab-pane fade show active" id="contentIniciativas" role="tabpanel" >
				<?= getMensajeGestion('noResultados') ?>
			</div>
		</div>
	</div>
</div>
