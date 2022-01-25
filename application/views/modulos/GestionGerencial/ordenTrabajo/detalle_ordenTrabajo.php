<div class="card-datatable">
	<table id="tb-inteligencia" class="mb-0 table table-bordered text-nowrap" width="100%">
		<thead>
			<tr>
				<th class="text-center noVis" rowspan="2">#</th>
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

				<th class="text-center" rowspan="2">COD<br/>USUARIO</th>
				<th class="text-center" rowspan="2">PERFIL USUARIO</th>
				<th class="text-center" rowspan="2">NOMBRE USUARIO</th>

				<th class="text-center" colspan="3" rowspan="1">DATOS VISIBILIDAD AUDITORIA</th>

				<th class="text-center" colspan="2" rowspan="1">DATOS ORDEN TRABAJO</th>

				<th class="text-center" rowspan="2">HABILITAR</th>
				<th class="text-center" rowspan="2">CORREGIDO</th>
				<th class="text-center" rowspan="2">HABILITAR PDF</th>
			</tr>
			<tr>
				<th class="text-center" rowspan="1">ELEMENTO</th>
				<th class="text-center" rowspan="1">RESULTADO DE EVALUACION - INDICADOR JALADO</th>
				<th class="text-center" rowspan="1">DETALLE RESULTADO - SIVAL</th>

				<th class="text-center" rowspan="1">FOTO CERCA</th>
				<th class="text-center" rowspan="1">FOTO PANORAMICA</th>

			</tr>
		</thead>
		<tbody>
			<? $i = 1;
			foreach ($visitas as $row) {
				if (isset($detalle[$row['idVisita']])) {
					foreach ($detalle[$row['idVisita']] as $idElemento => $row_) {
						foreach ($detalle[$row['idVisita']][$idElemento] as $row_d) {
							$elemento = "";
							$idVisitaVisibilidad = "";

							$variable2 = true;
							$variable3 = true;
							$variable4 = true;

							$idVisitaFotoCerca = "";
							$fotoCerca = "";

							$idVisitaFotoPanoramica = "";
							$fotoPanoramica = "";
							$habilitarOt = "";
							$validado = "";

							$estado = "-";
							$estadoSival = "-";
							$idVisitaOrdenTrabajoDet = "";
							$idVisitaVisibilidadDet = "";
							$cantidad = "";


							if (isset($detalle[$row['idVisita']][$idElemento])) {
								foreach ($detalle[$row['idVisita']][$idElemento] as $row_i) {
									$idVisitaVisibilidadDet = $row_i['idVisitaVisibilidadDet'];
									$idVisitaOrdenTrabajoDet = $row_i['idVisitaOrdenTrabajoDet'];
									$elemento = $row_i['elemento'];
									$idVisitaVisibilidad = $row_i['idVisitaVisibilidad'];
									if ($row_i['idVariable'] == "2" && $row_i['presencia'] == "1") {
										$variable2 = true;
									} else if ($row_i['idVariable'] == "2" && $row_i['presencia'] != "1") {
										$variable2 = false;
									}
									if ($row_i['idVariable'] == "3" && $row_i['presencia'] == "1") {
										$variable3 = true;
									} else if ($row_i['idVariable'] == "3" && $row_i['presencia'] != "1") {
										$variable3 = false;
									}
									if ($row_i['idVariable'] == "4" && $row_i['presencia'] == "1") {
										$variable4 = true;
									} else if ($row_i['idVariable'] == "4" && $row_i['presencia'] != "1") {
										$variable4 = false;
									}
									$idVisitaFotoCerca = $row_i['idVisitaFotoCerca'];
									$fotoCerca = $row_i['fotoCerca'];
									$idVisitaFotoPanoramica = $row_i['idVisitaFotoPanoramica'];
									$fotoPanoramica = $row_i['fotoPanoramica'];

									$habilitarOt = $row_i['habilitarOt'];
									$validado = $row_i['validado'];
									$cantidad = $row_i['cantidad'];
								}
							}

							$boolCantidad = false;
							if (is_numeric($cantidad)) {
								if ($cantidad > 0) {
									$boolCantidad = true;
								} else {
									$boolCantidad = false;
								}
							} else {
								$boolCantidad = false;
							}

							if ($boolCantidad == true && $variable2 == true && $variable3 == true) {
								//no debe aparecer el registro
								//$estado="NO DEBERIA APARECER";
								continue;
							} else if ($boolCantidad == true && $variable2 == false && $variable3 == true) {
								$estado = "ELEMENTO PRESENTE Y NO CUMPLE PC";
								$estadoSival = "POSICION CALIENTE";
							} else if ($boolCantidad == true && $variable2 == true && $variable3 == false) {
								$estado = "ELEMENTO PRESENTE Y NO CUMPLE PL";
								$estadoSival = "PLANOGRAMA";
							} else if ($boolCantidad == true && $variable2 == false && $variable3 == false) {
								$estado = "ELEMENTO PRESENTE Y NO CUMPLE VARIABLES";
							} else {
								$estado = "ELEMENTO NO PRESENTE";
							}

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

								<td class="text-left"><?= $elemento ?></td>
								<td><?= $estado ?></td>
								<td><?= $estadoSival ?></td>

								<?
								$fotoImgCerca = (isset($fotoCerca) && !empty($fotoCerca)) ? $this->fotos_url . 'orden/' . $fotoCerca : '';
								$fotoImgParo = (isset($fotoPanoramica) && !empty($fotoPanoramica)) ? $this->fotos_url . 'orden/' . $fotoPanoramica : '';
								if (!empty($row_i['fotoCerca'])) {
									$fotoImgCerca = rutafotoModulo(['foto'=>$row_i['fotoCerca'],'modulo'=>'orden','icono'=>'fal fa-image-polaroid fa-lg btn-outline-primary btn border-0']); 
								}

								?>
								<td class="text-center"><?= (!empty($fotoImgCerca) ? $fotoImgCerca : '-'); ?></td>

								<?
								$fotoImgParo = (isset($fotoPanoramica) && !empty($fotoPanoramica)) ? $this->fotos_url . 'orden/' . $fotoPanoramica : '';
								if (!empty($row_i['fotoPanoramica'])) {
									$fotoImgParo = rutafotoModulo(['foto'=>$row_i['fotoPanoramica'],'modulo'=>'orden','icono'=>'fal fa-image-polaroid fa-lg btn-outline-primary btn border-0']); 
								}
								
								?>
								<td class="text-center"><?= (!empty($fotoImgParo) ? $fotoImgParo : '-'); ?></td>

								<td class="text-center">
									<?
									if ($idVisitaOrdenTrabajoDet == "") {
									?>
										<input name="check[]" class="check check_habilitar" type="checkbox" data-idVisitaVisibilidad="<?= $idVisitaVisibilidad ?>" data-idElemento="<?= $idElemento ?>" data-estado="<?= ($habilitarOt == "1") ? "1" : "0" ?>" value="" id="check-anular-<?= $idVisitaVisibilidadDet ?>" <?= ($habilitarOt == "1") ? "checked" : "" ?> />
									<?
									} else {
									?>
										-
									<?
									}
									?>
								</td>

								<td class="text-center">
									<?
									if ($habilitarOt != "1" || $idVisitaOrdenTrabajoDet == "") {
									?>
										-
									<?
									} else {
									?>
										<input name="check[]" class="check check_validar" type="checkbox" data-idVisitaOrdenTrabajoDet="<?= $idVisitaOrdenTrabajoDet ?>" data-estado="<?= ($validado == "1") ? "1" : "0" ?>" value="" id="check-anular-<?= $idVisitaVisibilidadDet ?>" <?= ($validado == "1") ? "checked" : "" ?> />
									<?
									}
									?>
								</td>

								<td class="text-center">
									<input name="check_pdf[]" id="check" class="check check_pdf" type="checkbox" data-idVisitaVisibilidad="<?= $idVisitaVisibilidad ?>" data-idElemento="<?= $idElemento ?>" />
								</td>
							</tr>
			<?
							break;
						}
					}
				}
			}
			?>
		</tbody>
	</table>
</div>