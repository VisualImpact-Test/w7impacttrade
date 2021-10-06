<?
$html = [
		'tab' => '',
		'eval' => '',
		'modal' => [
				'enc' => '',
				'det' => '',
				'eval' => ''
			]
	];

$iti = $numTienda;
$aPdv = [];
foreach($tienda as $idCliente => $ti){
	$html['tab'] .= '<li id="nav-item-'.$idCliente.'" class="nav-item '.( $iti == 0 ? 'active' : '').'">';
		$html['tab'] .= '<a href="#tab-lsck-tienda-'.$idCliente.'"';
			$html['tab'] .= 'class="nav-link tab-tienda '.( $iti == 0 ? 'active' : '').'"';
			$html['tab'] .= 'role="tab"';
			$html['tab'] .= 'aria-controls="tab-lsck-tienda-'.$idCliente.'"';
			$html['tab'] .= 'data-toggle="tab"';
		$html['tab'] .= '>';
			$html['tab'] .= '<span data-toggle="tooltip" title="'.$ti['nombre'].'" >PDV '.($iti + 1).'</span>';
		$html['tab'] .= '</a>';
	$html['tab'] .= '</li>';
	$aPdv[$idCliente] = $iti + 1;
	$iti++;
}

$iti = $numTienda;
foreach($tienda as $idCliente => $ti){
	$idTipoCliente = $ti['idTipoCliente'];
	$html['eval'] .= '<div id="tab-lsck-tienda-'.$idCliente.'" class="tab-pane fade '.( $iti == 0 ? 'show active' : '' ).'" role="tabpanel">';
		$html['eval'] .= '<input type="hidden" name="tienda" value="'.$idCliente.'">';
		$html['eval'] .= '<input type="hidden" name="tienda-nombre['.$idCliente.']" value="'.$ti['nombre'].'">';
		$html['eval'] .= '<div class="col-md-12">';
			$html['eval'] .= '<label class="h6">';
				$html['eval'] .= '<i class="fas fa-store fa-lg"></i> Razón Social: <b>'.$ti['nombre'].'</b>';
			$html['eval'] .= '</label>';
			$html['eval'] .= '<br>';
			$html['eval'] .= '<label class="h6 mb-3">';
				$html['eval'] .= '<i class="fas fa-clipboard-list fa-lg"></i> Tipo Cliente: <b>'.$ti['tipoCliente'].'</b>';
			$html['eval'] .= '</label>';
		$html['eval'] .= '</div>';
		if( !empty($encuestasTienda) ){
			$html['eval'] .= '<div class="col-md-12">';
				$html['eval'] .= '<div class="btn-group btn-group-sm">';
				foreach($encuestasTienda as $idEncuestaTienda){
					$html['eval'] .= '<button type="button"';
						$html['eval'] .= 'class="btn btn-danger"';
						$html['eval'] .= 'data-toggle="modal"';
						$html['eval'] .= 'data-target="#modal-lsck-tienda-encuesta-'.implode('-', [$idCliente, $idEncuestaTienda]).'"';
					$html['eval'] .= '><i class="far fa-question-circle fa-lg"></i> '.$encuestas[$idEncuestaTienda]['nombre'].'</button>';

					$html['modal']['enc'] .= '<div id="modal-lsck-tienda-encuesta-'.implode('-', [$idCliente, $idEncuestaTienda]).'" class="modal-lsck-form modal fade" tabindex="-1" >';
						$html['modal']['enc'] .= '<div class="modal-dialog">';
							$html['modal']['enc'] .= '<div class="modal-content">';
								$html['modal']['enc'] .= '<div class="modal-header">';
									$html['modal']['enc'] .= '<h5 class="modal-title">'.$encuestas[$idEncuestaTienda]['nombre'].'</h5>';
									$html['modal']['enc'] .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
										$html['modal']['enc'] .= '<span aria-hidden="true">&times;</span>';
									$html['modal']['enc'] .= '</button>';
								$html['modal']['enc'] .= '</div>';
								$html['modal']['enc'] .= '<div class="modal-body">';
									$html['modal']['enc'] .= '<form id="'.$frm.'-tienda-encuesta-'.implode('-', [$idCliente, $idEncuestaTienda]).'">';
										$html['modal']['enc'] .= '<div class="row">';
										if( empty($preguntas[$idEncuestaTienda]) ){
											$html['modal']['enc'] .= '<div class="col-md-12" style="padding: 1rem;">';
												$html['modal']['enc'] .= createMessage([ 'type' => 2, 'message' => 'No se encontró un formato de preguntas, <b>posiblemente el formato este inactivo</b>' ]);
											$html['modal']['enc'] .= '</div>';
										} else{
											$numPreg = 1;
											foreach($preguntas[$idEncuestaTienda] as $idPregunta => $preg){
												$html['modal']['enc'] .= '<div class="col-md-12" style="padding: 1rem;">';
													$html['modal']['enc'] .= '<label>'.$numPreg++.') '.$preg['nombre'];
														$html['modal']['enc'] .= '<input type="hidden" name="tienda-pregunta['.$idCliente.']" value="'.$idPregunta.'">';
													$html['modal']['enc'] .= '</label>';
													if( in_array($preg['tipo'], [2, 3]) ){
														$type = $preg['tipo'] == 2 ? 'radio' : ($preg['tipo'] == 3 ? 'checkbox' : '');
														foreach($alternativas[$idPregunta] as $idAlternativa => $alt){
															$html['modal']['enc'] .= '<div class="'.$type.'" style="padding-left: 1rem;">';
																$html['modal']['enc'] .= '<label class="pointer">';
																	$html['modal']['enc'] .= '<input type="'.$type.'" class="mr-2" name="tienda-alternativa['.$idCliente.']['.$idPregunta.']" value="'.$idAlternativa.'" >'.$alt['nombre'];
																$html['modal']['enc'] .= '</label>';
															$html['modal']['enc'] .= '</div>';
														}
													}
													else{
														$html['modal']['enc'] .= '<input type="text" name="tienda-respuesta['.$idCliente.']['.$idPregunta.']" class="form-control input-sm" placeholder="Escriba una respuesta">';
													}
													$html['modal']['enc'] .= '<div style="padding: 0.5rem 1rem;">';
														$html['modal']['enc'] .= '<label>Comentario:</label>';
														$html['modal']['enc'] .= '<textarea name="tienda-obs['.$idCliente.']['.$idPregunta.']" class="form-control" rows="2" placeholder="Máx. 250 caracteres" maxlength="250"></textarea>';
													$html['modal']['enc'] .= '</div>';
												$html['modal']['enc'] .= '</div>';
											}
										}
										$html['modal']['enc'] .= '</div>';
									$html['modal']['enc'] .= '</form>';
								$html['modal']['enc'] .= '</div>';
								$html['modal']['enc'] .= '<div class="modal-footer">';
									$html['modal']['enc'] .= '<button type="button" class="btn btn-default btn-modal-close" data-id="#modal-lsck-tienda-encuesta-'.implode('-', [$idCliente, $idEncuestaTienda]).'">Cerrar</button>';
								$html['modal']['enc'] .= '</div>';
							$html['modal']['enc'] .= '</div>';
						$html['modal']['enc'] .= '</div>';
					$html['modal']['enc'] .= '</div>';
				}
				$html['eval'] .= '</div>';
			$html['eval'] .= '</div>';
		}
		$html['eval'] .= '<div class="col-md-12 p-4">';
			$html['eval'] .= '<div class="row">';
				$numEval = count($evaluacion[$idTipoCliente]);
				$colmd = $numEval > 2 ? 'col-md-4' : $numEval == 2 ? 'col-md-6' : 'col-md-12';
				foreach($evaluacion[$idTipoCliente] as $idEvaluacion => $ev){
					$html['eval'] .= '<div class="'.$colmd.'">';
						$html['eval'] .= '<div class="row">';
							$html['eval'] .= '<div class="col-md-12">';
								$html['eval'] .= '<div class="row">';
									$html['eval'] .= '<div class="col-md-12">';
										$html['eval'] .= '<h5 class="text-center"><i class="far fa-star fa-lg"></i> Evaluación - '.$ev['nombre'].'</h5>';
										$html['eval'] .= '<input type="hidden" name="evaluacion['.$idCliente.']" value="'.$idEvaluacion.'">';
									$html['eval'] .= '</div>';
								$html['eval'] .= '</div>';
								$html['eval'] .= '<div class="row">';
									$html['eval'] .= '<div class="col-md-12 content-lsck-capturas">';
										$html['eval'] .= '<div class="form-group form-inline">';
											$html['eval'] .= '<label><i class="fas fa-camera-retro fa-lg"></i> Capturas:</label>';
											$html['eval'] .= '<input type="file" name="capturas" class="file-lsck-capturas form-control input-sm" placeholder="Cargar Imagen" data-cliente="'.$idCliente.'" data-evaluacion="'.$idEvaluacion.'" accept=".png, .jpg, .jpeg" multiple >';
										$html['eval'] .= '</div>';
										$html['eval'] .= '<div class="content-lsck-galeria"></div>';
									$html['eval'] .= '</div>';
								$html['eval'] .= '</div>';
								$html['eval'] .= '<div class="row">';
									foreach($evaluacionDet[$idTipoCliente][$idEvaluacion] as $idEvaluacionDet => $evd){
										$html['eval'] .= '<div class="col-md-12">';
											$html['eval'] .= '<div class="content-lsck-eval form-row">';
												$html['eval'] .= '<div class="col-md-8 col-sm-12 col-xs-12">';
													if( !empty($evd['detallar']) ){
														$html['eval'] .= '<div class="form-group">';
															$html['eval'] .= '<label class="lbl-lsck-eval pull-left">'.$evd['nombre'].'</label>';
															$html['eval'] .= '<div class="input-group input-group-lsck">';
																$html['eval'] .= '<div class="input-group-addon">';
																	$html['eval'] .= '<button class="btn-lsck-comentario btn btn-xs" title="Ingresar Comentario" data-cliente="'.$idCliente.'" data-evaluacion-det="'.$idEvaluacionDet.'" ><i class="fas fa-edit"></i></button>';
																$html['eval'] .= '</div>';
																$html['eval'] .= '<textarea id="comentario-'.implode('-', [$idCliente,$idEvaluacionDet]).'" class="txt-lsck-comentario form-control" name="comentario['.$idCliente.']['.$idEvaluacionDet.']" rows="1" maxlength="500" placeholder="Escribir"></textarea>';
															$html['eval'] .= '</div>';
														$html['eval'] .= '</div>';
													} else{
														$html['eval'] .= '<label class="lbl-lsck-eval">'.$evd['nombre'].'</label>';
													}
													$html['eval'] .= '<input type="hidden" name="evaluacionDet['.$idCliente.']['.$idEvaluacion.']" value="'.$idEvaluacionDet.'">';
												$html['eval'] .= '</div>';
												$html['eval'] .= '<div class="col-md-4 col-sm-12 col-xs-12">';
													if( !empty($evd['idEncuesta']) ){
														$html['eval'] .= '<button type="button"';
															$html['eval'] .= 'class="btn-lsck-preguntas btn btn-xs btn-primary pull-right"';
															$html['eval'] .= 'data-cliente="'.$idCliente.'"';
															$html['eval'] .= 'data-evaluacion-det="'.$idEvaluacionDet.'"';
															$html['eval'] .= 'data-toggle="modal"';
															$html['eval'] .= 'data-target="#modal-lsck-tienda-preguntas-'.implode('-', [$idCliente, $idEvaluacionDet]).'"';
														$html['eval'] .= '><i class="fas fa-list-ol"></i> Preguntas</button>';
															$aEncuestasCliente[] = [
																	'idCliente' => $idCliente,
																	'idEvaluacionDet' => $idEvaluacionDet,
																	'evaluacionDet' => $evd['nombre'],
																	'idEncuesta' => $evd['idEncuesta']
																];
													}
												$html['eval'] .= '</div>';
											$html['eval'] .= '</div>';
										$html['eval'] .= '</div>';
									}
								$html['eval'] .= '</div>';
							$html['eval'] .= '</div>';
						$html['eval'] .= '</div>';
					$html['eval'] .= '</div>';
				}
			$html['eval'] .= '</div>';
		$html['eval'] .= '</div>';
	$html['eval'] .= '</div>';
	$iti++;
}

unset($idCliente, $idPregunta, $preg, $idAlternativa, $alt);
foreach($aEncuestasCliente as $aen){
	$idCliente = $aen['idCliente'];
	$idEvaluacionDet = $aen['idEvaluacionDet'];
	$idEncuesta = $aen['idEncuesta'];

$html['modal']['eval'] .= '<div id="modal-lsck-tienda-preguntas-'.implode('-', [$idCliente, $idEvaluacionDet]).'" class="modal-lsck-form modal fade" data-tienda="PDV '.$aPdv[$idCliente].'" tabindex="-1" role="dialog" >';
	$html['modal']['eval'] .= '<div class="modal-dialog modal-lg">';
		$html['modal']['eval'] .= '<div class="modal-content">';
			$html['modal']['eval'] .= '<div class="modal-header" data-evaluacion="'.$aen['evaluacionDet'].'">';
				$html['modal']['eval'] .= '<h4 class="modal-title"><i class="fas fa-list-ol"></i> '.$aen['evaluacionDet'].' <small>(Preguntas)</small></h4>';
			$html['modal']['eval'] .= '</div>';
			$html['modal']['eval'] .= '<div class="modal-body">';
				$html['modal']['eval'] .= '<form id="'.implode('-', [$frm, $idCliente, $idEvaluacionDet]).'" role="form" >';
					$html['modal']['eval'] .= '<div class="row">';
						if( empty($preguntas[$idEncuesta]) ){
							$html['modal']['eval'] .= '<div class="col-md-12" style="padding: 1rem;">';
								$html['modal']['eval'] .= createMessage([ 'type' => 2, 'message' => 'No se encontró un formato de preguntas, <b>posiblemente el formato este inactivo</b>' ]);
							$html['modal']['eval'] .= '</div>';
						}
						else{
							$numPreg = 1;
							foreach($preguntas[$idEncuesta] as $idPregunta => $preg){
								$html['modal']['eval'] .= '<div class="col-md-12" style="padding: 1rem;">';
									$html['modal']['eval'] .= '<label class="lbl-lsck-pregunta" data-pregunta="'.$numPreg.') '.$preg['nombre'].'">'.$numPreg++.') '.$preg['nombre'];
										$html['modal']['eval'] .= '<input type="hidden" name="pregunta['.$idCliente.']['.$idEvaluacionDet.']" value="'.$idPregunta.'">';
										$html['modal']['eval'] .= '<div class="btn-group btn-group-toggle btn-lsck-calificar" data-toggle="buttons">';
											$html['modal']['eval'] .= '<label class="lbl-lsck-calificar-ok btn btn-xs">';
												$html['modal']['eval'] .= '<input type="radio" name="resultado['.$idCliente.']['.$idEvaluacionDet.']['.$idPregunta.']" value="1"><i class="far fa-check-circle"></i> Correcto';
											$html['modal']['eval'] .= '</label>';
											$html['modal']['eval'] .= '<label class="lbl-lsck-calificar-error btn btn-xs" title="Incorrecto">';
												$html['modal']['eval'] .= '<input type="radio" name="resultado['.$idCliente.']['.$idEvaluacionDet.']['.$idPregunta.']" value="0"><i class="far fa-times-circle"></i> Incorrecto';
											$html['modal']['eval'] .= '</label>';
										$html['modal']['eval'] .= '</div>';
									$html['modal']['eval'] .= '</label>';
									if( in_array($preg['tipo'], [2, 3]) ){
										$type = $preg['tipo'] == 2 ? 'radio' : ($preg['tipo'] == 3 ? 'checkbox' : '');
										if( empty($preg['idExtAudTipo']) ){
											$html['modal']['eval'] .= '<input type="hidden" name="punto[pregunta]['.$idCliente.']['.$idPregunta.'][presentes]" value="'.count($alternativas[$idPregunta]).'" >';
											foreach($alternativas[$idPregunta] as $idAlternativa => $alt){
												$html['modal']['eval'] .= '<div class="'.$type.'" style="padding-left: 1rem;">';
													$html['modal']['eval'] .= '<label class="pointer">';
														$html['modal']['eval'] .= '<input type="'.$type.'" class="mr-2" name="alternativa['.$idCliente.']['.$idEvaluacionDet.']['.$idPregunta.']" value="'.$idAlternativa.'" >'.$alt['nombre'];
													$html['modal']['eval'] .= '</label>';
												$html['modal']['eval'] .= '</div>';
											}
										}
										else{
											if( !empty($preg['extAudDetalle']) ){
												$html['modal']['eval'] .= '<button type="button"';
													$html['modal']['eval'] .= 'class="btn btn-primary btn-sm"';
													$html['modal']['eval'] .= 'data-toggle="modal"';
													$html['modal']['eval'] .= 'data-target="#modal-lsck-tienda-pregunta-det-'.implode('-', [$idCliente,$idEvaluacionDet,$idPregunta]).'"';
												$html['modal']['eval'] .= '>';
													$html['modal']['eval'] .= '<i class="fas fa-clipboard-list fa-lg"></i> PRE '.( $preg['extAudPresencia'] == 0 ? 'SI' : 'NO' );
												$html['modal']['eval'] .= '</button>';

													$html['modal']['det'] .= '<div id="modal-lsck-tienda-pregunta-det-'.implode('-', [$idCliente,$idEvaluacionDet,$idPregunta]).'" class="modal-lsck-form modal fade" tabindex="-1" >';
														$html['modal']['det'] .= '<div class="modal-dialog">';
															$html['modal']['det'] .= '<div class="modal-content">';
																$html['modal']['det'] .= '<div class="modal-header">';
																	$html['modal']['det'] .= '<h5 class="modal-title">Auditoria Externa</h5>';
																	$html['modal']['det'] .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
																	$html['modal']['det'] .= '<span aria-hidden="true">&times;</span>';
																	$html['modal']['det'] .= '</button>';
																$html['modal']['det'] .= '</div>';
																$html['modal']['det'] .= '<div class="modal-body">';
																	$html['modal']['det'] .= '<table class="table table-sm table-striped">';
																		$html['modal']['det'] .= '<thead>';
																			$html['modal']['det'] .= '<tr class="thead-light">';
																				$auditoria = ' - '.( !$preg['extAudPresencia'] ? 'Presentes' : 'No Presentes' );
																				$html['modal']['det'] .= '<th>#</th>';
																				if( isset($extAudTipo[$preg['idExtAudTipo']]['nombre']) )
																					$html['modal']['det'] .= '<th>'.$extAudTipo[$preg['idExtAudTipo']]['nombre'].$auditoria.'</th>';
																				else
																					$html['modal']['det'] .= '<th>-</th>';
																			$html['modal']['det'] .= '</tr>';
																		$html['modal']['det'] .= '</thead>';
																		$html['modal']['det'] .= '<tbody>';
																			if( isset($tiendaExtAud[$idCliente][$preg['idExtAudTipo']]) ){
																				$i = 0;
																				foreach($tiendaExtAud[$idCliente][$preg['idExtAudTipo']] as $idExtAudMat => $extAudMat){
																					if( $preg['extAudPresencia'] != $extAudMat['presencia'] ){
																						$html['modal']['det'] .= '<tr>';
																							$html['modal']['det'] .= '<td>'.++$i.'</td>';
																							$html['modal']['det'] .= '<td>'.$extAudMat['nombre'].'</td>';
																						$html['modal']['det'] .= '</tr>';
																					}
																				}
																			}
																			else{
																				$html['modal']['det'] .= '<tr>';
																					$html['modal']['det'] .= '<td colspan=2>'.createMessage([ 'type' => 2, 'message' => 'No se encontró datos de la auditoria, <b>posiblemente no se cargó los datos de auditoria</b>' ]).'</td>';
																				$html['modal']['det'] .= '</tr>';
																			}
																		$html['modal']['det'] .= '</tbody>';
																	$html['modal']['det'] .= '</table>';
																$html['modal']['det'] .= '</div>';
																$html['modal']['det'] .= '<div class="modal-footer">';
																	$html['modal']['det'] .= '<button type="button" class="btn btn-default btn-modal-close" data-id="#modal-lsck-tienda-pregunta-det-'.implode('-', [$idCliente,$idEvaluacionDet,$idPregunta]).'">Cerrar</button>';
																$html['modal']['det'] .= '</div>';
															$html['modal']['det'] .= '</div>';
														$html['modal']['det'] .= '</div>';
													$html['modal']['det'] .= '</div>';
											}

											$i = 0;
											if( isset($tiendaExtAud[$idCliente][$preg['idExtAudTipo']]) ){
												foreach($tiendaExtAud[$idCliente][$preg['idExtAudTipo']] as $idExtAudMat => $extAudMat){
													if( $preg['extAudPresencia'] == $extAudMat['presencia'] ){
														$i++;
													}
												}

												$html['modal']['eval'] .= '<input type="hidden" name="punto[pregunta]['.$idCliente.']['.$idPregunta.'][presentes]" value="'.$i.'" >';
												$html['modal']['eval'] .= '<input type="hidden" name="punto[pregunta]['.$idCliente.']['.$idPregunta.'][total]" value="'.count($tiendaExtAud[$idCliente][$preg['idExtAudTipo']]).'" >';

												$i = 0;
												foreach($tiendaExtAud[$idCliente][$preg['idExtAudTipo']] as $idExtAudMat => $extAudMat){
													if( $preg['extAudPresencia'] == $extAudMat['presencia'] ){
														$html['modal']['eval'] .= '<div class="'.$type.'" style="padding-left: 1rem;">';
															$html['modal']['eval'] .= '<label class="pointer">';
																$html['modal']['eval'] .= '<input type="'.$type.'" class="mr-2" name="extAudMat['.$idCliente.']['.$idEvaluacionDet.']['.$idPregunta.']" value="'.$idExtAudMat.'" checked >'.$extAudMat['nombre'];
															$html['modal']['eval'] .= '</label>';
														$html['modal']['eval'] .= '</div>';
														++$i;
													}
												}
											}

											if( empty($i) ){
												$html['modal']['eval'] .= '<div style="padding: 0.5rem 1rem;">';
													$html['modal']['eval'] .= '<label class="text-danger">- No se encontraron item para mostrar</label>';
												$html['modal']['eval'] .= '</div>';
											}
										}
									}
									else{
										$html['modal']['eval'] .= '<input type="text" name="respuesta['.$idCliente.']['.$idEvaluacionDet.']['.$idPregunta.']" class="form-control input-sm" placeholder="Escriba una respuesta">';
									}
									$html['modal']['eval'] .= '<div style="padding: 0.5rem 1rem;">';
										$html['modal']['eval'] .= '<label>Orden de Trabajo:</label>';
										$html['modal']['eval'] .= '<textarea name="ordenTrabajo['.$idCliente.']['.$idEvaluacionDet.']['.$idPregunta.']" class="form-control" rows="2" placeholder="Máx. 250 caracteres" maxlength="250"></textarea>';
									$html['modal']['eval'] .= '</div>';
									$html['modal']['eval'] .= '<div style="padding: 0.5rem 1rem;">';
										$html['modal']['eval'] .= '<label>Responsable:</label>';
										$html['modal']['eval'] .= '<select name="responsable['.$idCliente.']['.$idEvaluacionDet.']['.$idPregunta.']"';
											$html['modal']['eval'] .= 'id="responsable['.$idCliente.']['.$idEvaluacionDet.']['.$idPregunta.']"';
											$html['modal']['eval'] .= 'class="form-control select2"';
											$html['modal']['eval'] .= 'title="SELECCIONAR"';
											$html['modal']['eval'] .= 'multiple';
											$html['modal']['eval'] .= 'data-dropdown-parent="#modal-lsck-tienda-preguntas-'.implode('-', [$idCliente, $idEvaluacionDet]).'"';
										$html['modal']['eval'] .= '>';
											$html['modal']['eval'] .= '<option value="">SELECCIONAR</option>';
											foreach($responsableTipo as $idTipo => $vTipo){
												$html['modal']['eval'] .= '<optgroup label="'.$vTipo['nombre'].'">';
												foreach($responsable[$idTipo] as $idResposanble => $vResponsable){
													$html['modal']['eval'] .= '<option value="'.$idTipo.'-'.$idResposanble.'">'.$vResponsable['nombres'].' '.$vResponsable['apellidos'].'</option>';
												}
												$html['modal']['eval'] .= '</optgroup>';
											}
										$html['modal']['eval'] .= '</select>';
									$html['modal']['eval'] .= '</div>';
								$html['modal']['eval'] .= '</div>';
							}
						}
					$html['modal']['eval'] .= '</div>';
				$html['modal']['eval'] .= '</form>';
			$html['modal']['eval'] .= '</div>';
			$html['modal']['eval'] .= '<div class="modal-footer">';
				$html['modal']['eval'] .= '<button type="button" class="btn btn-default btn-modal-close" data-id="#modal-lsck-tienda-preguntas-'.implode('-', [$idCliente,$idEvaluacionDet]).'">Cerrar</button>';
			$html['modal']['eval'] .= '</div>';
		$html['modal']['eval'] .= '</div>';
	$html['modal']['eval'] .= '</div>';
$html['modal']['eval'] .= '</div>';
}

echo json_encode($html);