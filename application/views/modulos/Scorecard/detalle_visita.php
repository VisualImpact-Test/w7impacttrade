<script>
	$('#detalle_scorecard').DataTable();
</script>
<div class="col-lg-12 ">
		<div class="mb-3 card">
			<div class="card-body">

			<table id="detalle_scorecard" class="table table-striped table-bordered nowrap"  style="font-size: 90%">
				<thead>
					<tr>
						<th class="noVis">N°</th>
						<th>FECHA</th>
						<th>GERENTE ZONAL</th>
						<th>COORDINADOR</th>
						<th>SUPERVISOR</th>
						<th>COD USUARIO</th>
						<th>NOMBRE USUARIO</th>
						<th>GRUPO CANAL</th>
						<th>CANAL</th>
						<th>TIPO CLIENTE</th>
						<? foreach ($segmentacion['headers'] as $k => $v) { ?>
							<th class="text-center align-middle"><?= strtoupper($v['header']) ?></th>
							<? } ?>
						<th>COD VISUAL</th>
						<th class="text-center hideCol" >COD <?=$this->sessNomCuentaCorto?></th>
						<th class="text-center hideCol" >COD PDV</th>
						<th>PDV</th>
						<th>DIRECCION</th>
                        <th class="text-center">HORA INICIO</th>
                        <th class="text-center ">LATITUD INICIAL</th>
                        <th class="text-center ">LONGITUD INICIAL</th>
                        <th class="text-center">HORA FIN</th>
                        <th class="text-center ">LATITUD FINAL</th>
                        <th class="text-center ">LONGITUD FINAL</th>
                        <th class="text-center">TIEMPO (MIN)</th>
                        <th class="text-center">INCIDENCIA</th>
					</tr>
				</thead>
				<tbody>
					<? $i=1; foreach($cartera as $row){ 
                        $latiIni = $row['lati_ini'];
						$longIni = $row['long_ini'];
						$latitud = $row['latitud'];
						$longitud = $row['longitud'];
						$gpsIni = ((empty($latiIni) || $latiIni == 0 || empty($longIni) || $longIni == 0)) ? '' : '<a href="javascript:;" class="lk-show-gps1 a-fa" data-latitud="' . $latiIni . '" data-longitud="' . $longIni . '" data-latitud-cliente="' . $latitud . '" data-longitud-cliente="' . $longitud . '" data-type="ini" data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '"  ><i class="fa fa-map-marker" ></i></a> ';
						/* ---- */
						$latiFin = $row['lati_fin'];
						$longFin = $row['long_fin'];
						$latitud = $row['latitud'];
						$longitud = $row['longitud'];
						$gpsFin = ((empty($latiFin) || $latiFin == 0 || empty($longFin) || $longFin == 0)) ? '' : '<a href="javascript:;" class="lk-show-gps1 a-fa" data-latitud="' . $latiFin . '" data-longitud="' . $longFin . '" data-latitud-cliente="' . $latitud . '" data-longitud-cliente="' . $longitud . '" data-type="fin" data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '"  ><i class="fa fa-map-marker" ></i></a> ';
						
						$incidencia = !empty($row['incidencia_nombre']) ? (!empty($row['incidencia_foto']) ? '<a href="javascript:;" data-fotoUrl="' . $row['incidencia_foto'] . '" data-hora ="' . $row['incidencia_hora'] . '" data-html="' . $row['incidencia_nombre'] . '" class="lk-incidencia-foto"  data-perfil="' . $row['tipoUsuario'] . '"  data-usuario="' . $row['nombreUsuario'] . '" data-cliente="' . $row['razonSocial'] . '"  ><i class="fa fa-camera" ></i><br />' : '') . $row['incidencia_nombre'] : '<center>-</center>';

						$grupoCanal = $row['grupoCanal'];
						if(in_array($grupoCanal, GC_TRADICIONALES)) {
							$ejecutivo = !empty($usuarios['tradicional'][6][$row['idDistribuidoraSucursal']])? $usuarios['tradicional'][6][$row['idDistribuidoraSucursal']] : ' - ' ;
							$supervisor = !empty($usuarios['tradicional'][2][$row['idDistribuidoraSucursal']])? $usuarios['tradicional'][2][$row['idDistribuidoraSucursal']] : ' - ' ;
							$coordinador = !empty($usuarios['tradicional'][10][$row['idDistribuidoraSucursal']])? $usuarios['tradicional'][10][$row['idDistribuidoraSucursal']] : ' - ' ;
						}else if(in_array($grupoCanal, GC_MAYORISTAS)){
							$ejecutivo = !empty($usuarios['mayorista'][6][$row['idPlaza']])? $usuarios['mayorista'][6][$row['idPlaza']] : ' - ' ;
							$supervisor = !empty($usuarios['mayorista'][2][$row['idPlaza']])? $usuarios['mayorista'][2][$row['idPlaza']] : ' - ' ;
							$coordinador = !empty($usuarios['mayorista'][10][$row['idPlaza']])? $usuarios['mayorista'][10][$row['idPlaza']] : ' - ';
						}else if(in_array($grupoCanal, GC_MODERNOS)){
							$ejecutivo = !empty($usuarios['moderno'][6][$row['idBanner']])? $usuarios['moderno'][6][$row['idBanner']] : ' - ' ;
							$supervisor = !empty($usuarios['moderno'][2][$row['idBanner']])? $usuarios['moderno'][2][$row['idBanner']] : ' - ' ;
							$coordinador = !empty($usuarios['moderno'][10][$row['idBanner']])? $usuarios['moderno'][10][$row['idBanner']] : ' - ' ;
						}else{
							$ejecutivo = '-';
							$supervisor = '-';
							$coordinador = '-';
						}
					?>
					<tr>
						<td style="text-align:center;"><?=$i?></td>
						<td style="text-align:center;"><?=!empty($row['fecha'])? ($row['fecha']) : ' - ' ?></td>
						<td style="text-align:left;"><?=$ejecutivo?></td>
						<td style="text-align:left;"><?=$coordinador?></td>
						<td style="text-align:left;"><?=$supervisor?></td>
						<td style="text-align:center;"><?=!empty($row['idUsuario'])? $row['idUsuario'] : ' - ' ?></td>
						<td style="text-align:left;"><?=!empty($row['nombreUsuario'])? $row['nombreUsuario'] : ' - ' ?></td>
						<td style="text-align:left;"><?=$row['grupoCanal']?></td>
						<td style="text-align:left;"><?=$row['canal']?></td>
						<td style="text-align:left;"><?=$row['subcanal']?></td>
						<? foreach ($segmentacion['headers'] as $k => $v) { ?>
							<td class="text-<?= (!empty($row[($v['columna'])]) ? $v['align'] : 'left') ?>"><?= (!empty($row[($v['columna'])]) ? $row[($v['columna'])] : '-') ?></td>
						<? } ?>
						<td style="text-align:center;"><?=$row['idCliente']?></td>
						<td style="text-align:center;"><?=($row['codCliente']) ? $row['codCliente'] : '-' ?></td>
						<td style="text-align:center;"><?=($row['codDist']) ? $row['codDist'] : '-' ?></td>
						<td style="text-align:left;"><?=$row['razonSocial']?></td>
						<td style="text-align:left;"><?=($row['direccion']) ? $row['direccion'] : '-' ?></td>
						<td style="text-align:left;"><?=!empty($row['hora_ini']) ? $gpsIni . $row['hora_ini'] : '-'?></td>
						<td style="text-align:left;"><?=!empty($latiIni) ? $latiIni : '-'?></td>
						<td style="text-align:left;"><?=!empty($longIni) ? $longIni : '-'?></td>
						<td style="text-align:left;"><?=!empty($row['hora_fin']) ? $gpsFin . $row['hora_fin'] : '-'?></td>
						<td style="text-align:left;"><?=!empty($latiFin) ? $latiFin : '-'?></td>
						<td style="text-align:left;"><?=!empty($longFin) ? $longFin : '-'?></td>
						<td style="text-align:left;"><?=!empty($row['minutos']) ? $row['minutos'] : '-'?></td>
						<td style="text-align:left;"><?=$incidencia?></td>
					</tr>
					<? $i++;} ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
