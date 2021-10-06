	<table id="tb-rutasGeneral" class="mb-0 table table-bordered text-nowrap">
		<thead>
			<tr>
				<th class="text-center align-middle" rowspan="2">OPCIONES</th>
				<th class="text-center align-middle" colspan="2">VISITAS</th>
			</tr>
			<tr>
				<th class="text-center align-middle">N°</th>
				<th class="text-center align-middle">%</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="text-center"><strong>UNIVERSO DE VISITAS</strong></td>
				<td class="text-center" colspan="2"><strong><?=$contRsVisitas;?></strong></td>
			</tr>
			<tr>
				<td class="text-center">VISITAS EFECTIVAS</td>
				<td class="text-center"><?=!empty($universoVisitas['valueEF'])?$universoVisitas['valueEF']:0;?></td>
				<td class="text-center"><?=($contRsVisitas>0)? ( !empty($universoVisitas['valueEF']) ? round(($universoVisitas['valueEF']/$contRsVisitas)*100,2).' %' : '0 %' ) : '-';?></td>
			</tr>
			<tr>
				<td class="text-center">VISITAS NO EFECTIVAS</td>
				<td class="text-center"><?=!empty($universoVisitas['valueNE'])?$universoVisitas['valueNE']:0;?></td>
				<td class="text-center"><?=($contRsVisitas>0)? ( !empty($universoVisitas['valueNE']) ? round(($universoVisitas['valueNE']/$contRsVisitas)*100,2).' %' : '0 %' ) : '-';?></td>
			</tr>
			<tr>
				<td class="text-center">VISITAS INCIDENCIA</td>
				<td class="text-center"><?=!empty($universoVisitas['valueIN'])?$universoVisitas['valueIN']:0;?></td>
				<td class="text-center"><?=($contRsVisitas>0)? ( !empty($universoVisitas['valueIN']) ? round(($universoVisitas['valueIN']/$contRsVisitas)*100,2).' %' : '0 %' ) : '-';?></td>
			</tr>
			<tr>
				<td class="text-center">VISITAS NO REALIZADAS</td>
				<td class="text-center"><?=!empty($universoVisitas['valueSV'])?$universoVisitas['valueSV']:0;?></td>
				<td class="text-center"><?=($contRsVisitas>0)? ( !empty($universoVisitas['valueSV']) ? round(($universoVisitas['valueSV']/$contRsVisitas)*100,2).' %' : '0 %' ) : '-';?></td>
			</tr>
		</tbody>
	</table>