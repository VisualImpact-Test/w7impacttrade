<form id="formNew">
    <div class='form-row'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre'>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombreCorto'>Nombre Corto</label><br>
            <input id='nombreCorto' name='nombreCorto' type='text' class='form-control form-control-sm' placeholder='Nombre corto'>
        </div>
        <div class='col-md-12'>
            <label for='cuenta'>Cuenta</label><br>
            <select id='cuenta' name='cuenta' class='form-control form-control-sm my_select2'>
                <option value=''>-- Seleccionar --</option>
                <?php foreach ($cuentas as $idCuenta => $cuenta) { ?>
                    <option value='<?= $cuenta['idCuenta'] ?>'><?= $cuenta['nombre'] ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaInicio'>Fecha Inicio</label><br>
            <input id='fechaInicio' name='fechaInicio' type='text' class='form-control form-control-sm' placeholder='Fecha Inicio'>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaFin'>Fecha Fin</label><br>
            <input id='fechaFin' name='fechaFin' type='text' class='form-control form-control-sm' placeholder='Fecha Fin'>
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