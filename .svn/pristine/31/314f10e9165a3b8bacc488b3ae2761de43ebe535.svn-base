<form id="formNew">
    <div class='form-row'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='cuenta'>Cuenta:</label><br>
            <select id='cuenta' name='cuenta' class='form-control form-control-sm my_select2'>
                <option value=''>-- Seleccionar --</option>
                <?php foreach ($cuentas as $idCuenta => $cuenta) { ?>
                    <option value='<?= $cuenta['idCuenta'] ?>'><?= $cuenta['nombre'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='idTipoUsuario'>Tipo Usuario:</label><br>
            <select id='idTipoUsuario' name='idTipoUsuario' class='form-control form-control-sm my_select2'>
                <option value=''>-- Seleccionar --</option>
                <?php foreach ($tiposUsuarios as $idTipoUsuario => $row) { ?>
                    <option value='<?= $row['idTipoUsuario'] ?>'><?= $row['nombre'] ?></option>
                <?php } ?>
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