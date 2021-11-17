<?
$addTH = 0;
$obliColumn = 2 + count($visibColumn);
if (!empty($obligatorios)) {
	$addTH = 1;
}
?>
<style>
.reporte_visibilidad button.btn.btn-sm.btn-outline-trade-visual.buttons-excel.buttons-html5 { 
    display: none !important;
}
</style>
<div class="card-datatable reporte_visibilidad">
	<table id="tb-auditoria" class="table table-striped table-bordered nowrap" width="100%">
		<thead>
			<tr>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-general noVis">#</th>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-general">FECHA</th>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-general">GRUPO CANAL</th>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-general">CANAL</th>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-general hideCol">SUB CANAL</th>
				<? foreach ($segmentacion['headers'] as $k => $v) { ?>
					<th class="bg-general text-center" rowspan="<?= 2 + $addTH ?>"><?= strtoupper($v['header']) ?></th>
				<? } ?>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-general">COD VISUAL</th>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-general hideCol">COD <?= $this->sessNomCuentaCorto ?></th>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-general hideCol">COD PDV</th>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-general">PDV</th>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-general">TIPO CLIENTE</th>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-general hideCol">DEPARTAMENTO</th>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-general hideCol">PROVINCIA</th>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-general hideCol">DISTRITO</th>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-general">PERFIL USUARIO</th>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-general">NOMBRE USUARIO</th>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-general">ORDEN<br>DE TRABAJO</th>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-general">MODULACIÓN<br>CORRECTA</th>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-general">FOTOS</th>

				<th rowspan="1" colspan="3" class="bg-general">INCIDENCIA</th>

				<th rowspan="<?= 2 + $addTH ?>" class="bg-general">TOTAL PRESENTES<br>(EO + AD)</th>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-obligatorio">TOTAL EO<br>PRESENTES</th>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-obligatorio">TOTAL EO<br>NO PRESENTES</th>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-obligatorio">TOTAL EO</th>
				<? if (count($obligatorios) > 0) { ?>
					<th rowspan="1" colspan="<?= count($obligatorios) * $obliColumn ?>" class="bg-obligatorio">ELEMENTOS OBLIGATORIOS</th>
				<? } ?>
				<? if (count($adicionales) > 0) { ?>
					<th rowspan="1" colspan="<?= count($adicionales) ?>" class="bg-adicional">ELEMENTOS ADICIONALES</th>
				<? } ?>
				<? if (count($iniciativas) > 0) { ?>
					<th rowspan="1" colspan="<?= count($iniciativas) ?>" class="bg-iniciativa">INICIATIVAS</th>
				<? } ?>

				<th rowspan="<?= 2 + $addTH ?>" class="bg-obligatorio" title="TOTAL OBLIGATORIOS">TOTAL EO (60%)</th>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-adicional" title="TOTAL ADICIONALES">TOTAL ADIC. (10%)</th>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-iniciativa" title="TOTAL INICIATIVAS">TOTAL INIC. (30%)</th>
				<? foreach ($clienteTipo as $row) { ?>
					<th rowspan="<?= 2 + $addTH ?>" class="bg-general"><?= $row['nombre'] ?></th>
				<? } ?>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-general" title="TOTAL VISIBILIDAD">TOTAL VIS.</th>
				<th rowspan="<?= 2 + $addTH ?>" class="bg-general">FRECUENCIA</th>
			</tr>
			<tr>
				<th rowspan="<?= 1 + $addTH ?>" class="bg-general">TIPO</th>
				<th rowspan="<?= 1 + $addTH ?>" class="bg-general">ESTADO</th>
				<th rowspan="<?= 1 + $addTH ?>" class="bg-general">OBSERVACION</th>
				<? foreach ($obligatorios as $row) { ?>
					<th rowspan="1" colspan="<?= $obliColumn ?>" class="bg-obligatorio"><?= $row['nombre'] ?></th>
				<? } ?>
				<? foreach ($adicionales as $row) { ?>
					<th rowspan="<?= 1 + $addTH ?>" class="bg-adicional"><?= $row['nombre'] ?></th>
				<? } ?>
				<? foreach ($iniciativas as $row) { ?>
					<th rowspan="<?= 1 + $addTH ?>" class="bg-iniciativa"><?= $row['nombre'] ?></th>
				<? } ?>
			</tr>
			<?
			if (!empty($obligatorios)) {
			?>
				<tr>
					<? foreach ($obligatorios as $row) { ?>
						<th rowspan="1" colspan="1" class="bg-obligatorio noVis" title="POSICIÓN CALIENTE">PC</th>
						<th rowspan="1" colspan="1" class="bg-obligatorio noVis" title="PLANOGRAMA">PL</th>
						<? if (in_array(1, $visibColumn)) { ?><th rowspan="1" colspan="1" class="bg-obligatorio noVis" title="CANTIDAD">CANT</th><? } ?>
						<? if (in_array(2, $visibColumn)) { ?><th rowspan="1" colspan="1" class="bg-obligatorio noVis" title="OBSERVACIÓN">OBS</th><? } ?>
						<? if (in_array(3, $visibColumn)) { ?><th rowspan="1" colspan="1" class="bg-obligatorio noVis" title="FOTO">FOTO</th><? } ?>
					<? } ?>
				</tr>
			<?
			}
			?>
		</thead>
		<tbody>
			<? $i = 1; ?>
			<? foreach ($visitas as $row) { ?>
				<tr data-id-visita="<?= $row['idVisita'] ?>" data-cliente="<?= $row['razonSocial'] ?>" data-usuario="<?= $row['usuario'] ?>" data-perfil="-">
					<td><?= $i ?></td>
					<td class="text-center"><?= verificarEmpty($row['fecha'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['grupoCanal'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['canal'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['subCanal'], 3) ?></td>
					<? foreach ($segmentacion['headers'] as $k => $v) { ?>
						<td class="text-<?= (!empty($row[($v['columna'])]) ? $v['align'] : 'left') ?>"><?= (!empty($row[($v['columna'])]) ? $row[($v['columna'])] : '-') ?></td>
					<? } ?>
					<td class="text-center"><?= verificarEmpty($row['idCliente'], 3) ?></td>
					<td class="text-center"><?= isset($row['codCliente']) && strlen($row['codCliente']) > 0 ? $row['codCliente'] : '-' ?></td>
					<td class="text-center"><?= verificarEmpty($row['codDist'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['razonSocial'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['clienteTipo'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['departamento'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['provincia'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['distrito'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['tipoUsuario'], 3) ?></td>
					<td class="text-left"><?= verificarEmpty($row['usuario'], 3) ?></td>
					<td class="text-left"><?= (!empty($row['ordenTrabajo']) ? $row['ordenTrabajo'] : '-') ?></td>
					<?
					$modulacion = '';
					$modulacionClass = '';
					if (!is_null($row['modulacion']))
						$modulacion = $row['modulacion'] ? 'SI' : 'NO';

					if ($modulacion == 'NO') {
						$modulacionClass = 'class="lk-visib-mod cursor-pointer color-danger"';
					}
					?>
					<td <?= $modulacionClass ?>><?= $modulacion ? $modulacion : '-' ?></td>
					<?
					$fotos = '';
					if (!empty($resultados_foto[$row['idVisita']]['numFotos'])) {
						$fotos = $resultados_foto[$row['idVisita']]['numFotos'] . ' <i class="far fa-camera text-primary"></i>';
					}
					?>
					<td class="text-center<?= (!empty($fotos) ? ' lk-visib-fotos cursor-pointer' : '') ?>"><?= (!empty($fotos) ? $fotos : '-') ?></td>

					<td><?= (!empty($row['nombreIncidencia']) ? $row['nombreIncidencia'] : '-') ?></td>
					<td><?= ($row['estadoIncidencia'] == 1 ? 'ACTIVO' : (!empty($row['nombreIncidencia']) ? 'INACTIVO' : '-')) ?></td>
					<td><?= (!empty($row['observacion']) ? $row['observacion'] : '-') ?></td>

					<td class="text-right"><?= (($row['estadoIncidencia']==1)? '-' : (!empty($total_eo_ad[$row['idVisita']]) ? count($total_eo_ad[$row['idVisita']]) : 0) )  ?></td>
					<td class="text-right"><?= (($row['estadoIncidencia']==1)? '-' : (!empty($total_eo_si[$row['idVisita']]) ? count($total_eo_si[$row['idVisita']]) : 0) )  ?></td>
					<td class="text-right"><?= (($row['estadoIncidencia']==1)? '-' : (!empty($total_eo_no[$row['idVisita']]) ? count($total_eo_no[$row['idVisita']]) : 0) ) ?></td>
					<td class="text-right"><?= (($row['estadoIncidencia']==1)? '-' : (!empty($total_eo[$row['idVisita']]) ? count($total_eo[$row['idVisita']]) : 0)  )?></td>

					<? foreach ($obligatorios as $row_e) { ?>
						<?
						$obliBg = ' bg-gray';
						if (isset($resultados_obligatorios[$row['idVisita']][$row_e['idElementoVis']]))
							$obliBg = '';

						$obli_2 = '-';
						$obli_2_txt = '';
						$estilo_modulado='';
						if (isset($resultados_obligatorios[$row['idVisita']][$row_e['idElementoVis']]['modulado'])) {
							$estilo_modulado = ($resultados_obligatorios[$row['idVisita']][$row_e['idElementoVis']]['modulado']==1)?'style="font-size:15px;color: green;"':'';
						}
						
						if (isset($resultados_obligatorios[$row['idVisita']][$row_e['idElementoVis']][2]['presencia'])) {
							$obli_2 = $resultados_obligatorios[$row['idVisita']][$row_e['idElementoVis']][2]['presencia'];
							$obli_2_txt = " text-obligatorio-{$obli_2}";
						}

						$obli_3 = '-';
						$obli_3_txt = '';
						if (isset($resultados_obligatorios[$row['idVisita']][$row_e['idElementoVis']][3]['presencia'])) {
							$obli_3 = $resultados_obligatorios[$row['idVisita']][$row_e['idElementoVis']][3]['presencia'];
							$obli_3_txt = " text-obligatorio-{$obli_3}";
						}
						?>
						<td class="text-right<?= $obliBg . $obli_2_txt ?>"  <?=$estilo_modulado?>><?= $obli_2 ?></td>
						<td class="text-right<?= $obliBg . $obli_3_txt ?>"  <?=$estilo_modulado?> ><?= $obli_3 ?></td>
						<? if (in_array(1, $visibColumn)) { ?><td class="text-right<?= $obliBg ?>" <?=$estilo_modulado?> ><?= isset($resultados_obligatorios[$row['idVisita']][$row_e['idElementoVis']]['cantidad']) ? $resultados_obligatorios[$row['idVisita']][$row_e['idElementoVis']]['cantidad'] : '-' ?></td><? } ?>
						<? if (in_array(2, $visibColumn)) { ?><td class="text-left<?= $obliBg ?>" <?=$estilo_modulado?> ><?= isset($resultados_obligatorios[$row['idVisita']][$row_e['idElementoVis']][3]['comentario']) ? $resultados_obligatorios[$row['idVisita']][$row_e['idElementoVis']][3]['comentario'] : '-'; ?></td><? } ?>
						<? if (in_array(3, $visibColumn)) { ?>
							<td class="text-right<?= $obliBg ?>" <?=$estilo_modulado?> >
								<? if (isset($resultados_obligatorios[$row['idVisita']][$row_e['idElementoVis']][2]['foto'])) { ?>
									<? $fotoUrl = site_url("controlFoto/obtener_carpeta_foto/visibilidadAuditoria/{$resultados_obligatorios[$row['idVisita']][$row_e['idElementoVis']][2]['foto']}"); ?>
									<img class="lk-visib-zoom cursor-pointer" src="<?= $fotoUrl ?>" style="height: 50px;">
								<? } else echo '-'; ?>
							</td>
						<? } ?>
					<? } ?>

					<? foreach ($adicionales as $row_a) { ?>
						<?
						$adiBg = ' bg-gray';
						if (isset($resultados_adicionales[$row['idVisita']][$row_a['idElementoVis']]))
							$adiBg = '';
						?>
						<td class="text-right<?= $adiBg ?>"><?= isset($resultados_adicionales[$row['idVisita']][$row_a['idElementoVis']]) ? $resultados_adicionales[$row['idVisita']][$row_a['idElementoVis']] : '-'; ?></td>
					<? } ?>

					<? foreach ($iniciativas as $row_i) { ?>
						<?
						$iniBg = ' bg-gray';
						if (isset($resultados_iniciativas[$row['idVisita']][$row_i['idElementoVis']]))
							$iniBg = '';
						?>
						<td class="text-right<?= $iniBg ?>"><?= isset($resultados_iniciativas[$row['idVisita']][$row_i['idElementoVis']]) ? $resultados_iniciativas[$row['idVisita']][$row_i['idElementoVis']] : '-'; ?></td>
					<? } ?>

					<td class="text-right">
						<?
						$porcentajeObli = 0;
						if (isset($resultados_obligatorios[$row['idVisita']]['porcentajeEo']))
							$porcentajeObli = $resultados_obligatorios[$row['idVisita']]['porcentajeEo'];

						echo "{$porcentajeObli}%";
						?>
					</td>
					<td class="text-right">
						<?
						$porcentajeAdi = 0;
						if (isset($resultados_adicionales[$row['idVisita']]['porcentajeAd']))
							$porcentajeAdi = $resultados_adicionales[$row['idVisita']]['porcentajeAd'];

						echo "{$porcentajeAdi}%";
						?>
					</td>
					<td class="text-right">
						<?
						$porcentajeIni = 0;
						if (isset($resultados_iniciativas[$row['idVisita']]['porcentajeI']))
							$porcentajeIni = $resultados_iniciativas[$row['idVisita']]['porcentajeI'];

						echo "{$porcentajeIni}%";
						?>
					</td>
					<? foreach ($clienteTipo as $row_ct) { ?>
						<td>-</td>
					<? } ?>
					<td class="text-right">
						<?
						$porcentajeVI = 0;
						$porcentajeVI = ($porcentajeObli * 60) / 100 + ($porcentajeAdi * 10) / 100 + ($porcentajeIni * 30) / 100;
						$porcentajeVI = round($porcentajeVI, 0);

						echo "{$porcentajeVI}%";
						?>
					</td>
					<td class="text-center"><?= verificarEmpty($row['frecuencia'], 3) ?></td>
				</tr>
			<? $i++;
			} ?>
		</tbody>
	</table>
</div>
<script>
	$(document)
		.off('click', '.lk-visib-zoom')
		.on('click', '.lk-visib-zoom', function() {

			var control = $(this);
			var src = control.attr('src');

			var html = '';
			html += '<div class="row">';
			html += '<div class="col-md-12">';
			html += '<img class="img-thumbnail" src="' + src + '">';
			html += '</div>';
			html += '</div>';

			Fn.showModal({
				id: ++modalId,
				show: true,
				title: 'Foto',
				frm: html,
				btn: [{
					title: 'Cerrar',
					fn: 'Fn.showModal({ id: ' + modalId + ', show: false });'
				}]
			});

		});

	$(document)
		.off('click', '.lk-visib-mod')
		.on('click', '.lk-visib-mod', function() {

			var control = $(this);
			var tr = control.closest('tr');

			var url = 'auditoria/modulacion';
			var data = {
				data: JSON.stringify({
					idVisita: tr.data('idVisita')
				})
			}

			$.when(Fn.ajax({
				url: url,
				data: data
			})).then(function(a) {
				if (a.result == 2) return false;

				Fn.showModal({
					id: ++modalId,
					show: true,
					title: 'Modulación',
					frm: a.data.view,
					btn: [{
						title: 'Cerrar',
						fn: 'Fn.showModal({ id: ' + modalId + ', show: false });'
					}]
				});
			})

		});

	$(document)
		.off('click', '.lk-visib-fotos')
		.on('click', '.lk-visib-fotos', function() {

			var control = $(this);
			var tr = control.closest('tr');

			var url = 'rutas/mostrarFotos';
			var data = {
				data: JSON.stringify(tr.data())
			}

			$.when(Fn.ajax({
				url: url,
				data: data
			})).then(function(a) {
				if (a.result == 2) return false;

				Fn.showModal({
					id: ++modalId,
					show: true,
					title: 'Fotos',
					frm: a.data,
					btn: [{
						title: 'Cerrar',
						fn: 'Fn.showModal({ id: ' + modalId + ', show: false });'
					}]
				});
			})

		});
</script>