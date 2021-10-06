<form id="frm-visitaFotos">
	<div class="hide">
		<input class="form-control" type="text" id="idVisita" name="idVisita" value="<?=$idVisita?>">
	</div>
	<div class="row themeWhite">
		<div class="col-md-12">
			<div class="mb-3 mt-3 card">
				<div class="card-header">
					LISTA DE FOTOS DE LA VISITA
					<div class="ml-auto">
						<button type="button" id="btn-addRowFoto" class="btn btn-primary "><i class="fas fa-plus-circle fa-lg"></i></button>
					</div>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="table-responsive">
							<table id="tb-fotos" class="mb-0 table table-bordered table-sm text-nowrap">
								<thead>
									<tr>
										<th class="text-center align-middle">#</th>
										<th class="text-center align-middle">MÓDULO</th>
										<th class="text-center align-middle">FOTO</th>
									</tr>
								</thead>
								<tbody class="tb-foto">
									<? $ix=1; ?>
									<? foreach ($listaFotos as $kvf => $fotos): ?>
										<?
											$modulo = $fotos['modulo'];
											$carpeta = '';
											switch ( $fotos['idModulo'] ) {
												case 1: $carpeta = 'encuestas/'; break;
												case 2: $carpeta = 'ipp/'; break;
												case 3: $carpeta = 'checklist/'; break;
												case 4: $carpeta = 'seguimientoPlan/'; break;
												case 5: 
													$res = explode("_", $fotos['foto']);
													//var_dump($res);
													if ( isset($res[2]) ) {
														if ( $res[2]=='SOD.jpg' ) {
															$modulo = 'SOD';
															$carpeta = 'sod/'; 
														} elseif ( $res[2]=='SOS.jpg' ) {
															$modulo = 'SOS';
															$carpeta = 'sos/'; 
														} elseif ( $res[2]=='ENCARTES.jpg' ) {
															$modulo = 'ENCARTES';
															$carpeta = 'encartes/'; 
														}
													}
													break;
												case 6: $carpeta = '/'; break;
												case 7: $carpeta = 'promociones/'; break;
												case 8: $carpeta = 'despachos/'; break;
												case 9: $carpeta = 'moduloFotos/'; break;
												case 10: $carpeta = '/'; break;
												case 11: $carpeta = '/'; break;
												case 12: $carpeta = '/'; break;
												case 13: $carpeta = '/'; break;
												case 14: $carpeta = '/'; break;
												case 15: $carpeta = '/'; break;
												case 16: $carpeta = 'visiblidad/'; break;
												case 17: $carpeta = '/'; break;
												case 18: $carpeta = '/'; break;
												case 19: $carpeta = '/'; break;
												case 20: $carpeta = '/'; break;
												case 21: $carpeta = '/'; break;
												case 22: $carpeta = 'iniciativa/'; break;
												case 23: $carpeta = 'inteligencia/'; break;
												case 24: $carpeta = '/'; break;
												case 25: $carpeta = 'orden/'; break;
												case 26: $carpeta = '/'; break;
												case 27: $carpeta = '/'; break;
												case 28: $carpeta = 'encuestasPremio/'; break;

											}
										?>
										<tr>
											<td class="text-center"><?=$ix++;?></td>
											<td class="text-center text-uppercase"><?=$modulo;?></td>
											<td class="text-center">
												<a href="javascript:;" class="lk-foto-1" data-content="foto-<?=$ix?>">
													<img id="foto-<?=$ix?>" class="imgNormal" src="<?=$this->fotos_url.$carpeta.$fotos['foto']?>" alt="">
												</a>
											</td>
											<td class="text-center">
												<button type="button" class="btn-deleteRowFotosAdicionales btn btn-danger" ><i class="fas fa-trash fa-lg"></i></button>
											</td>
										</tr>
									<? endforeach ?>
								</tbody>
							</table>
							<div class="hide">
								<input class="form-control" type="text" id="contNumberFotos" id="contNumberFotos" value="<?=$ix;?>">
							</div>				
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<script>
	ContingenciaRutas.dataListaTipoFoto = JSON.parse('<?=json_encode($listaTipoFoto)?>');
</script>