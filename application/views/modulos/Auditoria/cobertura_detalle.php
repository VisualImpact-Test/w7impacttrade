<div class="card-datatable centraTabla">
    <table id="tb-cobertura" class="mb-0 table table-bordered text-nowrap tb_plantilla_popup" width="100%">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">CODIGO VISUAL</th>
                <th class="text-center">CODIGO P&G</th>
                <th class="text-center">RAZON SOCIAL</th>
                <th class="text-center">DIRECCION</th>
            </tr>
        </thead>
        <tbody>
            <? $i = 0;
            foreach ($clientes as $fila) {
                $i++; ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td class="text-center"><?= verificarEmpty($fila['idCliente'], 3); ?></td>
                    <td class="text-center"><?= verificarEmpty($fila['codRD'], 3); ?></td>
                    <td><?= verificarEmpty($fila['razonSocial'], 3); ?></td>
                    <td><?= verificarEmpty($fila['direccion'], 3); ?></td>
                </tr>
            <? } ?>
        </tbody>
    </table>
</div>