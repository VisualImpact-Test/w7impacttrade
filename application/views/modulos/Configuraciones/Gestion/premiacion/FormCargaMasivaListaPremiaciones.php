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
                        <i class="fa fa-check-circle"></i> <label class="">Se pide que solo una fila (la última) debe quedar en <strong>BLANCO</strong></label>.<br>
                        <i class="fa fa-check-circle"></i> <label class="">Los campos con una cabecera que contenga (*) son <strong>OBLIGATORIOS</strong></label>.<br>
                        <i class="fa fa-check-circle msgCargaElementos d-none"></i> <label class="msgCargaElementos d-none">Al  <strong>GENERAR UN NUEVO DETALLE</strong> se eliminarán las encuestas de la lista y solo se considerarán las nuevas premiaciones cargadas (Solo se considera al actualizar) . </label><br>
                    </div>
                    <div class="alert alert-danger msgCargaElementos d-none" role="alert" style="color:#695560 !important;">
                        <div class="ui slider checkbox">
                            <input type="checkbox" name="chk-nuevo">
                            <label>Generar nuevo Detalle</label>
                        </div>
                    </div>
                </div>

                <div class="tab-content mt-4 text-white">
                    <?php foreach ($hojas as $key => $row) { ?>
                        <div class="tab-pane <?= ($key == 0) ? 'show active' : '' ?>" id="hoja<?= $key ?>" role="tabpanel" aria-labelledby="hoja<?= $key ?>-tab">
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