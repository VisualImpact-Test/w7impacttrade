<table id="tablaEncuestasExcel" class="table table-striped table-bordered nowrap" width="100%">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">FECHA</th>
            <th class="text-center">GRUPO CANAL</th>
            <th class="text-center">CANAL</th>
            <th class="text-center">COD VISUAL</th>
            <th class="text-center">PDV</th>
            <th class="text-center">ENCUESTA</th>
            <th class="text-center">PREGUNTA</th>
            <th class="text-center">ALTERNATIVA</th>
            <th class="text-center">RESPUESTA</th>
        </tr>
    </thead>
    <tbody>
        <?
        $contador = 0;
        foreach ($encuestasClientes as $key => $row) {
            $contador++;
        ?>
            <tr>
                <td><?= $contador ?></td>
                <td><?= verificarEmpty($row['fecha'], 3) ?></td>
                <td><?= verificarEmpty($row['grupoCanal'], 3) ?></td>
                <td><?= verificarEmpty($row['canal'], 3) ?></td>
                <td><?= verificarEmpty($row['idCliente'], 3) ?></td>
                <td><?= verificarEmpty($row['razonSocial'], 3) ?></td>
                <td><?= verificarEmpty($row['encuesta'], 3) ?></td>
                <td><?= verificarEmpty($row['pregunta'], 3) ?></td>
                <td><?= verificarEmpty($row['alternativa'], 3) ?></td>
                <td><?= verificarEmpty($row['respuesta'], 3) ?></td>
            </tr>
        <?
        }
        ?>
    </tbody>
</table>