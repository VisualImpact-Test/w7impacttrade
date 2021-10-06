<form id="formNew">
    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre'>
        </div>
    </div>
    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='nombreCorto'>Nombre Corto</label><br>
            <input id='nombreCorto' name='nombreCorto' type='text' class='form-control form-control-sm' placeholder='Nombre'>
        </div>
    </div>
    <div class='form-row'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='ean'>Ean</label><br>
            <input id='ean' name='ean' type='text' class='form-control form-control-sm' placeholder='ean'>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='competencia'>Competencia</label><br>
            <div class="contenedor_marcas">
                <select id='competencia' name='competencia' class='form-control form-control-sm my_select2'>
                        <option value=''>-- Seleccionar --</option>
                        <option value='1'>SI</option>
                        <option value='0'>NO</option>
                        
                </select>
            </div>
        </div>
    </div>
    <div class='form-row'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='marca'>Marcas</label><br>
            <div class="contenedor_marcas">
                <select id='marca' name='marca' class='form-control form-control-sm my_select2'>
                        <option value=''>-- Seleccionar --</option>
                        <?php foreach ($marcas as $idMarca => $marca) { ?>
                            <option value='<?= $marca['idMarca'] ?>'><?= $marca['nombre'] ?></option>
                        <?php } ?>
                </select>
            </div>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
             <label for='categoria'>Categorias</label><br>
            <select id='categoria' name='categoria' class='form-control form-control-sm my_select2'>
                <option value=''>-- Seleccionar --</option>
                <?php foreach ($categorias as $idCategoria => $categoria) { ?>
                    <option value='<?= $categoria['idCategoria'] ?>'><?= $categoria['nombre'] ?></option>
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