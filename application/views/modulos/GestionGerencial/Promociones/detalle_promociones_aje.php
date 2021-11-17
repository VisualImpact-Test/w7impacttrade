<div class="card-datatable">
	<table id="tb-promociones" class="mb-0 table table-bordered text-nowrap" width="100%">
		<thead>
			<tr>
				<th class="text-center align-middle noVis" >#</th>
				<th class="text-center align-middle" >FECHA</th>
				<th class="text-center align-middle" >NOMBRE USUARIO</th>
				<th class="text-center align-middle" >GRUPO CANAL</th>
				<th class="text-center align-middle" >CANAL</th>
				<th class="text-center align-middle hideCol" >SUBCANAl</th>
				<?foreach ($segmentacion['headers'] as $k => $v) {?>
					<th class="text-center align-middle" ><?=strtoupper($v['header'])?></th>
				<?}?>
				<th class="text-center align-middle hideCol" >DEPARTAMENTO</th>
				<th class="text-center align-middle hideCol" >PROVINCIA</th>
				<th class="text-center align-middle hideCol" >DISTRITO</th>
				<th class="text-center align-middle" >COD VISUAL</th>
				<th class="text-center align-middle" >COD <?=$this->sessNomCuentaCorto?></th>
				<th class="text-center align-middle" >PDV</th>
				<th class="text-center align-middle" >CATEGORIA</th>
				<th class="text-center align-middle" >MARCA</th>
				<th class="text-center align-middle" >FORMATO</th>
				<th class="text-center align-middle" >PRECIO OFERTA</th>
				<th class="text-center align-middle" >TIPO PROMOCIÓN</th>
				<th class="text-center align-middle" >PROMOCIÓN</th>
				<th class="text-center align-middle" >FOTO</th>
				<th class="text-center align-middle" >FECHA INICIO</th>
				<th class="text-center align-middle" >FECHA FIN</th>

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
					<td class="text-center"><?= date_change_format($row['fecha']) ?></td>
					<td class=""><?= (!empty($row['nombreUsuario']) ? $row['nombreUsuario'] : '-') ?></td>
					<td class="text-center"><?= (!empty($row['grupoCanal']) ? $row['grupoCanal'] : '-') ?></td>
					<td class="text-center"><?= (!empty($row['canal']) ? $row['canal'] : '-') ?></td>
					<td class="text-center"><?= (!empty($row['subCanal']) ? $row['subCanal'] : '-') ?></td>
					<?foreach ($segmentacion['headers'] as $k => $v) {?>
						<td class="text-left"><?= (!empty($row[($v['columna'])]) ? $row[($v['columna'])] : '-') ?></td>
					<?}?>
					<td class="text-center"><?= (!empty($row['departamento']) ? $row['departamento'] : '-') ?></td>
					<td class="text-center"><?= (!empty($row['provincia']) ? $row['provincia'] : '-') ?></td>
					<td class="text-center"><?= (!empty($row['distrito']) ? $row['distrito'] : '-') ?></td>
					<td class="text-center"><?= (!empty($row['idCliente']) ? $row['idCliente'] : '-') ?></td>
					<td class="text-center"><?= (!empty($row['codCliente']) ? $row['codCliente'] : '-') ?></td>
					<td class="text-left"><?= (!empty($row['razonSocial']) ? $row['razonSocial'] : '-') ?></td>
					<td class="text-left"><?= (!empty($row['categoria']) ? $row['categoria'] : '-') ?></td>
					<td class="text-left"><?= (!empty($row['marca']) ? $row['marca'] : '-') ?></td>
					<td class="text-center"><?= (!empty($row['formato']) ? $row['formato'] : '-') ?></td>
					<td class="text-right "><?= (!empty($row['precio']) ? moneda($row['precio']) : '-') ?></td>
					<td class="text-center"><?= (!empty($row['tipoPromocion']) ? $row['tipoPromocion'] : '-') ?></td>
					<td class="text-left"><?= (!empty($row['promocion']) ? ($row['promocion']) : '-') ?></td>

					<?
					if (!empty($row['foto'])) {
						$fotoImg = rutafotoModulo(['modulo'=>'promociones','foto'=>$row['foto'],'icono'=>'fal fa-image-polaroid fa-lg btn-outline-secondary btn border-0']);
					}
					?>
					<td class="text-center"> <?= (!empty($fotoImg) ? $fotoImg : '-'); ?> </td>
					<td class="text-left"><?= (!empty($row['fechaVigenciaInicio']) ? date_change_format($row['fechaVigenciaInicio']) : '-') ?></td>
					<td class="text-left"><?= (!empty($row['fechaVigenciaFin']) ? date_change_format($row['fechaVigenciaFin']) : '-') ?></td>


				</tr>
			<?} ?>
		</tbody>
	</table>
</div>