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
                        <?php foreach ($cuentas as $idCuenta => $cuenta) { ?>
                            <option value='<?= $cuenta['idCuenta'] ?>'><?= $cuenta['nombre'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <?
            }
        ?>
    </div>

    <div class='form-row'>
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
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
                    <label for='canal'>Canal</label><br>
                    <div class="canal_sl">
                     <select id='canal' name='canal' class='form-control form-control-sm my_select2 canal_cliente'>
                        <option value=''>-- Seleccionar --</option>
                        <?php foreach ($canales as $idCanal => $canal) { ?>
                            <option value='<?= $canal['idCanal'] ?>'><?= $canal['nombre'] ?></option>
                        <?php } ?>
                    </select>
                    </div>
                </div>
        
    </div>
    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
                    <label for='cliente'>Cliente</label><br>
                    <div class="cliente_sl">
                    <select id='cliente' name='cliente' class='form-control form-control-sm my_select2'>
                        <option value=''>-- Seleccionar --</option>
                        <?php foreach ($clientes as $idCliente => $cliente) { ?>
                            <option value='<?= $cliente['idCliente'] ?>'><?= $cliente['razonSocial'] ?></option>
                        <?php } ?>
                    </select>
                    </div>
                </div>
    </div>

    <div class="form-row">
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaInicio'>Fecha Inicio</label><br>
            <input id='fechaInicio' name='fechaInicio' type='text' class='form-control form-control-sm' placeholder='Fecha Inicio'>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaFin'>Fecha Fin</label><br>
            <input id='fechaFin' name='fechaFin' type='text' class='form-control form-control-sm' placeholder='Fecha Fin'>
        </div>
    </div>
    <div class="form-row mb-3">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                <table class='table table-sm table-bordered text-nowrap'>
                    <thead class='thead-light'>
                        <tr>
                            <th class="text-center align-middle">
                                ACTUALIZAR
                            </th>
                            <th class="text-center align-middle">
                                <div class="wr-20">PRODUCTOS</div>
                            </th>
                            <th class="text-center align-middle">
                                <button  class="btn btn-AgregarElemento btn-secondary" title="Agregar Elemento"><strong>AGREGAR FILA</strong> <i class="fa fa-plus"></i></button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class='trPadre d-none' data-select2="<?= $select2 ?>" data-classmodal="<?=$class?>">
                            <td></td>

                            <td class="text-center" data-name='<?= $nameSelectEncuesta ?>'>
                                <select class='form-control form-control-sm'>
                                    <option value=''>-- Seleccionar --</option>
                                    <?php foreach ($elementos as $idElemento => $elemento) { ?>
                                        <option value='<?= $elemento[$this->model->tablas['elemento']['id']] ?>'><?= $elemento['nombre'] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="text-left">
                                <button style="left: 45%;" class="border-0 btn btn-BorrarElemento btn-outline-secondary" title="Eliminar Elemento"><i class="fa fa-trash"></i></button>
                            </td> 
                        </tr>

                        <?php
                        foreach ($lista_elementos as $key => $row) { ?>
                            <tr class='trHijo table-secondary' data-fila="<?=$num?>">
                                <td class="text-center">
                                    <input name='id-<?= $num ?>' class="chk-ActualizarElemento" type="checkbox" value='<?= $row[$this->model->tablas['listaDet']['id']] ?>'>
                                </td>
                                <td class="text-center">
                                    <input value="<?=$row['nombre']?>"  type="text" class="form-control form-control-sm" placeholder="textotest" disabled readonly="readonly">
                                </td>
                                <td class="text-left" >
                                    <button style="left: 45%;" class="border-0 btn btn-BorrarElemento btn-outline-secondary" title="Eliminar Elemento" disabled><i class="fa fa-trash"></i></button>
                                </td>

                            </tr>
                        <?php $num++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>



<script>

    $('#fechaInicio').daterangepicker(singleDatePickerModal);
    $('#fechaFin').daterangepicker($.extend({
        "autoUpdateInput": false,
    }, singleDatePickerModal));
    $('#fechaInicio').on('apply.daterangepicker', function(ev, picker) {
        $('#fechaFin').val('');
    });
    $('#fechaFin').on('apply.daterangepicker', function(ev, picker) {
        $.fechaLimite(picker, "#fechaFin", "#fechaInicio");
    });
    $('.my_select2').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });

    // var checkList = document.getElementById('listEncuestas');
    //     checkList.getElementsByClassName('anchor')[0].onclick = function (evt) {
    //         if (checkList.classList.contains('visible'))
    //             checkList.classList.remove('visible');
    //         else
    //             checkList.classList.add('visible');
    // }
    // // Todo esto para los dos primeros selects juntos
    // $('#fecIni').daterangepicker(singleDatePickerModal);
    // $('#fecFin').daterangepicker($.extend({
    //     "autoUpdateInput": false,
    // }, singleDatePickerModal));
    // $('#fecIni').on('apply.daterangepicker', function(ev, picker) {
    //     $('#fecFin').val('');
    // });
    // $('#fecFin').on('apply.daterangepicker', function(ev, picker) {
    //     $.fechaLimite(picker, "#fecFin", "#fecIni");
    // });

    // // Todo esto para los dos segundos selects juntos
    // $('#fecIni2').daterangepicker(singleDatePickerModal);
    // $('#fecFin2').daterangepicker($.extend({
    //     "autoUpdateInput": false,
    // }, singleDatePickerModal));
    // $('#fecIni2').on('apply.daterangepicker', function(ev, picker) {
    //     $('#fecFin2').val('');
    // });
    // $('#fecFin2').on('apply.daterangepicker', function(ev, picker) {
    //     $.fechaLimite(picker, "#fecFin2", "#fecIni2");
    // });

    // // Esto para poner el modal como parent para los select2
    // $('.my_select2').select2({
    //     dropdownParent: $("div.modal-content"),
    //     width: '100%'
    // });
</script>