<div class="row" style="padding: 1rem;">
	<div class="card">
		<div class="card-header card-header-tab-animation">
			<ul class="nav nav-justified" role="tablist">
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
					<div id="tab-live-categoria-<?=$idCategoria?>" class="tab-pane <?if( $icat == 0 ){?>active<?}?>" role="tabpanel">
						<div class="col-md-12 text-right">
							<h5><i class="fa fa-clipboard-check fa-lg"></i> Peso <small style="color: #777 !important;">(categoria):</small> <?=$cg['peso']?></h5>
						</div>
						<?foreach($evaluaciones[$idCategoria] as $idEvaluacion => $ev){?>
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12">
									<h5><i class="fa fa-star fa-lg"></i> <?=$ev['nombre']?></h5>
								</div>
								<div class="row" style="margin: 1rem;">
									<?foreach($evaluacionesDet[$idCategoria][$idEvaluacion] as $idEvaluacionDet => $evd){?>
									<div class="col-md-12">
										<div class="row">
											<div class="col-md-4 col-sm-12 col-xs-12">
												<div class="form-group">
													<label class="lbl-live-eval pull-left"><?=$evd['nombre']?></label>
												</div>
											</div>
											<div class="col-md-2 col-sm-12 col-xs-12">
												<div class="form-group">
													<span><?=$evd['peso']?></span>
												</div>
											</div>
											<div class="col-md-3 col-sm-12 col-xs-12">
												<div class="form-group">
													<span>
													<?if( empty($evd['idEncuesta']) ){?>
														<i class="fa fa-star fa-lg"></i> Estrellas
													<?} else{?>
														<i class="fa fa-list-ol"></i> Preguntas
													<?}?>
													</span>
												</div>
											</div>
											<div class="col-md-3 col-sm-12 col-xs-12">
												<div class="form-group">
													<span><?=(empty($evd['idEncuesta']) ? '-' : $evd['encuesta'])?></span>
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