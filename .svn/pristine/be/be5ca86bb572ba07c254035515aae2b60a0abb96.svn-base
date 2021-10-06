<form id="frm-visitaEncartes">
	<div class="hide">
		<input class="form-control" type="text" id="idVisita" name="idVisita" value="<?=$idVisita?>">
	</div>
	<div class="row themeWhite">
		<div class="col-md-12">
			<div class="mb-3 mt-3 card">
				<div class="card-header">
					LISTA DE ENCARTES
					<div class="ml-auto">
						<button type="button" id="btn-addRowPromociones" class="btn btn-primary "><i class="fas fa-plus-circle fa-lg"></i></button>
					</div>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="table-responsive">
							<table id="tb-encartes" class="mb-0 table table-bordered table-sm text-nowrap">
								<thead>
									<tr>
										<th class="text-center align-middle">#</th>
										<th class="text-center align-middle">ENCARTES</th>
										<th class="text-center align-middle">FOTO</th>
									</tr>
								</thead>
								<tbody class="tb-encarte">
									<? $ixt=1; ?>
									<? if ( !empty($listaVisitas)): ?>
										<? foreach ($listaVisitas as $kved => $encartes): ?>
											<tr class="tr-encartes" data-visitaEncartes="1" data-visitaEncartesDet="<?=$kved?>">
												<td class="text-center"><?=$ixt++;?></td>
												<td class="text-center">
													<?=$encartes['categoria']?>
													<div class="hide">
														<? $idCategoria = ( !empty($encartes['idCategoria'])? $encartes['idCategoria']:'' );?>
														<input type="text" id="categoria-<?=$kved?>" name="categoria-<?=$kved?>" value="<?=$idCategoria;?>">
													</div>			
												</td>
												<td class="text-center">
													<div class="row" id="foto-<?=$kved?>">
														<? $fotoImg = ( isset($listaVisitas[$kved]['idVisitaFoto']) && !empty($listaVisitas[$kved]['idVisitaFoto']) ) ? $this->fotos_url.'encartes/'.$listaVisitas[$kved]['foto']:'';?>
														<div class="col">
															<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-<?=$kved?>">
																<img class="fotoMiniatura foto" name="img-fotoprincipal-<?=$kved?>" id="img-fotoprincipal-<?=$kved?>" src="<?=$fotoImg;?>" alt="">
															</a>
														</div>
														<div class="col">
															<div class="content-input-file">
																<input type="text" readonly="readonly" id="txt-fotoprincipal-<?=$kved?>" name="fotoprincipal-<?=$kved?>" class="hide" >
																<input type="text" readonly="readonly" id="txt-fotoprincipal-<?=$kved?>_show" class="text-file" placeholder="Solo .jpg" >
																<span class="btn-file btnFoto" data-file="fl-fotoprincipal-<?=$kved?>"><i class="fa fa-file-image" aria-hidden="true"></i> Buscar</span>
																<input type="file" id="fl-fotoprincipal-<?=$kved?>" class="fl-control hide" name="filefotoprincipal-<?=$kved?>" data-content="txt-fotoprincipal-<?=$kved?>"  accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal-<?=$kved?>" >
															</div>
														</div>
													</div>
												</td>
											</tr>
										<? endforeach ?>
									<? else: ?>
										<? foreach ($listaCategorias as $klct => $categorias): ?>
											<tr class="tr-encartes" data-visitaEncartes="0" data-visitaEncartesDet="<?=$klct?>">
												<td class="text-center"><?=$ixt++;?></td>
												<td class="text-center">
													<?=$categorias['categoria']?>
													<div class="hide">
														<? $idCategoria = ( !empty($categorias['idCategoria'])? $categorias['idCategoria']:'' );?>
														<input type="text" id="categoria-<?=$klct?>" name="categoria-<?=$klct?>" value="<?=$idCategoria;?>">
													</div>	
												</td>
												<td class="text-center">
													<div class="row" id="foto-<?=$klct;?>">
														<div class="col">
															<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-<?=$klct?>">
																<img class="fotoMiniatura foto" name="img-fotoprincipal-<?=$klct?>" id="img-fotoprincipal-<?=$klct?>" src="" alt="">
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
										<? endforeach ?>
									<? endif ?>
								</tbody>
							</table>
							<div class="hide">
								<input class="form-control" type="text" id="contNumberEncartes" id="contNumberEncartes" value="<?=$ixt;?>">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<script>
	//$('#tb-encartes').DataTable();
	ContingenciaRutas.dataListaEncartesCategorias = JSON.parse('<?=json_encode($listaCategorias)?>');
</script>