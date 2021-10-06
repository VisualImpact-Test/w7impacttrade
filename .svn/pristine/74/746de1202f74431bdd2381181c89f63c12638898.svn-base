<form id="formNew">
    <div class='form-row'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre'>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='departamento'>Departamento</label><br>
            <select class="form-control mySelect2Modal" name="departamento" id="departamento">
                <?= htmlSelectOptionArray2(['query' => $departamentos, 'id' => 'cod_departamento', 'value' => 'departamento', 'title' => '-- Seleccione --']) ?>
            </select>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='provincia'>Provincias</label><br>
            <select class="form-control mySelect2Modal" name="provincia" id="provincia">
                <option value="">-- Seleccione Departamento --</option>
            </select>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='cod_ubigeo'>Distrito</label><br>
            <select class="form-control mySelect2Modal" name="cod_ubigeo" id="cod_ubigeo">
                <option value="">-- Seleccione Provincia --</option>
            </select>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='cod_ubigeo'>Distribuidora</label><br>
            <select class="form-control mySelect2Modal" name="distribuidora" id="distribuidora">
                <?= htmlSelectOptionArray2(['query' => $distribuidoras, 'id' => 'cod_distribuidora', 'value' => 'distribuidora', 'title' => '-- Seleccione --']) ?>
            </select>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombre'>Correo:</label><br>
            <input id='correo' name='correo' type='text' class='form-control form-control-sm' placeholder='Correo' patron="requerido">
        </div>
    </div>

</form>
<script>
    $('.mySelect2Modal').select2({
        dropdownParent: $("#formNew"),
        width: '100%',
        placeholder: "-- Seleccione --"
    });
    $('#departamento').on('change', function() {
        let idDepartamento = $('#departamento').val();
        $("#provincia").empty();
        $('#provincia').select2({
            dropdownParent: $("#formNew"),
            width: '100%',
            placeholder: "-- Seleccione --",
            ajax: {
                url: site_url + Gestion.urlActivo + "getProvincias/",
                type: "POST",
                dataType: 'json',
                data: {
                    'cod_departamento': idDepartamento
                },
                processResults: function(result) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: result.items
                    };
                }
            }
        });
    });

    $('#provincia').on('change', function() {
        let idProvincia = $('#provincia').val();
        let idDepartamento = $('#departamento').val();
        $("#cod_ubigeo").empty();
        $('#cod_ubigeo').select2({
            dropdownParent: $("#formNew"),
            width: '100%',
            placeholder: "-- Seleccione --",
            ajax: {
                url: site_url + Gestion.urlActivo + "getDistritos/",
                type: "POST",
                dataType: 'json',
                data: {
                    'cod_provincia': idProvincia,
                    'cod_departamento': idDepartamento
                },
                processResults: function(result) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: result.items
                    };
                }
            }
        });
    });
</script>