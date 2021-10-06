<style>
    legend.form-legend {
    font-size: 13px;
    border-bottom: 2px solid #ddd;
}
legend {
    display: block;
    width: 100%;
    padding: 0;
    margin-bottom: 20px;
    font-size: 21px;
    line-height: inherit;
    color: #333;
    border: 0;
    border-bottom: 1px solid #e5e5e5;
}
fieldset {
    min-width: 0;
    padding: 0;
    margin: 0;
    border: 0;
}
</style>
<form id="formUpdate">
    <input type="hidden" name="idx" value="<?= $idUsuario ?>">
    <div class="form-row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php foreach ($grupos as $indiceGrupo => $grupo) { ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <fieldset>
                        <legend class="form-legend">
                            <label><?= $grupo['nombreGrupo'] ?> </label>
                            <input type="checkbox" data-grupo="<?= $grupo['idGrupo'] ?>" class="checkGrupo">
                        </legend>
                        <?php $contador = 1;
                        foreach ($categorias[$grupo['idGrupo']] as $categoria) { ?>
                            <?= (($contador % 4) == 1) ? '<div class="row">' : '' ?>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <div class="row">
                                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                        <input class="<?= $grupo['idGrupo'] ?>" id="<?= $categoria['idGrupo'] ?>-<?= $categoria['idCarpeta'] . 'a' ?>" type="checkbox" name="<?= $categoria['idGrupo'] ?>-<?= $categoria['idCarpeta'] . 'a' ?>" <?= isset($permisos[$categoria['idGrupo']][$categoria['idCarpeta']]) ? 'checked' : '' ?>>
                                        <input class="hide" type="checkbox" name="<?= $categoria['idGrupo'] ?>-<?= $categoria['idCarpeta'] . 'b' ?>" <?= isset($permisos[$categoria['idGrupo']][$categoria['idCarpeta']]) ? 'checked' : '' ?>>
                                        <input class="hide" type="checkbox" name="<?= $categoria['idGrupo'] ?>-<?= $categoria['idCarpeta'] ?>" checked>
                                    </div>
                                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                        <label for="<?= $categoria['idGrupo'] ?>-<?= $categoria['idCarpeta'] . 'a' ?>"><?= $categoria['nombreCategoria'] ?></label>
                                    </div>
                                </div>
                            </div>
                            <?= (($contador % 4) == 0) ? '</div>' : '' ?>
                        <?php $contador++;
                        } ?>
                    </fieldset>
                    <br>
                </div>

            <?php } ?>
        </div>
    </div>

</form>

<script>

    $(document).on('change', '.checkGrupo', function() {
        var grupo = $(this).attr('data-grupo');

        if ($(this).is(':checked')) {
            $('.' + grupo).attr('checked', true);
        } else {
            $('.' + grupo).attr('checked', false);
        }

    });
</script>