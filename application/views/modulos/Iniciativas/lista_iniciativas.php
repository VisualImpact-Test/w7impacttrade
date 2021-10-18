<div class="card-datatable">
	<table id="data-table" class="table table-striped table-bordered nowrap" style="font-size:12px;width:100%">
		<thead>
			<tr>
				<th>TOTAL: <?= count($iniciativas) ?></th>
				<th colspan="25"></th>
			</tr>
			<tr>
				<th class="text-center align-middle noVis" >#</th>
				<th class="text-center align-middle">SELECCIONAR</th>
				<th class="text-center align-middle">FECHA</th>
				<th class="text-center align-middle ">PERFIL USUARIO</th>
				<th class="text-center align-middle ">COD USUARIO</th>
				<th class="text-center align-middle">NOMBRE USUARIO</th>
				<th class="text-center align-middle">GRUPO CANAL</th>
				<th class="text-center align-middle">CANAL</th>
				<th class="text-center align-middle hideCol">SUBCANAL</th>
				<?foreach ($segmentacion['headers'] as $k => $v) {?>
					<th class="text-center align-middle" ><?=strtoupper($v['header'])?></th>
				<?}?>
				<th class="text-center align-middle">COD VISUAL</th>
				<th class="text-center align-middle hideCol">COD <?=$this->sessNomCuentaCorto?></th>
				<th class="text-center align-middle hideCol">COD PDV</th>
				<th class="text-center align-middle">PDV</th>
				<th class="text-center align-middle">INICIATIVA</th>
				<th class="text-center align-middle">ELEMENTO</th>
				<th class="text-center align-middle">PRESENCIA</th>
				<th class="text-center align-middle">MOTIVO</th>
				<th class="text-center align-middle">CUENTA CON PRODUCTO</th>
				<th class="text-center align-middle">CANTIDAD</th>
				<th class="text-center align-middle">FOTO</th>
				<th class="text-center align-middle">EDITADO</th>
				<th class="text-center align-middle">VALIDADO</th>
				<th class="text-center align-middle">EDITAR / ESTADO</th>
			</tr>
		</thead>
		<tbody>
			<? $ix = 1; ?>
			<?
			foreach ($iniciativas as $row) {
			?>
				<tr>
					<td class="text-center" style="text-align:center;vertical-align: middle;"><?= $ix; ?></td>
					<td class="text-center" style="text-align:center;vertical-align: middle;"><input name="check" id="check" class="check" type="checkbox" value="<?= $row['idVisitaIniciativaTradDet'] ?>"></td>
					<td class="text-center" style="text-align:center;vertical-align: middle;"><?= !empty($row['fecha']) ? $row['fecha'] : '-' ; ?></td>
					<td class="text-left" style="text-align:center;vertical-align: middle;"><?= !empty($row['tipoUsuario'])?  $row['tipoUsuario'] : '-' ; ?></td>
					<td class="text-center" style="text-align:center;vertical-align: middle;"><?= !empty($row['idUsuario']) ? $row['idUsuario'] : '-'; ?></td>
					<td class="text-left" style="text-align:center;vertical-align: middle;"><?= !empty($row['nombreUsuario'])?  $row['nombreUsuario'] : '-' ; ?></td>
					<td class="text-left" style="text-align:center;vertical-align: middle;"><?= !empty($row['grupoCanal'])? $row['grupoCanal'] : '-'; ?></td>
					<td class="text-left" style="text-align:center;vertical-align: middle;"><?= !empty($row['canal'])? $row['canal'] : '-'; ?></td>
					<td class="text-left" style="text-align:center;vertical-align: middle;"><?= !empty($row['subCanal'])? $row['subCanal'] : '-'; ?></td>
					<?foreach ($segmentacion['headers'] as $k => $v) {?>
						<td class="text-left"><?= (!empty($row[($v['columna'])]) ? $row[($v['columna'])] : '-') ?></td>
					<?}?>
					<td class="text-center" style="text-align:center;vertical-align: middle;"><?= !empty($row['idCliente'])? $row['idCliente'] : '-'; ?></td>
					<td class="text-center" style="text-align:center;vertical-align: middle;"><?= !empty($row['codCliente'])? $row['codCliente'] : '-'; ?></td>
					<td class="text-center" style="text-align:center;vertical-align: middle;"><?= !empty($row['codDist'])? $row['codDist'] : '-'; ?></td>
					<td class="text-left" style="text-align:center;vertical-align: middle;"><?= !empty($row['razonSocial'])? $row['razonSocial'] : '-'; ?></td>
					<td class="text-left" style="text-align:center;vertical-align: middle;"><?= !empty($row['iniciativa'])? $row['iniciativa'] : '-'; ?></td>
					<td class="text-left" style="text-align:center;vertical-align: middle;"><?= !empty($row['elementoIniciativa'])? $row['elementoIniciativa'] : '-'; ?></td>
					<td class="text-center" style="text-align:center;vertical-align: middle;"><?= ($row['presencia'] == 1) ? 'SI' : 'NO'; ?></td>
					<td class="text-center" style="text-align:center;vertical-align: middle;"><?= !empty($row['estadoIniciativa'])? $row['estadoIniciativa'] : '-'; ?></td>
					<td class="text-center" style="text-align:center;vertical-align: middle;"><?= !empty($row['cuentaConProducto'])? 'SI' : 'NO'; ?></td>
					<td class="text-center" style="text-align:center;vertical-align: middle;"><?= ($row['cantidad'] > 0) ? $row['cantidad'] : '-'; ?></td>
					<?
					if(!empty($row['foto'])){
						$foto = ' <a href="javascript:;" style="margin-right:3px;font-size: 15px;" class="lk-show-foto" data-modulo="iniciativa" data-foto="' . ($row['foto']) . '" ><i class="fa fa-camera" ></i></a> ';
					}
					?>
					<td class="text-center" style="text-align:center;vertical-align: middle;"><?= (!empty($row['foto'])) ? $foto : '-' ;?></td>
					<!--ANALISTA -->
					<td class="text-center" style="text-align:center;vertical-align: middle;"><?= ($row['editado'] == 1) ? 'SI' : 'NO'; ?></td>
					<td class="text-center" style="text-align:center;vertical-align: middle;"><?= ($row['validacion_ejecutivo'] == 1) ? 'SI' : 'NO'; ?></td>
					<?
					if ($row['validacion_analista'] == 1) {
						if ($row['presencia'] == 1) {
							$edicion = '<a href="javascript:;" style="margin-right:5px;" class="btn-editar-iniciativas" data-id="' . $row['idVisitaIniciativaTradDet'] . '" title="Editar"><i class="fa fa-pencil" style="font-size: 16px;"></i></a>
						<span id="spanValidacion-' . $row['idVisitaIniciativaTradDet'] . '">HABILITADO</span><a id="hrefValidacion-' . $row['idVisitaIniciativaTradDet'] . '" href="javascript:;" style="margin-left:5px;" class="btn-actualizar-validacion-analista" data-id="' . $row['idVisitaIniciativaTradDet'] . '" data-validacion="1" title="Habilitar/Inhabilitar"><i class="fad fa-sync-alt" style="font-size: 16px;"></i></a>';
						} else {
							$edicion = '<span id="spanValidacion-' . $row['idVisitaIniciativaTradDet'] . '">HABILITADO</span><a id="hrefValidacion-' . $row['idVisitaIniciativaTradDet'] . '" href="javascript:;" style="margin-left:5px;" class="btn-actualizar-validacion-analista" data-id="' . $row['idVisitaIniciativaTradDet'] . '" data-validacion="1" title="Habilitar/Inhabilitar"><i class="fad fa-sync-alt" style="font-size: 16px;"></i></a>';
						}
					} else {
						if ($row['presencia'] == 1) {
							$edicion = '<a href="javascript:;" style="margin-right:5px;" class="btn-editar-iniciativas" data-id="' . $row['idVisitaIniciativaTradDet'] . '" title="Editar"><i class="fa fa-pencil" style="font-size: 16px;"></i></a>
						<span id="spanValidacion-' . $row['idVisitaIniciativaTradDet'] . '">INHABILITADO</span><a id="hrefValidacion-' . $row['idVisitaIniciativaTradDet'] . '" href="javascript:;" style="margin-left:5px;" class="btn-actualizar-validacion-analista" data-id="' . $row['idVisitaIniciativaTradDet'] . '" data-validacion="1" title="Habilitar/Inhabilitar"><i class="fad fa-sync-alt" style="font-size: 16px;"></i></a>';
						} else {
							$edicion = '<span id="spanValidacion-' . $row['idVisitaIniciativaTradDet'] . '">INHABILITADO</span><a id="hrefValidacion-' . $row['idVisitaIniciativaTradDet'] . '" href="javascript:;" style="margin-left:5px;" class="btn-actualizar-validacion-analista" data-id="' . $row['idVisitaIniciativaTradDet'] . '" data-validacion="1" title="Habilitar/Inhabilitar"><i class="fad fa-sync-alt" style="font-size: 16px;"></i></a>';
						}
					}
					?>
					<td class="text-center" style="text-align:center;vertical-align: middle;"><?= $edicion; ?></td>
					<!--EJECUTIVO-->
					<!--<td class="text-center" style="text-align:center;vertical-align: middle;">
				<? if ($row['presencia'] == 1) { ?>
				<a href="javascript:;" style="margin-right:5px;" class="btn-editar-iniciativas" data-id="<?= $row['idVisitaIniciativaTradDet'] ?>"><i class="fa fa-pencil-square-o" style="font-size: 16px !important;"></i></a>
				<? } ?>
				<input name="check" id="check" class="check" type="checkbox" value="<?= $row['idVisitaIniciativaTradDet'] ?>">
			</td>-->
				</tr>
			<? $ix++;
			} ?>
		</tbody>
	</table>
</div>