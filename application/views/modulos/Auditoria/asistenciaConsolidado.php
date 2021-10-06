	<table id="tb-asistenciaConsolidado" class="mb-0 table table-bordered text-nowrap">
		<thead>
		<tr>
		</tr>
			<tr>
				<th class="text-center align-middle" rowspan="2">#</th>
				<th class="text-center align-middle" rowspan="2">EMPRESA</th>
				<th class="text-center align-middle" rowspan="2">ZONA</th>
				<th class="text-center align-middle" rowspan="2">DISTRIBUIDORA</th>
				<th class="text-center align-middle" rowspan="2">CIUDAD</th>
				<th class="text-center align-middle" rowspan="2">CANAL</th>
				<th class="text-center align-middle" rowspan="2">CARGO</th>
				<th class="text-center align-middle" rowspan="2">ID EMPLEADO</th>
				<th class="text-center align-middle" rowspan="2">CODIGO<br>USUARIO</th>
				<th class="text-center align-middle" rowspan="2">DNI</th>
				<th class="text-center align-middle" rowspan="2">USUARIO</th>
				<th class="text-center align-middle" rowspan="2">CELULAR</th>
				<?foreach ($tiempo as $kt => $row): ?>
					<th class="text-center align-middle" colspan="<?=count($row['dias']);?>"><?=$row['mes']?></th>
				<?endforeach ?>
			</tr>
			<tr>
				<?foreach ($tiempo as $kt => $dias): ?>
					<?foreach ($dias['dias'] as $key => $dia): ?>
						<th class="text-center align-middle"><?=$dia['dia']?><br><?=$dia['fecha'];?></th>
					<?endforeach ?>
				<?endforeach ?>
			</tr>
		</thead>
		<tbody>
			<? $ix=1; ?>
			<?foreach ($listaUsuarios as $ku => $usuario): ?>
				<tr>
					<td><?=$ix++;?></td>
					<td><?=!empty($usuario['empresa'])?$usuario['empresa']:'-';?></td>
					<td>-</td>
					<td>-</td>
					<td><?=!empty($usuario['ciudad'])?$usuario['ciudad']:'-';?></td>
					<td><?=!empty($usuario['canal'])?$usuario['canal']:'-';?></td>
					<td>-</td>
					<td><?=!empty($usuario['idEmpleado'])?$usuario['idEmpleado']:'-';?></td>
					<td><?=!empty($usuario['idUsuario'])?$usuario['idUsuario']:'-';?></td>
					<td><?=!empty($usuario['numDocumento'])?$usuario['numDocumento']:'-';?></td>
					<td><?=!empty($usuario['usuario'])?$usuario['usuario']:'-';?></td>
					<td><?=!empty($usuario['movil'])?$usuario['movil']:'-';?></td>
					<?foreach ($tiempo as $kt => $dias): ?>
						<?foreach ($dias['dias'] as $ktd => $dia): ?>
							<?
								if ( isset($usuario['fechas'][$dia['fecha_id']] )) {
									$jornada = $usuario['fechas'][$dia['fecha_id']];

									$status = '';
									$ocurrencia = '';

									if ( !empty($jornada['feriado']) ) {
										$status = 'Fe';
									} else {
										if ( !empty($jornada['vacaciones']) ) {
											$status = 'V';
										} else {
											if ( !empty($jornada['ocurrencia']) ) {
												$status = 'O';
												$ocurrencia = $jornada['ocurrencia'];
											}
										}
									}
									//
									$status_ing = isset($asistencias[$jornada['fecha_id']]['usuarios'][$usuario['idUsuario']]['asistencias'][1]) ? 1 : 0;
									$status_sal = isset($asistencias[$jornada['fecha_id']]['usuarios'][$usuario['idUsuario']]['asistencias'][3]) ? 1 : 0;
									//
									if ( empty($status) ) {
										if(!empty($status_ing) && !empty($status_sal)){
											$status = 'C';
										} elseif (!empty($status_ing) && empty($status_sal) ) {
											$status = 'I';
										} else {
											if((!empty($jornada['horarioIng']) && !empty($jornada['horarioSal']))) $status = 'F';
											else $status = 'NL';
										}
									}

									if ( empty($status) ) {
										$status = 'F <span class="color-F" ><i class="fa fa-circle" ></i></span>';
									} else {
										$status = $status . ' <span class="color-'.$status.'" ><i class="fa fa-circle" ></i></span> ';
										$status .= !empty($ocurrencia)? '<div style="font-size:0.8em">'.$ocurrencia.'</div>' : '';
									}
							?>	
								<td class="text-center"><?=$status;?></td>
							<?	} else {	?>
									<td class="text-center"><span class="">NL <i class="fa fa-circle"></i></span></td>
							<?	} ?>							
						<?endforeach ?>
					<?endforeach ?>
				</tr>
			<?endforeach ?>
		</tbody>
	</table>