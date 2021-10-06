<div class="row p-3">
	<div class="col-md-12">
		<form id="frm-registrarModulacionMasiva">
			<div class="row">
				<div class="col-md-12 mb-3">
					<h5>Ingresar los siguientes datos:</h5>
				</div>
				<div class="col-md-8">
					<div class="row">
						<label for="fechaLista" class="col-md-2 text-right">Fechas Listas:</label>
						<div class="col-md-7 mb-3">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" style="width: 40px;">
										<i class="fad fa-calendar-alt fa-lg"></i>
									</span>
								</div>
								<input type="text" id="fechaLista" class="form-control text-center rango_fechas" name="fechaLista" value="<?= date("d/m/Y") . ' - ' . date("d/m/Y") ?>" patron="requerido">
							</div>
						</div>
					</div>
					<div class="row">
						<label for="fechaLista" class="col-md-2 text-right">Adjuntar Archivo:</label>
						<div class="col-md-7 mb-3">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" style="width: 40px;">
										<i class="far fa-file-upload fa-lg"></i>
									</span>
								</div>
								<input type="file" id="archivo" class="form-control" name="archivo" style="padding: 3px;" accept=".csv">
							</div>
							<a class="btn btn-link btn-sm" target="_blank" href="<?= base_url('configuraciones/master/modulacion/generar_formato_carga_masiva_alternativa') ?>">
								<i class="fal fa-file-csv fa-lg"></i> Descargar Formato
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-check mb-3 pl-5">
						<input type="checkbox" id="chk-visib-auditoria" class="form-check-input cursor-pointer" name="chk-visib-auditoria" value="1" style="width:23px; height: 23px; margin-left: -2.25rem;" checked>
						<label class="form-check-label cursor-pointer pt-2" for="chk-visib-auditoria">
							Registrar Visibilidad para Auditoria
						</label>
					</div>
					<button type="button" class="btn btn-primary btn-block float-right" onclick="Modulacion.cargaMasivaAlternativa();" data-toggle="collapse">
						<i class="far fa-folder-upload fa-lg"></i> Subir Archivo
					</button>
				</div>
			</div>


			<div class="tab-content">
				<div class="table-responsive">
					<!-- style="width: 100%;"-->
					<div id="cargas_detalles" style="margin-top:40px;text-align:center;">

						<? if (!empty($data_carga)) {
							if (count($data_carga) > 0) { ?>
								<table class="table table-striped table-bordered nowrap table-sm">
									<thead>
										<tr>
											<th>IDCARGA</th>
											<th>FECHA INICIO LISTA</th>
											<th>FECHA FIN LISTA</th>
											<th>FECHA CARGA</th>
											<th>HORA CARGA</th>
											<th>HORA FIN</th>
											<th>TOTAL FILAS EXCEL</th>
											<th>TOTAL FILAS EXCEL CARGADAS</th>
											<th>TOTAL LISTAS PROCESADAS</th>
											<th>TOTAL LISTAS NO PROCESADAS</th>
											<th>ERRORES</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<? foreach ($data_carga as $row) { ?>
											<tr>
												<td><?= $row['idCarga'] ?></td>
												<td><?= $row['fecIniL'] ?></td>
												<td><?= $row['fecFinL'] ?></td>
												<td><?= $row['fecRegistro'] ?></td>
												<td><?= $row['horaRegistro'] ?></td>
												<td id="horaFin_<?= $row['idCarga'] ?>"><?= $row['horaFin'] ?></td>
												<td><?= $row['totalRegistros'] ?></td>
												<td id="clientes_<?= $row['idCarga'] ?>"><?= $row['totalClientes'] ?></td>
												<td id="procesados_<?= $row['idCarga'] ?>"><?= $row['total_procesados'] ?></td>
												<td id="noprocesados_<?= $row['idCarga'] ?>"><?= $row['noProcesados'] ?></td>
												<td id="errores_<?= $row['idCarga'] ?>">-</td>
												<td class="text-center">
													<?
													$porcentaje = 0;
													if (!empty($row['totalClientes']))
														$porcentaje = round(($row['total_procesados']) / ($row['totalClientes']) * 100, 0);
													?>

													<label id="estado_<?= $row['idCarga'] ?>"><?= ($row['estado'] == 1) ? 'Registrando data en Base de datos.' : $porcentaje . "%"; ?></label>
													<br>
													<meter id="barraprogreso_<?= $row['idCarga'] ?>" min="0" max="100" low="0" high="0" optimum="100" value="<?= $porcentaje ?>" style="font-size:20px;">
												</td>
											</tr>
										<? } ?>
									</tbody>
								</table>
							<? } else { ?>
								<div>
									<h4 style="border: 1px solid; background: #f2f2f2; padding: 20px; width: 50%; margin: auto; text-transform: uppercase; }">Aun no ha realizado ninguna carga. </h4>
								</div>
							<? }
						} else { ?>
							<div>
								<h4 style="border: 1px solid; background: #f2f2f2; padding: 20px; width: 50%; margin: auto; text-transform: uppercase; }">Aun no ha realizado ninguna carga. </h4>
							</div>
						<? } ?>
					</div>
					<!--style="overflow: auto;"-->
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('.select2').select2({
			dropdownParent: $("div.modal-content"),
			width: '80%'
		});

		$('.rango_fechas').daterangepicker({
			locale: {
				"format": "DD/MM/YYYY",
				"applyLabel": "Aplicar",
				"cancelLabel": "Cerrar",
				"daysOfWeek": ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
				"monthNames": ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"],
				"firstDay": 1
			},
			parentEl: ".modal-content",
			singleDatePicker: false,
			showDropdowns: false,
			autoApply: true,
		});

	});


	function validar_estado_carga() {
		$.ajax({
			type: "POST",
			dataType: 'JSON',
			url: site_url + 'configuraciones/master/modulacion/estado_carga_alternativa/',
			success: function(data) {
				var len = data.data.length;

				for (var i = 0; i < len; i++) {
					$('#procesados_' + data.data[i].idCarga).html(data.data[i].total_procesados);
					$('#clientes_' + data.data[i].idCarga).html(data.data[i].totalClientes);
					$('#horaFin_' + data.data[i].idCarga).html(data.data[i].horaFin);


					$('#noprocesados_' + data.data[i].idCarga).html(data.data[i].noProcesados);
					if (data.data[i].error > 0) {
						$('#errores_' + data.data[i].idCarga).html('<a href="<?= base_url() ?>configuraciones/master/modulacion/generar_formato_errores_alternativa/' + data.data[i].idCarga + '" class="btn-outline-primary border-0" target="_blank"> DESCARGAR ERRORES</a>');
					}
					var html = "";
					var total = 0;
					if (data.data[i].totalClientes != data.data[i].total) {
						if (data.data[i].totalClientes > 0) {
							total = Math.round((data.data[i].totalClientes) / (data.data[i].total) * 100);
						}
						$('#estado_' + data.data[i].idCarga).html("Cargando Archivo <br>" + String(total) + "% ");
						$('#barraprogreso_' + data.data[i].idCarga).attr('value', total);
					} else {
						if (data.data[i].totalClientes > 0) {
							total = Math.round((data.data[i].total_procesados) / (data.data[i].totalClientes) * 100);
						}
						if (total >= 100) {
							$('#estado_' + data.data[i].idCarga).html("Completado");
						} else {
							$('#estado_' + data.data[i].idCarga).html("Generando listas<br>" + String(total) + "% ");
						}
						$('#barraprogreso_' + data.data[i].idCarga).attr('value', total);
					}
				}
			}
		});
	}
	setInterval(validar_estado_carga, 10000);
</script>