<table id="tb-live-tiendas" class="table table-striped" width="100%">
	<thead>
		<tr>
			<th>#</th>
			<th>COD VI</th>
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
		<?$i = 1;?>
		<?foreach($listTienda as $row){?>
			<tr class="pointer"
				data-id-cliente="<?=$row['idCliente']?>"
				data-id-cuenta=<?=$row['idCuenta']?>
				data-id-proyecto=<?=$row['idProyecto']?>
				data-id-grupo-canal=<?=$row['idGrupoCanal']?>
			>
				<td><?=$i++?></td>
				<td><?=$row['idCliente']?></td>
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
 	$('#tb-live-tiendas').DataTable({
		'dom': 'frtip',
		'ordering': false,
		'iDisplayLength': 10,
		'scrollX': true,
        'select': { 'style': 'single' }
	});
</script>