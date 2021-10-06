<div class="row themeWhite">
	<div class="col-md-12">
		<div class="mb-3 card">
			<div class="card-header">
				REGISTRAR MODULACIÓN MASIVA
			</div>
			<div class="card-body">
				<form id="frm-registrarModulacionMasiva">
					<div class="hide">
						<? $permisoAnterior = !empty($dataPermisoAnterior) ? $dataPermisoAnterior['idPermiso'] : ""; ?>
						<input type="text" class="form-control" id="permisoAnterior" name="permisoAnterior" value="<?=$permisoAnterior?>">
					</div>

					<div class="row">
						<div class="hide">
							<input type="text" name="masivoPermiso" id="masivoPermiso" value="<?=$dataPermiso['idPermiso']?>">
							<input type="text" name="fecIniLista" id="fecIniLista" value="<?=$dataPermiso['fecIniLista']?>">
							<input type="text" name="fecFinLista" id="fecFinLista" value="<?=$dataPermiso['fecFinLista']?>">
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="table-responsive">
								<table class="table table-striped table-bordered nowrap table-sm" width="100%">
									<thead>
										<tr>
											<th class="text-center">FECHA INICIO CARGA</th>
											<th class="text-center">FECHA FIN CARGA</th>
											<th class="text-center">FECHA INICIO LISTA</th>
											<th class="text-center">FECHA FIN LISTA</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="text-center"><label><i class="fas fa-hourglass-half"></i> <?=$dataPermiso['fecIniCarga']?></label></td>
											<td class="text-center"><label><i class="fas fa-hourglass-half"></i> <?=$dataPermiso['fecFinCarga']?></label></td>
											<td class="text-center"><label><i class="fas fa-calendar-week"></i> <?=$dataPermiso['fecIniLista']?></label></td>
											<td class="text-center"><label><i class="fas fa-calendar-week"></i> <?=$dataPermiso['fecFinLista']?></label></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="row">
						<a href="<?=base_url()?>configuraciones/master/modulacion/generar_formato" class="btn-outline-primary border-0" target="_blank" style="padding:10px;margin-left:10px;border-radius: 13px;outline: blue;">  Descargar Formato</a>
						
						<center>
						<input id="archivo" type="file" name="archivo" accept=".csv" style="margin-left:10px;">
						<!--<button
							type="button" 
							data-toggle="collapse" 
							class="btn-outline-primary border-0 carga_masiva_general" 
							style="padding:10px;margin-left:10px;border-radius: 13px;outline: blue;"
							
							data-tipo="1"
							data-id="<?=$dataPermiso['idPermiso']?>"
							data-fecIni="<?=$dataPermiso['fecIniLista']?>"
							data-fecFin="<?=$dataPermiso['fecFinLista']?>"
						>
							Cargar Data
						</button>-->
						<button type="button" data-toggle="collapse" class="btn-outline-primary border-0" style="padding:10px;margin-left:10px;border-radius: 13px;outline: blue;" onclick="Modulacion.validarCargaModulacion();">Cargar Data</button>
						</center>
					
					</div>
					<div class="tab-content">
						<div class="table-responsive"><!-- style="width: 100%;"-->
							<div id="cargas_detalles" style="margin-top:40px;text-align:center;">
								<? if(count($data_carga)>0){?>
									<table class="table table-striped table-bordered nowrap table-sm">
										<thead>
											<tr>
												<th>IDCARGA</th>
												<th>FECHA CARGA</th>
												<th>HORA CARGA</th>
												<th>HORA FIN</th>
												<th>TOTAL FILAS EXCEL</th>
												<th>TOTAL CLIENTES</th>
												<th>TOTAL CLIENTES PROCESADOS</th>
												<th>TOTAL CLIENTES NO PROCESADOS</th>
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
													<td id="clientes_<?=$row['idCarga']?>"><?=$row['totalClientes']?></td>
													<td id="procesados_<?=$row['idCarga']?>"><?=$row['total_procesados']?></td>
													<td id="noprocesados_<?=$row['idCarga']?>"><?=$row['noProcesados']?></td>
													<td id="errores_<?=$row['idCarga']?>">-</td>
													<td class="text-center" id="barraprogreso_<?=$row['idCarga']?>">
														<?
															$porcentaje = 0;
															if( !empty($row['totalRegistros']) )
																$porcentaje = round(($row['total_procesados']+$row['noProcesados'])/$row['totalRegistros']*100,0);
														?>
														<?=($row['estado']==1)?'Registrando data en Base de datos.':'procesando';?><br>
														<meter min="0" max="100" low="0" high="0" optimum="100" value="<?=$porcentaje?>" style="font-size:20px;">
													</td>
												</tr>
											<? } ?>
										</tbody>
									</table>
								<? } else { ?>
									<div>
										<h4 style="border: 1px solid;
    background: #f2f2f2;
    padding: 20px;
    width: 50%;
    margin: auto;
    text-transform: uppercase;
}">Aun no ha realizado ninguna carga. </h4>
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

function validar_estado_carga() {
		$.ajax({
			type: "POST",
			dataType: 'JSON',
			url: site_url+'configuraciones/master/modulacion/estado_carga/',
			success: function(data) {
				var len = data.data.length;
				
				for(var i=0; i<len; i++){
					$('#procesados_'+data.data[i].idCarga).html(data.data[i].total_procesados);
					$('#clientes_'+data.data[i].idCarga).html(data.data[i].totalClientes);
					$('#horaFin_'+data.data[i].idCarga).html(data.data[i].horaFin);
					
					
					$('#noprocesados_'+data.data[i].idCarga).html(data.data[i].noProcesados);
					if(data.data[i].error>0){
						$('#errores_'+data.data[i].idCarga).html('<a href="<?=base_url()?>configuraciones/master/modulacion/generar_formato_errores/'+data.data[i].idCarga+'" class="btn-outline-primary border-0" target="_blank"> DESCARGAR ERRORES</a>');
					}
					if(data.data[i].totalProcesados!=data.data[i].total){
						var total=0;
						if(data.data[i].totalClientes>0){
						total = Math.round((data.data[i].total_procesados+data.data[i].noProcesados)/data.data[i].totalClientes*100);
						}
						var html=""+String(total)+"%<br><meter min='0' max='100' low='0' high='0' optimum='100' value='"+total+"' style='font-size:20px;'>";
						$('#barraprogreso_'+data.data[i].idCarga).html(html);
					} else{
						var total=0;
						if(data.data[i].totalClientes>0){
						total = Math.round((data.data[i].total_procesados+data.data[i].noProcesados)/data.data[i].totalClientes*100);
						}
						var html=""+String(total)+"% <br><meter min='0' max='100' low='0' high='0' optimum='100' value='"+total+"' style='font-size:20px;'>";
						$('#barraprogreso_'+data.data[i].idCarga).html(html);
					}
				}
			}
		});
	}
setInterval(validar_estado_carga, 10000);
</script>