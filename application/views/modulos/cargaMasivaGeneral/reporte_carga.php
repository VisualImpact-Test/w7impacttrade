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

