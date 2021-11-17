<h5>ORDEN AUDITORIA</h5>
<div class="table-responsive mb-3">
	<table class="table table-bordered table-sm text-nowrap">
		<thead class="bg-light">
			<tr class="text-center">
				<th>#</th>
				<th>ORDEN</th>
				<th>DESCRIPCION</th>
				<th>FOTO</th>
			</tr>
		</thead>
		<tbody>
			<? $i = 1; ?>
			<?foreach($ordenAuditoria as $row){ ?>
				<tr>
					<td class="text-center"><?=$i++?></td>
					<td class="text-center"><?=( !empty($row['orden']) ? $row['orden'] :'-' )?></td>
					<td class="text-center"><?=( !empty($row['descripcion']) ? $row['descripcion'] : '-' )?></td>
					<td class="text-center">
						<?if( !empty($row['foto']) ){?>
                            <?$fotoUrl = site_url("controlFoto/obtener_carpeta_foto/orden/{$row['foto']}")?>
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