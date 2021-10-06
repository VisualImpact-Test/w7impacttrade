<h5>VISIBILIDAD AUDITORIA ADICIONAL</h5>
<div class="table-responsive">
	<table class="mb-0 table table-bordered table-sm text-nowrap">
		<thead class="bg-light">
			<tr>
				<th class="text-center align-middle">#</th>
				<!--th class="text-center align-middle">PROCENTAJE</th-->
				<!--th class="text-center align-middle">CANTIDAD CABECERA</th-->
				<th class="text-center align-middle">ELEMENTO VISIBLIDAD</th>
				<th class="text-center align-middle">PRESENCIA</th>
				<th class="text-center align-middle">CANTIDAD</th>
				<th class="text-center align-middle">COMENTARIO</th>
				<th class="text-center align-middle">FOTO</th>
			</tr>
		</thead>
		<tbody>
			<? $i=1; $rowspan = 1;?>
			<? foreach($listaAuditoriaAdicional as $row){ ?>
				<?/*
				<tr>
					<td class="text-center" rowspan="<?=$rowspan;?>"><?=$i++?></td>
					<td class="text-center" rowspan="<?=$rowspan;?>"><?=(!empty($row['porcentaje']))? $row['porcentaje'] :'-';?></td>
					<td class="text-center" rowspan="<?=$rowspan;?>"><?=(!empty($row['cantidadCabecera']))? $row['cantidadCabecera'] :'-';?></td>
				</tr>
				*/?>
				<? foreach ($row['listaElementos'] as $ke => $elemento){ ?>
					<tr>
						<td class="text-center"><?=$i++?></td>
						<td><?=(!empty($elemento['elementoVisibilidad']))? $elemento['elementoVisibilidad']:'-';?></td>
						<td class="text-center"><?=(!empty($elemento['presencia']))? 'SÍ':'-';?></td>
						<td class="text-center"><?=(!empty($elemento['cantidad']))? $elemento['cantidad']:'-';?></td>
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
				<? } ?>
			<? }?>
		</tbody>
	</table>
</div>