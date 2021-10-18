<div class="card-datatable">
	<table id="tb-inteligencia" class="mb-0 table table-bordered text-nowrap" width="100%">
		<thead>
			<tr>
				<th class="text-center no Vis" rowspan="2">#</th>
				<th class="text-center" rowspan="2">FECHA</th>
				<th class="text-center" rowspan="2">GRUPO CANAL</th>
				<th class="text-center" rowspan="2">CANAL</th>
				<th class="text-center hideCol" rowspan="2">SUB CANAL</th>

				<? foreach ($segmentacion['headers'] as $k => $v) { ?>
					<th rowspan="2" class="text-center"><?= strtoupper($v['header']) ?></th>
				<? } ?>

				<th class="text-center" rowspan="2">COD VISUAL</th>
				<th class="text-center hideCol" rowspan="2">COD <?= $this->sessNomCuentaCorto ?></th>
				<th class="text-center hideCol" rowspan="2">COD PDV</th>
				<th class="text-center" rowspan="2">PDV</th>
				<th class="text-center" rowspan="2">TIPO CLIENTE</th>

				<th class="text-center hideCol" rowspan="2">DEPARTAMENTO</th>
				<th class="text-center hideCol" rowspan="2">PROVINCIA</th>
				<th class="text-center hideCol" rowspan="2">DISTRITO</th>

				<th class="text-center" rowspan="2">COD <br />USUARIO</th>
				<th class="text-center" rowspan="2">PERFIL USUARIO</th>
				<th class="text-center" rowspan="2">NOMBRE USUARIO</th>

				<th class="text-center" colspan="3" rowspan="1">DATOS INTELIGENCIA</th>

				<th class="text-center" colspan="4" rowspan="1">PRODUCTO</th>
				<th class="text-center" colspan="1" rowspan="1">ELEMENTO</th>
				<th class="text-center" colspan="3" rowspan="1">INICIATIVA</th>
				<th class="text-center" colspan="4" rowspan="1">PRECIO</th>
				<th class="text-center" colspan="3" rowspan="1">ACTIVACION</th>
				<th class="text-center" colspan="4" rowspan="1">ACCION COMERCIAL</th>

				<th class="text-center" colspan="1" rowspan="2">FOTO</th>
			</tr>

			<tr>
				<th class="text-center" rowspan="1">CATEGORIA</th>
				<th class="text-center" rowspan="1">MARCA</th>
				<th class="text-center" rowspan="1">TIPO</th>

				<th class="text-center" rowspan="1">NOMBRE</th>
				<th class="text-center" rowspan="1">VERSION</th>
				<th class="text-center" rowspan="1">TAMAÑO</th>
				<th class="text-center" rowspan="1">PRECIO</th>

				<th class="text-center" rowspan="1">NOMBRE</th>

				<th class="text-center" rowspan="1">OBJETIVO</th>
				<th class="text-center" rowspan="1">VIGENCIA INICIO</th>
				<th class="text-center" rowspan="1">VIGENCIA FIN</th>

				<th class="text-center" rowspan="1">NOMBRE</th>
				<th class="text-center" rowspan="1">TAMAÑO</th>
				<th class="text-center" rowspan="1">PRECIO ANTERIOR</th>
				<th class="text-center" rowspan="1">PRECIO ACTUAL</th>

				<th class="text-center" rowspan="1">DESCRIPCION</th>
				<th class="text-center" rowspan="1">VIGENCIA INICIO</th>
				<th class="text-center" rowspan="1">VIGENCIA FIN</th>

				<th class="text-center" rowspan="1">NOMBRE</th>
				<th class="text-center" rowspan="1">CANTIDAD</th>
				<th class="text-center" rowspan="1">UNIDAD MEDIDA</th>
				<th class="text-center" rowspan="1">DESCRIPCION</th>
			</tr>
		</thead>
		<tbody>
			<? $i = 1;
			foreach ($visitas as $row) {
				foreach ($detalle as $row_d) {
					if ($row['idVisita'] == $row_d['idVisita']) {
			?>
						<tr>
							<td class="text-center"><?= $i++; ?></td>
							<td class="text-center"><?= verificarEmpty($row['fecha'], 3) ?></td>
							<td class="text-left"><?= verificarEmpty($row['grupoCanal'], 3) ?></td>
							<td class="text-left"><?= verificarEmpty($row['canal'], 3) ?></td>
							<td class="text-left"><?= verificarEmpty($row['subCanal'], 3) ?></td>

							<? foreach ($segmentacion['headers'] as $k => $v) { ?>
								<td class="text-<?= (!empty($row[($v['columna'])]) ? $v['align'] : '-') ?>"><?= (!empty($row[($v['columna'])]) ? $row[($v['columna'])] : '-') ?></td>
							<? } ?>

							<td class="text-center"><?= verificarEmpty($row['idCliente'], 3) ?></td>
							<td class="text-center"><?= verificarEmpty($row['codCliente'], 3) ?></td>
							<td class="text-center"><?= verificarEmpty($row['codDist'], 3) ?></td>
							<td class="text-left"><?= verificarEmpty($row['razonSocial'], 3) ?></td>
							<td class="text-left"><?= verificarEmpty($row['tipoCliente'], 3) ?></td>

							<td class="text-left"><?= verificarEmpty($row['departamento'], 3) ?></td>
							<td class="text-left"><?= verificarEmpty($row['provincia'], 3) ?></td>
							<td class="text-left"><?= verificarEmpty($row['distrito'], 3) ?></td>

							<td class="text-center"><?= verificarEmpty($row['idUsuario'], 3) ?></td>
							<td class="text-left"><?= verificarEmpty($row['tipoUsuario'], 3) ?></td>
							<td class="text-left"><?= verificarEmpty($row['nombreUsuario'], 3) ?></td>

							<td class="text-left"><?= (!empty($row_d['categoria']) ? $row_d['categoria'] : '-') ?></td>
							<td class="text-left"><?= (!empty($row_d['marca']) ? $row_d['marca'] : '-') ?></td>
							<td class="text-left"><?= (!empty($row_d['tipo']) ? $row_d['tipo'] : '-') ?></td>

							<td><?= (!empty($row_d['nombreSku']) ? $row_d['nombreSku'] : '-') ?></td>
							<td class="text-right"><?= (!empty($row_d['versionSku']) ? $row_d['versionSku'] : '-') ?></td>
							<td class="text-right"><?= (!empty($row_d['tamanoSku']) ? $row_d['tamanoSku'] : '-') ?></td>
							<td class="text-right"><?= (!empty($row_d['precioSku']) ? $row_d['precioSku'] : '-') ?></td>

							<td><?= (!empty($row_d['nombreElemento']) ? $row_d['nombreElemento'] : '-') ?></td>

							<td><?= (!empty($row_d['objetivoIniciativa']) ? $row_d['objetivoIniciativa'] : '-') ?></td>
							<td class="text-center"><?= (!empty($row_d['vigenciaIniIniciativa']) ? $row_d['vigenciaIniIniciativa'] : '-') ?></td>
							<td class="text-center"><?= (!empty($row_d['vigenciaFinIniciativa']) ? $row_d['vigenciaFinIniciativa'] : '-') ?></td>

							<td class="text-left"><?= (!empty($row_d['nombreSkuPrecio']) ? $row_d['nombreSkuPrecio'] : '-') ?></td>
							<td class="text-right"><?= (!empty($row_d['tamanoPrecio']) ? $row_d['tamanoPrecio'] : '-') ?></td>
							<td class="text-right"><?= (!empty($row_d['precioAnterior']) ? $row_d['precioAnterior'] : '-') ?></td>
							<td class="text-right"><?= (!empty($row_d['precioActual']) ? $row_d['precioActual'] : '-') ?></td>

							<td class="text-left"><?= (!empty($row_d['descripcionActivacion']) ? $row_d['descripcionActivacion'] : '-') ?></td>
							<td class="text-center"><?= (!empty($row_d['vigenciaIniActivacion']) ? $row_d['vigenciaIniActivacion'] : '-') ?></td>
							<td class="text-center"><?= (!empty($row_d['vigenciaFinActivacion']) ? $row_d['vigenciaFinActivacion'] : '-') ?></td>

							<td class="text-left"><?= (!empty($row_d['nombreSku']) ? $row_d['nombreSku'] : '-') ?></td>
							<td class="text-center"><?= (!empty($row_d['cantidadSku']) ? $row_d['cantidadSku'] : '-') ?></td>
							<td class="text-center"><?= (!empty($row_d['umSku']) ? $row_d['umSku'] : '-') ?></td>
							<td class="text-center"><?= (!empty($row_d['accion']) ? $row_d['accion'] : '-') ?></td>
							<?
							$fotoImg = (isset($row_d['foto']) && !empty($row_d['foto'])) ? $this->fotos_url . 'inteligencia/' . $row_d['foto'] : '';
							if (!empty($fotoImg)) {
								$fotoImg = '<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-' . $row_d['idVisita'] . '-' . $i . '">
													<img class="fotoMiniatura foto" name="img-fotoprincipal-' . $row_d['idVisita'] . '-' . $i . '" id="img-fotoprincipal-' . $row_d['idVisita'] . '-' . $i . '" src="' . $fotoImg . '" alt=""></a>';
							}
							?>
							<td class="text-center"><?= (!empty($fotoImg) ? $fotoImg : '-'); ?></td>
						</tr>
			<?
					}
				}
			} ?>
		</tbody>
	</table>
</div>