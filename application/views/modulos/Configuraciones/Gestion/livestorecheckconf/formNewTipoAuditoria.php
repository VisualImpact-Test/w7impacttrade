<form id="formNew">
    <div class='form-row'>
    <input type="hidden" name="sl_cuenta" id="sl_cuenta" value="3">
    <input type="hidden" name="sl_proyecto" id="sl_proyecto" value="3">
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre'>
        </div>
    </div>

</form>
<script>
    $('.my_select2').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });
</script>
