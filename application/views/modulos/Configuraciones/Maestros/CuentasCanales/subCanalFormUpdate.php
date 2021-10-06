<form id="formUpdate">

    <input class="d-none" type="text" name="idSubCanal" value="<?= $subCanal['idSubCanal'] ?>">

    <div class='form-row'>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre' value="<?= $subCanal['nombre'] ?>">
        </div>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='canal'>Canal</label><br>
             <select id='canal' name='canal' class='form-control form-control-sm my_select2 canal_cliente'>
                <option value=''>-- Seleccionar --</option>
                <?php if (!empty($subCanal['idCanal'])) { ?>
                    <option value='<?= $subCanal['idCanal'] ?>' selected><?= $subCanal['canal'] ?></option>
                    <?php } ?>
                <?php foreach ($canales as $idCanal => $canal) { ?>
                    <?php if ($subCanal['idCanal'] != $canal['idCanal']) { ?>
                        <option value='<?= $canal['idCanal'] ?>'><?= $canal['nombre'] ?></option>
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