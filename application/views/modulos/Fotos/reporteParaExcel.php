<table id="tablaFotosExcel" class="table table-striped table-bordered nowrap" width="100%">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">COD VISUAL</th>
            <th class="text-center">COD <?= $this->sessNomCuentaCorto ?></th>
            <th class="text-center">DIRECCIÓN</th>
            <th class="text-center">UBICACION</th>
            <th class="text-center">CANAL</th>
            <th class="text-center">TIPO CLIENTE</th>

            <th class="text-center">FECHA</th>
            <th class="text-center">PERFIL USUARIO</th>
            <th class="text-center">NOMBRE USUARIO</th>
            <th class="text-center">FOTO</th>
            <th class="text-center">HORA FOTO</th>
            <th class="text-center">TIPO FOTO</th>
        </tr>
    </thead>
    <tbody>
        <? $contador = 0;
        foreach ($fotosClientes as $key => $fotoCliente) { ?>
            <? foreach ($fotoCliente["visitas"] as $keyVisita => $visita) {
                $cantidadFotos = count($visita["fotos"]);
            ?>
                <? foreach ($visita["fotos"] as $keyFoto => $foto) {
                ?>
                    <tr>
                        <td><?= $contador ?></td>
                        <td><?= verificarEmpty($fotoCliente['idCliente'], 3) ?></td>
                        <td><?= verificarEmpty($fotoCliente['codCliente'], 3) ?></td>
                        <td><?= verificarEmpty($fotoCliente['direccion'], 3) ?></td>
                        <td><?= verificarEmpty($fotoCliente["departamento"] . " - " . $fotoCliente["provincia"] . " - " . $fotoCliente["distrito"], 3) ?></td>
                        <td><?= verificarEmpty($fotoCliente['canal'], 3) ?></td>
                        <td><?= verificarEmpty($fotoCliente['cliente_tipo'], 3) ?></td>

                        <td><?= verificarEmpty($visita['fecha'], 3) ?></td>
                        <td><?= verificarEmpty($visita['tipoUsuario'], 3) ?></td>
                        <td><?= verificarEmpty($visita['usuario'], 3) ?></td>
                        <td><?= verificarUrlFotos($foto["imgRef"]) ?>moduloFotos/<?= $foto["imgRef"] ?></td>
                        <td><?= verificarEmpty($foto['horaFoto'], 3) ?></td>
                        <td><?= verificarEmpty($foto['tipoFoto'], 3) ?></td>
                    </tr>
                <? } ?>
            <? } ?>
        <? } ?>
    </tbody>
</table>