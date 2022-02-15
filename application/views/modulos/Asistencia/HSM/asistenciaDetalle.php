<style>
	table.dataTable {
		border-collapse: collapse !important;
	}
</style>

<div class="card-datatable">
	<table id="tb-asistenciaDetalleHsm" class="table table-striped table-bordered nowrap" width="100%">
		<thead>
			<!-- Si se agrega una columna nueva ir a FILTRAR_LEYENDA en asistencia.js y verificar el numero de columna -->
			<tr>
				<th class="text-center align-middle noVis" rowspan="3">#</th>
				<th class="text-center align-middle hideCol" rowspan="3">GRUPO CANAL</th>
				<th class="text-center align-middle hideCol" rowspan="3">CANAL</th>
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
				<th class="text-center align-middle hideCol" rowspan="3">DNI</th>
				<th class="text-center align-middle" rowspan="3">FEC. INGRESO</th>
				<th class="text-center align-middle" rowspan="3">MÓVIL ASIGNADO</th>
				<th class="text-center align-middle" rowspan="3">TIPO RUTA</th>

				<th class="text-center align-middle" colspan="5">CUMPLIMIENTO DE SERVICIO</th>
				<th class="text-center align-middle" colspan="3">EFECTIVIDAD DE SERVICIO</th>
			</tr>
			<tr>
				<th class="text-center align-middle" colspan="2">HORARIO</th>
				<th class="text-center align-middle" colspan="3">ASISTENCIA</th>
				<th class="text-center align-middle" rowspan="2">HORAS PROG.</th>
				<th class="text-center align-middle" rowspan="2">HORAS TRAB.</th>
				<th class="text-center align-middle" rowspan="2">% EFECT.</th>
			</tr>
			<tr>
				<th class="text-center align-middle">HORA<br>INGRESO</th>
				<th class="text-center align-middle">HORA<br>SALIDA</th>

				<th class="text-center align-middle">HORA INGRESO</th>
				<th class="text-center align-middle">HORA SALIDA</th>
				<th class="text-center align-middle">ESTADO</th>
			</tr>
		</thead>
		<tbody>
			<? $ix = 1; ?>
			<?
			foreach ($listaUsuarios as $key => $row) {
				$segmentacionUsuarios = segmentacion_usuarios($usuarios, $row);
				$jornada = $row['horasProgramadas'];
				$tipoRuta = '';
				$status = '-';
				$css_status = '';

				if (
					$jornada >= 540
				) {
					$tipoRuta = 'FULL TIME';
				} else {
					$tipoRuta = 'PART TIME';
				}

				if (
					!empty($row['horaIniVisita']) && !empty($row['horaFinVisita'])
				) {
					$status = 'C';
					$css_status = 'color-C';
				} elseif (!empty($row['horaIniVisita']) || !empty($row['horaFinVisita'])) {
					$status = 'P';
					$css_status = 'color-I';
				} else {
					$status = 'F';
					$css_status = 'color-F';
				}

				$efectividad = ($row['horasProgramadas'] > 0) ? ($row['horasTrabajadas'] / $row['horasProgramadas']) * 100 : 0;

				$gps_ini = '';
				$gps_fin = '';
				$css_hora_ini = '';
				$css_hora_fin = '';
				if (!empty($row['horaIniVisita'])) {
					$array_hora_ini = difMin($row['horarioIng'], $row['horaIniVisita']);

					if ($array_hora_ini['difh'] < 0) {
						$css_hora_ini = 'color-C';
					} elseif ($array_hora_ini['difh'] == 0 && $array_hora_ini['difm'] <= 10) {
						$css_hora_ini = 'color-N';
					} else {
						$css_hora_ini = 'color-F';
					}
				}

				if (!empty($row['horaFinVisita'])) {
					$array_hora_fin = difMin($row['horarioSal'], $row['horaFinVisita']);

					if ($array_hora_fin['difh'] < 0) {
						$css_hora_fin = 'color-F';
					} else {
						$css_hora_fin = 'color-C';
					}
				}

				$gpsInicial = (empty($row['latiIniVisita']) || empty($row['longIniVisita'])) ? '' : '<a href="javascript:;" class="lk-show-gps1 a-fa" data-latitud="' . $row['latiIniVisita'] . '" data-longitud="' . $row['longIniVisita'] . '" data-latitud-cliente="' . $row['latiIniVisita'] . '" data-longitud-cliente="' . $row['longIniVisita'] . '" data-type="mapa" ><i class="fa fa-map-marker" ></i></a>';
				$gpsFinal = (empty($row['latiFinVisita']) || empty($row['longFinVisita'])) ? '' : '<a href="javascript:;" class="lk-show-gps1 a-fa" data-latitud="' . $row['latiFinVisita'] . '" data-longitud="' . $row['longFinVisita'] . '" data-latitud-cliente="' . $row['latiFinVisita'] . '" data-longitud-cliente="' . $row['longFinVisita'] . '" data-type="mapa" ><i class="fa fa-map-marker" ></i></a>';

				$fotoIngreso = isset($asistencias[$row['fecha_id']]['usuarios'][$row['idUsuario']]['asistencias'][1]['foto']) ? $asistencias[$row['fecha_id']]['usuarios'][$row['idUsuario']]['asistencias'][1]['foto'] : '';
				$fotoIngreso = !empty($fotoIngreso) ? '<a href="javascript:;" class="fotoMiniatura a-fa" data-idUsuario = "' . $row['idUsuario'] . '" data-fecha="' . $row['fecha'] . '" data-type="1" ><i class="fa fa-camera" ></i></a>' : '';

				$fotoSalida = isset($asistencias[$row['fecha_id']]['usuarios'][$row['idUsuario']]['asistencias'][3]['foto']) ? $asistencias[$row['fecha_id']]['usuarios'][$row['idUsuario']]['asistencias'][3]['foto'] : '';
				$fotoSalida = !empty($fotoSalida) ? '<a href="javascript:;" class="fotoMiniatura a-fa" data-idUsuario = "' . $row['idUsuario'] . '" data-fecha="' . $row['fecha'] . '" data-type="3" ><i class="fa fa-camera" ></i></a>' : '';

			?>
				<tr>
					<td class="text-center"><?= $ix++ ?></td>
					<td class="text-center"><?= verificarEmpty($row['grupoCanal'], 3) ?></td>
					<td class="text-center"><?= verificarEmpty($row['canal'], 3) ?></td>
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
					<td class="text-center"><?= verificarEmpty($row['numDocumento'], 3) ?></td>
					<td class="text-center"><?= verificarEmpty($row['fecha_ingreso'], 3) ?></td>
					<td class="text-center"><?= verificarEmpty($row['movil'], 3) ?></td>
					<td class="text-center"><?= verificarEmpty($tipoRuta, 3) ?></td>
					<td class="text-center"><?= verificarEmpty($row['horarioIng'], 3) ?></td>
					<td class="text-center"><?= verificarEmpty($row['horarioSal'], 3) ?></td>
					<td class="text-center <?= $css_hora_ini ?>"><?= $gpsInicial . ' ' . $fotoIngreso ?> <strong><?= verificarEmpty($row['horaIniVisita'], 3) ?></strong></td>
					<td class="text-center <?= $css_hora_fin ?>"><?= $gpsFinal . ' ' . $fotoSalida ?> <strong><?= verificarEmpty($row['horaFinVisita'], 3) ?></strong></td>
					<td class="text-center"><span class="<?= $css_status ?>"><i class="fa fa-circle"></i></span> <?= verificarEmpty($status, 3) ?></td>
					<td class="text-center"><?= verificarEmpty($row['horasProgramadas'], 3) ?></td>
					<td class="text-center"><?= verificarEmpty($row['horasTrabajadas'], 3) ?></td>
					<td class="text-center"><?= round(verificarEmpty($efectividad, 2), 2) ?> %</td>
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