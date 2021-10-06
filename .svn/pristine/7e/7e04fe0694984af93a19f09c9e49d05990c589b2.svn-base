<form id="formNew">
    <div class='form-row'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='grupo'>Grupo</label><br>
            <select id="grupo" name="grupo" class="form-control form-control-sm my_select2_modalNew">
                <option value="">-- Seleccionar --</option>
                <?php foreach ($grupos as $grupo) {  ?>
                    <option value="<?= $grupo['idGrupo'] ?>"><?= $grupo['nombre'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='carpeta'>Carpeta</label>
            <input id='carpeta' name='carpeta' type='text' class='form-control form-control-sm' placeholder='Carpeta'>
        </div>
    </div>
</form>

<script>
    $(".my_select2_modalNew").select2({
        dropdownParent: $("div.modal-content-modalNew"),
        width: "100%"
    });
</script>