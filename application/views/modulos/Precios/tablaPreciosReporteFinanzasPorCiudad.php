<div class="card-datatable">
    <table id="tablaReporteFinanzas" class="mb-0 table table-bordered text-nowrap" style="width:100%;">
        <thead>
            <tr>
                <th class="text-center noVis">#</th>
                <th class="text-center hideCol">DEPARTAMENTO</th>
                <th class="text-center hideCol">PROVINCIA</th>
                <th class="text-center hideCol">DISTRITO</th>
                <th class="text-center">GRUPO CANAL</th>
                <th class="text-center">CANAL</th>
                <th class="text-center hideCol">SUB CANAL</th>
                <th class="text-center">NUMERO CLIENTES</th>
                <th class="text-center">NUMERO VISITAS</th>
                <th class="text-center">CATEGORIA</th>
                <th class="text-center">MARCA</th>
                <th class="text-center">EAN</th>
                <th class="text-center">SKU</th>
                <th class="text-center">PRECIO PROM</th>
                <th class="text-center">PRECIO MODA 1</th>
                <th class="text-center">PRECIO MODA 2</th>
                <th class="text-center">PRECIO MODA 3</th>
            </tr>
        </thead>
        <tbody>
            <? $contador = 0;
            foreach ($visitasPrecios as $keyVisita => $visitaPrecio) {
                if (isset($visitaPrecio["productos"])) {
                    foreach ($visitaPrecio["productos"] as $keyProducto => $producto) {
                        $contador++; ?>
                        <tr>
                            <td class="text-center"><?= $contador ?></td>
                            <td class="text-left"><?= verificarEmpty($visitaPrecio["departamento"], 3) ?></td>
                            <td class="text-left"><?= verificarEmpty($visitaPrecio["provincia"], 3) ?></td>
                            <td class="text-left"><?= verificarEmpty($visitaPrecio["distrito"], 3) ?></td>
                            <td class="text-left"><?= verificarEmpty($producto["grupoCanal"], 3) ?></td>
                            <td class="text-left"><?= verificarEmpty($producto["canal"], 3) ?></td>
                            <td class="text-left"><?= verificarEmpty($producto["subCanal"], 3) ?></td>
                            <td class="text-right"><?= verificarEmpty($producto["totalClientes"], 3) ?></td>
                            <td class="text-right"><?= verificarEmpty($producto["totalVisitas"], 3) ?></td>
                            <td class="text-left"><?= verificarEmpty($producto["categoria"], 3) ?></td>
                            <td class="text-left"><?= verificarEmpty($producto["marca"]) ?></td>
                            <td class="text-center"><?= verificarEmpty($producto["ean"], 3) ?></td>
                            <td class="text-left"><?= verificarEmpty($producto["sku"], 3) ?></td>
                            <td class="text-right"><?= !empty($producto["precioPromedio"][0]) ? moneda($producto["precioPromedio"][0]) : '-' ?></td>
                            <td class="text-right"><?= !empty($producto["modas"][0]) ? moneda($producto["modas"][0]) : '-' ?></td>
                            <td class="text-right"><?= !empty($producto["modas"][1]) ? moneda($producto["modas"][1]) : '-' ?></td>
                            <td class="text-right"><?= !empty($producto["modas"][2]) ? moneda($producto["modas"][2]) : '-' ?></td>
                        </tr>
            <?
                    }
                }
            } ?>
        </tbody>
    </table>
</div>