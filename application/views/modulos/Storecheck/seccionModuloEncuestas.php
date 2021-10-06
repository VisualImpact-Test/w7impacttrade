<?php
$cantidadVisitasEncuesta = (!empty($visitasEncuesta['visitas'])) ? count($visitasEncuesta['visitas']) : 0;
$cantidadEncuestas = (!empty($visitasEncuesta['encuestas'])) ? count($visitasEncuesta['encuestas']) : 0;
$cantidadTotalDePreguntasDeTodasEncuestas = 0;
if ($cantidadEncuestas != 0) {
    foreach ($visitasEncuesta['encuestas'] as $key => $encuesta) {
        $cantidadTotalDePreguntasDeTodasEncuestas += count($encuesta['preguntas']);
    }
}
$idTipoPreguntaAbierta = 1;
$idTipoPreguntaCerrada = 2;
$idTipoPreguntaMultiple = 3;
$espacioColumnaTotal = 1;
$ubicacionFotos = "http://movil.visualimpact.com.pe/fotos/impactTrade_android/encuesta/";
?>

<div class="col-md-12">
    <div class="mb-3 card">
        <div class="card-header"><i class="fa fa-table" aria-hidden="true"></i> &nbsp;&nbsp;Módulo Encuestas &nbsp;<span class="badge badge-secondary">Visitas <?= $cantidadVisitasEncuesta ?> | Encuestas <?= $cantidadEncuestas ?></span></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?php if ($cantidadVisitasEncuesta == 0) { ?>
                        No se han generado registros
                    <?php } else { ?>
                        <div class="overflow-auto">
                            <table id="tablaVisitasEncuesta" class="mb-0 table-bordered table-sm no-footer" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle" colspan="4">VISITAS</th>
                                        <th class="text-center align-middle" colspan="<?= $cantidadTotalDePreguntasDeTodasEncuestas + ($espacioColumnaTotal * $cantidadEncuestas) ?>">ENCUESTAS</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center align-middle" rowspan="2">COD. VISITA</th>
                                        <th class="text-center align-middle" rowspan="2">FECHA</th>
                                        <th class="text-center align-middle" rowspan="2">TIPO USUARIO</th>
                                        <th class="text-center align-middle" rowspan="2">USUARIO</th>
                                        <?php foreach ($visitasEncuesta['encuestas'] as $key => $encuesta) { ?>
                                            <th class="text-center align-middle" colspan="<?= count($encuesta['preguntas']) + $espacioColumnaTotal  ?>">
                                                <?= $encuesta['encuesta'] ?>
                                            </th>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php foreach ($visitasEncuesta['encuestas'] as $keyEncuesta => $encuesta) { ?>
                                            <th class="text-center align-middle">INFO VISITA - ENCUESTA</th>
                                            <?php foreach ($encuesta['preguntas'] as $keyPregunta => $pregunta) { ?>
                                                <th class="text-center align-middle"><?= $pregunta['pregunta'] ?> <br>(<?= $pregunta['tipoPregunta'] ?>)</th>
                                            <?php  } ?>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($visitasEncuesta['visitas'] as $key => $visita) { ?>
                                        <tr>
                                            <td class="text-center align-middle"><?= $visita['idVisita'] ?></td>
                                            <td class="text-center align-middle"><?= date_change_format($visita['fecha']) ?></td>
                                            <td><?= $visita['tipoUsuario'] ?></td>
                                            <td><?= $visita['nombreUsuario'] ?></td>

                                            <?php foreach ($visitasEncuesta['encuestas'] as $keyEncuesta => $encuesta) { ?>
                                                <?php if (empty($visita['encuestas'][$keyEncuesta])) { ?>
                                                    <td class="text-center celdaNula">-</td>
                                                <?php } else { ?>
                                                    <?php $encuestaTieneFoto = !empty($visita['encuestas'][$keyEncuesta]['fotoUrl']) ? true : false ?>
                                                    <?php $linkFoto = $ubicacionFotos . $visita['encuestas'][$keyEncuesta]['fotoUrl'] ?>
                                                    <td class="text-center">
                                                        HORA: <?= time_change_format($visita['encuestas'][$keyEncuesta]['hora']) ?>
                                                        <button data-urlfoto="<?= $linkFoto ?>" class="btn-verFoto btn-sm border-0 btn-transition btn btn-outline-primary" <?= !$encuestaTieneFoto ? 'disabled' : '' ?>><i class="fa fa-camera" aria-hidden="true"></i></button>
                                                    </td>
                                                <?php } ?>
                                                <?php if (empty($visita['encuestas'][$keyEncuesta])) { ?>
                                                    <?php for ($i = 0; $i < count($encuesta['preguntas']); $i++) { ?>
                                                        <td class="text-center celdaNula">-</td>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <?php foreach ($encuesta['preguntas'] as $keyPregunta => $pregunta) { ?>
                                                        <?php $hayInfoPregunta = !empty($visita['encuestas'][$keyEncuesta]['preguntas'][$keyPregunta]) ? true : false ?>
                                                        <?php if (!$hayInfoPregunta) { ?>
                                                            <td class="text-center">-</td>
                                                        <?php } else { ?>
                                                            <td class="text-center align-middle">
                                                                <?php $respuestaTieneFoto = !empty($visita['encuestas'][$keyEncuesta]['preguntas'][$keyPregunta]['fotoUrlDet']) ? true : false ?>
                                                                <?php $linkFotoDet = $ubicacionFotos . $visita['encuestas'][$keyEncuesta]['preguntas'][$keyPregunta]['fotoUrlDet'] ?>
                                                                <?php if ($pregunta['idTipoPregunta'] == $idTipoPreguntaAbierta) { ?>
                                                                    <?= $visita['encuestas'][$keyEncuesta]['preguntas'][$keyPregunta]['respuesta'] ?>
                                                                <?php } elseif ($pregunta['idTipoPregunta'] == $idTipoPreguntaCerrada) { ?>
                                                                    <?= $visita['encuestas'][$keyEncuesta]['preguntas'][$keyPregunta]['alternativa'] ?>
                                                                <?php  } elseif ($pregunta['idTipoPregunta'] == $idTipoPreguntaMultiple) {
                                                                    $alternativas = [];
                                                                    foreach ($visita['encuestas'][$keyEncuesta]['preguntas'][$keyPregunta]['alternativasMultiples']  as $keyAlternativa => $alternativa) {
                                                                        $alternativas[] .= $alternativa['alternativa'];
                                                                    }
                                                                ?>
                                                                    <?= implode(', ', $alternativas) . '.' ?>
                                                                <?php  } ?>
                                                                <button data-urlfoto="<?= $linkFotoDet ?>" class="btn-verFoto btn-sm border-0 btn-transition btn btn-outline-primary" <?= !$respuestaTieneFoto ? 'disabled' : '' ?>><i class="fa fa-camera" aria-hidden="true"></i></button>
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