<form id="formNew">
    <div class='form-row'>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombre'>Nombre:</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre' patron="requerido">
        </div>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='idAplicacion'>Aplicacion:</label><br>
            <select class="form-control form-control-sm my_select2" name="idAplicacion" id="idAplicacion" patron="requerido">
                <?= htmlSelectOptionArray2(['query' => $aplicaciones, 'id' => 'idAplicacion', 'value' => 'aplicacion', 'title' => '-- Seleccione --']) ?>
            </select>
        </div>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='idModuloGrupo'>Grupo Modulo:</label><br>
            <select class="form-control form-control-sm my_select2" name="idModuloGrupo" id="idModuloGrupo" patron="requerido">
                <?= htmlSelectOptionArray2(['query' => $grupoModulo, 'id' => 'idModuloGrupo', 'value' => 'modulogrupo', 'title' => '-- Seleccione --']) ?>
            </select>
        </div>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='orden'>Orden:</label><br>
            <input id='orden' name='orden' type='text' class='form-control form-control-sm' placeholder='Orden' patron="requerido">
        </div>

    </div>
</form>

<script>
    $('.my_select2').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });
</script>