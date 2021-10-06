<?php
$num = 1;
$nameSelectEncuesta = 'elemento_lista';
$select2 = "my_select2AgregarLista"; 
$class = "modalNew";
?>
<form id="formNew">

    <div class='form-row'>
        <?
        if( count($cuentas)==1 ){
            ?>
            <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2' style="display:none !important;">
                <select id='cuenta_cliente' name='cuenta' class='form-control form-control-sm my_select2 cuenta_cliente' >
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
                <?php foreach ($cuentas as $idCuenta => $cuenta) { ?>
                    <option value='<?= $cuenta['idCuenta'] ?>'><?= $cuenta['nombre'] ?></option>
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
                <?php foreach ($proyectos as $idProyecto => $proyecto) { ?>
                    <option value='<?= $proyecto['idProyecto'] ?>'><?= $proyecto['nombre'] ?></option>
                <?php } ?>
            </select>
            </div>
        </div>
       
    </div>

    <div class='form-row'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre'>
        </div>
    </div>
    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='url'>Url Archivo</label><br>
            <input id='url' name='url' type='text' class='form-control form-control-sm' placeholder='Url Archivo'>
        </div>
    </div>
       

    
     
</form>



<script>

    $('.my_select2').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });
</script>