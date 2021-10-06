                <div class="card-datatable">
                    <table class="mb-0 table-bordered table-sm no-footer w-100 text-nowrap">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-center">#</th>
                                <th class="text-center">OPCIONES</th>
                                <th class="text-center">CUENTA</th>
                                <th class="text-center">PROYECTO</th>
                                <th class="text-center">NOMBRE</th>
                                <th class="text-center">URL</th>
                                <th class="text-center">ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $value) {
                                $badge = $value['estado'] == 1 ? 'badge-success' : 'badge-danger';
                                $mensajeEstado = $value['estado'] == 1 ? 'Activo' : 'Inactivo';
                                $iconoBotonEstado = $value['estado'] == 1 ? 'fa fa-toggle-on fa-lg' : 'fa fa-toggle-off fa-lg';
                            ?>
                                <tr data-id="<?= $value[$this->model->tablas['lista']['id']] ?>" data-estado="<?= $value['estado'] ?>">
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div>
                                            <button class="btn btn-Editar btn-outline-secondary border-0" title="Editar"><i class="fas fa-edit fa-lg"></i></button>
                                            <button class="btn btn-CambiarEstado btn-outline-secondary border-0" title="Activar/Desactivar"><i class="<?= $iconoBotonEstado ?>"></i></button>
                                        </div>
                                    </td>
                                    <td><?= !empty($value['cuenta']) ? $value['cuenta'] : '-' ?></td>
                                    <td><?= !empty($value['proyecto']) ? $value['proyecto'] : "-" ?></td>
                                    <td><?= !empty($value['nombreArchivo']) ? $value['nombreArchivo'] : '-' ?></td>
                                    <td><?= !empty($value['urlArchivo']) ? $value['urlArchivo'] : '-' ?></td>
                                    <td data-order="<?= $mensajeEstado ?>" class="style-icons">
                                        <span class="badge <?= $badge ?>"><?= $mensajeEstado ?></span>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>