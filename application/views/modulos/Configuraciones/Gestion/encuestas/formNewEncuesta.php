<form id="formNew">
    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre'>
        </div>

    </div>
    <div class='form-row'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='foto'>Foto</label><br>
            <select id='foto' name='foto' class='form-control form-control-sm my_select2'>
                <option value='1'> SÍ </option>
                <option value='2'> NO </option>
            </select>
        </div>
    </div>

</form>

<script>
    $('.my_select2').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });

    // // Todo esto para los dos primeros selects juntos
    // $('#fecIni').daterangepicker(singleDatePickerModal);
    // $('#fecFin').daterangepicker($.extend({
    //     "autoUpdateInput": false,
    // }, singleDatePickerModal));
    // $('#fecIni').on('apply.daterangepicker', function(ev, picker) {
    //     $('#fecFin').val('');
    // });
    // $('#fecFin').on('apply.daterangepicker', function(ev, picker) {
    //     $.fechaLimite(picker, "#fecFin", "#fecIni");
    // });

    // // Todo esto para los dos segundos selects juntos
    // $('#fecIni2').daterangepicker(singleDatePickerModal);
    // $('#fecFin2').daterangepicker($.extend({
    //     "autoUpdateInput": false,
    // }, singleDatePickerModal));
    // $('#fecIni2').on('apply.daterangepicker', function(ev, picker) {
    //     $('#fecFin2').val('');
    // });
    // $('#fecFin2').on('apply.daterangepicker', function(ev, picker) {
    //     $.fechaLimite(picker, "#fecFin2", "#fecIni2");
    // });

    // // Esto para poner el modal como parent para los select2
    // $('.my_select2').select2({
    //     dropdownParent: $("div.modal-content"),
    //     width: '100%'
    // });
</script>