<style>
li .active{
    color:white;
    background-color: red;

}

.segHist{
    color:#008000 !important;
}

.segModerno{
    color:red !important;
}

.blue{
    color:blue !important;
}
</style>
<form id="formCargaMasiva" role="form">
    <div class="row">
        <div class="col-md-12" id="divTablaCargaMasiva">

            <ul class="nav nav-tabs" role="tablist">
                <?php foreach ($hojas as $key => $row) { ?>
                    <li class="nav-item">
                        <a class="tabCargaMasiva nav-link <?= ($key == 0) ? 'active' : '' ?>" id="hoja<?= $key ?>-tab" data-nrohoja="<?= $key ?>" data-toggle="tab" href="#hoja<?= $key ?>" role="tab" aria-controls="hoja<?= $key ?>" aria-selected="true"><?= $row ?></a>
                    </li>
                <?php } ?>
            </ul>

            <div class="tab-content mt-4 text-white">
            <div class="">
					<div class="alert alert-warning" role="alert" style="color:#695560 !important;">
						<i class="fa fa-check-circle"></i> <label class="">Se pide que solo una fila (la última) debe quedar en  <strong>BLANCO</strong></label>.<br>
						<i class="fa fa-check-circle"></i> <label class="">Los campos con una cabecera que contenga (*)  son <strong>OBLIGATORIOS</strong></label>.<br>
						<!--i class="fa fa-mobile blue"></i> <label class="blue">Si el <strong>TIPO ACCESO</strong> es <strong>APLICATIVO</strong> se pide que la clave sea numérica y de 4 cifras</label>.<br>
						<i class="fa fa-mobile blue" ></i> <label class="blue">Si el <strong>TIPO ACCESO</strong> es <strong>APLICATIVO</strong> el usuario por defecto será el <strong>DOCUMENTO</strong></label>.<br-->
                    </div>
            </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" id="export-string" class="intext-btn d-none" hidden>Export as a String</button>
                        <button type="button" id="export-string-range" class="intext-btn d-none" hidden> Export as a String with a specified range </button>
                        <button type="button" id="export-blob" class="intext-btn d-none" hidden> Export as a blob  </button>
                        <button type="button" id="export-file" class="intext-btn btn btn-success" >Exportar como CSV  <i class="fa fa-file"></i></button>
                    </div>
                </div>
                <?php foreach ($hojas as $key => $row) { ?>
                    <div class="tab-pane <?= ($key == 0) ? 'active' : '' ?>" id="hoja<?= $key ?>" role="tabpanel" aria-labelledby="hoja<?= $key ?>-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="divHT<?= $key ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>
</form>
