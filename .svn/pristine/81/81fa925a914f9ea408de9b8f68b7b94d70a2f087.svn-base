<table id="tb-auditoria-reporte" class="nowrap table tb-report" width="100%">
    <thead class="thead-default">
        <tr>
            <th>#</th>
            <th>Usuario</th>
            <th>N° Intento</th>
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
        <tr data-idAttempt="<?= $row['idAttempt']; ?>">
            <td><?= $i; ?></td>
            <td><?= $row['nombreUsuario']; ?></td>
            <td><?= $row['nro_intento']; ?></td>
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
                "title": "Intentos fallidos",
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