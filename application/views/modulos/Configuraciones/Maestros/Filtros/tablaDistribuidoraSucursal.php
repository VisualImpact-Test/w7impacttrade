<div class="card-datatable">
    <table class="table table-striped table-bordered nowrap" width="100%">
        <thead class="">
            <tr>
                <th class="noVis px-4"></th>
                <th class="text-center noVis">#</th>
                <th class="text-center">OPCIONES</th>
                <th class="text-center">NOMBRE</th>
                <th class="text-center">CORREO</th>
                <th class="text-center">DISTRIBUIDORA</th>
                <th class="text-center">CORREO DISTRIBUIDORA</th>
                <th class="text-center">DEPARTAMENTO</th>
                <th class="text-center">PROVINCIA</th>
                <th class="text-center">DISTRITO</th>
                <th class="text-center">ESTADO</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $value) {
                $badge = $value['estado'] == 1 ? 'badge-success' : 'badge-danger';
                $mensajeEstado = $value['estado'] == 1 ? 'Activo' : 'Inactivo';
                $iconoBotonEstado = $value['estado'] == 1 ? 'fal fa-lg fa-toggle-on' : 'fal fa-lg fa-toggle-off';
            ?>
                <tr data-id="<?= $value[$this->m_filtros->tablas['distribuidora']['id']] ?>" data-estado="<?= $value['estado'] ?>">
                    <td></td>
                    <td></td>
                    <td>
                        <div>
                            <button class="btn btn-Editar btn-outline-secondary border-0" title="Editar"><i class="fas fa-lg fa-edit"></i></button>
                            <button class="btn btn-CambiarEstado btn-outline-secondary border-0" title="Activar/Desactivar"><i class="<?= $iconoBotonEstado ?>"></i></button>
                        </div>
                    </td>
                    <td><?= !empty($value['nombre']) ? $value['nombre'] : '-' ?></td>
                    <td><?= !empty($value['correoDistribuidoraSucursal']) ? $value['correoDistribuidoraSucursal'] : '-' ?></td>
                    <td><?= !empty($value['distribuidora']) ? $value['distribuidora'] : '-' ?></td>
                    <td><?= !empty($value['correoDistribuidoraSucursal']) ? $value['correoDistribuidoraSucursal'] : '-' ?></td>
                    <td><?= !empty($value['departamento']) ? $value['departamento'] : '-' ?></td>
                    <td><?= !empty($value['provincia']) ? $value['provincia'] : '-' ?></td>
                    <td><?= !empty($value['distrito']) ? $value['distrito'] : '-' ?></td>
                    <td data-order="<?= $mensajeEstado ?>" class="style-icons">
                        <span class="badge <?= $badge ?>"><?= $mensajeEstado ?></span>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>