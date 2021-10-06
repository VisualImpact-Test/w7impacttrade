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
<div class="row">
    <div class="col-12">

        <div class="mb-3 card">
            <div class="card-header-tab card-header">
                <ul class="nav">
                    <!-- <li class="nav-item"><a data-toggle="tab" href="#tab-content-0" class="nav-link">Promociones</a></li> -->
                    <li class="nav-item"><a data-toggle="tab" href="#tab-content-0" class="active nav-link">Lista Inventario</a></li>
                </ul>
                <div class="funciones">
                    <!-- <a href="javascript:void(0);" class="btn btn-outline-primary border-0 btn-seccion-Cuenta" title="BuscarCuenta"><i class="fa fa-search"></i>btnCuenta</a>
                    <a href="javascript:void(0);" class="btn btn-outline-primary border-0 btn-seccion-GrupoCanal d-none" title="BuscarGrupoCanal"><i class="fa fa-search"></i>btnGrupoCanal</a>
                    <a href="javascript:void(0);" class="btn btn-outline-primary border-0 btn-seccion-Proyecto d-none" title="BuscarProyecto"><i class="fa fa-search"></i>btnProyecto</a>
                     -->
                    <button class="btn btn-outline-primary border-0 btn-Consultar" title="Filtrar"><i class="fa fa-filter"></i></button>
                    <button class="btn btn-outline-primary border-0 btn-New" title="Agregar"><i class="fa fa-plus"></i></button>
                    <button class="btn btn-outline-primary border-0 btn-CargaMasiva" title="Carga Masiva"><i class="fas fa-folder-plus"></i></button>
                    <button class="btn btn-outline-primary border-0 btn-CambiarEstadoMultiple" data-estado="0" title="Activar"><i class="fa fa-toggle-on"></i></button>
                    <button class="btn btn-outline-primary border-0 btn-CambiarEstadoMultiple" data-estado="1" title="Desactivar"><i class="fa fa-toggle-off"></i></button>
                    <button type="button" data-toggle="collapse" href="#collapseBodyBasemadre" title="Desplegar filtros" class="btn btn-outline-primary border-0 btnCollapse"><i class="fas fa-caret-down fa-lg" aria-hidden="true"></i></button>
                </div>
            </div>
            <div class="card-body collapse" id="collapseBodyBasemadre">
                <div class="tab-content">
 
                    <div class="tab-pane active" id="tab-content-0" role="tabpanel">
                        <form id="seccionLista">
                            <div class="form-row mb-3">

                                <div class="col-auto">
                                    <!-- <label for='cuenta_filtro'>Cuenta</label><br> -->
                                    <?= getFiltros(['cuenta' => ['label' => 'Cuenta', 'name' => 'cuenta', 'id' => 'cuenta', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                                </div>

                                <div class="col-auto">
                                    <!-- <label for='proyecto'>Proyecto</label><br> -->
                                    <?= getFiltros(['proyecto' => ['label' => 'Proyecto', 'name' => 'proyecto', 'id' => 'proyecto', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                                </div>
                                <div class="col-auto">
                                    <!-- <label for='grupoCanal'>Grupo Canal</label><br> -->
                                    <?= getFiltros(['grupoCanal' => ['label' => 'Grupo Canal', 'name' => 'grupoCanal', 'id' => 'grupoCanal', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                                </div>
                                <div class="col-auto">
                                    <!-- <label for='canal'>Canal</label><br> -->
                                    <?= getFiltros(['canal' => ['label' => 'Canal', 'name' => 'canal', 'id' => 'canal', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="row contentGestion contentLista">
	<div class="col-lg-12">
		<div class="main-card mb-3 card">
			<div class="card-header">
				<i class="fas fa-list-alt fa-lg"></i>&nbspElemento
			</div>
			<div class="card-body" id="contentLista">
				<div class="alert alert-info" role="alert">
					<i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGÚN RESULTADO.
				</div>
			</div>
		</div>
	</div>
</div>