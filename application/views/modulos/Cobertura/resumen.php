<div class="card-datatable" style="text-align: center;">
    <table id="tablaResumenCobertura" class="table table-striped table-bordered nowrap w-100">
        <thead>
            <tr class="text-white">
                <th colspan="4" class="count-data" style="background-color:#305496;">Total: <?= count($tiendas) ?></th>
            </tr>
            <tr class="text-white">
                <th style="background-color:#305496;">#</th>
                <th style="background-color:#305496;">RUTA</th>
                <th style="background-color:#305496;">OBJ PDV</th>
                <th style="background-color:#305496;">COB PDV</th>
            </tr>
        </thead>
        <tbody>
            <? $z = 1;
            foreach ($supervisor as $row_s => $value_s) { ?>
                <tr>
                    <td style="background-color:#ffffff;"><?= $z ?></td>
                    <td style="background-color:#ffffff;"><?= $value_s['supervisor'] ?></td>
                    <? $f = array();
                    $i = 0;
                    $j = 0;
                    $sum_frecuencia[$row_s] = 0;
                    $sum_cobertura[$row_s] = 0;
                    foreach ($tiendas->result() as $row_t) {
                        foreach ($fechas->result() as $col) {
                            $m = isset($cobertura[$row_s][$row_t->idCliente][$col->idTiempo]['visita']) ? $cobertura[$row_s][$row_t->idCliente][$col->idTiempo]['visita'] : 0;
                            $f = isset($prog[$row_s][$row_t->idCliente][$col->idTiempo]['HP']) ? $prog[$row_s][$row_t->idCliente][$col->idTiempo]['HP'] : 0;
                            $sum_frecuencia[$row_s] = $sum_frecuencia[$row_s] + $f;
                            $sum_cobertura[$row_s] = $sum_cobertura[$row_s] + $m;
                        }
                    }

                    ?>
                    <td style="background-color:#ffffff;"><?= $sum_frecuencia[$row_s] ?></td>
                    <td style="background-color:#ffffff;"><?= $sum_cobertura[$row_s] ?></td>
                </tr>
            <? $z++;
            } ?>
        </tbody>
    </table>
</div>