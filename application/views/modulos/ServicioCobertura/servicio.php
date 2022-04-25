<style>
    table.dataTable {
        border-collapse: collapse !important;
    }
 
</style>

<div class="card-datatable">
    <table id="tb-servicio" class="table table-striped table-bordered nowrap" width="100%">
        <thead>
            <tr>
                <th class="text-center align-middle cabeceraPrincipal noVis">#</th>
                <th class="text-center align-middle cabeceraPrincipal">CANAL</th>
                <th class="text-center align-middle cabeceraPrincipal">GERENTE</th>
                <th class="text-center align-middle cabeceraPrincipal">SPOC</th>
                <th class="text-center align-middle cabeceraPrincipal">SUCURSAL</th>
                <th class="text-center align-middle cabeceraPrincipal">ID GTM</th>
                <th class="text-center align-middle cabeceraPrincipal">DNI</th>
                <th class="text-center align-middle cabeceraPrincipal">PERFIL GTM</th>
                <th class="text-center align-middle cabeceraPrincipal">RUTA</th>
                <th class="text-center align-middle cabeceraPrincipal">DIAS</th>
                <th class="text-center align-middle cabeceraPrincipal">OBJ Q</th>
                <th class="text-center align-middle cabeceraPrincipal">OBJ DIARIO</th>
                <th class="text-center align-middle cabeceraPrincipal">EFECTIVIDAD %</th>
                <th class="text-center align-middle cabeceraPrincipal">HORA SERVICIO</th>
                <th class="text-center align-middle cabeceraPrincipal">V. HORA Y MEDIA</th>
                <th class="text-center align-middle cabeceraPrincipal">EFECTIVIDAD HORAS</th>
                <th class="text-center align-middle cabeceraPrincipal">ALERTA MARCACION</th>
                <th class="text-center align-middle cabeceraPrincipal">ACUMULADO MARCACION</th>
                <th class="text-center align-middle cabeceraPrincipal">ALERTA GEO</th>
                <th class="text-center align-middle cabeceraPrincipal">ACUMULADO GEO</th>

                <?
                foreach ($quincena as $key => $value) {
                ?>
                    <th class="text-center align-middle cabeceraSecundaria"><?= $value['dia'] . ' ' . $value['nombreDia'] ?></th>
                <?
                }
                ?>

            </tr>
        </thead>
        <tbody>
            <?
            $i = 0;
            foreach ($data as $key => $value) {
                $i++;
            ?>
                <tr data-ruta="<?=$value["RUTA"]?>" data-fechatope="<?= $value["fechaMax"]?>" >
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?= verificarEmpty($value['CANAL'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['GERENTE'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['SPOC'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['SUCURSAL'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['IDGTM'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['DNI'], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($value['GTM_NAME'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['RUTA'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['DIAS'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['OBJ_Q'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['OBJ_DIARIO'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['EFECTIVIDAD'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['HORA_SERVICIO'], 3) ?></td>
                    <? $visitasMayores = verificarEmpty($value['VISITAS_MAYORES'], 2) ?>
                    <td class="text-center <?= $visitasMayores > 30 ? 'celdaConError' : 'celdaCorrecta' ?>"><?= $visitasMayores ?></td>
                    <td class="text-center"><?= verificarEmpty($value['EFECTIVIDAD_HORAS'], 3) ?></td>
                    <td class="text-center">
                        <span data-tipo="alerta_marcacion" data-hoy="1" class="<?= !empty($value['ALERTA_MARCACION']) ? "view_alerta text-primary btn text-underline" : ""  ?>">
                            <?= verificarEmpty($value['ALERTA_MARCACION'], 3) ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <span data-tipo="alerta_marcacion" data-hoy="0" class="<?= !empty($value['ACUMULADO_MARCACION']) ? "view_alerta text-primary btn text-underline" : ""  ?>">
                            <?= verificarEmpty($value['ACUMULADO_MARCACION'], 3) ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <span data-tipo="alerta_geo" data-hoy="1" class="<?= !empty($value['ALERTA_GEO']) ? "view_alerta text-primary btn text-underline" : ""  ?>">
                            <?= verificarEmpty($value['ALERTA_GEO'], 3) ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <span data-tipo="alerta_geo" data-hoy="0" class="<?= !empty($value['ACUMULADO_GEO']) ? "view_alerta text-primary btn text-underline" : ""  ?>">
                            <?= verificarEmpty($value['ACUMULADO_GEO'], 3) ?>
                        </span>
                    </td>
                    <?
                    foreach ($quincena as $skey => $svalue) {
                        if (!empty($value['fecha'][$svalue['fecha']])) {
                            $valorPorFecha = verificarEmpty($value['fecha'][$svalue['fecha']], 3);
                    ?>
                            <td class="text-center <?= $valorPorFecha != '-' && $valorPorFecha < 8 ? 'celdaConError' : ''; ?>"><?= $valorPorFecha ?></td>
                        <?
                        } else {
                        ?>
                            <td class="text-center celdaVacia">-</td>
                    <?
                        }
                    }
                    ?>
                </tr>
            <?
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {

        var opcion = $('.btnReporte.active').data('value');
        if (opcion == 1) {
            var c = 0;

            $('.filtroCondicion').each(function(ev) {
                var btn = $(this).val();
                var ckb = $(this).prop('checked');

                if (ckb == false) {
                    $('.' + btn).each(function(ev) {
                        $(this).parent('tr').hide();
                    });
                } else {
                    $('.' + btn).each(function(ev) {
                        $(this).parent('tr').show();
                        c++;
                    });
                }
            });

            var page = Math.floor((Math.random() * 10) + 1);
            $('#tb-servicio').DataTable().page.len(page).draw();
            $('#tb-servicio').DataTable().page.len(20).draw();
        }
    });
</script>