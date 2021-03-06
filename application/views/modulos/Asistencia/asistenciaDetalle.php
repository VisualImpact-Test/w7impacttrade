<style>
	table.dataTable {
		border-collapse: collapse !important;
	}
</style>

<div class="card-datatable">
	<table id="tb-asistenciaDetalle" class="table table-striped table-bordered nowrap" width="100%">
		<thead>
			<!-- Si se agrega una columna nueva ir a FILTRAR_LEYENDA en asistencia.js y verificar el numero de columna -->
			<tr>
				<th class="text-center align-middle noVis" rowspan="2">#</th>
				<th class="text-center align-middle " rowspan="2">FECHA</th>
				<th class="text-center align-middle hideCol" rowspan="2">DEPARTAMENTO</th>
				<th class="text-center align-middle hideCol" rowspan="2">PROVINCIA</th>
				<th class="text-center align-middle hideCol" rowspan="2">DISTRITO</th>
				<th class="text-center align-middle hideCol" rowspan="2">GRUPO CANAL</th>
				<th class="text-center align-middle hideCol" rowspan="2">CANAL</th>
				<th class="text-center align-middle" rowspan="2">PERFIL USUARIO</th>
				<th class="text-center align-middle hideCol" rowspan="2">COD EMPLEADO</th>
				<th class="text-center align-middle" rowspan="2">COD USUARIO</th>
				<th class="text-center align-middle" rowspan="2">NOMBRE USUARIO</th>
				<th class="text-center align-middle hideCol" rowspan="2">DNI</th>
				<th class="text-center align-middle hideCol" rowspan="2">MÓVIL ASIGNADO</th>
				<th class="text-center align-middle" rowspan="2">HORARIO</th>
				<th class="text-center align-middle" rowspan="2">1° VISITA<br>(HORA INICIO)</th>
				<th class="text-center align-middle" rowspan="2">N° VISITA<br>(HORA FIN)</th>
				<th class="text-center align-middle" colspan="6">INGRESO</th>
				<th class="text-center align-middle" colspan="6">SALIDA</th>
				<th class="text-center align-middle" rowspan="2">CONDICIÓN</th>
			</tr>
			<tr>
				<th class="text-center align-middle">HORA</th>
				<th class="text-center align-middle">GPS</th>
				<th class="text-center align-middle hideCol">LATITUD</th>
				<th class="text-center align-middle hideCol">LONGITUD</th>
				<th class="text-center align-middle">FOTO</th>
				<th class="text-center align-middle">OBSERVACION</th>
				
				<th class="text-center align-middle">HORA</th>
				<th class="text-center align-middle">GPS</th>
				<th class="text-center align-middle hideCol">LATITUD</th>
				<th class="text-center align-middle hideCol">LONGITUD</th>
				<th class="text-center align-middle">FOTO</th>
				<th class="text-center align-middle">OBSERVACION</th>
			</tr>
		</thead>
		<tbody>
			<? $ix = 1; ?>
			<? foreach ($listaUsuarios as $klu => $fechas) : ?>
				<? foreach ($fechas['usuarios'] as $kfu => $usuario) : ?>
					<tr>
						<td><?= $ix++; ?></td>
						<td class="text-center"><?= $fechas['fecha']; ?></td>
						<td><?= !empty($usuario['departamento']) ? $usuario['departamento'] : '-'; ?></td>
						<td><?= !empty($usuario['provincia']) ? $usuario['provincia'] : '-'; ?></td>
						<td><?= !empty($usuario['distrito']) ? $usuario['distrito'] : '-'; ?></td>
						<td><?= !empty($usuario['grupoCanal']) ? $usuario['grupoCanal'] : '-'; ?></td>
						<td><?= !empty($usuario['canal']) ? $usuario['canal'] : '-'; ?></td>
						<td><?= $usuario['tipoUsuario']; ?></td>
						<td class="text-center"><?= $usuario['idEmpleado']; ?></td>
						<td class="text-center"><?= $usuario['idUsuario']; ?></td>
						<td><?= verificarEmpty($usuario['usuario'], 3); ?></td>
						<td class="text-center"><?= $usuario['numDocumento']; ?></td>
						<td class="text-center"><?= $usuario['movil'] ? $usuario['movil'] : '-'; ?></td>
						<td class="text-center"><?= (!empty($usuario['horarioIng']) && !empty($usuario['horarioSal'])) ? $usuario['horarioIng'] . ' - ' . $usuario['horarioSal'] : '-'; ?></td>
						<td class="text-center"><?= !empty($usuario['horaIniVisita']) ? $usuario['horaIniVisita'] : '-'; ?></td>
						<td class="text-center"><?= !empty($usuario['horaFinVisita']) ? $usuario['horaFinVisita'] : '-'; ?></td>
						<?
						$hora1 = isset($asistencias[$fechas['fecha_id']]['usuarios'][$usuario['idUsuario']]['asistencias'][1]['hora']) ? $asistencias[$fechas['fecha_id']]['usuarios'][$usuario['idUsuario']]['asistencias'][1]['hora'] : '-';
						$latitud1 = isset($asistencias[$fechas['fecha_id']]['usuarios'][$usuario['idUsuario']]['asistencias'][1]['latitud']) ? $asistencias[$fechas['fecha_id']]['usuarios'][$usuario['idUsuario']]['asistencias'][1]['latitud'] : '';
						$longitud1 = isset($asistencias[$fechas['fecha_id']]['usuarios'][$usuario['idUsuario']]['asistencias'][1]['longitud']) ? $asistencias[$fechas['fecha_id']]['usuarios'][$usuario['idUsuario']]['asistencias'][1]['longitud'] : '';
						$gps1 = ((empty($latitud1) || $latitud1 == 0 || empty($longitud1) || $longitud1 == 0)) ? '-' : '<a href="javascript:;" class="lk-show-gps1 a-fa" data-latitud="' . $latitud1 . '" data-longitud="' . $longitud1 . '" data-latitud-cliente="' . $latitud1 . '" data-longitud-cliente="' . $longitud1 . '" data-type="mapa" ><i class="fa fa-map-marker" ></i> <span>SI</span></a>';

						$foto1 = isset($asistencias[$fechas['fecha_id']]['usuarios'][$usuario['idUsuario']]['asistencias'][1]['foto']) ? $asistencias[$fechas['fecha_id']]['usuarios'][$usuario['idUsuario']]['asistencias'][1]['foto'] : '';
						$foto1 = !empty($foto1) ? '<a href="javascript:;" class="fotoMiniatura a-fa" data-idUsuario = "' . $usuario['idUsuario'] . '" data-fecha="' . $fechas['fecha'] . '" data-type="1" ><i class="fa fa-camera" ></i> <span>SI</span></a>' : '-';
						$comentario1 = isset($asistencias[$fechas['fecha_id']]['usuarios'][$usuario['idUsuario']]['asistencias'][1]['observacion']) ? $asistencias[$fechas['fecha_id']]['usuarios'][$usuario['idUsuario']]['asistencias'][1]['observacion'] : '-';
						?>
						<td class="text-center"><?= $hora1; ?></td>
						<td class="text-center"><?= $gps1; ?></td>
						<td class="text-center"><?= verificarEmpty($latitud1, 3); ?></td>
						<td class="text-center"><?= verificarEmpty($longitud1, 3); ?></td>
						<td class="text-center"><?= $foto1; ?></td>
						<td class="text-center"><?= $comentario1; ?></td>

						<?
						$hora3 = isset($asistencias[$fechas['fecha_id']]['usuarios'][$usuario['idUsuario']]['asistencias'][3]['hora']) ? $asistencias[$fechas['fecha_id']]['usuarios'][$usuario['idUsuario']]['asistencias'][3]['hora'] : '-';
						$latitud3 = isset($asistencias[$fechas['fecha_id']]['usuarios'][$usuario['idUsuario']]['asistencias'][3]['latitud']) ? $asistencias[$fechas['fecha_id']]['usuarios'][$usuario['idUsuario']]['asistencias'][3]['latitud'] : '';
						$longitud3 = isset($asistencias[$fechas['fecha_id']]['usuarios'][$usuario['idUsuario']]['asistencias'][3]['longitud']) ? $asistencias[$fechas['fecha_id']]['usuarios'][$usuario['idUsuario']]['asistencias'][3]['longitud'] : '';
						$gps3 = ((empty($latitud3) || $latitud3 == 0 || empty($longitud3) || $longitud3 == 0)) ? '-' : '<a href="javascript:;" class="lk-show-gps1 a-fa" data-latitud="' . $latitud3 . '" data-longitud="' . $longitud3 . '" data-latitud-cliente="' . $latitud3 . '" data-longitud-cliente="' . $longitud3 . '" data-type="mapa" ><i class="fa fa-map-marker" ></i> <span>SI</span></a>';

						$foto3 = isset($asistencias[$fechas['fecha_id']]['usuarios'][$usuario['idUsuario']]['asistencias'][3]['foto']) ? $asistencias[$fechas['fecha_id']]['usuarios'][$usuario['idUsuario']]['asistencias'][3]['foto'] : '';
						$foto3 = !empty($foto3) ? '<a href="javascript:;" class="fotoMiniatura a-fa" data-idUsuario = "' . $usuario['idUsuario'] . '" data-fecha="' . $fechas['fecha'] . '" data-type="3" ><i class="fa fa-camera" ></i> <span>SI</span></a>' : '-';
						$comentario3 = isset($asistencias[$fechas['fecha_id']]['usuarios'][$usuario['idUsuario']]['asistencias'][3]['observacion']) ? $asistencias[$fechas['fecha_id']]['usuarios'][$usuario['idUsuario']]['asistencias'][3]['observacion'] : '-';
						?>
						<td class="text-center"><?= $hora3; ?></td>
						<td class="text-center"><?= $gps3; ?></td>
						<td class="text-center"><?= verificarEmpty($latitud3, 3); ?></td>
						<td class="text-center"><?= verificarEmpty($longitud3, 3); ?></td>
						<td class="text-center"><?= $foto3; ?></td>
						<td class="text-center"><?= $comentario3; ?></td>

						<?
						$status = '';
						$status_nombre = '';
						$ocurrencia = '';

						if (!empty($usuario['feriado'])) {
							$status = 'Fe';
							$status_nombre = 'feriado';
						} else {
							if (!empty($usuario['vacaciones'])) {
								$status = 'V';
								$status_nombre = 'vacaciones';
							} else {
								if (!empty($usuario['ocurrencia'])) {
									$status = 'O';
									$status_nombre = 'ocurrencia';
									$ocurrencia = $usuario['ocurrencia'];
								}
							}
						}
						//
						$status_ing = isset($asistencias[$fechas['fecha_id']]['usuarios'][$usuario['idUsuario']]['asistencias'][1]) ? 1 : 0;
						$status_sal = isset($asistencias[$fechas['fecha_id']]['usuarios'][$usuario['idUsuario']]['asistencias'][3]) ? 1 : 0;

						if (empty($status)) {
							if (!empty($status_ing) && !empty($status_sal)) {
								$status = 'C';
								$status_nombre = 'completa';
							} elseif (!empty($status_ing) && empty($status_sal)) {
								$status = 'I';
								$status_nombre = 'incomp';
							} else {
								if (!empty($usuario['horarioIng']) && !empty($usuario['horarioSal'])) {$status = 'F'; $status_nombre = 'falta';}
								else{ $status = 'NL'; $status_nombre = 'No Laborable'; };
							}
						}
						//
						$status_filtro = $status;

						if (empty($status)) {
							$status = 'F <span class="color-F" ><i class="fa fa-circle" ></i></span>';
							$status_filtro = 'F';
							$status_nombre = 'Falta';
						} else {
							$status = ' <span class="color-' . $status . '" ><i class="fa fa-circle" ></i></span> ' . $status;
							$status .= !empty($ocurrencia) ? '<div style="font-size:0.8em">' . $ocurrencia . '</div>' : '';
						}
						?>
						<td class="text-center <?= $status_filtro; ?>"><?= $status; ?> <span class="d-none">  <?=$status_nombre?> </span> </td>
					</tr>
				<? endforeach ?>
			<? endforeach ?>
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