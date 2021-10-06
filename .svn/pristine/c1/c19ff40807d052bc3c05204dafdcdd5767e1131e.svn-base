<?php $ubicacionFotos = "http://movil.visualimpact.com.pe/fotos/impactTrade_Android/reprogramaciones/"; ?>
<div class="card-datatable">
    <table class="table table-striped table-bordered nowrap" width="100%">
        <thead>
            <tr>
                <th rowspan="2" class="text-center">#</th>
                <th rowspan="2" class="text-center">OPCIONES</th>
                <th colspan="6" class="text-center">PUNTO DE VENTA</th>
                <th colspan="2" class="text-center">VISITA</th>
                <th colspan="8" class="text-center">SOLICITUD</th>
                <th colspan="4" class="text-center">REPROGRAMACIÓN</th>
            </tr>

            <tr>
                <th class="text-center">CÓDIGO VISUAL</th>
                <th class="text-center">RAZÓN SOCIAL</th>
                <th class="text-center">DIRECCIÓN</th>
                <th class="text-center">DISTRITO</th>
                <th class="text-center">PROVINCIA</th>
                <th class="text-center">DEPARTAMENTO</th>

                <th class="text-center">FECHA ORIGINAL</th>
                <th class="text-center">FRECUENCIA</th>

                <th class="text-center">TIPO DOCUMENTO</th>
                <th class="text-center">DOCUMENTO</th>
                <th class="text-center">TIPO USUARIO</th>
                <th class="text-center">USUARIO</th>
                <th class="text-center">HORA</th>
                <th class="text-center">MOTIVO</th>
                <th class="text-center">OBSERVACIÓN</th>
                <th class="text-center">FOTO</th>

                <th class="text-center">USUARIO</th>
                <th class="text-center">FECHA REPROGRAMACION</th>
                <th class="text-center">COMENTARIO</th>
                <th class="text-center">STATUS</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultados as $value) {
                $estadoReprogramacion = $value['idEstadoReprogramacion'];
                switch ($estadoReprogramacion) {
                    case 1:
                        $mensajeEstado = 'Aprobado';
                        $badge = 'btn-primary';
                        break;

                    case 2:
                        $mensajeEstado = 'Rechazado';
                        $badge = 'btn-danger';
                        break;

                    default:
                        $mensajeEstado = 'Pendiente';
                        $badge = 'btn-warning';
                        break;
                }
            ?>
                <tr data-id="<?= $value['idVisitaReprogramacion'] ?>" data-idusuario="<?= $value['idUsuario'] ?>" data-idcuenta="<?= $value['idCuenta'] ?>" data-idproyecto="<?= $value['idProyecto'] ?>" data-idcliente="<?= $value['idCliente'] ?>" data-estado="<?= $estadoReprogramacion ?>">
                    <td></td>
                    <td>
                        <div>
                            <button <?= ($estadoReprogramacion == 1) ? 'disabled' : '' ?> class="btn btn-Reprogramar btn-outline-secondary border-0" title="Reprogramar"><i class="fa fa-lg fa-calendar-times"></i></button>
                        </div>
                    </td>
                    <td class="colNumerica text-center"><?= !empty($value['idCliente']) ? $value['idCliente'] : '-' ?></td>
                    <td><?= !empty($value['razonSocial']) ? $value['razonSocial'] : '-' ?></td>
                    <td><?= !empty($value['direccion']) ? $value['direccion'] : '-' ?></td>
                    <td><?= !empty($value['distrito']) ? $value['distrito'] : '-' ?></td>
                    <td><?= !empty($value['provincia']) ? $value['provincia'] : '-' ?></td>
                    <td><?= !empty($value['departamento']) ? $value['departamento'] : '-' ?></td>

                    <td class="colNumerica text-center" data-order="<?= strtotime($value['fecha']) ?>"><?= !empty($value['fecha']) ? date_change_format($value['fecha'])  : '-' ?></td>
                    <td><?= !empty($value['frecuencia']) ? $value['frecuencia'] : '-' ?></td>
                    <td><?= !empty($value['tipoDocumento']) ? $value['tipoDocumento'] : '-' ?></td>
                    <td class="colNumerica text-center"><?= !empty($value['numDocumento']) ? $value['numDocumento'] : '-' ?></td>
                    <td><?= !empty($value['tipoUsuario']) ? $value['tipoUsuario'] : '-' ?></td>
                    <td><?= !empty($value['nombreCompleto']) ? $value['nombreCompleto'] : '-' ?></td>
                    <td class="colNumerica" data-order="<?= strtotime($value['hora']) ?>"><?= !empty($value['hora']) ? time_change_format($value['hora']) : '-' ?></td>
                    <td><?= !empty($value['motivoReprogramacion']) ? $value['motivoReprogramacion'] : '-' ?></td>
                    <td><?= !empty($value['observacion']) ? $value['observacion'] : '-' ?></td>
                    <td class="text-center">
                        <?php if (!empty($value['fotoUrl'])) { ?>
                            <button data-urlfoto="<?= $ubicacionFotos . $value['fotoUrl'] ?>" class="btn btn-verFoto btn-outline-secondary border-0 btn-sm" title="Ver Foto"><i class="fa fa-lg fa-camera"></i></button>
                        <?php } else { ?>
                            -
                        <?php } ?>
                    </td>
                    <td><?= !empty($value['nombreCompletoUsuarioReprogramo']) ? $value['nombreCompletoUsuarioReprogramo'] : '-' ?></td>
                    <td class="colNumerica text-center" data-order="<?= strtotime($value['fechaNueva']) ?>"><?= !empty($value['fechaNueva']) ? date_change_format($value['fechaNueva']) : '-' ?></td>
                    <td><?= !empty($value['comentario']) ? $value['comentario'] : '-' ?></td>
                    <td data-order="<?= $mensajeEstado ?>" class="style-icons">
                        <span class="badge <?= $badge ?>"><?= $mensajeEstado ?></span>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
        </tbody>
    </table>
</div>
