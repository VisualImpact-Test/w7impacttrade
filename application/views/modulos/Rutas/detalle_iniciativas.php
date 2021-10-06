<h5>INICIATIVAS ELEMENTOS</h5>
<div class="table-responsive">
	<table class="mb-0 table table-bordered table-sm text-nowrap">
		<thead class="bg-light">
			<tr class="text-center">
				<th>#</th>
				<th>INICIATIVA</th>
				<th>ELEMENTO</th>
				<th>PRODUCTO</th>
				<th>PRESENCIA</th>
				<th>CANTIDAD</th>
				<th>ESTADO</th>
				<th>FOTO</th>
			</tr>
		</thead>
		<tbody>
			<?$i = 1;?>
			<?foreach($iniciativa as $idIniciativa => $vini){?>
				<tr>
					<?$rowspan = $vini['total'];?>
					<td rowspan=<?=$rowspan?> class="text-center"><?=$i++?></td>
					<td rowspan=<?=$rowspan?> ><?=$vini['nombre']?></td>
					<?$j = 1;?>
					<?foreach($elementos[$idIniciativa] as $velem){?>
						<?if( $j > 1 ){?><tr><?}?>
							<td><?=(!empty($velem['nombre']))? $velem['nombre'] :'-';?></td>
							<td class="text-center"><?=(!empty($velem['producto']))? 'SI' :'-';?></td>
							<td class="text-center"><?=(!empty($velem['presencia']))? 'SÍ' :'-';?></td>
							<td class="text-center"><?=(!empty($velem['cantidad']))? $velem['cantidad']:'-';?></td>
							<td class="text-center"><?=(!empty($velem['estado']))? $velem['estado']:'-';?></td>
							<td class="text-center">
								<?if( !empty($velem['foto']) ){?>
									<?$fotoUrl = site_url("controlFoto/obtener_carpeta_foto/iniciativa/{$velem['foto']}");?>
									<a href="javascript:;" class="lk-foto" data-fotourl="<?=$fotoUrl?>" >
										<img src="<?=$fotoUrl?>" style="width:96px;border: 2px solid #CCC;" >
									</a>
								<?} else echo '-';?>
							</td>
						</tr>
						<?$j++;?>
					<?}?>
				</tr>
			<? } ?>
		</tbody>
	</table>
</div>