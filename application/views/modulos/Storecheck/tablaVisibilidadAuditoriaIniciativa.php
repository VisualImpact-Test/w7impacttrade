<?php
$cantidadVisitasVisibilidadAuditoriaIniciativa = (!empty($visitasVisibilidadAuditoriaIniciativa['visitas'])) ? count($visitasVisibilidadAuditoriaIniciativa['visitas']) : 0;
$cantidadColumnasDetalleVisita = 3;
$contadorFilas = 1;
?>

<div class="row">
    <div class="col-md-12">
        <?php if ($cantidadVisitasVisibilidadAuditoriaIniciativa == 0) { ?>
            No se han generado registros
        <?php } else { ?>
            <div class="overflow-auto" style="height: 20rem;">
                <table id="tablaVisibilidadAuditoriaIniciativa" class="mb-0 table-bordered table-sm no-footer" style="width:100%">
                    <thead>
                        <tr>
                            <th colspan="3" class="text-center align-middle">ELEMENTOS VISIBILIDAD</th>
                            <th colspan="<?= $cantidadVisitasVisibilidadAuditoriaIniciativa  * $cantidadColumnasDetalleVisita ?>" class="text-center align-middle">VISITAS</th>
                        </tr>

                        <tr>
                            <th rowspan="2" class="text-center align-middle">#</th>
                            <th rowspan="2" class="text-center align-middle">ELEMENTO</th>
                            <th rowspan="2" class="text-center align-middle">TIPO</th>
                            <?php foreach ($visitasVisibilidadAuditoriaIniciativa['visitas'] as $keyVisita => $visita) { ?>
                                <th colspan="<?= $cantidadColumnasDetalleVisita ?>" class="text-center align-middle">
                                    COD. VISITA <?= $visita['idVisita'] ?><br>
                                    <?= $visita['tipoUsuario'] ?>: <?= $visita['nombreUsuario'] ?><br>
                                    (<?= $visita['fecha'] ?> <?= time_change_format($visita['hora']) ?>)<br>
                                    PORCENTAJE: <?= number_format((float) $visita['porcentaje'], 2, '.', '')  ?>%
                                </th>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php for ($i = 0; $i < $cantidadVisitasVisibilidadAuditoriaIniciativa; $i++) { ?>
                                <th class="text-center align-middle">PRESENCIA</th>
                                <th class="text-center align-middle">OBSERVACIÓN</th>
                                <th class="text-center align-middle">COMENTARIO</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($visitasVisibilidadAuditoriaIniciativa['elementosVisibilidad'] as $keyElementoVisibilidad => $elementoVisibilidad) { ?>
                            <tr>
                                <td class="text-center align-middle"><?= $contadorFilas ?></td>
                                <td class="text-center align-middle"><?= $elementoVisibilidad['elementoVisibilidad'] ?></td>
                                <td class="text-center align-middle"><?= $elementoVisibilidad['tipoElementoVisibilidad'] ?></td>
                                <?php foreach ($visitasVisibilidadAuditoriaIniciativa['visitas'] as $keyVisita => $visita) { ?>
                                    <td class="text-center align-middle"><?= !empty($elementoVisibilidad['infoVisitas'][$keyVisita]['presencia']) ? 'Sí' : 'No' ?></td>
                                    <td class="text-center align-middle"><?= !empty($elementoVisibilidad['infoVisitas'][$keyVisita]['observacion']) ? $elementoVisibilidad['infoVisitas'][$keyVisita]['observacion'] : '-'  ?></td>
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