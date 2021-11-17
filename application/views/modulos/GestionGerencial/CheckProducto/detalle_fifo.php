<div class="card-datatable">
    <table id="tb-fifo" class="mb-0 table table-bordered text-nowrap" width="100%">
        <thead>
            <tr>
                <th class="text-center align-middle noVis">#</th>
                <th class="text-center align-middle">FECHA</th>
                <th class="text-center align-middle">GRUPO CANAL</th>
                <th class="text-center align-middle">CANAL</th>
                <th class="text-center align-middle hideCol">SUBCANAL</th>
                <?$nroHeaders = 9;?>
                <? foreach ($segmentacion['headers'] as $k => $v) { ?>
                    <? $nroHeaders++;?>
                    <th class="text-center align-middle"><?= strtoupper($v['header']) ?></th>
                <? } ?>
                <th class="text-center align-middle">COD VISUAL</th>
                <th class="text-center align-middle hideCol">COD <?=$this->sessNomCuentaCorto?></th>
                <th class="text-center align-middle">PDV</th>
                <th class="text-center align-middle">PRODUCTO</th>
                <th class="text-center align-middle">UNIDAD MEDIDA</th>
                <th class="text-center align-middle">CANTIDAD POR VENCER</th>
                <th class="text-center align-middle">FECHA VENCIMIENTO</th>
                <th class="text-center align-middle">DÍAS PARA VENCIMIENTO</th>
            </tr>
        </thead>
        <tbody>
            <?
            $i = 1;
            foreach ($quiebres as $row) {
            ?>
                <tr>
                    <td class="text-center"><?= $i++; ?></td>
                    <td class="text-left"><?= (!empty($row['fecha']) ? date_change_format($row['fecha']) : '-') ?></td>
                    <td class="text-left"><?= (!empty($row['grupoCanal']) ? $row['grupoCanal'] : '-') ?></td>
                    <td class="text-left"><?= (!empty($row['canal']) ? $row['canal'] : '-') ?></td>
                    <td class="text-left"><?= (!empty($row['subCanal']) ? $row['subCanal'] : '-') ?></td>
                    <? foreach ($segmentacion['headers'] as $k => $v) { ?>
                        <td class="text-left"><?= (!empty($row[($v['columna'])]) ? $row[($v['columna'])] : '-') ?></td>
                    <? } ?>
                    <td class="text-center"><?= (!empty($row['idCliente']) ? $row['idCliente'] : '-') ?></td>
                    <td class="text-center"><?= (!empty($row['codCliente']) ? $row['codCliente'] : '-') ?></td>
                    <td class="text-left"><?= (!empty($row['razonSocial']) ? $row['razonSocial'] : '-') ?></td>
                    <td class="text-left"><?= (!empty($row['producto']) ? $row['producto'] : '-') ?></td>
                    <td class="text-left"><?= (!empty($row['unidadMedida']) ? $row['unidadMedida'] : '-') ?></td>
                    <td class="text-center"><?= (!empty($row['cantidadVencida']) ? $row['cantidadVencida'] : '-') ?></td>
                    <td class="text-center"><?= (!empty($row['fechaVencido']) ? date_change_format($row['fechaVencido']) : '-') ?></td>
                    <td class="text-center text-bold"><span><i style="color: <?=$row['color']?>;" class="fas fa-circle"></i></span> <?= (is_numeric($row['diasVencimiento']) && ($row['diasVencimiento'] < 0 ) ? '<b>Vencido</b>' : '<b style="font-size:12px">'.$row['diasVencimiento'].'</b>') ?></td>
                </tr>
            <? } ?>
        </tbody>
    </table>
</div>