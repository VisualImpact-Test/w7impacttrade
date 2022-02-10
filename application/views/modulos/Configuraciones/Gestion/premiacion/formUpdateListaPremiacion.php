<?php
$num = 1;
$nameSelectEncuesta = 'sl_encuesta';
$checkFoto = "chkFoto";
$select2 = "my_select2EditarLista";

?>


<form id="formUpdate">
    <input class="d-none" type="text" name="idLista" value="<?= $data['idListPremiacion'] ?>">


    <div class='form-row'>

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='grupoCanal'>Grupo Canal</label><br>
            <div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia">
                <?= getFiltros(['grupoCanal' => ['label' => 'Grupo Canal', 'name' => 'grupoCanal_form', 'id' => 'grupoCanal_form', 'data' => true, 'select2' => 'ui my_select2Lista', 'html' => '', 'selected' => $data['idGrupoCanal']]]) ?>
            </div>
        </div>

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='canal'>Canal</label><br>
            <div class="canal_form">
                <div class="mb-2 mr-sm-2 position-relative form-group filtros_asistencia">
                    <?= getFiltros(['canal' => ['label' => 'Canal', 'name' => 'canal_form', 'id' => 'canal_form', 'data' => true, 'select2' => 'ui my_select2Lista', 'html' => '', 'selected' => $data['idCanal']]]) ?>
                </div>
            </div>
        </div>

        <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 mb-2'>
            <label for='tipoUsuario'>Tipo Usuario</label><br>
            <div class="tipoUsuario_sl_form">
                <select id='tipoUsuario_form' name='tipoUsuario_form' class='form-control form-control-sm my_select2Lista tipoUsuario_cliente'>
                    <?php if (!empty($data['idTipoUsuario'])) { ?>
                        <option value='<?= $data['idTipoUsuario'] ?>' selected><?= $data['tipo'] ?></option>
                    <?php } ?>
                    <?= (empty($data['idTipoUsuario'])) ? "<option value=''>-- Seleccione --</option>": '' ?>
                    <? if (!empty($tipoUsuario)) { ?>
                        <?php foreach ($tipoUsuario as $id => $value) { ?>
                            <?php if ($data['idTipoUsuario'] != $value['idTipoUsuario']) { ?>
                                <option value='<?= $value['idTipoUsuario'] ?>'><?= $value['nombre'] ?></option>
                            <?php } ?>
                        <?php } ?>
                    <? } ?>
                </select>
            </div>
        </div>

        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2 w-100'>
            <label for="cliente">Cliente</label>
            <div class="cliente_sl_form">
                <select id='cliente_form' name='cliente_form' class='form-control form-control-sm my_select2Lista' style="width:100%;">
                    <option value=''>-- Seleccionar --</option>
                    <? foreach ($clientes as $row) { ?>
                        <? if ($data['idCliente'] != $row['idCliente']) {
                            $selected = '';
                        } else {
                            $selected = 'selected';
                        } ?>
                        <option value='<?= $row['idCliente'] ?>' <?= $selected ?>><?= $row['razonSocial'] ?></option>
                    <? } ?>
                </select>
            </div>
        </div>

    </div>
    <div class="form-row">
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaInicio'>Fecha Inicio</label><br>
            <input id='fechaInicio' name='fechaInicio' type='text' class='form-control form-control-sm' placeholder='Fecha Inicio' value="<?= $data['fecIni'] ?>">
        </div>

        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaFin'>Fecha Fin</label><br>
            <input id='fechaFin' name='fechaFin' type='text' class='form-control form-control-sm' placeholder='Fecha Fin' value="<?= $data['fecFin'] ?>">
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
                                <div class="wr-20">PREMIACION</div>
                            </th>
                            <th class="text-center align-middle">
                                <button class="btn btn-AgregarElemento btn-secondary" title="Agregar Elemento"><strong>AGREGAR FILA</strong> <i class="fa fa-plus"></i></button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class='trPadre d-none' data-select2="<?= $select2 ?>" data-classmodal="<?= $class ?>">
                            <td></td>
                            <td class="text-center" data-name='<?= $nameSelectEncuesta ?>'>
                                <select class='form-control form-control-sm'>
                                    <option value=''>-- Seleccionar --</option>
                                    <?php foreach ($premiacion as $idPremiacion => $premiacion) { ?>
                                        <option value='<?= $premiacion['idPremiacion'] ?>'><?= $premiacion['nombre'] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="text-left">
                                <button style="left: 45%;" class="border-0 btn btn-BorrarElemento btn-outline-secondary" title="Eliminar Elemento"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>

                        <?php
                        foreach ($lista_premiacion as $key => $row) { ?>
                            <tr class='trHijo table-secondary' data-fila="<?= $num ?>">
                                <td class="text-center">
                                    <input name='id-<?= $num ?>' class="chk-ActualizarElemento" type="checkbox" value='<?= $row['idListPremiacionDet'] ?>'>
                                </td>
                                <td class="text-center">
                                    <input data-id="<?= $row['idPremiacion'] ?>" value="<?= $row['premiacion'] ?>" type="text" class="form-control form-control-sm premiacionestxt" placeholder="textotest" disabled readonly="readonly">
                                </td>
                                <td class="text-left">
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
    $('.my_select2Lista').select2({
        dropdownParent: $("#formUpdate"),
        width: '100%',
    });
</script>