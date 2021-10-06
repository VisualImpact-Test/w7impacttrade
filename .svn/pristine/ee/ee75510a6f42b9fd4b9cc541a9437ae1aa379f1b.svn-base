<form id="formUpdate">
    <input class="d-none" type="text" name="idEncuesta" value="<?= $data['idEncuesta'] ?>">

    <div class='form-row'>

        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre' value="<?= $data['nombre'] ?>">
        </div>

        
    </div>
    <div class='form-row'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='foto'>Foto</label><br>
            <select id='foto' name='foto' class='form-control form-control-sm my_select2'>
                <option value='1' <?= $data['foto'] == 1? 'selected' : ''?>> SÍ </option>
                <option value='2' <?= $data['foto'] == 0? 'selected' : ''?> > NO </option>
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