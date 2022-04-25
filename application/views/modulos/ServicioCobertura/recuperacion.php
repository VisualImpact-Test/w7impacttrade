<style>
    table.dataTable {
        border-collapse: collapse !important;
    }
</style>

<div class="card-datatable">
    <table id="tb-recuperacion" class="table table-striped table-bordered nowrap" width="100%">
        <thead>
            <tr>
                <th class="text-center align-middle cabeceraPrincipal noVis">#</th>
                <th class="text-center align-middle cabeceraPrincipal">GERENTE</th>
                <th class="text-center align-middle cabeceraPrincipal">SPOC</th>
                <th class="text-center align-middle cabeceraPrincipal">SUCURSAL</th>
                <th class="text-center align-middle cabeceraSecundaria">RUTAS PENDIENTES GTM Q</th>
                <th class="text-center align-middle cabeceraSecundaria">RUTAS RECUPERADAS POR SPOC</th>
                <th class="text-center align-middle cabeceraSecundaria">RECUPERACION SPOC</th>
                <th class="text-center align-middle cabeceraSecundaria">RUTAS RECUPERADAS POR GZ</th>
                <th class="text-center align-middle cabeceraSecundaria">RECUPERACION GZ</th>
            </tr>
        </thead>
        <tbody>
            <?
            $i = 0;
            foreach ($data as $key => $value) {
                $i++;
            ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-left"><?= verificarEmpty($value['GERENTE'], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($value['SPOC'], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($value['SUCURSAL'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['RUTAS_PENDIENTES_GTM_Q'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['RUTAS_RECUPERADAS_POR_SPOC'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['RECUPERACION_SPOC'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['RUTAS_RECUPERADAS_POR_GZ'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['RECUPERACION_GZ'], 3) ?></td>
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
            $('#tb-recuperacion').DataTable().page.len(page).draw();
            $('#tb-recuperacion').DataTable().page.len(20).draw();
        }
    });
</script>