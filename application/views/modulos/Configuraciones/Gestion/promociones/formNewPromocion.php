<form id="formNew">
    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre'>
        </div>
    </div>
    <div class='form-row'>
         <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
             <label for='tipo'>Tipo Promoción</label><br>

                        <select id='tipo' name='tipo' class='form-control form-control-sm my_select2'>
                            <option value=''>-- Seleccionar --</option>
                            <?php foreach ($tipos as $idTipo => $tipo) { ?>
                                <option value='<?= $tipo['idTipoPromocion'] ?>'><?= $tipo['nombre'] ?></option>
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
