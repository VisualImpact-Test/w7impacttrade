
<div class="card-datatable">
    <table class="table table-striped table-bordered nowrap" width="100%">
        <thead>
            <tr>
                <th></th>
                <th class="text-center">#</th>
                <th class="text-center">OPCIONES</th>
                <th class="text-center">NOMBRE</th>
                <th class="text-center">CUENTA</th>
                <th class="text-center">FOTO</th>
                <th class="text-center">FECHA REGISTRO</th>
                <th class="text-center">FECHA MODIFICACIÓN</th>
                <th class="text-center">ESTADO</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $value) {
                $badge = $value['estado'] == 1 ? 'badge-success' : 'badge-danger';
                $mensajeEstado = $value['estado'] == 1 ? 'Activo' : 'Inactivo';
                $iconoBotonEstado = $value['estado'] == 1 ? 'fal fa-lg fa-toggle-on' : 'fal fa-lg fa-toggle-off';
            ?>
                <tr data-id="<?= $value['idEncuesta'] ?>" data-estado="<?= $value['estado'] ?>">
                    <td></td>
                    <td></td>
                    <td>
                        <div>
                            <button class="btn btn-Preguntas btn-outline-secondary border-0" title="Preguntas"><i class="fas fa-lg fa-question"></i></button>
                            <button class="btn btn-Editar btn-outline-secondary border-0" title="Editar"><i class="fas fa-lg fa-edit"></i></button>
                            <button class="btn btn-CambiarEstado btn-outline-secondary border-0" title="Activar/Desactivar"><i class="<?= $iconoBotonEstado ?>"></i></button>
                        </div>
                    </td>
                    <td><?= !empty($value['nombre']) ? $value['nombre'] : '-' ?></td>
                    <td><?= !empty($value['razonSocial']) ? $value['razonSocial'] : $value['nombreComercial'] ?></td>
                    <td><?= !empty($value['foto']) && $value['foto'] == 1 ? "SÍ" : "NO" ?></td>
                    <!-- <td><?= !empty($value['razonSocial']) ? $value['razonSocial'] : '-' ?></td> -->
                    <!-- <td><?= !empty($value['ruc']) ? $value['ruc'] : '-' ?></td> -->
                    <!-- <td><?= !empty($value['direccion']) ? $value['direccion'] : '-' ?></td> -->
                    <!-- <td><?= !empty($value['cod_ubigeo']) ? $value['cod_ubigeo'] : '-' ?></td> -->
                    <!-- <td><?= !empty($value['urlCSS']) ? $value['urlCSS'] : '-' ?></td> -->
                    <!-- <td><?= !empty($value['urlLogo']) ? $value['urlLogo'] : '-' ?></td> -->
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
