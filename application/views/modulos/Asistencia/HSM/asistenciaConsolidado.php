<style>
	table.dataTable {
		border-collapse: collapse !important;
	}
</style>

<div class="card-datatable">
	<table id="tb-asistenciaConsolidadoHsm" class="table table-striped table-bordered nowrap" width="100%">
		<thead>
			<!-- Si se agrega una columna nueva ir a FILTRAR_LEYENDA en asistencia.js y verificar el numero de columna -->
			<tr>
				<th class="text-center align-middle noVis" rowspan="3">#</th>
				<th class="text-center align-middle" rowspan="3">GERENTE ZONAL</th>
				<th class="text-center align-middle" rowspan="3">CIUDAD</th>
				<th class="text-center align-middle" rowspan="3">SPOC</th>

				<? foreach ($segmentacion['headers'] as $k => $v) { ?>
					<th rowspan="3" class="text-center align-middle"><?= strtoupper($v['header']) ?></th>
				<? } ?>

				<th class="text-center align-middle" rowspan="3">PDV</th>
				<th class="text-center align-middle hideCol" rowspan="3">COD EMPLEADO</th>
				<th class="text-center align-middle hideCol" rowspan="3">COD USUARIO</th>
				<th class="text-center align-middle" rowspan="3">PERFIL USUARIO</th>
				<th class="text-center align-middle" rowspan="3">NOMBRE USUARIO</th>
				<th class="text-center align-middle" rowspan="3">FEC. INGRESO</th>
				<th class="text-center align-middle" rowspan="3">MÓVIL ASIGNADO</th>
				<th class="text-center align-middle" rowspan="3">TIPO RUTA</th>
				<?
				foreach ($detalleFechas['meses'] as $k => $r) {
					$colspanMes = count($detalleFechas['fecha'][$k]);
				?>
					<th class="text-center align-middle" colspan="<?= ($colspanMes * 2) ?>"><?= $r ?></th>
				<?
				}
				?>
			</tr>
			<tr>
				<?
				foreach ($detalleFechas['meses'] as $k => $r) {
					foreach ($detalleFechas['dia'][$k] as $sk => $sr) {
				?>
						<th class="text-center align-middle" colspan="2"><?= $sr ?><br><?= $detalleFechas['fecha'][$k][$sk] ?></th>
				<?
					}
				}
				?>
			</tr>
			<tr>
				<?
				foreach ($detalleFechas['meses'] as $k => $r) {
					foreach ($detalleFechas['dia'][$k] as $sk => $sr) {
				?>
						<th class="text-center align-middle">STATUS</th>
						<th class="text-center align-middle">%</th>
				<?
					}
				}
				?>
			</tr>
		</thead>
		<tbody>
			<? $ix = 1; ?>
			<?
			foreach ($listaUsuarios as $key => $row) {
				$segmentacionUsuarios = segmentacion_usuarios($usuarios, $row);
				$tipoRuta = '';
				$jornada = $row['horasProgramadas'];

				if (
					$jornada >= 540
				) {
					$tipoRuta = 'FULL TIME';
				} else {
					$tipoRuta = 'PART TIME';
				}
			?>
				<tr>
					<td class="text-center"><?= $ix++ ?></td>
					<td class="text-center"><?= verificarEmpty($segmentacionUsuarios['ejecutivo'], 3) ?></td>
					<td class="text-center"><?= verificarEmpty($row['ciudad'], 3) ?></td>
					<td class="text-center"><?= verificarEmpty($segmentacionUsuarios['supervisor'], 3) ?></td>

					<? foreach ($segmentacion['headers'] as $k => $v) { ?>
						<td class="text-<?= (!empty($row[($v['columna'])]) ? $v['align'] : '-') ?>"><?= (!empty($row[($v['columna'])]) ? $row[($v['columna'])] : '-') ?></td>
					<? } ?>

					<td class="text-center"><?= verificarEmpty($row['cliente'], 3) ?></td>
					<td class="text-center"><?= verificarEmpty($row['idEmpleado'], 3) ?></td>
					<td class="text-center"><?= verificarEmpty($row['idUsuario'], 3) ?></td>
					<td class="text-center"><?= verificarEmpty($row['tipoUsuario'], 3) ?></td>
					<td class="text-center"><?= verificarEmpty($row['usuario'], 3) ?></td>
					<td class="text-center"><?= verificarEmpty($row['fecha_ingreso'], 3) ?></td>
					<td class="text-center"><?= verificarEmpty($row['movil'], 3) ?></td>
					<td class="text-center"><?= verificarEmpty($tipoRuta, 3) ?></td>
					<?
					foreach ($detalleFechas['meses'] as $k => $r) {
						foreach ($detalleFechas['dia'][$k] as $sk => $sr) {
							if (!empty($row[$sk])) {
								$status = '-';
								$css_status = '';

								if (
									!empty($row[$sk]['horaIniVisita']) && !empty($row[$sk]['horaFinVisita'])
								) {
									$status = 'C';
									$css_status = 'color-C';
								} elseif (!empty($row[$sk]['horaIniVisita']) || !empty($row[$sk]['horaFinVisita'])) {
									$status = 'P';
									$css_status = 'color-I';
								} else {
									$status = 'F';
									$css_status = 'color-F';
								}

								$efectividad = ($row['horasProgramadas'] > 0) ? ($row[$sk]['horasTrabajadas'] / $row['horasProgramadas']) * 100 : 0;

								$css_hora_ini = '';
								$css_hora_fin = '';
								if (!empty($row['horaIniVisita'])) {
									$array_hora_ini = difMin($row[$sk]['horarioIng'], $row[$sk]['horaIniVisita']);

									if ($array_hora_ini['difh'] < 0) {
										$css_hora_ini = 'color-C';
									} elseif ($array_hora_ini['difh'] == 0 && $array_hora_ini['difm'] <= 10) {
										$css_hora_ini = 'color-N';
									} else {
										$css_hora_ini = 'color-F';
									}
								}

								if (!empty($row[$sk]['horaFinVisita'])) {
									$array_hora_fin = difMin($row[$sk]['horarioSal'], $row[$sk]['horaFinVisita']);

									if ($array_hora_fin['difh'] < 0) {
										$css_hora_fin = 'color-F';
									} else {
										$css_hora_fin = 'color-C';
									}
								}
							}
					?>
							<td class="text-center"><span class="<?= $css_status ?>"><i class="fa fa-circle"></i></span> <?= verificarEmpty($status, 3) ?></td>
							<td class="text-center"><?= round(verificarEmpty($efectividad, 2), 2) ?> %</td>
					<?
						}
					}
					?>
				</tr>
			<?
			}
			?>
		</tbody>
	</table>
</div>

<script>
	$(document).ready(function() {

		var opcion = $('.btnReporte.active').data('value');
		if (opcion == 1) {
			var c = 0;

			$('.filtroCondicion').each(function(ev) {
				var btn = $(this).val();
				var ckb = $(this).prop('checked');

				if (ckb == false) {
					$('.' + btn).each(function(ev) {
						$(this).parent('tr').hide();
					});
				} else {
					$('.' + btn).each(function(ev) {
						$(this).parent('tr').show();
						c++;
					});
				}
			});

			var page = Math.floor((Math.random() * 10) + 1);
			$('#tb-asistenciaDetalle').DataTable().page.len(page).draw();
			$('#tb-asistenciaDetalle').DataTable().page.len(20).draw();
		}
	});
</script>