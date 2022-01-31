<form id="formUpdate">
    <input class="d-none" type="text" name="idGrupoCanal" value="<?= $grupoCanal['idGrupoCanal'] ?>">
    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre' value='<?= $grupoCanal['nombre'] ?>'>
        </div>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='nombre'>Nombre Corto</label><br>
            <input id='nombreCorto' name='nombreCorto' type='text' class='form-control form-control-sm' placeholder='Nombre corto' value='<?= $grupoCanal['nombreCorto'] ?>'>
        </div>
    </div>
</form>