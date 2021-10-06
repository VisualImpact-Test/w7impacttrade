<form id="frm-visitaEncuestaPremio">
	<div class="hide">
		<input class="form-control" type="text" id="idVisita" name="idVisita" value="<?=$idVisita?>">
	</div>
	<div class="row themeWhite">
		<div class="col-md-12">
			<div class="mb-3 mt-3 card">
				<div class="card-header card-header-tab-animation">
					<ul class="nav nav-justified">
						<? $ix=1;?>
						<? foreach ($listaEncuestasPremio as $kle => $encuestas): ?>
							<? $active = ( $ix==1 ? 'active':'' );?>
							<li class="nav-item"><a data-toggle="tab" href="#tab-encuestas-<?=$kle?>" class="nav-link <?=$active;?> show text-uppercase"><?=$encuestas['encuestaPremio'];?></a></li>
							<? $ix++;?>
						<? endforeach ?>
					</ul>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<!----LISTA DE ENCUESTAS PREMIO----->
						<? $ix=1; ?>
						<? foreach ($listaEncuestasPremio as $kle => $encuestas): ?>
							<? $active = ( $ix==1 ? 'active':'' );?>
							<div class="tab-pane <?=$active?> show" id="tab-encuestas-<?=$kle?>" role="tabpanel">
								<!--h5 class="card-title"><?//=$encuestas['descripcion']?></h5-->
								<div class="hide">
									<? $idVisitaEncuesta = (isset($listaVisitasEncuesta[$kle]['idVisitaEncuesta']) && !empty($listaVisitasEncuesta[$kle]['idVisitaEncuesta']) ) ? $listaVisitasEncuesta[$kle]['idVisitaEncuesta'] : ''; ?>
									<? $encuestaFoto = $encuestas['foto_obligatoria']==1 ? 1 : 0; ?>
									<input type="text" class="form-control encuestaPremio" name="encuestaPremio" value="<?=$encuestas['idEncuesta'];?>" data-visitaEncuesta="<?=$idVisitaEncuesta?>" data-fotoEncuesta="<?=$encuestaFoto?>">
								</div>

								<!---DETALLE DE LA FOTO ENCUESTA--->
								<? if ($encuestas['foto_obligatoria']==1): ?>
									<div class="col-md-12">
										<div class="card-shadow-success border card card-body border-success">
											<h5 class="card-title">ES NECESARIO INGRESAR UNA FOTO PARA LA ENCUESTA.</h5>
											<? $fotoImg = ( isset($listaVisitasEncuesta[$kle]['idVisitaFoto']) && !empty($listaVisitasEncuesta[$kle]['idVisitaFoto']) ) ? $this->fotos_url.'encuestasPremio/'.$listaVisitasEncuesta[$kle]['foto']:'';?>
											<div class="row" id="foto-<?=$kle;?>">
												<div class="col">
													<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-<?=$kle?>">
														<img class="imgNormal fotoEncuesta" name="img-fotoprincipal-<?=$kle?>" id="img-fotoprincipal-<?=$kle?>" src="<?=$fotoImg?>" alt="" data-encuesta="<?=$kle;?>" data-visitaEncuesta="<?=$idVisitaEncuesta;?>"> 
													</a>
												</div>
												<div class="col">
													<div class="content-input-file">
														<input type="text" readonly="readonly" id="txt-fotoprincipal-<?=$kle?>" name="fotoprincipal-<?=$kle?>" class="hide" >
														<input type="text" readonly="readonly" id="txt-fotoprincipal-<?=$kle?>_show" class="text-file" placeholder="Solo .jpg" >
														<span class="btn-file btnFoto" data-file="fl-fotoprincipal-<?=$kle?>"><i class="fa fa-file-image" aria-hidden="true"></i> Buscar</span>
														<input type="file" id="fl-fotoprincipal-<?=$kle?>" class="fl-control hide" name="filefotoprincipal-<?=$kle?>" data-content="txt-fotoprincipal-<?=$kle?>"  accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal-<?=$kle?>" >
													</div>
												</div>
											</div>
										</div>
										<div class="divider"></div>
									</div>
								<? endif ?>

								<!----LISTA DE PREGUNTAS--->
								<? foreach ($encuestas['listaPreguntas'] as $klp => $preguntas): ?>
									<div class="position-relative form-group">
										<h5 class="card-title"><?=$ix++;?>. <?=$preguntas['pregunta'];?></h5>
									</div>

									<!----DETALLE DE PREGUNTAS---->
									<? $requerido = $preguntas['obligatoria']==1 ? 'patron="requerido"':'';?>
									<? if ($preguntas['idPreguntaTipo']==1){ ?>
										<div class="position-relative form-group">
											<? $respuesta= ( isset($listaVisitasEncuesta[$kle]['listaTipoPreguntas'][1]['listaPreguntas'][$klp]['listaRespuestas'][0]) && !empty($listaVisitasEncuesta[$kle]['listaTipoPreguntas'][1]['listaPreguntas'][$klp]['listaRespuestas'][0]) ? $listaVisitasEncuesta[$kle]['listaTipoPreguntas'][1]['listaPreguntas'][$klp]['listaRespuestas'][0]:''); ?>
											<input name="pregunta-tp1-<?=$kle?>" id="pregunta-<?=$klp?>" placeholder="Ingresar respuesta." type="text" class="form-control inputEncuestaRespuesta" <?=$requerido;?> value="<?=$respuesta;?>" data-encuesta="<?=$kle?>" data-tipoPregunta="1" data-pregunta="<?=$klp?>">
										</div>
									<? } elseif ($preguntas['idPreguntaTipo']==2) { ?>
										<!---LISTA DE ALTERNATIVAS--->
										<div class="position-relative form-group">
											<div>
												<? if (!empty($preguntas['listaAlternativas'])): ?>
													<? foreach ($preguntas['listaAlternativas'] as $klpa => $alternativas): ?>
														<div class="custom-radio custom-control">
															<? $checkedAlternativa=( isset($listaVisitasEncuesta[$kle]['listaTipoPreguntas'][2]['listaPreguntas'][$klp]['listaRespuestas'][$klpa]) && !empty($listaVisitasEncuesta[$kle]['listaTipoPreguntas'][2]['listaPreguntas'][$klp]['listaRespuestas'][$klpa]) ? 'checked':''); ?>
															<input type="radio" id="alternativa-<?=$kle?>-<?=$klp?>-<?=$klpa?>" name="alternativa-tp2-<?=$kle?>-<?=$klp?>" class="custom-control-input inputEncuestaRespuesta" <?=$checkedAlternativa;?> value="<?=$klpa?>" data-encuesta="<?=$kle?>" data-tipoPregunta="2" data-pregunta="<?=$klp?>">
															<label class="custom-control-label" for="alternativa-<?=$kle?>-<?=$klp?>-<?=$klpa?>"><?=$alternativas['alternativa'];?></label>
														</div>
													<? endforeach ?>
												<? else: ?>
													<label>NO HAY ALTERNATIVAS.</label>
												<? endif ?>
											</div>
										</div>
									<? } elseif ($preguntas['idPreguntaTipo']==3) { ?>
										<div class="position-relative form-group">
											<div>
												<? if ( !empty($preguntas['listaAlternativas'])): ?>
													<? foreach ($preguntas['listaAlternativas'] as $klpa => $alternativas): ?>
														<? $checkedAlternativa=( isset($listaVisitasEncuesta[$kle]['listaTipoPreguntas'][3]['listaPreguntas'][$klp]['listaRespuestas'][$klpa]) && !empty($listaVisitasEncuesta[$kle]['listaTipoPreguntas'][3]['listaPreguntas'][$klp]['listaRespuestas'][$klpa]) ? 'checked':''); ?>
														<div class="custom-checkbox custom-control">
															<input type="checkbox" id="alternativa-<?=$kle?>-<?=$klp?>-<?=$klpa?>" class="custom-control-input inputEncuestaRespuesta" name="alternativa-tp3-<?=$kle?>-<?=$klp?>" <?=$checkedAlternativa;?> value="<?=$klpa?>" data-encuesta="<?=$kle?>" data-tipoPregunta="3" data-pregunta="<?=$klp?>">
															<label class="custom-control-label" for="alternativa-<?=$kle?>-<?=$klp?>-<?=$klpa?>"><?=$alternativas['alternativa'];?></label>
														</div>
													<? endforeach ?>
												<? else: ?>
													<label>NO HAY ALTERNATIVAS.</label>
												<? endif ?>
											</div>
										</div>
									<? } ?>
									
									<div class="divider"></div>
								<? endforeach ?>
							</div>
						<? $ix++; ?>
						<? endforeach ?>	
					</div>
				</div>
			</div>
		</div>
	</div>
</form>