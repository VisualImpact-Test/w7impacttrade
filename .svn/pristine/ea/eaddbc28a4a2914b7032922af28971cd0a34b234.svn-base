<form id="frm-visitaVisibilidad">
	<div class="hide">
		<input class="form-control" type="text" id="idVisita" name="idVisita" value="<?=$idVisita?>">
	</div>
	<div class="row themeWhite">
		<div class="col-md-12">
			<div class="mb-3 mt-3 card">
				<div class="card-header">
					ELEMENTOS DE VISIBILIDAD TRADICIONAL
					<div class="ml-auto">
						<button type="button" id="btn-addRowVisibilidadTrad" class="btn btn-primary "><i class="fas fa-plus-circle fa-lg"></i></button>
					</div>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="table-responsive">
							<table id="tb-visibilidadTrad" class="mb-0 table table-bordered table-sm text-nowrap">
								<thead>
									<tr>
										<th class="text-center align-middle">#</th>
										<th class="text-center align-middle">ELEMENTO VISIBILIDAD</th>
										<th class="text-center align-middle">CONDICIÓN ELEMENTO</th>
										<th class="text-center align-middle">PRESENCIA</th>
										<th class="text-center align-middle">CANTIDAD</th>
										<th class="text-center align-middle">FOTO</th>
									</tr>
								</thead>
								<tbody class="tb-visibilidadTrad">
									<? $ixt=1; ?>
									<? if ( !empty($listaVisitas)): ?>
										<? foreach ($listaVisitas as $klv => $visitas): ?>
											<tr class="tr-visibilidadTrad" data-visitaVisibilidad="1" data-visitaVisibilidadDet="<?=$klv;?>">
												<td class="text-center"><?=$ixt++;?></td>
												<td class="text-left"><?=$visitas['elementoVisibilidadTrad'];?>
													<div class="hide">
														<input type="text" class="form-control" id="elementoVisibilidad-<?=$klv?>" name="elementoVisibilidad-<?=$klv?>" value="<?=$visitas['idElementoVis'];?>">
													</div>
												</td>
												<td class="text-center">
													<? $visitaCondicionElemento = ( !empty($visitas['condicion_elemento'])? $visitas['condicion_elemento']:'' );?>
													<!-- <select class="form-control slWidth condicionElemento" name="condicion-<?=$klv?>" id="condicion-<?=$klv?>" data-visitaVisibilidadDet="<?=$klv;?>">
														<option value="0" <?=( empty($visitaCondicionElemento)?'selected':'');?> >MODULADOS</option>
														<option value="1" <?=( $visitaCondicionElemento=="1"?'selected':'');?> >NO MODULADOS</option>
													</select> -->
													<label for=""><?=( empty($visitaCondicionElemento)?'MODULADOS':'NO MODULADOS');?></label>
													<input type="hidden" class="f slWidth condicionElemento" name="condicion-<?=$klv?>" id="condicion-<?=$klv?>" data-visitaVisibilidadDet="<?=$klv;?>" value="<?=( empty($visitaCondicionElemento)?'0':'1')?>" >
												</td>
												<td class="text-center">
													<? $checkedPresencia = ( isset($visitas['presencia']) && !empty($visitas['presencia']) ) ? 'checked':'';?>
													<div class="custom-checkbox custom-control">
														<input <?=$checkedPresencia;?> class="custom-control-input" type="checkbox" id="presencia-<?=$klv?>"  name="presencia-<?=$klv?>" value="1" >
														<label class="custom-control-label" for="presencia-<?=$klv?>"></label>
													</div>
												</td>
												<td class="text-center">
													<? $cantidadVisita = ( isset($visitas['cantidad']) && !empty($visitas['cantidad']) ) ? $visitas['cantidad']:'';?>
													<input type="text" class="form-control ipWidth" placeholder="Cantidad" id="cantidad-<?=$klv?>"  name="cantidad-<?=$klv?>" value="<?=$cantidadVisita;?>">
												</td>

												<td class="text-center divContentImg">

													<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-<?='AD'.$klv?>">
														<img class="fotoMiniatura imgNormal foto" name="img-fotoprincipal-'+prefijo+'" id="img-fotoprincipal-<?='AD'.$klv?>" src="<?= site_url("controlFoto/obtener_carpeta_foto/visibilidad/{$visitas['foto']}") ?>" alt="" style="width: 40px;display: none;">
													</a>
													<div>
														<span class="btn border-0 btn-outline-secondary btn-file btnAbrirFoto <?=empty($visitas['foto']) ? 'disabled': '' ?>" title="Abrir imagen subida" ><i class="fal fa-image-polaroid fa-lg" aria-hidden="true"></i></span>
													</div>
													<div>
														<div class="content-input-file">
															<input type="text" readonly="readonly" id="txt-fotoprincipal-<?='AD'.$klv?>" name="fotoprincipal-<?='AD'.$klv?>" class="hide" >
															<input type="text" readonly="readonly" id="txt-fotoprincipal-<?='AD'.$klv?>_show" class="text-file hide" placeholder="Solo .jpg" >
															<span  class="btn border-0 btn-outline-secondary btn-file btnFoto" data-file="fl-fotoprincipal-<?='AD'.$klv?>" title="Subir imagen JPG"><i class="fa fa-file-upload fa-lg" aria-hidden="true"></i></span>
															<input type="file" id="fl-fotoprincipal-<?='AD'.$klv?>" class="fl-control hide" name="filefotoprincipal-<?='AD'.$klv?>" data-content="txt-fotoprincipal-<?='AD'.$klv?>"  accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal-<?='AD'.$klv?>" >
														</div>
													</div>
												</td>
												
											</tr>
										<? endforeach ?>
									<? else: ?>
										<? foreach ($listaElementoVisibilidad as $klev => $elementos): ?>
											<tr class="tr-visibilidadTrad" data-visitaVisibilidad="0" data-visitaVisibilidadDet="<?=$klev;?>">
												<td class="text-center"><?=$ixt++;?></td>
												<td class="text-left"><?=$elementos['elementoVisibilidad'];?>
													<div class="hide">
														<input type="text" class="form-control" id="elementoVisibilidad-<?=$klev?>" name="elementoVisibilidad-<?=$klev?>" value="<?=$elementos['idElementoVis'];?>">
													</div>
												</td>
												<td class="text-center">
													<select class="form-control slWidth condicionElemento" name="condicion-<?=$klev?>" id="condicion-<?=$klev?>" data-visitaVisibilidadDet="<?=$klev;?>">
														<option value="0">MODULADOS</option>
													</select>
												</td>
												<td class="text-center">
													<div class="custom-checkbox custom-control">
														<input class="custom-control-input" type="checkbox" id="presencia-<?=$klev?>"  name="presencia-<?=$klev?>" value="1" >
														<label class="custom-control-label" for="presencia-<?=$klev?>"></label>
													</div>
												</td>
												<td class="text-center">
													<input type="text" class="form-control ipWidth" placeholder="Cantidad" id="cantidad-<?=$klev?>"  name="cantidad-<?=$klev?>" value="">
												</td>
												<td class="text-center">
													<div class="row" id="foto-<?=$klev?>">
														<div class="col">
															<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-<?=$klev?>">
																<img class="fotoMiniatura foto" name="img-fotoprincipal-<?=$klev?>" id="img-fotoprincipal-<?=$klev?>" src="" alt="">
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
									<? endif ?>
								</tbody>
							</table>
						</div>
						<div class="hide">
							<input class="form-control" type="text" id="contNumberVisibilidadTrad" id="contNumberVisibilidadTrad" value="<?=$ixt;?>">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<script>
	ContingenciaRutas.dataListaElementosVisibilidadTrad = JSON.parse('<?=json_encode($listaElementoVisibilidadNoModulados)?>');
	ContingenciaRutas.dataListaEstadoElementosTrad = JSON.parse('<?=json_encode($listaEstadoElementos)?>');
</script>