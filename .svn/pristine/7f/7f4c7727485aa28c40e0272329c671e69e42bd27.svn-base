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
                    <li class="nav-item " ><a data-toggle="tab" href="#contentElemento" id="nav-link-0" class="active nav-link" data-value="0" > Elemento</a></li>
					<li class="nav-item " ><a data-toggle="tab" href="#contentLista" class="nav-link" data-value="1" > Lista Elemento Visibilidad Obligatoria</a></li>
                    <li class="nav-item " ><a data-toggle="tab" href="#contentListaModulacion" class="nav-link" data-value="2" > Lista Elementos Modulacion</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="customizer border-left-blue-grey border-left-lighten-4 d-none d-xl-block ">
	<a href="javascript:;" class="customizer-close"><i class="fal fa-times"></i></a>
	<a href="javascript:;" class="customizer-toggle box-shadow-3 bg-trade-visual-grad-left text-white">
		<i class="fal fa-cog fa-lg fa-spin"></i>
	</a>
	<div class="customizer-content p-2 ps-container ps-theme-dark" data-ps-id="aca1f25c-4ed9-a04b-d154-95a5d6494748">
		<form id="frm-auditoria">
			<div class="card-header" style="margin-bottom: 14px;">
				<h4>CONFIGURACIÓN</h4>
			</div>
			<div class="customizer-content-button">
                <button class="btn btn-outline-trade-visual border-0 btn-Consultar" title="Filtrar"><i class="fa fa-search"></i></button>
                <button class="btn btn-outline-trade-visual border-0 btn-New" title="Agregar"><i class="fa fa-plus"></i></button>
                <button class="btn btn-outline-trade-visual border-0 btn-CargaMasiva" title="Carga Masiva"><i class="fas fa-folder-plus"></i></button>
				<button class="btn btn-outline-trade visual border-0 btn-CargaMasiva-modulacion" title="Carga Masiva"><i class="fas fa-folder-plus"></i></button>
                <button class="btn btn-outline-trade-visual border-0 btn-CambiarEstadoMultiple" data-estado="0" title="Activar"><i class="fa fa-toggle-on"></i></button>
                <button class="btn btn-outline-trade-visual border-0 btn-CambiarEstadoMultiple" data-estado="1" title="Desactivar"><i class="fa fa-toggle-off"></i></button>
			</div>
            <div class="customizer-content-filter">
				<h5 class="mt-1 mb-1 text-bold-500"><i class="fal fa-table"></i> Filtros</h5>
				<div class="form-row">
                    <div class="col-md-12" id="tab-content-1-filter">
                        <div class="mb-2 mr-sm-2  position-relative form-group ">
                            <?= getFiltros(['cuenta' => ['label' => 'Cuenta', 'name' => 'cuenta', 'id' => 'cuenta', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                        </div>
                        <div class="mb-2 mr-sm-2  position-relative form-group ">
                            <?= getFiltros(['proyecto' => ['label' => 'Proyecto', 'name' => 'proyecto', 'id' => 'proyecto', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                        </div>
                        <div class="mb-2 mr-sm-2  position-relative form-group ">
                            <?= getFiltros(['grupoCanal' => ['label' => 'Grupo Canal', 'name' => 'grupoCanal', 'id' => 'grupoCanal', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                        </div>
                        <div class="mb-2 mr-sm-2  position-relative form-group ">
                            <?= getFiltros(['canal' => ['label' => 'Canal', 'name' => 'canal', 'id' => 'canal', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                        </div>
                        
                    </div>
                </div>
            </div>
		</form>
	</div>
</div>




<div class="main-card mb-3 card ">
	<div class="card-body p-0">
		<div class="tab-content" id="content-live-storecheckconf">
			<div class="tab-pane fade show active" id="contentElemento" role="tabpanel" >
				<?= getMensajeGestion('noResultados') ?>
			</div>
			<div class="tab-pane fade " id="contentLista" role="tabpanel" >
				<?= getMensajeGestion('noResultados') ?>
			</div>
			<div class="tab-pane fade " id="contentListaModulacion" role="tabpanel" >
				<?= getMensajeGestion('noResultados') ?>
			</div>
		</div>
	</div>
</div>