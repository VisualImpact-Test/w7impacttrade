		<div class="card-datatable">
		<table id="tb-contingenciaAsistenciaDetalle" class="table table-striped table-bordered nowrap w-100">
			<thead>
				<tr>
					<!--th class="text-center align-middle" rowspan="2">#</th-->
					<th class="text-center align-middle" rowspan="2">PROYECTO</th>
					<th class="text-center align-middle" rowspan="2">GRUPO<br>CANAL</th>
					<th class="text-center align-middle" rowspan="2">CANAL</th>
					<!--th class="text-center align-middle" rowspan="2">ENCARGADO</th-->
					<th class="text-center align-middle" rowspan="2">DEPARTAMENTO</th>
					<th class="text-center align-middle" rowspan="2">PERFIL</th>
					<th class="text-center align-middle" rowspan="2">IDENTIFICADOR</th>
					<!--th class="text-center align-middle" rowspan="2">COD USUARIO</th-->
					<th class="text-center align-middle" rowspan="2">DNI</th>
					<th class="text-center align-middle" rowspan="2">EMPLEADO</th>
					<th class="text-center align-middle" rowspan="2">MOVIL<br>ASIGNADO</th>
					<th class="text-center align-middle" rowspan="2">HORARIO</th>
					<? foreach ($tipoAsistencias as $kta => $asistencia): ?>
						<th class="text-center align-middle text-uppercase" colspan="3"><?=$asistencia['asistencia'];?></th>
					<? endforeach ?>
					<th class="text-center align-middle" rowspan="2">REGISTRAR<br>ASISTENCIA</th>
				</tr>
				<tr>
					<? foreach ($tipoAsistencias as $kta => $asistencia): ?>
						<th class="text-center">HORA</th>
						<th class="text-center">MOTIVO</th>
						<th class="text-center">MEDIO</th>
						<!--th class="text-center align-middle">OPCIONES</th-->
					<? endforeach ?>
				</tr>
			</thead>
			<tbody>
				<? $ix=1; ?>
				<?foreach ($listaUsuarios as $ku => $usuario): ?>
					<tr>
						<!--td class="text-center"><?//=$ix++;?></td-->
						<td class=""><?=!empty($usuario['proyecto']) ? $usuario['proyecto']:'-';?></td>
						<td class=""><?=!empty($usuario['grupoCanal']) ? $usuario['grupoCanal']:'-';?></td>
						<td class=""><?=!empty($usuario['canal']) ? $usuario['canal']:'-';?></td>
						<!--td class="text-center text-uppercase"><?//=!empty($usuario['encargado']) ? $usuario['encargado']:'-';?></td-->
						<td class="text-center"><?=!empty($usuario['departamento']) ? $usuario['departamento']:'-';?></td>
						<td class=""><?=!empty($usuario['perfil']) ? $usuario['perfil']:'-';?></td>
						<td class="text-center"><?=!empty($usuario['codEmpleado']) ? $usuario['codEmpleado']:'-';?></td>
						<!--td class="text-center"><?//=!empty($usuario['codUsuario']) ? $usuario['codUsuario']:'-';?></td-->
						<td class="text-center"><?=!empty($usuario['dni']) ? $usuario['dni']:'-';?></td>
						<td class="text-uppercase"><?=!empty($usuario['nombreUsuario']) ? $usuario['nombreUsuario']:'-';?></td>
						<td class="text-center"><?=!empty($usuario['movil']) ? $usuario['movil']:'-';?></td>
						<td class="text-center"><?=!empty($usuario['horarioIng']) ? '<strong>I: </strong>'.$usuario['horarioIng'].'<br><strong>S: </strong>'.$usuario['horarioSal']:'-';?></td>

						<? $tdClassButton='disabled'; ?>
						<? foreach ($tipoAsistencias as $kta => $asistencia): ?>
							<? if ( isset($tipoAsistenciasUsuarios[$usuario['idCuenta']]['proyectos'][$usuario['idProyecto']]['tipoUsuarios'][$usuario['idTipoUsuario']]['tipoAsistencias'][$kta] ) ): ?>
								<? if ( isset($usuario['tipoAsistencias'][$kta])): ?>
									<td class="text-center"><?=$usuario['tipoAsistencias'][$kta]['hora'];?></td>
									<td class="text-center"><?=empty($usuario['tipoAsistencias'][$kta]['idOcurrencia'])?'NORMAL':$usuario['tipoAsistencias'][$kta]['ocurrencia'];?></td>
									<td class="text-center"><?=($usuario['tipoAsistencias'][$kta]['flagContingencia']==0) ? 'MOVIL' : 'WEB';?></td>
								<? else: ?>
									<? $tdClassButton=''; ?>
									<td id="tdHora-<?=$usuario['codUsuario']?>-<?=$kta?>" class="text-center ">
										<input class="form-control hora ipUsuarioHora-<?=$usuario['codUsuario']?>" type="time" name="hora-<?=$usuario['codUsuario']?>-<?=$kta?>" data-tipoAsistencia="<?=$kta?>" min="9:00" max="18:00">
									</td>
									<td id="tdSlocurrencias-<?=$usuario['codUsuario']?>-<?=$kta?>" class="text-center">
										<select class="form-control form-control-sm my_select2Full opcionestd" name="sl-ocurrencias-<?=$usuario['codUsuario']?>-<?=$kta?>" title="Ocurrencias (Todo)" data-actions-box="true" data-live-search="true" >
											<option value="" class="label label-success" >Ocurrencias (Todo)</option>
											<?foreach ($listaOcurrencias as $ko => $ocurrencia): ?>
												<option value="<?=$ocurrencia['idOcurrencia']?>"><?=$ocurrencia['ocurrencia']?></option>
											<?endforeach ?>
										</select>
									</td>
									<td id="tdMedio-<?=$usuario['codUsuario']?>-<?=$kta?>" class="text-center">-</td>
								<? endif ?>
							<? else: ?>
								<td class="text-center tdBloqueado">-</td>
								<td class="text-center tdBloqueado">-</td>
								<td class="text-center tdBloqueado">-</td>
							<? endif ?>
						<? endforeach ?>
						<td id="tdButton-<?=$usuario['codUsuario']?>-<?=$kta?>" class="text-center">
							<button type="button" class="btn border-0 btn-outline-danger <?=$tdClassButton;?> saveUsuarioAsistencia" data-usuario="<?=$usuario['codUsuario'];?>" data-nombreUsuario="<?=$usuario['nombreUsuario']?>" data-fecha="<?=$usuario['fecha']?>" data-tipoUsuario="<?=$usuario['idTipoUsuario']?>" data-perfil="<?=$usuario['perfil']?>" data-numDocumento="<?=$usuario['dni']?>" title="REGISTRAR ASISTENCIA INDIVIDUAL" <?=$tdClassButton;?>><i class="fas fa-upload fa-lg"></i></button>
						</td>					
					</tr>
				<?endforeach ?>
			</tbody>
		</table>
		</div>
	<script>
		$('#btn-saveContingenciaAsistencia').parent().removeClass('hide');
	</script>