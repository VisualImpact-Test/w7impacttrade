<?
$valor_frecuencia = 0.3;
$valor_efectividad = 0.7;
?>
<div class="card-datatable" style="text-align: center;">
    <table id="tablaDetalladoLeyenda" class="table table-striped table-bordered nowrap" style="font-size:12px;width:auto;display: inline-block;">
        <tbody>
            <tr>
                <td>Frecuencia</td>
                <td><?= $valor_frecuencia * 100 ?>%</td>
            </tr>
            <tr>
                <td>Efectvidad - tiempo de atencion</td>
                <td><?= $valor_efectividad * 100 ?>%</td>
            </tr>
        </tbody>
    </table>
    <br><br>
    <table id="tablaDetalladoResumen" class="table table-striped table-bordered nowrap" style="font-size:12px;width:auto;display: inline-block;">
        <thead>
            <tr>
                <th></th>
                <th>Cartera de Tiendas</th>
                <th>Frecuencias Programadas</th>
                <th>Tiempo Programado</th>
                <th>Frecuencias Ejecutadas</th>
                <th>%Frecuencias Ejecutadas </th>
                <th>Tiempo Ejecutado</th>
                <th>%Tiempo Ejecutada</th>
            </tr>
        </thead>
        <tbody>
            <?
            $sumTotalFrecuencias = 0;
            $sumTotalTiendas = 0;
            $sumTotalHP = 0;
            $sumTotalFrecuenciaEjecutada = 0;
            $sumTotalHoraEjecutada = 0;
            foreach ($canal as $row_s => $value_s) {

                $sumFrecuencia = 0;
                $sumHP = 0;
                $sumFrecuenciaEjecutada = 0;
                $sumHorasEjecutada = 0;
                foreach ($tiendas_segmento[$row_s] as $row_t => $value_t) {
                    $sum = isset($frecuencias[$row_t]['frecuencia']) ? $frecuencias[$row_t]['frecuencia'] : 0;
                    $sumFrecuencia = $sumFrecuencia + $sum;

                    $hp_segmento = isset($prog[$row_t]['HP']) ? $prog[$row_t]['HP'] : 0;
                    $sumHP = $sumHP + $hp_segmento;

                    foreach ($fechas->result() as $col) {
                        $fp_segmento =  isset($visitas[$row_t][$col->idTiempo]['HT']) ? 1 : 0;
                        $he_segmento =  isset($visitas[$row_t][$col->idTiempo]['HT']) ? $visitas[$row_t][$col->idTiempo]['HT'] : 0;
                        $sumFrecuenciaEjecutada = $sumFrecuenciaEjecutada + $fp_segmento;
                        $sumHorasEjecutada = $sumHorasEjecutada + $he_segmento;
                    }
                }
                $sumTotalFrecuencias = $sumTotalFrecuencias + $sumFrecuencia;
                $sumTotalTiendas = $sumTotalTiendas + $value_s['total'];
                $sumTotalHP = $sumTotalHP + $sumHP;
                $sumTotalFrecuenciaEjecutada = $sumTotalFrecuenciaEjecutada + $sumFrecuenciaEjecutada;
                $sumTotalHoraEjecutada = $sumTotalHoraEjecutada + $sumHorasEjecutada;

                $sumTotalFrecuenciaEjecutada = ($sumTotalFrecuenciaEjecutada > $sumTotalFrecuencias) ? $sumTotalFrecuencias : $sumTotalFrecuenciaEjecutada;
                $sumHorasEjecutada = ($sumHorasEjecutada > $sumHP) ? $sumHP : $sumHorasEjecutada;

                $sumTotalFrecuenciaEjecutada = ($sumTotalFrecuenciaEjecutada > $sumHP) ? $sumHP : $sumTotalFrecuenciaEjecutada;
                $sumTotalHoraEjecutada = ($sumTotalHoraEjecutada > $sumTotalHP) ? $sumTotalHP : $sumTotalHoraEjecutada;

            ?>
                <tr>
                    <td><?= $value_s['canal'] ?></td>
                    <td><?= $value_s['total'] ?></td>
                    <td><?= $sumFrecuencia ?></td>
                    <td><?= $sumHP ?></td>
                    <td><?= $sumFrecuenciaEjecutada ?></td>
                    <td><?= ($sumFrecuencia > 0) ? ROUND($sumFrecuenciaEjecutada / $sumFrecuencia * 100, 2) . '%' : '0%'; ?></td>
                    <td><?= $sumHorasEjecutada ?></td>
                    <td><?= ($sumHP > 0) ? ROUND($sumHorasEjecutada / $sumHP * 100, 2) . '%' : '0%'; ?></td>
                </tr>
            <? } ?>
            <tr>
                <th></th>
                <th><?= $sumTotalTiendas ?></th>
                <th><?= $sumTotalFrecuencias ?></th>
                <th><?= $sumTotalHP ?></th>
                <th><?= $sumTotalFrecuenciaEjecutada ?></th>
                <? $porcentaje_frecuencia = ($sumTotalFrecuencias > 0) ? ROUND($sumTotalFrecuenciaEjecutada / $sumTotalFrecuencias * 100, 2) : 0; ?>
                <? $porcentaje_horas = ($sumTotalHP > 0) ? ROUND($sumTotalHoraEjecutada / $sumTotalHP * 100, 2) : 0; ?>
                <th><?= $porcentaje_frecuencia ?>%</th>
                <th><?= $sumTotalHoraEjecutada ?></th>
                <th><?= $porcentaje_horas; ?>%</th>
            </tr>
        </tbody>
    </table>

    <br><br>

    <table id="tablaDetalladoResultado" class="table table-striped table-bordered nowrap" style="font-size:12px;width:auto;display: inline-block;">
        <tbody>
            <tr>
                <th>Resumen</th>
                <th>Resultado</th>
                <th>% Cumplimiento</th>
            </tr>
            <tr>
                <td>Frecuencia</td>
                <td><?= $porcentaje_frecuencia ?>%</td>
                <td><?= round($porcentaje_frecuencia * $valor_frecuencia, 2) ?>%</td>
            </tr>
            <tr>
                <td>Efectvidad - tiempo de atencion</td>
                <td><?= $porcentaje_horas; ?>%</td>
                <td><?= round($porcentaje_horas * $valor_efectividad, 2) ?>%</td>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th><?= round(($porcentaje_horas * $valor_efectividad) + ($porcentaje_frecuencia * $valor_frecuencia), 2) ?>%</th>
            </tr>
        </tbody>
    </table>
    <br><br>
    <table id="tablaDetalladoCobertura" class="table table-striped table-bordered nowrap w-100" style="font-size:12px;">
        <thead class="fixed">
            <tr>
                <? $cols = count($fechas->result()) + 11; ?>
                <th colspan="8" class="count-data">Total: <?= count($tiendas->result()); ?></th>
                <? foreach ($fechas->result() as $row) { ?>
                    <th>
                        <div class="vertical-text"><?= $row->dia; ?></div>
                    </th>
                <? } ?>
                <th colspan="4" class="count-data"></th>
            </tr>
            <tr>
                <th>#</th>
                <!-- <th>EJECUTIVO</th> -->
                <!-- <th>SPOC</th> -->
                <th>SEGMENTO</th>
                <!-- <th>CADENA</th>
            <th>BANNER</th> -->
                <th>CODIGO TIENDA</th>
                <th>TIENDA</th>
                <th>HORAS PROGRAMADA</th>
                <th>FRECUENCIA PROGRAMADA</th>
                <? foreach ($fechas->result() as $row) { ?>
                    <th>
                        <div class=" vertical-text"><?= $row->fecha; ?>
                        </div>
                    </th>
                <? } ?>
                <th>HORAS EJECUTADAS</th>
                <th>%.</th>
                <th>FRECUENCIA EJECUTADAS</th>
                <th>%.</th>
            </tr>
        </thead>
        <tbody>
            <? $ix = 0; ?>
            <? foreach ($tiendas->result() as $row) { ?>
                <?
                $ix++;
                $cssRow = ($ix % 2 == 0) ? 'row-white' : '';
                $sumH = 0;
                ?>
                <tr class="<?= $cssRow; ?>" data-id-tienda="<?= $row->idCliente ?>">
                    <td><?= $ix; ?></td>
                    <!-- <td><?= $row->EJE; ?></td> -->
                    <!-- <td><?= $row->SPOC; ?></td> -->
                    <td><?= $row->canal; ?></td>
                    <td><?= verificarEmpty($row->codCliente,3); ?></td>
                    <td><?= $row->cliente; ?></td>
                    <? $hp = (isset($prog[$row->idCliente]['HP'])) ? $prog[$row->idCliente]['HP'] : 0; ?>

                    <td><?= $hp; ?></td>
                    <? $fp = 0; //isset($frecuencias[$row->idCliente]['frecuencia'])?$frecuencias[$row->idCliente]['frecuencia']:0; 
                    ?>
                    <?
                    foreach ($fechas->result() as $col) {
                        $fpdia = (isset($prog[$row->idCliente][$col->idTiempo]['hp_dia'])) ? 1 : 0;
                        $fp = $fp + $fpdia;
                    }
                    ?>
                    <td><?= $fp ?></td>
                    <? $sumF = 0;
                    foreach ($fechas->result() as $col) { ?>
                        <? $ht = (isset($visitas[$row->idCliente][$col->idTiempo]['HT'])) ? $visitas[$row->idCliente][$col->idTiempo]['HT'] : 0;
                        $hpdia = (isset($prog[$row->idCliente][$col->idTiempo]['hp_dia'])) ? $prog[$row->idCliente][$col->idTiempo]['hp_dia'] : 0;
                        $ht = ($hpdia < $ht) ? $hpdia : $ht;
                        $ft = (isset($visitas[$row->idCliente][$col->idTiempo]['HT'])) ? 1 : 0;
                        $sumH = $sumH + $ht;
                        $sumF = $sumF + $ft;
                        ?>
                        <td><?= $ht; ?></td>
                    <? } ?>

                    <? $sumH = ($hp < $sumH) ? $hp : $sumH; ?>
                    <td><?= $sumH; ?></td>
                    <td><?= ($hp > 0) ? round($sumH / $hp, 2) * 100 : 0; ?>%</td>
                    <td><?= $sumF ?></td>
                    <td><?= ($fp > 0) ? round($sumF / $fp, 2) * 100 : 0; ?>%</td>
                </tr>
            <? } ?>
        </tbody>
    </table>
</div>