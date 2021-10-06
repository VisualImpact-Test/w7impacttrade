<h5>OBSERVACIONES</h5>
<div class="table-responsive">
	<table class="mb-0 table table-bordered table-sm text-nowrap">
		<tbody>
			<? $i = 1; ?>
			<? foreach($observacion as $row){ ?>
				<tr>
					<td class="bg-light"><?=$i++?></td>
					<td><?=empty($row['comentario']) ? '-' : $row['comentario']?></td>
                </tr>
			<? }?>
		</tbody>
	</table>
</div>