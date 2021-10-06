<form id="formEditarHistorico">
    <input class='d-none' type='text' name='menu' value='<?=$menu?>'>
    <input class='d-none' type='text' name='idUsuarioHistorico' value='<?=$idUsuarioHistorico?>'>

    <div class='form-row'>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
            <h6><i class="fa fa-pencil-square-o"></i> Registrar Zonas: </h6>
            <hr class="solid mb-2 mt-0">
        </div>
    </div>

    <div class='form-row mb-0'>

        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <div class="form-check form-check-inline">
                <input id="todos" class="form-check-input checkPadre" data-checkhijo="zonas" type="checkbox" value="">
                <label for="todos" class="form-check-label">Todos</label>
            </div>
        </div>

        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <div class="form-row">
                <?php foreach ($zonas as $key => $value) {
                    $seleccionado = (in_array($value['idZona'], $zonasDeHistorico)) ? 'checked' : '';
                ?>
                    <div class='col-xs-3 col-sm-3 col-md-3 col-lg-3 mb-2'>
                        <div class="form-check">
                            <input data-checkhijo="zonas" name="zonas" id="zona<?= $value['idZona'] ?>" class="form-check-input checkHijo" type="checkbox" value="<?= $value['idZona'] ?>" <?= $seleccionado ?>>
                            <label for="zona<?= $value['idZona'] ?>" class="form-check-label"><?= $value['nombre'] ?></label>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</form>