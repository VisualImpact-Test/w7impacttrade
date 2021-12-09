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
						<th>COORDINADOR ZONAL</th>
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
						
						$grupoCanal = $row['grupoCanal'];
						if(in_array($grupoCanal, GC_TRADICIONALES)) {
							$ejecutivo = !empty($usuarios['tradicional'][11][$row['idDistribuidoraSucursal']])? $usuarios['tradicional'][11][$row['idDistribuidoraSucursal']] : ' - ' ;
							$supervisor = !empty($usuarios['tradicional'][2][$row['idDistribuidoraSucursal']])? $usuarios['tradicional'][2][$row['idDistribuidoraSucursal']] : ' - ' ;
							$coordinador = !empty($usuarios['tradicional'][17][$row['idDistribuidoraSucursal']])? $usuarios['tradicional'][17][$row['idDistribuidoraSucursal']] : ' - ' ;
						}else if(in_array($grupoCanal, GC_MAYORISTAS)){
							$ejecutivo = !empty($usuarios['mayorista'][11][$row['idPlaza']])? $usuarios['mayorista'][11][$row['idPlaza']] : ' - ' ;
							$supervisor = !empty($usuarios['mayorista'][2][$row['idPlaza']])? $usuarios['mayorista'][2][$row['idPlaza']] : ' - ' ;
							$coordinador = !empty($usuarios['mayorista'][17][$row['idPlaza']])? $usuarios['mayorista'][17][$row['idPlaza']] : ' - ';
						}else if(in_array($grupoCanal, GC_MODERNOS)){
							$ejecutivo = !empty($usuarios['moderno'][11][$row['idBanner']])? $usuarios['moderno'][11][$row['idBanner']] : ' - ' ;
							$supervisor = !empty($usuarios['moderno'][2][$row['idBanner']])? $usuarios['moderno'][2][$row['idBanner']] : ' - ' ;
							$coordinador = !empty($usuarios['moderno'][17][$row['idBanner']])? $usuarios['moderno'][17][$row['idBanner']] : ' - ' ;
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
