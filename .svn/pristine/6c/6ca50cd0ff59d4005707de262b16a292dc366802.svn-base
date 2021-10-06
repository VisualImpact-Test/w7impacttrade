<?php
$cantidadVisitasVisibilidadAuditoriaAdicional = (!empty($visitasVisibilidadAuditoriaAdicional['visitas'])) ? count($visitasVisibilidadAuditoriaAdicional['visitas']) : 0;
$cantidadColumnasDetalleVisita = 3;
$contadorFilas = 1;
?>

<div class="row">
    <div class="col-md-12">
        <?php if ($cantidadVisitasVisibilidadAuditoriaAdicional == 0) { ?>
            No se han generado registros
        <?php } else { ?>
            <div class="overflow-auto" style="height: 20rem;">
                <table id="tablaVisibilidadAuditoriaAdicional" class="mb-0 table-bordered table-sm no-footer" style="width:100%">
                    <thead>
                        <tr>
                            <th colspan="3" class="text-center align-middle">ELEMENTOS VISIBILIDAD</th>
                            <th colspan="<?= $cantidadVisitasVisibilidadAuditoriaAdicional  * $cantidadColumnasDetalleVisita ?>" class="text-center align-middle">VISITAS</th>
                        </tr>

                        <tr>
                            <th rowspan="2" class="text-center align-middle">#</th>
                            <th rowspan="2" class="text-center align-middle">ELEMENTO</th>
                            <th rowspan="2" class="text-center align-middle">TIPO</th>
                            <?php foreach ($visitasVisibilidadAuditoriaAdicional['visitas'] as $keyVisita => $visita) { ?>
                                <th colspan="<?= $cantidadColumnasDetalleVisita ?>" class="text-center align-middle">
                                    COD. VISITA <?= $visita['idVisita'] ?><br>
                                    <?= $visita['tipoUsuario'] ?>: <?= $visita['nombreUsuario'] ?><br>
                                    (<?= $visita['fecha'] ?> <?= time_change_format($visita['hora']) ?>)<br>
                                    PORCENTAJE: <?= $visita['porcentaje'] ?>%
                                </th>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php for ($i = 0; $i < $cantidadVisitasVisibilidadAuditoriaAdicional; $i++) { ?>
                                <th class="text-center align-middle">PRESENCIA</th>
                                <th class="text-center align-middle">CANTIDAD</th>
                                <th class="text-center align-middle">COMENTARIO</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($visitasVisibilidadAuditoriaAdicional['elementosVisibilidad'] as $keyElementoVisibilidad => $elementoVisibilidad) { ?>
                            <tr>
                                <td class="text-center align-middle"><?= $contadorFilas ?></td>
                                <td class="text-center align-middle"><?= $elementoVisibilidad['elementoVisibilidad'] ?></td>
                                <td class="text-center align-middle"><?= $elementoVisibilidad['tipoElementoVisibilidad'] ?></td>
                                <?php foreach ($visitasVisibilidadAuditoriaAdicional['visitas'] as $keyVisita => $visita) { ?>
                                    <td class="text-center align-middle"><?= !empty($elementoVisibilidad['infoVisitas'][$keyVisita]['presencia']) ? 'Sí' : 'No' ?></td>
                                    <td class="text-center align-middle"><?= !empty($elementoVisibilidad['infoVisitas'][$keyVisita]['cant']) ? $elementoVisibilidad['infoVisitas'][$keyVisita]['cant'] : '-'  ?></td>
                                    <td class="text-center align-middle"><?= !empty($elementoVisibilidad['infoVisitas'][$keyVisita]['comentario']) ? $elementoVisibilidad['infoVisitas'][$keyVisita]['comentario'] : '-'  ?></td>
                                <?php } ?>
                            </tr>
                            <?php $contadorFilas++; ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>
</div>