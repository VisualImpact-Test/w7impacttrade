                <div class="card-datatable">
                    <table class="table table-striped table-bordered nowrap w-100 text-nowrap">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-center">#</th>
                                <th class="text-center">OPCIONES</th>
                                <th class="text-center">ID PRODUCTO</th>
                                <th class="text-center">PRODUCTO</th>
                                <th class="text-center">UNIDAD MEDIDA</th>
                                <th class="text-center">PRECIO</th>
                                <th class="text-center">FECHA REGISTRO</th>
                                <th class="text-center">FECHA MODIFICACIÓN</th>
                                <th class="text-center">ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $value) {
                                $badge = $value['estado'] == 1 ? 'badge-success' : 'badge-danger';
                                $mensajeEstado = $value['estado'] == 1 ? 'Activo' : 'Inactivo';
                                $iconoBotonEstado = $value['estado'] == 1 ? 'fa fa-toggle-on fa-lg' : 'fa fa-toggle-off fa-lg';
                            ?>
                                <tr data-id="<?= $value[$this->model->tablas['unidadMedidaProducto']['id']] ?>" data-estado="<?= $value['estado'] ?>">
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div>
                                            <button class="btn btn-Editar btn-outline-secondary border-0" title="Editar"><i class="fas fa-edit fa-lg"></i></button>
                                            <button class="btn btn-CambiarEstado btn-outline-secondary border-0" title="Activar/Desactivar"><i class="<?= $iconoBotonEstado ?>"></i></button>
                                        </div>
                                    </td>
                                    <td><?= !empty($value['idProducto']) ? $value['idProducto'] : '-' ?></td>
                                    <td><?= !empty($value['producto']) ? $value['producto'] : '-' ?></td>
                                    <td><?= !empty($value['unidadMedida']) ? $value['unidadMedida'] : '-' ?></td>
                                    <td><?= !empty($value['precio']) ? $value['precio'] : '-' ?></td>
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