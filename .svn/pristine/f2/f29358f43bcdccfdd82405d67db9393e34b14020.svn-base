<div class="row themeWhite">
	<div class="col-md-12">
		<div class="mb-3 card">
			<!--<div class="card-header">
				REGISTRO MASIVA
			</div>-->
			<div class="card-body">
				<form id="frm-registrarModulacionMasiva">

					<div class="row">
						<? $url_moderno = base_url().'formato/base_madre/formato_base_madre_moderno.csv';?>
						<? $url_tradicional = base_url().'formato/base_madre/formato_base_madre_tradicional.csv';?>
						<? if($tipo==2){?>
							<div class="col-lg-12 col-md-12">
								<select class="form-control" id="grupocanal" name="grupocanal" style="margin-bottom:20px;">
									<option value="1">Tradicional</option>
									<!--<option value="2">Moderno</option>-->
								</select>
								
								<a href="<?=$url_tradicional?>" class="btn-outline-primary border-0" target="_blank" style="padding:10px;margin-left:10px;border-radius: 13px;outline: blue;">  Descargar Formato Tradicional</a>
								<!--<a href="<?=$url_moderno?>" class="btn-outline-primary border-0" target="_blank" style="padding:10px;margin-left:10px;border-radius: 13px;outline: blue;">  Descargar Formato Moderno</a>-->
							</div>
						<? } ?>
						<!--<a href="<?=$url?>" class="btn-outline-primary border-0" target="_blank" style="padding:10px;margin-left:10px;border-radius: 13px;outline: blue;">  Descargar Formato</a>-->
					
						<center style="margin-top:20px;">
						<input id="archivo" type="file" name="archivo" accept=".csv" style="margin-left:10px;">
						<button
							type="button" 
							data-toggle="collapse" 
							class="btn-outline-primary border-0 carga_masiva_general" 
							style="padding:10px;margin-left:10px;border-radius: 13px;outline: blue;"
							
							data-tipo="<?=$tipo?>"
							
						>
							Cargar Data
						</button>
						<!--<button type="button" data-toggle="collapse" class="btn-outline-primary border-0" style="padding:10px;margin-left:10px;border-radius: 13px;outline: blue;" onclick="Modulacion.validarCargaModulacion();">Cargar Data</button>-->
						</center>
					
					</div>
					
				</form>
				
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
												<!--<th>TOTAL CLIENTES NO PROCESADOS</th>-->
												<!--<th>ERRORES</th>-->
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?foreach($data_carga as $row){?>
												<tr>
													<td><?=$row['idCarga']?></td>
													<td><?=$row['fechacarga']?></td>
													<td><?=$row['horacarga']?></td>
													<td id="horaFin_<?=$row['idCarga']?>"><?=$row['horaFincarga']?></td>
													<td><?=$row['totalRegistros']?></td>
													<td id="clientes_<?=$row['idCarga']?>"><?=$row['totalClientes']?></td>
													<td id="procesados_<?=$row['idCarga']?>"><?=$row['totalProcesados']?></td>
													<? $noProcesados= $row['totalClientes']- $row['totalProcesados'];?>
													<!--<td id="noprocesados_<?=$row['idCarga']?>"><?=$noProcesados?></td>-->
													<!--<td id="errores_<?=$row['idCarga']?>">-</td>-->
													<td class="text-center" id="barraprogreso_<?=$row['idCarga']?>">
														<?
															$porcentaje = 0;
															if( !empty($row['totalRegistros']) )
																$porcentaje = round(($row['totalProcesados']+$noProcesados)/$row['totalRegistros']*100,0);
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
							</div>
				
				
			</div>
		</div>
	</div>
</div>

<script>

function validar_estado_carga() {
		$.ajax({
			type: "POST",
			dataType: 'JSON',
			url: site_url+'index.php/carga_masiva_general/estado_carga/',
			success: function(data) {
				var len = data.data.length;
				
				for(var i=0; i<len; i++){
					$('#procesados_'+data.data[i].idCarga).html(data.data[i].total_procesados);
					$('#clientes_'+data.data[i].idCarga).html(data.data[i].totalClientes);
					$('#horaFin_'+data.data[i].idCarga).html(data.data[i].horaFin);
					
					
					$('#noprocesados_'+data.data[i].idCarga).html(data.data[i].noProcesados);
					if(data.data[i].error>0){
						$('#errores_'+data.data[i].idCarga).html('<a href="<?=base_url()?>carga_masiva_general/generar_formato_errores/'+data.data[i].idCarga+'" class="btn-outline-primary border-0" target="_blank"> DESCARGAR ERRORES</a>');
					}
					if(data.data[i].totalProcesados!=data.data[i].total){
						var total=0;
						if(data.data[i].totalClientes>0){
						total = Math.round((data.data[i].total_procesados)/data.data[i].totalClientes*100);
						}
						var html=""+String(total)+"%<br><meter min='0' max='100' low='0' high='0' optimum='100' value='"+total+"' style='font-size:20px;'>";
						$('#barraprogreso_'+data.data[i].idCarga).html(html);
					} else{
						var total=0;
						if(data.data[i].totalClientes>0){
						total = Math.round((data.data[i].total_procesados)/data.data[i].totalClientes*100);
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