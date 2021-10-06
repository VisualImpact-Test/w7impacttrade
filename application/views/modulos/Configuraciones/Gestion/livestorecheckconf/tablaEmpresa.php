                <div class="card-datatable">
                    <table class="mb-0 table table-bordered text-nowrap w-100 ">
                        <thead class=""> 
                            <tr>
                                <th class="noVis px-4"></th>
                                <th class="text-center noVis">#</th>
                                <th class="text-center">OPCIONES</th>
                                <th class="text-center">NOMBRE</th>
                                <th class="text-center">ESTADO</th>
                                <th class="text-center">DATOS REGISTRO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $value) {
                                $badge = $value['estado'] == 1 ? 'badge-success' : 'badge-danger';
                                $mensajeEstado = $value['estado'] == 1 ? 'Activo' : 'Inactivo';
                                $iconoBotonEstado = $value['estado'] == 1 ? 'fa fa-toggle-on fa-lg' : 'fa fa-toggle-off fa-lg';
                            ?>
                                <tr data-fechaModificacion="<?= !empty($value['fechaModificacion']) ? date_change_format($value['fechaModificacion']) : '-'?>" data-id="<?= $value[$this->model->tablas['empresa']['id']] ?>" data-estado="<?= $value['estado'] ?>" data-usuario ="<?= !empty($value['usuario']) ? $value['usuario'] : '-' ?>" data-fechaReg =" <?=  date_change_format($value['fechaReg'] )?>"  data-horaReg =" <?=  $value['horaReg'] ?>">
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div>
                                            <button class="btn btn-Editar btn-outline-secondary border-0" title="Editar"><i class="fas fa-edit fa-lg"></i></button>
                                            <button class="btn btn-CambiarEstado btn-outline-secondary border-0" title="Activar/Desactivar"><i class="<?= $iconoBotonEstado ?>"></i></button>
                                        </div>
                                    </td>
                                    <td><?= !empty($value['nombre']) ? $value['nombre'] : '-' ?></td>
                                    <td data-order="<?= $mensajeEstado ?>" class="style-icons">
                                        <span class="badge <?= $badge ?>"><?= $mensajeEstado ?></span>
                                    </td>
                                    <td class="details-control" ></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>