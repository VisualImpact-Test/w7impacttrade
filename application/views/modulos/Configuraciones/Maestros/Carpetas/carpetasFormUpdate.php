<form id="formUpdate">
    <input class='d-none' type='text' name='idCarpeta' value='<?= $carpeta['idCarpeta'] ?>'>
    <div class='form-row'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='grupo'>Grupo</label><br>
            <select id="grupo" name="grupo" class="form-control form-control-sm my_select2_modalUpdate" readonly>
                <option value="<?= $carpeta['idGrupo'] ?>"><?= $carpeta['nombreGrupo'] ?></option>
            </select>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='carpeta'>Carpeta</label>
            <input id='carpeta' name='carpeta' type='text' class='form-control form-control-sm' placeholder='Carpeta' value="<?= $carpeta['nombreCarpeta'] ?>">
        </div>
    </div>
</form>

<script>
    $(".my_select2_modalUpdate").select2({
        dropdownParent: $("div.modal-content-modalUpdate"),
        width: "100%"
    });
</script>