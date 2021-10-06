<div class="card-datatable">
    <table id="tablaVisitasPrecios" class="mb-0 table table-bordered text-nowrap" style="width:100%;">
        <thead>
            <tr>
                <th class="text-center noVis">#</th>
                <th class="text-center">GRUPO CANAL</th>
                <th class="text-center">CANAL</th>
                <th class="text-center hideCol">SUB CANAL</th>

                <? foreach ($segmentacion['headers'] as $k => $v) { ?>
                    <th class="text-center"><?= strtoupper($v['header']) ?></th>
                <? } ?>

                <th class="text-center">COD VISUAL</th>
				<th class="text-center hideCol">COD <?= $this->sessNomCuentaCorto ?></th>
				<th class="text-center hideCol">COD PDV</th>
				<th class="text-center">PDV</th>
				<th class="text-center">TIPO CLIENTE</th>

                <th class="text-center">COD USUARIO</th>
                <th class="text-center">PERFIL USUARIO</th>
                <th class="text-center">NOMBRE<br />USUARIO</th>

                <th class="text-center hideCol">DEPARTAMENTO</th>
                <th class="text-center hideCol">PROVINCIA</th>
                <th class="text-center hideCol">DISTRITO</th>

                <th class="text-center">CATEGORÍA</th>
                <th class="text-center">MARCA</th>
                <th class="text-center">COD PRODUCTO</th>
                <th class="text-center">PRODUCTO</th>
                <th class="text-center">PRECIO</th>
            </tr>
        </thead>
        <tbody>
            <?
            $contador = 0;
            foreach ($visitasPrecios as $key => $visitaPrecio) {
                $contador++;
            ?>
                <tr>
                    <td class="text-center"><?= $contador ?></td>
                    <td class="text-left"><?= verificarEmpty($visitaPrecio["grupoCanal"], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($visitaPrecio["canal"], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($visitaPrecio["subCanal"], 3) ?></td>

                    <? foreach ($segmentacion['headers'] as $k => $v) { ?>
                        <td class="text-<?= (!empty($visitaPrecio[($v['columna'])]) ? $v['align'] : '-') ?>"><?= (!empty($visitaPrecio[($v['columna'])]) ? $visitaPrecio[($v['columna'])] : '-') ?></td>
                    <? } ?>

                    <td class="text-center"><?= verificarEmpty($visitaPrecio['idCliente'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($visitaPrecio['codCliente'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($visitaPrecio['codDist'], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($visitaPrecio['razonSocial'], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($visitaPrecio['tipoCliente'], 3) ?></td>

                    <td class="text-center"><?= verificarEmpty($visitaPrecio["idUsuario"], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($visitaPrecio["tipoUsuario"], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($visitaPrecio["nombreUsuario"], 3) ?></td>

                    <td class="text-left"><?= verificarEmpty($visitaPrecio["departamento"], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($visitaPrecio["provincia"], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($visitaPrecio["distrito"], 3) ?></td>

                    <td class="text-left"><?= verificarEmpty($visitaPrecio["categoria"], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($visitaPrecio["marca"], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($visitaPrecio["idProducto"], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($visitaPrecio["producto"], 3) ?></td>
                    <td class="text-right"><?= verificarEmpty($visitaPrecio["precio"], 3) ?></td>
                </tr>
            <? } ?>
        </tbody>
    </table>
</div>