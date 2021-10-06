<form id="formNew">
    <div class='form-row'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre'>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='detallar'>Detallar</label><br>
            <select class="form-control" name="detallar" id="detallar">
                <option value="0">NO</option>
                <option value="1">SI</option>
            </select>
        </div>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='tipoEvaluacion'>Tipo Evaluación</label><br>
            <select class="form-control" name="tipoEvaluacion" id="tipoEvaluacion">
                <?=htmlSelectOptionArray($tiposEvaluacion)?>
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
