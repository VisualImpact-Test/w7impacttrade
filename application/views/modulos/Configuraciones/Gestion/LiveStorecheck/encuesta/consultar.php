<div class="card-datatable">
<table id="tb-live-list-encuesta" class="table table-striped" width="100%">
	<thead>
		<tr>
			<th class="no-sort"></th>
			<th>#</th>
			<th>CUENTA</th>
			<th>FORMATO</th>
			<th>PREGUNTAS</th>
			<th>ESTADO</th>
			<th class="no-sort"></th>
		</tr>
	</thead>
	<tbody>
		<?$i = 1;?>
		<?foreach($data as $row){?>
		<tr data-id="<?=$row['idEncuesta']?>">
			<td>
				<input type="checkbox" class="check-row" style="width: 1.5rem; height: 1.5rem;">
			</td>
			<td><?=$i++?></td>
			<td><?=$row['cuenta']?></td>
			<td><?=$row['nombre']?></td>
			<td><?=$row['numPreg']?></td>
			<td>
				<?$estado = empty($row['estado']) ? 'INACTIVO' : 'ACTIVO';?>
				<?$color = empty($row['estado']) ? 'red' : 'green';?>
				<span class="color-<?=$color?>"><?=$estado?><span>
			</td>
			<td class="text-center">
				<button class="btn-live-encuesta-ver btn btn-xs" data-id="<?=$row['idEncuesta']?>" title="Ver Detalle"><i class="fa fa-eye"></i></button>
			</td>
		</tr>
		<?}?>
	</tbody>
</table>
</div>
<script>
	$('#tb-live-list-encuesta').dataTable({
		'dom': 'rtip',
		'iDisplayLength': -1,
		'scrollX': true,
		'columnDefs': [{ 'targets': 'no-sort', 'orderable': false }]
	});
</script>