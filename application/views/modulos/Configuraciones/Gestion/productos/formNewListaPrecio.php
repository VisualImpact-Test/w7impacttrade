<form id="formNew">
    <div class='form-row'>
         <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
             <label for='grupoCanal'>Grupo Canal</label><br>
                <select id='grupoCanal' name='grupoCanal' class='form-control form-control-sm my_select2 grupoCanal_cliente'>
                    <option value=''>-- Seleccionar --</option>
                    <?php foreach ($gruposCanal as $idGrupoCanal => $grupoCanal) { ?>
                        <option value='<?= $grupoCanal['idGrupoCanal'] ?>'><?= $grupoCanal['nombre'] ?></option>
                    <?php } ?>
                </select>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='canal'>Canal</label><br>
                <div class="canal_sl">
                    <select id='canal' name='canal' class='form-control form-control-sm my_select2 canal_cliente'>
                    <option value=''>-- Seleccionar --</option>
                     
                </select>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='valorMin'>Valor Mínimo</label><br>
            <input id='valorMin' name='valorMin' type='text' class='form-control form-control-sm' placeholder='Valor Mínimo'>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='valorMax'>Valor Máximo </label><br>
            <input id='valorMax' name='valorMax' type='text' class='form-control form-control-sm' placeholder='Valor Máximo'>
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
    Productos.grupoCanal=<?=json_encode($arr_grupoCanal) ?>;
</script>

