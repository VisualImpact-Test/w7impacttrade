<div class="card-datatable">
<table id="tb-iniciativasConsolidadoCobertura" class="mb-0 table table-bordered table-sm text-nowrap" width="100%">
	<thead>
		<tr>
			<th class="text-center align-middle" rowspan="2">#</th>
			<th class="text-center align-middle" rowspan="2">SUPERVISOR</th>
			<th class="text-center align-middle" rowspan="2">GTM</th>
			<th class="text-center align-middle" rowspan="2">VISITAS<br>PROGRAMADAS (VP)</th>
			<th class="text-center align-middle" colspan="4">VISITAS</th>
			<th class="text-center align-middle" rowspan="2">VISITAS<br>INICIATIVAS<br>EFECTIVAS (VIE)</th>
			<th class="text-center align-middle" rowspan="2">%<br>FORMULA<br>(VIE/VP)</th>
		</tr>
		<tr>
			<th class="text-center align-middle">INICIADAS</th>
			<th class="text-center align-middle">REALIZADAS</th>
			<th class="text-center align-middle">NO REALIZADAS</th>
			<th class="text-center align-middle">CON INCIDENCIA</th>
		</tr>
	</thead>
	<tbody>
		<? $ix=1; ?>
		<? foreach ($listaVisitasConsolidado as $klc => $row): ?>
			<tr>
				<td class="text-center"><?=$ix++;?></td>
				<td class=""><?=(!empty($row['usuarioSupervisor'])?$row['usuarioSupervisor']:'-')?></td>
				<td class=""><?=(!empty($row['nombreUsuario'])?$row['nombreUsuario']:'-')?></td>
				<?
					$totalVisitas = !empty($row['total_visitas']) ? $row['total_visitas'] : '';
					if ( !empty($totalVisitas)) {
						$totalVisitas = '<a href="javascript:;" class="visitasDetallado" data-title="VISITAS PROGRAMADAS" data-supervisor="'.$row['idUsuarioSupervisor'].'" data-usuario="'.$row['idUsuario'].'" data-tipoVisita="visitasProgramadas">'.$totalVisitas.'</a>';
					}
				?>
				<td class="text-center"><?=(!empty($totalVisitas)?$totalVisitas:'-')?></td>
				<?
					$sumaVisitasIniciadas = !empty($row['suma_visitas_iniciadas']) ? $row['suma_visitas_iniciadas'] : '';
					if ( !empty($sumaVisitasIniciadas)) {
						$sumaVisitasIniciadas = '<a href="javascript:;" class="visitasDetallado" data-title="VISITAS INICIADAS" data-supervisor="'.$row['idUsuarioSupervisor'].'" data-usuario="'.$row['idUsuario'].'"  data-tipoVisita="visitasIniciadas">'.$sumaVisitasIniciadas.'</a>';
					}
				?>
				<td class="text-center"><?=(!empty($sumaVisitasIniciadas)?$sumaVisitasIniciadas:'-')?></td>
				<?
					$sumaVisitasFinalizadas = !empty($row['suma_visitas_finalizadas']) ? $row['suma_visitas_finalizadas'] : '';
					if ( !empty($sumaVisitasFinalizadas)) {
						$sumaVisitasFinalizadas = '<a href="javascript:;" class="visitasDetallado" data-title="VISITAS REALIZADAS" data-supervisor="'.$row['idUsuarioSupervisor'].'" data-usuario="'.$row['idUsuario'].'" data-tipoVisita="visitasRealizadas">'.$sumaVisitasFinalizadas.'</a>';
					}
				?>
				<td class="text-center"><?=(!empty($sumaVisitasFinalizadas)?$sumaVisitasFinalizadas:'-')?></td>
				<?
					$sumaVisitasNoFinalizadas = !empty($row['suma_visitas_no_finalizadas']) ? $row['suma_visitas_no_finalizadas'] : '';
					if ( !empty($sumaVisitasNoFinalizadas)) {
						$sumaVisitasNoFinalizadas = '<a href="javascript:;" class="visitasDetallado" data-title="VISITAS NO REALIZADAS" data-supervisor="'.$row['idUsuarioSupervisor'].'" data-usuario="'.$row['idUsuario'].'" data-tipoVisita="visitasNoRealizadas">'.$sumaVisitasNoFinalizadas.'</a>';
					}
				?>
				<td class="text-center"><?=(!empty($sumaVisitasNoFinalizadas)?$sumaVisitasNoFinalizadas:'-')?></td>
				<?
					$sumaVisitasIncidencia = !empty($row['total_visitas_incidencia']) ? $row['total_visitas_incidencia'] : '';
					if ( !empty($sumaVisitasIncidencia)) {
						$sumaVisitasIncidencia = '<a href="javascript:;" class="visitasDetallado"  data-title="VISITAS CON INCIDENCIA" data-supervisor="'.$row['idUsuarioSupervisor'].'" data-usuario="'.$row['idUsuario'].'" data-tipoVisita="visitasConIncidencia">'.$sumaVisitasIncidencia.'</a>';
					}
				?>
				<td class="text-center"><?=(!empty($sumaVisitasIncidencia)?$sumaVisitasIncidencia:'-')?></td>
				<?
					$sumaVisitasIniciativas = !empty($row['suma_visitas_iniciativas']) ? $row['suma_visitas_iniciativas'] : '';
					if ( !empty($sumaVisitasIniciativas)) {
						$sumaVisitasIniciativas = '<a href="javascript:;" class="visitasDetallado"  data-title="VISITAS INICIATIVAS EFECTIVAS" data-supervisor="'.$row['idUsuarioSupervisor'].'" data-usuario="'.$row['idUsuario'].'" data-tipoVisita="visitasIniciativas">'.$sumaVisitasIniciativas.'</a>';
					}
				?>
				<td class="text-center"><?=(!empty($sumaVisitasIniciativas)?$sumaVisitasIniciativas:'-')?></td>
				<?
					$porcentajeFormula= '';
					$totalVisitas = !empty($row['total_visitas']) ? $row['total_visitas'] : '';
					$totalVisitasIniciativas = !empty($row['suma_visitas_iniciativas']) ? $row['suma_visitas_iniciativas']:'';
					if ( !empty($totalVisitasIniciativas) && !empty($totalVisitas)) {
						$porcentajeFormula = round(( $totalVisitasIniciativas/$totalVisitas )*100, 2);
					}

					$tdBackgroundColor = ( $porcentajeFormula==100 ? 'tdSuccess':'tdNoSuccess' );
				?>
				<td class="text-center <?=$tdBackgroundColor?>"><?=(!empty($porcentajeFormula)?$porcentajeFormula.' %':'-')?></td>
			</tr>
		<? endforeach ?>
	</tbody>
</table>
</div>