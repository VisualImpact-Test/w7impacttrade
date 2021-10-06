<form id="formUpdate">
    <input class="d-none" type="text" name="idx" value="<?= $data[$this->model->tablas['unidadMedidaProducto']['id']] ?>">


    <div class='form-row'>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='producto'>Productos</label><br>
            <select id='producto' name='producto' class='form-control form-control-sm my_select2'>
                <option value=''>-- Seleccionar --</option>
                <?php if (!empty($data['idProducto'])) { ?>
                    <option value='<?= $data['idProducto'] ?>' selected><?= $data['producto'] ?></option>
                <?php } ?>
                
                <?php foreach ($productos as $idproducto => $producto) { ?>
                    <?php if ($data['idProducto'] != $productos['idCuenta']) { ?>
                        <option value='<?= $producto['idProducto'] ?>'><?= $producto['nombre'] ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
        </div>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='unidadMedida'>Unidad Medida</label><br>
            <div class="contenedor_unidadMedida">
                <select id='unidadMedida' name='unidadMedida' class='form-control form-control-sm my_select2'>
                    <option value=''>-- Seleccionar --</option>
                    <?php if (!empty($data['idUnidadMedida'])) { ?>
                        <option value='<?= $data['idUnidadMedida'] ?>' selected><?= $data['unidadMedida'] ?></option>
                    <?php } ?>
                    
                    <?php foreach ($unidadMedidas as $idunidadMedida => $unidadMedida) { ?>
                        <?php if ($data['idUnidadMedida'] != $unidadMedida['idUnidadMedida']) { ?>
                            <option value='<?= $unidadMedida['idUnidadMedida'] ?>'><?= $unidadMedida['nombre'] ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
        </div>
        
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='precio'>Precio</label><br>
            <input id='precio' name='precio' type='text' class='form-control form-control-sm' placeholder='Precio' value="<?= !empty($data['precio'])? $data['precio'] : '' ?>">
        </div>
              
    </div>
    
</form>
<script>

    $('.my_select2').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });
</script>
