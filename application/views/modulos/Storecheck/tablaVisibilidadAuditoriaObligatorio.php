<?php
$cantidadVisitasVisibilidadAuditoriaObligatorio = (!empty($visitasVisibilidadAuditoriaObligatorio['visitas'])) ? count($visitasVisibilidadAuditoriaObligatorio['visitas']) : 0;
$cantidadVariables = (!empty($visitasVisibilidadAuditoriaObligatorio['variables'])) ? count($visitasVisibilidadAuditoriaObligatorio['variables']) : 0;
$cantidadColumnasDetalleVisitaVariable = 4;
$contadorFilas = 1;
?>

<div class="row">
    <div class="col-md-12">
        <?php if ($cantidadVisitasVisibilidadAuditoriaObligatorio == 0) { ?>
            No se han generado registros
        <?php } else { ?>
            <div class="overflow-auto" style="height: 20rem;">
                <table id="tablaVisibilidadAuditoriaObligatorio" class="mb-0 table-bordered table-sm no-footer" style="width:100%">
                    <thead>
                        <tr>
                            <th colspan="3" class="text-center align-middle">ELEMENTOS VISIBILIDAD</th>
                            <th colspan="<?= $cantidadVisitasVisibilidadAuditoriaObligatorio * $cantidadVariables * $cantidadColumnasDetalleVisitaVariable ?>" class="text-center align-middle">VISITAS</th>
                        </tr>
                        <tr>
                            <th rowspan="3" class="text-center align-middle">#</th>
                            <th rowspan="3" class="text-center align-middle">ELEMENTO</th>
                            <th rowspan="3" class="text-center align-middle">TIPO</th>
                            <?php foreach ($visitasVisibilidadAuditoriaObligatorio['visitas'] as $keyVisita => $visita) { ?>
                                <th colspan="<?= $cantidadColumnasDetalleVisitaVariable * $cantidadVariables ?>" class="text-center align-middle">
                                    COD. VISITA <?= $visita['idVisita'] ?><br>
                                    <?= $visita['tipoUsuario'] ?> : <?= $visita['nombreUsuario'] ?><br>
                                    (<?= $visita['fecha'] ?> <?= time_change_format($visita['hora']) ?>)<br>
                                    PORC.: <?= !empty($visita['porcentaje']) ? number_format((float) $visita['porcentaje'], 2, '.', '') : '-'  ?>%
                                    PORC. V: <?= !empty($visita['porcentajeV']) ? number_format((float) $visita['porcentajeV'], 2, '.', '') : '-'   ?>%
                                    PORC. PM: <?= !empty($visita['porcentajePM']) ? number_format((float) $visita['porcentajePM'], 2, '.', '') : '-'   ?>%
                                </th>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php for ($i = 0; $i < $cantidadVisitasVisibilidadAuditoriaObligatorio; $i++) { ?>
                                <?php foreach ($visitasVisibilidadAuditoriaObligatorio['variables'] as $keyVariable => $variable) { ?>
                                    <th colspan="<?= $cantidadColumnasDetalleVisitaVariable ?>" class="text-center align-middle"><?= $variable['variable'] ?></th>
                                <?php } ?>
                            <?php } ?>
                        </tr>

                        <tr>
                            <?php for ($i = 0; $i < $cantidadVisitasVisibilidadAuditoriaObligatorio * $cantidadVariables; $i++) { ?>
                                <th class="text-center align-middle">PRESENCIA</th>
                                <th class="text-center align-middle">OBSERVACIÓN</th>
                                <th class="text-center align-middle">COMENTARIO</th>
                                <th class="text-center align-middle">CANTIDAD</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($visitasVisibilidadAuditoriaObligatorio['elementosVisibilidad'] as $keyElementoVisibilidad => $elementoVisibilidad) { ?>
                            <tr>
                                <td class="text-center align-middle"><?= $contadorFilas ?></td>
                                <td class="text-center align-middle"><?= $elementoVisibilidad['elementoVisibilidad'] ?></td>
                                <td class="text-center align-middle"><?= $elementoVisibilidad['tipoElementoVisibilidad'] ?></td>

                                <?php foreach ($visitasVisibilidadAuditoriaObligatorio['visitas'] as $keyVisita => $visita) { ?>
                                    <?php foreach ($visitasVisibilidadAuditoriaObligatorio['variables'] as $keyVariable => $variable) { ?>
                                        <?php if (empty($elementoVisibilidad['infoVisitas'][$keyVisita])) { ?>
                                            <?php for ($i = 0; $i < $cantidadColumnasDetalleVisitaVariable; $i++) { ?>
                                                <td class="text-center align-middle">-</td>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <td class="text-center align-middle"><?= !empty($elementoVisibilidad['infoVisitas'][$keyVisita]['variables'][$keyVariable]['presencia']) ? 'Sí' : 'No' ?></td>
                                            <td class="text-center align-middle"><?= !empty($elementoVisibilidad['infoVisitas'][$keyVisita]['variables'][$keyVariable]['observacion']) ? $elementoVisibilidad['infoVisitas'][$keyVisita]['variables'][$keyVariable]['observacion'] : '-' ?></td>
                                            <td class="text-center align-middle"><?= !empty($elementoVisibilidad['infoVisitas'][$keyVisita]['variables'][$keyVariable]['comentario']) ? $elementoVisibilidad['infoVisitas'][$keyVisita]['variables'][$keyVariable]['comentario'] : '-' ?></td>
                                            <td class="text-center align-middle"><?= !empty($elementoVisibilidad['infoVisitas'][$keyVisita]['variables'][$keyVariable]['cantidad']) ? $elementoVisibilidad['infoVisitas'][$keyVisita]['variables'][$keyVariable]['cantidad'] : '-' ?></td>
                                        <?php } ?>
                                    <?php } ?>
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