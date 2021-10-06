<div class="card-datatable">
	<table id="tb-visibilidad" class="mb-0 table table-bordered text-nowrap" width="100%">
		<thead>
			<tr>
				<th class="text-center noVis" rowspan="4">#</th>
				<!-- <th class="text-center" rowspan="4">INHABILITAR / PDF</th> -->
				<th class="text-center" rowspan="4">FECHA</th>
				<th class="text-center" rowspan="4">GRUPO CANAL</th>
				<th class="text-center" rowspan="4">CANAL</th>
				<th class="text-center hideCol" rowspan="4">SUBCANAL</th>

				<? foreach ($segmentacion['headers'] as $k => $v) { ?>
                    <th class="text-center" rowspan="4"><?= strtoupper($v['header']) ?></th>
                <? } ?>

				<th class="text-center" rowspan="4">COD VISUAL</th>
				<th class="text-center hideCol" rowspan="4">COD <?= $this->sessNomCuentaCorto ?></th>
				<th class="text-center hideCol" rowspan="4">COD PDV</th>
				<th class="text-center" rowspan="4">PDV</th>
				<th class="text-center" rowspan="4">TIPO CLIENTE</th>

                <th class="text-center" rowspan="4">COD<br/>USUARIO</th>
                <th class="text-center" rowspan="4">PERFIL USUARIO</th>
                <th class="text-center" rowspan="4">NOMBRE USUARIO</th>

                <th class="text-center hideCol" rowspan="4">DEPARTAMENTO</th>
                <th class="text-center hideCol" rowspan="4">PROVINCIA</th>
                <th class="text-center hideCol" rowspan="4">DISTRITO</th>

				<?
				$rows = 0;
				foreach ($categorias as $idCat => $categoria) {
					if (isset($elementos[$idCat])) {
						if (count($elementos[$idCat]) > 0) {
							$rows += count($elementos[$idCat]);
						}
					}
				}
				$rows = $rows * 4;
				?>
				<th class="text-center" rowspan="1" colspan="<?= $rows ?>">PRODUCTOS</th>
			</tr>

			<tr>
				<?
				$rows = 0;
				foreach ($categorias as $idCat => $categoria) {
					if (isset($elementos[$idCat])) {
						if (count($elementos[$idCat]) > 0) {
							$rows = count($elementos[$idCat]);
							$rows = $rows * 4;
				?>
							<th class="text-center" rowspan="1" colspan="<?= $rows ?>"><?= $categoria ?></th>
				<?
						}
					}
				}
				?>
			</tr>

			<tr>
				<?
				foreach ($categorias as $idCat => $categoria) {
					if (isset($elementos[$idCat])) {
						if (count($elementos[$idCat]) > 0) {
							foreach ($elementos[$idCat] as $idEle => $eleme) {
				?>
								<th class="text-center" colspan="4"><?= $eleme ?></th>
				<?
							}
						}
					}
				}
				?>
			</tr>
			<tr>
				<?
				foreach ($categorias as $idCat => $categoria) {
					if (isset($elementos[$idCat])) {
						if (count($elementos[$idCat]) > 0) {
							foreach ($elementos[$idCat] as $idEle => $eleme) {
				?>
								<th class="text-center noVis" rowspan="1">PRESENCIA</th>
								<th class="text-center noVis" rowspan="1">OBSERVACION</th>
								<th class="text-center noVis" rowspan="1">ESTADO</th>
								<th class="text-center noVis" rowspan="1">FOTO</th>
				<?
							}
						}
					}
				}
				?>

			</tr>
		</thead>
		<tbody>
			<? $i = 1;
			foreach ($visitas as $row) {
			?>
				<tr>
					<td class="text-center"><?= $i++; ?></td>
					<!-- <td class="text-center">
						<input name="check[]" id="check" class="check" type="checkbox" value="<?= $row['idVisita']; ?>" />
					</td> -->
					<td class="text-center"><?= verificarEmpty($row["fecha"], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row["grupoCanal"], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($row["canal"], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($row["subCanal"], 3) ?></td>

					<? foreach ($segmentacion['headers'] as $k => $v) { ?>
                        <td class="text-<?= (!empty($row[($v['columna'])]) ? $v['align'] : '-') ?>"><?= (!empty($row[($v['columna'])]) ? $row[($v['columna'])] : '-') ?></td>
                    <? } ?>

					<td class="text-center"><?= verificarEmpty($row['idCliente'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($row['codCliente'], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($row['codDist'], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($row['razonSocial'], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($row['tipoCliente'], 3) ?></td>

                    <td class="text-center"><?= verificarEmpty($row["idUsuario"], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($row["tipoUsuario"], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($row["nombreUsuario"], 3) ?></td>

                    <td class="text-left"><?= verificarEmpty($row["departamento"], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($row["provincia"], 3) ?></td>
                    <td class="text-left"><?= verificarEmpty($row["distrito"], 3) ?></td>
					<?

					foreach ($categorias as $idCat => $categoria) {
						if (isset($elementos[$idCat])) {
							if (count($elementos[$idCat]) > 0) {
								foreach ($elementos[$idCat] as $idEle => $eleme) {
									$res = true;

									foreach ($detalle as $row_d) {
										if ($row['idVisita'] == $row_d['idVisita']) {
											if ($row_d['idProducto'] == $idEle) {
												$res = false;


												$elemento_pertenece = false;
												if (isset($lista)) {
													if (isset($lista[$row['idVisita']])) {
														if (isset($lista[$row['idVisita']][$row_d['idProducto']])) {
															$elemento_pertenece = true;
														}
													}
												}
					?>
												<td class="text-center" <?= ($elemento_pertenece) ? 'style="background: #b2d6f5;"' : '' ?>><?= (!empty($row_d['presencia']) ? ($row_d['presencia'] == 1 ? 'SI' : 'NO') : '-') ?></td>
												<td class="text-center" <?= ($elemento_pertenece) ? 'style="background: #b2d6f5;"' : '' ?>><?= (!empty($row_d['observacion']) ? $row_d['observacion'] : '-') ?></td>
												<td class="text-center" <?= ($elemento_pertenece) ? 'style="background: #b2d6f5;"' : '' ?>><?= (!empty($row_d['estado']) ? $row_d['estado'] : '-') ?></td>
												<?
												$fotoImg = (isset($row_d['foto']) && !empty($row_d['foto'])) ? foto_controlador('surtido/' . $row_d['foto']) : '';
												if (!empty($fotoImg)) {
													// $fotoImg = '<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-' . $row_d['idVisita'] . '-' . $row_d['idProducto'] . '">
													// 							<img class="fotoMiniatura foto" name="img-fotoprincipal-' . $row_d['idVisita'] . '-' . $row_d['idProducto'] . '" id="img-fotoprincipal-' . $row_d['idVisita'] . '-' . $row_d['idProducto'] . '" src="' . $fotoImg . '" alt=""></a>';
													$fotoImg = '<button class="btn btn-outline-secondary border-0 lk-foto-1" title="Ver Foto" name="img-fotoprincipal-' . $row_d['idVisita'] . '-' . $row_d['idProducto'] . '" id="img-fotoprincipal-' . $row_d['idVisita'] . '-' . $row_d['idProducto'] . '" data-content="img-fotoprincipal-' . $row_d['idVisita'] . '-' . $row_d['idProducto'] . '" src="' . $fotoImg . '">';
														$fotoImg .= '<i class="fas fa-image fa-lg"></i>';
													$fotoImg .= '</button>';
												}
												?>
												<td class="text-center" <?= ($elemento_pertenece) ? 'style="background: #b2d6f5;"' : '' ?>><?= (!empty($fotoImg) ? $fotoImg : '-'); ?></td>

										<?
												break;
											}
										}
									}

									if ($res) {
										?>
										<td class="text-center" rowspan="1"> - </td>
										<td class="text-center" rowspan="1"> - </td>
										<td class="text-center" rowspan="1"> - </td>
										<td class="text-center" rowspan="1"> - </td>
					<?
									}
								}
							}
						}
					}
					?>



				</tr>
			<?
			} ?>
		</tbody>
	</table>
</div>