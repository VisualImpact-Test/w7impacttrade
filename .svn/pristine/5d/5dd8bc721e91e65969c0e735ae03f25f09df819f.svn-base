<?php
$cantidadVisitasInventario = (!empty($visitasInventario['visitas'])) ? count($visitasInventario['visitas']) : 0;
$cantidadProductos = (!empty($visitasInventario['productos'])) ? count($visitasInventario['productos']) : 0;
$columnasPorVisita = 7;
?>

<div class="col-md-12">
    <div class="mb-3 card">
        <div class="card-header"><i class="fa fa-table" aria-hidden="true"></i> &nbsp;&nbsp;Módulo Inventario &nbsp;<span class="badge badge-secondary">Visitas <?= $cantidadVisitasInventario ?> | Productos <?= $cantidadProductos ?></span></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?php if ($cantidadVisitasInventario == 0) { ?>
                        No se han generado registros
                    <?php } else { ?>
                        <div class="overflow-auto" style="height: 25rem;">
                            <table id="tablaVisitasInventario" class="mb-0 table-bordered table-sm no-footer" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center" colspan="4">PRODUCTOS</th>
                                        <th class="text-center" colspan="<?= $cantidadVisitasInventario * $columnasPorVisita ?>">VISITAS</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center align-middle" rowspan="2">#</th>
                                        <th class="text-center align-middle" rowspan="2">PRODUCTO</th>
                                        <th class="text-center align-middle" rowspan="2">MARCA</th>
                                        <th class="text-center align-middle" rowspan="2">CATEGORÍA</th>
                                        <?php foreach ($visitasInventario['visitas'] as $key => $value) { ?>
                                            <th class="text-center" colspan="<?= $columnasPorVisita ?>">
                                                COD. VISITA: <?= $value['idVisita'] ?><br>
                                                <?= $value['tipoUsuario'] . ': ' . $value['nombreUsuario'] ?><br>
                                                <?= date_change_format($value['fecha']) ?> <?= time_change_format($value['hora']) ?>
                                            </th>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php for ($i = 0; $i < $cantidadVisitasInventario; $i++) { ?>
                                            <th class="text-center align-middle">STOCK INICIAL</th>
                                            <th class="text-center align-middle">SELLIN</th>
                                            <th class="text-center align-middle">STOCK</th>
                                            <th class="text-center align-middle">VALIDACIÓN</th>
                                            <th class="text-center align-middle">OBSERVACIÓN</th>
                                            <th class="text-center align-middle">COMENTARIO</th>
                                            <th class="text-center align-middle">FECHA VENCIMIENTO</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $contador = 0;
                                    foreach ($visitasInventario['productos'] as $key => $producto) {
                                        $contador++; ?>
                                        <tr>
                                            <td><?= $contador ?></td>
                                            <td><?= $producto['producto'] ?></td>
                                            <td><?= $producto['marca'] ?></td>
                                            <td><?= $producto['categoria'] ?></td>

                                            <?php foreach ($visitasInventario['visitas'] as $key => $visita) {
                                                $hayInfo = (!empty($producto['infoVisitas'][$visita['idVisita']])) ? true : false;
                                            ?>
                                                <?php if (!$hayInfo) { ?>
                                                    <?php for ($i = 0; $i < $columnasPorVisita; $i++) { ?>
                                                        <td class="text-center celdaNula">-</td>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <td class="text-center align-middle"><?= !empty($producto['infoVisitas'][$visita['idVisita']]['stock_inicial']) ? $producto['infoVisitas'][$visita['idVisita']]['stock_inicial'] : '-' ?></td>
                                                    <td class="text-center align-middle"><?= !empty($producto['infoVisitas'][$visita['idVisita']]['sellin']) ? $producto['infoVisitas'][$visita['idVisita']]['sellin'] : '-' ?></td>
                                                    <td class="text-center align-middle"><?= !empty($producto['infoVisitas'][$visita['idVisita']]['stock']) ? $producto['infoVisitas'][$visita['idVisita']]['stock'] : '-' ?></td>
                                                    <td class="text-center align-middle"><?= !empty($producto['infoVisitas'][$visita['idVisita']]['validacion']) ? $producto['infoVisitas'][$visita['idVisita']]['validacion'] : '-' ?></td>
                                                    <td class="align-middle"><?= !empty($producto['infoVisitas'][$visita['idVisita']]['obs']) ? $producto['infoVisitas'][$visita['idVisita']]['obs'] : '-' ?></td>
                                                    <td class="align-middle"><?= !empty($producto['infoVisitas'][$visita['idVisita']]['comentario']) ? $producto['infoVisitas'][$visita['idVisita']]['comentario'] : '-' ?></td>
                                                    <td class="text-center"><?= !empty($producto['infoVisitas'][$visita['idVisita']]['fecVenc']) ? date_change_format($producto['infoVisitas'][$visita['idVisita']]['fecVenc']) : '-' ?></td>
                                                <?php } ?>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>