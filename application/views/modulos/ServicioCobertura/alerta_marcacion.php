<div class="card-datatable">
    <table id="tb-alerta" class="table table-striped table-bordered nowrap" width="100%">
        <thead>
            <tr>
                <th class="text-center align-middle noVis">#</th>
                <th class="text-center align-middle ">FECHA</th>
                <th class="text-center align-middle ">DEPARTAMENTO</th>
                <th class="text-center align-middle ">PROVINCIA</th>
                <th class="text-center align-middle ">DISTRITO</th>
                <th class="text-center align-middle ">GRUPO CANAL</th>
                <th class="text-center align-middle ">CANAL</th>
                <th class="text-center align-middle ">COD USUARIO</th>
                <th class="text-center align-middle ">USUARIO</th>
                <th class="text-center align-middle ">DOCUMENTO</th>
                <th class="text-center align-middle ">MOVIL ASIGNADO</th>
                <th class="text-center align-middle ">HORARIO</th>
                <th class="text-center align-middle ">1° VISITA<br>(HORA INICIO)</th>
                <th class="text-center align-middle ">N° VISITA<br>(HORA FIN)</th>
                <th class="text-center align-middle ">HORA INGRESO</th>
                <th class="text-center align-middle ">HORA SALIDA</th>
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
                    <td class="text-left"><?= verificarEmpty($value['fecha'], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($value['departamento'], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($value['provincia'], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($value['distrito'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['grupoCanal'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['canal'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['idUsuario'], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($value['usuario'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['numDocumento'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['movil'], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($value['horarioIng'], 3) ." - ".verificarEmpty($value['horarioSal'], 3)  ?></td>
                    <td class="text-center"><?= verificarEmpty($value['horaIniVisita'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['horaFinVisita'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['horaIngreso'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['horaSalida'], 3) ?></td>
                </tr>
            <?
            }
            ?>
        </tbody>
    </table>
</div>
<script>
    $("#tb-alerta").DataTable();
</script>