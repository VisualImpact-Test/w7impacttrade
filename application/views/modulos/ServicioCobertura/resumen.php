<style>
    table.dataTable {
        border-collapse: collapse !important;
    }
</style>

<div class="card-datatable">
    <h3 style="text-align: center;">Servicio de Cobertura</h3>
    <hr>
    <table id="tb-resumen" class="table table-striped table-bordered nowrap" width="100%">
        <thead>
            <tr>
                <th class="text-center align-middle cabeceraSecundaria">GERENTE</th>
                <th class="text-center align-middle cabeceraSecundaria">CANAL</th>
                <th class="text-center align-middle cabeceraSecundaria">SUCURSAL/PLAZA</th>
                <th class="text-center align-middle cabeceraSecundaria">OBJ</th>
                <th class="text-center align-middle cabeceraSecundaria">COB</th>
                <th class="text-center align-middle cabeceraSecundaria">%</th>
                <th class="text-center align-middle cabeceraSecundaria">DIF</th>
            </tr>
        </thead>
        <tbody>
            <?
            foreach ($data as $key => $value) {
            ?>
                <tr style="background-color:#e1e1e1;">
                    <td class="text-left"><i class="fas fa-plus-circle mostrarDetalle" style="cursor: pointer;margin-right: 15px;" data-detalle="tdDetalle<?= $key ?>" value="0"></i> <?= verificarEmpty($value['nombre'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['canal'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['sucursal'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['objetivo'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['cobertura'], 3) ?></td>
                    <? $efectividad =  verificarEmpty($value['efectividad'], 2) ?>
                    <td class="text-center <?= $efectividad == '100.00%' ? 'celdaCorrecta' : 'celdaConAdvertencia'?>"><?= $efectividad."%" ?></td>
                    <td class="text-center"><?= verificarEmpty($value['diferencia'], 2) ?></td>
                </tr>
                <?
                foreach ($dataDetalle as $skey => $svalue) {
                    if ($svalue['nombre'] == $value['nombre']) {
                ?>
                        <tr style="background-color:#F2F2F2;">
                            <td class="text-left tdDetalle<?= $key ?> d-none"><?= verificarEmpty($svalue['nombre'], 3) ?></td>
                            <td class="text-center tdDetalle<?= $key ?> d-none"><?= verificarEmpty($svalue['canal'], 3) ?></td>
                            <td class="text-center tdDetalle<?= $key ?> d-none"><?= verificarEmpty($svalue['sucursal'], 3) ?></td>
                            <td class="text-center tdDetalle<?= $key ?> d-none"><?= verificarEmpty($svalue['objetivo'], 3) ?></td>
                            <td class="text-center tdDetalle<?= $key ?> d-none"><?= verificarEmpty($svalue['cobertura'], 3) ?></td>
                            <? $efectividad =  verificarEmpty($svalue['efectividad'], 2) ?>
                            <td class="text-center <?= $efectividad == '100.00%' ? 'celdaCorrecta' : 'celdaConAdvertencia'?> tdDetalle<?= $key ?> d-none"><?= $efectividad."%" ?></td>
                            <td class="text-center tdDetalle<?= $key ?> d-none"><?= verificarEmpty($svalue['diferencia'], 2) ?></td>
                        </tr>
                <?
                    }
                }
                ?>
            <?
            }
            ?>
        </tbody>
        <tfoot>
            <tr class="table-primary font-weight-bold">
                <td class="text-center">TOTAL GENERAL</td>
                <td></td>
                <td></td>
                <td class="text-center"><?=verificarEmpty($dataTotal['objetivo'], 3)?></td>
                <td class="text-center"><?=verificarEmpty($dataTotal['cobertura'], 3)?></td>
                <? $efectividadT =  verificarEmpty($dataTotal['efectividad'], 2) ?>
                <td class="text-center <?= $efectividadT == '100' ? 'celdaCorrecta' : 'celdaConAdvertencia'?>"><?= $efectividadT."%" ?> </td>
                <td class="text-center"><?= verificarEmpty($dataTotal['diferencia'], 2) ?></td>
            </tr>
        </tfoot>
    </table>
    <h3 style="text-align: center;">Servicio Horas</h3>
    <hr>
    <table id="tb-resumen" class="table table-striped table-bordered nowrap" width="100%">
        <thead>
            <tr>
                <th class="text-center align-middle cabeceraSecundaria">GERENTE</th>
                <th class="text-center align-middle cabeceraSecundaria">CANAL</th>
                <th class="text-center align-middle cabeceraSecundaria">SUCURSAL/PLAZA</th>
                <th class="text-center align-middle cabeceraSecundaria">OBJ</th>
                <th class="text-center align-middle cabeceraSecundaria">COB</th>
                <th class="text-center align-middle cabeceraSecundaria">% EF</th>
                <th class="text-center align-middle cabeceraSecundaria">%</th>
                <th class="text-center align-middle cabeceraSecundaria">DIF</th>
            </tr>
        </thead>
        <tbody>
            <?
            foreach ($dataH as $key => $value) {
            ?>
                <tr style="background-color:#e1e1e1;">
                    <td class="text-left"><i class="fas fa-plus-circle mostrarDetalleH" style="cursor: pointer;margin-right: 15px;" data-detalle="tdDetalleH<?= $key ?>" value="0"></i> <?= verificarEmpty($value['nombre'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['canal'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['sucursal'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['objetivo'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['cobertura'], 3) ?></td>
                    <td class="text-center" style="background-color:#ffff73"><?= verificarEmpty(round($value['efectividad'],2), 2).'%' ?></td>
                    <? $porcentaje =  verificarEmpty($value['porcentaje'], 2) ?>
                    <td class="text-center <?= $porcentaje == '100.00%' ? 'celdaCorrecta' : 'celdaConAdvertencia'?>"><?= $porcentaje ?></td>
                    <td class="text-center"><?= verificarEmpty($value['diferencia'], 2) ?></td>
                </tr>
                <?
                foreach ($dataDetalleH as $skey => $svalue) {
                    if ($svalue['nombre'] == $value['nombre']) {
                ?>
                        <tr style="background-color:#F2F2F2;">
                            <td class="text-left tdDetalleH<?= $key ?> d-none"><?=   verificarEmpty($svalue['nombre'], 3) ?></td>
                            <td class="text-center tdDetalleH<?= $key ?> d-none"><?= verificarEmpty($svalue['canal'], 3) ?></td>
                            <td class="text-center tdDetalleH<?= $key ?> d-none"><?= verificarEmpty($svalue['sucursal'], 3) ?></td>
                            <td class="text-center tdDetalleH<?= $key ?> d-none"><?= verificarEmpty($svalue['objetivo'], 3) ?></td>
                            <td class="text-center tdDetalleH<?= $key ?> d-none"><?= verificarEmpty($svalue['cobertura'], 3) ?></td>
                            <td class="text-center tdDetalleH<?= $key ?> d-none" style="background-color:#ffff73"><?= verificarEmpty(round($svalue['efectividad'],2), 2).'%' ?></td>
                            <? $porcentaje =  verificarEmpty($svalue['porcentaje'], 2) ?>
                            <td class="text-center <?= $porcentaje == '100.00%' ? 'celdaCorrecta' : 'celdaConAdvertencia'?> tdDetalleH<?= $key ?> d-none"><?= $porcentaje ?></td>
                            <td class="text-center tdDetalleH<?= $key ?> d-none"><?= verificarEmpty($svalue['diferencia'], 2) ?></td>
                        </tr>
                <?
                    }
                }
                ?>
            <?
            }
            ?>
        </tbody>
        <tfoot>
        <tr class="table-primary font-weight-bold">
                <td class="text-center">TOTAL GENERAL</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"><?=verificarEmpty($dataTotalH['objetivo'], 3)?></td>
                <td class="text-center"><?=verificarEmpty($dataTotalH['cobertura'], 3)?></td>
                <td class="text-center" style="background-color:#ffff73"><?=verificarEmpty(round($dataTotalH['efectividad'],2), 2).'%'?></td>
                <? $porcentajet =  verificarEmpty($dataTotalH['porcentaje'], 2) ?>
                <td class="text-center <?= $porcentajet == '100' ? 'celdaCorrecta' : 'celdaConAdvertencia'?>"><?= $porcentajet."%" ?> </td>
                <td class="text-center"><?= verificarEmpty($dataTotalH['diferencia'], 2) ?></td>
            </tr>
        </tfoot>
    </table>
</div>

<script>
    $(document).ready(function() {

        var opcion = $('.btnReporte.active').data('value');
        if (opcion == 1) {
            var c = 0;

            $('.filtroCondicion').each(function(ev) {
                var btn = $(this).val();
                var ckb = $(this).prop('checked');

                if (ckb == false) {
                    $('.' + btn).each(function(ev) {
                        $(this).parent('tr').hide();
                    });
                } else {
                    $('.' + btn).each(function(ev) {
                        $(this).parent('tr').show();
                        c++;
                    });
                }
            });

            var page = Math.floor((Math.random() * 10) + 1);
            $('#tb-asistenciaDetalle').DataTable().page.len(page).draw();
            $('#tb-asistenciaDetalle').DataTable().page.len(20).draw();
        }
    });
</script>