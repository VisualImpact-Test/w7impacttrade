<form id="formUpdate">
    <input class="d-none" type="text" name="idx" value="<?= $data[$this->model->tablas['responsable']['id']] ?>">

    <div class='form-row'>
        <input type="hidden" name="sl_cuenta" id="sl_cuenta" value="3">
        <input type="hidden" name="sl_proyecto" id="sl_proyecto" value="3">
            <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
                <label for='sl_tipo'>Tipo Responsable</label><br>
                <select class="my_select2_modal form-control" name="sl_tipo" id="sl_tipo">
                    <?=htmlSelectOptionArray($tipos,$data['idTipo'])?>
                </select>
            </div>
            <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
                <label for='email'>Email</label><br>
                <input value="<?=$data['email']?>" id='email' name='email' type='text' class='form-control form-control-sm' placeholder='Email'>
            </div>
            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
                <label for='nombres'>Nombres</label><br>
                <input value="<?=$data['nombres']?>" id='nombres' name='nombres' type='text' class='form-control form-control-sm' placeholder='Nombres'>
            </div>
            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
                <label for='apellidos'>Apellidos</label><br>
                <input value="<?=$data['apellidos']?>" id='apellidos' name='apellidos' type='text' class='form-control form-control-sm' placeholder='Apellidos'>
            </div>
    </div>
</form>
<script>
    $('.my_select2_modal').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });
</script>
