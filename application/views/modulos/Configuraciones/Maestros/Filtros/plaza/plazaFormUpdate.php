<form id="formUpdate">

    <input class="d-none" type="text" name="idPlaza" value="<?= $plaza['idPlaza'] ?>">

    <div class='form-row'>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre' value="<?= $plaza['nombre'] ?>" patron="requerido">
        </div>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombre'>Cod. Ubigeo:</label><br>
            <input id='cod_ubigeo' name='cod_ubigeo' type='text' class='form-control form-control-sm' placeholder='Codigo Ubigeo' value="<?= $plaza['cod_ubigeo'] ?>" patron="requerido">
        </div>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombre'>Dirección:</label><br>
            <input id='direccion' name='direccion' type='text' class='form-control form-control-sm' placeholder='Dirección' value="<?= $plaza['direccion'] ?>" patron="requerido">
        </div>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombreMayorista'>Nombre Mayorista:</label><br>
            <input id='nombreMayorista' name='nombreMayorista' type='text' class='form-control form-control-sm' value="<?= $plaza['nombreMayorista'] ?>" placeholder='Nombre Mayorista'>
        </div>

    </div>
    
</form>

<script>
    $('.my_select2').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });
</script>