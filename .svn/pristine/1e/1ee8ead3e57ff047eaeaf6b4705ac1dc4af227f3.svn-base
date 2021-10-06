<h5>INTELIGENCIA COMPETITIVA</h5>
<div class="table-responsive">
	<table class="mb-0 table table-bordered table-sm text-nowrap">
		<thead class="bg-light">
			<tr class="text-center">
				<th rowspan=2>#</th>
				<th rowspan=2>CATEGORÍA</th>
				<th rowspan=2>MARCA</th>
				<th rowspan=2>TIPO COMPETENCIA</th>
				<th rowspan=2>FOTO</th>
				<th colspan=4>PRODUCTO</th>
				<th rowspan=2>ELEMENTO<br>NOMBRE</th>
				<th colspan=3>INICIATIVA</th>
				<th colspan=4>PRECIO</th>
				<th colspan=3>ACTIVACIÓN</th>
			</tr>
			<tr class="text-center">
				<th>NOMBRE</th>
				<th>VERSIÓN</th>
				<th>TAMAÑO</th>
				<th>PRECIO</th>

				<th>OBJETIVO</th>
				<th>VIGENCIA DESDE</th>
				<th>VIGENCIA HASTA</th>

				<th>NOMBRE</th>
				<th>TAMAÑO</th>
				<th>PRECIO ANTERIOR</th>
				<th>PRECIO ACTUAL</th>

				<th>DESCRIPCIÓN</th>
				<th>VIGENCIA DESDE</th>
				<th>VIGENCIA HASTA</th>
			</tr>
		</thead>
		<tbody>
			<? $i=1; foreach($listaInteligenciaCompetitiva as $row){ ?>
				<tr>
					<td><?=$i++?></td>
					<td ><?=(!empty($row['categoria']))? $row['categoria'] :'-';?></td>
					<td><?=(!empty($row['marca']))? $row['marca']:'-';?></td>
					<td><?=(!empty($row['tipoCompetencia']) ? $row['tipoCompetencia'] : '-' );?></td>
					<td class="text-center">
						<?if( !empty($row['foto']) ){?>
							<?$fotoUrl = site_url("controlFoto/obtener_carpeta_foto/inteligencia/{$row['foto']}");?>
							<a href="javascript:;" class="lk-foto" data-fotoUrl="<?=$fotoUrl?>"  >
								<img src="<?=$fotoUrl?>" style="width:96px;border: 2px solid #CCC;">
							</a>
						<?} else echo '-'; ?>
					</td>

					<td><?=(!empty($row['nombreSku']) ? $row['nombreSku'] : '-' );?></td>
					<td><?=(!empty($row['versionSku']) ? $row['versionSku'] : '-' );?></td>
					<td><?=(!empty($row['tamanoSku']) ? $row['tamanoSku'] : '-' );?></td>
					<td><?=(!empty($row['precioSku']) ? $row['precioSku'] : '-' );?></td>

					<td><?=(!empty($row['nombreElemento']) ? $row['nombreElemento'] : '-' );?></td>

					<td><?=(!empty($row['objetivoIniciativa']) ? $row['objetivoIniciativa'] : '-' );?></td>
					<td class="text-center"><?=(!empty($row['vigenciaIniciativa']) ? $row['vigenciaIniciativa'] : '-' );?></td>
					<td class="text-center"><?=(!empty($row['vigenciaFinIniciativa']) ? $row['vigenciaFinIniciativa'] : '-' );?></td>

					<td><?=(!empty($row['nombreSkuPrecio']) ? $row['nombreSkuPrecio'] : '-' );?></td>
					<td><?=(!empty($row['tamanoPrecio']) ? $row['tamanoPrecio'] : '-' );?></td>
					<td><?=(!empty($row['precioAnterior']) ? $row['precioAnterior'] : '-' );?></td>
					<td><?=(!empty($row['precioActual']) ? $row['precioActual'] : '-' );?></td>

					<td><?=(!empty($row['descripcionActivacion']) ? $row['descripcionActivacion'] : '-' );?></td>
					<td class="text-center"><?=(!empty($row['vigenciaIniActivacion']) ? $row['vigenciaIniActivacion'] : '-' );?></td>
					<td class="text-center"><?=(!empty($row['vigenciaFinActivacion']) ? $row['vigenciaFinActivacion'] : '-' );?></td>
				</tr>
			<? } ?>
		</tbody>
	</table>
</div>