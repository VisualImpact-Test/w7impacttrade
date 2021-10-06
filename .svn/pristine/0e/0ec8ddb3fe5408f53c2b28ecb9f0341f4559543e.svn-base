<?php
$num = 1;
$nameSelect = 'elemento_lista';
$select2 = "my_select2AgregarLista"; 
$class = "modalUpdate";
?>
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
$class = "modalUpdate";
?>
<form id="formUpdate">
    <input class="d-none" type="text" id="idx" name="idx" value="<?= $data[$this->model->tablas['elemento']['id']] ?>">

    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre' value="<?= $data['nombre'] ?>">
        </div>
    </div>
    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='descripcion'>Descripcion</label><br>
            <input id='descripcion' name='descripcion' type='text' class='form-control form-control-sm' placeholder='Descripción' value="<?= $data['descripcion'] ?>">
        </div>
    </div>
    <div class="form-row">
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaInicio'>Fecha Inicio</label><br>
            <input id='fechaInicio' name='fechaInicio' type='text' class='form-control form-control-sm' placeholder='Fecha Inicio' value="<?= date_change_format($data['fecIni']) ?>">
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaFin'>Fecha Fin</label><br>
            <input id='fechaFin' name='fechaFin' type='text' class='form-control form-control-sm' placeholder='Fecha Fin' value="<?= date_change_format($data['fecFin']) ?>">
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

                                <?php
                                foreach ($elementos_iniciativa as $row) { ?>
                                    <tr class='trHijo table-secondary' data-fila="<?=$num?>">
                                        <td class="text-center">
                                            <input name='id-<?= $num ?>' class="chk-ActualizarElemento" type="checkbox" value='<?= $row['idElementoVis'] ?>'>
                                        </td>
                                        <td class="text-center">
                                            <input value="<?=$row['nombre']?>"  type="text" class="form-control form-control-sm" placeholder="textotest" disabled readonly="readonly">
                                        </td>

                                        <td class="text-left"  >
                                            <input type="text" value="" style="display:none;" >
                                            <div style="padding-left: 45%;">
                                                <button  class="border-0 btn-seleccionarMotivosExistente btn-outline-secondary" title="Seleccionar Motivos" data-id="<?= $row['idElementoVis'] ?>"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </td> 
                                        
                                        <td class="text-left" >
                                            <div style="padding-left: 45%;">
                                                <button  class="border-0   btn-BorrarElemento btn-outline-secondary" title="Eliminar Motivo" disabled><i class="fa fa-trash"></i></button>
                                            </div>
                                        </td>

                                    </tr>
                                <?php $num++;
                                } ?>
                            </tbody>
                    </div>
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
    
</script>
