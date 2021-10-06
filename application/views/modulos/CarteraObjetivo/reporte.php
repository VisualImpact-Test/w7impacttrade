<style>

</style>
<div class="card-datatable">
    <table id="tb-carteraobjetivo" class="mb-0 table table-bordered text-nowrap" width="100%">
        <thead>
            <tr>
                <th class="td-center">#</th>
                <th class="td-center">OPCIONES</th>
                <th>CUENTA</th>
                <th>PROYECTO</th>
                <th>GRUPO CANAL</th>
                <th>CANAL</th>
                <th>SUB CANAL</th>
                <th>DISTRIBUIDORA SUCURSAL</th>
                <th>PLAZA</th>
                <th>FECHA INICIO</th>
                <th>FECHA FINAL</th>
                <th>CARTERA</th>
                <th class="td-center">ESTADO</th>
            </tr>
        </thead>
        <tbody>
            <? $ix = 1; ?>
            <?
            foreach ($datos as $row) {
                $mensajeEstado = $row['estado'] == 1 ? 'Activo' : 'Inactivo';
                $badge = $row['estado'] == 1 ? 'badge-success' : 'badge-danger';
                $toggle = $row['estado'] == 1 ? 'fa-toggle-on' : 'fa-toggle-off';
            ?>
                <tr data-id="<?=$row['idObjetivo']?>">
                    <td class="td-center"><?= $ix; ?></td>
                    <td class="td-center style-icons">
                        <a href="javascript:;" class="btn btn-outline-secondary border-0 btn-editar"><i class="fa fa-lg fa-edit"></i></a>
                        <a id="hrefEstado-<?= $row['idObjetivo']; ?>" href="javascript:;" class="btn btn-outline-secondary border-0 btn-actualizar-estado" data-id="<?= $row['idObjetivo']; ?>" data-estado="<?= $row['estado']; ?>">
                            <i class="fal fa-lg <?= $toggle ?>"></i>
                        </a>
                    </td>
                    <td class="td-left"><?= verificarEmpty($row['cuenta'], 3); ?></td>
                    <td class="td-left"><?= verificarEmpty($row['proyecto'], 3); ?></td>
                    <td class="td-left"><?= verificarEmpty($row['grupoCanal'], 3); ?></td>
                    <td class="td-left"><?= verificarEmpty($row['canal'], 3); ?></td>
                    <td class="td-left"><?= verificarEmpty($row['subCanal'], 3); ?></td>
                    <td class="td-left"><?= verificarEmpty($row['distribuidoraSucursal'], 3); ?></td>
                    <td class="td-left"><?= verificarEmpty($row['plaza'], 3); ?></td>
                    <td class="td-center"><?= verificarEmpty($row['fecIni'], 3); ?></td>
                    <td class="td-center"><?= verificarEmpty($row['fecFin'], 3); ?></td>
                    <td class="td-center"><?= verificarEmpty($row['cartera'], 3); ?></td>
                    <td class="text-center style-icons">
                        <span class="badge <?= $badge ?>" id="spanEstado-<?= $row['idObjetivo']; ?>"><?= $mensajeEstado; ?></span>
                    </td>
                </tr>
            <? $ix++;
            } ?>
        </tbody>
    </table>
</div>