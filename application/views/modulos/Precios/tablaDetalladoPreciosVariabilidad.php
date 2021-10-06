<style>
    .blurry {
        filter: blur(3px);
    }
</style>
<div class="card-datatable">
    <table id="tb-precios-variabilidad" class="mb-0 table table-bordered text-nowrap" width="100%">
        <thead>
            <tr>
                <th class="text-center align-middle">EMPRESA</th>
                <th class="text-center align-middle">SEMANA</th>
                <? $nroHeaders = 9; ?>
                <? foreach ($segmentacion['headers'] as $k => $v) { ?>
                    <? $nroHeaders++; ?>
                    <th class="text-center align-middle noVis"><?= strtoupper($v['header']) ?></th>
                <? } ?>

                <th class="text-center align-middle">CATEGORÍA</th>
                <th class="text-center align-middle">MARCA</th>
                <th class="text-center align-middle">PRODUCTO</th>
                <?
                $semanasGraf = '[';
                $numItems = count($semanas);
                $i = 0;
                foreach ($semanas as $k => $v) {
                ?>
                    <th class="text-center align-middle noVis"><?= $v ?></th>
                <?
                    if (++$i === $numItems) {
                        $semanasGraf .= $v . ']';
                    } else {
                        $semanasGraf .= $v . ', ';
                    }
                }
                ?>
                <th class="text-center align-middle" style="width: 100px;">TENDENCIA</th> <img src="" alt="">
            </tr>
        </thead>
        <tbody>
            <?
            $i = 1;
            foreach ($precios['cadenas'] as $cadenas) {
            ?>
                <? foreach ($cadenas as  $row) { ?>
                    <tr>
                        <td class="text-left align-middle"><?= (!empty($row['empresa']) ? $row['empresa'] : '-') ?></td>
                        <td class="text-center align-middle"><?= (!empty($row['semana']) ? ($row['semana']) : '-') ?></td>
                        <? foreach ($segmentacion['headers'] as $k => $v) { ?>
                            <td class="text-left align-middle"><?= (!empty($row[($v['columna'])]) ? $row[($v['columna'])] : '-') ?></td>
                        <? } ?>
                        <td class="text-left align-middle"><?= (!empty($row['categoria']) ? $row['categoria'] : '-') ?></td>
                        <td class="text-left align-middle"><?= (!empty($row['marca']) ? ($row['marca']) : '-') ?></td>
                        <td class="text-left align-middle"><?= (!empty($row['producto']) ? $row['producto'] : '-') ?></td>
                        <?
                        $valorxsemanaGraf = '[';
                        $numItems = count($semanas);
                        $i = 0;
                        foreach ($semanas as $k => $v) {
                            $valorxsemana = !empty($precios['semana'][$v][$row['idProducto']]['promedio']) ? number_format(moneda($precios['semana'][$v][$row['idProducto']]['promedio']), 3, '.', ',') : number_format(0, 3, '.', ',');
                        ?>
                            <td class="text-right align-middle"><?= $valorxsemana ?></td>
                        <?
                            if (++$i === $numItems) {
                                $valorxsemanaGraf .= $valorxsemana . ']';
                            } else {
                                $valorxsemanaGraf .= $valorxsemana . ', ';
                            }
                        }
                        ?>
                        <td data-semanas="<?= $semanasGraf ?>" data-valorxsemana="<?= $valorxsemanaGraf ?>">
                            <canvas class="divGrafico text-right align-middle" style="width:250px; height:100px;">
                            </canvas>
                        </td>
                    </tr>
                <? } ?>
            <? } ?>
        </tbody>
    </table>
</div>
