<h5>SURTIDO</h5>
<div class="table-responsive mb-4">
	<table class="mb-0 table table-bordered table-sm text-nowrap">
		<thead class="bg-light">
			<tr class="text-center align-middle">
				<th>#</th>
				<th>PRODUCTO</th>
				<th>PRESENCIA</th>
				<th>OBSERVACIÓN</th>
				<th>FOTO</th>
			</tr>
		</thead>
		<tbody>
			<? $i=1; ?>
            <? foreach($surtido as $row){ ?>
				<tr>
					<td class="text-center"><?=$i++?></td>
					<td><?=(!empty($row['producto']))? $row['producto']:'-';?></td>
					<td class="text-center"><?=(!empty($row['presencia']))? 'SÍ' :'-';?></td>
					<td class="text-center"><?=(!empty($row['observacion']))? $row['observacion']:'-';?></td>
					<td class="text-center">
						<? if( !empty($row['foto']) ) {?>
							<?$fotoUrl = site_url("controlFoto/obtener_carpeta_foto/surtido/{$row['foto']}");?>
							<a href="javascript:;" class="lk-foto" data-fotourl="<?=$fotoUrl?>"  >
								<?=($row['foto']!=0)?'<img src="'.$fotoUrl.'" style="width: 96px; border: 2px solid #CCC;">':'-';?>
							</a>
						<?} else echo '-';?>
					</td>
				</tr>
			<? } ?>
		</tbody>
	</table>
</div>
<h5>SUGERIDO</h5>
<div class="table-responsive">
	<table class="mb-0 table table-bordered table-sm text-nowrap">
		<thead class="bg-light">
			<tr class="text-center align-middle">
				<th>#</th>
				<th>PRODUCTO</th>
			</tr>
		</thead>
		<tbody>
			<? $i = 1; ?>
            <? foreach($sugerido as $row){ ?>
				<tr>
					<td class="text-center"><?=$i++?></td>
					<td><?=(!empty($row['producto']))? $row['producto']:'-';?></td>
				</tr>
			<? } ?>
		</tbody>
	</table>
</div>