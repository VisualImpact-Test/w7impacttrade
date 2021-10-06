<form id="formNew">

    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='grupo'>Grupo</label><br>
            <select id="grupo" name="grupo" class="form-control my_select2_modalNewArchivo">
                <?=htmlSelectOptionArray2(['query'=>$grupos,'id'=>'idGrupo','value'=>'nombreGrupo','title'=>'--Seleccione--'])?>
            </select>
        </div>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='nombre'>Nombre de Carpeta</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control ' placeholder='Nombre de Carpeta'>
        </div>
    </div>
    
</form>

<script>
    $(".my_select2_modalNewArchivo").select2({
        dropdownParent: $("#formNew"),
        width: "100%"
    });
</script>