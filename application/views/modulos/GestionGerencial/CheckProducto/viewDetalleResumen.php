<div class="col-lg-12 ">
	<table id="detalle_resumen" class="table table-sm table-bordered nowrap w-100">
		<thead>
			<tr>
				<th class="noVis">N°</th>
				<th>GRUPO CANAL</th>
				<th>CANAL</th>
				<? foreach ($segmentacion['headers'] as $k => $v) { ?>
					<th class="text-center align-middle"><?= strtoupper($v['header']) ?></th>
				<? } ?>
				<th>COD VISUAL</th>
				<th class="text-center ">COD <?= $this->sessNomCuentaCorto ?></th>
				<th class="text-center ">COD PDV</th>
				<th>PDV</th>
				<th>DIRECCION</th>
			</tr>
		</thead>
		<tbody>
			<? $i = 1;
			foreach ($data as $row) {
				if (empty($row['idCliente'])) {
					continue;
				}
			?>
				<tr>
					<td style="text-align:center;"><?= $i ?></td>
					<td style="text-align:left;"><?= $row['grupoCanal'] ?></td>
					<td style="text-align:left;"><?= $row['canal'] ?></td>
					<? foreach ($segmentacion['headers'] as $k => $v) { ?>
						<td class="text-<?= (!empty($row[($v['columna'])]) ? $v['align'] : 'left') ?>"><?= (!empty($row[($v['columna'])]) ? $row[($v['columna'])] : '-') ?></td>
					<? } ?>
					<td style="text-align:center;"><?= $row['idCliente'] ?></td>
					<td style="text-align:center;"><?= ($row['codCliente']) ? $row['codCliente'] : '-' ?></td>
					<td style="text-align:center;"><?= ($row['codDist']) ? $row['codDist'] : '-' ?></td>
					<td style="text-align:left;"><?= $row['razonSocial'] ?></td>
					<td style="text-align:left;"><?= ($row['direccion']) ? $row['direccion'] : '-' ?></td>
				</tr>
			<? $i++;
			} ?>
		</tbody>
	</table>
</div>
<script>
	$(document).ready(function() {
		$('#detalle_resumen').DataTable();
	});
</script>