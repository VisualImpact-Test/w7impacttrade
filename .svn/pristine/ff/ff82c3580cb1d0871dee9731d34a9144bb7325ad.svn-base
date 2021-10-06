<style>
.tableFixHead          { overflow-y: auto; height: 100px; }
.tableFixHead thead th { position: sticky; top: 0;padding: 8px 16px }
.tableFixHead tbody tr td { padding: 8px 16px }

table  { border-collapse: collapse; width: 100%; }
th     { background:#eee; }
</style>
<?php
$num = 1;
$nameSelectElemento= 'iniciativa_elemento';
$nameSelectMotivo= 'iniciativa_elemento_motivo';
$select2 = "my_select2AgregarElemento"; 
$class = "modalNew";
?>

<form id="formNew">
    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre'>
        </div>
    </div>
    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='descripcion'>Descripción</label><br>
            <input id='descripcion' name='descripcion' type='text' class='form-control form-control-sm' placeholder='Descripción'>
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
                <table class='table-Success table-sm table-bordered text-nowrap tableFixHead'>
                    <div>
                        <thead class='thead-dark'>
                            <tr>
                                <th class="text-center align-middle">
                                    ACTUALIZAR
                                </th>
                                <th class="text-center align-middle">
                                    <div class="wr-20">ELEMENTO</div>
                                </th>
                                <th class="text-center align-middle">
                                    <div class="wr-20">MOTIVOS</div>
                                </th>
                                <div>
                                    <th class="text-center align-middle">
                                        <button  class="btn btn-AgregarElemento btn-primary" title="Agregar Elemento"><strong>AGREGAR FILA</strong> <i class="fa fa-plus"></i></button>
                                    </th>
                                </div>
                            </tr>
                        </thead>
                    </div>
                    <div>
                            <tbody>
                                <tr class='trPadre d-none' data-select2="<?= $select2 ?>" data-classmodal="<?=$class?>">
                                    <td></td>
                                    <td class="text-center" data-name='<?= $nameSelectElemento ?>'>
                                        <select class='form-control form-control-sm elemento'>
                                            <option value=''>-- Seleccionar --</option>
                                            <?php foreach ($elementos as $idElemento => $elemento) { ?>
                                                <option value='<?= $elemento['idElementoVis']?>'><?= $elemento['nombre']?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td class="text-left" data-name='<?= $nameSelectMotivo ?>'>
                                        <input type="text" class="motivos" value="" style="display:none;" >
                                        <div style="padding-left: 45%;">
                                            <button  class="border-0 btn-seleccionarMotivos btn-outline-secondary" title="Seleccionar Motivos"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </td> 

                                    <td class="text-left">
                                        <div style="padding-left: 45%;">
                                            <button  class="border-0 btn-BorrarElemento btn-outline-secondary" title="Eliminar Motivo"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </td> 
                                </tr>

                            </tbody>
                    </div>
                </table>
            </div>
        </div>
    </div>

</form>
<script>
    $('.my_select2').select2({
        dropdownParent: $("div.modal-content-<?= $class ?>"),
        width: '100%'
    });
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
</script>
