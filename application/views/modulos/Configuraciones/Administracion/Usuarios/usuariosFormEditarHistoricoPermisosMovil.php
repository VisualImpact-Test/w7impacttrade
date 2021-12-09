<form id="formEditarHistorico">
    <input class='d-none' type='text' name='menu' value='<?= $menu ?>'>
    <input class='d-none' type='text' name='idUsuario' value='<?= $idUsuario ?>'>
    <input class='d-none' type='text' name='idAplicacion' value='<?= $idAplicacion ?>'>

    <div class='form-row'>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
            <h6><i class="fa fa-pencil-square-o"></i> Registrar Modulos de Móvil: </h6>
            <hr class="solid mb-2 mt-0">
        </div>
    </div>

    <div class='form-row mb-0'>
        <?php if (count($modulosDeMovil) == 0) { ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                <p class="p-info"><i class="fa fa-info-circle"></i> Esta aplicación no tiene módulos.</p>
            </div>
        <?php } else { ?>
            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
                <div class="form-check form-check-inline">
                    <input id="todos" class="form-check-input checkPadre" data-checkhijo="modulosMovil" type="checkbox" value="">
                    <b style="text-transform: uppercase;">
                        <label for="todos" class="form-check-label">Todos</label>
                    </b>
                </div>
            </div>

            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
                <div class="form-row">
                    <?php foreach ($modulosDeMovil as $key => $value) {
                        $seleccionado = (in_array($value['idModulo'], $modulosDeMovilDeUsuario)) ? 'checked' : '';
                    ?>
                        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
                            <div class="form-check">
                                <input data-checkhijo="modulosMovil" name="modulosMovil" id="moduloMovil<?= $value['idModulo'] ?>" class="form-check-input checkHijo" type="checkbox" value="<?= $value['idModulo'] ?>" <?= $seleccionado ?>>
                                <label for="moduloMovil<?= $value['idModulo'] ?>" class="form-check-label"><?= $value['nombre'] ?></label>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

    </div>
</form>