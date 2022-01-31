<form id="formUpdate">
    <input class="d-none" type="text" name="idProyecto" value="<?= $proyecto['idProyecto'] ?>">

    <div class='form-row'>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre' value="<?= $proyecto['nombre'] ?>">
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombreCorto'>Nombre Corto</label><br>
            <input id='nombreCorto' name='nombreCorto' type='text' class='form-control form-control-sm' placeholder='Nombre corto' value="<?= $proyecto['nombreCorto'] ?>">
        </div>

        <div class='col-md-12'>
            <label for='cuenta'>Cuenta</label><br>
            <select id='cuenta' name='cuenta' class='form-control form-control-sm my_select2'>
                <option value=''>-- Seleccionar --</option>
                <?php if (!empty($proyecto['idCuenta'])) { ?>
                    <option value='<?= $proyecto['idCuenta'] ?>' selected><?= $proyecto['cuenta'] ?></option>
                <?php } ?>
                <?php foreach ($cuentas as $idCuenta => $cuenta) { ?>
                    <?php if ($proyecto['idCuenta'] != $cuenta['idCuenta']) { ?>
                        <option value='<?= $cuenta['idCuenta'] ?>'><?= $cuenta['nombre'] ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
        </div>

    </div>

    <div class="form-row">

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaInicio'>Fecha Inicio</label><br>
            <input id='fechaInicio' name='fechaInicio' type='text' class='form-control form-control-sm' placeholder='Fecha Inicio' value="<?= date_change_format($proyecto['fecIni']) ?>">
        </div>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaFin'>Fecha Fin</label><br>
            <input id='fechaFin' name='fechaFin' type='text' class='form-control form-control-sm' placeholder='Fecha Fin' value="<?= date_change_format($proyecto['fecFin']) ?>">
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