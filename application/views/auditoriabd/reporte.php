<table id="tb-auditoria-reporte" class="nowrap table tb-report" width="100%">
    <thead class="thead-default">
        <tr>
            <th>#</th>
            <th>Usuario</th>
            <th>URI</th>
            <th>Controlador</th>
            <th>Metodo</th>
            <th>Accion</th>
            <th>Tabla</th>
            <th class="text-center">ID tabla</th>
            <th>Sesión</th>
            <th>Direccion IP</th>
            <th>Navegador</th>
            <th>Version de Navegador</th>
            <th class="text-center">Fecha</th>
            <th class="text-center">Hora</th>
        </tr>
    </thead>
    <tbody>
        <? $i = 1; ?>
        <? foreach($listaResultado as $row){ ?>
        <tr data-idTracking="<?= $row['idTracking']; ?>">
            <td><?= $i; ?></td>
            <td><?= $row['nombreUsuario']; ?></td>
            <td><?= $row['uri']; ?></td>
            <td><?= $row['controlador']; ?></td>
            <td><?= $row['metodo']; ?></td>
            <td><?= $row['accion']; ?></td>
            <td <?= !empty($row['tabla']) ? '' : 'class="text-center"'; ?> ><?= !empty($row['tabla']) ? $row['tabla'] : '-'; ?></td>
            <td <?= !empty($row['id']) ? '' : 'class="text-center"'; ?> ><?= !empty($row['id']) ? $row['id'] : '-'; ?></td>
            <td <?= !empty($row['sessionId']) ? '' : 'class="text-center"'; ?> ><?= !empty($row['sessionId']) ? $row['sessionId'] : '-'; ?></td>
            <td><?= $row['ipAddress']; ?></td>
            <td><?= $row['browser']; ?></td>
            <td><?= $row['browserVer']; ?></td>
            <td><?= $row['fecha']; ?></td>
            <td><?= $row['hora']; ?></td>
        </tr>
        <?$i++;}?>
    </tbody>
</table>
<script>
    $('#tb-auditoria-reporte').dataTable({
        "buttons": [{
                "extend": "excel",
                "title": "Maestros - Activos",
                "exportOptions": {
                    "columns": ":not(.excel-borrar)"
                },
            },
            {
                "extend": "pageLength"
            },
        ],
    });
</script>