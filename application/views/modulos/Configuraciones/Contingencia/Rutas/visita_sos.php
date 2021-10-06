<form id="frm-visitaSos">
	<div class="hide">
		<input class="form-control" type="text" id="idVisita" name="idVisita" value="<?=$idVisita?>">
	</div>
	<div class="row themeWhite">
		<div class="col-md-12">
			<div class="mb-3 mt-3 card">
				<div class="card-header">
					LISTA VISIBILIDAD - SOS
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="alert alert-warning" role="alert"><i class="fas fa-check-circle"></i> Ante cualquier cambie en las cantidades de los CMs o FRENTES, se pide presionar la tecla ENTER para visualizar los cambios.</div>
						<div class="table-responsive">
							<table id="tb-visibilidad" class="mb-0 table table-bordered table-sm text-nowrap">
								<thead>
									<tr>
										<th class="text-center align-middle">CATEGORIA</th>
										<th class="text-center align-middle">MARCA</th>
										<th class="text-center align-middle">CM</th>
										<th class="text-center align-middle">FRENTES</th>
										<th class="text-center align-middle">FOTO</th>
									</tr>
								</thead>
								<tbody>
									<? //if ( !empty($listaVisitas)): ?>
										<? //foreach ($listaVisitas['listaCategorias'] as $klct => $categorias): ?>
										<? foreach ($listaCategorias as $klct => $categorias): ?>
											<? $idVisitaSos = ( isset($listaVisitas['listaCategorias'][$klct]['idVisitaSos']) && !empty($listaVisitas['listaCategorias'][$klct]['idVisitaSos'])) ? $listaVisitas['listaCategorias'][$klct]['idVisitaSos']:'';?>
											<tr class="tr-categoria" data-categoria="<?=$klct?>" data-visitaSos="<?=$idVisitaSos;?>">
												<td class="text-center text-uppercase text-bold" colspan="2"><strong><?=$categorias['categoria']?></strong></td>
												<td class="text-center">
													<? $categoriaCm = ( isset($listaVisitas['listaCategorias'][$klct]['cm']) && !empty( $listaVisitas['listaCategorias'][$klct]['cm']) ) ? $listaVisitas['listaCategorias'][$klct]['cm']:'';?>
													<input class="form-control ipWidth" type="text" placeholder="CMs" id="categoria-cm-<?=$klct?>"  name="categoria-cm-<?=$klct?>" value="<?=$categoriaCm;?>" readonly="readonly">
												</td>
												<td class="text-center">
													<? $categoriaFrentes = ( isset($listaVisitas['listaCategorias'][$klct]['frentes']) && !empty( $listaVisitas['listaCategorias'][$klct]['frentes']) ) ? $listaVisitas['listaCategorias'][$klct]['frentes']:'';?>
													<input class="form-control ipWidth" type="text" placeholder="Frentes" id="categoria-frentes-<?=$klct?>"  name="categoria-frentes-<?=$klct?>" value="<?=$categoriaFrentes?>" readonly="readonly">
												</td>
												<td class="text-center">
													<div class="row" id="foto-<?=$klct?>">
														<? $fotoImg = ( isset($listaVisitas['listaCategorias'][$klct]['idVisitaFoto']) && !empty($listaVisitas['listaCategorias'][$klct]['idVisitaFoto']) ) ? $this->fotos_url.'sos/'.$listaVisitas['listaCategorias'][$klct]['foto']:'';?>
														<div class="col">
															<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-<?=$klct?>">
																<img class="fotoMiniatura foto" name="img-fotoprincipal-<?=$klct?>" id="img-fotoprincipal-<?=$klct?>" src="<?=$fotoImg;?>" alt="">
															</a>
														</div>
														<div class="col">
															<div class="content-input-file">
																<input type="text" readonly="readonly" id="txt-fotoprincipal-<?=$klct?>" name="fotoprincipal-<?=$klct?>" class="hide" >
																<input type="text" readonly="readonly" id="txt-fotoprincipal-<?=$klct?>_show" class="text-file" placeholder="Solo .jpg" >
																<span class="btn-file btnFoto" data-file="fl-fotoprincipal-<?=$klct?>"><i class="fa fa-file-image" aria-hidden="true"></i> Buscar</span>
																<input type="file" id="fl-fotoprincipal-<?=$klct?>" class="fl-control hide" name="filefotoprincipal-<?=$klct?>" data-content="txt-fotoprincipal-<?=$klct?>"  accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal-<?=$klct?>" >
															</div>
														</div>
													</div>
												</td>
											</tr>
											<? foreach ($categorias['listaMarcas'] as $klm => $marcas): ?>
												<? $idVisitaSosDet = ( isset($listaVisitas['listaCategorias'][$klct]['listaMarcas'][$klm]['idVisitaSosDet']) && !empty($listaVisitas['listaCategorias'][$klct]['listaMarcas'][$klm]['idVisitaSosDet'])) ? $listaVisitas['listaCategorias'][$klct]['listaMarcas'][$klm]['idVisitaSosDet']:'';?>
												<tr class="tr-marca tr-marca-<?=$klct?>" data-marca="<?=$klm?>" data-visitaSosDet="<?=$idVisitaSosDet?>" data-flagCompetencia="<?=$marcas['flagCompetencia']?>">
													<td class="text-center tdBloqueado"></td>
													<td class="text-center"><?=$marcas['marca']?></td>
													<td class="text-center">
														<? $marcaCm = ( isset($listaVisitas['listaCategorias'][$klct]['listaMarcas'][$klm]['cm']) && !empty( $listaVisitas['listaCategorias'][$klct]['listaMarcas'][$klm]['cm'] ) ) ? $listaVisitas['listaCategorias'][$klct]['listaMarcas'][$klm]['cm']:'';?>
														<input class="form-control ipWidth text-center marcasCm marca-cm-<?=$klct?>" data-categoria="<?=$klct?>" type="text" placeholder="CM" id="marca-cm-<?=$klct?>-<?=$klm?>"  name="marca-cm-<?=$klct?>-<?=$klm?>" value="<?=$marcaCm?>">
													</td>
													<td class="text-center">
														<? $marcaFrentes = ( isset($listaVisitas['listaCategorias'][$klct]['listaMarcas'][$klm]['frentes']) && !empty( $listaVisitas['listaCategorias'][$klct]['listaMarcas'][$klm]['frentes'] ) ) ? $listaVisitas['listaCategorias'][$klct]['listaMarcas'][$klm]['frentes']:'';?>
														<input class="form-control ipWidth text-center marcasFrentes marca-frentes-<?=$klct?>" data-categoria="<?=$klct?>" type="text" placeholder="Frentes" id="marca-frentes-<?=$klct?>-<?=$klm?>"  name="marca-frentes-<?=$klct?>-<?=$klm?>" value="<?=$marcaFrentes?>">
													</td>
													<td class="text-center tdBloqueado"></td>
												</tr>
											<? endforeach ?>							
										<? endforeach ?>									
									<? //else: ?>
										<? /*foreach ($listaCategorias as $klct => $categorias): ?>
											<tr class="tr-categoria" data-categoria="<?=$klct?>" data-visitaSos="">
												<td class="text-center text-uppercase text-bold" colspan="2"><strong><?=$categorias['categoria']?></strong></td>
												<td class="text-center">
													<input class="form-control ipWidth" type="text" placeholder="CMs" id="categoria-cm-<?=$klct?>"  name="categoria-cm-<?=$klct?>" value="" readonly="readonly">
												</td>
												<td class="text-center">
													<input class="form-control ipWidth" type="text" placeholder="Frentes" id="categoria-frentes-<?=$klct?>"  name="categoria-frentes-<?=$klct?>" value="" readonly="readonly">
												</td>
												<td class="text-center">
													<div class="row" id="foto-<?=$klct?>">
														<? $fotoImg = '';?>
														<div class="col">
															<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-<?=$klct?>">
																<img class="fotoMiniatura foto" name="img-fotoprincipal-<?=$klct?>" id="img-fotoprincipal-<?=$klct?>" src="<?=$fotoImg;?>" alt="">
															</a>
														</div>
														<div class="col">
															<div class="content-input-file">
																<input type="text" readonly="readonly" id="txt-fotoprincipal-<?=$klct?>" name="fotoprincipal-<?=$klct?>" class="hide" >
																<input type="text" readonly="readonly" id="txt-fotoprincipal-<?=$klct?>_show" class="text-file" placeholder="Solo .jpg" >
																<span class="btn-file btnFoto" data-file="fl-fotoprincipal-<?=$klct?>"><i class="fa fa-file-image" aria-hidden="true"></i> Buscar</span>
																<input type="file" id="fl-fotoprincipal-<?=$klct?>" class="fl-control hide" name="filefotoprincipal-<?=$klct?>" data-content="txt-fotoprincipal-<?=$klct?>"  accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal-<?=$klct?>" >
															</div>
														</div>
													</div>
												</td>
											</tr>
											<? foreach ($categorias['listaMarcas'] as $klm => $marcas): ?>
												<tr class="tr-marca tr-marca-<?=$klct?>" data-marca="<?=$klm?>" data-visitaSosDet="" data-flagCompetencia="<?=$marcas['flagCompetencia']?>">
													<td class="text-center tdBloqueado"></td>
													<td class="text-center"><?=$marcas['marca']?></td>
													<td class="text-center">
														<input class="form-control ipWidth text-center marcasCm marca-cm-<?=$klct?>" data-categoria="<?=$klct?>" type="text" placeholder="CM" id="marca-cm-<?=$klct?>-<?=$klm?>"  name="marca-cm-<?=$klct?>-<?=$klm?>" value="">
													</td>
													<td class="text-center">
														<input class="form-control ipWidth text-center marcasFrentes marca-frentes-<?=$klct?>" data-categoria="<?=$klct?>" type="text" placeholder="Frentes" id="marca-frentes-<?=$klct?>-<?=$klm?>"  name="marca-frentes-<?=$klct?>-<?=$klm?>" value="">
													</td>
													<td class="text-center tdBloqueado"></td>
												</tr>
											<? endforeach ?>
										<? endforeach*/ ?>
									<? //endif ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>