<form id="formUpdate">

    <input class="d-none" type="text" name="idZona" value="<?= $zonas['idZona'] ?>">

    <div class='form-row'>

        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2">
            <label for='cuenta_zona'>Cuenta:</label><br>
            <?= getFiltros(['cuenta' => ['label' => 'Cuenta', 'name' => 'cuenta_zona', 'id' => 'cuenta_zona', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '', 'value' => $zonas['idCuenta']]]) ?>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2">
            <label for='proyecto_zona'>Proyecto:</label><br>
            <?= getFiltros(['proyecto' => ['label' => 'Proyecto', 'name' => 'proyecto_zona', 'id' => 'proyecto_zona', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '', 'value' => $zonas['idProyecto']]]) ?>
        </div>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre' value="<?= $zonas['nombre'] ?>" patron="requerido">
        </div>

    </div>

</form>

<script>
    $('.my_select2').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });
</script>