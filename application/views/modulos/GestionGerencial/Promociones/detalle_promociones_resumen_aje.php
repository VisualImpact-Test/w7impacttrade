<div class="card-datatable">
	<table id="tb-promociones-resumen" class="mb-0 table table-bordered text-nowrap" width="100%">
		<thead>
			<tr>
				<th class="text-center align-middle">#</th>
				<? foreach ($segmentacion['headers'] as $k => $v) { ?>
					<th class="text-center align-middle"><?= strtoupper($v['header']) ?></th>
				<? } ?>
				<th class="text-center align-middle">CATEGORIA</th>
				<th class="text-center align-middle">MARCA</th>
				<th class="text-center align-middle">FORMATO</th>
				<th class="text-center align-middle">TIPO DE PROMOCIÓN</th>
				<th class="text-center align-middle">PROMOCIÓN</th>
				<th class="text-center align-middle">PRECIO OFERTA</th>
			</tr>

		</thead>
		<tbody>
			<? $i = 1;
			foreach ($visitas as $row) {
			?>
				<tr>
					<td class="text-center"><?= $i++; ?></td>
					<? foreach ($segmentacion['headers'] as $k => $v) { ?>
						<td class="text-left"><?= (!empty($row[($v['columna'])]) ? $row[($v['columna'])] : '-') ?></td>
					<? } ?>
					<td class="text-left"><?= (!empty($row['categoria']) ? $row['categoria'] : '-') ?></td>
					<td class="text-left"><?= (!empty($row['marca']) ? $row['marca'] : '-') ?></td>
					<td class="text-center"><?= (!empty($row['formato']) ? $row['formato'] : '-') ?></td>
					<td class="text-left"><?= (!empty($row['tipoPromocion']) ? $row['tipoPromocion'] : '-') ?></td>
					<td class="text-left"><?= (!empty($row['promocion']) ? $row['promocion'] : '-') ?></td>
					<td class="text-center "><?= (!empty($row['precio_oferta']) ? moneda($row['precio_oferta']) : '-') ?></td>

				</tr>
			<? } ?>
		</tbody>
	</table>
</div>