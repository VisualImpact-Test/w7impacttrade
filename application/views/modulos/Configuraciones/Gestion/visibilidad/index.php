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
                    <li class="nav-item"><a data-toggle="tab" href="#tab-content-0" class="active nav-link">Categorías</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#tab-content-1" class="nav-link">Lista Visibilidad</a></li>
                </ul>
                <div class="funciones">
                    <!-- <a href="javascript:void(0);" class="btn btn-outline-primary border-0 btn-seccion-Cuenta" title="BuscarCuenta"><i class="fa fa-search"></i>btnCuenta</a>
                    <a href="javascript:void(0);" class="btn btn-outline-primary border-0 btn-seccion-GrupoCanal d-none" title="BuscarGrupoCanal"><i class="fa fa-search"></i>btnGrupoCanal</a>
                    <a href="javascript:void(0);" class="btn btn-outline-primary border-0 btn-seccion-Proyecto d-none" title="BuscarProyecto"><i class="fa fa-search"></i>btnProyecto</a>
                     -->
                    <button class="btn btn-outline-primary border-0 btn-Consultar" title="Buscar"><i class="fa fa-search"></i></button>
                    <button class="btn btn-outline-primary border-0 btn-New" title="Agregar"><i class="fa fa-plus"></i></button>
                    <button class="btn btn-outline-primary border-0 btn-CargaMasiva" title="Carga Masiva"><i class="fas fa-folder-plus"></i></button>
                    <button class="btn btn-outline-primary border-0 btn-CambiarEstadoMultiple" data-estado="0" title="Activar"><i class="fa fa-toggle-on"></i></button>
                    <button class="btn btn-outline-primary border-0 btn-CambiarEstadoMultiple" data-estado="1" title="Desactivar"><i class="fa fa-toggle-off"></i></button>
                    <button type="button" data-toggle="collapse" href="#collapseBodyBasemadre" title="Mostrar/ocultar" class="btn btn-outline-primary border-0"><i class="fas fa-caret-up fa-lg" aria-hidden="true"></i></button>
                </div>
            </div>
            <div class="card-body" id="collapseBodyBasemadre">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-content-0" role="tabpanel">
                        <form id="seccionCategoria">
                            <!-- <div class="form-inline mt-2">
                                <button type="submit" class="btn-getPuntosDeVenta btn btn-primary m-lg-0">Obtener puntos de venta</button>
                                <div class="ml-2 mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                                    <select class="form-control form-control-sm my_select2" name="idPuntoDeVenta">
                                        <option value="">-- Punto de Venta --</option>
                                    </select>
                                </div>
                            </div> -->
                        </form>
                    </div>
                    <div class="tab-pane" id="tab-content-1" role="tabpanel">
                        <form id="seccionLista">

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="row contentGestion" id="contentCategoria">
                <?= getMensajeGestion('noResultados') ?>
            </div>
            <div class="row contentGestion d-none" id="contentLista">
                <?= getMensajeGestion('noResultados') ?>
            </div>
        </div>

    </div>
</div>