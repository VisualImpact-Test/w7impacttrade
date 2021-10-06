<div class="card-datatable">
<table id="tb-iniciativasConsolidadoImplementacion" class="mb-0 table table-bordered table-sm text-nowrap" width="100%">
	<thead>
		<tr>
			<th class="text-center align-middle" rowspan="2">#</th>
			<th class="text-center align-middle" rowspan="2">SUPERVISOR</th>
			<th class="text-center align-middle" rowspan="2">GTM</th>
			<th class="text-center align-middle" colspan="<?=count($listaElementosIniciativa)?>">ELEMENTOS</th>
		</tr>
		<tr>
			<? foreach ($listaElementosIniciativa as $klei => $elemento): ?>
				<th class="text-center align-middle"><?=$elemento['elementoIniciativa']?></th>

			<? endforeach ?>
		</tr>
	</thead>
	<tbody>
		<? $ix=1; ?>
		<? foreach ($listaVisitasConsolidado as $klc => $supervisor): ?>
			<? foreach ($supervisor['listaUsuarios'] as $klu => $usuario): ?>
				<tr>
					<td class="text-center"><?=$ix++;?></td>
					<td class=""><?=(!empty($supervisor['usuarioSupervisor'])?$supervisor['usuarioSupervisor']:'-')?></td>
					<td class=""><?=(!empty($usuario['nombreUsuario'])?$usuario['nombreUsuario']:'-')?></td>
					<?foreach ($listaElementosIniciativa as $klei => $row): ?>
					<? 
						$elementoIniciativaCantidad='';
						if ( isset($usuario['listaElementos'][$klei]['sumaElementosIniciativa']) && !empty($usuario['listaElementos'][$klei]['sumaElementosIniciativa']) ){
							$elementoIniciativaCantidad = $usuario['listaElementos'][$klei]['sumaElementosIniciativa'];
							$elementoIniciativaCantidad = '<a href="javascript:;" class="elementoDetallado" data-supervisor="'.$supervisor['idUsuarioSupervisor'].'" data-usuario="'.$usuario['idUsuario'].'" data-elemento="'.$row['idElementoIniciativa'].'" data-elementoTexto="'.$row['elementoIniciativa'].'" data-supervisorText="'.(!empty($supervisor['usuarioSupervisor'])?$supervisor['usuarioSupervisor']:'-').'" data-usuarioText="'.$usuario['nombreUsuario'].'">'.$elementoIniciativaCantidad.'</a>';
						}
					?>
						<td class="text-center"><?=(!empty($elementoIniciativaCantidad)?$elementoIniciativaCantidad:'-')?></td>
					<?endforeach ?>
				</tr>
			<? endforeach ?>
		<? endforeach ?>
	</tbody>
</table>
</div>