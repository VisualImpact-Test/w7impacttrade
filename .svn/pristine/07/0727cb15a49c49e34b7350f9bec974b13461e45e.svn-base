<form id="formNew">
    <div class='form-row'>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombre'>Nombre:</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre' patron="requerido">
        </div>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='departamento'>Cuenta:</label><br>
            <select class="form-control form-control-sm my_select2" name="form_idCuenta" id="form_idCuenta" patron="requerido">
                <?= htmlSelectOptionArray2(['query' => $cuentas, 'id' => 'idCuenta', 'value' => 'nombre', 'title' => '-- Seleccione --']) ?>
            </select>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <input type="checkbox" name="flagAndroid" id="flagAndroid">
            <label for='flagAndroid'>Android</label>
        </div>

    </div>
</form>

<script>
    $('.my_select2').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });
</script>