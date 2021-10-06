<form id="frm-visitaVisibilidadAud">
	<div class="hide">
		<input class="form-control" type="text" id="idVisita" name="idVisita" value="<?=$idVisita?>">
	</div>
	<div class="row themeWhite">
		<div class="col-md-12">
			<div class="mb-3 mt-3 card">
				<div class="card-header">
					EDICIÓN DEL MÓDULO DE VISIBILIDAD AUDITORIA ADICIONAL
					<!--div class="ml-auto">
						<button type="button" id="btn-addRowVisibilidadAuditoriaAdicional" class="btn btn-primary "><i class="fas fa-plus-circle fa-lg"></i></button>
					</div-->
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="table-responsive">
							<table id="tb-visibilidadAdicional" class="mb-0 table table-bordered table-sm text-nowrap">
								<thead>
									<tr>
										<th class="text-center align-middle">#</th>
										<th class="text-center align-middle">ELEMENTO</th>
										<th class="text-center align-middle">PRESENCIA</th>
										<th class="text-center align-middle">CANTIDAD</th>
										<th class="text-center align-middle">COMENTARIO</th>
										<th class="text-center align-middle">FOTO</th>
									</tr>
								</thead>
								<tbody class="tb-visibilidadAdicional">
									<? $ixt=1; ?>
									<? foreach ($listaElementoVisibilidad as $klev => $elementos): ?>
										<?
											$visitaVisibilidad = ( isset($listaVisitas[$klev]['idVisitaVisibilidad']) && !empty($listaVisitas[$klev]['idVisitaVisibilidad']) ) ? $listaVisitas[$klev]['idVisitaVisibilidad']:'';
											$visitaVisibilidadDet = ( isset($listaVisitas[$klev]['idVisitaVisibilidadDet']) && !empty($listaVisitas[$klev]['idVisitaVisibilidadDet']) ) ? $listaVisitas[$klev]['idVisitaVisibilidadDet']:'';
										?>
										<tr class="tr-visibilidadAdicional" data-elementoVisibilidad="<?=$klev?>" data-visitaVisibilidad="<?=$visitaVisibilidad?>" data-visitaVisibilidadDet="<?=$visitaVisibilidadDet?>">
											<td class="text-center"><?=$ixt++;?></td>
											<td class="text-center"><?=$elementos['elementoVisibilidad'];?></td>
											<td class="text-center">
												<? $checkedPresencia = ( isset($listaVisitas[$klev]['presencia']) && !empty($listaVisitas[$klev]['presencia']) ) ? 'checked':'';?>
												<div class="custom-checkbox custom-control">
													<input <?=$checkedPresencia;?> class="custom-control-input" type="checkbox" id="presencia-<?=$klev?>" name="presencia-<?=$klev?>" value="1" >
													<label class="custom-control-label" for="presencia-<?=$klev?>"></label>
												</div>
											</td>
											<td class="text-center">
												<? $cantidadVisita = ( isset($listaVisitas[$klev]['cantidad']) && !empty($listaVisitas[$klev]['cantidad']) ) ? $listaVisitas[$klev]['cantidad']:'';?>
												<input type="text" class="form-control ipWidth" placeholder="Cantidad" id="cantidad-<?=$klev?>"  name="cantidad-<?=$klev?>" value="<?=$cantidadVisita;?>">
											</td>
											<td class="text-center">
												<? $comentarioVisita = ( isset($listaVisitas[$klev]['comentario']) && !empty($listaVisitas[$klev]['comentario']) ) ? $listaVisitas[$klev]['comentario']:'';?>
												<input type="text" class="form-control ipWidth" placeholder="Comentario" id="comentario-<?=$klev?>"  name="comentario-<?=$klev?>" value="<?=$comentarioVisita;?>">
											</td>
											<td class="text-center">
												<? $imagenVisita= ( isset($listaVisitas[$klev]['idVisitaFoto']) && !empty($listaVisitas[$klev]['idVisitaFoto']) ) ? $this->fotos_url.'visibilidadAuditoria/'.$listaVisitas[$klev]['foto']:'';?>
												<div class="row" id="foto-<?=$klev?>">
													<div class="col">
														<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-<?=$klev?>">
															<img class="fotoMiniatura foto" name="img-fotoprincipal-<?=$klev?>" id="img-fotoprincipal-<?=$klev?>" src="<?=$imagenVisita?>" alt="">
														</a>
													</div>
													<div class="col">
														<div class="content-input-file">
															<input type="text" readonly="readonly" id="txt-fotoprincipal-<?=$klev?>" name="fotoprincipal-<?=$klev?>" class="hide" >
															<input type="text" readonly="readonly" id="txt-fotoprincipal-<?=$klev?>_show" class="text-file" placeholder="Solo .jpg" >
															<span class="btn-file btnFoto" data-file="fl-fotoprincipal-<?=$klev?>"><i class="fa fa-file-image" aria-hidden="true"></i> Buscar</span>
															<input type="file" id="fl-fotoprincipal-<?=$klev?>" class="fl-control hide" name="filefotoprincipal-<?=$klev?>" data-content="txt-fotoprincipal-<?=$klev?>"  accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal-<?=$klev?>" >
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
				</div>
			</div>
		</div>
	</div>
</form>