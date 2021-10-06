<form id="formUpdate">
    <input class="d-none" type="text" name="idx" value="<?= $data[$this->model->tablas['elemento']['id']] ?>">

    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre' value="<?= $data['nombre'] ?>">
        </div>
    </div>
    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='nombreCorto'>Nombre Corto</label><br>
            <input id='nombreCorto' name='nombreCorto' type='text' class='form-control form-control-sm' placeholder='Nombre' value="<?=!empty($data['nombreCorto'])?$data['nombreCorto'] : ""?>">
        </div>
    </div>
    <div class='form-row'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='ean'>Ean</label><br>
            <input id='ean' name='ean' type='text' class='form-control form-control-sm' placeholder='ean' value="<?=!empty($data['ean'])?$data['ean'] : ""?>">
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='competencia'>Competencia</label><br>
            <div class="contenedor_marcas">
                <select id='competencia' name='competencia' class='form-control form-control-sm my_select2'>
                        <option value=''>-- Seleccionar --</option>
                        <option value='1' <?=!empty($data['nombreCorto'])? 'selected' : ""?>>SI</option>
                        <option value='0' <?=empty($data['nombreCorto'])? 'selected' : ""?>>NO</option>
                        
                </select>
            </div>
        </div>
    </div>
    <div class='form-row'>
                
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='marca'>Marcas</label><br>
            <div class="contenedor_marcas">
                <select id='marca' name='marca' class='form-control form-control-sm my_select2'>
                        <?php if (!empty($data['idMarca'])) { ?>
                            <option value='<?= $data['idMarca'] ?>' selected><?= $data['marca'] ?></option>
                        <?php } ?>
                    <?php foreach ($marcas as $idMarca => $marca) { ?>
                        <?php if ($data['idMarca'] != $marca['idMarca']) { ?>
                        <option value='<?= $marca['idMarca'] ?>'><?= $marca['nombre'] ?></option>
                        <?php } ?>

                    <?php } ?>
                </select>
            </div>
        </div>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='categoria'>Categorías</label><br>
            <select id='categoria' name='categoria' class='form-control form-control-sm my_select2'>
            <option value=''>-- Seleccionar --</option>
            <?php if (!empty($data['idCategoria'])) { ?>
                <option value='<?= $data['idCategoria'] ?>' selected><?= $data['categoria'] ?></option>
            <?php } ?>
            <?php foreach ($categorias as $idCategoria => $categoria) { ?>
                <?php if ($data['idCategoria'] != $categoria['idCategoria']) { ?>
                    <option value='<?= $categoria['idCategoria'] ?>'><?= $categoria['nombre'] ?></option>
                <?php } ?>
            <?php } ?>
            </select>
        </div>
        
        
    </div>
    <div class='form-row'>
                
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='envase'>Envases</label><br>
            <select id='envase' name='envase' class='form-control form-control-sm my_select2'>
                    <option value=''>-- Seleccionar --</option>

                    <?php if (!empty($data['idEnvase'])) { ?>
                        <option value='<?= $data['idEnvase'] ?>' selected><?= $data['envase'] ?></option>
                    <?php } ?>
                <?php foreach ($envases as $idEnvase => $envase) { ?>
                    <?php if ($data['idMarca'] != $envase['idEnvase']) { ?>
                    <option value='<?= $envase['idEnvase'] ?>'><?= $envase['descripcion'] ?></option>
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