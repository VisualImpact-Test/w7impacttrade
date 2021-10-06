<h5>FRECUENCIA DE DESPACHOS</h5>
<div class="table-responsive">
	<table class="mb-0 table table-bordered table-sm text-nowrap">
		<tbody>
			<? $i=1; foreach($despachos as $ix_d => $row_d){ ?>
				<tr>
					<td class="tdLabel">PLACA</td>
					<td><?=!empty($row_d['placa'])? $row_d['placa'] : '-'?></td>
				</tr>
				<tr>
					<td class="tdLabel">HORARIO</td>
					<td><?=( !empty($row_d['horaIni']) || !empty($row_d['horaFin'])   )? $row_d['horaIni'].' - '.$row_d['horaFin'] : '-'?></td>
				</tr>
				<tr>
					<td class="tdLabel-1" colspan="2">FRECUENCIA</td>
				</tr>
				<tr>
					<td colspan="2"  class="text-center" >
						<?foreach($despachos_det[$ix_d] as $row){?>
							<?=$row['diaDespacho']?>
						<?}?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel">INDICENDIA</td>
					<td><?=!empty($row_d['incidencia'])? $row_d['incidencia'] : '-'?></td>
				</tr>
				<tr>
					<td class="tdLabel">COMENTARIO</td>
					<td><?=!empty($row_d['comentario'])? $row_d['comentario'] : '-'?></td>
				</tr>
			<? } ?>
		</tbody>
	</table>
</div>