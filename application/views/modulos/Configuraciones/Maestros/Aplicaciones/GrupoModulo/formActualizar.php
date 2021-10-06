<form id="formUpdate">
    <div class='form-row'>

        <input class="d-none" type="text" name="idModuloGrupo" value="<?= $grupoModulo['idModuloGrupo'] ?>">

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombre'>Nombre:</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre' patron="requerido" value="<?= $grupoModulo['modulogrupo'] ?>">
        </div>

    </div>
</form>

<script>
    $('.my_select2').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });
</script>