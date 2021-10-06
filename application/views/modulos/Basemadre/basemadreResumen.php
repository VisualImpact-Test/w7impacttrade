	<table id="tb-basemadreResumen" class="mb-0 table table-bordered text-nowrap " style="font-size:12px;">
		<thead>
			<tr class="bg-purple-gradient">
				<th class="text-center align-middle" rowspan="2">OPCIONES</th>
				<th class="text-center align-middle" colspan="2">COBERTURA</th>
				<th class="text-center align-middle" colspan="2">VENTAS</th>
			</tr>
			<tr class="bg-purple-gradient">
				<th class="text-center align-middle">TOTAL</th>
				<th class="text-center align-middle">PARTICIPACIÓN</th>
				<th class="text-center align-middle">TOTAL</th>
				<th class="text-center align-middle">PARTICIPACIÓN</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="text-center">UNIVERSO DE PDV</td>
				<td class="text-center" colspan="2"><strong><?=$contRs;?></strong></td>
				<td class="text-center" colspan="2"><strong><?=moneda($total_venta);?></strong></td>
			</tr>
			<tr>
				<td class="text-center">PDV EN CARTERA</td>
				<td class="text-center"><strong><?=count($en_cartera)?></strong></td>
				<td class="text-center"><strong><?=($contRs > 0)? round((count($en_cartera)/$contRs) *100, 2).'%' : '-' ?></strong></td>
				<td class="text-center"><strong><?=moneda($total_en_cartera_venta)?></strong></td>
				<td class="text-center"><strong><?=(round($total_venta,2) > 0)? round((round($total_en_cartera_venta,2)/round($total_venta,2)) *100, 2).'%' : '-' ?></strong></td>
			</tr>
			<tr>
				<td colspan="5"></td>
			</tr>
			<tr>
				<td class="text-center" >PDV PROGRAMADOS <br /><strong>(<?=$fecIni?>-<?=$fecFin?>)</strong></td>
				<td class="text-center" colspan="4">
					<? $por= isset($programados)? ( (count($en_cartera) > 0) ? round((count($programados)/count($en_cartera) ) *100, 2).'%' : 0) : 0;?>
					<div class="mb-3 progress" style="height: 4em;">
						<div class="progress-bar" role="progressbar" aria-valuenow="<?=$por;?>" aria-valuemin="0" aria-valuemax="100" style="height: 4em;width: <?=$por;?>;font-weight: bold;"><strong><?=$por;?></strong></div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>