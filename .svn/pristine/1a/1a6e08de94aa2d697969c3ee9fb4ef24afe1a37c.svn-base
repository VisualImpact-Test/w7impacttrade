<form id="frm-visitaSeguimientoPlan">
	<div class="hide">
		<input class="form-control" type="text" id="idVisita" name="idVisita" value="<?=$idVisita?>">
	</div>
	<div class="row themeWhite">
		<div class="col-md-12">
			<div class="mb-3 mt-3 card">
				<div class="card-header card-header-tab-animation">
					<ul class="nav nav-justified">
						<? $ix=1;?>
						<? foreach ($listaSeguimientoPlan as $klsp => $plan): ?>
							<? $active = ( $ix==1 ? 'active':'' );?>
							<li class="nav-item"><a data-toggle="tab" href="#tab-seguimientoPlan-<?=$klsp?>" class="nav-link <?=$active;?> show text-uppercase"><?=$plan['seguimientoPlan'];?></a></li>
							<? $ix++;?>
						<? endforeach ?>
					</ul>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<!----DETALLE DE PLAN---->
						<? $ix=1; ?>
						<? foreach ($listaSeguimientoPlan as $klsp => $plan): ?>
							<? $active = ( $ix==1 ? 'active':'' );?>
							<div class="tab-pane <?=$active?> show" id="tab-seguimientoPlan-<?=$klsp?>" role="tabpanel">
								<!--h5 class="card-title"><?//=$plan['seguimientoPlan']?></h5-->

								<!----LISTA ELELENTOS VISIBILIDAD--->
								<div class="table-responsive">
									<table id="tb-seguimientoPlan" class="mb-0 table table-bordered table-sm text-nowrap">
										<thead>
											<tr>
												<th class="text-center align-middle">#</th>
												<th class="text-center align-middle">ELEMENTO VISIBILIDAD</th>
												<th class="text-center align-middle">PRESENCIA</th>
												<th class="text-center align-middle">ARMADO</th>
												<th class="text-center align-middle">REVESTIDO</th>
												<th class="text-center align-middle">MOTIVO</th>
												<th class="text-center align-middle">COMENTARIO</th>
												<th class="text-center align-middle">MARCA</th>
												<th class="text-center align-middle">FOTO</th>
											</tr>
										</thead>
										<tbody class="tb-seguimientoPlan">
											<? $ixt=1; ?>
											<? foreach ($plan['listaTipoElementoVisibilidad'] as $klte => $elementoVisibilidad): ?>
												<? 
													$idVisitaSegPlan = ( isset($listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]['idVisitaSeguimientoPlan']) && !empty($listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]['idVisitaSeguimientoPlan']) ) ? $listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]['idVisitaSeguimientoPlan']:'';
													$idVisitaSegPlanDet = ( isset($listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]['idVisitaSeguimientoPlanDet']) && !empty($listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]['idVisitaSeguimientoPlanDet']) ) ? $listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]['idVisitaSeguimientoPlanDet']:'';
												?>
												<tr class="tr-seguimientoPlan"  data-segPlan="<?=$klsp;?>" data-elementoVis="<?=$klte;?>" data-visitaSegPlan="<?=$idVisitaSegPlan;?>" data-visitaSegPlanDet="<?=$idVisitaSegPlanDet?>">
													<td class="text-center"><?=$ixt++;?></td>
													<td class="text-center"><?=!empty($elementoVisibilidad['tipoElementoVisibilidad'])?$elementoVisibilidad['tipoElementoVisibilidad']:'-';?></td>
													<td class="text-center">
														<div class="custom-checkbox custom-control">
															<? $checkedPresencia = ( isset($listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]) && !empty($listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]) ) ? 'checked':'';?>
															<? $disabled = ( isset($listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]) && !empty($listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]) ) ? 'disabled':'';?>
															<input <?=$checkedPresencia;?> class="custom-control-input" type="checkbox" id="presencia-<?=$klsp?>-<?=$klte;?>"  name="presencia-<?=$klsp?>-<?=$klte;?>" value="1" <?=$disabled;?>>
															<label class="custom-control-label" for="presencia-<?=$klsp?>-<?=$klte;?>"></label>
														</div>
													</td>
													<td class="text-center">
														<? $armadoVisita = ( isset($listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]['armado']) && !empty($listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]['armado']) ) ? $listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]['armado']:'';?>
														<input class="form-control ipWidth" type="text" placeholder="Armado" id="armado-<?=$klsp?>-<?=$klte?>"  name="armado-<?=$klsp?>-<?=$klte?>" value="<?=$armadoVisita;?>">
													</td>
													<td class="text-center">
														<? $revestidoVisita = ( isset($listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]['revestido']) && !empty($listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]['revestido']) ) ? $listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]['revestido']:'';?>
														<input class="form-control ipWidth" type="text" placeholder="Revestido" id="revestido-<?=$klsp?>-<?=$klte?>"  name="revestido-<?=$klsp?>-<?=$klte?>" value="<?=$revestidoVisita;?>">
													</td>
													<td class="text-center">
														<? $motivoVisita = ( isset($listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]['idMotivo']) && !empty($listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]['idMotivo']) ) ? $listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]['idMotivo']:'';?>
														<select class="form-control slWidth" id="motivo-<?=$klsp?>-<?=$klte?>"  name="motivo-<?=$klsp?>-<?=$klte?>">
															<option value="">-- Motivo --</option>
															<? foreach ($motivos as $km => $motivo): ?>
																<? $selected = ( $motivo['idMotivo']==$motivoVisita ? 'selected' : '' );?>
																<option value="<?=$motivo['idMotivo']?>" <?=$selected;?>><?=$motivo['motivo']?></option>
															<? endforeach ?>
														</select>
													</td>
													<td class="text-center">
														<? $comentarioVisita = ( isset($listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]['comentario']) && !empty($listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]['comentario']) ) ? $listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]['comentario']:'';?>
														<input class="form-control ipWidth" type="text" placeholder="Comentario" id="comentario-<?=$klsp?>-<?=$klte?>"  name="comentario-<?=$klsp?>-<?=$klte?>" value="<?=$comentarioVisita;?>">
													</td>
													<td class="text-center">
														<? $marcaVisita = ( isset($listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]['idMarca']) && !empty($listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]['idMarca']) ) ? $listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]['idMarca']:'';?>
														<select class="form-control slWidth" id="marca-<?=$klsp?>-<?=$klte?>"  name="marca-<?=$klsp?>-<?=$klte?>">
															<option value="">-- Marca --</option>
															<? foreach ($marcas as $kmc => $marca): ?>
																<? $selected = ( $marca['idMarca']==$marcaVisita ? 'selected' : '' );?>
																<option value="<?=$marca['idMarca']?>" <?=$selected;?>><?=$marca['marca']?></option>
															<? endforeach ?>
														</select>
													</td>
													<td class="text-center">
														<div class="row" id="foto-<?=$klte;?>">
															<? $fotoImg = ( isset($listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]['idVisitaFoto']) && !empty($listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]['idVisitaFoto']) ) ? $this->fotos_url.'seguimientoPlan/'.$listaVisitasSegPlan[$klsp]['listaElementoVisibilidad'][$klte]['foto']:'';?>
															<div class="col">
																<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-<?=$klsp?>-<?=$klte?>">
																	<img class="fotoMiniatura foto" name="img-fotoprincipal-<?=$klsp?>-<?=$klte?>" id="img-fotoprincipal-<?=$klsp?>-<?=$klte?>" src="<?=$fotoImg;?>" alt="">
																</a>
															</div>
															<div class="col">
																<div class="content-input-file">
																	<input type="text" readonly="readonly" id="txt-fotoprincipal-<?=$klsp?>-<?=$klte?>" name="fotoprincipal-<?=$klsp?>-<?=$klte?>" class="hide" >
																	<input type="text" readonly="readonly" id="txt-fotoprincipal-<?=$klsp?>-<?=$klte?>_show" class="text-file" placeholder="Solo .jpg" >
																	<span class="btn-file btnFoto" data-file="fl-fotoprincipal-<?=$klsp?>-<?=$klte?>"><i class="fa fa-file-image" aria-hidden="true"></i> Buscar</span>
																	<input type="file" id="fl-fotoprincipal-<?=$klsp?>-<?=$klte?>" class="fl-control hide" name="filefotoprincipal-<?=$klsp?>-<?=$klte?>" data-content="txt-fotoprincipal-<?=$klsp?>-<?=$klte?>"  accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal-<?=$klsp?>-<?=$klte?>" >
																</div>
															</div>
														</div>
													</td>
												</tr>
											<? endforeach ?>
										</tbody>
									</table>
								</div>
							</div>
							<? $ix++; ?>
						<? endforeach ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>