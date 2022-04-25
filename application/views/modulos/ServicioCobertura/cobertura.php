<style>
    table.dataTable {
        border-collapse: collapse !important;
    }
</style>

<div class="card-datatable">
    <table id="tb-cobertura" class="table table-striped table-bordered nowrap" width="100%">
        <thead>
            <tr>
                <th class="text-center align-middle cabeceraSecundaria noVis">#</th>
                <th class="text-center align-middle cabeceraSecundaria">CANAL</th>
                <th class="text-center align-middle cabeceraSecundaria">GERENTE</th>
                <th class="text-center align-middle cabeceraSecundaria">SPOC</th>
                <th class="text-center align-middle cabeceraSecundaria">COD. VISUAL</th>
                <th class="text-center align-middle cabeceraSecundaria">SUCURSAL/PLAZA</th>
                <th class="text-center align-middle cabeceraSecundaria">RAZON SOCIAL</th>
                <th class="text-center align-middle cabeceraPrincipal">ID GTM</th>
                <th class="text-center align-middle cabeceraPrincipal">DNI</th>
                <th class="text-center align-middle cabeceraPrincipal">PERFIL GTM</th>
                <th class="text-center align-middle cabeceraPrincipal">RUTA</th>
                <th class="text-center align-middle cabeceraPrincipal">OBJ</th>
                <th class="text-center align-middle cabeceraPrincipal">COB</th>
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
                    <td class="text-center"><?= verificarEmpty($value['CANAL'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['GERENTE'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['SPOC'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['CODIGO_VISUAL'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['SUCURSAL_PLAZA'], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($value['RAZON_SOCIAL'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['IDGTM'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['DNI'], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($value['GTM_NAME'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['RUTA'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['OBJ'], 2) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['COB'], 2) ?></td>
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
            $('#tb-cobertura').DataTable().page.len(page).draw();
            $('#tb-cobertura').DataTable().page.len(20).draw();
        }
    });
</script>