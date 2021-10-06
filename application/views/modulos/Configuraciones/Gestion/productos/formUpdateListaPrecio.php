<form id="formUpdate">
    <input class="d-none" type="text" name="idx" value="<?= $data[$this->model->tablas['listaPrecio']['id']] ?>">

    <div class='form-row'>
                <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
                    <label for='grupoCanal'>Grupo Canal</label><br>
                    <select id='grupoCanal' name='grupoCanal' class='form-control form-control-sm my_select2 grupoCanal_cliente'>
                    <?php if (!empty($data['idGrupoCanal'])) { ?>
                        <option value='<?= $data['idGrupoCanal'] ?>' selected><?= $data['grupoCanal'] ?></option>
                    <?php } ?>
                    <?php foreach ($gruposCanal as $idGrupoCanal => $grupoCanal) { ?>
                        <?php if ($data['idGrupoCanal'] != $grupoCanal['idGrupoCanal']) { ?>
                            <option value='<?= $grupoCanal['idGrupoCanal'] ?>'><?= $grupoCanal['nombre'] ?></option>
                        <?php } ?>
                    <?php } ?>
                    </select>
                </div>
                <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
                    <label for='canal'>Canal</label><br>
                    <div class="canal_sl">
                        <select id='canal' name='canal' class='form-control form-control-sm my_select2 canal_cliente'>
                        <option value=''>-- Seleccionar --</option>
                        <?php if (!empty($data['idCanal'])) { ?>
                            <option value='<?= $data['idCanal'] ?>' selected><?= $data['canal'] ?></option>
                        <?php } ?>
                        <?php foreach ($canales as $idCanal => $canal) { ?>
                            <?php if ($data['idCanal'] != $canal['idCanal']) { ?>
                                <option value='<?= $canal['idCanal'] ?>'><?= $canal['nombre'] ?></option>
                            <?php } ?>
                        <?php } ?>
                        </select>
                    </div>
                </div>
    </div>
    <div class="form-row">
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='valorMin'>Valor Mínimo</label><br>
            <div class="input-group input-group-sm">
                <input id='valorMin' name='valorMin' type='text' class='form-control form-control-sm' placeholder='Valor Mínimo' value="<?=$data['valorMin']?>" >
                <div class="input-group-append">
                    <div class="input-group-text">%</div>
                </div>
            </div>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='valorMax'>Valor Máximo </label><br>
            <div class="input-group input-group-sm">
                <input id='valorMax' name='valorMax' type='text' class='form-control form-control-sm' placeholder='Valor Máximo' value="<?=$data['valorMax']?>">
                <div class="input-group-append">
                    <div class="input-group-text">%</div>
                </div>
            </div>
        </div>
    </div>

</form>
<script>

    $('#fechaInicio').daterangepicker(singleDatePickerModal);
    $('#fechaFin').daterangepicker($.extend({
        "autoUpdateInput": false,
    }, singleDatePickerModal));
    $('#fechaInicio').on('apply.daterangepicker', function(ev, picker) {
        $('#fechaFin').val('');
    });
    $('#fechaFin').on('apply.daterangepicker', function(ev, picker) {
        $.fechaLimite(picker, "#fechaFin", "#fechaInicio");
    });
    $('.my_select2').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });
    Productos.grupoCanal=<?=json_encode($arr_grupoCanal) ?>;
    
</script>
