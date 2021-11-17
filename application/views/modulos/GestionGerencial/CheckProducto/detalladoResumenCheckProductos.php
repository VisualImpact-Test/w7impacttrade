<div class="card-datatable" style="overflow-x: auto;max-height: 500px;">

    <table id="tb-resumen-checkProductos" class="mb-0 table table-bordered text-nowrap" width="100%">
        <thead>
            <tr>
                <th colspan="3" style="text-align:center;">DETALLE DEL <?= $fecIni ?> AL <?= $fecFin ?></th>
                <th style="text-align:center;background-color: lightgray;">PRESENCIA</th>
                <th style="text-align:center;background-color: lightgray;"> % PRESENCIA</th>
                <th style="text-align:center;background-color: lightgray;"> QUIEBRES</th>
                <th style="text-align:center;background-color: lightgray;"> PRECIOS</th>
                <? foreach ($banners as $idBanner => $banner) : ?>
                    <th style="text-align:center;background-color: lightgreen;"><?= $banner['nombre'] ?></th>
                <? endforeach; ?>
            </tr>
            <?
            $i = 0;
            $idCategoria = '';
            $idMarca = '';
            foreach ($productos as $k => $v) : ?>
                <? if ($idCategoria != $v['idCategoria']) { ?>
                    <!-- Categorias -->
                    <tr>
                        <th style="text-align:center;" rowspan="<?= ($rowspan['categorias'][$v['idCategoria']]) ?>"><?= $v['categoria'] ?></th>
                        <th style="text-align:center;" rowspan="<?= ($rowspan['marcas'][$v['idCategoria']][$v['idMarca']]) ?>"><?= $v['marca'] ?></th>
                        <th style="text-align:left;"><?= $v['producto'] ?></th>
                        <!-- Columnas -->
                        <th style="text-align:center;"><?= $v['totalPresencia'] ?></th>
                        <th style="text-align:right;"><?= get_porcentaje($tiendasVisitadas['tiendasVisitadas'], $v['totalPresencia']) ?>%</th>
                        <th style="text-align:center;"><?= $v['totalQuiebres'] ?></th>
                        <th style="text-align:center;"><?= $v['totalPrecio'] ?></th>
                        <? foreach ($banners as $idBanner => $banner) : ?>
                            <td style="text-align:center;background-color: lightgreen;"><?= !empty($v[$tipoReporte][$idBanner]) ? $v[$tipoReporte][$idBanner] : '-' ?></td>
                        <? endforeach; ?>
                    </tr>
                    <? $idMarca = $v['idMarca'] ?>
                <? } ?>

                <? if ($idMarca != $v['idMarca']) { ?>
                    <!-- Marcas -->
                    <tr>
                        <th style="text-align:center;" rowspan="<?= ($rowspan['marcas'][$v['idCategoria']][$v['idMarca']]) ?>"><?= $v['marca'] ?></th>
                        <th style="text-align:left;"><?= $v['producto'] ?></th>
                        <!-- Columnas -->
                        <th style="text-align:center;"><?= $v['totalPresencia'] ?></th>
                        <th style="text-align:right;"><?= get_porcentaje($tiendasVisitadas['tiendasVisitadas'], $v['totalPresencia']) ?>%</th>
                        <th style="text-align:center;"><?= $v['totalQuiebres'] ?></th>
                        <th style="text-align:center;"><?= $v['totalPrecio'] ?></th>
                        <? foreach ($banners as $idBanner => $banner) : ?>
                            <td style="text-align:center;background-color: lightgreen;"><?= !empty($v[$tipoReporte][$idBanner]) ? $v[$tipoReporte][$idBanner] : '-' ?></td>
                        <? endforeach; ?>
                    </tr>
                <? } ?>

                <? if ($idCategoria == $v['idCategoria'] && $idMarca == $v['idMarca']) { ?>
                    <tr>
                        <th style="text-align:left;"><?= $v['producto'] ?></th>
                        <!-- Columnas -->
                        <th style="text-align:center;"><?= $v['totalPresencia'] ?></th>
                        <th style="text-align:right;"><?= get_porcentaje($tiendasVisitadas['tiendasVisitadas'], $v['totalPresencia']) ?>%</th>
                        <th style="text-align:center;"><?= $v['totalQuiebres'] ?></th>
                        <th style="text-align:center;"><?= $v['totalPrecio'] ?></th>
                        <? foreach ($banners as $idBanner => $banner) : ?>
                            <td style="text-align:center;background-color: lightgreen;"><?= !empty($v[$tipoReporte][$idBanner]) ? $v[$tipoReporte][$idBanner] : '-' ?></td>
                        <? endforeach; ?>
                    </tr>

                <? } ?>
                <? $idCategoria = $v['idCategoria'] ?>
                <? $idMarca = $v['idMarca'] ?>
            <? endforeach;   ?>

        </thead>
    </table>
</div>