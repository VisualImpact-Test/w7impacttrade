<div class="table-responsive">
	<table id="tb-iniciativasConsolidadoVisitas" class="mb-0 table table-bordered table-sm text-nowrap" width="100%">
		<thead>
			<tr>
				<th class="text-center align-middle" rowspan="2">#</th>
				<th class="text-center align-middle" rowspan="2">SUPERVISOR</th>
				<th class="text-center align-middle" rowspan="2">GTM</th>
				<th class="text-center align-middle" rowspan="2">FECHA</th>
				<th class="text-center align-middle" rowspan="2">ZONA</th>
				<th class="text-center align-middle" colspan="2">DISTRIBUIDORA SUCURSAL</th>
				<th class="text-center align-middle" colspan="4">CLIENTE</th>
				<th class="text-center align-middle" colspan="3">VISITA</th>
				<? if ($flagImplementacion==1): ?>
					<th class="text-center align-middle" colspan="2">ELEMENTOS</th>
				<? endif ?>
				
			</tr>
			<tr>
				<th class="text-center align-middle">DISTRIBUIDORA</th>
				<th class="text-center align-middle">CIUDAD</th>
				<th class="text-center align-middle">CANAL</th>
				<th class="text-center align-middle">TIPO<br>CLIENTE</th>
				<th class="text-center align-middle">COD<br>VISUAL</th>
				<th class="text-center align-middle">RAZÓN<br>SOCIAL</th>
				<th class="text-center align-middle">HORA<br>INICIO</th>
				<th class="text-center align-middle">HORA<br>FINAL</th>
				<th class="text-center align-middle">INCIDENCIA</th>
				<? if ($flagImplementacion==1): ?>
					<th class="text-center align-middle">PRESENCIA</th>
					<th class="text-center align-middle">CANTIDAD</th>
				<? endif ?>
			</tr>
		</thead>
		<tbody>
			<? $ix=1; ?>
			<? foreach ($listaVisitasElemento as $klve => $row): ?>
				<tr>
					<td class="text-center"><?=$ix++;?></td>
					<td class=""><?=(!empty($row['usuarioSupervisor'])?$row['usuarioSupervisor']:'-')?></td>
					<td class=""><?=(!empty($row['nombreUsuario'])?$row['nombreUsuario']:'-')?></td>
					<td class="text-center"><?=(!empty($row['fecha'])?$row['fecha']:'-')?></td>
					<td class=""><?=(!empty($row['zona'])?$row['zona']:'*')?></td>
					<td class=""><?=(!empty($row['distribuidora'])?$row['distribuidora']:'-')?></td>
					<td class=""><?=(!empty($row['ciudad'])?$row['ciudad']:'-')?></td>
					<td class=""><?=(!empty($row['canal'])?$row['canal']:'-')?></td>
					<td class=""><?=(!empty($row['tipoCliente'])?$row['tipoCliente']:'*')?></td>
					<td class="text-center"><?=(!empty($row['idCliente'])?$row['idCliente']:'-')?></td>
					<td class=""><?=(!empty($row['razonSocial'])?$row['razonSocial']:'-')?></td>
					<td class="text-center"><?=(!empty($row['horaIni'])?$row['horaIni']:'-')?></td>
					<td class="text-center"><?=(!empty($row['horaFin'])?$row['horaFin']:'-')?></td>
					<td class="text-center"><?=(!empty($row['estadoIncidencia'])?($row['estadoIncidencia']==1?'SI':'NO'):'-')?></td>
					<? if ($flagImplementacion==1): ?>
						<td class="text-center"><?=(!empty($row['presencia'])?($row['presencia']==1?'SI':'NO'):'-')?></td>
						<td class="text-center"><?=(!empty($row['cantidad'])?$row['cantidad']:'-')?></td>
					<? endif ?>
				</tr>
			<? endforeach ?>
		</tbody>
	</table>
</div>