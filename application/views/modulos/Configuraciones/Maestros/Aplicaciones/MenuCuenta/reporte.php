<div class="card-datatable">
    <table class="table table-striped table-bordered nowrap" width="100%">
        <thead>
            <tr>
                <th></th>
                <th class="text-center">#</th>
                <th class="text-center">OPCIONES</th>
                <th class="text-center">CUENTA</th>
                <th class="text-center">PROYECTO</th>
                <th class="text-center">GRUPO CANAL</th>
                <th class="text-center">TIPO USUARIO</th>
                <th class="text-center">APLICACION</th>
                <th class="text-center">MENU</th>
                <th class="text-center">ESTADO</th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($resultados as $value) {
                $badge = $value['estado'] == 1 ? 'badge-primary' : 'badge-danger';
                $mensajeEstado = $value['estado'] == 1 ? 'Activo' : 'Inactivo';
                $iconoBotonEstado = $value['estado'] == 1 ? 'fal fa-lg fa-toggle-on' : 'fal fa-lg fa-toggle-off';
            ?>
                <tr data-id="<?= $value['idListAplicacionMenu'] ?>" data-estado="<?= $value['estado'] ?>">
                    <td></td>
                    <td></td>
                    <td>
                        <div>
                            <button class="btn btn-Editar btn-outline-secondary border-0" title="Editar"><i class="fas fa-lg fa-edit"></i></button>
                            <button class="btn btn-CambiarEstado btn-outline-secondary border-0" title="Activar/Desactivar"><i class="<?= $iconoBotonEstado ?>"></i></button>
                        </div>
                    </td>
                    <td><?= verificarEmpty($value['cuenta'], 3) ?></td>
                    <td><?= verificarEmpty($value['proyecto'], 3) ?></td>
                    <td><?= verificarEmpty($value['grupoCanal'], 3) ?></td>
                    <td><?= verificarEmpty($value['tipoUsuario'], 3) ?></td>
                    <td><?= verificarEmpty($value['aplicacion'], 3) ?></td>
                    <td><?= verificarEmpty($value['menu'], 3) ?></td>
                    <td data-order="<?= $mensajeEstado ?>" class="style-icons">
                        <span class="badge <?= $badge ?>"><?= $mensajeEstado ?></span>
                    </td>
                </tr>
            <? } ?>
        </tbody>
    </table>
</div>