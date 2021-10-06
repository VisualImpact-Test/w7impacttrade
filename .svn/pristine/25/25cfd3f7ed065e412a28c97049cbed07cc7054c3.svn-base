<div class="col-md-12">
    <div class="mb-3 card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="mb-0 table-bordered table-sm no-footer w-100 text-nowrap">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-center">#</th>
                                <th class="text-center">OPCIONES</th>
                                <th class="text-center">NOMBRE</th>
                                <th class="text-center">NOMBRE COMERCIAL</th>
                                <th class="text-center">RAZÓN SOCIAL</th>
                                <th class="text-center colNumerica">RUC</th>
                                <th class="text-center">DIRECCIÓN</th>
                                <th class="text-center colNumerica">CÓDIGO UBIGEO</th>
                                <th class="text-center">URL CSS</th>
                                <th class="text-center">URL LOGO</th>
                                <th class="text-center">FECHA REGISTRO</th>
                                <th class="text-center">FECHA MODIFICACIÓN</th>
                                <th class="text-center">ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cuentas as $value) {
                                $badge = $value['estado'] == 1 ? 'badge-success' : 'badge-danger';
                                $mensajeEstado = $value['estado'] == 1 ? 'Activo' : 'Inactivo';
                                $iconoBotonEstado = $value['estado'] == 1 ? 'fa fa-toggle-on fa-lg' : 'fa fa-toggle-off fa-lg';
                            ?>
                                <tr data-id="<?= $value['idCuenta'] ?>" data-estado="<?= $value['estado'] ?>">
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div>
                                            <button class="btn btn-Editar btn-outline-secondary border-0" title="Editar"><i class="fas fa-edit fa-lg"></i></button>
                                            <button class="btn btn-CambiarEstado btn-outline-secondary border-0" title="Activar/Desactivar"><i class="<?= $iconoBotonEstado ?>"></i></button>
                                        </div>
                                    </td>
                                    <td><?= !empty($value['nombre']) ? $value['nombre'] : '-' ?></td>
                                    <td><?= !empty($value['nombreComercial']) ? $value['nombreComercial'] : '-' ?></td>
                                    <td><?= !empty($value['razonSocial']) ? $value['razonSocial'] : '-' ?></td>
                                    <td><?= !empty($value['ruc']) ? $value['ruc'] : '-' ?></td>
                                    <td><?= !empty($value['direccion']) ? $value['direccion'] : '-' ?></td>
                                    <td><?= !empty($value['cod_ubigeo']) ? $value['cod_ubigeo'] : '-' ?></td>
                                    <td><?= !empty($value['urlCSS']) ? $value['urlCSS'] : '-' ?></td>
                                    <td><?= !empty($value['urlLogo']) ? $value['urlLogo'] : '-' ?></td>
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
            </div>
        </div>
    </div>
</div>