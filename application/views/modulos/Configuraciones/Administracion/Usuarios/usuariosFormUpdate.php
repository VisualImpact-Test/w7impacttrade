<?php
$tieneEncargado = !empty($encargado) ? true : false;
?>

<form id="formUpdate">
    <input class='d-none' type='text' name='externo' value='<?= $usuario['externo'] ?>'>
    <input class='d-none' type='text' name='idUsuario' value='<?= $usuario['idUsuario'] ?>'>
    <input class='d-none' type='text' name='idEmpleado' value='<?= $usuario['idEmpleado'] ?>'>

    <div class='form-row'>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
            <h6><i class="fa fa-pencil-square-o"></i> Datos de Usuario:</h6>
            <hr class="solid mb-2 mt-0">
        </div>
    </div>

    <div class='form-row mb-3'>
        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='nombres'>Nombres</label><br>
            <input id='nombres' name='nombres' type='text' class='form-control form-control-sm' placeholder='Nombres' value="<?= !empty($usuario['nombres']) ? $usuario['nombres'] : '' ?>">
        </div>

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='apePaterno'>Apellido Paterno</label><br>
            <input id='apePaterno' name='apePaterno' type='text' class='form-control form-control-sm' placeholder='Apellido Paterno' value="<?= !empty($usuario['apePaterno']) ? $usuario['apePaterno'] : '' ?>">
        </div>

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='apeMaterno'>Apellido Materno</label><br>
            <input id='apeMaterno' name='apeMaterno' type='text' class='form-control form-control-sm' placeholder='Apellido Materno' value="<?= !empty($usuario['apeMaterno']) ? $usuario['apeMaterno'] : '' ?>">
        </div>

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='tipoDocumento'>Tipo Documento</label><br>
            <select id='tipoDocumento' name='tipoDocumento' class='form-control form-control-sm my_select2Update'>
                <option value=''>-- Seleccionar --</option>
                <?php foreach ($tiposDeDocumento as $tipoDeDocumento) {
                    $stringSelected = ($tipoDeDocumento['idTipoDocumento'] == $usuario['idTipoDocumento']) ? 'selected' : ''; ?>
                    <option value='<?= $tipoDeDocumento['idTipoDocumento'] ?>' <?= $stringSelected ?>><?= $tipoDeDocumento['breve'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='numDocumento'>Num. Documento</label><br>
            <input id='numDocumento' name='numDocumento' type='text' class='form-control form-control-sm' placeholder='Num. Documento' value="<?= !empty($usuario['numDocumento']) ? $usuario['numDocumento'] : '' ?>">
        </div>

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='email'>Email</label><br>
            <input id='email' name='email' type='text' class='form-control form-control-sm' placeholder='Email' value="<?= !empty($usuario['email']) ? $usuario['email'] : '' ?>">
        </div>

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='usuario'>Usuario</label><br>
            <input id='usuario' name='usuario' type='text' class='form-control form-control-sm' placeholder='Usuario' value="<?= !empty($usuario['usuario']) ? $usuario['usuario'] : '' ?>">
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2">
            <label for="clave">Clave</label><br>
            <div class="input-group input-group-sm">
                <input id="clave" name="clave" type="password" class="form-control" value="<?= !empty($usuario['clave']) ? $usuario['clave'] : '' ?>">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary btn-GenerarClave" title="Generar Clave" type="button"><i class="fa fa-key"></i></button>
                </div>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary btn-MostrarClave" title="Mostrar clave" type="button"><i class="fa fa-eye"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class='form-row'>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
            <h6><i class="fa fa-pencil-square-o"></i> Registrar Encargado:</h6>
            <hr class="solid mb-2 mt-0">
        </div>
    </div>

    <div class="form-row mb-3 justify-content-end">
        <div class='col-xs-3 col-sm-3 col-md-3 col-lg-3 mb-2'>
            <label>¿Tiene encargado?</label><br>
            <div class="form-check form-check-inline" id="tieneEncargado">
                <input name="tieneEncargado" class="form-check-input" type="radio" value="1" <?= $tieneEncargado ? 'checked' : '' ?>>
                <label class="form-check-label">Sí</label>
            </div>
            <div class="form-check form-check-inline">
                <input name="tieneEncargado" class="form-check-input" type="radio" value="0" <?= !$tieneEncargado ? 'checked' : '' ?>>
                <label class="form-check-label">No</label>
            </div>
        </div>

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='tipoDocumentoSuperior'>Tipo</label><br>
            <select data-radio='tieneEncargado' id='tipoDocumentoSuperior' name='tipoDocumentoSuperior' class='form-control form-control-sm my_select2Update' <?= !$tieneEncargado ? 'disabled' : '' ?>>
                <?php foreach ($tiposDeDocumento as $tipoDeDocumento) {
                    $stringSelected = '';
                    if (!empty($encargado['idTipoDocumento'])) $stringSelected = ($tipoDeDocumento['idTipoDocumento'] == $encargado['idTipoDocumento']) ? 'selected' : '';
                ?>
                    <option value='<?= $tipoDeDocumento['idTipoDocumento'] ?>' <?= $stringSelected ?>><?= $tipoDeDocumento['breve'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class='col-xs-5 col-sm-5 col-md-5 col-lg-5 mb-2'>
            <label for='numDocSuperior'>Num. Documento</label><br>
            <div class="input-group input-group-sm">
                <input data-radio="tieneEncargado" id='numDocSuperior' name='numDocSuperior' type="text" class="form-control" placeholder="Num. Documento" value='<?= !empty($encargado['numDocumento']) ? $encargado['numDocumento'] : '' ?>' <?= !$tieneEncargado ? 'disabled' : '' ?>>
                <div class="input-group-append">
                    <button data-radio="tieneEncargado" class="btn btn-outline-secondary btn-FindSuperior" title="Buscar Superior" type="button" <?= !$tieneEncargado ? 'disabled' : '' ?>><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
        <div class='col-xs-9 col-sm-9 col-md-9 col-lg-9 mb-2'>
            <label for='idUsuarioSuperior'>Superior</label><br>
            <input data-radio="tieneEncargado" id='idUsuarioSuperior' name='superiorEncontrado' type='text' class='form-control form-control-sm' value='<?= !empty($encargado['nombreSuperior']) ? $encargado['nombreSuperior'] : '' ?>' readonly <?= !$tieneEncargado ? 'disabled' : '' ?>>
            <input data-radio="tieneEncargado" class='d-none' type='text' name='idUsuarioSuperior' value='<?= !empty($encargado['idUsuario']) ? $encargado['idUsuario'] : '' ?>'>
        </div>
    </div>

    <?php if (count($subordinados) > 0) { ?>
        <div class="form-row mb-3">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <label>Subordinados</label><br>
                <div class="overflow-auto hr-15">
                    <table class='table table-sm table-bordered'>
                        <thead class='thead-light'>
                            <tr>
                                <th class='text-center'>NUM. DOCUMENTO</th>
                                <th class='text-center'>APELLIDOS Y NOMBRES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($subordinados as $subordinado) { ?>
                                <tr>
                                    <td class='text-center'><?= $subordinado['numDocumento'] ?></td>
                                    <td><?= $subordinado['nombre'] ?></td>
                                </tr>
                            <?php  } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php  } ?>

</form>

<script>
    $('#fechaInicio').daterangepicker(singleDatePickerModal);

    $('.my_select2Update').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });
</script>