<style>
.select2 {
    width: 300px !important;
}
</style>
<div class="row">
    <div class="col-12">
        <div class="mb-3 card">
            <div class="card-header-tab card-header">
                <ul class="nav">
                    <li class="nav-item"><a data-toggle="tab" href="#tab-content-0" class="active nav-link"></a></li>
                </ul>
                <div class="funciones">
                    <button class="btn btn-outline-primary border-0 btn-consultar" id="btn-consultar" title="Filtrar"><i class="fa fa-filter"></i></button>
                    <button type="button" data-toggle="collapse" href="#collapseBodyBasemadre" title="Desplegar filtros" class="btn btn-outline-primary border-0 btnCollapse" aria-expanded="true"><i class="fas fa-caret-down fa-lg" aria-hidden="true"></i></button>
                </div>
            </div>
            <div class="card-body mostrarocultar collapse" id="collapseBodyBasemadre">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-content-0" role="tabpanel">
                        <form role="form" id="form-seguridad" class="form-inline">
                            <div class='form-row'>
                                <div class="form-group" style="margin-right:10px;">
                                    <!-- <label>Fechas: </label><br> -->
                                    <input class="form-control input-sm fechas" type="text" name="txt-fechas" patron="requerido" value="<?= date('d/m/Y') . ' - ' . date('d/m/Y') ?>">
                                </div>
                                <div class="form-group">
                                    <!-- <label>Usuario: </label><br> -->
                                    <select class="form-control  my_select2Full" name="idUsuario" style="width: 200px !important; ">
                                        <option value="">Usuario</option>
                                        <? foreach($usuarios AS $key => $value){ ?>
                                        <option value="<?= $value['idUsuario'] ?>"><?= $value['nombreUsuario'] ?></option>
                                        <? } ?>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="main-card mb-3 card">
            <div class="card-header">
                <i class="fas fa-list-alt fa-lg" aria-hidden="true"></i>&nbsp;Seguridad
            </div>
            <div class="card-body">
                <div id="div-ajax-seguridad" class="table-responsive">
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGUN REGISTRO.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>