<form id="formEditarHistorico">
    <input class='d-none' type='text' name='menu' value='<?= $menu ?>'>
    <input class='d-none' type='text' name='idUsuario' value='<?= $idUsuario ?>'>

    <? if(!empty($carpetas)){?>
    <div class='form-row'>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
            <h6><i class="fa fa-pencil-square-o"></i> Registrar Carpetas de Usuario: </h6>
            <hr class="solid mb-2 mt-0">
        </div>
    </div>

    <div class='form-row mb-0'>
        <?php foreach ($grupos as $idGrupo => $grupo) { ?>
            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
                <div class="form-check form-check-inline">
                    <input id="grupo<?= $grupo['idGrupo'] ?>" class="form-check-input checkPadre" data-checkhijo="grupo<?= $grupo['idGrupo'] ?>" type="checkbox" value="">
                    <label for="grupo<?= $grupo['idGrupo'] ?>" class="form-check-label"><?= $grupo['nombreGrupo'] ?></label>
                </div>
            </div>
            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
                <div class="form-row">
                    <?php foreach ($carpetas[$grupo['idGrupo']] as $idCarpeta => $carpeta) {
                        $seleccionado = (in_array($carpeta['idCarpeta'], $carpetasDeUsuario)) ? 'checked' : '';
                    ?>
                        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
                            <div class="form-check">
                                <input data-checkhijo="grupo<?= $grupo['idGrupo'] ?>" name="idCarpeta" id="idCarpeta<?= $carpeta['idCarpeta'] ?>" class="form-check-input checkHijo" type="checkbox" value="<?= $carpeta['idCarpeta'] ?>" <?= $seleccionado ?>>
                                <label for="idCarpeta<?= $carpeta['idCarpeta'] ?>" class="form-check-label"><?= $carpeta['nombreCarpeta'] ?></label>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php
            end($grupos);
            if ($idGrupo != key($grupos)) { ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                    <hr class="mb-2 mt-0">
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <?}else{?>
        <?= getMensajeGestion('noResultados')?>
    <?}?>

</form>