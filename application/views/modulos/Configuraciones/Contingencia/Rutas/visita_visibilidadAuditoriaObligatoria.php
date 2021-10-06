<form id="frm-visitaVisibilidadAud">
	<div class="hide">
		<input class="form-control" type="text" id="idVisita" name="idVisita" value="<?=$idVisita?>">
	</div>
	<div class="row themeWhite">
		<div class="col-md-12">
			<div class="mb-3 mt-3 card">
				<div class="card-header">
					EDICIÓN DEL MÓDULO DE VISIBILIDAD AUDITORIA OBLIGATORIA
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="table-responsive">
							<table id="tb-visibilidadObligatoria" class="mb-0 table table-bordered table-sm text-nowrap">
								<thead>
									<tr>
										<th class="text-center align-middle" rowspan="3">#</th>
										<th class="text-center align-middle" rowspan="3">ELEMENTO VISIBILIDAD</th>
										<th class="text-center align-middle" rowspan="3">CANTIDAD</th>
										<th class="text-center align-middle" colspan="<?=(count($listaVariablesVisibilidad)*3)?>">VARIABLES</th>
									</tr>
									<tr>
										<? foreach ($listaVariablesVisibilidad as $klvv => $variables): ?>
											<th class="text-center align-middle" colspan="4"><?=$variables['variableVisibilidad']?><br><?=$variables['nomCorto']?></th>
										<? endforeach ?>
									</tr>
									<tr>
										<? foreach ($listaVariablesVisibilidad as $klvv => $variables): ?>
											<th class="text-center align-middle">PRESENCIA</th>
											<th class="text-center align-middle">OBSERVACIONES</th>
											<th class="text-center align-middle">COMENTARIOS</th>
											<th class="text-center align-middle">FOTOS</th>
										<? endforeach ?>
									</tr>
								</thead>
								<tbody class="tb-visibilidadObligatoria">
									<? $ixt=1; ?>
									<? foreach ($listaElementoVisibilidad as $klev => $elementos): ?>
										<tr class="tr-visibilidadObligatoria">
											<td class="text-center"><?=$ixt++;?></td>
											<td class="text-center"><?=$elementos['elementoVisibilidad'];?></td>
											<td class="text-center">
												<? $cantidadVisita = ( isset($listaVisitas[$klev]['cantidad']) && !empty($listaVisitas[$klev]['cantidad']) ) ? $listaVisitas[$klev]['cantidad']:'';?>
												<input type="text" class="form-control ipWidth" placeholder="Cantidad" id="cantidad-<?=$klev?>"  name="cantidad-<?=$klev?>" value="<?=$cantidadVisita;?>">
											</td>
											<? foreach ($listaVariablesVisibilidad as $klvv => $variables): ?>
												<?
													$visitaVisibilidad = ( isset($listaVisitas[$klev]['listaVariables'][$klvv]['idVisitaVisibilidad']) && !empty($listaVisitas[$klev]['listaVariables'][$klvv]['idVisitaVisibilidad']) ) ? $listaVisitas[$klev]['listaVariables'][$klvv]['idVisitaVisibilidad']:'';
													$visitaVisibilidadDet = ( isset($listaVisitas[$klev]['listaVariables'][$klvv]['idVisitaVisibilidadDet']) && !empty($listaVisitas[$klev]['listaVariables'][$klvv]['idVisitaVisibilidadDet']) ) ? $listaVisitas[$klev]['listaVariables'][$klvv]['idVisitaVisibilidadDet']:'';
												?>
												<td class="hide tr-visibilidadObligatoria-variables" data-elementoVisibilidad="<?=$klev?>" data-variable="<?=$klvv?>" data-visitaVisibilidad="<?=$visitaVisibilidad?>" data-visitaVisibilidadDet="<?=$visitaVisibilidadDet?>">-</td>
												<td class="text-center">
													<? $checkedPresencia = ( isset($listaVisitas[$klev]['listaVariables'][$klvv]['presencia']) && !empty($listaVisitas[$klev]['listaVariables'][$klvv]['presencia']) ) ? 'checked':'';?>
													<div class="custom-checkbox custom-control">
														<input <?=$checkedPresencia;?> class="custom-control-input" type="checkbox" id="presencia-<?=$klev?>-<?=$klvv?>" name="presencia-<?=$klev?>-<?=$klvv?>" value="1" >
														<label class="custom-control-label" for="presencia-<?=$klev?>-<?=$klvv?>"></label>
													</div>
												</td>
												<td class="text-center">
													<? $visitaVariableObservaciones = ( isset($listaVisitas[$klev]['listaVariables'][$klvv]['idObservacion']) && !empty($listaVisitas[$klev]['listaVariables'][$klvv]['idObservacion']) ) ? $listaVisitas[$klev]['listaVariables'][$klvv]['idObservacion']:'';?>
													<select class="form-control slWidth" name="observacion-<?=$klev?>-<?=$klvv?>" id="observacion-<?=$klev?>-<?=$klvv?>">
														<option value="">--- Observaciones ---</option>
														<? foreach ($listaVariablesObs[$klvv]['listaObservaciones'] as $klvo => $observaciones): ?>
															<? $checkedVariableObservaciones = $klvo==$visitaVariableObservaciones ? 'selected':'';?>
															<option value="<?=$observaciones['idObservacion']?>" <?=$checkedVariableObservaciones?>><?=$observaciones['descripcion'];?></option>
														<? endforeach ?>
													</select>
												</td>
												<td class="text-center">
													<? $comentarioVisita = ( isset($listaVisitas[$klev]['listaVariables'][$klvv]['comentario']) && !empty($listaVisitas[$klev]['listaVariables'][$klvv]['comentario']) ) ? $listaVisitas[$klev]['listaVariables'][$klvv]['comentario']:'';?>
													<input type="text" class="form-control ipWidth" placeholder="Comentario" id="comentario-<?=$klev?>-<?=$klvv?>"  name="comentario-<?=$klev?>-<?=$klvv?>" value="<?=$comentarioVisita;?>">
												</td>
												<td class="text-center">
													<? $imagenVisita= ( isset($listaVisitas[$klev]['listaVariables'][$klvv]['idVisitaFoto']) && !empty($listaVisitas[$klev]['listaVariables'][$klvv]['idVisitaFoto']) ) ? $this->fotos_url.'visibilidadAuditoria/'.$listaVisitas[$klev]['listaVariables'][$klvv]['foto']:'';?>
													<div class="row" id="foto-<?=$klev?>-<?=$klvv?>">
														<div class="col">
															<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-<?=$klev?>-<?=$klvv?>">
																<img class="fotoMiniatura foto" name="img-fotoprincipal-<?=$klev?>-<?=$klvv?>" id="img-fotoprincipal-<?=$klev?>-<?=$klvv?>" src="<?=$imagenVisita?>" alt="">
															</a>
														</div>
														<div class="col">
															<div class="content-input-file">
																<input type="text" readonly="readonly" id="txt-fotoprincipal-<?=$klev?>-<?=$klvv?>" name="fotoprincipal-<?=$klev?>-<?=$klvv?>" class="hide" >
																<input type="text" readonly="readonly" id="txt-fotoprincipal-<?=$klev?>-<?=$klvv?>_show" class="text-file" placeholder="Solo .jpg" >
																<span class="btn-file btnFoto" data-file="fl-fotoprincipal-<?=$klev?>-<?=$klvv?>"><i class="fa fa-file-image" aria-hidden="true"></i> Buscar</span>
																<input type="file" id="fl-fotoprincipal-<?=$klev?>-<?=$klvv?>" class="fl-control hide" name="filefotoprincipal-<?=$klev?>-<?=$klvv?>" data-content="txt-fotoprincipal-<?=$klev?>-<?=$klvv?>"  accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal-<?=$klev?>-<?=$klvv?>" >
															</div>
														</div>
													</div>
												</td>
											<? endforeach ?>
										</tr>
									<? endforeach ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>