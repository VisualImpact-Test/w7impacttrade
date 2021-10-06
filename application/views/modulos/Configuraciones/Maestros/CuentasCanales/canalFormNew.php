<form id="formNew">
    <div class='form-row'>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre'>
        </div>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='grupoCanal'>Grupo Canal</label><br>
            <select id='grupoCanal' name='grupoCanal' class='form-control form-control-sm my_select2'>
                <option value=''>-- Seleccionar --</option>
                <?php foreach ($grupoCanales as $idGrupoCanal => $grupoCanal) { ?>
                    <option value='<?= $grupoCanal['idGrupoCanal'] ?>'><?= $grupoCanal['nombre'] ?></option>
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