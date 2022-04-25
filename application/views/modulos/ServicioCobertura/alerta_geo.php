<div class="card-datatable">
    <table id="tb-alerta" class="table table-striped table-bordered nowrap" width="100%">
        <thead>
            <tr>
                <th class="text-center align-middle noVis">#</th>
                <th class="text-center align-middle ">FECHA</th>
                <th class="text-center align-middle ">GRUPO CANAL</th>
                <th class="text-center align-middle ">GERENTE</th>
                <th class="text-center align-middle ">COORDINADOR</th>
                <th class="text-center align-middle ">SPOC</th>
                <th class="text-center align-middle ">COD USUARIO</th>
                <th class="text-center align-middle ">USUARIO</th>
                <th class="text-center align-middle ">SUCURSAL</th>
                <th class="text-center align-middle ">PLAZA</th>
                <th class="text-center align-middle ">COD. VISUAL</th>
                <th class="text-center align-middle ">RAZON SOCIAL</th>
                <th class="text-center align-middle ">HORA INICIO</th>
                <th class="text-center align-middle ">LATITUD INICIAL</th>
                <th class="text-center align-middle ">LONGITUD INICIAL</th>
                <th class="text-center align-middle ">HORA FIN</th>
                <th class="text-center align-middle ">LATITUD FINAL</th>
                <th class="text-center align-middle ">LONGITUD FINAL</th>
            </tr>
        </thead>
        <tbody>
            <?
            $i = 0;
            foreach ($data as $key => $value) {
                $i++;

                $latiIni = $value['lati_ini'];
                $longIni = $value['long_ini'];
                $latitud = $value['latitud'];
                $longitud = $value['longitud'];
                $gpsIni = ((empty($latiIni) || $latiIni == 0 || empty($longIni) || $longIni == 0)) ? '' : '<a href="javascript:;" class="lk-show-gps1 a-fa" data-latitud="' . $latiIni . '" data-longitud="' . $longIni . '" data-latitud-cliente="' . $latitud . '" data-longitud-cliente="' . $longitud . '" data-type="ini" data-perfil="' . $value['tipoUsuario'] . '"  data-usuario="' . $value['nombreUsuario'] . '" data-cliente="' . $value['razonSocial'] . '"  ><i class="fa fa-map-marker" ></i></a> ';
                /* ---- */
                $latiFin = $value['lati_fin'];
                $longFin = $value['long_fin'];
                $latitud = $value['latitud'];
                $longitud = $value['longitud'];
                $gpsFin = ((empty($latiFin) || $latiFin == 0 || empty($longFin) || $longFin == 0)) ? '' : '<a href="javascript:;" class="lk-show-gps1 a-fa" data-latitud="' . $latiFin . '" data-longitud="' . $longFin . '" data-latitud-cliente="' . $latitud . '" data-longitud-cliente="' . $longitud . '" data-type="fin" data-perfil="' . $value['tipoUsuario'] . '"  data-usuario="' . $value['nombreUsuario'] . '" data-cliente="' . $value['razonSocial'] . '"  ><i class="fa fa-map-marker" ></i></a> ';
                
            ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-left"><?= verificarEmpty($value['fecha'], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($value['grupoCanal'], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($value['gerenteZonal'], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($value['coordinador'], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($value['supervisor'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['cod_usuario'], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($value['nombreUsuario'], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($value['sucursal'], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($value['plaza'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($value['cod_visual'], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($value['razonSocial'], 3) ?></td>
                    <td style="text-align:left;"><?=!empty($value['hora_ini']) || !empty($gpsIni) ? $gpsIni . $value['hora_ini'] : '-'?></td>
                    <td style="text-align:left;"><?=!empty($latiIni) ? $latiIni : '-'?></td>
                    <td style="text-align:left;"><?=!empty($longIni) ? $longIni : '-'?></td>
                    <td style="text-align:left;"><?=!empty($value['hora_fin']) ? $gpsFin . $value['hora_fin'] : '-'?></td>
                    <td style="text-align:left;"><?=!empty($latiFin) ? $latiFin : '-'?></td>
                    <td style="text-align:left;"><?=!empty($longFin) ? $longFin : '-'?></td>
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