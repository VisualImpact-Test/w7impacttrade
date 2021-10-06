<form id="formNewArchivo">

    <div class='form-row'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='grupo'>Grupo</label><br>
            <select id="grupo" name="grupo" class="form-control form-control-sm my_select2_modalNewArchivo">
                <option value="">-- Seleccionar --</option>
                <?php foreach ($grupos as $grupo) {  ?>
                    <option value="<?= $grupo['idGrupo'] ?>"><?= $grupo['nombreGrupo'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='carpeta'>Carpeta</label><br>
            <select id="carpeta" name="carpeta" class="form-control form-control-sm my_select2_modalNewArchivo">
                <option value="">-- Seleccionar --</option>
            </select>
        </div>

    </div>

    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='nombreArchivo'>Nombre de Archivo</label><br>
            <input id='nombreArchivo' name='nombreArchivo' type='text' class='form-control form-control-sm' placeholder='Nombre de Archivo'>
        </div>
    </div>

    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label>Archivo</label><br>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="archivo">
                <label class="custom-file-label" for="archivo">Elegir Archivo</label>
            </div>
        </div>
    </div>
    
</form>

<script>
    var carpetas = <?= json_encode($carpetas) ?>;
    $(".my_select2_modalNewArchivo").select2({
        dropdownParent: $("div.modal-content-modalNewArchivo"),
        width: "100%"
    });
    bsCustomFileInput.init();
</script>