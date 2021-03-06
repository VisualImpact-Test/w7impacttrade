<style>
	.cartera1,
	.cartera2,
	.visita1 {
		display: none;
		text-align: center;
	}

	th,
	td {
		vertical-align: middle !important;
	}
</style>

<div class="card-datatable" style="overflow-x: auto;">
	<table id="tb-scorecard" class="mb-0 table table-bordered text-nowrap" width="100%">
		<thead>
			<tr>
				<th colspan="3" style="text-align:center;">CARTERA DEL <?= $fecIni ?> AL <?= $fecFin ?></th>
				<th rowspan="2" style="text-align:center;" class="cartera1" title="Clientes objetivo para el ultimo mes en consulta.">CARTERA <br> OBJ.</th>
				<th rowspan="2" style="text-align:center;" class="cartera1" title="( CARTERA OBJETIVO POR SUBCANAL / TOTAL ) %">CARTERA OBJETIVO <br> POR SUBCANAL / <br> TOTAL</th>
				<th rowspan="2" style="text-align:center;" class="cartera1" title="Clientes obtenidos de Base Madre.">CARTERA <br> ACT.</th>
				<th rowspan="2" style="text-align:center;" class="cartera1" title="( CARTERA ACTUAL POR SUBCANAL / TOTAL ) %">CARTERA ACTUAL <br>POR SUBCANAL / <br>TOTAL</th>
				<th rowspan="2" style="text-align:center;" title="( CARTERA ACT. / CARTERA OBJ. ) %">CARTERA ACT. <br>/ CARTERA <br>OBJ. <br>
					<i class="fas fa-plus-circle mostrar-cartera1" style="cursor:pointer;"></i>
					<i class="fas fa-minus-circle ocultar-cartera1" style="display:none;cursor:pointer;"></i>
				</th>

				<th rowspan="2" style="text-align:center;" class="cartera2" title="Clientes considerados decuerdo a su frecuencia de visita al mes.">CARTERA PLANEADA</th>
				<th rowspan="2" style="text-align:center;" class="cartera2" title="Suma de los POS que tengan frecuencia mensual no coberturado en el rango seleccionado.">MENSUAL</th>
				<th rowspan="2" style="text-align:center;" class="cartera2" title="Clientes de la cartera actual con todas las visitas excluidas.">EXCLUSION</th>
				<th rowspan="2" style="text-align:center;" class="cartera2" title="Formula [Cartera Planeada] - ([Mensual]+[Exclusión])">CARTERA HABIL</th>
				<th rowspan="2" style="text-align:center;" class="cartera2" title="Clientes de la cartera actual con minimo una visita efectiva.">COBERTURA</th>
				<th rowspan="2" style="text-align:center;" title="( CARTERA ACT. / COBERTURA ) %">COBERTURA/ CARTERA HABIL <br>
					<i class="fas fa-plus-circle mostrar-cartera2" style="cursor:pointer;"></i>
					<i class="fas fa-minus-circle ocultar-cartera2" style="display:none;cursor:pointer;"></i>
				</th>

				<th class="visita-cabecera" style="text-align:center;">VISITAS</th>
			</tr>
			<tr>
				<th style="text-align:center;">GRUPO CANAL</th>
				<th style="text-align:center;">CANAL</th>
				<th style="text-align:center;">SUBCANAL</th>

				<th class="visita1" title="Visitas planeadas de acuerdo a la frecuencia de visita al mes.">VISITAS <br>PLANEADAS <br> CARTERA ACT</th>
				<th class="visita1">VISITAS <br>PROGRAMADAS</th>
				<th class="visita1">VISITAS <br>EXCLUIDAS</th>
				<th class="visita1" title="Todas las visitas programadas que no estan incluidas en las excluidas.">VISITAS<br> HABILES</th>
				<th class="visita1">VISITAS<br> EFECTIVAS</th>
				<th class="visita1">VISITAS NO<br> EFECTIVAS</th>
				<th class="visita1">INCIDENCIAS </th>
				<th style="text-align:center;" title="( Visitas Efectivas / Visitas Habiles ) %">VISITAS EFECTIVAS /<br> VISITAS HABILES
					<i class="fas fa-plus-circle mostrar-visita1" style="cursor:pointer;"></i>
					<i class="fas fa-minus-circle ocultar-visita1" style="display:none;cursor:pointer;"></i>
				</th>


			</tr>
		</thead>
		<tbody>
			<? $total_cartera_planeada = 0; ?>
			<? $total_cartera_mensual = 0; ?>
			<? $total_cartera_exclusion = 0; ?>
			<? $total_cartera_habil = 0; ?>
			<? $total_cartera_cobertura = 0; ?>

			<? $total_visita_planeada = 0; ?>
			<? $total_visita_programada = 0; ?>
			<? $total_visita_excluida = 0; ?>
			<? $total_visita_habiles = 0; ?>
			<? $total_visita_efectivas = 0; ?>
			<? $total_visita_no_efectivas = 0; ?>
			<? $total_visita_incidencias = 0; ?>

			<? foreach ($grupoCanal as $row => $value) {
				$i = 1; ?>
				<? foreach ($canal[$row] as $row_c => $value_c) {
					$j = 1; ?>
					<? foreach ($subcanal[$row][$row_c] as $row_s => $value_s) { ?>
						<? $style = "";
						if ($i % 2 != 0) $style = ""; ?>
						<? if ($i == 1 && $j == 1) { ?>

							<tr> 
								<td style="" rowspan="<?= $value['rowspan']; ?>"><?= $value['nombre'] ?></td>
								<td style="" rowspan="<?= $value_c['rowspan']; ?>"><?= $value_c['nombre'] ?></td>
								<td style=""><?= $value_s['nombre'] ?></td>
								<?
								$carteraObj = isset($carteraObjetivo[$row_c][$row_s]) ? $carteraObjetivo[$row_c][$row_s] : '0';
								$carteraAct = isset($cartera[$row_c][$row_s]) ? $cartera[$row_c][$row_s] : '0';

								$carteraObjPor = ($carteraObj > 0 && $carteraTotalObjetivo > 0) ? ROUND($carteraObj / $carteraTotalObjetivo * 100, 2) : 0;
								$carteraActPor = ($carteraAct > 0 && $carteraTotal > 0) ? ROUND($carteraAct / $carteraTotal * 100, 2) : 0;

								$carteraAct_carteraObj = ($carteraAct > 0 && $carteraObj > 0) ? ROUND($carteraAct / $carteraObj * 100, 2) : 0;
								?>
								<td class="cartera1"><?= $carteraObj ?></td>
								<td class="cartera1"><?= $carteraObjPor . '%' ?></td>
								<td class="cartera1">
									<?= ($carteraAct > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_cartera" data-title="Cartera Activa" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="" >' . $carteraAct . '</a>' : 0 ?>
								</td>
								<td class="cartera1"><?= $carteraActPor . '%' ?></td>
								<td style="text-align:center;"><?= $carteraAct_carteraObj . '%' ?></td>

								<?
								$carteraPlan = isset($carteraPlaneada[$row_c][$row_s]) ? $carteraPlaneada[$row_c][$row_s] : '0';
								$carteraExcl = isset($carteraExclusion[$row_c][$row_s]) ? $carteraExclusion[$row_c][$row_s] : '0';
								$carteraCobe = isset($carteraCobertura[$row_c][$row_s]) ? $carteraCobertura[$row_c][$row_s] : '0';

								$mensual =  $carteraPlan - ($carteraExcl + $carteraCobe) ;
								$carteraHabil = $carteraPlan - ($carteraExcl + $mensual);

								$porcentaje = ($carteraHabil > 0) ? ROUND($carteraCobe / $carteraHabil * 100, 2) : 0;

								$total_cartera_planeada = $total_cartera_planeada + $carteraPlan;
								$total_cartera_mensual = $total_cartera_mensual + $mensual;
								$total_cartera_exclusion = $total_cartera_exclusion + $carteraExcl;
								$total_cartera_habil = $total_cartera_habil + $carteraHabil;
								$total_cartera_cobertura = $total_cartera_cobertura + $carteraCobe;
								?>

								<td class="cartera2"><?= $carteraPlan ?></td> <!-- AQUI ESTOY -->
								<td class="cartera2"><?= ($mensual >= 0) ? $mensual : '0' ?></td>
								<td class="cartera2">
									<?= ($carteraExcl > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_cartera" data-title="Exclusiones" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="EXCLUSION" >' . $carteraExcl . '</a>' : 0 ?>
								</td>
								<td class="cartera2"><?= $carteraHabil ?></td>
								<td class="cartera2">
									<?= ($carteraCobe > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_cartera" data-title="Exclusiones" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="EFECTIVA" data-cod-clientes="'.implode(",",$vcliente_efectiva[$row_c][$row_s]).'">' . $carteraCobe . '</a>' : 0 ?>
								</td>
								<td style="text-align:center;"><?= $porcentaje . '%' ?></td>

								<?
								$visitaProg = isset($visitaProgramada[$row_c][$row_s]) ? $visitaProgramada[$row_c][$row_s] : '0';
								$visitaExclu = isset($visitaExclusion[$row_c][$row_s]) ? $visitaExclusion[$row_c][$row_s] : '0';
								$visitaEfec = isset($visitaEfectiva[$row_c][$row_s]) ? $visitaEfectiva[$row_c][$row_s] : '0';
								$visitaNoEfec = isset($visitaNoEfectiva[$row_c][$row_s]) ? $visitaNoEfectiva[$row_c][$row_s] : '0';
								$visitaInci = isset($visitaIncidencia[$row_c][$row_s]) ? $visitaIncidencia[$row_c][$row_s] : '0';
								$visitaHabiles = $visitaProg - $visitaExclu;
								$porcentaje = ($visitaHabiles > 0) ? ROUND($visitaEfec / $visitaHabiles * 100, 2) : 0;

								$total_visita_planeada = $total_visita_planeada + $carteraPlan;
								$total_visita_programada = $total_visita_programada + $visitaProg;
								$total_visita_excluida = $total_visita_excluida + $visitaExclu;
								$total_visita_habiles = $total_visita_habiles + $visitaHabiles;
								$total_visita_efectivas = $total_visita_efectivas + $visitaEfec;
								$total_visita_no_efectivas = $total_visita_no_efectivas + $visitaNoEfec;
								$total_visita_incidencias = $total_visita_incidencias + $visitaInci;
								?>

								<td class="visita1"><?= $carteraPlan ?></td>
								<td class="visita1">
									<?= ($visitaProg > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_visita" data-title="Visitas Programadas" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="" data-cod-visitas="'.implode(",",$vruta_programada[$row_c][$row_s]).'">' . $visitaProg . '</a>' : 0 ?>
								</td>
								<td class="visita1">
									<?= ($visitaExclu > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_visita" data-title="Visitas EXcluidas" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="EXCLUIDAS" data-cod-visitas="'.implode(",",$vruta_excluida[$row_c][$row_s]).'">' . $visitaExclu . '</a>' : 0 ?>
								</td>
								<td class="visita1">
									<?= ($visitaHabiles > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_visita" data-title="Visitas Habiles" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="HABILES" data-cod-visitas="'.implode(",",$vruta_habiles[$row_c][$row_s]).'">' . $visitaHabiles  . '</a>' : 0 ?>
								</td>
								<td class="visita1">
									<?= ($visitaEfec > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_visita" data-title="Visitas Habiles" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="EFECTIVA" data-cod-visitas="'.implode(",",$vruta_efectiva[$row_c][$row_s]).'">' . $visitaEfec  . '</a>' : 0 ?>
								</td>
								<td class="visita1">
									<?= ($visitaNoEfec > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_visita" data-title="Visitas Habiles" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="NO EFECTIVA" data-cod-visitas="'.implode(",",$vruta_noefectiva[$row_c][$row_s]).'">' . $visitaNoEfec  . '</a>' : 0 ?>
								</td>
								<td class="visita1">
									<?= ($visitaInci > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_visita" data-title="INCIDENCIA" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="INCIDENCIA" data-cod-visitas="'.implode(",",$vruta_incidencia[$row_c][$row_s]).'">' . $visitaInci  . '</a>' : 0 ?>
								</td>
								<td style="text-align:center;"><?= $porcentaje . '%' ?></td>

							</tr>
						<? } elseif ($i != 1 && $j == 1) { ?>
							<tr>
								<td style="" rowspan="<?= $value_c['rowspan']; ?>"><?= $value_c['nombre'] ?></td>
								<td style=""><?= $value_s['nombre'] ?></td>
								<?
								$carteraObj = isset($carteraObjetivo[$row_c][$row_s]) ? $carteraObjetivo[$row_c][$row_s] : '0';
								$carteraAct = isset($cartera[$row_c][$row_s]) ? $cartera[$row_c][$row_s] : '0';

								$carteraObjPor = ($carteraObj > 0 && $carteraTotalObjetivo > 0) ? ROUND($carteraObj / $carteraTotalObjetivo * 100, 2) : 0;
								$carteraActPor = ($carteraAct > 0 && $carteraTotal > 0) ? ROUND($carteraAct / $carteraTotal * 100, 2) : 0;

								$carteraAct_carteraObj = ($carteraAct > 0 && $carteraObj > 0) ? ROUND($carteraAct / $carteraObj * 100, 2) : 0;
								?>
								<td class="cartera1"><?= $carteraObj ?></td>
								<td class="cartera1"><?= $carteraObjPor . '%' ?></td>
								<td class="cartera1">
									<?= ($carteraAct > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_cartera" data-title="Cartera Activa" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="" >' . $carteraAct . '</a>' : 0 ?>
								</td>
								<td class="cartera1"><?= $carteraActPor . '%' ?></td>
								<td style="text-align:center;"><?= $carteraAct_carteraObj . '%' ?></td>

								<?
								$carteraPlan = isset($carteraPlaneada[$row_c][$row_s]) ? $carteraPlaneada[$row_c][$row_s] : '0';
								$carteraExcl = isset($carteraExclusion[$row_c][$row_s]) ? $carteraExclusion[$row_c][$row_s] : '0';
								$carteraCobe = isset($carteraCobertura[$row_c][$row_s]) ? $carteraCobertura[$row_c][$row_s] : '0';

								$mensual =  $carteraPlan - ($carteraExcl + $carteraCobe) ;
								$carteraHabil = $carteraPlan - ($carteraExcl + $mensual);

								$porcentaje = ($carteraHabil > 0) ? ROUND($carteraCobe / $carteraHabil * 100, 2) : 0;

								$total_cartera_planeada = $total_cartera_planeada + $carteraPlan;
								$total_cartera_mensual = $total_cartera_mensual + $mensual;
								$total_cartera_exclusion = $total_cartera_exclusion + $carteraExcl;
								$total_cartera_habil = $total_cartera_habil + $carteraHabil;
								$total_cartera_cobertura = $total_cartera_cobertura + $carteraCobe;
								?>

								<td class="cartera2"><?= $carteraPlan ?></td>
								<td class="cartera2"><?= ($mensual >= 0) ? $mensual : '0' ?></td>
								<td class="cartera2">
									<?= ($carteraExcl > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_cartera" data-title="Exclusiones" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="EXCLUSION">' . $carteraExcl . '</a>' : 0 ?>
								</td>
								<td class="cartera2"><?= $carteraHabil ?></td>
								<td class="cartera2">
									<?= ($carteraCobe > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_cartera" data-title="Exclusiones" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="EFECTIVA" data-cod-clientes="'.implode(",",$vcliente_efectiva[$row_c][$row_s]).'">' . $carteraCobe . '</a>' : 0 ?>
								</td>
								<td style="text-align:center;"><?= $porcentaje . '%' ?></td>

								<?
								$visitaProg = isset($visitaProgramada[$row_c][$row_s]) ? $visitaProgramada[$row_c][$row_s] : '0';
								$visitaExclu = isset($visitaExclusion[$row_c][$row_s]) ? $visitaExclusion[$row_c][$row_s] : '0';
								$visitaEfec = isset($visitaEfectiva[$row_c][$row_s]) ? $visitaEfectiva[$row_c][$row_s] : '0';
								$visitaNoEfec = isset($visitaNoEfectiva[$row_c][$row_s]) ? $visitaNoEfectiva[$row_c][$row_s] : '0';
								$visitaInci = isset($visitaIncidencia[$row_c][$row_s]) ? $visitaIncidencia[$row_c][$row_s] : '0';
								$visitaHabiles = $visitaProg - $visitaExclu;
								$porcentaje = ($visitaHabiles > 0) ? ROUND($visitaEfec / $visitaHabiles * 100, 2) : 0;

								$total_visita_planeada = $total_visita_planeada + $carteraPlan;
								$total_visita_programada = $total_visita_programada + $visitaProg;
								$total_visita_excluida = $total_visita_excluida + $visitaExclu;
								$total_visita_habiles = $total_visita_habiles + $visitaHabiles;
								$total_visita_efectivas = $total_visita_efectivas + $visitaEfec;
								$total_visita_no_efectivas = $total_visita_no_efectivas + $visitaNoEfec;
								$total_visita_incidencias = $total_visita_incidencias + $visitaInci;
								?>

								<td class="visita1"><?= $carteraPlan ?></td>
								<td class="visita1">
									<?= ($visitaProg > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_visita" data-title="Visitas Programadas" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="" data-cod-visitas="'.implode(",",$vruta_programada[$row_c][$row_s]).'">' . $visitaProg . '</a>' : 0 ?>
								</td>
								<td class="visita1">
									<?= ($visitaExclu > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_visita" data-title="Visitas EXcluidas" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="EXCLUIDAS" data-cod-visitas="'.implode(",",$vruta_excluida[$row_c][$row_s]).'">' . $visitaExclu . '</a>' : 0 ?>
								</td>
								<td class="visita1">
									<?= ($visitaHabiles > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_visita" data-title="Visitas Habiles" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="HABILES" data-cod-visitas="'.implode(",",$vruta_habiles[$row_c][$row_s]).'">' . $visitaHabiles  . '</a>' : 0 ?>
								</td>
								<td class="visita1">
									<?= ($visitaEfec > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_visita" data-title="Visitas Habiles" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="EFECTIVA" data-cod-visitas="'.implode(",",$vruta_efectiva[$row_c][$row_s]).'">' . $visitaEfec  . '</a>' : 0 ?>
								</td>
								<td class="visita1">
									<?= ($visitaNoEfec > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_visita" data-title="Visitas Habiles" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="NO EFECTIVA" data-cod-visitas="'.implode(",",$vruta_noefectiva[$row_c][$row_s]).'">' . $visitaNoEfec  . '</a>' : 0 ?>
								</td>
								<td class="visita1">
									<?= ($visitaInci > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_visita" data-title="INCIDENCIA" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="INCIDENCIA" data-cod-visitas="'.implode(",",$vruta_incidencia[$row_c][$row_s]).'">' . $visitaInci  . '</a>' : 0 ?>
								</td>
								<td style="text-align:center;"><?= $porcentaje . '%' ?></td>

							</tr>
						<? } else { ?>
							<tr>
								<td style=""><?= $value_s['nombre'] ?></td>
								<?
								$carteraObj = isset($carteraObjetivo[$row_c][$row_s]) ? $carteraObjetivo[$row_c][$row_s] : '0';
								$carteraAct = isset($cartera[$row_c][$row_s]) ? $cartera[$row_c][$row_s] : '0';

								$carteraObjPor = ($carteraObj > 0 && $carteraTotalObjetivo > 0) ? ROUND($carteraObj / $carteraTotalObjetivo * 100, 2) : 0;
								$carteraActPor = ($carteraAct > 0 && $carteraTotal > 0) ? ROUND($carteraAct / $carteraTotal * 100, 2) : 0;

								$carteraAct_carteraObj = ($carteraAct > 0 && $carteraObj > 0) ? ROUND($carteraAct / $carteraObj * 100, 2) : 0;
								?>
								<td class="cartera1"><?= $carteraObj ?></td>
								<td class="cartera1"><?= $carteraObjPor . '%' ?></td>
								<td class="cartera1">
									<?= ($carteraAct > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_cartera" data-title="Cartera Activa" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="" >' . $carteraAct . '</a>' : 0 ?>
								</td>
								<td class="cartera1"><?= $carteraActPor . '%' ?></td>
								<td style="text-align:center;"><?= $carteraAct_carteraObj . '%' ?></td>

								<?
								$carteraPlan = isset($carteraPlaneada[$row_c][$row_s]) ? $carteraPlaneada[$row_c][$row_s] : '0';
								$carteraExcl = isset($carteraExclusion[$row_c][$row_s]) ? $carteraExclusion[$row_c][$row_s] : '0';
								$carteraCobe = isset($carteraCobertura[$row_c][$row_s]) ? $carteraCobertura[$row_c][$row_s] : '0';

								$mensual =  $carteraPlan - ($carteraExcl + $carteraCobe) ;
								$carteraHabil = $carteraPlan - ($carteraExcl + $mensual);

								$porcentaje = ($carteraHabil > 0) ? ROUND($carteraCobe / $carteraHabil * 100, 2) : 0;

								$total_cartera_planeada = $total_cartera_planeada + $carteraPlan;
								$total_cartera_mensual = $total_cartera_mensual + $mensual;
								$total_cartera_exclusion = $total_cartera_exclusion + $carteraExcl;
								$total_cartera_habil = $total_cartera_habil + $carteraHabil;
								$total_cartera_cobertura = $total_cartera_cobertura + $carteraCobe;
								?>

								<td class="cartera2"><?= $carteraPlan ?></td>
								<td class="cartera2"><?= ($mensual >= 0) ? $mensual : '0' ?></td>
								<td class="cartera2">
									<?= ($carteraExcl > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_cartera" data-title="Exclusiones" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="EXCLUSION">' . $carteraExcl . '</a>' : 0 ?>
								</td>
								<td class="cartera2"><?= $carteraHabil ?></td>
								<td class="cartera2">
									<?= ($carteraCobe > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_cartera" data-title="Exclusiones" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="EFECTIVA" data-cod-clientes="'.implode(",",$vcliente_efectiva[$row_c][$row_s]).'">' . $carteraCobe . '</a>' : 0 ?>
								</td>
								<td style="text-align:center;"><?= $porcentaje . '%' ?></td>

								<?
								$visitaProg = isset($visitaProgramada[$row_c][$row_s]) ? $visitaProgramada[$row_c][$row_s] : '0';
								$visitaExclu = isset($visitaExclusion[$row_c][$row_s]) ? $visitaExclusion[$row_c][$row_s] : '0';
								$visitaEfec = isset($visitaEfectiva[$row_c][$row_s]) ? $visitaEfectiva[$row_c][$row_s] : '0';
								$visitaNoEfec = isset($visitaNoEfectiva[$row_c][$row_s]) ? $visitaNoEfectiva[$row_c][$row_s] : '0';
								$visitaInci = isset($visitaIncidencia[$row_c][$row_s]) ? $visitaIncidencia[$row_c][$row_s] : '0';
								$visitaHabiles = $visitaProg - $visitaExclu;
								$porcentaje = ($visitaHabiles > 0) ? ROUND($visitaEfec / $visitaHabiles * 100, 2) : 0;

								$total_visita_planeada = $total_visita_planeada + $carteraPlan;
								$total_visita_programada = $total_visita_programada + $visitaProg;
								$total_visita_excluida = $total_visita_excluida + $visitaExclu;
								$total_visita_habiles = $total_visita_habiles + $visitaHabiles;
								$total_visita_efectivas = $total_visita_efectivas + $visitaEfec;
								$total_visita_no_efectivas = $total_visita_no_efectivas + $visitaNoEfec;
								$total_visita_incidencias = $total_visita_incidencias + $visitaInci;
								?>

								<td class="visita1"><?= $carteraPlan ?></td>
								<td class="visita1">
									<?= ($visitaProg > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_visita" data-title="Visitas Programadas" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="" data-cod-visitas="'.implode(",",$vruta_programada[$row_c][$row_s]).'">' . $visitaProg . '</a>' : 0 ?>
								</td>
								<td class="visita1">
									<?= ($visitaExclu > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_visita" data-title="Visitas EXcluidas" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="EXCLUIDAS" data-cod-visitas="'.implode(",",$vruta_excluida[$row_c][$row_s]).'">' . $visitaExclu . '</a>' : 0 ?>
								</td>
								<td class="visita1">
									<?= ($visitaHabiles > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_visita" data-title="Visitas Habiles" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="HABILES" data-cod-visitas="'.implode(",",$vruta_habiles[$row_c][$row_s]).'">' . $visitaHabiles  . '</a>' : 0 ?>
								</td>
								<td class="visita1">
									<?= ($visitaEfec > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_visita" data-title="Visitas Habiles" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="EFECTIVA" data-cod-visitas="'.implode(",",$vruta_efectiva[$row_c][$row_s]).'">' . $visitaEfec  . '</a>' : 0 ?>
								</td>
								<td class="visita1">
									<?= ($visitaNoEfec > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_visita" data-title="Visitas Habiles" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="NO EFECTIVA" data-cod-visitas="'.implode(",",$vruta_noefectiva[$row_c][$row_s]).'">' . $visitaNoEfec  . '</a>' : 0 ?>
								</td>
								<td class="visita1">
									<?= ($visitaInci > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_visita" data-title="INCIDENCIA" data-subcanal="' . $row_s . '" data-canal="' . $row_c . '" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-tipo="INCIDENCIA" data-cod-visitas="'.implode(",",$vruta_incidencia[$row_c][$row_s]).'">' . $visitaInci  . '</a>' : 0 ?>
								</td>
								<td style="text-align:center;"><?= $porcentaje . '%' ?></td>

							</tr>
						<? }
						$i++;
						$j++; ?>
					<? } ?>
				<? } ?>
			<? } ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="3" style="text-align:center;">TOTALES</td>
				<td class="cartera1"><?= $carteraTotalObjetivo ?></td>
				<td class="cartera1"><?= ($carteraTotalObjetivo > 0) ? '100%' : '0%' ?></td>
				<td class="cartera1">
					<?= ($carteraTotal > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_cartera" data-title="Cartera Activa" data-subcanal="" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-flag-total = "1" data-tipo="" >' . $carteraTotal . '</a>' : 0 ?>
					<? //=$carteraTotal
					?>
				</td>
				<td class="cartera1"><?= ($carteraTotal > 0) ? '100%' : '0%' ?></td>
				<td style="text-align:center;"><?= ($carteraTotalObjetivo > 0) ? ROUND($carteraTotal / $carteraTotalObjetivo * 100, 2) . '%' : '0%' ?></td>

				<td class="cartera2"><?= $total_cartera_planeada ?></td>
				<td class="cartera2"><?= ($total_cartera_mensual >= 0) ? $total_cartera_mensual : '0' ?></td>
				<td class="cartera2"><?= $total_cartera_exclusion ?></td>
				<td class="cartera2"><?= $total_cartera_habil ?></td>
				<td class="cartera2">
					<?= ($total_cartera_cobertura > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_cartera" data-title="Exclusiones" data-subcanal="" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-flag-total = "1" data-cod-clientes="'.implode(",",$vcliente_efectiva['total']).'" data-tipo="EFECTIVA">' . $total_cartera_cobertura . '</a>' : 0 ?>
					<? //=$total_cartera_cobertura
					?>
				</td>
				<td style="text-align:center;"><?= ($total_cartera_habil > 0) ? ROUND($total_cartera_cobertura / $total_cartera_habil * 100, 2) . '%' : '0%'; ?></td>

				<td class="visita1"><?= $total_visita_planeada ?></td>
				<td class="visita1">
					<?= ($total_visita_programada > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_visita" data-title="Visitas Programadas" data-subcanal="" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-flag-total = "1" data-tipo="" data-cod-visitas="'.implode(",",$vruta_programada_total).'">' . $total_visita_programada . '</a>' : 0 ?>
					<? //=$total_visita_programada
					?>
				</td>
				<td class="visita1">
					<?= ($total_visita_excluida > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_visita" data-title="Visitas EXcluidas" data-subcanal="" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-flag-total = "1" data-tipo="EXCLUIDAS" data-cod-visitas="'.implode(",",$vruta_excluida_total).'">' . $total_visita_excluida . '</a>' : 0 ?>
					<? //=$total_visita_excluida
					?>
				</td>
				<td class="visita1">
					<?= ($total_visita_habiles > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_visita" data-title="Visitas Habiles" data-subcanal="" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-flag-total = "1" data-tipo="HABILES" data-cod-visitas="'.implode(",",$vruta_habiles_total).'">' . $total_visita_habiles . '</a>' : 0 ?>
					<? //=$total_visita_habiles
					?>
				</td>
				<td class="visita1">
					<?= ($total_visita_efectivas > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_visita" data-title="Visitas Habiles" data-subcanal="" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-flag-total = "1" data-tipo="EFECTIVA" data-cod-visitas="'.implode(",",$vruta_efectiva_total).'">' . $total_visita_efectivas . '</a>' : 0 ?>
					<? //=$total_visita_efectivas
					?>
				</td>
				<td class="visita1">
					<?= ($total_visita_no_efectivas > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_visita" data-title="Visitas Habiles" data-subcanal="" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-flag-total = "1" data-tipo="NO EFECTIVA" data-cod-visitas="'.implode(",",$vruta_noefectiva_total).'">' . $total_visita_no_efectivas . '</a>' : 0 ?>
					<? //=$total_visita_no_efectivas
					?></td>
				<td class="visita1">
					<?= ($total_visita_incidencias > 0) ? '<a href="javascript:;" class="lk-detalle" data-ruta="detalle_visita" data-title="INCIDENCIA" data-subcanal="" data-fecini="' . $fecIni . '" data-fecfin ="' . $fecFin . '" data-grupo-canal="'.$row.'" data-flag-total = "1" data-tipo="INCIDENCIA" data-cod-visitas="'.implode(",",$vruta_incidencia_total).'">' . $total_visita_incidencias . '</a>' : 0 ?>
					<? //=$total_visita_incidencias
					?></td>
				<td style="text-align:center;"><?= ($total_visita_habiles > 0) ? ROUND($total_visita_efectivas / $total_visita_habiles * 100, 2) . '%' : '0%'; ?></td>
			</tr>
		</tfoot>
	</table>
</div>