<h5>VISIBILIDAD</h5>
<div class="table-responsive mb-3">
	<table class="table table-bordered table-sm text-nowrap">
		<thead class="bg-light">
			<tr>
				<td colspan=6>
					<span class="font-weight-bold mb-0 pl-4">MODULADO</span>
				</td>
			</tr>
			<tr class="text-center">
				<th>#</th>
				<th>ELEMENTO</th>
				<th>PRESENCIA</th>
				<th>CANTIDAD</th>
				<th>FOTO</th>
			</tr>
		</thead>
		<tbody>
			<? $i = 1; ?>
			<?foreach($modulado as $row){ ?>
				<tr>
					<td class="text-center"><?=$i++?></td>
					<td><?=$row['elementoVisibilidad']?></td>
					<td class="text-center"><?=(!empty($row['presencia']))? 'SI' :'-';?></td>
					<td class="text-center"><?=(!empty($row['cantidad']))? $row['cantidad']:'-';?></td>
					<td class="text-center">
						<?if(!empty($row['foto'])){?>
							<?$fotoUrl = site_url("controlFoto/obtener_carpeta_foto/visibilidad/{$row['foto']}")?>
							<a href="javascript:;" class="lk-foto" data-fotourl="<?=$fotoUrl?>" >
							<i class="fas fa-camera"></i>
							</a>
						<?}else{ echo '-';}?>
					</td>
				</tr>
			<? } ?>
			</tbody>
	</table>
</div>
<div class="table-responsive">
	<table class="table table-bordered table-sm text-nowrap">
		<thead>
			<tr class="bg-light">
				<td colspan=6>
					<span class="font-weight-bold mb-0 pl-4">NO MODULADO</span>
				</td>
			</tr>
			<tr class="bg-light text-center">
				<th>#</th>
				<th>ELEMENTO</th>
				<th>FOTO</th>
			</tr>
		</thead>
		<tbody>
			<? $i = 1; ?>
			<?foreach($nomodulado as $row){ ?>
				<tr>
					<td class="text-center"><?=$i++?></td>
					<td><?=$row['elementoVisibilidad']?></td>
					<td class="text-center">
						<?if( !empty($row['foto']) ){?>
							<?$fotoUrl = site_url("controlFoto/obtener_carpeta_foto/visibilidad/{$row['foto']}")?>
							<a href="javascript:;" class="lk-foto" data-fotourl="<?=$fotoUrl?>" >
								<img src="<?=$fotoUrl?>" style="width: 96px; border: 2px solid #CCC;">
							</a>
						<?} else echo '-';?>
					</td>
				</tr>
			<? } ?>
		</tbody>
	</table>
</div>