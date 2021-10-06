<h5>ORDEN DE TRABAJO</h5>
<div class="table-responsive">
	<table class="mb-0 table table-bordered table-sm text-nowrap">
		<thead class="bg-light">
			<tr class="text-center">
				<th>#</th>
				<th>ELEMENTO</th>
				<th>FOTO CERCA</th>
				<th>FOTO PANORÁMICA</th>
			</tr>
		</thead>
		<tbody>
			<?$i = 1;?>
			<?foreach($orden as $ix_o => $row){?>
				<tr>
					<td><?=$i++?></td>
					<td><?=!empty($row['elemento'])? $row['elemento'] : '-'?></td>
					<td class="text-center">
						<?if( $row['fotoCerca'] ){?>
							<?$fotoUrl = site_url("controlFoto/obtener_carpeta_foto/orden/{$row['fotoCerca']}");?>
							<a href="javascript:;" class="lk-foto" data-fotoUrl="<?=$fotoUrl?>"  >
								<img src="<?=$fotoUrl?>" style="width: 96px; border: 2px solid #CCC;">
							</a>
						<?} else echo '-';?>
					</td>
					<td class="text-center">
						<?if( $row['fotoPanor'] ){?>
							<?$fotoUrl = site_url("controlFoto/obtener_carpeta_foto/orden/{$row['fotoPanor']}");?>
							<a href="javascript:;" class="lk-foto" data-fotoUrl="<?=$fotoUrl?>"  >
								<img src="<?=$fotoUrl?>" style="width: 96px; border: 2px solid #CCC;">
							</a>
						<?} else echo '-';?>
					</td>
				</tr>
			<?}?>
		</tbody>
	</table>
</div>