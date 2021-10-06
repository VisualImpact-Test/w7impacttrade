<form id="formUpdate">
    <div class='form-row'>

        <input class="d-none" type="text" name="idMenu" value="<?= $menu['idMenu'] ?>">

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombre'>Nombre:</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre' patron="requerido" value="<?= $menu['nombre'] ?>">
        </div>
    </div>
</form>