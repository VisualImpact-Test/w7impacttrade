<div class="row themeWhite" style="padding: 10px;padding-top: 0px;">
	<div class="col-lg-12 d-flex">
		<div class="w-100 mb-3 p-0">
			<div class="card-body p-0">
				<ul class="nav nav-tabs nav-justified">
					<? $ix = 1; ?>
					<? foreach ($listaEncuestas as $kle => $encuesta) : ?>
						<? $active = ($ix == 1 ? 'active' : ''); ?>
						<li class="nav-item" id="nav-link-<?= $kle ?>"><a data-toggle="tab" href="#tab-encuesta-<?= $kle ?>" class="nav-link <?= $active; ?> show"><?= $encuesta['encuesta']; ?></a></li>
						<? $ix++; ?>
					<? endforeach ?>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<form id="frm-visitaEncuesta">
			<div class="hide">
				<input class="form-control" type="text" id="idVisita" name="idVisita" value="<?= $idVisita ?>">
			</div>
			<div class="tab-content">
				<!----DETALLE ENCUESTAS---->
				<? $ix = 1; ?>
				<? foreach ($listaEncuestas as $kle => $encuesta) : ?>
					<? $active = ($ix == 1 ? 'active' : ''); ?>
					<div class="tab-pane <?= $active ?> show" id="tab-encuesta-<?= $kle; ?>" role="tabpanel">
						<div class="form-row">
							<div class="col-md-12 hide">
								<? $idVisitaEncuesta = (isset($visita[$kle]['idVisitaEncuesta']) && !empty($visita[$kle]['idVisitaEncuesta'])) ? $visita[$kle]['idVisitaEncuesta'] : ''; ?>
								<? $encuestaFoto = $encuesta['fotoEncuesta'] == 1 ? 1 : 0; ?>
								<input type="text" class="form-control encuestas" name="encuesta" value="<?= $encuesta['idEncuesta']; ?>" data-visitaEncuesta="<?= $idVisitaEncuesta ?>" data-fotoEncuesta="<?= $encuestaFoto ?>">
							</div>
							<!---DETALLE DE LA FOTO ENCUESTA--->
							<? if ($encuesta['fotoEncuesta'] == 1) : ?>
								<? $obligatorioFotoEncuesta = $encuesta['flagFotoObligatorioEncuesta'] == 1 ? 'patron="requerido"' : ''; ?>
								<? $obligatorioFotoMultiple = $encuesta['flagFotoMultiple'] == 1 ? 'multiple' : ''; ?>
								<div class="col-md-12">
									<div class="border card-body border-success">
										<div style="width: auto;float: left;">
											<label class="card-title">ES NECESARIO INGRESAR UNA FOTO PARA LA ENCUESTA:</label>
										</div>
										<? $fotoImg = (isset($visita[$kle]['idVisitaFoto']) && !empty($visita[$kle]['idVisitaFoto'])) ? $this->fotos_url . 'encuestas/' . $visita[$kle]['fotoEncuesta'] : ''; ?>
										<div id="foto-<?= $kle; ?>" style="display:inline-flex;" class="divContentImg align-self-center">
											<div class="divFotoEncuesta">
												<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-<?= $kle ?>">
													<img class="imgNormal fotoEncuesta fotoMiniatura" name="img-fotoprincipal-<?= $kle ?>" id="img-fotoprincipal-<?= $kle ?>" src="<?= $fotoImg ?>" alt="" data-encuesta="<?= $kle; ?>" data-visitaEncuesta="<?= $idVisitaEncuesta; ?>" style="width: 40px;display: none;">
												</a>
											</div>
											<div>
												<span class="btn border-0 btn-outline-secondary btnAbrirFotoMultiple <?= (empty($fotoImg) ? " disabled" : "") ?>" title="Abrir imagen subida" data-idencuesta="<?= $kle ?>" data-idvisitaencuesta="<?=!empty($visita[$kle]['idVisitaEncuesta']) ? $visita[$kle]['idVisitaEncuesta'] : ''?>"><i class="fal fa-image-polaroid fa-lg" aria-hidden="true"></i></span>
											</div>
											<div>
												<div class="content-input-file">
													<input type="text" readonly="readonly" id="txt-fotoprincipal-<?= $kle ?>" name="fotoprincipal-<?= $kle ?>" class="hide">
													<input type="text" readonly="readonly" id="txt-fotoprincipal-<?= $kle ?>_show" class="text-file hide" placeholder="Solo .jpg">
													<span class="btn border-0 btn-outline-secondary btn-file btnFoto" data-file="fl-fotoprincipal-<?= $kle ?>" title="Subir imagen JPG"><i class="fa fa-file-upload fa-lg" aria-hidden="true"></i></span>
													<input <?= $obligatorioFotoEncuesta; ?> <?= $obligatorioFotoMultiple; ?> type="file" id="fl-fotoprincipal-<?= $kle ?>" class="fl-controlMulti hide" name="filefotoprincipal-<?= $kle ?>" data-content="txt-fotoprincipal-<?= $kle ?>" accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal-<?= $kle ?>" data-idencuesta="<?= $kle ?>">
												</div>
											</div>
										</div>
									</div>
									<div class="divider"></div>
								</div>
							<? endif ?>
							<!----LISTADO DE PREGUNTAS---->
							<? foreach ($encuesta['listaPreguntas'] as $klp => $preguntas) : ?>
								<? $requeridoPregunta = $encuesta['obligatorioEncuesta'] == 1 && $preguntas['obligatorioPregunta'] == 1 ? 'patron="requerido"' : ''; ?>
								<? $requeridoAlternativa = $encuesta['obligatorioEncuesta'] == 1 && $preguntas['obligatorioPregunta'] == 1 ? 'patron="requerido"' : ''; ?>
								<? $obligatorioFotoPregunta = $encuesta['flagFotoObligatorioEncuesta'] == 1 && $preguntas['flagFotoObligatorioPregunta'] == 1 ? 'patron="requerido"' : ''; ?>
								<div class="col-md-12">
									<div style="display:inline-flex;" class="divContentImg align-self-center">
										<h5 class="card-title" style="font-size: 25px;"><?= $ix++; ?>. <?= $preguntas['pregunta']; ?></h5>
										<!--  -->
										<? if ($preguntas['flagFotoPregunta'] == 1) : ?>
											<? $fotoImg = (!empty($visita[$kle]['tipoPreguntas'][$preguntas['idTipoPregunta']]['preguntas'][$klp]['idVisitaFotoPregunta'])) ? $this->fotos_url . 'encuestas/' . $visita[$kle]['tipoPreguntas'][$preguntas['idTipoPregunta']]['preguntas'][$klp]['fotoPregunta'] : ''; ?>
											<div>
												<a href="javascript:;" class="lk-foto-1" data-content="img-fotopregunta-<?= $kle ?>-<?= $klp ?>-01">
													<img class="fotoMiniatura fotoPregunta" name="img-fotopregunta-<?= $kle ?>-<?= $klp ?>-01" id="img-fotopregunta-<?= $kle ?>-<?= $klp ?>-01" src="<?= $fotoImg ?>" alt="" data-encuesta="<?= $klp; ?>" data-visitaEncuesta="<?= $idVisitaEncuesta; ?>" data-pregunta="<?= $klp ?>" style="width: 40px;display: none;">
												</a>
											</div>
											<div>
												<span class="btn border-0 btn-outline-secondary btn-file btnAbrirFoto<?= (empty($fotoImg) ? " disabled" : "") ?>" title="Abrir imagen subida"><i class="fal fa-image-polaroid fa-lg" aria-hidden="true"></i></span>
											</div>
											<div>
												<div class="content-input-file">
													<input type="text" readonly="readonly" id="txt-fotopregunta-<?= $kle ?>-<?= $klp ?>-01" name="fotopregunta-<?= $kle ?>-<?= $klp ?>-01" class="hide">
													<input type="text" readonly="readonly" id="txt-fotopregunta-<?= $kle ?>-<?= $klp ?>-01_show" class="text-file hide" placeholder="Solo .jpg">
													<span class="btn border-0 btn-outline-secondary btn-file btnFoto" data-file="fl-fotopregunta-<?= $kle ?>-<?= $klp ?>-01" title="Subir imagen JPG"><i class="fa fa-file-upload fa-lg" aria-hidden="true"></i></span>
													<input <?= $obligatorioFotoPregunta; ?> type="file" id="fl-fotopregunta-<?= $kle ?>-<?= $klp ?>-01" class="fl-control hide" name="filefotopregunta-<?= $kle ?>-<?= $klp ?>-01" data-content="txt-fotopregunta-<?= $kle ?>-<?= $klp ?>-01" accept="image/jpeg" data-previa="true" data-foto-content="img-fotopregunta-<?= $kle ?>-<?= $klp ?>-01">
												</div>
											</div>
										<? endif ?>
									</div>
									<!--  -->
									<? if ($preguntas['idTipoPregunta'] == 1) { ?>
										<div class="row" style="margin-top: 15px;margin-bottom: 15px;">
											<? if (!empty($preguntas['imagenPregunta'])) : ?>
												<div class="col-md-2 align-self-center">
													<div style="text-align: center;">
														<img id="foto" src="<?= base_url() ?>controlFoto/obtener_carpeta_foto/encuestaFotosRefencia/<?= $preguntas['imagenPregunta']; ?>" class="img-responsive center-block img-thumbnail" style="height:150px;width:auto;" />
													</div>
												</div>
											<? endif ?>
											<div class="align-self-center <?= (!empty($preguntas['imagenPregunta'])) ? "col-md-10" : "col-md-12" ?>">
												<? $alternativaFoto = $preguntas['fotoPregunta'] == 1 ? 1 : 0; ?>
												<? $idVisitaFoto = (isset($visita[$kle]['tipoPreguntas'][1]['preguntas'][$klp]['respuestas']['idVisitaFotoAlternativa']) && !empty($visita[$kle]['tipoPreguntas'][1]['preguntas'][$klp]['respuestas']['idVisitaFotoAlternativa'])) ? $visita[$kle]['tipoPreguntas'][1]['preguntas'][$klp]['respuestas']['idVisitaFotoAlternativa'] : ''; ?>
												<? $respuesta = (isset($visita[$kle]['tipoPreguntas'][1]['preguntas'][$klp]['respuestas']['respuesta']) && !empty($visita[$kle]['tipoPreguntas'][1]['preguntas'][$klp]['respuestas']['respuesta'])) ? $visita[$kle]['tipoPreguntas'][1]['preguntas'][$klp]['respuestas']['respuesta'] : ''; ?>
												<div class="custom-radio custom-control">
													<div style="display:inline-flex;" class="divContentImg align-self-center">
														<div class="align-self-center">
															<input name="pregunta-tp1-<?= $kle ?>" style="width: 200%;" id="pregunta-<?= $klp ?>" placeholder="Ingresar respuesta." type="text" class="form-control inputEncuestaRespuesta-<?= $kle ?>" <?= $requeridoAlternativa; ?> value="<?= $respuesta; ?>" data-encuesta="<?= $kle ?>" data-pregunta="<?= $klp ?>" data-tipoPregunta="1" data-alternativaFoto="<?= $alternativaFoto ?>" data-visitaFoto="<?= $idVisitaFoto ?>">
														</div>
													</div>
												</div>
											</div>
										</div>
									<? } elseif ($preguntas['idTipoPregunta'] == 2) { ?>
										<div class="row" style="margin-top: 15px;margin-bottom: 15px;">
											<? if (!empty($preguntas['imagenPregunta'])) : ?>
												<div class="col-md-2 align-self-center">
													<div style="text-align: center;">
														<img id="foto" src="<?= base_url() ?>controlFoto/obtener_carpeta_foto/encuestaFotosRefencia/<?= $preguntas['imagenPregunta']; ?>" class="img-responsive center-block img-thumbnail" style="height:150px;width:auto;" />
													</div>
												</div>
											<? endif ?>
											<div class="align-self-center <?= (!empty($preguntas['imagenPregunta'])) ? "col-md-10" : "col-md-12" ?>">
												<? foreach ($preguntas['listaAlternativas'] as $klpa => $alternativas) : ?>
													<? $alternativaFoto = $alternativas['fotoAlternativa'] == 1 ? 1 : 0; ?>
													<? $idVisitaFoto = (isset($visita[$kle]['tipoPreguntas'][2]['preguntas'][$klp]['alternativas'][$klpa]['idVisitaFotoAlternativa']) && !empty($visita[$kle]['tipoPreguntas'][2]['preguntas'][$klp]['alternativas'][$klpa]['idVisitaFotoAlternativa'])) ? $visita[$kle]['tipoPreguntas'][2]['preguntas'][$klp]['alternativas'][$klpa]['idVisitaFotoAlternativa'] : ''; ?>
													<? $checked = (isset($visita[$kle]['tipoPreguntas'][2]['preguntas'][$klp]['alternativas'][$klpa]) && !empty($visita[$kle]['tipoPreguntas'][2]['preguntas'][$klp]['alternativas'][$klpa])) ? 'checked' : ''; ?>
													<? $obligatorioFotoAlternativa = $encuesta['flagFotoObligatorioEncuesta'] == 1 && $alternativas['flagFotoObligatorioAlternativa'] == 1 ? 'patron="requerido"' : ''; ?>
													<div class="custom-radio custom-control">
														<div style="display:inline-flex;" class="divContentImg align-self-center">
															<div class="align-self-center">
																<input type="radio" id="alternativa-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>" name="alternativa-tp2-<?= $kle ?>-<?= $klp ?>" class="chkAlternativaPreg custom-control-input inputEncuestaRespuesta-<?= $kle ?>" <?= $requeridoAlternativa; ?> <?= $checked; ?> value="<?= $klpa ?>" data-pregunta="<?= $klp ?>" data-tipoPregunta="2" data-alternativaFoto="<?= $alternativaFoto ?>" data-visitaFoto="<?= $idVisitaFoto ?>">
																<label class="custom-control-label" for="alternativa-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>"><?= $alternativas['alternativa']; ?></label>
															</div>
															<? if ($alternativas['fotoAlternativa'] == 1) : ?>

																<? $fotoImg = (isset($visita[$kle]['tipoPreguntas'][2]['preguntas'][$klp]['alternativas'][$klpa]['idVisitaFotoAlternativa']) && !empty($visita[$kle]['tipoPreguntas'][2]['preguntas'][$klp]['alternativas'][$klpa]['idVisitaFotoAlternativa'])) ? $this->fotos_url . 'encuestas/' . $visita[$kle]['tipoPreguntas'][2]['preguntas'][$klp]['alternativas'][$klpa]['fotoAlternativa'] : ''; ?>
																<div class="align-self-center">
																	<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>">
																		<img class="fotoMiniatura fotoEncuesta" name="img-fotoprincipal-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>" id="img-fotoprincipal-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>" src="<?= $fotoImg ?>" alt="" data-encuesta="<?= $klp; ?>" data-visitaEncuesta="<?= $idVisitaEncuesta; ?>" style="width: 40px;display: none;">
																	</a>
																</div>
																<div class="align-self-center">
																	<span class="btn border-0 btn-outline-secondary btn-file btnAbrirFoto<?= (empty($fotoImg) ? " disabled" : "") ?>" title="Abrir imagen subida"><i class="fal fa-image-polaroid fa-lg" aria-hidden="true"></i></span>
																</div>
																<div class="align-self-center">
																	<div class="content-input-file">
																		<input type="text" readonly="readonly" id="txt-fotoprincipal-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>" name="fotoprincipal-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>" class="hide">
																		<input type="text" readonly="readonly" id="txt-fotoprincipal-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>_show" class="text-file hide" placeholder="Solo .jpg">
																		<span class="btn border-0 btn-outline-secondary btn-file btnFoto" data-file="fl-fotoprincipal-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>" title="Subir imagen JPG"><i class="fa fa-file-upload fa-lg" aria-hidden="true"></i></span>
																		<input <?= $obligatorioFotoAlternativa; ?> type="file" id="fl-fotoprincipal-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>" data-foto-obligatoria="<?= !empty($obligatorioFotoAlternativa) ? 1 : 0 ?>" class="fileAlternativaPreg fl-control hide" name="filefotoprincipal-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>" data-content="txt-fotoprincipal-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>" accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>">
																	</div>
																</div>
															<? endif ?>
														</div>
													</div>
												<? endforeach ?>
											</div>
										</div>
									<? } elseif ($preguntas['idTipoPregunta'] == 3) {
										$img = base_url() . "controlFoto/obtener_carpeta_foto/encuestaFotosRefencia/{$preguntas['imagenPregunta']}";
										empty($preguntas['imagenPregunta']) ? $img = "../public/assets/images/sin_imagen.jpg" : '';
									?>
										<div class="row " style="margin-top: 15px;margin-bottom: 15px;">
											<? if (!empty($preguntas['imagenPregunta'])) : ?>
												<div class="col-md-2 align-self-center">
													<div style="text-align: center;">
														<img id="foto" src="<?= base_url() ?>controlFoto/obtener_carpeta_foto/encuestaFotosRefencia/<?= $preguntas['imagenPregunta']; ?>" class="img-responsive center-block img-thumbnail" style="height:150px;width:auto;" />
													</div>
												</div>
											<? endif ?>
											<div class="align-self-center <?= (!empty($preguntas['imagenPregunta'])) ? "col-md-10" : "col-md-12" ?>">
												<? foreach ($preguntas['listaAlternativas'] as $klpa => $alternativas) : ?>
													<? $alternativaFoto = $alternativas['fotoAlternativa'] == 1 ? 1 : 0; ?>
													<? $idVisitaFoto = (isset($visita[$kle]['tipoPreguntas'][3]['preguntas'][$klp]['alternativas'][$klpa]['idVisitaFotoAlternativa']) && !empty($visita[$kle]['tipoPreguntas'][3]['preguntas'][$klp]['alternativas'][$klpa]['idVisitaFotoAlternativa'])) ? $visita[$kle]['tipoPreguntas'][3]['preguntas'][$klp]['alternativas'][$klpa]['idVisitaFotoAlternativa'] : ''; ?>
													<? $checked = (isset($visita[$kle]['tipoPreguntas'][3]['preguntas'][$klp]['alternativas'][$klpa]) && !empty($visita[$kle]['tipoPreguntas'][3]['preguntas'][$klp]['alternativas'][$klpa])) ? 'checked' : ''; ?>
													<? $obligatorioFotoAlternativa = $encuesta['flagFotoObligatorioEncuesta'] == 1 && $alternativas['flagFotoObligatorioAlternativa'] == 1 ? 'patron="requerido"' : ''; ?>
													<div class="custom-checkbox custom-control ">
														<div style="display:inline-flex;" class="divContentImg align-self-center">
															<div class="align-self-center">
																<input type="checkbox" id="alternativa-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>" class="chkAlternativaPreg custom-control-input inputEncuestaRespuesta-<?= $kle ?>" <?= $requeridoAlternativa; ?> name="alternativa-tp3-<?= $kle ?>-<?= $klp ?>" <?= $checked; ?> value="<?= $klpa ?>" data-pregunta="<?= $klp ?>" data-tipoPregunta="3" data-alternativaFoto="<?= $alternativaFoto ?>" data-visitaFoto="<?= $idVisitaFoto ?>">
																<label class="custom-control-label" for="alternativa-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>"><?= $alternativas['alternativa']; ?></label>
															</div>
															<? if ($alternativas['fotoAlternativa'] == 1) : ?>

																<? $fotoImg = (isset($visita[$kle]['tipoPreguntas'][3]['preguntas'][$klp]['alternativas'][$klpa]['idVisitaFotoAlternativa']) && !empty($visita[$kle]['tipoPreguntas'][3]['preguntas'][$klp]['alternativas'][$klpa]['idVisitaFotoAlternativa'])) ? $this->fotos_url . 'encuestas/' . $visita[$kle]['tipoPreguntas'][3]['preguntas'][$klp]['alternativas'][$klpa]['fotoAlternativa'] : ''; ?>
																<div class="align-self-center">
																	<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>">
																		<img class="fotoMiniatura fotoEncuesta" name="img-fotoprincipal-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>" id="img-fotoprincipal-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>" src="<?= $fotoImg ?>" alt="" data-encuesta="<?= $klp; ?>" data-visitaEncuesta="<?= $idVisitaEncuesta; ?>" style="width: 40px;display: none;">
																	</a>
																</div>
																<div class="align-self-center">
																	<span class="btn border-0 btn-outline-secondary btn-file btnAbrirFoto<?= (empty($fotoImg) ? " disabled" : "") ?>" title="Abrir imagen subida"><i class="fal fa-image-polaroid fa-lg" aria-hidden="true"></i></span>
																</div>
																<div class="align-self-center">
																	<div class="content-input-file">
																		<input type="text" readonly="readonly" id="txt-fotoprincipal-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>" name="fotoprincipal-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>" class="hide">
																		<input type="text" readonly="readonly" id="txt-fotoprincipal-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>_show" class="text-file hide" placeholder="Solo .jpg">
																		<span class="btn border-0 btn-outline-secondary btn-file btnFoto" data-file="fl-fotoprincipal-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>" title="Subir imagen JPG"><i class="fa fa-file-upload fa-lg" aria-hidden="true"></i></span>
																		<input <?= $obligatorioFotoAlternativa; ?> type="file" id="fl-fotoprincipal-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>" class="fl-control hide" name="filefotoprincipal-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>" data-content="txt-fotoprincipal-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>" accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal-<?= $kle ?>-<?= $klp ?>-<?= $klpa ?>">
																	</div>
																</div>
															<? endif ?>
														</div>
													</div>
												<? endforeach ?>
											</div>
										</div>

									<? } elseif ($preguntas['idTipoPregunta'] == 4) { ?>
										<div class="row" style="margin-top: 15px;margin-bottom: 15px;">
											<? if (!empty($preguntas['imagenPregunta'])) : ?>
												<div class="col-md-2 align-self-center">
													<div style="text-align: center;">
														<img id="foto" src="<?= base_url() ?>controlFoto/obtener_carpeta_foto/encuestaFotosRefencia/<?= $preguntas['imagenPregunta']; ?>" class="img-responsive center-block img-thumbnail" style="height:150px;width:auto;" />
													</div>
												</div>
											<? endif ?>
											<div class="align-self-center <?= (!empty($preguntas['imagenPregunta'])) ? "col-md-10" : "col-md-12" ?>">
												<table class="ui celled structured table">
													<thead>
														<tr class="text-center">
															<th rowspan="2">Alternativas</th>
															<th colspan="<?= count($preguntas['listaOpciones']) ?>">Opciones</th>
														</tr>
														<tr class="text-center">
															<? foreach ($preguntas['listaOpciones'] as $op => $opciones) { ?>
																<th><?= $opciones['opcion'] ?></th>
															<? } ?>
														</tr>
													</thead>
													<tbody>
														<? foreach ($preguntas['listaAlternativas'] as $klpa => $alternativas) : ?>
															<? $alternativaFoto = $alternativas['fotoAlternativa'] == 1 ? 1 : 0; ?>
															<? $idVisitaFoto = (isset($visita[$kle]['tipoPreguntas'][4]['preguntas'][$klp]['alternativas'][$klpa]['idVisitaFotoAlternativa']) && !empty($visita[$kle]['tipoPreguntas'][4]['preguntas'][$klp]['alternativas'][$klpa]['idVisitaFotoAlternativa'])) ? $visita[$kle]['tipoPreguntas'][4]['preguntas'][$klp]['alternativas'][$klpa]['idVisitaFotoAlternativa'] : ''; ?>
															<? $obligatorioFotoAlternativa = $encuesta['flagFotoObligatorioEncuesta'] == 1 && $alternativas['flagFotoObligatorioAlternativa'] == 1 ? 'patron="requerido"' : ''; ?>
															<tr>
																<td class="right aligned"><?= $alternativas['alternativa'] ?></td>
																<? foreach ($preguntas['listaOpciones'] as $op => $opciones) { ?>
																	<? $checked = (!empty($visita[$kle]['tipoPreguntas'][4]['preguntas'][$klp]['alternativas'][$klpa]['opciones']) && ($visita[$kle]['tipoPreguntas'][4]['preguntas'][$klp]['alternativas'][$klpa]['opciones'] == $op)) ? 'checked' : ''; ?>
																	<td class="text-center td-preg-valorativa">
																		<input type="radio" <?=$requeridoPregunta?>  data-alternativaFoto="<?= $alternativaFoto ?>" data-pregunta="<?= $klp ?>" data-visitaFoto="<?= $idVisitaFoto ?>" data-opcion-nombre="<?= $opciones['opcion'] ?>" class="d-none tdPregRadio inputEncuestaRespuesta-<?= $kle ?>" value="<?= $klpa ?>" data-alternativa="<?= $alternativas['idAlternativa'] ?>" data-opcion="<?= $opciones['idAlternativaOpcion'] ?>" name="<?= "OP-{$alternativas['idAlternativa']}" ?>" data-tipoPregunta="4"  <?= $checked?>>
																	</td>
																<? } ?>
																<!-- <td class="center aligned">
																	<i class="large green checkmark icon"></i> 
																</td>
																<td></td>
																<td></td> -->
															</tr>
														<? endforeach ?>
													</tbody>
												</table>
											</div>
										</div>
									<? } ?>
									<div class="divider"></div>
								</div>
							<? endforeach ?>
						</div>
					</div>
					<? $ix++; ?>
				<? endforeach ?>
			</div>
		</form>
	</div>
</div>