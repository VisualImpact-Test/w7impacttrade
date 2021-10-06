<div class="card-datatable">
    <table class="mb-0 table table-bordered text-nowrap w-100">
        <thead>
            <tr>
                <th></th>
                <th class="text-center">#</th>
                <th class="text-center">OPCIONES</th>
                <th class="text-center">ID ELEMENTO</th>
                <th class="text-center">ELEMENTO</th>
                <th class="text-center">INICIATIVA</th>

                <th class="text-center">ESTADO</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $value) {
                $badge = $value['estado'] == 1 ? 'badge-success' : 'badge-danger';
                $mensajeEstado = $value['estado'] == 1 ? 'Activo' : 'Inactivo';
                $iconoBotonEstado = $value['estado'] == 1 ? 'fa fa-toggle-on fa-lg' : 'fa fa-toggle-off fa-lg';
            ?>
                <tr data-id="<?= $value[$this->model->tablas['elementoIniciativa']['id']] ?>" data-estado="<?= $value['estado'] ?>">
                    <td></td>
                    <td></td>
                    <td>
                        <div>
                            <button class="btn btn-Editar btn-outline-secondary border-0" title="Editar"><i class="fas fa-edit fa-lg"></i></button>
                            <button class="btn btn-CambiarEstado btn-outline-secondary border-0" title="Activar/Desactivar"><i class="<?= $iconoBotonEstado ?>"></i></button>
                        </div>
                    </td>
                    <td class="text-center"><?= !empty($value['idElementoVis']) ? $value['idElementoVis'] : '-' ?></td>
                    <td><?= !empty($value['nombre']) ? $value['nombre'] : '-' ?></td>
                    <td><?= !empty($value['iniciativa']) ? $value['iniciativa'] : '-' ?></td>
                    <td data-order="<?= $mensajeEstado ?>" class="text-center style-icons">
                        <span class="badge <?= $badge ?>"><?= $mensajeEstado ?></span>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>