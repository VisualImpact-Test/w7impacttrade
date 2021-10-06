<table id="tb-lsck-plazas-auditadas" class="table table-striped" width="100%">
	<thead>
		<tr>
			<th class="no-sort noVis"></th>
			<th class="noVis">#<?=nbs(3);?></th>
			<th>DISTRIBUIDORA</th>
			<th>PLAZA</th>
			<th># AUDITORIAS</th>
		</tr>
	</thead>
	<tbody>
		<?foreach($data as $i => $row){?>
		<tr data-id-plaza="<?=$row['idPlaza']?>">
			<td class="text-center">
				<input type="radio" name="check-row" class="check-row pointer" style="width: 1.5rem; height: 1.5rem;">
			</td>
			<td><?=($i + 1)?></td>
			<td><?=$row['distribuidora']?></td>
			<td><?=$row['plaza'].( empty($row['distrito']) ? " - {$row['distrito']}" : "")?></td>
			<td><?=$row['totalAud']?></td>
		</tr>
		<?}?>
	</tbody>
</table>
<script>
	$('#tb-lsck-plazas-auditadas').DataTable();
</script>