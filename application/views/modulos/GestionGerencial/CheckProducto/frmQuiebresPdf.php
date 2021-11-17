<form id="formPdfQuiebres">
    <div class='form-row'>
        <div class='col-md-12  mb-2'>
            <label for='topClientes'>Cantidad máxima de clientes por PDF</label><br>
            <div >
                <select id='topClientes' name='topClientes' class='form-control  my_select2_modal'>
                    <option value='20'>20</option>
                    <option value='40'>40</option>
                    <option value='60'>60</option>
                    <option value='80'>80</option>
                    <option value='100'>100</option>
                </select>
            </div>
        </div>
        <div class='col-md-12  mb-2'>
            <label for='clientes'>Clientes</label><br>
            <select id='clientes' name='clientes' class='form-control my_select2_clientes' multiple>
                <option value=''>-- Escriba los clientes --</option>
            </select>
        </div>
    </div>
</form>
<script>
    $('.my_select2_modal').select2({
        dropdownParent: $("#formPdfQuiebres"),
        width: '100%'
    });

    $('.my_select2_clientes').select2({
        dropdownParent: $("#formPdfQuiebres"),
        tags: true,
        width: '100%',
        tokenSeparators: [',',' '],
        maximumSelectionLength: 20,
     
    });

    $('#topClientes').change(function(){
        let tope = $(this).val();
        $('.my_select2_clientes').select2({
        dropdownParent: $("#formPdfQuiebres"),
        tags: true,
        width: '100%',
        tokenSeparators: [',',' '],
        maximumSelectionLength: tope,
     
    });
    });

</script>