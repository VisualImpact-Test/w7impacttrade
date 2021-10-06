<style>
body { position: relative; }
#ZoomBox { position: absolute; top: 50%; left: 50%; transform: translate(-0%, -0%); }
.contenedor_hora { font-size: 10px !important; }

.bg-warning-gradient { background: linear-gradient(90deg, #ffc107, #e52e71); }
.bg-primary-gradient { background: linear-gradient(90deg, #007bff, #e52e71) }
.bg-purple-gradient { background: linear-gradient(90deg, #5011ad , #e52e71); }
.card-header>.nav>li.active {
    border-bottom: none !important;
}

.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: #fff !important;
    background: linear-gradient(90deg, #5011ad , #e52e71) !important;
}

button.btn.btn-xs.btn-primary.buttons-collection.buttons-page-length {
    background: linear-gradient(90deg, #007bff, #e52e71) !important;
}

button.btn.btn-xs.btn-primary.buttons-excel.buttons-html5 {
    background: linear-gradient(90deg, #ffc107, #e52e71) !important;
}
</style>

<div class="row  mt-4">

    <div class="col-md-3 col-sm-12 col-xs-12">
        <div class="mb-3 card">
            <div class="card-header font-weight-bold">
                <i class="fas fa-folder-open fa-lg" aria-hidden="true"></i>&nbsp;RAIZ
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div id="root-left"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="mb-3 card">
                    <div class="card-header  font-weight-bold">
                        <i class="fas fa-folder fa-lg" aria-hidden="true"></i>&nbsp;CARPETA
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div id="folder"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="content-files" style="display:none">
            <div class="row contentGestion">
                <div class="col-md-12">
                    <div class="mb-3 card">
                        <div class="card-header  font-weight-bold">
                            <i class="fal fa-folder-open fa-lg" aria-hidden="true"></i>&nbsp;Archivos
                            <div class="funciones">
                                <a href="javascript:;" class="lk-refresh-files btn btn-outline-trade-visual border-0"> <i class="fa fa-refresh" aria-hidden="true"></i> Todo </a>
                                <a href="javascript:;" class="lk-format btn btn-outline-trade-visual border-0" data-type="detail" title="Detalles"><i class="fa fa-th" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                        <div id="files" class="table-responsive">
					    </div>
                            <!-- <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div id="files"></div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>