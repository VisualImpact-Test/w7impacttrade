<div class="row" style="padding: 1rem;">
	<div class="card">
		<div class="card-header card-header-tab">
			<ul class="nav">
				<?$icat = 0;?>
				<?foreach($categorias as $idCategoria => $cg){?>
					<li class="nav-item <?if( $icat == 0 ){?>active<?}?>">
						<a href="#tab-live-categoria-<?=$idCategoria?>"
							class="nav-link <?if( $icat == 0 ){?>active<?}?>"
							role="tab"
							aria-controls="tab-live-categoria-<?=$idCategoria?>"
							data-toggle="tab"
						><?=$cg['nombre']?></a></li>
					<?$icat++;?>
				<?}?>
			</ul>
		</div>
		<div class="card-body">
			<div class="tab-content">
				<?$icat = 0;?>
				<?foreach($categorias as $idCategoria => $cg){?>
					<div id="tab-live-categoria-<?=$idCategoria?>" class="tab-pane fade <?if( $icat == 0 ){?>show active<?}?>" role="tabpanel">
						<div class="col-md-6 offset-md-6">
							<div class="row">
								<div class="col-md-6">
									<h5><i class="fas fa-clipboard-check"></i> Peso <small style="color: #777 !important;">(categoria):</small></h5>
								</div>
								<div class="col-md-6">
									<div class="form-group pull-right">
										<input type="hidden" name="categoria" value="<?=$idCategoria?>" class="vrf-live-list-no">
										<input type="hidden" name="categoria[<?=$idCategoria?>][nombre]" class="vrf-live-list-no form-control form-control-sm" value="<?=$cg['nombre']?>">
										<input type="number" name="peso[<?=$idCategoria?>]" class="vrf-live-list-no form-control form-control-sm" placeholder="0" title="Peso de la Categoria">
									</div>
								</div>
							</div>
						</div>
						<?foreach($evaluaciones as $idEvaluacion => $ev){?>
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12">
									<h5><i class="fa fa-star"></i> <?=$ev['nombre']?></h5>
								</div>
								<div style="margin: 1rem;">
									<?foreach($evaluacionesDet[$idEvaluacion] as $idEvaluacionDet => $evd){?>
									<div class="col-md-12">
										<div class="row" data-categoria="<?=$idCategoria?>" data-evaluacion="<?=$idEvaluacionDet?>">
											<div class="col-md-4 col-sm-12 col-xs-12">
												<label class="lbl-live-eval pull-left" style="padding: 1rem 0; margin: 0;"><?=$evd['nombre']?></label>
												<input type="hidden" name="evaluacionDet[<?=$idCategoria?>]" class="vrf-live-list-no" value="<?=$idEvaluacionDet?>" >
											</div>
											<div class="col-md-2 col-sm-12 col-xs-12">
												<div class="form-group">
													<input type="hidden" name="evaluacionDet[<?=$idCategoria?>][<?=$idEvaluacionDet?>][nombre]" class="vrf-live-list-no" value="<?=$evd['nombre']?>" >
													<input type="number" name="peso[<?=$idCategoria?>][<?=$idEvaluacionDet?>]" class="vrf-live-list-no form-control form-control-sm" placeholder="0" title="Peso de Evaluación">
												</div>
											</div>
											<div class="col-md-3 col-sm-12 col-xs-12">
												<div class="form-group">
													<select name="calificar[<?=$idCategoria?>][<?=$idEvaluacionDet?>]" class="cbx_calificar vrf-live-list-no form-control form-control-sm" title="Tipo de Calificación">
														<option value="1">ESTRELLAS</option>
														<option value="2">PREGUNTAS</option>
													</select>
												</div>
											</div>
											<div class="col-md-3 col-sm-12 col-xs-12">
												<div class="form-group">
													<select name="encuesta[<?=$idCategoria?>][<?=$idEvaluacionDet?>]" class="cbx_encuesta vrf-live-list-no form-control form-control-sm" title="Formato de Preguntas" disabled>
														<option value="">SELECCIONAR</option>
														<?foreach($encuestas as $idEncuesta => $enc){?>
															<option value="<?=$idEncuesta?>"><?=$enc['nombre']?></option>
														<?}?>
													</select>
												</div>
											</div>
										</div>
									</div>
									<?}?>
								</div>
							</div>
						</div>
						<?}?>
					</div>
					<?$icat++;?>
				<?}?>
			</div>
		</div>
	</div>
</div>