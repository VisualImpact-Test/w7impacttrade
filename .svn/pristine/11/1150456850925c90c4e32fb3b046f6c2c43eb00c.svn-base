<div class="card-datatable">
    <table class="table table-striped table-bordered nowrap" width="100%">
        <thead>
            <tr>
                <th class="noVis"></th>
                <th class="text-center noVis">#</th>
                <th class="text-center">OPCIONES</th>
                <th class="text-center">CÓDIGO</th>
                <th class="text-center">TIPO DOCUMENTO</th>
                <th class="text-center">NUM DOCUMENTO</th>
                <th class="text-center">NOMBRES</th>
                <th class="text-center">APELLIDO PATERNO</th>
                <th class="text-center">APELLIDO MATERNO</th>
                <th class="text-center colNumerica">USUARIO</th>
                <th class="text-center colNumerica">EXTERNO</th>
                <th class="text-center">FECHA REGISTRO</th>
                <th class="text-center">FECHA MODIFICACIÓN</th>
                <th class="text-center">ESTADO</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultados as $value) {
                $estaRegistrado = !empty($value['idUsuario']) ? true : false;
                $iconoBotonEstado = $value['estado'] == 1 ? 'fal fa-lg fa-toggle-on' : 'fal fa-lg fa-toggle-off';
                $iconoBotonActivo = $value['flag_activo'] == 1 ? 'fa fa-unlock' : 'fa fa-lock';
                $tituloBotonActivo = $value['flag_activo'] == 1 ? 'Desactivar Login de Usuario' : 'Activar Login de Usuario';
                if (!$estaRegistrado) {
                    $mensajeExterno = 'Sí';
                    $mensajeEstado = 'Nuevo';
                    $badge = 'badge-success';
                } else {
                    $mensajeExterno = $value['externo'] == 1 ? 'Sí' : 'No';
                    $mensajeEstado = $value['estado'] == 1 ? 'Activo' : 'Inactivo';
                    $badge = $value['estado'] == 1 ? 'badge-success' : 'badge-danger';
                }
            ?>
                <tr data-id="<?= $value['idUsuario'] ?>" data-estado="<?= $value['estado'] ?>" data-activo="<?= $value['flag_activo'] ?>" style="<?=($value['flag_nuevo'] == true) ? "background-color: #badbff;" : ""?>">
                    <td></td>
                    <td></td>
                    <td>
                        <div>
                            <?php if (!$estaRegistrado) {
                                $datosDefault = [
                                    'nombres' => $value['nombresRRHH'],
                                    'apePaterno' => $value['apePaternoRRHH'],
                                    'apeMaterno' => $value['apeMaternoRRHH'],
                                    'idTipoDocumento' => $value['idTipoDocIdentRRHH'],
                                    'tipoDocumento' => $value['tipoDocumentoRRHH'],
                                    'numDocumento' => $value['numDocIdentRRHH'],
                                    'usuario' => $value['numDocIdentRRHH'],
                                    'idCuenta' => $value['idCuentaRRHH'],
                                    'nombreEmpresa' => $value['nombreEmpresaRRHH'],
                                    'idEmpleado' => $value['idEmpleadoRRHH'],
                                    'email' => $value['email_corpRRHH'],
                                ]
                            ?>
                                <button data-extra='<?= json_encode($datosDefault) ?>' class="btn btn-New btn-outline-secondary border-0" title="Agregar Nuevo Usuario"><i class="fa fa-plus"></i></button>
                            <?php } else { ?>
                                <button class="btn btn-EditarHistoricosDeUsuario btn-outline-secondary border-0" title="Editar Permisos"><i class="fa fa-lg fa-list-ol"></i></button>
                                <!-- <button class="btn btn-Editar btn-outline-secondary border-0" title="Editar"><i class="fas fa-edit fa-lg"></i></button> -->
                                <!-- <button class="btn btn-CambiarEstado btn-outline-secondary border-0" title="Activar/Desactivar"><i class="<?= $iconoBotonEstado ?>"></i></button> -->
                                <? if($this->session->userdata('idTipoUsuario') == 4){ ?>
                                <!-- <button class="btn btn-CambiarActivo btn-outline-secondary border-0" title="<?= $tituloBotonActivo ?>"><i class="<?= $iconoBotonActivo ?>"></i></button> -->
                                <? } ?>
                            <?php } ?>
                        </div>
                        <?=($value['flag_nuevo'] == true) ? '<label class="badge badge-danger" >NUEVO</label>' : ''?>
                    </td>
                    <td><?= !empty($value['idUsuario']) ? $value['idUsuario'] : '-' ?></td>
                    <?php if (!$estaRegistrado) { ?>
                        <td><?= !empty($value['tipoDocumentoRRHH']) ? $value['tipoDocumentoRRHH'] : '-' ?></td>
                        <td><?= !empty($value['numDocIdentRRHH']) ? $value['numDocIdentRRHH'] : '-' ?></td>
                        <td><?= !empty($value['nombresRRHH']) ? $value['nombresRRHH'] : '-' ?></td>
                        <td><?= !empty($value['apePaternoRRHH']) ? $value['apePaternoRRHH'] : '-' ?></td>
                        <td><?= !empty($value['apeMaternoRRHH']) ? $value['apeMaternoRRHH'] : '-' ?></td>
                    <?php } else { ?>
                        <td><?= !empty($value['tipoDocumento']) ? $value['tipoDocumento'] : '-' ?></td>
                        <td><?= !empty($value['numDocumento']) ? $value['numDocumento'] : '-' ?></td>
                        <td><?= !empty($value['nombres']) ? $value['nombres'] : '-' ?></td>
                        <td><?= !empty($value['apePaterno']) ? $value['apePaterno'] : '-' ?></td>
                        <td><?= !empty($value['apeMaterno']) ? $value['apeMaterno'] : '-' ?></td>
                    <?php } ?>
                    <td><?= !empty($value['usuario']) ? $value['usuario'] : '-' ?></td>
                    <td><?= $mensajeExterno ?></td>
                    <td data-order="<?= strtotime($value['fechaCreacion']) ?>"><?= !empty($value['fechaCreacion']) ? date_change_format($value['fechaCreacion'])  : '-' ?></td>
                    <td data-order="<?= strtotime($value['fechaModificacion']) ?>"><?= !empty($value['fechaModificacion']) ? date_change_format($value['fechaModificacion']) : '-' ?></td>
                    <td data-order="<?= $mensajeEstado ?>" class="style-icons">
                        <span class="badge <?= $badge ?>"><?= $mensajeEstado ?></span>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>