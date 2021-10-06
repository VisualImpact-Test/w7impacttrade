<div class="row">
	<div class="table-responsive col-md-12">
		<table id="tb-lsck-orden" class="table" style="white-space: normal;">
			<thead>
				<tr>
					<th>#</th>
					<th>Orden de Trabajo</th>
					<th>Responsable</th>
					<th>Status</th>
					<th title="Fecha de Respuesta">Fec. Respuesta</th>
					<th>Notificar</th>
					<th>¿Se solucionó?</th>
					<th>Observación</th>
				</tr>
			</thead>
			<tbody>
				<?$i = 1;?>
				<?foreach($data as $row){?>
				<?
					$respuesta = 'Pendiente';
					if( !empty($row['fecRespuesta']) ){
						$respuesta = 'Respondido';
					}
				?>
				<tr>
					<td><?=$i++?></td>
					<td><?=$row['ordenTrabajo']?></td>
					<td>
						<?
							if( !empty($responsable[$row['idAudClienteEvalPreg']]) ){
								foreach($responsable[$row['idAudClienteEvalPreg']] as $idResponsable => $v_responsable){
									echo "<li>{$v_responsable['nombre']}</li>";
								}
							}
						?>
					</td>
					<td><?=$respuesta?></td>
					<td class="text-center"><?=( !empty($row['fecRespuesta']) ? $row['fecRespuesta'] : '-' )?></td>
					<td class="text-center">
						<input
							type="checkbox"
							name="chk-lsck-orden-notificar"
							class="chk-lsck-orden-notificar pointer"
							value="<?=$row['idAudClienteEvalPreg']?>"
							style="width: 20px; height: 20px;"
							<?=( $respuesta == 'Respondido' ? 'disabled' : '' )?>
						>
					</td>
					<td class="text-center" >
						<?
							if( is_null($row['fecRespuesta']) ) echo '-';
							else if( $row['status'] == 0 ) echo 'No';
							else if( $row['status'] == 1 ) echo 'Si';
						?>
					</td>
					<td class="<?=( empty($row['observacion']) ? 'text-center' : '' )?>" ><?=( !empty($row['observacion']) ? $row['observacion'] : '-' )?></td>
				</tr>
				<?}?>
			</tbody>
		</table>
	</div>
</div>