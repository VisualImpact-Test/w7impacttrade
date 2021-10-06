<h5>PREMIACIÓN</h5>
<div class="table-responsive mb-3">
	<table class="table table-bordered table-sm text-nowrap">
		<thead class="bg-light">
			<tr class="text-center">
				<th>#</th>
				<th>TIPO</th>
				<th>PREMIACIÓN</th>
				<th>CÓDIGO</th>
				<th>MONTO</th>
				<th>FOTO</th>
			</tr>
		</thead>
		<tbody>
			<? $i = 1; ?>
			<?foreach($premiacion as $row){ ?>
				<tr>
					<td class="text-center"><?=$i++?></td>
					<td class="text-center"><?=( !empty($row['tipoPremiacion']) ? $row['tipoPremiacion'] :'-' )?></td>
					<td class="text-center"><?=( !empty($row['premiacion']) ? $row['premiacion'] : '-' )?></td>
					<td class="text-center"><?=( !empty($row['codigo']) ? $row['codigo'] : '-' )?></td>
					<td class="text-center"><?=( !empty($row['monto']) ? $row['monto'] : '-' )?></td>
					<td class="text-center">
						<?if( !empty($row['foto']) ){?>
                            <?$fotoUrl = site_url("controlFoto/obtener_carpeta_foto/premiacion/{$row['foto']}")?>
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