<form id="formNew">

    <div class='form-row'>
         <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='producto'>Productos</label><br>
            <div class="producto_sl">
                <select id='producto' name='producto' class='form-control form-control-sm my_select2'>
                    <option value=''>-- Seleccionar --</option>
                    <?php foreach ($productos as $idProducto => $producto) { ?>
                        <option value='<?= $producto['idProducto'] ?>'><?= $producto['nombre'] ?></option>
                    <?php } ?>
                </select>
            </div>
              
        </div>
    </div>
    <div class="form-row">
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='precioSugerido'>Precio Sugerido</label><br>
            <input id='precioSugerido' name='precioSugerido' type='text' class='form-control form-control-sm' placeholder='Precio Sugerido'>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='precioPromedio'>Precio Promedio </label><br>
            <input id='precioPromedio' name='precioPromedio' type='text' class='form-control form-control-sm' placeholder='Precio Promedio'>
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

