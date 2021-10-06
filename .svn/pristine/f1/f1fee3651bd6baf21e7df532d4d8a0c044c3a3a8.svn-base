                <div class="card-datatable">
                    <table class="mb-0 table-bordered table-sm no-footer w-100 text-nowrap">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-center">#</th>
                                <th class="text-center">OPCIONES</th>
                                <th class="text-center">COD CLIENTE</th>
                                <th class="text-center">RAZON SOCIAL</th>
                                <th class="text-center">NOMBRE COMERCIAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $value) {
                                $badge = $value['estado'] == 1 ? 'badge-success' : 'badge-danger';
                                $mensajeEstado = $value['estado'] == 1 ? 'Activo' : 'Inactivo';
                                $iconoBotonEstado = $value['estado'] == 1 ? 'fa fa-toggle-on fa-lg' : 'fa fa-toggle-off fa-lg';
                            ?>
                                <tr data-id="<?= $value["idCliente"] ?>" data-estado="<?= $value['estado'] ?>">
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div>
                                            <button class="btn btn-Editar btn-outline-secondary border-0" title="Editar"><i class="fas fa-edit fa-lg"></i></button>
                                        </div>
                                    </td>
                                    <td><?= !empty($value['codCliente']) ? $value['codCliente'] : '-' ?></td>
                                    <td><?= !empty($value['razonSocial']) ? $value['razonSocial'] : "-" ?></td>
                                    <td><?= !empty($value['nombreComercial']) ? $value['nombreComercial'] : "-" ?></td>
 
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>