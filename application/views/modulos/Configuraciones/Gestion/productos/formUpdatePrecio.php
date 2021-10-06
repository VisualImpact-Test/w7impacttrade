<form id="formUpdate">
    <input class="d-none" type="text" name="idx" value="<?= $data[$this->model->tablas['precio']['id']] ?>">

    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='producto'>Productos</label><br>
            <div class="producto_sl">
                <select id='producto' name='producto' class='form-control form-control-sm my_select2'>
                <?php if (!empty($data['idProducto'])) { ?>
                    <option value='<?= $data['idProducto'] ?>' selected><?= $data['producto'] ?></option>
                <?php } ?>
                <?php foreach ($productos as $idProducto => $producto) { ?>
                    <?php if ($data['idProducto'] != $producto['idProducto']) { ?>
                        <option value='<?= $producto['idProducto'] ?>'><?= $producto['nombre'] ?></option>
                    <?php } ?>
                <?php } ?>
                </select>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='precioSugerido'>Precio Sugerido</label><br>
            <input id='precioSugerido' name='precioSugerido' type='text' class='form-control form-control-sm' placeholder='Precio Sugerido' value="<?=$data['precioSugerido']?>">
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='precioPromedio'>Precio Promedio </label><br>
            <input id='precioPromedio' name='precioPromedio' type='text' class='form-control form-control-sm' placeholder='Precio Promedio' value="<?=$data['precioPromedio']?>">
        </div>
    </div>
    <div class="form-row">
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaInicio'>Fecha Inicio</label><br>
            <input id='fechaInicio' name='fechaInicio' type='text' class='form-control form-control-sm' placeholder='Fecha Inicio' value="<?= date_change_format($data['fecIni']) ?>">
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaFin'>Fecha Fin</label><br>
            <input id='fechaFin' name='fechaFin' type='text' class='form-control form-control-sm' placeholder='Fecha Fin' value="<?= date_change_format($data['fecFin']) ?>">
        </div>
    </div>
</form>
<script>

    $('#fechaInicio').daterangepicker(singleDatePickerModal);
    $('#fechaFin').daterangepicker($.extend({
        "autoUpdateInput": false,
    }, singleDatePickerModal));
    $('#fechaInicio').on('apply.daterangepicker', function(ev, picker) {
        $('#fechaFin').val('');
    });
    $('#fechaFin').on('apply.daterangepicker', function(ev, picker) {
        $.fechaLimite(picker, "#fechaFin", "#fechaInicio");
    });
    $('.my_select2').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });
</script>
