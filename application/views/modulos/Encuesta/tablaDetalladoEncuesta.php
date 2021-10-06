<div class="card-datatable">
    <table id="tablaDetalladoEncuesta" class="table table-striped table-bordered nowrap w-100" style="font-size:12px;">
        <thead>
            <tr>
                <th rowspan="2" class="noVis text-center">#</th>
                <th rowspan="2" class="text-center">FECHA</th>
                <th rowspan="2" class="text-center">GRUPO CANAL</th>
                <th rowspan="2" class="text-center">CANAL</th>
                <th rowspan="2" class="text-center hideCol">SUBCANAL</th>
                <? foreach ($segmentacion['headers'] as $k => $v) { ?>
                    <th rowspan="2" class="text-center"><?= strtoupper($v['header']) ?></th>
                <? } ?>
                <th rowspan="2" class="text-center">COD VISUAL</th>
                <th rowspan="2" class="text-center hideCol">COD <?= $this->sessNomCuentaCorto ?></th>
                <th rowspan="2" class="text-center hideCol">COD PDV</th>
                <th rowspan="2" class="text-center">PDV</th>
                <th rowspan="2" class="text-center">TIPO CLIENTE</th>
                <th rowspan="2" class="text-center hideCol">DEPARTAMENTO</th>
                <th rowspan="2" class="text-center hideCol">PROVINCIA</th>
                <th rowspan="2" class="text-center hideCol">DISTRITO</th>
                <th rowspan="2" class="text-center">COD <br />USUARIO</th>
                <th rowspan="2" class="text-center">PERFIL USUARIO</th>
                <th rowspan="2" class="text-center">NOMBRE USUARIO</th>
                <th rowspan="2" class="text-center">INCIDENCIA</th>
                <th rowspan="2" class="text-center">ENCUESTADO</th>
                <? foreach ($listaEncuesta as $keyEncuesta => $encuesta) { ?>
                    <th rowspan="1" class="text-center" colspan="<?= count($listaPregunta[$keyEncuesta]) + $encuesta["foto"] ?>"><?= $encuesta["nombre"] ?></th>
                <? } ?>
            </tr>
            <tr>
                <? foreach ($listaEncuesta as $keyEncuesta => $encuesta) {
                    foreach ($listaPregunta[$keyEncuesta] as $keyPregunta => $pregunta) { ?>
                        <th rowspan="1" class="text-center"><?= $pregunta["nombre"] ?></th>
                    <? }
                    if ($encuesta["foto"] == 1) { ?>
                        <th rowspan="1" class="text-center">Foto</th>
                <? }
                } ?>
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
                    <td><?= verificarEmpty($visita["fecha"], 3) ?></td>
                    <td><?= verificarEmpty($visita["grupoCanal"], 3) ?></td>
                    <td><?= verificarEmpty($visita["canal"], 3) ?></td>
                    <td><?= verificarEmpty($visita["subCanal"], 3) ?></td>
                    <? foreach ($segmentacion['headers'] as $k => $v) { ?>
                        <td class="text-<?= (!empty($visita[($v['columna'])]) ? $v['align'] : '-') ?>"><?= (!empty($visita[($v['columna'])]) ? $visita[($v['columna'])] : '-') ?></td>
                    <? } ?>
                    <td class="text-center"><?= verificarEmpty($visita["idCliente"], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($visita["codCliente"], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($visita["codDist"], 3) ?></td>
                    <td><?= verificarEmpty($visita["razonSocial"], 3) ?></td>
                    <td><?= verificarEmpty($visita["tipoCliente"], 3) ?></td>
                    <td><?= verificarEmpty($visita["ciudad"], 3) ?></td>
                    <td><?= verificarEmpty($visita["provincia"], 3) ?></td>
                    <td><?= verificarEmpty($visita["distrito"], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($visita["idUsuario"], 3) ?></td>
                    <td><?= verificarEmpty($visita["tipoUsuario"], 3) ?></td>
                    <td><?= verificarEmpty($visita["usuario"], 3) ?></td>
                    <td><?= verificarEmpty($visita['incidencia'], 3) ?></td>
                    <td><?= !empty($visita['encuestado']) ? 'SÍ' : '-' ?></td>
                    <?
                    foreach ($listaEncuesta as $keyEncuesta => $encuesta) {
                    ?>
                        <?
                        foreach ($listaPregunta[$keyEncuesta] as $keyPregunta => $pregunta) {
                            $respuesta = (isset($visitaEncuesta[$visita['idVisita']][$keyPregunta])) ? implode(", ", $visitaEncuesta[$visita['idVisita']][$keyPregunta]) : '-';
                        ?>
                            <td><?= $respuesta ?></td>
                        <?
                        }
                        ?>
                        <?
                        if ($encuesta["foto"] == 1) {
                            if (isset($visitaFoto[$visita['idVisita']][$keyEncuesta])) {
                                $foto = '<a href="javascript:;" class="lk-show-foto a-fa" data-imgReg="' . $visitaFoto[$visita['idVisita']][$keyEncuesta] . '"><i class="fa fa-camera" ></i></a>';
                            } else {
                                $foto = "-";
                            }
                        ?>
                            <td rowspan="1"><?= $foto ?></td>
                        <?
                        }
                        ?>
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