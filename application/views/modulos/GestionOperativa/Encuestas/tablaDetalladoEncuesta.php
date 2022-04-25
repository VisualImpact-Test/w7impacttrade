<div class="card-datatable">
    <table id="tablaDetalladoEncuesta" class="table table-striped table-bordered nowrap w-100" style="font-size:12px;">
        <thead>
            <tr>
                <th rowspan="3">#</th>
                <th rowspan="1" colspan="<?= 10 + count($segmentacion['headers']) ?>">VISITA</th>
                <th rowspan="1" colspan="2">OPCIONES</th>
                <!-- <th rowspan="2">SELECCIONAR<br>FOTOS</th> -->
                <th rowspan="1" colspan="<?= $maximoDeColumasEncuesta + $maximoDeColumasPregunta + $maximoDeColumasAlternativa + 1 ?>">FOTOS DE LA ENCUESTA</th>
            </tr>
            <tr>
                <!-- VISITA -->
                <th rowspan="2" class="text-center">FECHA</th>
                <th rowspan="2" class="text-center hideCol">GRUPO CANAL</th>
                <th rowspan="2" class="text-center hideCol">CANAL</th>
                <?
                if (!empty($segmentacion['headers'])) {
                    foreach ($segmentacion['headers'] as $k => $v) {
                ?>
                        <th rowspan="2" class="text-center"><?= strtoupper($v['header']) ?></th>
                <?
                    }
                }
                ?>
                <th rowspan="2" class="text-center">COD VISUAL</th>
                <th rowspan="2" class="text-center hideCol">COD <?= $this->sessNomCuentaCorto ?></th>
                <th rowspan="2" class="text-center hideCol">COD PDV</th>
                <th rowspan="2" class="text-center">PDV</th>
                <th rowspan="2" class="text-center hideCol">COD <br />USUARIO</th>
                <th rowspan="2" class="text-center hideCol">PERFIL USUARIO</th>
                <th rowspan="2" class="text-center">NOMBRE USUARIO</th>
                <!-- OPCION -->
                <th rowspan="2" class="text-center">SELECCIONAR TIENDA<br><input type="checkbox" id="chkb-habilitarTodos" name="chkb-habilitarTodos" class="habilitarTodos"></th>
                <th rowspan="2" class="text-center">CANTIDAD DE<br>FOTOS POR HOJA</th>
                <th rowspan="2" class="text-center">MARCAR<br>TODO</th>
                <!-- FOTOS DE LA ENCUESTA -->
                <? if (!empty($maximoDeColumasEncuesta)) { ?>
                    <th class="text-center" colspan="<?= $maximoDeColumasEncuesta ?>">ENCUESTA</th>
                <? } ?>
                <? if (!empty($maximoDeColumasPregunta)) { ?>
                    <th class="text-center" colspan="<?= $maximoDeColumasPregunta ?>">PREGUNTA</th>
                <? } ?>
                <? if (!empty($maximoDeColumasAlternativa)) { ?>
                    <th class="text-center" colspan="<?= $maximoDeColumasAlternativa ?>">ALTERNATIVA</th>
                <? } ?>
            </tr>
            <tr>
                <? if (!empty($maximoDeColumasEncuesta)) {
                    for ($i = 1; $i < ($maximoDeColumasEncuesta+1); $i++) {
                ?>
                        <th class="text-center">FOTO <?=$i?></th>
                    <?
                    }
                    ?>
                <? } ?>
                <? if (!empty($maximoDeColumasPregunta)) {
                    for ($i = 1; $i < ($maximoDeColumasPregunta+1); $i++) {
                ?>
                        <th class="text-center">FOTO <?=$i?></th>
                    <?
                    }
                    ?>
                <? } ?>
                <? if (!empty($maximoDeColumasAlternativa)) {
                    for ($i = 1; $i < ($maximoDeColumasAlternativa+1); $i++) {
                ?>
                        <th class="text-center">FOTO <?=$i?></th>
                    <?
                    }
                    ?>
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
                    <td><?= verificarEmpty($visita["fecha"], 3) ?></td>
                    <td><?= verificarEmpty($visita["grupoCanal"], 3) ?></td>
                    <td><?= verificarEmpty($visita["canal"], 3) ?></td>
                    <?
                    if (!empty($segmentacion['headers'])) {
                        foreach ($segmentacion['headers'] as $k => $v) {
                    ?>
                            <td class="text-<?= (!empty($visita[($v['columna'])]) ? $v['align'] : '-') ?>"><?= (!empty($visita[($v['columna'])]) ? $visita[($v['columna'])] : '-') ?></td>
                    <?
                        }
                    }
                    ?>
                    <td class="text-center"><?= verificarEmpty($visita["idCliente"], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($visita["codCliente"], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($visita["codDist"], 3) ?></td>
                    <td><?= verificarEmpty($visita["razonSocial"], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($visita["idUsuario"], 3) ?></td>
                    <td><?= verificarEmpty($visita["tipoUsuario"], 3) ?></td>
                    <td><?= verificarEmpty($visita["usuario"], 3) ?></td>
                    <td class="text-center">
                        <input name="check[]" id="check" class="check seleccionarTienda" type="checkbox" data-idVisitaEncuesta="<?= $visita['idVisitaEncuesta']; ?>" data-nombreCliente="<?= $visita["razonSocial"] ?>" />
                    </td>
                    <td class="text-center">
                        <input name="cantidad[]" id="cantidad" class="form-control form-control-sm inputCantidad disabled" type="number" style="width:90%;margin:auto;" min="0" oninput="validity.valid||(value='');" value="0" />
                    </td>
                    <!-- BOTON PARA VER LAS FOTOS DE LA ENCUESTA (NO USADO) -->
                    <!-- <td class="text-center">
                        <button type="button" class="btn border-0 btn-outline-secondary btn-fotosEncuesta" data-idVisita="<?= $visita['idVisita']; ?>"><i class="fas fa-images fa-lg"></i> Ver <?= $visita['cantidadFotos']; ?> fotos</button>
                    </td> -->
                    <!-- FOTOS DE LA ENCUESTA -->
                    <td class="text-center">
                        <div class="divFotos disabled">
                            <input class="check_row" type="checkbox" data-id="<?= $visita['idVisitaEncuesta']; ?>" />
                        </div>
                    </td>
                    <?
                    if (!empty($fotosEncuesta)) {
                        $cantidadFotos = 0;
                        if (!empty($fotosEncuesta[$visita['idVisitaEncuesta']]['ENCUESTA'])) {
                            foreach ($fotosEncuesta[$visita['idVisitaEncuesta']]['ENCUESTA'] as $key => $value) {
                    ?>
                                <td>
                                    <div class="divFotos disabled">
                                        <input class="check_<?= $visita['idVisitaEncuesta'] ?> chckMargin" type="checkbox" name="chck-foto-<?= $visita['idVisitaEncuesta'] ?>" data-nombreFoto="<?= $value ?>">
                                        <a href="javascript:;" class="lk-foto-1" data-title="Foto Encuesta" data-content="<?= $key ?>">
                                            <img id="<?= $key ?>" src="<?= site_url() ?>controlFoto/obtener_carpeta_foto/encuestas/<?= $value ?>" class="imgFotoMin">
                                        </a><br>
                                    </div>
                                </td>
                            <?
                            }
                            $cantidadFotos = count($fotosEncuesta[$visita['idVisitaEncuesta']]['ENCUESTA']);
                        }
                        if ($cantidadFotos < $maximoDeColumasEncuesta) {
                            for ($i = 0; $i < ($maximoDeColumasEncuesta - $cantidadFotos); $i++) {
                            ?>
                                <td class="text-center">-</td>
                        <?
                            }
                        }
                    } else {
                        ?>
                       <?=  ($maximoDeColumasEncuesta != 0 ) ?  '<td>-</td>' : ''   ?>    
                    <?
                    }
                    ?>
                    <?
                    if (!empty($fotosEncuesta)) {
                        $cantidadFotos = 0;
                        if (!empty($fotosEncuesta[$visita['idVisitaEncuesta']]['PREGUNTA'])) {
                            foreach ($fotosEncuesta[$visita['idVisitaEncuesta']]['PREGUNTA'] as $key => $value) {
                    ?>
                                <td>
                                    <div class="divFotos disabled">
                                        <input class="check_<?= $visita['idVisitaEncuesta'] ?> chckMargin" type="checkbox" name="chck-foto-<?= $visita['idVisitaEncuesta'] ?>" data-nombreFoto="<?= $value ?>">
                                        <a href="javascript:;" class="lk-foto-1" data-title="Foto Encuesta" data-content="<?= $key ?>">
                                            <img id="<?= $key ?>" src="<?= site_url() ?>controlFoto/obtener_carpeta_foto/encuestas/<?= $value ?>" class="imgFotoMin">
                                        </a><br>
                                    </div>
                                </td>
                            <?
                            }
                            $cantidadFotos = count($fotosEncuesta[$visita['idVisitaEncuesta']]['PREGUNTA']);
                        }
                        if ($cantidadFotos < $maximoDeColumasPregunta) {
                            for ($i = 0; $i < ($maximoDeColumasPregunta - $cantidadFotos); $i++) {
                            ?>
                                <td class="text-center">-</td>
                        <?
                            }
                        }
                    } else {
                        ?>
                        <?=  ($maximoDeColumasEncuesta != 0 ) ?  '<td>-</td>' : ''   ?>    
                    <?
                    }
                    ?>
                    <?
                    if (!empty($fotosEncuesta)) {
                        $cantidadFotos = 0;
                        if (!empty($fotosEncuesta[$visita['idVisitaEncuesta']]['ALTERNATIVA'])) {
                            foreach ($fotosEncuesta[$visita['idVisitaEncuesta']]['ALTERNATIVA'] as $key => $value) {
                    ?>
                                <td>
                                    <div class="divFotos disabled">
                                        <input class="check_<?= $visita['idVisitaEncuesta'] ?> chckMargin" type="checkbox" name="chck-foto-<?= $visita['idVisitaEncuesta'] ?>" data-nombreFoto="<?= $value ?>">
                                        <a href="javascript:;" class="lk-foto-1" data-title="Foto Encuesta" data-content="<?= $key ?>">
                                            <img id="<?= $key ?>" src="<?= site_url() ?>controlFoto/obtener_carpeta_foto/encuestas/<?= $value ?>" class="imgFotoMin">
                                        </a><br>
                                    </div>
                                </td>
                            <?
                            }
                            $cantidadFotos = count($fotosEncuesta[$visita['idVisitaEncuesta']]['ALTERNATIVA']);
                        }
                        if ($cantidadFotos < $maximoDeColumasAlternativa) {
                            for ($i = 0; $i < ($maximoDeColumasAlternativa - $cantidadFotos); $i++) {
                            ?>
                                <td class="text-center">-</td>
                        <?
                            }
                        }
                    } else {
                        ?>
                       <?=  ($maximoDeColumasEncuesta != 0 ) ?  '<td>-</td>' : ''   ?>    
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