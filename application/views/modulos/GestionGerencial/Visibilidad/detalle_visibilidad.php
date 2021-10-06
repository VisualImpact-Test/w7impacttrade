<div class="card-datatable">
	<table id="tb-visibilidad" class="mb-0 table table-bordered text-nowrap" width="100%">
		<thead>
			<tr>
				<th class="text-center align-middle noVis" rowspan="4">#</th>
				<th class="text-center align-middle" rowspan="4">INHABILITAR / PDF</th>
				<th class="text-center align-middle" rowspan="4">FECHA</th>
				<th class="text-center align-middle" rowspan="4">PERFIL USUARIO</th>
				<th class="text-center align-middle hideCol" rowspan="4">COD USUARIO</th>
				<th class="text-center align-middle" rowspan="4">NOMBRE USUARIO</th>
				<th class="text-center align-middle" rowspan="4">GRUPO CANAL</th>
				<th class="text-center align-middle" rowspan="4">CANAL</th>
				<th class="text-center align-middle hideCol" rowspan="4">SUBCANAL</th>
				<?foreach ($segmentacion['headers'] as $k => $v) {?>
					<th class="text-center align-middle" rowspan="4" ><?=strtoupper($v['header'])?></th>
				<?}?>

				<th class="text-center align-middle hideCol" rowspan="4">DEPARTAMENTO</th>
				<th class="text-center align-middle hideCol" rowspan="4">PROVINCIA</th>
				<th class="text-center align-middle hideCol" rowspan="4">DISTRITO</th>

				<th class="text-center align-middle" rowspan="4">COD VISUAL</th>
				<th class="text-center align-middle hideCol" rowspan="4">COD <?=$this->sessNomCuentaCorto?></th>
				<th class="text-center align-middle hideCol" rowspan="4">COD PDV</th>
				<th class="text-center align-middle" rowspan="4">PDV</th>
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
				<th class="text-center align-middle" rowspan="1" colspan="<?= $rows ?>">ELEMENTOS VISIBILIDAD</th>
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
							<th class="text-center align-middle" rowspan="1" colspan="<?= $rows ?>"><?= $categoria ?></th>
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
								<th class="text-center align-middle" colspan="4"><?= $eleme ?></th>
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
								<th class="text-center align-middle noVis" rowspan="1">PRESENCIA</th>
								<th class="text-center align-middle noVis" rowspan="1">CANTIDAD</th>
								<th class="text-center align-middle noVis" rowspan="1">ESTADO</th>
								<th class="text-center align-middle noVis" rowspan="1">FOTO</th>
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
					<td class="text-center">
						<input name="check[]" id="check" class="check" type="checkbox" value="<?= $row['idVisita']; ?>" />
					</td>
					<td class="text-center"><?= date_change_format($row['fecha']) ?></td>
					<td class=""><?= (!empty($row['tipoUsuario']) ? $row['tipoUsuario'] : '-') ?></td>
					<td class="text-center"><?= (!empty($row['idUsuario']) ? $row['idUsuario'] : '-') ?></td>
					<td class=""><?= (!empty($row['nombreUsuario']) ? $row['nombreUsuario'] : '-') ?></td>
					<td class="text-left"><?= (!empty($row['grupoCanal']) ? $row['grupoCanal'] : '-') ?></td>
					<td class="text-left"><?= (!empty($row['canal']) ? $row['canal'] : '-') ?></td>
					<td class="text-left"><?= (!empty($row['subCanal']) ? $row['subCanal'] : '-') ?></td>
					<?foreach ($segmentacion['headers'] as $k => $v) {?>
						<td class="text-left"><?= (!empty($row[($v['columna'])]) ? $row[($v['columna'])] : '-') ?></td>
					<?}?>

					<td class="text-left"><?= (!empty($row['departamento']) ? $row['departamento'] : '-') ?></td>
					<td class="text-left"><?= (!empty($row['provincia']) ? $row['provincia'] : '-') ?></td>
					<td class="text-left"><?= (!empty($row['distrito']) ? $row['distrito'] : '-') ?></td>

					<td class="text-center"><?= (!empty($row['idCliente']) ? $row['idCliente'] : '-') ?></td>
					<td class="text-center"><?= (!empty($row['codCliente']) ? $row['codCliente'] : '-') ?></td>
					<td class="text-center"><?= (!empty($row['codDist']) ? $row['codDist'] : '-') ?></td>
					<td class="text-left"><?= (!empty($row['razonSocial']) ? $row['razonSocial'] : '-') ?></td>



					<?

					foreach ($categorias as $idCat => $categoria) {
						if (isset($elementos[$idCat])) {
							if (count($elementos[$idCat]) > 0) {
								foreach ($elementos[$idCat] as $idEle => $eleme) {
									$res = true;

									foreach ($detalle as $row_d) {
										if ($row['idVisita'] == $row_d['idVisita']) {
											if ($row_d['idElementoVis'] == $idEle) {
												$res = false;


												$elemento_pertenece = false;
												if (isset($lista)) {
													if (isset($lista[$row['idVisita']])) {
														if (isset($lista[$row['idVisita']][$row_d['idElementoVis']])) {
															$elemento_pertenece = true;
														}
													}
												}
					?>
												<td class="text-center" <?= ($elemento_pertenece) ? 'style="background: #b2d6f5;"' : '' ?>><?= (!empty($row_d['presencia']) ? ($row_d['presencia'] == 1 ? 'SI' : 'NO') : '-') ?></td>
												<td class="text-center" <?= ($elemento_pertenece) ? 'style="background: #b2d6f5;"' : '' ?>><?= (!empty($row_d['cantidad']) ? $row_d['cantidad'] : '-') ?></td>
												<td class="text-center" <?= ($elemento_pertenece) ? 'style="background: #b2d6f5;"' : '' ?>><?= (!empty($row_d['estado']) ? $row_d['estado'] : '-') ?></td>
												<?
												$fotoImg = (isset($row_d['foto']) && !empty($row_d['foto'])) ? $this->fotos_url . 'visibilidad/' . $row_d['foto'] : '';
												// if (!empty($fotoImg)) {
												// 	$fotoImg = '<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-' . $row_d['idVisita'] . '-' . $row_d['idElementoVis'] . '">
												// 								<img class="fotoMiniatura foto" name="img-fotoprincipal-' . $row_d['idVisita'] . '-' . $row_d['idElementoVis'] . '" id="img-fotoprincipal-' . $row_d['idVisita'] . '-' . $row_d['idElementoVis'] . '" src="' . $fotoImg . '" alt=""></a>';
												// }
												if (!empty($row_d['foto'])) {
													$foto = ' <a href="javascript:;" style="margin-right:3px;font-size: 15px;" class="lk-show-foto" data-modulo="visibilidad" data-foto="' . ($row_d['foto']) . '" ><i class="fa fa-camera" ></i></a> ';
												}
												?>
												<td class="text-center" <?= ($elemento_pertenece) ? 'style="background: #b2d6f5;"' : '' ?>><?= (!empty($foto) ? $foto : '-'); ?></td>

										<?
												break;
											}
										}
									}

									if ($res) {
										?>
										<td class="text-center align-middle" rowspan="1"> - </td>
										<td class="text-center align-middle" rowspan="1"> - </td>
										<td class="text-center align-middle" rowspan="1"> - </td>
										<td class="text-center align-middle" rowspan="1"> - </td>
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