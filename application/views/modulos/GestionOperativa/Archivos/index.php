<div class="row">
    <div class="col-12">
        <div class="mb-3 card">
            <div class="card-header-tab card-header">
                <ul class="nav">
                    <li class="nav-item"><a data-toggle="tab" href="#tab-content-0" class="active nav-link">Archivos</a></li>
                </ul>
                <ul class="nav">
                    <li class="nav-item"><a data-toggle="tab" href="#tab-content-1" class="nav-link">Carpetas</a></li>
                </ul>
                <div class="funciones">
                    <button class="btn btn-outline-trade-visual border-0 btn-Consultar" title="Buscar"><i class="fa fa-search"></i></button>
                    <button class="btn btn-outline-trade-visual border-0 btn-NewArchivo" title="Agregar"><i class="fa fa-plus"></i></button>
                    <button class="btn btn-outline-trade-visual border-0 btn-CambiarEstadoMultiple" data-estado="0" title="Activar"><i class="fa fa-toggle-on"></i></button>
                    <button class="btn btn-outline-trade-visual border-0 btn-CambiarEstadoMultiple" data-estado="1" title="Desactivar"><i class="fa fa-toggle-off"></i></button>
                </div>
            </div>
            <div class="card-body" id="collapseBodyBasemadre">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-content-0" role="tabpanel">
                        <form id="seccionArchivos">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="main-card mb-3 card ">
	<div class="card-body p-0">
		<div class="tab-content" id="content-archivos">
			<div class="tab-pane fade show active" id="tab-content-0" role="tabpanel">
				<?= getMensajeGestion('noResultados') ?>
			</div>
			<div class="tab-pane fade" id="tab-content-1" role="tabpanel">
				<?= getMensajeGestion('noResultados') ?>
			</div>
		</div>
	</div>
</div>