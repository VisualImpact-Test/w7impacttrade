<form id="formUpdate">
    <input class='d-none' type='text' name='idCuenta' id="idCuenta" value='<?= $cuenta['idCuenta'] ?>'>
    <div class='form-row'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombre'>Nombre</label>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre' value="<?= $cuenta['nombre'] ?>">
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='ruc'>Ruc</label>
            <input id='ruc' name='ruc' type='text' class='form-control form-control-sm' placeholder='Ruc' value="<?= $cuenta['ruc'] ?>">
        </div>
    </div>

    <div class="form-row">
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombreComercial'>Nombre Comercial</label>
            <input id='nombreComercial' name='nombreComercial' type='text' class='form-control form-control-sm' placeholder='Nombre Comercial' value="<?= $cuenta['nombreComercial'] ?>">
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='razonSocial'>Razón Social</label>
            <input id='razonSocial' name='razonSocial' type='text' class='form-control form-control-sm' placeholder='Razón Social' value="<?= $cuenta['razonSocial'] ?>">
        </div>
    </div>

    <div class='form-row'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='direccion'>Dirección</label>
            <input id='direccion' name='direccion' type='text' class='form-control form-control-sm' placeholder='Dirección' value="<?= $cuenta['direccion'] ?>">
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='ubigeo'>Ubigeo</label>
            <input id='ubigeo' name='ubigeo' type='text' class='form-control form-control-sm' placeholder='Ubigeo' value="<?= $cuenta['cod_ubigeo'] ?>">
        </div>
    </div>

    <div class='form-row'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='urlCss'>Url Css</label>
            <input id='urlCss' name='urlCss' type='text' class='form-control form-control-sm' placeholder='Url Css' value="<?= $cuenta['urlCSS'] ?>">
        </div>
        <!-- <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='urlLogo'>Url Logo</label>
            <input id='urlLogo' name='urlLogo' type='text' class='form-control form-control-sm' placeholder='Url Logo' value="<?= $cuenta['urlLogo'] ?>">
        </div> -->
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2 contenedorImagen'>
            <label for='urlLogo'>Logo:</label>
            <br>
            <input type="file" class="form-control-file" name="inputFileCargo" id="inputFileCargo" patron="requerido" style="float: left; width:80%">
            <a href="javascript:;" data-foto="<?= base_url(); ?>public/assets/images/logos/<?= $cuenta['urlLogo'] ?>" class="prettyphoto <?= (!empty($cuenta['urlLogo']) ? '' : ' disabled') ?>" style="font-size: 20px;" title="Ver imagen"><i class="fa fa-file-image"></i></a>
        </div>
    </div>
</form>