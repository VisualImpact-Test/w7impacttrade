<div class="card-datatable">
    <table class="table table-striped table-bordered nowrap w-100 text-nowrap">
        <thead>
            <tr>
                <th class="noVis p-3" scope="col"></th>
                <th class="text-center noVis" scope="col">#</th>
                <th class="text-center">OPCIONES</th>
                <th class="text-center">NOMBRE</th>
                <th class="text-center">GRUPO</th>
                <th class="text-center">CARPETA</th>
                <th class="text-center">TIPO DE ARCHIVO</th>
                <th class="text-center colNumerica">ESPACIO OCUPADO</th>
                <th class="text-center">FECHA REGISTRO</th>
                <th class="text-center">FECHA MODIFICACIÓN</th>
                <th class="text-center">ESTADO</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultados as $value) {
                $badge = $value['estado'] == 1 ? 'badge-success' : 'badge-danger';
                $mensajeEstado = $value['estado'] == 1 ? 'Activo' : 'Inactivo';
                $iconoBotonEstado = $value['estado'] == 1 ? 'fa fa-toggle-on fa-lg' : 'fa fa-toggle-off fa-lg';
            ?>
                <tr data-id="<?= $value['idArchivo'] ?>" data-estado="<?= $value['estado'] ?>">
                    <td></td>
                    <td></td>
                    <td>
                        <div>
                            <!-- <button class="btn btn-Editar btn-outline-secondary border-0" title="Editar"><i class="fas fa-edit fa-lg"></i></button> -->
                            <button class="btn btn-CambiarEstado btn-outline-secondary border-0" title="Activar/Desactivar"><i class="<?= $iconoBotonEstado ?>"></i></button>
                            <button class="btn btn-DescargarArchivo btn-outline-secondary border-0" title="Descargar Archivo" data-file="<?=$value['nombreArchivo']?>" data-extension="<?=$value['extension']?>" data-name="<?=$value['nombreRegistrado']?>" data-idarchivo="<?= $value['idArchivo'] ?>"><i class="fa fa-download"></i></button>
                            <button class="btn btn-EliminarArchivo btn-outline-secondary border-0" title="Eliminar Archivo"><i class="fa fa-trash"></i></button>
                        </div>
                    </td>
                    <td><?= !empty($value['nombreRegistrado']) ? $value['nombreRegistrado'] : '-' ?></td>
                    <td><?= !empty($value['nombreGrupo']) ? $value['nombreGrupo'] : '-' ?></td>
                    <td><?= !empty($value['nombreCarpeta']) ? $value['nombreCarpeta'] : '-' ?></td>
                    <td><?= !empty($value['tipoArchivo']) ? $value['tipoArchivo'] : '-' ?></td>
                    <td><?= !empty($value['peso']) ? formatBytes($value['peso']) : '-' ?></td>
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