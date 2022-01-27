<div class="card-datatable">
    <table id="tablaDetalladoEncuesta" class="table table-striped table-bordered nowrap w-100" style="font-size:12px;">
        <thead>
            <tr>
                <th rowspan="2">#</th>
                <th rowspan="1" colspan="<?= 10 + count($segmentacion['headers']) ?>">VISITA</th>
                <th rowspan="1" colspan="2">OPCIONES</th>
                <!-- <th rowspan="2">SELECCIONAR<br>FOTOS</th> -->
                <th rowspan="1" colspan="<?= $maximoDeColumas + 1 ?>">FOTOS DE LA ENCUESTA</th>
            </tr>
            <tr>
                <!-- VISITA -->
                <th class="text-center">FECHA</th>
                <th class="text-center hideCol">GRUPO CANAL</th>
                <th class="text-center hideCol">CANAL</th>
                <?
                if (!empty($segmentacion['headers'])) {
                    foreach ($segmentacion['headers'] as $k => $v) {
                ?>
                        <th class="text-center"><?= strtoupper($v['header']) ?></th>
                <?
                    }
                }
                ?>
                <th class="text-center">COD VISUAL</th>
                <th class="text-center hideCol">COD <?= $this->sessNomCuentaCorto ?></th>
                <th class="text-center hideCol">COD PDV</th>
                <th class="text-center">PDV</th>
                <th class="text-center hideCol">COD <br />USUARIO</th>
                <th class="text-center hideCol">PERFIL USUARIO</th>
                <th class="text-center">NOMBRE USUARIO</th>
                <!-- OPCION -->
                <th class="text-center">SELECCIONAR TIENDA<br><input type="checkbox" id="chkb-habilitarTodos" name="chkb-habilitarTodos" class="habilitarTodos"></th>
                <th class="text-center">CANTIDAD DE<br>FOTOS POR HOJA</th>
                <th class="text-center">MARCAR<br>TODO</th>
                <!-- FOTOS DE LA ENCUESTA -->
                <?
                if ($maximoDeColumas != 0) {
                    for ($i = 1; $i <= $maximoDeColumas; $i++) {
                ?>
                        <th>FOTO <?= $i ?></th>
                    <?
                    }
                } else {
                    ?>
                    <th>FOTO 1</th>
                <?
                }
                ?>
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
                        if (!empty($fotosEncuesta[$visita['idVisitaEncuesta']])) {
                            foreach ($fotosEncuesta[$visita['idVisitaEncuesta']] as $key => $value) {
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
                            $cantidadFotos = count($fotosEncuesta[$visita['idVisitaEncuesta']]);
                        }
                        if ($cantidadFotos < $maximoDeColumas) {
                            for ($i = 0; $i < ($maximoDeColumas - $cantidadFotos); $i++) {
                            ?>
                                <td class="text-center">-</td>
                        <?
                            }
                        }
                    } else {
                        ?>
                        <td>-</td>
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