<h5>VISIBILIDAD AUDITORIA INICIATIVA</h5>
<div class="table-responsive">
	<table class="mb-0 table table-bordered table-sm text-nowrap">
		<thead class="bg-light">
			<tr>
				<th class="text-center align-middle">#</th>
				<!--th class="text-center align-middle">PORCENTAJE</th-->
				<th class="text-center align-middle">INICIATIVA</th>
				<th class="text-center align-middle">ELEMENTO VISIBLIDAD</th>
				<th class="text-center align-middle">PRESENCIA</th>
				<th class="text-center align-middle">OBSERVACIÓN</th>
				<th class="text-center align-middle">COMENTARIO</th>
				<th class="text-center align-middle">FOTO</th>
			</tr>
		</thead>
		<tbody>
			<? $i=1; $rowspan = 1;
			foreach($listaAuditoriaIniciativa as $row){ ?>
				<?/*
				foreach ($row['listaElementos'] as $idIniciativa => $iniciativa){
					$rowspan = $rowspan + count($row['listaElementos'][$idIniciativa]['elementos'])+1;	
				}
				?>
				<tr>
					<td class="text-center" rowspan="<?=$rowspan;?>"><?=$i++?></td>
					<td class="text-center" rowspan="<?=$rowspan;?>"><?=(!empty($row['porcentaje']))? $row['porcentaje'] :'-';?></td>
				</tr>
				*/?>
				<? foreach ($row['listaElementos'] as $idIniciativa => $iniciativa){
					 $inispan =  count($row['listaElementos'][$idIniciativa]['elementos']); 
				?>
					<tr>
						<td rowspan="<?=$inispan;?>"><?=$i++?></td>
						<td rowspan="<?=$inispan;?>"><?=$row['listaElementos'][$idIniciativa]['iniciativa']?></td>
						<?$j = 1;?>
						<? foreach ($row['listaElementos'][$idIniciativa]['elementos'] as $ke_ => $elemento){ ?>
							<?if( $j > 1 ){?><tr><?}?>
								<td><?=(!empty($elemento['elementoVisibilidad']))? $elemento['elementoVisibilidad']:'-';?></td>
								<td class="text-center"><?=(!empty($elemento['presencia']))? 'SÍ':'-';?></td>
								<td class="text-center"><?=(!empty($elemento['observacion']))? $elemento['observacion']:'-';?></td>
								<td class="text-center"><?=(!empty($elemento['comentario']))? $elemento['comentario']:'-';?></td>
								<td class="text-center">
									<? if( !empty($elemento['foto']) ) {?>
										<?$fotoUrl = site_url("controlFoto/obtener_carpeta_foto/visibilidadAuditoria/{$elemento['foto']}");?>
										<a href="javascript:;" class="lk-foto" data-fotourl="<?=$fotoUrl?>"  >
											<img src="<?=$fotoUrl?>" style="width: 96px; border: 2px solid #CCC;">
										</a>
									<?} else echo '-';?>
								</td>
							</tr>
							<?$j++;?>
						<? } ?>
				<? } ?> 
			<? }?>
		</tbody>
	</table>
</div>