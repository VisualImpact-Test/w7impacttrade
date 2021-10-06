<div class="row themeWhite">
	<div class="col-md-12">
		<div class="mb-3 card">
			<div class="card-header">
				REGISTRAR VISITAS MASIVA
			</div>
			<div class="card-body">
				<form id="frm-registrarModulacionMasiva">
					<div class="mb-2 mr-sm-2  position-relative form-group ">
						<label>Tipo Usuario</label>
						<select id="tipo" name="tipo" class="form-control form-control-sm my_select2Full sl-width-150">
							<? foreach ($tipoUsuario as $key => $user): ?>
								<option value="<?=$user['idTipoUsuario']?>"><?=$user['nombre']?></option>
							<? endforeach ?>
						</select>
					</div>
					<div class="row">
						<a href="<?=base_url()?>formato/visitas/cargaRutas.csv" class="btn-outline-primary border-0" target="_blank" style="padding:10px;margin-left:10px;border-radius: 13px;outline: blue;">  Descargar Formato</a>
						
						<center>
						<input id="archivo" type="file" name="archivo" accept=".csv" style="margin-left:10px;">
						
						<button type="button" data-toggle="collapse" class="btn-outline-primary border-0" style="padding:10px;margin-left:10px;border-radius: 13px;outline: blue;" onclick="Visitas.cargaVisitasExcel();">Cargar Data</button>
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
												<th>TOTAL CLIENTES PROCESADOS</th>			 
												<th>ERRORES</th>	
												<th></th>
											</tr>
										</thead>
										<tbody>
											<? foreach($data_carga as $row){ ?>
											<tr>
												<td><?=$row['idCarga']?></td>
												<td><?=$row['fechaRegistro']?></td>
												<td><?=$row['horaRegistro']?></td>
												<td id="horaFin_<?=$row['idCarga']?>"><?=$row['horaFinRegistro']?></td>											 
												<td><?=$row['totalRegistros']?></td>
												<td id="procesados_<?=$row['idCarga']?>"><?=$row['total_procesados']?></td>
												<td id="errores_<?=$row['idCarga']?>"></td>													   							  
												<td class="text-center" id="barraprogreso_<?=$row['idCarga']?>">
												<? $porcentaje = 0;
												if( !empty($row['totalRegistros']) )
													$porcentaje = round($row['total_procesados']/$row['totalRegistros']*100,0);
													
													$mensaje=($row['estado']==1)?'Registrando data en Base de datos.':'procesando';
													$html='';
													$html.=$mensaje.'<br>';
													$html.='<meter min="0" max="100" low="0" high="0" optimum="100" value="'.$porcentaje.'" style="font-size:20px;">';
												?>
													<?=$html?>
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
			url: site_url+'configuraciones/gestion/visitas/estado_carga',
			success: function(data) {
				var len = data.data.length;
				
				for(var i=0; i<len; i++){
					$('#procesados_'+data.data[i].idCarga).html(data.data[i].total_procesados);
					$('#horaFin_'+data.data[i].idCarga).html(data.data[i].horaFin);

					if(data.data[i].error>0){
						$('#errores_'+data.data[i].idCarga).html('<a href="<?=base_url()?>configuraciones/gestion/visitas/generar_formato_errores/'+data.data[i].idCarga+'" class="btn-outline-primary border-0" target="_blank"> DESCARGAR ERRORES</a>');
					}
				
						var total=0;
						if(data.data[i].total>0){
						total = Math.round(data.data[i].total_procesados/data.data[i].total*100);
						}
						var html=""+String(total)+"%<br><meter min='0' max='100' low='0' high='0' optimum='100' value='"+total+"' style='font-size:20px;'>";
						$('#barraprogreso_'+data.data[i].idCarga).html(html);
					
				}
			}
		});
	}
setInterval(validar_estado_carga, 10000);
</script>