<div class="row">
    <div class="col-md-12">
        <div class="overflow-auto" style="height: 22rem;">
            <table id="tablaDetalladoModuloSos" class="mb-0 table-bordered table-sm no-footer" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">FECHA</th>
                        <th class="text-center">CATEGORÍA</th>
                        <th class="text-center">MARCA</th>
                        <th class="text-center">CM</th>
                        <th class="text-center">FRENTES</th>
                        <th class="text-center">COMPETENCIA</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $contador = 0;
                    foreach ($detallados as $key => $row) {
                        $contador++; ?>
                        <tr>
                            <td><?= $contador ?></td>
                            <td><?= !empty($row["fecha"]) ? date_change_format($row["fecha"]) : '-' ?></td>
                            <td><?= !empty($row["categoria"]) ? $row["categoria"] : '-' ?></td>
                            <td><?= !empty($row["marca"]) ? $row["marca"] : '-' ?></td>
                            <td class="text-center"><?= !empty($row["cmDet"]) ? $row["cmDet"] : '-' ?></td>
                            <td class="text-center"><?= !empty($row["frentesDet"]) ? $row["frentesDet"] : '-' ?></td>
                            <td class="text-center"><?= !empty($row["flagCompetenciaDet"]) ? '<div class="badge badge-danger">Competencia</div>' : '<div class="badge badge-primary">No Competencia</div>' ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>