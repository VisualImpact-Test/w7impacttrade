<div class="card-datatable">
    <table class="table table-striped table-bordered nowrap w-100 text-nowrap">
        <thead>
            <tr>
                <th class="noVis p-3" ></th>
                <th class="text-center noVis" >#</th>
                <th class="text-center">OPCIONES</th>
                <th class="text-center">USUARIO</th>
                <th class="text-center colNumerica">DOCUMENTO</th>
                <th class="text-center"> CORREO</th>
                <th class="text-center"> TIPO DE USUARIO</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultados as $value) {
                $badge = $value['estado'] == 1 ? 'badge-success' : 'badge-danger';
                $mensajeEstado = $value['estado'] == 1 ? 'Activo' : 'Inactivo';
                $iconoBotonEstado = $value['estado'] == 1 ? 'fa fa-toggle-on fa-lg' : 'fa fa-toggle-off fa-lg';
            ?>
                <tr data-id="<?= $value['idUsuario'] ?>" data-estado="<?= $value['estado'] ?>">
                    <td></td>
                    <td></td>
                    <td>
                        <div>
                            <button class="btn btn-Editar btn-outline-secondary border-0" title="Editar"><i class="fas fa-edit fa-lg"></i></button>
                        </div>
                    </td>
                    <td><?= $value['nombres'] . ' ' . $value['apePaterno'] . ' ' . $value['apeMaterno'] ?></td>
                    <td><?= !empty($value['nroDocumento']) ? $value['nroDocumento'] : '-' ?></td>
                    <td class="center"><?= !empty($value['correo']) ? $value['correo'] : '-' ?></td>
                    <td class="center"><?= !empty($value['tipo']) ? $value['tipo'] : '-' ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>