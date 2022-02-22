<div class="card-datatable">
    <table id="tablaDetalladoEncuestaConsolidado" class="table table-striped table-bordered nowrap w-100" style="font-size:12px;">
        <thead>
            <tr>
                <th class="noVis text-center">#</th>
                <th class="text-center">GRUPO CANAL</th>
                <th class="text-center">CANAL</th>
                <th class="text-center hideCol">SUBCANAL</th>
                <?
                if (!empty($segmentacion['headers'])) {
                    foreach ($segmentacion['headers'] as $k => $v) { ?>
                        <th class="text-center"><?= strtoupper($v['header']) ?></th>
                <? }
                } ?>
                <th class="text-center">COD VISUAL</th>
                <th class="text-center hideCol">COD <?= $this->sessNomCuentaCorto ?></th>
                <th class="text-center hideCol">COD PDV</th>
                <th class="text-center">PDV</th>
                <th class="text-center">TIPO CLIENTE</th>
                <th class="text-center">COD <br />USUARIO</th>
                <th class="text-center">PERFIL USUARIO</th>
                <th class="text-center">NOMBRE USUARIO</th>
                <? foreach ($listaEncuesta as $keyEncuesta => $encuesta) { ?>
                    <th class="text-center"><?= $encuesta["nombre"] ?></th>
                <? } ?>
            </tr>
        </thead>
        <tbody>
            <?
            $contador = 0;
            foreach ($visitas as $keyVisita => $visita) {
                $contador++;
            ?>
                <tr>
                    <td><?= $contador ?></td>
                    <td><?= verificarEmpty($visita["grupoCanal"], 3) ?></td>
                    <td><?= verificarEmpty($visita["canal"], 3) ?></td>
                    <td><?= verificarEmpty($visita["subCanal"], 3) ?></td>
                    <? if (!empty($segmentacion['headers'])) {
                        foreach ($segmentacion['headers'] as $k => $v) { ?>
                            <td class="text-<?= (!empty($visita[($v['columna'])]) ? $v['align'] : '-') ?>"><?= (!empty($visita[($v['columna'])]) ? $visita[($v['columna'])] : '-') ?></td>
                    <? }
                    } ?>
                    <td class="text-center"><?= verificarEmpty($visita["idCliente"], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($visita["codCliente"], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($visita["codDist"], 3) ?></td>
                    <td><?= verificarEmpty($visita["razonSocial"], 3) ?></td>
                    <td><?= verificarEmpty($visita["tipoCliente"], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($visita["idUsuario"], 3) ?></td>
                    <td><?= verificarEmpty($visita["tipoUsuario"], 3) ?></td>
                    <td><?= verificarEmpty($visita["usuario"], 3) ?></td>
                    <?
                    foreach ($listaEncuesta as $keyEncuesta => $encuesta) {
                    ?>
                        <?
                        $val = (isset($visita_encuesta[$visita['idCliente']][$visita['idUsuario']][$keyEncuesta]['num'])) ? $visita_encuesta[$visita['idCliente']][$visita['idUsuario']][$keyEncuesta]['num'] : 0;
                        $check = '<span class="color-F"><i class="fa fa-circle"></i></span><p style="display:none;">NO</p>';
                        if ($val > 0) {
                            $check = '<span class="color-C"><i class="fa fa-circle"></i></span><p style="display:none;">SI</p>';
                        }
                        ?>
                        <td class="text-center"><?= $check; ?></td>
                    <?
                    }
                    ?>
                </tr>
            <?
            }
            ?>
        </tbody>
    </table>
</div>