<!--h5 class="text-center modal-header title-special" >ENCUESTAS</h5-->
<form id="frm-visitaIpp">
	<div class="hide">
		<input class="form-control" type="text" id="idVisita" name="idVisita" value="<?=$idVisita?>">
	</div>
	<? foreach ($listaIpp as $kli => $ipp): ?>
	<div class="row themeWhite">
		<div class="col-md-12">
			<div class="row">
				<div class="col"><h5 class="text-center modal-header title-special mt-3" ><?=$ipp['ipp']?></h5></div>
				<div class="col"><h5 class="text-center modal-header title-special mt-3" >PUNTAJE: <?=(!empty($visita[$kli]['puntaje'])?$visita[$kli]['puntaje']:0.00);?></h5></div>
			</div>
			<? if ($ipp['foto']==0): ?>
				<div class="bg-white">
					<? $fotoImg = ( isset($visita[$kli]['idVisitaFoto']) && !empty($visita[$kli]['idVisitaFoto']) ) ? $this->fotos_url.'encuestas/'.$visita[$kli]['fotoEncuesta']:'';?>
					<div class="row m-2" id="foto-<?=$kli;?>">
						<h6 class="col-md-12 mt-3"><i class="fas fa-check-circle"></i> ES NECESARIO INGRESAR UNA FOTO PARA EL IPP.</h6>
						<div class="col">
							<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-<?=$kli?>">
								<img class="imgNormal fotoIpp mb-3" name="img-fotoprincipal-<?=$kli?>" id="img-fotoprincipal-<?=$kli?>" src="<?=$fotoImg?>" alt="" data-ipp="<?=$kli;?>"> 
							</a>
						</div>
						<div class="col">
							<div class="content-input-file">
								<input type="text" readonly="readonly" id="txt-fotoprincipal-<?=$kli?>" name="fotoprincipal-<?=$kli?>" class="hide" >
								<input type="text" readonly="readonly" id="txt-fotoprincipal-<?=$kli?>_show" class="text-file" placeholder="Solo .jpg" >
								<span class="btn-file btnFoto" data-file="fl-fotoprincipal-<?=$kli?>"><i class="fa fa-file-image" aria-hidden="true"></i> Buscar</span>
								<input type="file" id="fl-fotoprincipal-<?=$kli?>" class="fl-control hide" name="filefotoprincipal-<?=$kli?>" data-content="txt-fotoprincipal-<?=$kli?>"  accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal-<?=$kli?>" >
							</div>
						</div>
					</div>
				</div>
			<? endif ?>
			
			<div class="mb-3 mt-3 card">
				<div class="card-header card-header-tab-animation">
					<ul class="nav nav-justified">
						<? $ix=1;?>
						<? foreach ($ipp['listaCriterios'] as $klc => $criterio): ?>
							<? $active = ( $ix==1 ? 'active':'' );?>
							<li class="nav-item"><a data-toggle="tab" href="#tab-<?=$kli?>-criterio-<?=$klc?>" class="nav-link <?=$active;?> show text-uppercase"><?=$criterio['criterio'];?></a></li>
							<? $ix++;?>
						<? endforeach ?>
					</ul>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<!----DETALLE CRITERIOS--->
						<? $ix=1; ?>
						<? foreach ($ipp['listaCriterios'] as $klc => $criterios): ?>
							<? $active = ( $ix==1 ? 'active':'' );?>
							<div class="tab-pane <?=$active?> show" id="tab-<?=$kli?>-criterio-<?=$klc?>" role="tabpanel">
								<h5 class="card-title"><?=$criterios['criterio']?></h5>
								
								<!--DETALLE PREGUNTAS-->
								<? foreach ($criterios['listaPreguntas'] as $klp => $preguntas): ?>
									<div class="position-relative form-group">
										<h5 class="card-title"><?=$ix++;?>. <?=$preguntas['pregunta'];?></h5>
									</div>

									<!--DETALLE ALTERNATIVAS-->
									<? $requerido = $preguntas['obligatorio']==1 ? 'patron="requerido"':'';?>
									<? if ( $preguntas['idTipoPregunta']==1 ){ ?>
										<? $respuesta = isset($visita[$kli]['listaPreguntas'][$klp]['listaAlternativas'] ) ? $visita[$kli]['listaPreguntas'][$klp]['listaAlternativas'] : '';?>
										<div class="position-relative form-group">
											<input name="pregunta-tp1-<?=$kli?>" id="pregunta-<?=$klp?>" placeholder="Ingresar respuesta." type="text" class="form-control dataIpp" <?=$requerido;?> value="<?=$respuesta;?>"  data-tipoPregunta="1" data-pregunta="<?=$klp?>" data-visitaIppDet="" data-puntaje="">
										</div>
									<? } elseif ( $preguntas['idTipoPregunta']==2) { ?>
										<div class="position-relative form-group">
											<div class="dataIpp" data-ipp="<?=$kli?>" data-criterio="<?=$klc?>" data-tipoPregunta="2" data-pregunta="<?=$klp?>">
												<? if ( !empty($preguntas['listaAlternativas']) ): ?>
													<? foreach ($preguntas['listaAlternativas'] as $klpa => $alternativa): ?>
														<? 
															$checked = isset( $visita[$kli]['listaPreguntas'][$klp]['listaAlternativas'][$klpa] ) ? 'checked' : ''; 
															$idVisitaIpp = isset( $visita[$kli]['idVisitaIpp'] ) ? $visita[$kli]['idVisitaIpp'] : ''; 
															$idVisitaIppDet = isset( $visita[$kli]['listaPreguntas'][$klp]['listaAlternativas'][$klpa] ) ? $visita[$kli]['listaPreguntas'][$klp]['listaAlternativas'][$klpa]['idVisitaIppDet'] : ''; 
														?>
														<div class="custom-radio custom-control">
															<input <?=$requerido;?> type="radio" id="alternativa-<?=$kli?>-<?=$klc?>-<?=$klp?>-<?=$klpa?>" name="alternativa-tp2-<?=$kli?>-<?=$klc?>-<?=$klp?>" class="custom-control-input" value="<?=$klpa?>" <?=$checked;?> data-visitaIpp="<?=$idVisitaIpp;?>" data-visitaIppDet="<?=$idVisitaIppDet;?>" data-puntaje="<?=$alternativa['puntaje'];?>">
															<label class="custom-control-label" for="alternativa-<?=$kli?>-<?=$klc?>-<?=$klp?>-<?=$klpa?>"><?=$alternativa['alternativa'];?></label>
														</div>
													<? endforeach ?>
												<? else: ?>
													<label>NO HAY ALTERNATIVAS.</label>
												<? endif ?>
											</div>
										</div>
									<? } elseif ( $preguntas['idTipoPregunta']==3) { ?>
										<div class="position-relative form-group">
											<div class="dataIpp" data-ipp="<?=$kli?>" data-criterio="<?=$klc?>" data-tipoPregunta="3" data-pregunta="<?=$klp?>">
												<? if ( !empty($preguntas['listaAlternativas'])): ?>
													<? foreach ($preguntas['listaAlternativas'] as $klpa => $alternativa): ?>
														<? 
															$checked = isset( $visita[$kli]['listaPreguntas'][$klp]['listaAlternativas'][$klpa] ) ? 'checked' : ''; 
															$idVisitaIpp = isset( $visita[$kli]['idVisitaIpp'] ) ? $visita[$kli]['idVisitaIpp'] : ''; 
															$idVisitaIppDet = isset( $visita[$kli]['listaPreguntas'][$klp]['listaAlternativas'][$klpa] ) ? $visita[$kli]['listaPreguntas'][$klp]['listaAlternativas'][$klpa]['idVisitaIppDet'] : ''; 
														?>
														<div class="custom-checkbox custom-control">
															<input <?=$requerido;?> type="checkbox" id="alternativa-<?=$kli?>-<?=$klc?>-<?=$klp?>-<?=$klpa?>" class="custom-control-input" name="alternativa-tp3-<?=$kli?>-<?=$klc?>-<?=$klp?>" value="<?=$klpa?>" <?=$checked;?> data-visitaIpp="<?=$idVisitaIpp;?>" data-visitaIppDet="<?=$idVisitaIppDet;?>" data-puntaje="<?=$alternativa['puntaje'];?>">
															<label class="custom-control-label" for="alternativa-<?=$kli?>-<?=$klc?>-<?=$klp?>-<?=$klpa?>"><?=$alternativa['alternativa'];?></label>
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
							<?//$ix++;?>
						<? endforeach ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<? endforeach ?>
</form>
