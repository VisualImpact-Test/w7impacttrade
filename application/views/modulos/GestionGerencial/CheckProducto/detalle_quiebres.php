<div class="card-datatable">
    <table id="tb-quiebres" class="mb-0 table table-bordered text-nowrap" width="100%">
        <thead>
            <tr>
                <th class="text-center align-middle noVis">#</th>
                <th class="text-center align-middle hideCol noVis">CUENTA</th>
                <th class="text-center align-middle">GRUPO CANAL</th>
                <th class="text-center align-middle">CANAL</th>
                <th class="text-center align-middle hideCol">SUBCANAL</th>
                <?$nroHeaders = 9;?>
                <? foreach ($segmentacion['headers'] as $k => $v) { ?>
                    <? $nroHeaders++;?>
                    <th class="text-center align-middle"><?= strtoupper($v['header']) ?></th>
                <? } ?>
                <th class="text-center align-middle">COD VISUAL</th>
                <th class="text-center align-middle hideCol">COD <?=$this->sessNomCuentaCorto?></th>>
                <th class="text-center align-middle">PDV</th>
                <th class="text-center align-middle">PRODUCTO</th>
                <th class="text-center align-middle">QUIEBRE</th>
                <th class="text-center align-middle">MOTIVO</th>
            </tr>
        </thead>
        <tbody>
            <?
            $i = 1;
            $nroQuiebres = 0;
            $quiebre = 'NO';
            foreach ($quiebres as $row) {
                if(!empty($row['quiebre'])){
                    $quiebre = 'SI';
                    $nroQuiebres++;
                }
            ?>
                <tr>
                    <td class="text-center"><?= $i++; ?></td>
                    <td class="text-center"><?= (!empty($row['cuenta']) ? $row['cuenta'] : '-') ?></td>
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
                    <td class="text-center"><?= $quiebre ?></td>
                    <td class="text-center"><?= (!empty($row['motivo']) ? $row['motivo'] : '-') ?></td>
                </tr>
            <? } ?>
        </tbody>
        <tfoot>
            <tr>
                <th scope="row" colspan="<?=$nroHeaders-1;?>" style="text-align:right;">Total Quiebres:</th>
                <td><?=$nroQuiebres?></td>
            </tr>
        </tfoot>
    </table>
</div>