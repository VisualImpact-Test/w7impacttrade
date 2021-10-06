<?php
$cantidadVisitasPrecios = 0;
if (!empty($visitasPrecios['visitas'])) $cantidadVisitasPrecios = count($visitasPrecios['visitas']);
$cantidadProductos = 0;
if (!empty($visitasPrecios['productos'])) $cantidadProductos = count($visitasPrecios['productos']);
?>

<div class="col-md-12">
    <div class="mb-3 card">
        <div class="card-header"><i class="fa fa-table" aria-hidden="true"></i> &nbsp;&nbsp;Módulo Precios&nbsp;<span class="badge badge-secondary"> <?= $cantidadVisitasPrecios ?> Visitas | <?= $cantidadProductos ?> Productos </span></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?php if (empty($visitasPrecios['visitas'])) { ?>
                        No se han generado registros
                    <?php } else { ?>
                        <div class="overflow-auto" style="height: 25rem;">
                            <table id="tablaModuloPrecios" class="mb-0 table-bordered table-sm no-footer" style="width:100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="text-center align-middle">#</th>
                                        <th rowspan="2" class="text-center align-middle">CATEGORÍA</th>
                                        <th rowspan="2" class="text-center align-middle">MARCA</th>
                                        <th rowspan="2" class="text-center align-middle">PRODUCTO</th>
                                        <th rowspan="1" colspan="<?= count($visitasPrecios['visitas']) ?>" class="text-center">VISITAS</th>
                                    </tr>
                                    <tr>
                                        <?php foreach ($visitasPrecios['visitas'] as $key => $visita) { ?>
                                            <th class="text-center">
                                                COD. VISITA: <?= $visita['idVisita'] ?><br>
                                                <?= $visita['tipoUsuario'] . ': ' . $visita['nombreUsuario'] ?></br>
                                                (<?= date_change_format($visita['fecha']) ?> <?= date_change_format($visita['hora']) ?>)
                                            </th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $contador = 0;
                                    foreach ($visitasPrecios['productos'] as $key => $producto) {
                                        $contador++; ?>
                                        <tr>
                                            <td class="align-middle"><?= $contador ?></td>
                                            <td class="align-middle"><?= $producto['categoria'] ?></td>
                                            <td class="align-middle"><?= $producto['marca'] ?></td>
                                            <td class="align-middle"><?= $producto['producto'] ?></td>
                                            <?php $precioAnterior = null; ?>
                                            <?php foreach ($visitasPrecios['visitas'] as $key => $visita) {
                                                $precioActual = !empty($producto['precios'][$visita['idVisita']]['precio']) ? $producto['precios'][$visita['idVisita']]['precio'] : 0;
                                                $comparacionInvalida = (empty($precioAnterior) || empty($precioActual)) ? true : false;
                                                $precioAumento = floatval($precioAnterior) < floatval($precioActual);
                                                if ($precioAumento) {
                                                    $diferencia = floatval($precioActual) - floatval($precioAnterior);
                                                } else {
                                                    $diferencia = floatval($precioAnterior) - floatval($precioActual);
                                                }
                                            ?>
                                                <td class="text-center align-middle">
                                                    <?= !empty($producto['precios'][$visita['idVisita']]['precio']) ? moneda($producto['precios'][$visita['idVisita']]['precio']) : '-' ?>
                                                    <?php if (!$comparacionInvalida) { ?>
                                                        <span class="badge <?= ($precioAumento) ? 'badge-success' : 'badge-danger' ?>"><?= ($precioAumento) ? '+' : '-' ?> <?= moneda($diferencia) ?></span>
                                                    <?php } ?>
                                                </td>
                                                <?php $precioAnterior = $precioActual ?>
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