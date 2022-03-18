<?php
$cantidadVisitasIpp = (!empty($visitasIpp['visitas'])) ? count($visitasIpp['visitas']) : 0;
$cantidadIpp = (!empty($visitasIpp['ipp'])) ? count($visitasIpp['ipp']) : 0;
$cantidadTotalDePreguntasDeTodosIpp = 0;
if ($cantidadIpp != 0) {
    foreach ($visitasIpp['ipp'] as $key => $ipp) {
        $cantidadTotalDePreguntasDeTodosIpp += count($ipp['preguntas']);
    }
}
$idTipoPreguntaAbierta = 1;
$idTipoPreguntaCerrada = 2;
$idTipoPreguntaMultiple = 3;
$espacioColumnaTotal = 1;
?>

<div class="col-md-12">
    <div class="mb-3 card">
        <div class="card-header"><i class="fa fa-table" aria-hidden="true"></i> &nbsp;&nbsp;Módulo Ipp &nbsp;<span class="badge badge-secondary">Visitas <?= $cantidadVisitasIpp ?> | Ipps <?= $cantidadIpp ?></span></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?php if ($cantidadVisitasIpp == 0) { ?>
                        No se han generado registros
                    <?php } else { ?>
                        <div class="overflow-auto">
                            <table id="tablaVisitasIpp" class="mb-0 table table-bordered table-sm no-footer">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle" colspan="4">VISITAS</th>
                                        <th class="text-center align-middle" colspan="<?= $cantidadTotalDePreguntasDeTodosIpp + ($espacioColumnaTotal * $cantidadIpp) ?>">IPPs</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center align-middle" rowspan="2">COD. VISITA</th>
                                        <th class="text-center align-middle" rowspan="2">FECHA</th>
                                        <th class="text-center align-middle" rowspan="2">TIPO USUARIO</th>
                                        <th class="text-center align-middle" rowspan="2">USUARIO</th>
                                        <?php foreach ($visitasIpp['ipp'] as $key => $ipp) { ?>
                                            <th class="text-center align-middle" colspan="<?= count($ipp['preguntas']) + $espacioColumnaTotal ?>">
                                                <?= $ipp['ipp'] ?>
                                            </th>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php foreach ($visitasIpp['ipp'] as $keyIpp => $ipp) { ?>
                                            <th class="text-center align-middle">Total</th>
                                            <?php foreach ($ipp['preguntas'] as $keyPregunta => $pregunta) { ?>
                                                <th class="text-center align-middle"><?= $pregunta['pregunta'] ?> <br>(<?= $pregunta['tipoPregunta'] ?> - <?= $pregunta['criterio'] ?>)</th>
                                            <?php  } ?>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($visitasIpp['visitas'] as $key => $visita) { ?>
                                        <tr>
                                            <td class="text-center align-middle"><?= $visita['idVisita'] ?></td>
                                            <td class="text-center align-middle"><?= date_change_format($visita['fecha']) ?></td>
                                            <td><?= $visita['tipoUsuario'] ?></td>
                                            <td><?= $visita['nombreUsuario'] ?></td>

                                            <?php foreach ($visitasIpp['ipp'] as $keyIpp => $ipp) { ?>
                                                <?php if (empty($visita['ipp'][$keyIpp])) { ?>
                                                    <?php for ($i = 0; $i < count($ipp['preguntas']) + $espacioColumnaTotal; $i++) { ?>
                                                        <td class="text-center celdaNula">-</td>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <?php if (empty($visita['ipp'][$keyIpp])) { ?>
                                                        <td class="text-center celdaNula">-</td>
                                                    <?php } else { ?>
                                                        <?php $ippTieneFoto = !empty($visita['ipp'][$keyIpp]['fotoUrl']) ? true : false ?>
                                                        <?php $linkFoto = verificarUrlFotos($visita['ipp'][$keyIpp]['fotoUrl']) . 'ipp/' . $visita['ipp'][$keyIpp]['fotoUrl'] ?>
                                                        <td class="text-center">
                                                            HORA: <?= time_change_format($visita['ipp'][$keyIpp]['hora']) ?> (<?= number_format((float) $visita['ipp'][$keyIpp]['puntaje'], 2, '.', '') ?>)
                                                            <button data-urlfoto="<?= $linkFoto ?>" class="btn-verFoto btn-sm border-0 btn-transition btn btn-outline-primary" <?= !$ippTieneFoto ? 'disabled' : '' ?>><i class="fa fa-camera" aria-hidden="true"></i></button>
                                                        </td>
                                                    <?php } ?>
                                                    <?php foreach ($ipp['preguntas'] as $keyPregunta => $pregunta) { ?>
                                                        <?php $hayInfoPregunta = !empty($visita['ipp'][$keyIpp]['preguntas'][$keyPregunta]) ? true : false ?>
                                                        <?php $esPreguntaAbierta = ($pregunta['idTipoPregunta'] == $idTipoPreguntaAbierta) ? true : false ?>
                                                        <?php if (!$hayInfoPregunta) { ?>
                                                            <td class="text-center">-</td>
                                                        <?php } else { ?>
                                                            <td class="text-center align-middle">
                                                                <?php if ($pregunta['idTipoPregunta'] == $idTipoPreguntaAbierta || $pregunta['idTipoPregunta'] == $idTipoPreguntaCerrada) { ?>
                                                                    <?= $visita['ipp'][$keyIpp]['preguntas'][$keyPregunta]['alternativa'] ?> (<?= number_format((float) $visita['ipp'][$keyIpp]['preguntas'][$keyPregunta]['puntajeAlternativa'], 2, '.', '')   ?>)
                                                                <?php  } elseif ($pregunta['idTipoPregunta'] == $idTipoPreguntaMultiple) { ?>
                                                                    <?php $puntajeTotalDeAlternativas = 0;
                                                                    $alternativas = [];
                                                                    foreach ($visita['ipp'][$keyIpp]['preguntas'][$keyPregunta]['alternativasMultiples']  as $keyAlternativa => $alternativa) {
                                                                        $puntajeTotalDeAlternativas += $alternativa['puntajeAlternativa'];
                                                                        $alternativas[] = $alternativa['alternativa'];
                                                                    }
                                                                    ?>
                                                                    <?= implode(', ', $alternativas) . '.' ?>

                                                                    (<?= number_format((float) $puntajeTotalDeAlternativas, 2, '.', '') ?>)
                                                                <?php  } ?>
                                                            </td>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php  } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>