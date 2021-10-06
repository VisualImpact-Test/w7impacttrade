<div class="card-datatable">
<table id="tb-live-list-categoria" class="table table-striped nowrap" width="100%">
	<thead>
		<tr>
			<th class="no-sort"></th>
			<th>#</th>
			<th>CUENTA / PROYECTO</th>
			<th>GRUPO CANAL / CANAL / SUBCANAL</th>
			<th>LISTA</th>
			<th>CATEGORIAS</th>
			<th>FEC INICIO</th>
			<th>FEC FIN</th>
			<th>ESTADO</th>
			<th class="no-sort"></th>
		</tr>
	</thead>
	<tbody>
		<?$i = 1;?>
		<?foreach($data as $row){?>
		<tr data-id="<?=$row['idListCategoria']?>">
			<td class="text-center">
				<input type="checkbox" class="check-row" style="width: 1.5rem; height: 1.5rem;">
			</td>
			<td><?=$i++?></td>
			<td><?=$row['cuenta'].' / '.$row['proyecto']?></td>
			<td><?
				$valor = $row['grupoCanal'];
				$valor .= !empty($row['canal']) ? ' / '.$row['canal'] : '';
				$valor .= !empty($row['subCanal']) ? ' / '.$row['subCanal'] : '';
				echo $valor;
			?></td>
			<td><?
				$valor = '';
					if( in_array($row['idGrupoCanal'], [1,4]) ){
						$valor .= !empty($row['distribuidora']) ? ' / '.$row['distribuidora'] : '';
						$valor .= !empty($row['distribuidoraSucursal']) ? ' / '.$row['distribuidoraSucursal'] : '';
					}
					elseif( in_array($row['idGrupoCanal'], [2]) ){
						$valor .= !empty($row['cadena']) ? $row['cadena'] : '';
						$valor .= !empty($row['banner']) ? ' / '.$row['banner'] : '';
					}
					elseif( in_array($row['idGrupoCanal'], [5]) ){
						$valor .= !empty($row['plaza']) ? $row['plaza'] : '';
					}
					$valor .= !empty($row['tienda']) ? ' / '.$row['tienda'] : '';

				echo $valor;
			?></td>
			<td><?=$row['numCat']?></td>
			<td><?=$row['fecIni']?></td>
			<td><?=(empty($row['fecFin']) ? '-' : $row['fecFin'])?></td>
			<td>
				<?$estado = empty($row['estado']) ? 'INACTIVO' : 'ACTIVO';?>
				<?$color = empty($row['estado']) ? 'red' : 'green';?>
				<span class="color-<?=$color?>"><?=$estado?><span>
			</td>
			<td class="text-center">
				<button class="btn-live-gestor-ver btn btn-xs"
					data-id="<?=$row['idListCategoria']?>"
					data-cadena="<?=$row['cadena']?>"
					data-banner="<?=$row['banner']?>"
					data-tienda="<?=$row['tienda']?>"
					title="Ver Detalle"
				>
					<i class="fa fa-eye"></i>
				</button>
			</td>
		</tr>
		<?}?>
	</tbody>
</table>
</div>
<script>
	$('#tb-live-list-categoria').dataTable({
		'dom': 'frtip',
		'iDisplayLength': -1,
		'scrollX': true,
		'columnDefs': [{ 'targets': 'no-sort', 'orderable': false }]
	});
</script>