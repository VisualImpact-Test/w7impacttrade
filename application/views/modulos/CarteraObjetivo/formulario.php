<form id="formUpdate">
    <div class='form-row'>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
            <h6><i class="fa fa-pencil-square-o"></i> Datos de la cartera :</h6>
            <hr class="solid mb-2 mt-0">
        </div>
    </div>

    <div class="form-row mb-3">
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2">
            <label><strong>CUENTA:</strong></label>
            <select class="form-control" name="sel-cartera-cuenta" id="sel-cartera-cuenta" title="Cuenta" data-actions-box="true" data-live-search="true" data-container="body" patron="requerido">
                <option value="">-- SELECCIONE --</option>
                <? foreach ($cuentas as $k => $r) { ?>
                    <option value="<?= $r['id'] ?>" <?= ($r['id'] == $datos['idCuenta']) ? 'selected' : '' ?>><?= $r['cuenta'] ?></option>
                <? } ?>
            </select>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2">
            <label><strong>PROYECTO:</strong></label>
            <select class="form-control" name="sel-cartera-proyecto" id="sel-cartera-proyecto" title="Cuenta" data-actions-box="true" data-live-search="true" data-container="body" patron="requerido">
                <option value="">-- SELECCIONE --</option>
                <? foreach ($proyectos as $k => $r) { ?>
                    <option value="<?= $r['id'] ?>" <?= ($r['id'] == $datos['idProyecto']) ? 'selected' : '' ?>><?= $r['proyecto'] ?></option>
                <? } ?>
            </select>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2">
            <label><strong>SUB CANAL:</strong></label>
            <select class="form-control" name="sel-cartera-sub-canal" id="sel-cartera-sub-canal" title="Sub Canal" data-actions-box="true" data-live-search="true" data-container="body" patron="requerido">
                <option value="">-- SELECCIONE --</option>
                <? foreach ($subCanales as $k => $r) { ?>
                    <option value="<?= $r['id'] ?>" <?= ($r['id'] == $datos['idSubCanal']) ? 'selected' : '' ?>><?= $r['subCanal'] ?></option>
                <? } ?>
            </select>
        </div>
    </div>
    <div class="form-row mb-3">
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2">
            <div class="form-group">
                <label><strong>DISTRIBUIDORA SUCURSAL:</strong></label>
                <select class="form-control" name="sel-cartera-rd" id="sel-cartera-rd" title="Distribuidora Sucursal" data-actions-box="true" data-live-search="true" data-container="body">
                    <option value="">-- SELECCIONE --</option>
                    <? foreach ($distribuidorasSucursales as $k => $r) { ?>
                        <option value="<?= $r['id'] ?>" <?= ($r['id'] == $datos['idDistribuidoraSucursal']) ? 'selected' : '' ?>><?= $r['distribuidoraSucursal'] ?></option>
                    <? } ?>
                </select>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2">
            <label><strong>PLAZA:</strong></label>
            <select class="form-control" name="sel-cartera-plaza" id="sel-cartera-plaza" title="Plaza" data-actions-box="true" data-live-search="true" data-container="body">
                <option value="">-- SELECCIONE --</option>
                <? foreach ($plazas as $k => $r) { ?>
                    <option value="<?= $r['id'] ?>" <?= ($r['id'] == $datos['idPlaza']) ? 'selected' : '' ?>><?= $r['plaza'] ?></option>
                <? } ?>
            </select>
        </div>
    </div>

    <div class='form-row mb-3'>
        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='cartera'><strong>CARTERA:</strong></label><br>
            <input id='cartera' name='cartera' type='text' class='form-control' placeholder='Cartera' value="<?= verificarEmpty($datos['cartera']) ?>" patron="requerido">
        </div>

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='fechaIni'><strong>FECHA INICIO:</strong></label><br>
            <input id='fechaIni' name='fechaIni' type='text' class='form-control txt-fecha' placeholder='Fecha Inicial' value="<?= verificarEmpty($datos['fecIni']) ?>" patron="requerido">
        </div>

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='fechaFin'><strong>FECHA FIN:</strong></label><br>
            <input id='fechaFin' name='fechaFin' type='text' class='form-control txt-fecha' placeholder='Fecha Final' value="<?= verificarEmpty($datos['fecFin']) ?>">
        </div>
        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <input id='id' name='id' type='hidden' class='form-control' placeholder='Id' value="<?= verificarEmpty($datos['idObjetivo']) ?>">
        </div>
    </div>
</form>

<script>
    singleDatePickerModal.autoUpdateInput = false;
    $('.txt-fecha').daterangepicker(singleDatePickerModal, function(chosen_date) {
        $(this.element[0]).val(chosen_date.format('DD/MM/YYYY'));
    });
</script>