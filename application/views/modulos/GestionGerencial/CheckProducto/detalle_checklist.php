<style>
	th.product-propio { background-color: #29943f; color: #fff; }
</style>
<div class="card-datatable">
	<table id="tb-checkproductos" class="mb-0 table table-bordered text-nowrap" width="100%">
		<thead>
			<tr>
				<th class="text-center noVis" rowspan="4">#</th>
				<!-- <th class="text-center" rowspan="4">INHABILITAR / PDF</th> -->
				<th class="text-center" rowspan="4">FECHA</th>
				<th class="text-center <?=!empty($hideCol['tipoUsuario']) ? 'hideCol' : '' ?>" rowspan="4">PERFIL USUARIO</th>
				<th class="text-center" rowspan="4">NOMBRE USUARIO</th>
				<th class="text-center <?=!empty($hideCol['grupoCanal']) ? 'hideCol' : '' ?>" rowspan="4">GRUPO CANAL</th>
				<th class="text-center <?=!empty($hideCol['canal']) ? 'hideCol' : '' ?>" rowspan="4">CANAL</th>
				<th class="text-center hideCol" rowspan="4">SUBCANAL</th>
				<?$nroHeaders = 9;?>
                <? foreach ($segmentacion['headers'] as $k => $v) { ?>
                    <? $nroHeaders++;?>
                    <th class="text-center <?=!empty($hideCol[$v['columna']]) ? 'hideCol' : '' ?>" rowspan="4"><?= strtoupper($v['header']) ?></th>
                <? } ?>
				<th class="text-center hideCol" rowspan="4">DEPARTAMENTO</th>
				<th class="text-center hideCol" rowspan="4">PROVINCIA</th>
				<th class="text-center hideCol" rowspan="4">DISTRITO</th>
				<th class="text-center <?=!empty($hideCol['idCliente']) ? 'hideCol' : '' ?>" rowspan="4">COD VISUAL</th>
				<th class="text-center hideCol" rowspan="4">COD <?=$this->sessNomCuentaCorto?></th>
				<th class="text-center hideCol" rowspan="4">COD PDV</th>
				<th class="text-center" rowspan="4">PDV</th>
				<th class="text-center <?=!empty($hideCol['tipoCliente']) ? 'hideCol' : '' ?>" rowspan="4">TIPO CLIENTE</th>
				<?
				$rows = 0;
				foreach ($categorias as $idCat => $categoria) {
					if (!empty($elementos[$idCat])) {
						if (count($elementos[$idCat]) > 0) {
							$rows += count($elementos[$idCat]);
						}
					}
				}
				$rows = $rows * 3;
				?>
				<th class="text-center" rowspan="1" colspan="<?= $rows ?>">PRODUCTOS</th>
			</tr>
			<tr>
				<?
				$rows = 0;
				foreach ($categorias as $idCat => $categoria) {
					if (!empty($elementos[$idCat])) {
						if (count($elementos[$idCat]) > 0) {
							$rows = count($elementos[$idCat]);
							$rows = $rows * 3;
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
					if (!empty($elementos[$idCat])) {
						if (count($elementos[$idCat]) > 0) {
							foreach ($elementos[$idCat] as $idEle => $eleme) {
								$color = $eleme['flagCompetencia'] ? 'product-competencia' : 'product-propio';
				?>
								<th class="text-center <?=$color?>" colspan="3"><?= $eleme['nombre'] ?></th>
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
					if (!empty($elementos[$idCat])) {
						if (count($elementos[$idCat]) > 0) {
							foreach ($elementos[$idCat] as $idEle => $eleme) {
								$color = $eleme['flagCompetencia'] ? 'product-competencia' : 'product-propio';
				?>
								<th class="text-center noVis <?=$color?>" rowspan="1">PRESENCIA</th>
								<!--<th class="text-center noVis" rowspan="1">STOCK</th>-->
								<th class="text-center noVis <?=$color?>" rowspan="1">MOTIVO</th>
								<th class="text-center noVis <?=$color?>" rowspan="1">FOTO</th>
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
						<input name="check[]" id="check" class="check" type="checkbox" value="<?//= $row['idVisita']; ?>" />
					</td> -->
					<td class="text-center"><?= date_change_format($row['fecha']) ?></td>
					<td class="text-left"><?= verificarEmpty($row['tipoUsuario'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['nombreUsuario'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['grupoCanal'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['canal'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['subCanal'], 3) ?></td>
					
					<? foreach ($segmentacion['headers'] as $k => $v) { ?>
                        <td class="text-<?= (!empty($row[($v['columna'])]) ? $v['align'] : '-') ?>"><?= (!empty($row[($v['columna'])]) ? $row[($v['columna'])] : '-') ?></td>
                    <? } ?>

					<td class="text-center"><?= verificarEmpty($row['departamento'], 3) ?></td>
					<td class="text-center"><?= verificarEmpty($row['provincia'], 3) ?></td>
					<td class="text-center"><?= verificarEmpty($row['distrito'], 3) ?></td>

					<td class="text-center"><?= verificarEmpty($row['idCliente'], 3) ?></td>
					<td class="text-center"><?= verificarEmpty($row['codCliente'], 3) ?></td>
					<td class="text-center"><?= verificarEmpty($row['codDist'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['razonSocial'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['tipoCliente'], 3) ?></td>
					<?
					foreach ($categorias as $idCat => $categoria) {
						if (!empty($elementos[$idCat])) {
							if (count($elementos[$idCat]) > 0) {
								foreach ($elementos[$idCat] as $idEle => $eleme) {
									$res = true;
										$color = $eleme['flagCompetencia'] ? 'product-competencia' : 'product-propio';
										if ( !empty($detalle[$row['idVisita']]) ) {
											if( !empty($detalle[$row['idVisita']][$idEle]) ){
												$row_d = $detalle[$row['idVisita']][$idEle];
												
												$res = false;
												$elemento_pertenece = false;
												if (!empty($lista)) {
													if (!empty($lista[$row['idVisita']])) {
														if (!empty($lista[$row['idVisita']][$row_d['idProducto']])) {
															$elemento_pertenece = true;
														}
													}
												}
						?>
												<td class="text-center <?=$color?>" <?= ($elemento_pertenece) ? 'style="background: #b2d6f5;"' : '' ?>><?= (!empty($row_d['presencia']) ? ($row_d['presencia'] == 1 ? 'SI' : 'NO') : '-') ?></td>
												<!--td class="text-center" <?//= ($elemento_pertenece) ? 'style="background: #b2d6f5;"' : '' ?>><?//= (!empty($row_d['stock']) ? $row_d['stock'] : '-') ?></td-->
												<td class="text-center <?=$color?>" <?= ($elemento_pertenece) ? 'style="background: #b2d6f5;"' : '' ?>><?= (!empty($row_d['motivo']) ? $row_d['motivo'] : '-') ?></td>
												<?
												$fotoImg = "";
												if (!empty($row_d['foto'])) {
													$fotoImg = rutafotoModulo(['foto'=>$row_d['foto'],'modulo'=>'checklist','icono'=>'fal fa-image-polaroid fa-lg btn-outline-primary btn border-0']); 
												}
												?>
												<td class="text-center <?=$color?>" <?= ($elemento_pertenece) ? 'style="background: #b2d6f5;"' : '' ?>><?= (!empty($fotoImg) ? $fotoImg : '-'); ?></td>

										<?
											}
										}

									if ($res) {
										?>
										<td class="text-center" rowspan="1"> - </td>
										<!--td class="text-center" rowspan="1"> - </td-->
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