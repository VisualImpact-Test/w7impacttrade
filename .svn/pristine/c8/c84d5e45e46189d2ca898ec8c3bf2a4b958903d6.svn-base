<div class="card-datatable">
	<table id="tb-contentTablaPremiaciones" class="mb-0 table table-bordered text-nowrap" width="100%">
		<thead>
			<tr>
				<th class="text-center">#</th>
				<th>PREMIACIÓN</th>
				<th>OBJETIVO</th>
				<th>CARGO</th>
			</tr>
		</thead>
		<tbody>
			<? foreach ($premiaciones as $key => $row) { ?>
				<tr>
					<td class="text-center"><?= $key+1; ?></td>
					<td><?= $row['nombre']; ?></td>
					<td class="text-center">
						<a style="cursor:pointer;font-size: 20px;" id="btn-objetivo-premiacion" data-id="<?= $row['idPremiacion']; ?>" data-nombre="<?= $row['nombre']; ?>"><i class="fa fa-star"></i></a>
					</td>
					<td class="text-center">
						<a style="cursor:pointer;font-size: 20px;" id="btn-cargo-premiacion" data-id="<?= $row['idPremiacion']; ?>" data-nombre="<?= $row['nombre']; ?>"><i class="fa fa-file-image"></i></a>
					</td>
				</tr>
			<? } ?>
		</tbody>
	</table>
</div>