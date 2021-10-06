
<style>
.tableFixHead          { overflow-y: auto; height: 100px; }
.tableFixHead thead th { position: sticky; top: 0;padding: 8px 16px }
.tableFixHead tbody tr td { padding: 8px 16px }

table  { border-collapse: collapse; width: 100%; }
th     { background:#eee; }

</style>
<form id="formUpdate">
    <input class="d-none" type="text" name="idlst" value="<?= $data[$this->model->tablas['lista']['id']] ?>">

    <div class='form-row'>

        <?
            if( count($cuentas)==1 ){
                ?>
                <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2' style="display:none !important;">
                    <label for='cuenta'>Cuenta</label><br>
                        <select id='cuenta_cliente' name='cuenta' class='form-control form-control-sm my_select2 cuenta_cliente'>
                        <?php foreach ($cuentas as $idCuenta => $cuenta) { ?>
                            <option value='<?= $cuenta['idCuenta'] ?>' SELECTED><?= $cuenta['nombre'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <?
            }else{
                ?>
                <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
                    <label for='cuenta'>Cuenta</label><br>
                        <select id='cuenta_cliente' name='cuenta' class='form-control form-control-sm my_select2 cuenta_cliente'>
                        <option value=''>-- Seleccionar --</option>
                        <?php if (!empty($data['idCuenta'])) { ?>
                            <option value='<?= $data['idCuenta'] ?>' selected><?= $data['cuenta'] ?></option>
                        <?php } ?>
                        <?php foreach ($cuentas as $idCuenta => $cuenta) { ?>
                            <?php if ($data['idCuenta'] != $cuenta['idCuenta']) { ?>
                            <option value='<?= $cuenta['idCuenta'] ?>'><?= $cuenta['nombre'] ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <?
            }
        ?>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='proyecto'>Proyecto</label><br>
            <div class="proyecto_sl">
                <select id='proyecto' name='proyecto' class='form-control form-control-sm my_select2'>
                    <option value=''>-- Seleccionar --</option>

                        <?php if (!empty($data['idProyecto'])) { ?>
                            <option value='<?= $data['idProyecto'] ?>' selected><?= $data['proyecto'] ?></option>
                        <?php } ?>
                    <?php foreach ($proyectos as $idProyecto => $proyecto) { ?>
                        <?php if ($data['idProyecto'] != $proyecto['idProyecto']) { ?>
                        <option value='<?= $proyecto['idProyecto'] ?>'><?= $proyecto['nombre'] ?></option>
                        <?php } ?>

                    <?php } ?>
                </select>
            </div>
        </div>

    </div>
   

    <div class='form-row'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre' value="<?=  $data['nombreArchivo'] ?>">
        </div>
    </div>
    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='url'>Url Archivo</label><br>
            <input id='url' name='url' type='text' class='form-control form-control-sm' placeholder='Url Archivo' value="<?=  $data['urlArchivo'] ?>">
        </div>
    </div>
    
    
    
</form>



<script>
 
    $('.my_select2').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });
</script>