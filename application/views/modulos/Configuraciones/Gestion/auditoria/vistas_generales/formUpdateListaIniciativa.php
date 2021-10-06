<?php
$num = 1;
$nameSelectEncuesta = 'elemento_lista';
$nameSelectIniciativa = 'elemento_iniciativa';
$select2 = "my_select2AgregarLista";
$class = "modalUpdate";
?>
<style>
    .tableFixHead {
        overflow-y: auto;
        height: 100px;
    }

    .tableFixHead thead th {
        position: sticky;
        top: 0;
        padding: 8px 16px
    }

    .tableFixHead tbody tr td {
        padding: 8px 16px
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th {
        background: #eee;
    }
</style>
<form id="formUpdate">
    <input class="d-none" type="text" name="idlst" value="<?= $data[$this->model->tablas['listaIniciativa']['id']] ?>">
    <input class="d-none" type="text" name="iniciativa" value="">
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
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
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
                <table class='table table-sm table-bordered text-nowrap'>
                    <thead class='thead-light'>
                        <tr>
                            <th class="text-center align-middle">
                                ACTUALIZAR
                            </th>
                            <th class="text-center align-middle">
                                <div class="wr-20">INICIATIVA</div>
                            </th>
                            <th class="text-center align-middle">
                                <div class="wr-20">ELEMENTOS</div>
                            </th>
                            <th class="text-center align-middle">
                                <button class="btn btn-AgregarElemento btn-secondary" title="Agregar Elemento"><strong>AGREGAR FILA</strong> <i class="fa fa-plus"></i></button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class='trPadre d-none' data-select2="<?= $select2 ?>" data-classmodal="<?= $class ?>">
                            <td></td>

                            <td class="text-center">
                                <select class='form-control form-control-sm iniciativas' name="<?= $nameSelectIniciativa ?>">
                                    <option value=''>-- Seleccionar --</option>
                                    <?php foreach ($iniciativas as $id => $iniciativa) { ?>
                                        <option value='<?= $iniciativa[$this->model->tablas['iniciativa']['id']] ?>'><?= $iniciativa['nombre'] ?></option>
                                    <?php } ?>
                                </select>
                            </td>

                            <td class="text-center">
                                <select class='form-control form-control-sm elementos' name="<?= $nameSelectEncuesta ?>">
                                    <option value=''>-- Seleccionar --</option>
                                </select>
                            </td>
                            <td class="text-left">
                                <button style="left: 45%;" class="border-0 btn btn-BorrarElemento btn-outline-secondary" title="Eliminar Elemento"><i class="fa fa-trash"></i></button>
                            </td>

                        </tr>

                        <?php
                        foreach ($lista_elementos as $row) { ?>
                            <tr class='trHijo table-secondary' data-fila="<?= $num ?>">
                                <td class="text-center">
                                    <input name='id-<?= $num ?>' class="chk-ActualizarElemento" type="checkbox" value='<?= $row['idListaDet'] ?>'>
                                </td>
                                <td class="text-center">
                                    <input value="<?= $row['idIniciativa'] ?>" type="hidden" name="<?= $nameSelectIniciativa ?>">
                                    <input value="<?= $row['iniciativa'] ?>" type="text" class="form-control form-control-sm" placeholder="textotest" disabled readonly="readonly">
                                </td>
                                <td class="text-center">
                                    <input value="<?= $row['idElementoVis'] ?>" type="hidden" name="<?= $nameSelectEncuesta ?>">
                                    <input value="<?= $row['nombre'] ?>" type="text" class="form-control form-control-sm" placeholder="textotest" disabled readonly="readonly">
                                </td>
                                <td class="text-left">
                                    <div style="padding-left: 45%;">
                                        <button class="border-0   btn-BorrarElemento btn-outline-secondary" title="Eliminar Elemento" disabled><i class="fa fa-trash"></i></button>
                                    </div>
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
        dropdownParent: $("div.modal-content-<?= $class ?>"),
        width: '100%'
    });
    AuditoriaVisibilidad.elementos = <?= json_encode($elementos) ?>;
    AuditoriaVisibilidad.grupoCanal = <?= json_encode($grupoCanal_canales) ?>;
</script>