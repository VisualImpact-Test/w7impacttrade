<?php
$num = 1;
$nameSelectEncuesta = 'elemento_lista';
$select2 = "my_select2AgregarLista"; 
$class = "modalUpdate";
?>
<style>

</style>
<form id="formUpdate">
    <input class="d-none" type="text" name="idlst" value="<?= $data[$this->model->tablas['lista']['id']] ?>">
    
    <div class='form-row'>
                <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
                    <label for='grupoCanal'>Grupos Canal</label><br>
                    <select id='grupoCanal' name='grupoCanal' class='form-control form-control-sm my_select2 grupoCanal_sl'>
                     <option value=''>-- Seleccionar --</option>
                    <?php if (!empty($data['idGrupoCanal'])) { ?>
                        <option value='<?= $data['idGrupoCanal'] ?>' selected><?= $data['grupoCanal'] ?></option>
                    <?php } ?>
                    <?php foreach ($gruposCanal as $idGrupoCanal => $grupoCanal) { ?>
                        <?php if ($data['idGrupoCanal'] != $grupoCanal['idGrupoCanal']) { ?>
                            <option value='<?= $grupoCanal['idGrupoCanal'] ?>'><?= $grupoCanal['nombre'] ?></option>
                        <?php } ?>
                    <?php } ?>
                    </select>
                </div>
                <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
                    <label for='canal'>Canal</label><br>
                     <select id='canal' name='canal' class='form-control form-control-sm my_select2 canal_cliente canal_sl'>
                     <option value=''>-- Seleccionar --</option>
                    <?php if (!empty($data['idCanal'])) { ?>
                        <option value='<?= $data['idCanal'] ?>' selected><?= $data['canal'] ?></option>
                    <?php } ?>
                    <?php foreach ($canales as $idCanal => $canal) { ?>
                        <?php if ($data['idCanal'] != $canal['idCanal']) { ?>
                            <option value='<?= $canal['idCanal'] ?>'><?= $canal['nombre'] ?></option>
                        <?php } ?>
                    <?php } ?>
                    </select>
                </div>
    </div>
    <div class='form-row'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='cliente'>Cliente</label><br>
            <div class="cliente_sl">
                <select id='cliente' name='cliente' class='form-control form-control-sm my_select2'>
                    <option value=''>-- Seleccionar --</option>
        
                <?php if (!empty($data['idCliente'])) { ?>
                    <option value='<?= $data['idCliente'] ?>' selected><?= $data['razonSocial'] ?></option>
                <?php } ?>
                <?php foreach ($clientes as $idCliente => $cliente) { ?>
                    <?php if ($data['idCliente'] != $cliente['idCliente']) { ?>
                        <option value='<?= $cliente['idCliente'] ?>'><?= $cliente['razonSocial'] ?></option>
                    <?php } ?>
                <?php } ?>
                </select>
            </div>
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
                <table class='table-Success table-sm table-bordered text-nowrap tableFixHead' style="width:100% !important;">
                    <div>
                        <thead class='thead-dark'>
                            <tr>
                                <th class="text-center align-middle">
                                    ACTUALIZAR
                                </th>
                                <th class="text-center align-middle">
                                    <div class="wr-20">ELEMENTOS DE VISIB.</div>
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

                                    <td class="text-center" data-name='<?= $nameSelectEncuesta ?>'>
                                       <div style="z-index: -1;">
                                            <select class='form-control form-control-sm'>
                                                <option value=''>-- Seleccionar --</option>
                                                <?php foreach ($elementos as $idElemento => $elemento) { ?>
                                                    <option value='<?= $elemento[$this->model->tablas['elemento']['id']] ?>'><?= $elemento['nombre'] ?></option>
                                                <?php } ?>
                                            </select>
                                       </div>
                                    </td>
                                    <td class="text-left">
                                        <div style="padding-left: 45%;">
                                            <button  class="border-0 btn-BorrarElemento btn-outline-secondary" title="Eliminar Elemento"><i class="fa fa-trash"></i></button>
                                        </div>
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
        width: '100%'
    });
    TradeVisibilidad.grupoCanal=<?=json_encode($grupoCanal_canales)?> 
</script>