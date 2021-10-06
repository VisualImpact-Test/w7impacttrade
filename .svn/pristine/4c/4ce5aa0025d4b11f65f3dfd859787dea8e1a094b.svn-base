<?php $cantidadVisitas = count($visitas);
$ubicacionFotos = "http://movil.visualimpact.com.pe/fotos/impactTrade_android/incidencias/";

?>
<div class="col-md-7">
    <div class="mb-3 card">
        <div class="card-header"><i class="fa fa-table" aria-hidden="true"></i> &nbsp;&nbsp;Visitas&nbsp;<span class="badge badge-secondary"><?= $cantidadVisitas ?> Visitas</span></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?php if ($cantidadVisitas == 0) { ?>
                        No se han generado registros
                    <?php } else { ?>
                        <div class="overflow-auto" style="height: 18rem;">
                            <table id="tablaVisitas" class="mb-0 table-bordered table-sm no-footer" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle fixedHeader">COD. VISITA</th>
                                        <th class="text-center align-middle fixedHeader">TIPO USUARIO</th>
                                        <th class="text-center align-middle fixedHeader">USUARIO</th>
                                        <th class="text-center align-middle fixedHeader">FECHA</th>
                                        <th class="text-center align-middle fixedHeader">ESTADO</th>
                                        <th class="text-center align-middle fixedHeader">INCIDENCIA</th>
                                        <th class="text-center align-middle fixedHeader">OBSERVACIÓN</th>
                                        <th class="text-center align-middle fixedHeader">FOTO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $contador = 0;
                                    foreach ($visitas as $key => $visita) {
                                        $contador++; ?>
                                        <tr>
                                            <td class="text-center align-middle"><?= $visita['idVisita'] ?></td>
                                            <td><?= $visita['tipoUsuario'] ?></td>
                                            <td><?= $visita['nombreUsuario'] ?></td>
                                            <td class="text-center align-middle"><?= date_change_format($visita['fecha']) ?></td>

                                            <?php if ($visita['idIncidencia'] != null) {
                                                $estadoVisita = '<div class="mb-2 mr-2 badge badge-warning">Incidencia</div>';
                                            } elseif (empty($visita['efectiva'])) {
                                                $estadoVisita = '<div class="mb-2 mr-2 badge badge-danger">No Efectiva</div>';
                                            } else {
                                                $estadoVisita = '<div class="mb-2 mr-2 badge badge-primary">Efectiva</div>';
                                            } ?>

                                            <td class="text-center align-middle"><?= $estadoVisita ?></td>
                                            <td><?= !empty($visita['incidencia']) ? $visita['incidencia'] : '-' ?></td>
                                            <td><?= !empty($visita['observacion']) ? $visita['observacion'] : '-' ?></td>
                                            <?php $visitaTieneFoto = !empty($visita['fotoUrl']) ? true : false ?>
                                            <?php $linkFoto = $ubicacionFotos . $visita['fotoUrl'] ?>
                                            <td class="text-center align-middle">
                                                <?php if (!$visitaTieneFoto) { ?>
                                                    -
                                                <?php } else { ?>
                                                    <button data-urlfoto="<?= $linkFoto ?>" class="btn-verFoto btn-sm border-0 btn-transition btn btn-outline-primary"><i class="fa fa-camera" aria-hidden="true"></i></button>
                                                <?php } ?>
                                            </td>
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