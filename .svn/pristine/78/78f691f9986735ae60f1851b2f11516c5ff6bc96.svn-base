<?php
$num = 1;
$nameSelectEncuesta = 'elemento_lista';
$nameFechaFin = "fechaFin";
$nameValor = "valor";
$nameFechaInicio = "fechaInicio";
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
    <input class="d-none" type="text" name="idlst" value="<?= $data['idCliente'] ?>">
 
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
                                <div class="wr-20">INFO</div>
                            </th>
                            <th class="text-center align-middle">
                                <div class="wr-20">VALOR</div>
                            </th>
                            <th class="text-center align-middle">
                                <div class="wr-20">FECHA INICIO</div>
                            </th>
                            <th class="text-center align-middle">
                                <div class="wr-20">FECHA FIN</div>
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
                            <td class="text-center" data-name='<?= $nameValor ?>'>
                                <input id='valor' name='valor' type='text' class='form-control form-control-sm' placeholder='Valor'>
                            </td>
                            <td class="text-center" data-name='<?= $nameFechaInicio ?>'>
                                <input id='fechaInicio' name='fechaInicio' type='text' class='form-control form-control-sm' placeholder='Fecha Inicio'>
                            </td>
                            <td class="text-center" data-name='<?= $nameFechaFin ?>'>
                                <input id='fechaFin' name='fechaFin' type='text' class='form-control form-control-sm' placeholder='Fecha Fin'>
                            </td>

                            <td class="text-left">
                                <button style="left: 45%;" class="border-0 btn btn-BorrarElemento btn-outline-secondary" title="Eliminar Elemento"><i class="fa fa-trash"></i></button>
                            </td> 
                        </tr>

                        <?php
                        foreach ($lista_elementos as $key => $row) { ?>
                            <tr class='trHijo table-secondary' data-fila="<?=$num?>">
                                <td class="text-center">
                                    <input name='id-<?= $num ?>' class="chk-ActualizarElemento" type="checkbox" value='<?= $row[$this->model->tablas['lista']['id']] ?>'>
                                </td>
                                <td class="text-center">
                                    <input value="<?=$row['nombre']?>"  type="text" class="form-control form-control-sm" placeholder="textotest" disabled readonly="readonly">
                                </td>
                                <td class="text-center">
                                    <input  type='text' class='form-control form-control-sm' placeholder='Valor' value="<?= ($row['valor']) ?>" disabled>
                                </td>
                                <td class="text-center">
                                    <input  type='text' class='form-control form-control-sm' placeholder='Fecha' value="<?= ($row['fecIni']) ?>" disabled>
                                </td>
                                <td class="text-center">
                                    <input  type='text' class='form-control form-control-sm' placeholder='Fecha' value="<?= ($row['fecFin']) ?>" disabled>
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

    $('.my_select2').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });
    // $('#fechaInicio').daterangepicker(singleDatePickerModal);
    // $('#fechaFin').daterangepicker($.extend({
    //     "autoUpdateInput": false,
    // }, singleDatePickerModal));
    // $('#fechaInicio').on('apply.daterangepicker', function(ev, picker) {
    //     $('#fechaFin').val('');
    // });
    // $('#fechaFin').on('apply.daterangepicker', function(ev, picker) {
    //     $.fechaLimite(picker, "#fechaFin", "#fechaInicio");
    // });

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