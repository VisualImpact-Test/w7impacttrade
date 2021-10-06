<form id="formUpdate">
    <input class="d-none" type="text" name="idx" value="<?= $data[$this->model->tablas['elemento']['id']] ?>">

    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre' value="<?= $data['nombre'] ?>">
        </div>
    </div>
    <div class='form-row'>
                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
                    <label for='tipo'>Tipo Promoción</label><br>
                    <select id='tipo' name='tipo' class='form-control form-control-sm my_select2'>
                    <option value=''>-- Seleccionar --</option>
                    <?php if (!empty($data['idTipoPromocion'])) { ?>
                        <option value='<?= $data['idTipoPromocion'] ?>' selected><?= $data['tipoPromocion'] ?></option>
                    <?php } ?>
                    <?php foreach ($tipos as $idTipo => $tipo) { ?>
                        <?php if ($data['idTipoPromocion'] != $tipo['idTipoPromocion']) { ?>
                            <option value='<?= $tipo['idTipoPromocion'] ?>'><?= $tipo['nombre'] ?></option>
                        <?php } ?>
                    <?php } ?>
                    </select>
                </div>

    </div>
</form>
<script>
    $('.my_select2').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });
</script>