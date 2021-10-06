<form id="formUpdate">
    <input class="d-none" type="text" name="idx" value="<?= $data[$this->model->tablas['tipoAuditoria']['id']] ?>">

    <input type="hidden" name="sl_cuenta" id="sl_cuenta" value="3">
    <input type="hidden" name="sl_proyecto" id="sl_proyecto" value="3">
    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre' value="<?= $data['nombre'] ?>">
        </div>
    </div>
</form>
