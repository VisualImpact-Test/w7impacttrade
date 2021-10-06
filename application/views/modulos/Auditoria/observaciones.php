<div class="card-datatable">
	<table id="tb-observaciones" class="mb-0 table table-bordered text-nowrap" width="100%">
		<thead>
			<tr>
				<th class="text-center noVis">#</th>
				<th class="text-center">FECHA</th>
				<th class="text-center">GRUPOCANAL</th>
				<th class="text-center">CANAL</th>
				<th class="text-center hideCol">SUB CANAL</th>
				<? foreach ($segmentacion['headers'] as $k => $v) { ?>
					<th class="text-center"><?= strtoupper($v['header']) ?></th>
				<? } ?>
				<th class="text-center">COD VISUAL</th>
				<th class="text-center hideCol">COD <?= $this->sessNomCuentaCorto ?></th>
				<th class="text-center hideCol">COD PDV</th>
				<th class="text-center">PDV</th>
				<th class="text-center">TIPO CLIENTE</th>
				<th class="text-center hideCol">DEPARTAMENTO</th>
				<th class="text-center hideCol">PROVINCIA</th>
				<th class="text-center hideCol">DISTRITO</th>
				<th class="text-center">PERFIL USUARIO</th>
				<th class="text-center">NOMBRE USUARIO</th>
				<th class="text-center">ELEMENTO</th>
				<th class="text-center">PRESENCIA</th>
				<th class="text-center">VARIABLE</th>
				<th class="text-center">OBSERVACION</th>
			</tr>
		</thead>
		<tbody>
			<?
			$i = 1;
			foreach ($visitas as $fila) {
			?>
				<tr>
					<td class="text-center"><?= $i++; ?></td>
					<td class="text-center"><?= verificarEmpty($fila['fecha'], 3); ?></td>
					<td class="text-left"><?= verificarEmpty($fila['grupoCanal'], 3); ?></td>
					<td class="text-left"><?= verificarEmpty($fila['canal'], 3); ?></td>
					<td class="text-left"><?= verificarEmpty($fila['subCanal'], 3); ?></td>
					<? foreach ($segmentacion['headers'] as $k => $v) { ?>
						<td class="text-<?= (!empty($row[($v['columna'])]) ? $v['align'] : 'left') ?>"><?= (!empty($row[($v['columna'])]) ? $row[($v['columna'])] : '-') ?></td>
					<? } ?>
					<td class="text-center"><?= verificarEmpty($fila['idCliente'], 3); ?></td>
					<td class="text-center"><?= verificarEmpty($fila['codCliente'], 3); ?></td>
					<td class="text-center"><?= verificarEmpty($fila['codDist'], 3); ?></td>
					<td class="text-left"><?= verificarEmpty($fila['razonSocial'], 3); ?></td>
					<td class="text-left"><?= verificarEmpty($fila['clienteTipo'], 3); ?></td>
					<td class="text-left"><?= verificarEmpty($fila['departamento'], 3); ?></td>
					<td class="text-left"><?= verificarEmpty($fila['provincia'], 3); ?></td>
					<td class="text-left"><?= verificarEmpty($fila['distrito'], 3); ?></td>
					<td class="text-left"><?= verificarEmpty($fila['tipoUsuario'], 3); ?></td>
					<td class="text-left"><?= verificarEmpty($fila['usuario'], 3); ?></td>
					<td class="text-left"><?= verificarEmpty($fila['elementoVisibilidad'], 3); ?></td>
					<td class="text-left"><?= verificarEmpty($fila['presencia'], 3); ?></td>
					<td class="text-left"><?= verificarEmpty($fila['variable'], 3); ?></td>
					<td class="text-left"><?= verificarEmpty($fila['observacion'], 3); ?></td>
				</tr>
			<? } ?>
		</tbody>
	</table>
</div>