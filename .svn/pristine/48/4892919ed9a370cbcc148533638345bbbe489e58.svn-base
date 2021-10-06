<div class="row themeWhite">
	<div class="col-md-12">
		<div class="mb-3 card">
			<div class="card-body">
				<form id="frm-registrarModulacionMasiva">

					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-4" >
							<label>FECHA INICIO</label>
							<input type="text" class="form-control input-sm fecha" id="fecha_ini" name="fecha_ini" value="<?= DATE('d/m/Y');?>">
						</div>

						<div class="col-md-4 col-sm-4 col-xs-4" >
							<label>FECHA FIN</label>
							<input type="text" class="form-control input-sm fecha" id="fecha_fin" name="fecha_fin" value="">
						</div>
					</div>

					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-4">
							<a href="<?=base_url()?>configuraciones/gestion/iniciativaTrad/generar_formato_carga_masiva_alternativa" class="btn-outline-primary border-0" target="_blank" style="padding:10px;margin-left:10px;border-radius: 13px;outline: blue;">  Descargar Formato</a>
						</div>


						<div class="col-md-4 col-sm-4 col-xs-4" >
							<input id="archivo" type="file" name="archivo" accept=".csv" style="margin-left:10px;">
						</div>
						<div class="col-md-4 col-sm-4 col-xs-4" >
							<button type="button" data-toggle="collapse" class="btn-outline-primary border-0" style="padding:10px;margin-left:10px;border-radius: 13px;outline: blue;" onclick="IniciativaTrad.cargaMasivaAlternativa();">Cargar Data</button>
						</div>

						
					</div>

					

					<div class="tab-content">
						<div class="table-responsive"><!-- style="width: 100%;"-->
							<div id="cargas_detalles" style="margin-top:40px;text-align:center;">

								<? if( !empty($data_carga) ){
										if(count($data_carga)>0){?>
											<table class="table table-striped table-bordered nowrap table-sm">
												<thead>
													<tr>
														<th>IDCARGA</th>
														<th>FECHA INICIO</th>
														<th>FECHA FIN</th>
														<th>FECHA CARGA</th>
														<th>HORA CARGA</th>
														<th>HORA FIN</th>
														<th>TOTAL FILAS EXCEL</th>
														<th>TOTAL FILAS CARGADAS</th>
														<th>TOTAL FILAS PROCESADOS</th>
														<th>TOTAL FILAS NO PROCESADOS</th>
														<th>ERRORES</th>
														<th></th>
													</tr>
												</thead>
												<tbody>
													<?foreach($data_carga as $row){?>
														<tr>
															<td><?=$row['idCarga']?></td>
															<td><?=$row['fecI']?></td>
															<td><?=$row['fecF']?></td>
															<td><?=$row['fecRegistro']?></td>
															<td><?=$row['horaRegistro']?></td>
															<td id="horaFin_<?=$row['idCarga']?>"><?=$row['horaFin']?></td>
															<td><?=$row['totalRegistros']?></td>
															<td id="clientes_<?=$row['idCarga']?>"><?=$row['totalRegistros']?></td>
															<td id="procesados_<?=$row['idCarga']?>"><?=$row['total_procesados']?></td>
															<td id="noprocesados_<?=$row['idCarga']?>"><?=$row['noProcesados']?></td>
															<td id="errores_<?=$row['idCarga']?>">-</td>
															<td class="text-center">
																<?
																	$porcentaje = 0;
																	if( !empty($row['totalRegistros']) )
																		$porcentaje = round(($row['total_procesados'])/($row['totalRegistros'])*100,0);
																?>
																<label id="estado_<?=$row['idCarga']?>"><?=($row['estado']==1)?'Registrando data en Base de datos.': $porcentaje."%" ;?></label>
																<br>
																<meter id="barraprogreso_<?=$row['idCarga']?>" min="0" max="100" low="0" high="0" optimum="100" value="<?=$porcentaje?>" style="font-size:20px;">
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
									} 
									else{ ?>
									<div>
										<h4 style="border: 1px solid; background: #f2f2f2; padding: 20px; width: 50%; margin: auto; text-transform: uppercase; }">Aun no ha realizado ninguna carga. </h4>
									</div>
								<? } ?>
							</div><!--style="overflow: auto;"-->
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	$('#fecha_ini').daterangepicker({
		locale: {
			"format": "DD/MM/YYYY",
			"applyLabel": "Aplicar",
			"cancelLabel": "Cerrar",
			"daysOfWeek": ["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
			"monthNames": ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre"],
			"firstDay": 1
		},
		parentEl :"div.modal-content",
		singleDatePicker: true,
		//startDate: start_date,
		showDropdowns: false,
		autoApply: true,
		//autoUpdateInput: false,
	});
	
	$('#fecha_fin').daterangepicker({
		locale: {
		'format': 'DD/MM/YYYY',
		'daysOfWeek': ["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
		'monthNames': ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre"],
		},
		parentEl :"div.modal-content",
		singleDatePicker: true,
		autoUpdateInput: false,
	});	

	$('#fecha_fin').on('apply.daterangepicker', function(ev,picker){
		var control=$(this);
		var name=control.attr('name');
		var fecha_inicio = $("#fecha_ini").val();
		var dateB = moment(picker.startDate.format('YYYY-MM-DD'));
		var dateC = moment(moment(fecha_inicio, "DD/MM/YYYY").format('YYYY-MM-DD'));
		var diferencia  = dateB.diff(dateC, 'days');
		if( diferencia>=0 ) control.val(picker.startDate.format('DD/MM/YYYY'));
		else control.val('');
	});

	$('#fecha_fin').on('blur.daterangepicker', function(ev,picker){
		var control=$(this);
		var fecha=control.val();
		if( !moment(fecha,'DD/MM/YYYY',true).isValid() ) control.val('');

		var fecha_inicio = $("#fecha_ini").val();
		var dateB = moment(moment(fecha, "DD/MM/YYYY").format('YYYY-MM-DD'));
		var dateC = moment(moment(fecha_inicio, "DD/MM/YYYY").format('YYYY-MM-DD'));
		var diferencia  = dateB.diff(dateC, 'days');
		if(diferencia<0) control.val('');
	});
	
});

function validar_estado_carga() {
		$.ajax({
			type: "POST",
			dataType: 'JSON',


			url: site_url+'configuraciones/gestion/iniciativaTrad/estado_carga/',
			
			success: function(data) {
				var len = data.data.length;
				
				for(var i=0; i<len; i++){
					$('#procesados_'+data.data[i].idCarga).html(data.data[i].total_procesados);
					$('#clientes_'+data.data[i].idCarga).html(data.data[i].totalClientes);
					$('#horaFin_'+data.data[i].idCarga).html(data.data[i].horaFin);
					
					
					$('#noprocesados_'+data.data[i].idCarga).html(data.data[i].noProcesados);
					if(data.data[i].error>0){
						$('#errores_'+data.data[i].idCarga).html('<a href="<?=base_url()?>configuraciones/maestros/basemadre/generar_formato_errores_alternativo/'+data.data[i].idCarga+'" class="btn-outline-primary border-0" target="_blank"> DESCARGAR ERRORES</a>');
					}
					var html="";
					var total=0;
					if(data.data[i].totalClientes!=data.data[i].total){
						if(data.data[i].totalClientes>0){
						total = Math.round((data.data[i].totalClientes)/(data.data[i].total )*100);
						}
						$('#estado_'+data.data[i].idCarga).html("Cargando Archivo <br>"+String(total)+"% ");
						$('#barraprogreso_'+data.data[i].idCarga).attr('value',total);
					} else{
						if(data.data[i].totalClientes>0){
						total = Math.round((data.data[i].total_procesados)/(data.data[i].totalClientes )*100);
						}
						if(total>=100){
							$('#estado_'+data.data[i].idCarga).html("Completado");
						}else{
							if(data.data[i].generado=="1"){
								$('#estado_'+data.data[i].idCarga).html("Generando visitas<br>"+String(total)+"% ");
							}else{
								$('#estado_'+data.data[i].idCarga).html("Guardando programacion<br>"+String(total)+"% ");
							}
						}
						$('#barraprogreso_'+data.data[i].idCarga).attr('value',total);
					}
				}
			}
		});
	}
setInterval(validar_estado_carga, 10000);
</script>