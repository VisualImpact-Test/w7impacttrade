<h5>VISIBILIDAD AUDITORIA OBLIGATORIA</h5>
<div class="table-responsive">
	<table class="mb-0 table table-bordered table-sm text-nowrap">
		<thead class="bg-light">
			<tr >
				<th class="text-center align-middle">#</th>
				<!--th class="text-center align-middle">PROCENTAJE</th>
				<th class="text-center align-middle">PROCENTAJEV</th>
				<th class="text-center align-middle">PROCENTAJEPM</th-->
				<th class="text-center align-middle">ELEMENTO VISIBILIDAD</th>
				<th class="text-center align-middle">CANTIDAD</th>
				<th class="text-center align-middle">FOTO</th>
				<th class="text-center align-middle">VARIABLE</th>
				<th class="text-center align-middle">PRESENCIA</th>
				<th class="text-center align-middle">OBSERVACIÓN</th>
				<th class="text-center align-middle">COMENTARIO</th>
			</tr>
		</thead>
		<tbody>
			<? $i=1; $rowspan = 1;
			foreach($listaAuditoriaObligatoria as $row){ ?>
				<?/*
					$rowspan = $rowspan + count($row['listaElementos']);
					foreach ($row['listaElementos'] as $elemento){
						$rowspan = $rowspan + count($elemento['listaVariables']);
					} 
				?>
				<tr>
					<td class="text-center" rowspan="<?=$rowspan;?>"><?=$i++?></td>
					<td class="text-center" rowspan="<?=$rowspan;?>"><?=(!empty($row['porcentaje']))? $row['porcentaje'] :'-';?></td>
					<td class="text-center" rowspan="<?=$rowspan;?>"><?=(!empty($row['porcentajeV']))? $row['porcentajeV']:'-';?></td>
					<td class="text-center" rowspan="<?=$rowspan;?>"><?=(!empty($row['porcentajePM']))? $row['porcentajePM']:'-';?></td>
				</tr>
				*/?>
				<? foreach ($row['listaElementos'] as $ke => $elemento){ ?>
					<tr>
						<?$rowspan = count($elemento['listaVariables']);?>
						<td rowspan="<?=$rowspan?>"><?=$i++?></td>
						<td rowspan="<?=$rowspan?>">
							<?=(!empty($elemento['elementoVisibilidad']))? $elemento['elementoVisibilidad']:'-';?>
						</td>
						<td rowspan="<?=$rowspan?>" class="text-center"><?=(!empty($elemento['cantidad']))? $elemento['cantidad']:'-';?></td>
						<td rowspan="<?=$rowspan?>" class="text-center">
							<? if( !empty($elemento['foto']) ) {?>
								<?$fotoUrl = site_url("controlFoto/obtener_carpeta_foto/visibilidadAuditoria/{$elemento['foto']}");?>
								<a href="javascript:;" class="lk-foto" data-fotourl="<?=$fotoUrl?>"  >
									<img src="<?=$fotoUrl?>" style="width: 96px; border: 2px solid #CCC;">
								</a>
							<?} else echo '-';?>
						</td>
						<?$j = 1;?>
						<? foreach ($elemento['listaVariables'] as $kev => $variable){ ?>
							<?if( $j > 1 ){?><tr><?}?>
								<td><?=(!empty($variable['variable']))? $variable['variable']:'-';?></td>
								<td class="text-center"><?=(!empty($variable['presencia']))? 'SÍ':'-';?></td>
								<td class="text-center"><?=(!empty($variable['observacion']))? $variable['observacion']:'-';?></td>
								<td class="text-center"><?=(!empty($variable['comentario']))? $variable['comentario']:'-';?></td>
							</tr>
							<?$j++;?>
						<? } ?>
				<? } ?>
			<? }?>
		</tbody>
	</table>
</div>