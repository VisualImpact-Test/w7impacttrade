<form id="frm-visitaInventario">
	<div class="hide">
		<input class="form-control" type="text" id="idVisita" name="idVisita" value="<?=$idVisita?>">
	</div>
	<div class="row themeWhite">
		<div class="col-md-12">
			<div class="mb-3 mt-3 card">
				<div class="card-header">
					LISTA DE INVETARIO
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="table-responsive">
							<table id="tb-inventario" class="mb-0 table table-bordered table-sm text-nowrap">
								<thead>
									<tr>
										<th class="text-center align-middle">#</th>
										<th class="text-center align-middle">PRODUCTO</th>
										<th class="text-center align-middle">STOCK INICIAL</th>
										<th class="text-center align-middle">SELLIN</th>
										<th class="text-center align-middle">STOCK</th>
										<th class="text-center align-middle">SELL OUT</th>
										<th class="text-center align-middle">OBSERVACIÓN</th>
										<th class="text-center align-middle">COMENTARIO</th>
										<th class="text-center align-middle">FECHA VENCIMIENTO</th>
									</tr>
								</thead>
								<tbody class="tb-inventario">
									<? $ixt=1; ?>
									<? foreach ($listaProductos as $klp => $producto): ?>
										<?
											$idVisitaInventario = ( isset($listaVisitas[$klp]['idVisitaInventario']) && !empty($listaVisitas[$klp]['idVisitaInventario']) ) ? $listaVisitas[$klp]['idVisitaInventario']:'';
											$idVisitaInventarioDet = ( isset($listaVisitas[$klp]['idVisitaInventarioDet']) && !empty($listaVisitas[$klp]['idVisitaInventarioDet']) ) ? $listaVisitas[$klp]['idVisitaInventarioDet']:'';
										?>
										<tr class="tr-inventario" data-producto="<?=$klp?>" data-visitaInventario="<?=$idVisitaInventario;?>" data-visitaInventarioDet="<?=$idVisitaInventarioDet;?>">
											<td class="text-center"><?=$ixt++;?></td>
											<td class="text-center"><?=( !empty($producto['producto']) && $producto['producto'])? $producto['producto']:'-';?></td>
											<td class="text-center">
												<? $listaInventarioStockInicial = ( isset($listaInventarioProductos[$klp]['stockInicial']) && !empty($listaInventarioProductos[$klp]['stockInicial'])) ? $listaInventarioProductos[$klp]['stockInicial']:'';?>
												<? $visitaStockInicial = ( isset($listaVisitas[$klp]['stock_inicial']) && !empty($listaVisitas[$klp]['stock_inicial']) ) ? $listaVisitas[$klp]['stock_inicial']:$listaInventarioStockInicial;?>
												<input class="form-control ipWidth" type="text" placeholder="Stock Inicial" id="stockInicial-<?=$klp?>"  name="stockInicial-<?=$klp?>" value="<?=$visitaStockInicial;?>" readonly>
											</td>
											<td class="text-center">
												<? $listaInventarioSellIn = ( isset($listaInventarioProductos[$klp]['sellin']) && !empty($listaInventarioProductos[$klp]['sellin'])) ? $listaInventarioProductos[$klp]['sellin']:'';?>
												<? $visitaSellin = ( isset($listaVisitas[$klp]['sellin']) && !empty($listaVisitas[$klp]['sellin']) ) ? $listaVisitas[$klp]['sellin']:$listaInventarioSellIn;?>
												<input class="form-control ipWidth" type="text" placeholder="Sell In" id="sellin-<?=$klp?>"  name="sellin-<?=$klp?>" value="<?=$visitaSellin;?>" readonly>
											</td>
											<td class="text-center">
												<? $visitaStock = ( isset($listaVisitas[$klp]['stock']) && !empty($listaVisitas[$klp]['stock']) ) ? $listaVisitas[$klp]['stock']:'';?>
												<input class="form-control ipWidth stockInventario" type="text" placeholder="Stock" id="stock-<?=$klp?>"  name="stock-<?=$klp?>" value="<?=$visitaStock;?>" data-producto="<?=$klp?>">
											</td>
											<td class="text-center">
												<? $visitaValidacion = ( isset($listaVisitas[$klp]['validacion']) && !empty($listaVisitas[$klp]['validacion']) ) ? $listaVisitas[$klp]['validacion']:'';?>
												<input class="form-control ipWidth" type="text" placeholder="Validación" id="validacion-<?=$klp?>"  name="validacion-<?=$klp?>" value="<?=$visitaValidacion;?>" readonly>
											</td>
											<td class="text-center">
												<? $visitaObservacion = ( isset($listaVisitas[$klp]['obs']) && !empty($listaVisitas[$klp]['obs']) ) ? $listaVisitas[$klp]['obs']:'';?>
												<input class="form-control ipWidth" type="text" placeholder="Observación" id="obs-<?=$klp?>"  name="obs-<?=$klp?>" value="<?=$visitaObservacion;?>" readonly>
											</td>
											<td class="text-center">
												<? $visitaComentario = ( isset($listaVisitas[$klp]['comentario']) && !empty($listaVisitas[$klp]['comentario']) ) ? $listaVisitas[$klp]['comentario']:'';?>
												<input class="form-control ipWidth" type="text" placeholder="Comentario" id="comentario-<?=$klp?>"  name="comentario-<?=$klp?>" value="<?=$visitaComentario;?>">
											</td>
											<td class="text-center">
												<div>
													<? $visitaFecVence = ( isset($listaVisitas[$klp]['fecVence']) && !empty($listaVisitas[$klp]['fecVence']) ) ? $listaVisitas[$klp]['fecVence']:'';//date("d/m/Y");?>
													<input class="form-control text-center ipWidth" type="date" placeholder="Fecha Venc." id="fecVenc-<?=$klp?>" name="fecVenc-<?=$klp?>"  value="<?=$visitaFecVence;?>">
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
<script>
	$('#tb-inventario').DataTable();
	setTimeout(function(){
		$('#tb-inventario').DataTable().columns.adjust();
	},1000);
</script>