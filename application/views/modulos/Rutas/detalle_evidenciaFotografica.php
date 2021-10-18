<h5>EVIDENCIAS FOTOGRAFICAS</h5>
<div class="table-responsive">
	<table class="mb-0 table table-bordered table-sm text-nowrap">
		<thead class="bg-light">
			<tr class="">
				<th class="text-center align-middle" >#</th>
				<th class="text-center align-middle">COMENTARIO</th>
				<th class="text-center align-middle">FOTOS ANTES</th>
				<th class="text-center align-middle">FOTOS DESPUES</th>
			</tr>
		</thead>
		<tbody>
			<?$i = 1;?>
			<? foreach($evidencias as $row){ ?>
				<tr>
					<td><?=$i++?></td>
					<td class="text-center"><?=verificarEmpty($row['comentario'], 3) ?></td>
					<td class="text-center">
						<?if( !empty($row['fotos'][1]) ){?>
							<? foreach($row['fotos'][1] AS $k => $r){ ?>
								<?if( !empty($r) ){?>
									<?$fotoUrl = site_url("controlFoto/obtener_carpeta_foto/evidenciaFotografica/{$r}");?>
									<a href="javascript:;" class="lk-foto" data-fotoUrl="<?=$fotoUrl?>"  >
										<img src="<?=$fotoUrl?>" style="width :96px; border: 2px solid #CCC;">
									</a>
								<? } ?>
							<? } ?>
						<?} else echo '-';?>
					</td>
					<td class="text-center">
						<?if( !empty($row['fotos'][2]) ){?>
							<? foreach($row['fotos'][2] AS $k => $r){ ?>
								<?if( !empty($r) ){?>
									<?$fotoUrl = site_url("controlFoto/obtener_carpeta_foto/evidenciaFotografica/{$r}");?>
									<a href="javascript:;" class="lk-foto" data-fotoUrl="<?=$fotoUrl?>"  >
										<img src="<?=$fotoUrl?>" style="width :96px; border: 2px solid #CCC;">
									</a>
								<? } ?>
							<? } ?>
						<?} else echo '-';?>
					</td>
				</tr>
			<? } ?>
		</tbody>
	</table>
</div>
