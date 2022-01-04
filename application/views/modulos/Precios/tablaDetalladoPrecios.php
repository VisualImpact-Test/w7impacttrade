<div class="card-datatable">
    <table id="tb-precios" class="mb-0 table table-bordered text-nowrap" width="100%">
        <thead>
            <tr>
                <th class="text-center align-middle noVis">#</th>
                <th class="text-center align-middle">AÑO</th>
                <th class="text-center align-middle">MES</th>
                <th class="text-center align-middle">SEMANA</th>
                <th class="text-center align-middle <?=!empty($hideCol['grupoCanal']) ? 'hideCol' : '' ?>" >GRUPO CANAL</th>
                <th class="text-center align-middle <?=!empty($hideCol['canal']) ? 'hideCol' : '' ?>">CANAL</th>
                <?$nroHeaders = 9;?>
                <? foreach ($segmentacion['headers'] as $k => $v) { ?>
                    <? $nroHeaders++;?>
                    <th class="text-center align-middle <?=!empty($hideCol[$v['columna']]) ? 'hideCol' : '' ?>"><?= strtoupper($v['header']) ?></th>
                <? } ?>
                
                <th class="text-center align-middle">EMPRESA</th>
                <th class="text-center align-middle">CATEGORÍA</th>
                <th class="text-center align-middle">MARCA</th>
                <th class="text-center align-middle">FORMATO</th>
                <th class="text-center align-middle">PRODUCTO</th>
                <th class="text-center align-middle">PRECIO</th>
            </tr>
        </thead>
        <tbody>
            <?
            $i = 1;
            foreach ($quiebres as $row) {
            ?>
                <tr>
                    <td class="text-center"><?= $i++; ?></td>
                    <td class="text-center"><?= (!empty($row['anio']) ? ($row['anio']) : '-') ?></td>
                    <td class="text-center"><?= (!empty($row['mes']) ? ($row['mes']) : '-') ?></td>
                    <td class="text-center"><?= (!empty($row['semana']) ? ($row['semana']) : '-') ?></td>
                    <td class="text-left"><?= (!empty($row['grupoCanal']) ? $row['grupoCanal'] : '-') ?></td>
                    <td class="text-left"><?= (!empty($row['canal']) ? $row['canal'] : '-') ?></td>
                    <? foreach ($segmentacion['headers'] as $k => $v) { ?>
                        <td class="text-left"><?= (!empty($row[($v['columna'])]) ? $row[($v['columna'])] : '-') ?></td>
                    <? } ?>
                    <td class="text-left"><?= (!empty($row['empresa']) ? $row['empresa'] : '-') ?></td>
                    <td class="text-left"><?= (!empty($row['categoria']) ? $row['categoria'] : '-') ?></td>
                    <td class="text-left"><?= (!empty($row['marca']) ? ($row['marca']) : '-') ?></td>
                    <td class="text-center"><?= (!empty($row['formato']) ? number_format($row['formato'], 2, '.', ' ') : '-') ?></td>
                    <td class="text-left"><?= (!empty($row['producto']) ? $row['producto'] : '-') ?></td>
                    <td class="text-right"><?= 'S/ '.$row['precio'] ?></td>
                </tr>
            <? } ?>
        </tbody>
    </table>
</div>