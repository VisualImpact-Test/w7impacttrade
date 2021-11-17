<h5>PRODUCTOS</h5>
<div class="table-responsive">
	<table class="mb-0 table table-bordered table-sm text-nowrap">
		<thead class="bg-light">
			<tr class="">
				<th class="text-center align-middle" >#</th>
				<th class="text-center align-middle">PRODUCTO</th>
				<th class="text-center align-middle">CHECK</th>
				<th class="text-center align-middle">UND MEDIDA</th>
				<th class="text-center align-middle">MOTIVO</th>
				<th class="text-center align-middle">FOTO</th>

				<?=$columnasAdicionales['headers_adicionales'];?>
			</tr>
		</thead>
		<tbody>
			<?$i = 1;?>
			<? foreach($checkproducto as $row){ ?>
				<tr>
					<td><?=$i++?></td>
					<td><?=!empty($row['producto'])?$row['producto']:'-';?></td>
					<td class="text-center"><?=!empty($row['presencia']) ? 'SI' : 'NO'?></td>
					<td class="text-center"><?=!empty($row['unidadMedida']) ? $row['unidadMedida'] : '-' ?></td>
					<td class="text-center"><?=!empty($row['motivo']) ? $row['motivo'] : '-' ?></td>
					<td class="text-center">
						<?if( !empty($row['foto']) ){?>
							<?$fotoUrl = site_url("controlFoto/obtener_carpeta_foto/checklist/{$row['foto']}");?>
							<a href="javascript:;" class="lk-foto" data-fotoUrl="<?=$fotoUrl?>"  >
								<img src="<?=$fotoUrl?>" style="width :96px; border: 2px solid #CCC;">
							</a>
						<?} else echo '-';?>
					</td>
					<? foreach($columnasAdicionales['body_adicionales'] AS $k => $r) {?>
						<? if($r == 'quiebre') { ?>
							<td class="text-center"><?=!empty($row[$r]) ? 'SI' : 'NO'?></td>
						<? }else { ?>
							<td class="text-center"><?=verificarEmpty($row[$r], 3)?></td>
						<? }?>
					<? } ?>
				</tr>
			<? } ?>
		</tbody>
	</table>
</div>
