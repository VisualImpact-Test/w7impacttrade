<form id="formNew">
    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre'>
        </div>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='sl_cuentas'>Cuenta</label><br>
            <select class="form-control" name="sl_cuentas" id="sl_cuentas">
                <?=htmlSelectOptionArray($cuentas)?>
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
