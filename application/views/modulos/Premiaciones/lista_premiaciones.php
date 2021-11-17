<?
$externo = $this->flag_externo;

?>
<div class="card-datatable">
	<table id="tb-premiaciones" class="mb-0 table table-bordered text-nowrap" width="100%">
		<thead>
			<tr>
				<th>TOTAL: <?= count($premiaciones) ?></th>
				<th colspan="16"></th>
			</tr>
			<tr>
				<th class="text-center align-middle noVis">#</th>
				<th class="text-center align-middle">FECHA</th>
				<th class="text-center align-middle">HORA</th>
				<th class="text-center align-middle">PERFIL USUARIO</th>
				<th class="text-center align-middle hideCol">COD USUARIO</th>
				<th class="text-center align-middle">NOMBRE USUARIO</th>
				<th class="text-center align-middle">GRUPO CANAL</th>
				<th class="text-center align-middle">CANAL</th>
				<th class="text-center align-middle hideCol">SUBCANAL</th>
				<?foreach ($segmentacion['headers'] as $k => $v) {?>
					<th class="text-center align-middle" ><?=strtoupper($v['header'])?></th>
				<?}?>
				<th class="text-center align-middle">COD VISUAL</th>
				<th class="text-center align-middle hideCol">COD <?=$this->sessNomCuentaCorto?></th>
				<th class="text-center align-middle hideCol">COD PDV</th>
				<th class="text-center align-middle">PDV</th>
				<th class="text-center align-middle">PREMIADO</th>
				<th class="text-center align-middle">PREMIACION</th>
				<th class="text-center align-middle">TIPO PREMIACION</th>
				<th class="text-center align-middle">CODIGO PREMIO</th>
				<th class="text-center align-middle">MONTO PREMIO</th>
				<th class="text-center align-middle">MOTIVO NO PREMIO</th>
				<th class="text-center align-middle">ESTADO</th>
			</tr>
		</thead>
		<tbody>
			<? $ix = 1; ?>
			<?
			foreach ($premiaciones as $row) {
				$lati_cli = isset($row['latitud_cliente']) ? $row['latitud_cliente'] : '';
				$long_cli = isset($row['longitud_cliente']) ? $row['longitud_cliente'] : '';
				$gps = (!empty($row['latitud_visita']) && !empty($row['longitud_visita'])) ? ruta_gps($row['latitud_visita'], $row['longitud_visita'], $lati_cli, $long_cli) : '';
				$foto = isset($row['fotoUrl']) ? (!empty($row['fotoUrl']) ? ruta_foto($row['fotoUrl']) : '') : '';

				$mensajeEstado = $row['estado'] == 1 ? 'Activo' : 'Inactivo';
				$badge = $row['estado'] == 1 ? 'badge-success' : 'badge-danger';
			?>
				<tr>
					<td class="text-center" style="text-align:center;vertical-align: middle;"><?= $ix; ?></td>
					<td class="text-center" style="text-align:center;vertical-align: middle;"><?= verificarEmpty($row['fecha'], 3); ?></td>
					<td class="text-center" style="text-align:center;vertical-align: middle;"><?= verificarEmpty($row['hora'], 3); ?></td>
					<td class="text-left" style="text-align:center;vertical-align: middle;"><?= verificarEmpty($row['tipoUsuario'], 3); ?></td>
					<td class="text-center" style="text-align:center;vertical-align: middle;"><?= verificarEmpty($row['idUsuario'], 3); ?></td>
					<td class="text-left" style="text-align:center;vertical-align: middle;"><?= verificarEmpty($row['nombreUsuario'], 3); ?></td>
					<td class="text-left" style="text-align:center;vertical-align: middle;"><?= !empty($row['grupoCanal'])? $row['grupoCanal'] : '-'; ?></td>
					<td class="text-left" style="text-align:center;vertical-align: middle;"><?= !empty($row['canal'])? $row['canal'] : '-'; ?></td>
					<td class="text-left" style="text-align:center;vertical-align: middle;"><?= !empty($row['subCanal'])? $row['subCanal'] : '-'; ?></td>
					<?foreach ($segmentacion['headers'] as $k => $v) {?>
						<td class="text-left"><?= (!empty($row[($v['columna'])]) ? $row[($v['columna'])] : '-') ?></td>
					<?}?>
					<td class="text-center" style="text-align:center;vertical-align: middle;"><?= verificarEmpty($row['idCliente'], 3); ?></td>
					<td class="text-center" style="text-align:center;vertical-align: middle;"><?= !empty($row['codCliente'])? $row['codCliente'] : '-'; ?></td>
					<td class="text-center" style="text-align:center;vertical-align: middle;"><?= !empty($row['codDist'])? $row['codDist'] : '-'; ?></td>
					<td class="text-left" style="text-align:center;vertical-align: middle;"><?= verificarEmpty($row['razonSocial'], 3); ?></td>
					<td class="text-center" style="text-align:center;vertical-align: middle;"><?= $gps . ' ' . $foto . ' ' . (($row['premiado'] == 1) ? 'SI' : 'NO'); ?></td>
					<td class="text-left" style="text-align:center;vertical-align: middle;"><?= $row['premiacion']; ?></td>
					<td class="text-left" style="text-align:center;vertical-align: middle;"><?= $row['tipoPremiacion']; ?></td>
					<td class="text-center" style="text-align:center;vertical-align: middle;"><?= $row['codigo']; ?></td>
					<td class="text-right" style="text-align:center;vertical-align: middle;"><?= $row['monto']; ?></td>
					<td class="text-center" style="text-align:center;vertical-align: middle;">-</td>
					<td class="text-center style-icons" style="text-align:center;vertical-align: middle;">
						<span class="badge <?=$badge?>" id="spanEstado-<?= $row['idVisitaPremiacion']; ?>"><?= $mensajeEstado; ?></span>
						<?if(empty($externo)){?>
						<a id="hrefEstado-<?= $row['idVisitaPremiacion']; ?>" href="javascript:;" style="margin-left:5px;" class="btn-actualizar-estado" data-id="<?= $row['idVisitaPremiacion']; ?>" data-estado="<?= $row['estado']; ?>">
							<i class="fa fa-sync"></i>
						</a>
						<?}?>
					</td>
				</tr>
			<? $ix++;
			} ?>
		</tbody>
	</table>
</div>