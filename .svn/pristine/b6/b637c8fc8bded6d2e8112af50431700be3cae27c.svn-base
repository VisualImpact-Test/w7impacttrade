<form id="formUpdate">
    <input class="d-none" type="text" name="idTipoUsuarioCuenta" value="<?= $tipoUsuarioCuenta['idTipoUsuarioCuenta'] ?>">

    <div class='form-row'>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='cuenta'>Cuenta:</label><br>
            <select id='cuenta' name='cuenta' class='form-control form-control-sm my_select2'>
                <option value=''>-- Seleccionar --</option>
                <?php if (!empty($tipoUsuarioCuenta['idCuenta'])) { ?>
                    <option value='<?= $tipoUsuarioCuenta['idCuenta'] ?>' selected><?= $tipoUsuarioCuenta['cuenta'] ?></option>
                <?php } ?>
                <?php foreach ($cuentas as $idCuenta => $cuenta) { ?>
                    <?php if ($tipoUsuarioCuenta['idCuenta'] != $cuenta['idCuenta']) { ?>
                        <option value='<?= $cuenta['idCuenta'] ?>'><?= $cuenta['nombre'] ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
        </div>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='idTipoUsuario'>Tipo Usuario:</label><br>
            <select id='idTipoUsuario' name='idTipoUsuario' class='form-control form-control-sm my_select2'>
                <option value=''>-- Seleccionar --</option>
                <?php if (!empty($tipoUsuarioCuenta['idTipoUsuario'])) { ?>
                    <option value='<?= $tipoUsuarioCuenta['idTipoUsuario'] ?>' selected><?= $tipoUsuarioCuenta['tipoUsuario'] ?></option>
                <?php } ?>
                <?php foreach ($tiposUsuarios as $idTipoUsuario => $row) { ?>
                    <?php if ($tipoUsuarioCuenta['idTipoUsuario'] != $row['idTipoUsuario']) { ?>
                        <option value='<?= $row['idTipoUsuario'] ?>'><?= $row['nombre'] ?></option>
                    <?php } ?>
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