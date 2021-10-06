<div class="card-datatable">
	<table id="tb-preciomarcado" class="mb-0 table table-bordered text-nowrap" width="100%">
		<thead>
			<tr>
				<th rowspan="2" class="text-center noVis">#</th>
				<th rowspan="2" class="text-center">FECHA</th>
				<th rowspan="2" class="text-center">GRUPO CANAL</th>
				<th rowspan="2" class="text-center">CANAL</th>
				<th rowspan="2" class="text-center hideCol">SUB CANAL</th>
				<? foreach ($segmentacion['headers'] as $k => $v) { ?>
					<th class="text-center" rowspan="2"><?= strtoupper($v['header']) ?></th>
				<? } ?>
				<th rowspan="2" class="text-center">COD VISUAL</th>
				<th rowspan="2" class="text-center hideCol">COD <?= $this->sessNomCuentaCorto ?></th>
				<th rowspan="2" class="text-center hideCol">COD PDV</th>
				<th rowspan="2" class="text-center">PDV</th>
				<th rowspan="2" class="text-center">TIPO CLIENTE</th>
				<th rowspan="2" class="text-center hideCol">DEPARTAMENTO</th>
				<th rowspan="2" class="text-center hideCol">PROVINCIA</th>
				<th rowspan="2" class="text-center hideCol">DISTRITO</th>
				<th rowspan="2" class="text-center">PERFIL USUARIO</th>
				<th rowspan="2" class="text-center">NOMBRE USUARIO</th>

				<th colspan="3" class="text-center">INCIDENCIA</th>
				<?
				if (count($elementos) > 0) {
				?>
					<th colspan="<?= count($elementos) * 1 ?>">ELEMENTOS OBLIGATORIOS</th>
				<?
				}
				?>
				<th rowspan="2" class="text-center">TOTAL PM</th>
				<th rowspan="2" class="text-center">FRECUENCIA</th>
			</tr>
			<tr>
				<th rowspan="1" class="text-center">TIPO</th>
				<th rowspan="1" class="text-center">ESTADO</th>
				<th rowspan="1" class="text-center">OBSERVACION</th>
				<? foreach ($elementos as $row) { ?>
					<th colspan="1" class="noVis"><?= $row['nombre'] ?></th>
				<? } ?>
			</tr>
		</thead>
		<tbody>
			<? $i = 1;
			foreach ($visitas as $row) { ?>
				<tr>
					<td><?= $i ?></td>
					<td class="text-center"><?= verificarEmpty($row['fecha'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['grupoCanal'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['canal'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['subCanal'], 3) ?></td>
					<? foreach ($segmentacion['headers'] as $k => $v) { ?>
						<td class="text-<?= (!empty($row[($v['columna'])]) ? $v['align'] : 'left') ?>"><?= (!empty($row[($v['columna'])]) ? $row[($v['columna'])] : '-') ?></td>
					<? } ?>
					<td class="text-center"><?= verificarEmpty($row['idCliente'], 3) ?></td>
					<td class="text-center"><?= verificarEmpty($row['codCliente'], 3) ?></td>
					<td class="text-center"><?= verificarEmpty($row['codDist'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['razonSocial'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['clienteTipo'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['departamento'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['provincia'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['distrito'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['tipoUsuario'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['usuario'], 3) ?></td>

					<td class="text-center"><?= verificarEmpty($row['nombreIncidencia'], 3) ?></td>
					<td class="text-center"><?= ($row['estadoIncidencia'] == 1) ? 'Activo' : 'Inactivo'; ?></td>
					<td class="text-left"><?= verificarEmpty($row['observacion'], 3) ?></td>

					<? foreach ($elementos as $row_e) { ?>
						<? if (!empty($elementos_visita[$row['idListVisibilidadTradObl']][$row['idGrupoCanal']][$row_e['idElementoVis']])) { ?>
							<? if (isset($resultado_obligatorio[$row['idVisita']][$row_e['idElementoVis']][4]['presencia'])) { ?>
								<td class="text-center"><?= ($resultado_obligatorio[$row['idVisita']][$row_e['idElementoVis']][4]['presencia'] == 1) ? '1' : '0' ?></td>
							<? } else { ?>
								<td class="text-center" style="background-color: white;">-</td>
							<? } ?>
						<? } else { ?>
							<td class="text-center" style="background-color: gray;">-</td>
						<? } ?>
					<? } ?>

					<td class="text-center"><?= !empty($data_resultados[$row['idVisita']]['porcentajePM']) ? $data_resultados[$row['idVisita']]['porcentajePM'] . '%' : '-'; ?></td>
					<td class="text-center"><?= !empty($row['frecuencia']) ? $row['frecuencia'] : ' - ' ?></td>
				</tr>
			<? $i++;
			} ?>
		</tbody>
	</table>
</div>