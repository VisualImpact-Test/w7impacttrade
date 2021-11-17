<div class="row themeWhite">
	<div class="col-md-12">
		<div class="mb-3 card">
			<div class="card-body">
				<form id="frm-registrarModulacionMasiva">
					<?
					$formato_trad=( isset($flagClienteTradicional))? ( ($flagClienteTradicional=="1")? true:false ) : false;
					$formato_moder=( isset($flagClienteModerno))? ( ($flagClienteModerno=="1")? true:false ) : false;

					$ver_formato_trad=false;
					$ver_formato_mode=false;

					if($formato_trad && $formato_moder){
						$ver_formato_trad=true;
					}else if($formato_trad && !$formato_moder){
						$ver_formato_trad=true;
					}else if(!$formato_trad && $formato_moder){
						$ver_formato_mode=true;
					}
					
					?>
					
					<div class="row">
						<div class="col-md-12 mb-3">
							<h5>Ingresar los siguientes datos:</h5>
						</div>
						<div class="col-md-8">
							<div class="row">
								<label for="" class="col-md-2 text-right">Tipo Cliente:</label>
								<div class="col-md-7 mb-3">
									<div class="input-group">
										<div class="position-relative form-check form-check-inline" style="<?= ($formato_trad==true) ? "" : "display:none"  ?>;">
											<label class="form-check-label">
												<input type="radio" name="ch-tipo" value="1" class="form-check-input ch-tipo" <?= ($ver_formato_trad==true) ? "checked" : ""  ?>> TRADICIONAL</label>
										</div>
										<div class="position-relative form-check form-check-inline" style="<?= ($formato_moder==true) ? "" : "display:none"  ?>;">
											<label class="form-check-label">
												<input type="radio" name="ch-tipo" value="2" class="form-check-input ch-tipo" <?= ($ver_formato_mode==true) ? "checked" : ""  ?>> MODERNO</label>
										</div>
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

									<a class="btn btn-link btn-sm" id="div_formato_trad" target="_blank" style="<?= ($ver_formato_trad==true) ? "" : "display:none;"  ?>" href="<?=base_url()?>configuraciones/maestros/basemadre/generar_formato_carga_masiva_alternativa_tradicional">
										<i class="fal fa-file-csv fa-lg"></i> Descargar Formato
									</a>

									<a class="btn btn-link btn-sm" id="div_formato_moder" target="_blank" style="<?= ($ver_formato_mode==true) ? "" : "display:none"  ?>;" href="<?=base_url()?>configuraciones/maestros/basemadre/generar_formato_carga_masiva_alternativa_moderno">
										<i class="fal fa-file-csv fa-lg"></i> Descargar Formato
									</a>
									
									<a class="btn btn-link btn-sm" id="div_maestrro" target="_blank" href="<?=base_url()?>configuraciones/maestros/basemadre/generar_maestros" >
										<i class="fal fa-file-csv fa-lg"></i> Descargar Maestro
									</a>

								</div>
							</div>
						</div>

						<div class="col-md-4">
							<?
								if($mostrarCheckAuditoria){
									?>
										<div class="form-check mb-3 pl-5">
											<input type="checkbox" id="chk-cliente-auditoria" class="form-check-input cursor-pointer" name="chk-cliente-auditoria" value="1" style="width:23px; height: 23px; margin-left: -2.25rem;" checked>
											<label class="form-check-label cursor-pointer pt-2" for="chk-cliente-auditoria">
												Registrar Clientes para Auditoria
											</label>
										</div>
									<?
								}

							?>
							

							<button type="button" class="btn btn-primary btn-block float-right" onclick="Basemadre.cargaMasivaAlternativa();" data-toggle="collapse">
								<i class="far fa-folder-upload fa-lg"></i> Subir Archivo
							</button>
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
	$('.select2').select2({
		dropdownParent: $("div.modal-content"),
		width: '80%'
	});

	$('.rango_fechas').daterangepicker({
		locale: {
			"format": "DD/MM/YYYY",
			"applyLabel": "Aplicar",
			"cancelLabel": "Cerrar",
			"daysOfWeek": ["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
			"monthNames": ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre"],
			"firstDay": 1
		},
		parentEl: ".modal-content",
		singleDatePicker: false,
		showDropdowns: false,
		autoApply: true,
	});

	$("#btn-addUsuario").click( function(e){
		e.preventDefault();
		var cantUsuarios = parseInt($('#cantUsuarios').val()) + 1;
		var idUsuario = $('#usuarios').val();
		var usuario = $('#usuarios option:selected').text();

		if ( idUsuario!='' && usuario!='') {
			var fila ='';
				fila+= '<tr>';
					fila+='<td class="text-center">'+cantUsuarios+'</td>'
					fila+='<td>'+usuario+' <input type="hidden" name="idUsuario" value="'+idUsuario+'">';
						fila+='<input type="hidden" name="usuario" value="'+usuario+'">';
					fila+='</td>';
					fila+='<td class="text-center"><button class="btn-deleteRow btn btn-danger"><i class="fas fa-trash fa-lg"></i></button></td>';
				fila+='</tr>';
			$('#detalle_usuario tbody tr.noData').remove();
			$('#detalle_usuario tbody').append(fila);
			$('#usuarios').select2('val', 'Seleccione Usuario');
			$('#cantUsuarios').val(cantUsuarios);
		}
	});
		
	$(document).on('click','.btn-deleteRow',function(e){
		e.preventDefault();

		var tr = $(this).parents('tr').remove();
	});
	
});


function validar_estado_carga() {
		$.ajax({
			type: "POST",
			dataType: 'JSON',
			url: site_url+'configuraciones/maestros/basemadre/estado_carga_alternativa/',
			
			success: function(data) {
				var len = data.data.length;
				
				for(var i=0; i<len; i++){
					$('#procesados_'+data.data[i].idCarga).html(data.data[i].total_procesados);
					$('#clientes_'+data.data[i].idCarga).html(data.data[i].totalRegistros);
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