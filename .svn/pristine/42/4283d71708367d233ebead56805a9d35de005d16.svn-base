<?php
$num = 1;
$nameSelectEncuesta = 'elemento_lista';
$nameSelectOrden = 'orden_lista';
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
<form id="formUpdate">
    <input class="d-none" type="text" name="idlst" value="<?= $data['idLista'] ?>">
    <div class="form-row">
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaInicio'>Fecha Inicio</label><br>
            <input id='fechaInicio' name='fechaInicio' type='text' class='form-control form-control-sm' placeholder='Fecha Inicio' value="<?= date_change_format($data['fecInicio']) ?>">
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaFin'>Fecha Fin</label><br>
            <input id='fechaFin' name='fechaFin' type='text' class='form-control form-control-sm' placeholder='Fecha Fin' value="<?= date_change_format($data['fecFinal']) ?>">
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
                                    <div class="wr-20">TIPO ELEMENTO</div>
                                </th>
                                <th class="text-center align-middle">
                                    <div class="wr-20">ELEMENTOS</div>
                                </th>
                                <th class="text-center align-middle">
                                    <div class="wr-20">ORDEN</div>
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
                                    <td class="text-center">
                                        <select class='form-control form-control-sm tipoElemento'>
                                            <option value=''>-- Seleccionar --</option>
                                            <?php foreach ($tipo_elementos as $idTipoElemento => $tipoElemento) { ?>
                                                <option value='<?= $idTipoElemento?>'><?= $tipoElemento?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td class="text-center" data-name='<?= $nameSelectEncuesta ?>'>
                                       <div style="z-index: -1;">
                                            <select class='form-control form-control-sm elementoVisibilidad'>
                                                <option value=''>-- Seleccionar --</option>
                                                <?php foreach ($elementos as $idElemento => $elemento) { ?>
                                                    <option value='<?= $elemento[$this->model->tablas['elemento']['id']] ?>'><?= $elemento['nombre'] ?></option>
                                                <?php } ?>
                                            </select>
                                       </div>
                                    </td>
                                    <td class="text-center" data-name='<?= $nameSelectOrden ?>'>
                                        <input name='orden' type='text' class='form-control form-control-sm' placeholder='Orden'>
                                    </td>
                                    <td class="text-left">
                                        <div style="padding-left: 45%;">
                                            <button  class="border-0 btn-BorrarElemento btn-outline-secondary" title="Eliminar Elemento"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </td> 
                                </tr>

                                <?php
                                foreach ($lista_elementos as $row) { ?>
                                    <tr class='trHijo table-secondary' data-fila="<?=$num?>">
                                        <td class="text-center">
                                            <input name='id-<?= $num ?>' class="chk-ActualizarElemento" type="checkbox" value='<?= $row['idListaDet'] ?>'>
                                        </td>
                                        <td class="text-center">
                                            <input value="<?=$row['tipo']?>"  type="text" class="form-control form-control-sm" placeholder="textotest" disabled readonly="readonly">
                                        </td>
                                        <td class="text-center">
                                            <input value="<?=$row['nombre']?>"  type="text" class="form-control form-control-sm" placeholder="textotest" disabled readonly="readonly">
                                        </td>
                                        <td class="text-center">
                                            <input value="<?=$row['orden']?>" type='text' class='form-control form-control-sm' placeholder='Orden' placeholder="textotest" disabled readonly="readonly">
                                        </td>
                                        
                                        <td class="text-left" >
                                            <div style="padding-left: 45%;">
                                                <button  class="border-0   btn-BorrarElemento btn-outline-secondary" title="Eliminar Elemento" disabled><i class="fa fa-trash"></i></button>
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
    $('.my_select2').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });
    TradeVisibilidad.elementosVisibilidad=<?=json_encode($elementos_visibilidad)?>   
</script>