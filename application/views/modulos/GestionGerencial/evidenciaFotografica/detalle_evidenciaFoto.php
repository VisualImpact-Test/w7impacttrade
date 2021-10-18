<div class="card-datatable">
	<table id="tb-evidenciaFoto" class="mb-0 table table-bordered text-nowrap" width="100%">
		<thead>
			<tr>
				<th class="text-center noVis" rowspan="3">#</th>
				<!-- <th class="text-center" rowspan="3">INHABILITAR / PDF</th> -->
				<th class="text-center" rowspan="3">FECHA</th>
				<th class="text-center" rowspan="3">PERFIL USUARIO</th>
				<th class="text-center" rowspan="3">NOMBRE USUARIO</th>
				<th class="text-center" rowspan="3">GRUPO CANAL</th>
				<th class="text-center" rowspan="3">CANAL</th>
				<th class="text-center hideCol" rowspan="3">SUBCANAL</th>
				<?$nroHeaders = 9;?>
                <? foreach ($segmentacion['headers'] as $k => $v) { ?>
                    <? $nroHeaders++;?>
                    <th class="text-center" rowspan="3"><?= strtoupper($v['header']) ?></th>
                <? } ?>
				<th class="text-center hideCol" rowspan="3">DEPARTAMENTO</th>
				<th class="text-center hideCol" rowspan="3">PROVINCIA</th>
				<th class="text-center hideCol" rowspan="3">DISTRITO</th>
				<th class="text-center" rowspan="3">COD VISUAL</th>
				<th class="text-center hideCol" rowspan="3">COD <?=$this->sessNomCuentaCorto?></th>
				<th class="text-center hideCol" rowspan="3">COD PDV</th>
				<th class="text-center" rowspan="3">PDV</th>
				<th class="text-center" rowspan="3">TIPO CLIENTE</th>
				<?
				$rows = 0;
				if (count($elementos) > 0) {
					$rows += count($elementos);
				}
				$rows = $rows * 3;
				?>
				<th class="text-center" rowspan="1" colspan="<?= $rows ?>">EVIDENCIAS</th>
			</tr>
			<tr>
				<?
							foreach ($elementos as $idEle => $eleme) {
				?>
								<th class="text-center" colspan="3"><?= $eleme ?></th>
				<?
							}
				?>
			</tr>
			<tr>
				<?
					foreach ($elementos as $idEle => $eleme) {
						?>
						<th class="text-center noVis" rowspan="1">FOTO ANTES</th>
						<th class="text-center noVis" rowspan="1">FOTO DESPUÉS</th>
						<th class="text-center noVis <?=($idEle != 'otros') ? 'hideCol': '' ?>" rowspan="1">COMENTARIO</th>
						<?
					}
				?>

			</tr>
		</thead>
		<tbody>
			<? $i = 1;
			foreach ($visitas as $row) {
				$fotoImgAntes = [];
				$fotoImgDespues = [];

			?>
				<tr>
					<td class="text-center"><?= $i++; ?></td>
					<!-- <td class="text-center">
						<input name="check[]" id="check" class="check" type="checkbox" value="<?= $row['idVisita']; ?>" />
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
								foreach ($elementos as $idEle => $eleme) {
									$res = true;
									$fotoImgAntes = [];
									$fotoImgDespues = [];
										if ( !empty($detalle[$row['idVisita']][$idEle]) ) {
											$row_d=$detalle[$row['idVisita']][$idEle];
											if ($row_d['idTipoFoto'] == $idEle) {
												
												$res = false;
												$elemento_pertenece = false;
												?>
												<?
												if(!empty($fotos[$row_d['idVisita']][$row_d['idTipoFoto']][1])){
													foreach($fotos[$row_d['idVisita']][$row_d['idTipoFoto']][1] as $foto){
														!empty($foto) ? $fotoImgAntes[] = $foto : '' ; 
													}
												}
												if (!empty($fotoImgAntes)) {
													$icoFoto = '<a href="javascript:;" class="lk-tarea-foto" data-perfil="'.(!empty($row['tipoUsuario'])? $row['tipoUsuario'] : '').' "  data-usuario="'.(!empty($row['nombreUsuario'])? $row['nombreUsuario'] : '').' "  data-cliente="'.(!empty($row['razonSocial'])? $row['razonSocial'] : '').'" data-content="img-fotoprincipal-' . $row_d['idVisita'] . '-' . $row_d['idTipoFoto'] . '" data-fotos="'.implode(',',$fotoImgAntes).'">
													'.count($fotoImgAntes).' <i class="fa fa-camera"></i></a>';
												}

												?>
												<td class="text-center" <?= ($elemento_pertenece) ? 'style="background: #b2d6f5;"' : '' ?>><?= (!empty($fotoImgAntes) ? $icoFoto  : '-'); ?></td>

												<?
												if(!empty($fotos[$row_d['idVisita']][$row_d['idTipoFoto']][2])){
													foreach($fotos[$row_d['idVisita']][$row_d['idTipoFoto']][2] as $foto){
														!empty($foto) ? $fotoImgDespues[] = $foto : '' ; 
													}
												}
												if (!empty($fotoImgDespues)) {
													$icoFoto = '<a href="javascript:;" class="lk-tarea-foto" data-perfil="'.(!empty($row['tipoUsuario'])? $row['tipoUsuario'] : '').' "  data-usuario="'.(!empty($row['nombreUsuario'])? $row['nombreUsuario'] : '').' "  data-cliente="'.(!empty($row['razonSocial'])? $row['razonSocial'] : '').'" data-content="img-fotoprincipal-' . $row_d['idVisita'] . '-' . $row_d['idTipoFoto'] . '" data-fotos="'.implode(',',$fotoImgDespues).'">
													'.count($fotoImgDespues).' <i class="fa fa-camera"></i></a>';
												}

												?>
												<td class="text-center" <?= ($elemento_pertenece) ? 'style="background: #b2d6f5;"' : '' ?>><?= (!empty($fotoImgDespues) ? $icoFoto  : '-'); ?></td>

												<td class="text-left" <?= ($elemento_pertenece) ? 'style="background: #b2d6f5;"' : '' ?>><?= (!empty($row_d['comentario']) ? ($row_d['comentario']) : '-') ?></td>

										<?
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
					?>



				</tr>
			<?
			} ?>
		</tbody>
	</table>
</div>