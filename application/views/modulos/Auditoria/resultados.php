<div class="card-datatable">
    <table id="tb-resultados" class="mb-0 table table-bordered text-nowrap" width="100%">
        <thead>
            <tr>
                <th class="text-center noVis">#</th>
                <th class="text-center">GRUPO CANAL</th>
                <th class="text-center">CANAL</th>
                <th class="text-center hideCol">SUB CANAL</th>
                <? $nroHeaders = 14; ?>
                <? foreach ($segmentacion['headers'] as $k => $v) { ?>
                    <? $nroHeaders++; ?>
                    <th class="text-center"><?= strtoupper($v['header']) ?></th>
                <? } ?>
                <th class="text-center">COD VISUAL</th>
                <th class="text-center hideCol">COD <?= $this->sessNomCuentaCorto ?></th>
                <th class="text-center hideCol">CODIGO PDV</th>
                <th class="text-center">PDV</th>
                <th class="text-center">TIPO CLIENTE</th>
                <th class="text-center hideCol">DEPARTAMENTO</th>
                <th class="text-center hideCol">PROVINCIA</th>
                <th class="text-center hideCol">DISTRITO</th>
                <th class="text-center">PERFIL USUARIO</th>
                <th class="text-center">NOMBRE USUARIO</th>
                <th class="text-center">N° VISITAS</th>
                <th class="text-center">INCIDENCIAS</th>
                <th class="text-center">RESULTADO CLIENTE</th>
                <th class="text-center">RESULTADO GTM</th>
            </tr>
        </thead>
        <tbody>
            <?
            $i = 1;
            foreach ($clientes as $fila) {
                if ($fila['cantIncidencias'] > 0) {
                    $incidencias = "SI";
                } else {
                    $incidencias = "NO";
                }
                $porcCliente = isset($porcentajeCliente[$fila['idCliente']]['pCliente']) ? $porcentajeCliente[$fila['idCliente']]['pCliente'] : '-';
                $porcGTM = isset($porcentajeGTM[$fila['idCliente']]['pGTM']) ? $porcentajeGTM[$fila['idCliente']]['pGTM'] : '-';
                $porcClienteFinal = ($porcCliente == "-" && $porcGTM == "-") ? "0%" : round(number_format($porcCliente, 2, '.', ','), 2) . ' %';
                $porcGTMFinal = ($porcGTM == "-" && $porcCliente == "-") ? "0%" : round(number_format($porcGTM, 2, '.', ','), 2) . ' %';
            ?>
                <tr>
                    <td class="text-center"><?= $i++; ?></td>
                    <td><?= verificarEmpty($fila['grupoCanal'], 3); ?></td>
                    <td><?= verificarEmpty($fila['canal'], 3); ?></td>
                    <td><?= verificarEmpty($fila['subCanal'], 3); ?></td>
                    <? foreach ($segmentacion['headers'] as $k => $v) { ?>
                        <td class="text-<?= (!empty($row[($v['columna'])]) ? $v['align'] : 'left') ?>"><?= (!empty($row[($v['columna'])]) ? $row[($v['columna'])] : '-') ?></td>
                    <? } ?>
                    <td class="text-center"><?= verificarEmpty($fila['idCliente'], 3); ?></td>
                    <td class="text-center"><?= verificarEmpty($fila['codCliente'], 3); ?></td>
                    <td class="text-center"><?= verificarEmpty($fila['codRD'], 3); ?></td>
                    <td><?= verificarEmpty($fila['razonSocial'], 3); ?></td>
                    <td><?= verificarEmpty($fila['clienteTipo'], 3); ?></td>
                    <td><?= verificarEmpty($fila['departamento'], 3); ?></td>
                    <td><?= verificarEmpty($fila['provincia'], 3); ?></td>
                    <td><?= verificarEmpty($fila['distrito'], 3); ?></td>
                    <td><?= verificarEmpty($fila['tipoUsuario'], 3); ?></td>
                    <td><?= verificarEmpty($fila['usuario'], 3); ?></td>
                    <td class="text-right"><?= ($fila['cantVisitas'] % 2) == 0 ? ($fila['cantVisitas'] / 2) : '-' ?></td>
                    <td><?= $incidencias ?></td>
                    <td class="text-right"><?= $porcClienteFinal ?></td>
                    <td class="text-right"><?= $porcGTMFinal ?></td>
                </tr>
            <? } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">TOTAL:&nbsp;<?= count($clientes); ?></td>
                <td colspan="<?= $nroHeaders; ?>"></td>
            </tr>
        </tfoot>
    </table>
</div>