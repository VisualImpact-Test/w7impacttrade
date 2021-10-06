<table class="table table-sm-px table-borderless table-striped">
	<tbody>
		<?//$totalPuntos = 0;?>
		<?$colspan = count($tienda) + 1;?>
		<?foreach($tipoIndicador as $idTipoIndicador => $vtind){?>
			<tr class="thead-dark">
				<?if( $idTipoIndicador == 1 ){?>
					<th colspan="<?=$colspan?>">Indicadores de <?=$vtind['nombre']?></th>					
				<?} elseif( $idTipoIndicador == 2 ){?>
					<th>Indicadores de <?=$vtind['nombre']?></th>
					<?$i = 0;?>
					<?foreach($tienda as $idCliente){?>
						<th class="text-center">PDV <?=++$i?></th>
					<?}?>
				<?}?>
				<th class="border-left bg-info text-center">Plaza</th>
			</tr>
			<?foreach($indicador[$idTipoIndicador] as $idIndicador => $ind){?>
				<tr>
					<?if( $idTipoIndicador == 1 ){?>
						<td colspan="<?=$colspan?>"><?=$ind['nombre']?></td>
						<?$punto = !isset($puntaje[$idTipoIndicador][$idIndicador]) ? 0 : $puntaje[$idTipoIndicador][$idIndicador];?>
						<td class="font-weight-bold border-left text-center"><?=$punto?></td>
					<?} elseif( $idTipoIndicador == 2 ){?>
						<td><?=$ind['nombre']?></td>
						<?foreach($tienda as $idCliente){?>
							<?$punto = !isset($puntaje[$idTipoIndicador][$idIndicador][$idCliente]) ? 0 : $puntaje[$idTipoIndicador][$idIndicador][$idCliente];?>
							<td class="text-center"><?=$punto?></td>
						<?}?>
						<?$punto = !isset($puntaje[1][$idIndicador]) ? 0 : $puntaje[1][$idIndicador];?>
						<td class="font-weight-bold border-left text-center"><?=$punto?></td>
					<?}?>
					<?//$totalPuntos += $punto;?>
				</tr>
			<?}?>
		<?}?>
		<tr class="bg-secondary text-white">
			<th colspan="<?=$colspan?>" class="font-weight-bold text-right">
				Puntos
			</th>
			<th class="border-left text-center"><?=$puntaje['nota']?></th>
		</tr>
		<tr class="bg-secondary text-white">
			<th colspan="<?=$colspan?>" class="font-weight-bold text-right">
				%
			</th>
			<th class="border-left text-center"><?=$puntaje['porcentaje']?></th>
		</tr>
		<tr class="bg-info text-white">
			<th colspan="<?=$colspan?>" class="font-weight-bold text-right">
				<i class="fas fa-medal fa-lg text-warning"></i> Perfect OMS
			</th>
			<th class="border-left text-center"><?=$puntaje['perfectOms']?></th>
		</tr>
		<tr>
			<td>Preguntas Aprobadas</td>
			<?foreach($tienda as $idCliente){?>
				<?$aprobadas = !isset($pregunta[2]['aprobadas'][$idCliente]) ? 0 : $pregunta[2]['aprobadas'][$idCliente];?>
				<td class="text-center"><?=$aprobadas?></td>
			<?}?>
			<td class="font-weight-bold border-left text-center"><?=$pregunta[1]['aprobadas']?></td>
		</tr>
		<tr>
			<td>Preguntas Total</td>
			<?foreach($tienda as $idCliente){?>
				<?$total = !isset($pregunta[2]['total'][$idCliente]) ? 0 : $pregunta[2]['total'][$idCliente];?>
				<td class="text-center"><?=$total?></td>
			<?}?>
			<td class="font-weight-bold border-left text-center"><?=$pregunta[1]['total']?></td>
		</tr>
		<tr class="bg-info text-white">
			<th colspan="<?=$colspan?>" class="font-weight-bold text-right">
				<i class="fas fa-medal fa-lg text-warning"></i> Nota General
			</th>
			<th class="border-left text-center"><?=$pregunta[1]['nota'].'%'?></th>
		</tr>
	</tfoot>
</table>