<div class="card-datatable">
	<table id="data-table" class="table table-striped table-bordered nowrap" style="font-size:12px;width:100%">
		<thead>
			<tr>
				<th>TOTAL: <?= count($visitas) ?></th>
				<th colspan="100%"></th>
			</tr>
			<tr>
				<th class="text-center noVis">#</th>
				<th class="text-center">SEL.</th>
				<th class="text-center">FECHA</th>
				<th class="text-center">PERFIL USUARIO</th>
				<th class="text-center">COD USUARIO</th>
				<th class="text-center">NOMBRE USUARIO</th>
				<th class="text-center">GRUPO CANAL</th>
				<th class="text-center">CANAL</th>
				<th class="text-center hideCol">SUB CANAL</th>
				<?foreach ($segmentacion['headers'] as $k => $v) {?>
					<th class="text-center align-middle" ><?=strtoupper($v['header'])?></th>
				<?}?>
				<th class="text-center">COD VISUAL</th>
				<th class="text-center hideCol">COD <?= $this->sessNomCuentaCorto ?></th>
				<th class="text-center hideCol">COD PDV</th>
				<th class="text-center">PDV</th>
				<th class="text-center">ZONA PELIGROSA</th>
			</tr>
		</thead>
		<tbody>
			<? $ix = 1; ?>
			<?
			foreach ($visitas as $row) {
			?>
				<tr>
					<td class="text-center"><?= $ix; ?></td>
					<td class="text-center"><input name="check" id="check" class="check" type="checkbox" value="<?= $row['idVisita'] ?>"></td>
					<td class="text-center"><?= verificarEmpty($row['fecha'], 3); ?></td>
					<td class="text-center"><?= verificarEmpty($row['tipoUsuario'], 3); ?></td>
					<td class="text-center"><?= verificarEmpty($row['idUsuario'], 3); ?></td>
					<td class="text-left"><?= verificarEmpty($row['nombreUsuario'], 3); ?></td>
					<td class="text-left"><?= verificarEmpty($row['grupoCanal'], 3); ?></td>
					<td class="text-left"><?= verificarEmpty($row['canal'], 3); ?></td>
					<td class="text-left"><?= verificarEmpty($row['subCanal'], 3); ?></td>
					<?foreach ($segmentacion['headers'] as $k => $v) {?>
						<td class="text-left"><?= (!empty($row[($v['columna'])]) ? $row[($v['columna'])] : '-') ?></td>
					<?}?>
					<td class="text-center"><?= verificarEmpty($row['idCliente'], 3); ?></td>
					<td class="text-center"><?= verificarEmpty($row['codCliente'], 3); ?></td>
					<td class="text-center"><?= verificarEmpty($row['codPdv'], 3); ?></td>
					<td class="text-left"><?= verificarEmpty($row['razonSocial'], 3); ?></td>
					<td class="text-left"><?= verificarEmpty($row['zonaPeligrosa'], 3); ?></td>
				</tr>
			<? $ix++;
			} ?>
		</tbody>
	</table>
</div>
