<table id="tb-live-tiendas-auditadas" class="table table-striped" width="100%">
	<thead>
		<tr>
			<th class="no-sort"></th>
			<th>#<?=nbs(3);?></th>
			<th>CUENTA</th>
			<th>GRUPO CANAL</th>
			<?if( in_array($idGrupoCanal, [1,4]) ){?>
			<th>ZONA</th>
			<th>DISTRIBUIDORA</th>
			<th>PLAZA</th>
			<?} elseif( in_array($idGrupoCanal, [2]) ){?>
			<th>CADENA</th>
			<th>BANNER</th>
			<?} elseif( in_array($idGrupoCanal, [5]) ){?>
			<th>PLAZA</th>
			<?}?>
			<th>REGIÓN</th>
			<th>RAZÓN SOCIAL</th>
			<th>NOMBRE COMERCIAL</th>
			<th>DIRECCIÓN</th>
		</tr>
	</thead>
	<tbody>
		<?foreach($data as $i => $row){?>
		<tr
			data-id-cliente="<?=$row['idCliente']?>"
			data-id-cuenta=<?=$row['idCuenta']?>
			data-id-proyecto=<?=$row['idProyecto']?>
			data-id-grupo-canal=<?=$row['idGrupoCanal']?>
		>
			<td class="text-center">
				<input type="radio" name="check-row" class="check-row" style="width: 1.5rem; height: 1.5rem;">
			</td>
			<td><?=($i + 1)?></td>
			<td><?=$row['cuenta'] ?: '-'?></td>
			<td><?=$row['grupoCanal'] ?: '-'?></td>
			<?if( in_array($idGrupoCanal, [1,4]) ){?>
			<td><?=$row['zona'] ?: '-'?></td>
			<td><?=$row['distribuidora'] ?: '-'?></td>
			<td><?=$row['plaza'] ?: '-'?></td>
			<?} elseif( in_array($idGrupoCanal, [2]) ){?>
			<td><?=$row['cadena'] ?: '-'?></td>
			<td><?=$row['banner'] ?: '-'?></td>
			<?} elseif( in_array($idGrupoCanal, [5]) ){?>
			<td><?=$row['plaza'] ?: '-'?></td>
			<?}?>
			<td><?=$row['region']?></td>
			<td><?=$row['razonSocial']?></td>
			<td><?=$row['nombreComercial']?></td>
			<td><?=$row['direccion']?></td>
		</tr>
		<?}?>
	</tbody>
</table>
<script>
	$('#tb-live-tiendas-auditadas').dataTable({
		'dom': 'rtip',
		'scrollX': true,
		'columnDefs': [{ 'targets': 'no-sort', 'orderable': false }]
	});
</script>