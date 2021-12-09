<form id="formEditarHistorico">
    <input class='d-none' type='text' name='menu' value='<?= $menu ?>'>
    <input class='d-none' type='text' name='idUsuario' value='<?= $idUsuario ?>'>

    <div class='form-row'>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
            <h6><i class="fa fa-pencil-square-o"></i> Registrar Modulos de Intranet: </h6>
            <hr class="solid mb-2 mt-0">
        </div>
    </div>

    <div class='form-row mb-0'>
        <?php foreach ($grupoMenus as $idGrupoMenu => $grupoMenu) { ?>
            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
                <div class="form-check form-check-inline">
                    <input id="grupoMenu<?= $grupoMenu['idGrupoMenu'] ?>" class="form-check-input checkPadre" data-checkhijo="grupoMenu<?= $grupoMenu['idGrupoMenu'] ?>" type="checkbox" value="">
                    <b style="text-transform: uppercase;">
                        <label for="grupoMenu<?= $grupoMenu['idGrupoMenu'] ?>" class="form-check-label"><?= $grupoMenu['grupoMenu'] ?></label>
                    </b>
                </div>
            </div>
            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
                <div class="form-row">
                    <?php foreach ($menuOpciones[$grupoMenu['idGrupoMenu']] as $idMenuOpcion => $menuOpcion) {
                        $seleccionado = (in_array($menuOpcion['idMenuOpcion'], $modulosDeIntranetDeUsuario)) ? 'checked' : '';
                    ?>
                        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
                            <div class="form-check">
                                <input data-checkhijo="grupoMenu<?= $grupoMenu['idGrupoMenu'] ?>" name="menuOpcion" id="menuOpcion<?= $menuOpcion['idMenuOpcion'] ?>" class="form-check-input checkHijo" type="checkbox" value="<?= $menuOpcion['idMenuOpcion'] ?>" <?= $seleccionado ?>>
                                <label for="menuOpcion<?= $menuOpcion['idMenuOpcion'] ?>" class="form-check-label">
                                    <?if(!empty( $menuOpcion['icono'])){?>
                                        <i style="color: gray;" class="<?= $menuOpcion['icono']?>"></i>
                                    <?}?>
                                    <?= $menuOpcion['menuOpcion'] ?>
                                </label>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php
            end($grupoMenus);
            if ($idGrupoMenu != key($grupoMenus)) { ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                    <hr class="mb-2 mt-0">
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</form>