<form id="formNew">
    <div class='form-row'>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='idCuenta'>Cuenta:</label><br>
            <select class="form-control form-control-sm my_select2" name="idCuenta" id="idCuenta" patron="requerido">
                <?= htmlSelectOptionArray2(['query' => $cuentas, 'id' => 'idCuenta', 'value' => 'nombre', 'title' => '-- Seleccione --']) ?>
            </select>
        </div>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='idProyecto'>Proyecto:</label><br>
            <div id="idProyecto_select">
                <select class="form-control form-control-sm my_select2" name="idProyecto" id="idProyecto" patron="requerido">
                    <?= htmlSelectOptionArray2(['query' => null, 'id' => 'idProyecto', 'value' => 'proyecto', 'title' => '-- Seleccione --']) ?>
                </select>
            </div>
        </div>


        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='idGrupoCanal'>Grupo Canal:</label><br>
            <div id="idGrupoCanal_select">
                <select class="form-control form-control-sm my_select2" name="idGrupoCanal" id="idGrupoCanal">
                    <?= htmlSelectOptionArray2(['query' => null, 'id' => 'idGrupoCanal', 'value' => 'grupoCanal', 'title' => '-- Seleccione --']) ?>
                </select>
            </div>
        </div>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='idTipoUsuario'>Tipo Usuario:</label><br>
            <div id="idTipoUsuario_select">
                <select class="form-control form-control-sm my_select2" name="idTipoUsuario" id="idTipoUsuario">
                    <?= htmlSelectOptionArray2(['query' => null, 'id' => 'idTipoUsuario', 'value' => 'nombre', 'title' => '-- Seleccione --']) ?>
                </select>
            </div>
        </div>


        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='idAplicacion'>Aplicacion:</label><br>
            <select class="form-control form-control-sm my_select2" name="idAplicacion" id="idAplicacion" patron="requerido">
                <?= htmlSelectOptionArray2(['query' => $aplicaciones, 'id' => 'idAplicacion', 'value' => 'aplicacion', 'title' => '-- Seleccione --']) ?>
            </select>
        </div>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='idMenu'>Menu:</label><br>
            <select class="form-control form-control-sm my_select2" name="idMenu" id="idMenu" patron="requerido">
                <?= htmlSelectOptionArray2(['query' => $menus, 'id' => 'idMenu', 'value' => 'nombre', 'title' => '-- Seleccione --']) ?>
            </select>
        </div>


    </div>
</form>

<script>
    $('.my_select2').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });
    Aplicaciones.proyectos = JSON.parse('<?=json_encode($proyectos)?>');
    Aplicaciones.grupoCanal = JSON.parse('<?=json_encode($grupoCanales)?>');
    Aplicaciones.tipoUsuario = JSON.parse('<?=json_encode($tipoUsuarios)?>');
</script>