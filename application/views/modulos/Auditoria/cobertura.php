<div class="card-datatable">
    <table id="tb-cobertura" class="mb-0 table table-bordered text-nowrap" width="100%">
        <thead>
            <tr>
                <th class="text-center noVis" rowspan="3">#</th>
                <th class="text-center" rowspan="3">CIUDAD</th>
                <th class="text-center" rowspan="3">DISTRITO</th>
                <th class="text-center" rowspan="3">DISTRIBUIDORA</th>
                <th class="text-center" rowspan="1" colspan="<?= count($canales) * 2; ?>">CARTERA TOTAL</th>
                <th class="text-center" rowspan="3">TOTAL BASEMADRE</th>
                <th class="text-center" rowspan="3">TOTAL PROGRAMADOS</th>
            </tr>
            <tr>
                <? foreach ($canales as $fila) { ?>
                    <th class="text-center" rowspan="1" colspan="2"><?= $fila['canal']; ?></th>
                <? } ?>
            </tr>
            <tr>
                <? foreach ($canales as $fila) { ?>
                    <th class="text-center" rowspan="1" colspan="1" class="tooltipTipsy" title="CLIENTES BASEMADRE">CBM</th>
                    <th class="text-center" rowspan="1" colspan="1" class="tooltipTipsy" title="CLIENTES PROGRAMADOS">CP</th>
                <? } ?>
            </tr>
        </thead>
        <tbody>
            <? $i = 0;
            foreach ($distribuidoras as $fila) {
                $i++; ?>
                <tr>
                    <td class="text-center"><?= $i; ?></td>
                    <td><?= verificarEmpty($fila['ciudad'], 3); ?></td>
                    <td><?= verificarEmpty($fila['distrito'], 3); ?></td>
                    <td><?= verificarEmpty($fila['distribuidora'], 3) ?></td>
                    <? foreach ($canales as $fila2) { ?>
                        <?
                        $clientesBaseMadre = isset($clientesBaseMadreDistCanal[$fila['idDistribuidoraSucursal']][$fila2['idCanal']]['cliDistCanal']) ? $clientesBaseMadreDistCanal[$fila['idDistribuidoraSucursal']][$fila2['idCanal']]['cliDistCanal'] : '-';
                        $clientesProgramados = isset($clientesProgramadosDistCanal[$fila['idDistribuidoraSucursal']][$fila2['idCanal']]['cliDistCanal']) ? $clientesProgramadosDistCanal[$fila['idDistribuidoraSucursal']][$fila2['idCanal']]['cliDistCanal'] : '-';
                        if ($clientesBaseMadre != "-") {
                            $classDetalle1 = " verDetalleClientes";
                        } else {
                            $classDetalle1 = "";
                        }
                        if ($clientesProgramados != "-") {
                            $classDetalle2 = " verDetalleClientes";
                        } else {
                            $classDetalle2 = "";
                        }
                        ?>
                        <td class="text-right<?= $classDetalle1; ?>" data-tipo="cbm" data-distSucursal="<?= $fila['idDistribuidoraSucursal']; ?>" data-canal="<?= $fila2['idCanal']; ?>"><?= $clientesBaseMadre; ?></td>
                        <td class="text-right<?= $classDetalle2; ?>" data-tipo="cp" data-distSucursal="<?= $fila['idDistribuidoraSucursal']; ?>" data-canal="<?= $fila2['idCanal']; ?>"><?= $clientesProgramados; ?></td>
                    <? } ?>
                    <?
                    $clientesBaseMadreTotalDist = isset($clientesBaseMadreDist[$fila['idDistribuidoraSucursal']]['cliDist']) ? $clientesBaseMadreDist[$fila['idDistribuidoraSucursal']]['cliDist'] : '-';
                    $clientesProgramadosTotalDist = isset($clientesProgramadosDist[$fila['idDistribuidoraSucursal']]['cliDist']) ? $clientesProgramadosDist[$fila['idDistribuidoraSucursal']]['cliDist'] : '-';
                    ?>
                    <td class="text-right"><?= $clientesBaseMadreTotalDist; ?></td>
                    <td class="text-right"><?= $clientesProgramadosTotalDist; ?></td>
                </tr>
            <? } ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">TOTAL GENERAL</th>
                <? $clientesBaseMadreTotalCanalGeneral = 0;
                $clientesProgramadosTotalCanalGeneral = 0;
                foreach ($canales as $fila) { ?>
                    <?
                    $clientesBaseMadreTotalCanal = isset($clientesBaseMadreCanal[$fila['idCanal']]['cliCanal']) ? $clientesBaseMadreCanal[$fila['idCanal']]['cliCanal'] : '-';
                    $clientesProgramadosTotalCanal = isset($clientesProgramadosCanal[$fila['idCanal']]['cliCanal']) ? $clientesProgramadosCanal[$fila['idCanal']]['cliCanal'] : '-';
                    if ($clientesBaseMadreTotalCanal != "-") {
                        $clientesBaseMadreTotalCanalGeneral += $clientesBaseMadreTotalCanal;
                    }
                    if ($clientesProgramadosTotalCanal != "-") {
                        $clientesProgramadosTotalCanalGeneral += $clientesProgramadosTotalCanal;
                    }
                    ?>
                    <th><?= $clientesBaseMadreTotalCanal; ?></th>
                    <th><?= $clientesProgramadosTotalCanal; ?></th>
                <? } ?>
                <th class="text-right"><?= $clientesBaseMadreTotalCanalGeneral; ?></th>
                <th class="text-right"><?= $clientesProgramadosTotalCanalGeneral; ?></th>
            </tr>
        </tfoot>
    </table>
</div>