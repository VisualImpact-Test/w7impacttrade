<form id="formUpdate">

    <input type="hidden" name="idx" value="<?=$data['idCarpeta']?>">
    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='grupo'>Grupo</label><br>
            <select id="grupo" name="grupo" class="form-control my_select2_modalNewArchivo">
                <?=htmlSelectOptionArray2(['query'=>$grupos,'id'=>'idGrupo','value'=>'nombreGrupo','title'=>'--Seleccione--','selected'=>$data['idGrupo']])?>
            </select>
        </div>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='nombre'>Nombre de Carpeta</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control ' placeholder='Nombre de Carpeta' value="<?=$data['nombreCategoria']?>">
        </div>
    </div>
    
</form>

<script>
    $(".my_select2_modalNewArchivo").select2({
        dropdownParent: $("#formUpdate"),
        width: "100%"
    });
</script>