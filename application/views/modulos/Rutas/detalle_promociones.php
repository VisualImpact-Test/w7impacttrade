<h5>PROMOCIONES VIGENTES</h5>
<div class="table-responsive">
	<table class="mb-0 table table-bordered table-sm text-nowrap">
		<thead class="bg-light">
			<tr>
				<th class="text-center align-middle">#</th>
				<th class="text-center align-middle">TIPO PROMOCION</th>
				<th class="text-center align-middle">PROMOCIÓN</th>
				<th class="text-center align-middle">CHECK</th>
				<th class="text-center align-middle">FOTO</th>

				<?=$columnasAdicionales['headers_adicionales'];?>
			</tr>
		</thead>
		<tbody>
			<? $i=1; foreach($promociones as $row){ ?>
				<tr>
					<td><?=$i++?></td>
					<td><?=!empty($row['tipoPromocion'])? $row['tipoPromocion'] : '-';?></td>
					<td>
						<?
							$promocion = '-';
							if( !empty($row['idPromocion']) ) $promocion = $row['promocion'];
							else $promocion = $row['nombrePromocion'];

							echo !empty($promocion) ? $promocion : '-'; 
						?>
					</td>
					<td class="text-center" ><?=(!empty($row['presencia']))? '<strong>SI</strong>' :'-';?></td>
					<td class="text-center">
						<?$fotoUrl = site_url("controlFoto/obtener_carpeta_foto/promociones/{$row['foto']}");?>
						<a href="javascript:;" class="lk-foto" data-fotoUrl="<?=$fotoUrl?>"  >
						<?=($row['foto']!=0)?'<img src="'.$fotoUrl.'" style="width:96px;border: 2px solid #CCC;" />':'-';?></a>

						<? foreach($columnasAdicionales['body_adicionales'] AS $k => $r) {?>
							<? if($r == 'fechaVigencia') { ?>
								<td class="text-center"><?=date_change_format($row["fechaVigenciaInicio"])?></td>
								<td class="text-center"><?=date_change_format($row["fechaVigenciaFin"])?></td>
							<? }else { ?>
								<td class="text-center"><?=verificarEmpty($row[$r], 3)?></td>
							<? }?>
						<? } ?>
					</td>
				</tr>
			<? } ?>
		</tbody>
	</table>
</div>