<form id="frm-visitaPrecios">
	<div class="hide">
		<input class="form-control" type="text" id="idVisita" name="idVisita" value="<?= $idVisita ?>">
	</div>
	<div class="row themeWhite" style="padding: 10px;padding-top: 0px;">
		<div class="col-lg-12 d-flex">
			<div class="w-100 mb-3 p-0">
				<div class="card-body p-0">
					<ul class="nav nav-tabs nav-justified">
						<? $ix = 1; ?>
						<? foreach ($listaCompetencia as $klc => $competencia) : ?>
							<? $active = ($ix == 1 ? 'active' : ''); ?>
							<li class="nav-item" id="nav-link-<?= $klc ?>"><a data-toggle="tab" href="#tab-competencia-<?= $klc ?>" class="nav-link <?= $active; ?> show"><?= $competencia['competencia']; ?></a></li>
							<? $ix++; ?>
						<? endforeach ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="tab-content">
				<!----DETALLE COMPETENCIA--->
				<? $ix = 1; ?>
				<? foreach ($listaCompetencia as $klc => $competencia) : ?>
					<? $active = ($ix == 1 ? 'active' : ''); ?>
					<div class="tab-pane <?= $active ?> show" id="tab-competencia-<?= $klc ?>" role="tabpanel">
						<!--h5 class="card-title"><? //=$competencia['competencia']
													?></h5-->

						<!----DETALLE CATEGORIAS---->
						<div class="table-responsive">
							<table id="tb-precios-<?= $klc ?>" class="mb-0 table table-bordered text-nowrap w-100" width="100%">
								<thead>
									<tr>
										<th class="text-center align-middle">#</th>
										<th class="text-center align-middle">CATEGORIA</th>
										<th class="text-center align-middle">MARCA</th>
										<th class="text-center align-middle">PRODUCTO</th>
										<th class="text-center align-middle">PRECIO</th>
										<th class="text-center align-middle">PRECIO REGULAR</th>
										<th class="text-center align-middle">PRECIO OFERTA</th>
										<th class="text-center align-middle hide">PRECIO PROM1</th>
										<th class="text-center align-middle hide">PRECIO PROM2</th>
										<th class="text-center align-middle hide">PRECIO PROM3</th>
									</tr>
								</thead>
								<tbody class="tb-competencia" data-tbCompetencia="<?= $klc; ?>">
									<? $ixt = 1; ?>
									<? foreach ($competencia['listaCategorias'] as $klct => $categoria) : ?>
										<!--tr>
													<td class="text-center font-weight-bold text-uppercase" colspan="10"><?= $categoria['categoria'] ?></td>
												</tr-->
										<? foreach ($categoria['listaMarcas'] as $klm => $marca) : ?>
											<? foreach ($marca['listaProductos'] as $klp => $producto) : ?>
												<?
												$idVisitaPrecios = (isset($listaVisitas[$klc][$klp]['idVisitaPrecios']) && !empty($listaVisitas[$klc][$klp]['idVisitaPrecios'])) ? $listaVisitas[$klc][$klp]['idVisitaPrecios'] : '';
												$idVisitaPreciosDet = (isset($listaVisitas[$klc][$klp]['idVisitaPreciosDet']) && !empty($listaVisitas[$klc][$klp]['idVisitaPreciosDet'])) ? $listaVisitas[$klc][$klp]['idVisitaPreciosDet'] : '';
												?>
												<tr class="tr-precios" data-competencia="<?= $klc ?>" data-categoria="<?= $klct ?>" data-marca="<?= $klm ?>" data-producto="<?= $klp ?>" data-visitaPrecios="<?= $idVisitaPrecios; ?>" data-visitaPreciosDet="<?= $idVisitaPreciosDet; ?>">

													<td class="text-center"><?= $ixt++; ?></td>
													<!--td class="text-center text-uppercase"><?= $categoria['categoria'] ?></td-->
													<td class="text-center text-uppercase"><?= $klp; ?></td>
													<td class="text-center"><?= $marca['marca'] ?></td>
													<td class="text-center"><?= $producto['producto'] ?></td>
													<td class="text-center">
														<? $precioVisita = (isset($listaVisitas[$klc][$klp]['precio']) && !empty($listaVisitas[$klc][$klp]['precio'])) ? $listaVisitas[$klc][$klp]['precio'] : ''; ?>
														<input class="form-control form-control-sm ipWidth" type="text" placeholder="Precio" id="precio-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>" name="precio-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>" value="<?= $precioVisita; ?>" style="width: 92%;">
													</td>
													<td class="text-center">
														<? $precioRegularVisita = (isset($listaVisitas[$klc][$klp]['precioRegular']) && !empty($listaVisitas[$klc][$klp]['precioRegular'])) ? $listaVisitas[$klc][$klp]['precioRegular'] : ''; ?>
														<input class="form-control form-control-sm ipWidth" type="text" placeholder="Precio Regular" id="precioRegular-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>" name="precioRegular-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>" value="<?= $precioRegularVisita; ?>" style="width: 92%;">
													</td>
													<td class="text-center">
														<? $precioOfertaVisita = (isset($listaVisitas[$klc][$klp]['precioOferta']) && !empty($listaVisitas[$klc][$klp]['precioOferta'])) ? $listaVisitas[$klc][$klp]['precioOferta'] : ''; ?>
														<input class="form-control form-control-sm ipWidth" type="text" placeholder="Precio Oferta" id="precioOferta-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>" name="precioOferta-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>" value="<?= $precioOfertaVisita; ?>" style="width: 92%;">
													</td>
													<td class="text-center hide">
														<? $precioProm1Visita = (isset($listaVisitas[$klc][$klp]['precioProm1']) && !empty($listaVisitas[$klc][$klp]['precioProm1'])) ? $listaVisitas[$klc][$klp]['precioProm1'] : ''; ?>
														<input class="form-control form-control-sm ipWidth" type="text" placeholder="Precio Prom01" id="precioProm1-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>" name="precioProm1-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>" value="<?= $precioProm1Visita; ?>" style="width: 92%;">
													</td>
													<td class="text-center hide">
														<? $precioProm2Visita = (isset($listaVisitas[$klc][$klp]['precioProm2']) && !empty($listaVisitas[$klc][$klp]['precioProm2'])) ? $listaVisitas[$klc][$klp]['precioProm2'] : ''; ?>
														<input class="form-control form-control-sm ipWidth" type="text" placeholder="Precio Prom02" id="precioProm2-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>" name="precioProm2-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>" value="<?= $precioProm2Visita; ?>" style="width: 92%;">
													</td>
													<td class="text-center hide">
														<? $precioProm3Visita = (isset($listaVisitas[$klc][$klp]['precioProm3']) && !empty($listaVisitas[$klc][$klp]['precioProm3'])) ? $listaVisitas[$klc][$klp]['precioProm3'] : ''; ?>
														<input class="form-control form-control-sm ipWidth" type="text" placeholder="Precio Prom03" id="precioProm3-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>" name="precioProm3-<?= $klc ?>-<?= $klct ?>-<?= $klm ?>-<?= $klp ?>" value="<?= $precioProm3Visita; ?>" style="width: 92%;">
													</td>
												</tr>
											<? endforeach ?>
										<? endforeach ?>
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
</form>

<script>
	$('#tb-precios-0').DataTable();
	$('#tb-precios-1').DataTable();

	setTimeout(function() {
		$('#tb-precios-0').DataTable().columns.adjust();
		$('#tb-precios-1').DataTable().columns.adjust();
	}, 1000);
</script>