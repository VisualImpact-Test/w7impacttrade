                <div class="card-datatable">
                    <table class="mb-0 table-bordered table-sm no-footer w-100 text-nowrap">
                        <thead>
                            <tr>
                                <th class="noVis not-excel"></th>
                                <th class="text-center not-excel noVis">#</th>
                                <th class="text-center not-excel">OPCIONES</th>
                                <th class="text-center">COD HORARIO</th>
                                <th class="text-center">HORA INGRESO</th>
                                <th class="text-center">HORA SALIDA</th>
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
                                <tr data-id="<?= $value[$this->model->tablas['elemento']['id']] ?>" data-estado="<?= $value['estado'] ?>">
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div>
                                            <button class="btn btn-Editar btn-outline-secondary border-0" title="Editar"><i class="fas fa-edit fa-lg"></i></button>
                                            <button class="btn btn-CambiarEstado btn-outline-secondary border-0" title="Activar/Desactivar"><i class="<?= $iconoBotonEstado ?>"></i></button>
                                        </div>
                                    </td>
                                    <td class="text-center"><?= !empty($value['idHorario']) ? $value['idHorario'] : '-' ?></td>
                                    <td class="text-center"><?= !empty($value['horaIni']) ? $value['horaIni'] : '-' ?></td>
                                    <td class="text-center"><?= !empty($value['horaFin']) ? $value['horaFin'] : '-' ?></td>
                                    <td data-order="<?= strtotime($value['fechaRegistro']) ?>"><?= !empty($value['fechaRegistro']) ? date_change_format($value['fechaRegistro'])  : '-' ?></td>
                                    <td data-order="<?= strtotime($value['fechaModificacion']) ?>"><?= !empty($value['fechaModificacion']) ? date_change_format($value['fechaModificacion']) : '-' ?></td>
                                    <td data-order="<?= $mensajeEstado ?>" class="style-icons">
                                        <span class="badge <?= $badge ?>"><?= $mensajeEstado ?></span>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>