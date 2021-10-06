<form id="frm-visitaSod">
	<div class="hide">
		<input class="form-control" type="text" id="idVisita" name="idVisita" value="<?=$idVisita?>">
	</div>
	<div class="">
		<div class="alert alert-warning" role="alert">
			<i class="fas fa-check-circle"></i> Ante cualquier cambie en las cantidades de los CMs o FRENTES, se pide presionar la tecla ENTER para visualizar los cambios.<br>
			<i class="fas fa-check-circle"></i> Si se desea añadir una nueva categoría,marca o tipo elemento de visibilidad, se recomienda utilizar los gestores respectivos.<br>
			<i class="fas fa-check-circle"></i> Para realizar la visualización o el ingreso de una nueva foto por cada marca y tipo elemento de visibilidad, presione el botón de la camara ubicado al costado de cada cantidad.
		</div>
	</div>
	<div class="row themeWhite">
		<div class="col-md-12">
			<div class="mb-3 mt-3 card">
				<div class="card-header card-header-tab-animation">
					<ul class="nav nav-justified">
						<? $ix=1;?>
						<? foreach ($listaCategorias as $klct => $categorias): ?>
							<? $active = ( $ix==1 ? 'active':'' );?>
							<li class="nav-item"><a data-toggle="tab" href="#tab-categoria-<?=$klct?>" class="nav-link <?=$active;?> show text-uppercase"><?=$categorias['categoria'];?></a></li>
							<? $ix++;?>
						<? endforeach ?>
					</ul>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<!----DETALLE CATEGORIAS--->
						<? $ix=1; ?>
						<? foreach ($listaCategorias as $klct => $categorias): ?>
							<? $active = ( $ix==1 ? 'active':'' );?>
							<div class="tab-pane <?=$active?> show" id="tab-categoria-<?=$klct?>" role="tabpanel">
								<!--h5 class="card-title">CATEGORÍA: <?//=$categorias['categoria']?></h5-->
								<div class="hide"><input type="text" class="categorias" value="<?=$klct?>"></div>

								<div class="table-responsive">
									<table id="tb-sod-<?=$klct?>" class="mb-0 table table-bordered table-sm text-nowrap">
										<thead>
											<tr>
												<th class="text-center align-middle" rowspan="3">#</th>
												<th class="text-center align-middle text-uppercase" rowspan="3">MARCAS</th>
											</tr>
											<tr>
												<? foreach ($listaElementoVisibilidad as $kev => $elemento): ?>
													<th class="text-center align-middle text-uppercase" colspan="2"><?=$elemento['elementoVisibilidad'];?></th>
												<? endforeach ?>
											</tr>
											<tr>
												<? foreach ($listaElementoVisibilidad as $kev => $elemento): ?>
													<th class="text-center align-middle" colspan="2">
														<? $cantidadElemento = ( isset($listaVisitas['listaCategorias'][$klct]['listaElementoVisibilidad'][$kev]['cant']) && !empty($listaVisitas['listaCategorias'][$klct]['listaElementoVisibilidad'][$kev]['cant']) ) ? $listaVisitas['listaCategorias'][$klct]['listaElementoVisibilidad'][$kev]['cant'] : 0;?>
														<input class="form-control ipWidth text-center iptCategorias-<?=$klct?>" type="text" placeholder="Cantidad" id="cantidadEleVisibilidad-<?=$klct?>-<?=$kev?>"  name="cantidadEleVisibilidad-<?=$klct?>-<?=$kev?>" value="<?=$cantidadElemento;?>" readonly="readonly">
													</th>
												<? endforeach ?>
											</tr>
										</thead>
										<tbody>
											<!----DETALLE MARCAS---->
											<? $ixt=1; ?>
											<? foreach ($categorias['listaMarcas'] as $klm => $marcas): ?>
												<tr class="text-center">
													<td class="text-center"><?=$ixt++;?></td>
													<td class="text-center text-uppercase"><?=$marcas['marca']?></td>
													<? foreach ($listaElementoVisibilidad as $kev => $elemento): ?>
														<td class="text-center">
															<? $cantidadMarcaElemento = ( isset($listaVisitas['listaCategorias'][$klct]['listaMarcas'][$klm]['listaElementoVisibilidad'][$kev]['cant']) && !empty($listaVisitas['listaCategorias'][$klct]['listaMarcas'][$klm]['listaElementoVisibilidad'][$kev]['cant']) ) ? $listaVisitas['listaCategorias'][$klct]['listaMarcas'][$klm]['listaElementoVisibilidad'][$kev]['cant'] : 0;?>
															<input class="form-control ipWidth text-center ipCantidadMarcaElemento inputCategoria-<?=$klct?> cantidad-<?=$klct?>-<?=$kev?>" type="text" placeholder="Cantidad" id="cantidad-<?=$klct?>-<?=$klm?>-<?=$kev?>" name="cantidad-<?=$klct?>-<?=$klm?>-<?=$kev?>" value="<?=$cantidadMarcaElemento?>" data-categoria="<?=$klct?>" data-marca="<?=$klm?>" data-elementoVisibilidad="<?=$kev?>">
														</td>
														<td class="text-center">
															<? $btnColor = ($cantidadMarcaElemento>0) ? 'btn-success':'btn-primary';?>
															<button class="btn <?=$btnColor?> btn-sod-fotos" type="button"  data-categoria="<?=$klct?>" data-marca="<?=$klm?>" data-elementoVisibilidad="<?=$kev?>"><i class="fas fa-camera fa-lg"></i></button>
														</td>
													<? endforeach ?>
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