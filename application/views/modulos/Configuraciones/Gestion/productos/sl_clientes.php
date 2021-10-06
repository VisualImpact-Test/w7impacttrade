<select id='cliente' name='cliente' class='form-control form-control-sm my_select2'>
                    <option value=''>-- Seleccionar --</option>
                    <?php foreach ($clientes as $idCliente => $cliente) { ?>
                            <option value='<?= $cliente['idCliente'] ?>'><?= $cliente['razonSocial'] ?></option>
                    <?php } ?>
</select>
<script>
$('.my_select2').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
});
</script>