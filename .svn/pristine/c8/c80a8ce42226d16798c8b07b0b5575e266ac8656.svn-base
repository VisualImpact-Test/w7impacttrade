<?php
$num = 1;
$nameSelect = 'elemento_lista';
$nameSelectOrden = 'orden_lista';
$select2 = "my_select2AgregarLista"; 
$class = "modalNew";
?>
<form id="formNew">

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
                                <div class="wr-20">TIPO ELEMENTO</div>
                            </th>
                            <th class="text-center align-middle">
                                <div class="wr-20">ELEMENTOS</div>
                            </th>
                            <th class="text-center align-middle">
                                <div class="wr-20">ORDEN</div>
                            </th>
                            <th class="text-center align-middle">
                                <button  class="btn btn-AgregarElemento btn-secondary" title="Agregar Elemento"><strong>AGREGAR FILA</strong> <i class="fa fa-plus"></i></button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class='trPadre d-none' data-select2="<?= $select2 ?>" data-classmodal="<?=$class?>">
                            <td></td>
                            <td class="text-center">
                                <select class='form-control form-control-sm tipoElemento'>
                                    <option value=''>-- Seleccionar --</option>
                                    <?php foreach ($tipo_elementos as $idTipoElemento => $tipoElemento) { ?>
                                        <option value='<?= $idTipoElemento?>'><?= $tipoElemento?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="text-center" data-name='<?= $nameSelect ?>'>
                                <select class='form-control form-control-sm elementoVisibilidad'>
                                    <option value=''>-- Seleccionar --</option>
                                </select>
                            </td>
                            <td class="text-center" data-name='<?= $nameSelectOrden ?>'>
                                <input name='orden' type='text' class='form-control form-control-sm' placeholder='Orden'>
                            </td>
                            <td class="text-left">
                                <button style="left: 45%;" class="border-0 btn btn-BorrarElemento btn-outline-secondary" title="Eliminar Elemento"><i class="fa fa-trash"></i></button>
                            </td> 
                        </tr>
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
        width: '100%'
    });

    Obligatoria.elementosVisibilidad=<?=json_encode($elementos_visibilidad)?> 
</script>