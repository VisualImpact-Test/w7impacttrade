<form id="formNew">
    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
        <input type="hidden" name="sl_cuenta" id="sl_cuenta" value="3">
        <input type="hidden" name="sl_proyecto" id="sl_proyecto" value="3">
        <label for='sl_plazas'>Plazas</label><br>    
        <select class="my_select2 form-control" name="sl_plazas" id="sl_plazas">
                <?=htmlSelectOptionArray($plazas)?>
        </select>
            
            <!-- <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre'> -->
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
        <label for='sl_tipoCliente'>Tipo Cliente</label><br>    
            <select class="my_select2 form-control" name="sl_tipoCliente" id="sl_tipoCliente">
                <?=htmlSelectOptionArray($tiposCliente)?>
            </select>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
        <label for='empresa'>Tipo Auditoria</label><br>
            <select class="my_select2 form-control" name="sl_tipoAuditoria" id="sl_tipoAuditoria">
                <?=htmlSelectOptionArray($tiposAuditoria)?>
            </select>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='audPromedio'>Promedio Auditoria</label><br>
            <input id='audPromedio' name='audPromedio' type='text' class=' txt-only-number form-control form-control-sm' placeholder='Promedio'>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaInicio'>Fecha de Inicio</label><br>
            <input id='fechaInicio' name='fechaInicio' type='text' class='form-control form-control-sm' placeholder='Fecha Inicio'>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaFin'>Fecha de Fin</label><br>
            <input id='fechaFin' name='fechaFin' type='text' class='form-control form-control-sm' placeholder='Fecha Fin'>
        </div>
 
    </div>

</form>
<script>
    $('.my_select2').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });
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
</script>
