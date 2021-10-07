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
						<th>GERENTE ZONAL</th>
						<th>COORDINADOR</th>
						<th>SUPERVISOR</th>
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
					</tr>
				</thead>
				<tbody>
					<? $i=1; foreach($cartera as $row){ 
						
						if($segmentacion['tipoSegmentacion'] == 'tradicional'){
							$ejecutivo = !empty($usuarios[6][$row['idDistribuidoraSucursal']])? $usuarios[6][$row['idDistribuidoraSucursal']] : ' - ' ;
							$supervisor = !empty($usuarios[2][$row['idDistribuidoraSucursal']])? $usuarios[2][$row['idDistribuidoraSucursal']] : ' - ' ;
							$coordinador = !empty($usuarios[10][$row['idDistribuidoraSucursal']])? $usuarios[10][$row['idDistribuidoraSucursal']] : ' - ' ;
						}else if($segmentacion['tipoSegmentacion'] == 'mayorista'){
							$ejecutivo = !empty($usuarios[6][$row['idPlaza']])? $usuarios[6][$row['idPlaza']] : ' - ' ;
							$supervisor = !empty($usuarios[2][$row['idPlaza']])? $usuarios[2][$row['idPlaza']] : ' - ' ;
							$coordinador = !empty($usuarios[10][$row['idPlaza']])? $usuarios[10][$row['idPlaza']] : ' - ' ;
						}else if($segmentacion['tipoSegmentacion'] == 'moderno'){
							$ejecutivo = !empty($usuarios[6][$row['idBanner']])? $usuarios[6][$row['idBanner']] : ' - ' ;
							$supervisor = !empty($usuarios[2][$row['idBanner']])? $usuarios[2][$row['idBanner']] : ' - ' ;
							$coordinador = !empty($usuarios[10][$row['idBanner']])? $usuarios[10][$row['idBanner']] : ' - ' ;
						}else{
							$ejecutivo = '-';
							$supervisor = '-';
							$coordinador = '-';
						}
					?>
					<tr>
						<td style="text-align:center;"><?=$i?></td>
						<td style="text-align:left;"><?=$ejecutivo?></td>
						<td style="text-align:left;"><?=$coordinador?></td>
						<td style="text-align:left;"><?=$supervisor?></td>
						<td style="text-align:center;"><?=$row['grupoCanal']?></td>
						<td style="text-align:left;"><?=$row['canal']?></td>
						<td style="text-align:left;"><?=$row['subcanal']?></td>
						<? foreach ($segmentacion['headers'] as $k => $v) { ?>
							<td class="text-<?= (!empty($row[($v['columna'])]) ? $v['align'] : 'left') ?>"><?= (!empty($row[($v['columna'])]) ? $row[($v['columna'])] : '-') ?></td>
						<? } ?>
						<td style="text-align:center;"><?=$row['idCliente']?></td>
						<td style="text-align:center;"><?=$row['codCliente']?></td>
						<td style="text-align:center;"><?=$row['codDist']?></td>
						<td style="text-align:left;"><?=$row['razonSocial']?></td>
						<td style="text-align:left;"><?=$row['direccion']?></td>
					</tr>
					<? $i++;} ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
