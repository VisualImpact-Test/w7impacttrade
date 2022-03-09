<div class="table-responsive mb-3">

	<? 
		if( !empty($materialPop)){
			?>
				<table class="table table-bordered table-sm text-nowrap">
					<thead class="bg-light">
						<tr class="text-center">
							<th>#</th>
							<th>MATERIAL</th>
							<th>MARCA</th>
							<th>CANTIDAD</th>
							<th>FOTO</th>
						</tr>
					</thead>
					<tbody>
						<? $i = 1; ?>
						<?foreach($materialPop as $row){ ?>
							<tr>
								<td class="text-center"><?=$i++?></td>
								<td class="text-left"><?=( !empty($row['material']) ? $row['material'] :'-' )?></td>
								<td class="text-left"><?=( !empty($row['marca']) ? $row['marca'] :'-' )?></td>
								<td class="text-center"><?=( !empty($row['cantidad']) ? $row['cantidad'] :'0' )?></td>
								<td class="text-center"> <?= rutafotoModulo(['foto'=>$row['foto'],'modulo'=>$row['carpetaFoto'],'icono'=>'fal fa-image-polaroid fa-lg btn-outline-primary btn border-0'])?></td>
							</tr>
						<? } ?>
						</tbody>
				</table>
			<?
	}
	?>

	
</div>