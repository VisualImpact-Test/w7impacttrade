<? foreach ($encuesta as $row => $value) { ?>
	<h5><strong><?= $value['name']; ?></strong></h5>
	<div class="table-responsive">
		<!--style="overflow:auto;"-->
		<table class="mb-0 table table-bordered table-sm text-nowrap">
			<thead class="bg-light">
				<tr class="">
					<th class="text-center align-middle">#</th>
					<th class="text-center align-middle">PREGUNTA</th>
					<th class="text-center align-middle">RESPUESTA</th>
					<th class="text-center align-middle">FOTO</th>
				</tr>
			</thead>
			<tbody>
			<? $i= 1;?>
			<?foreach($pregunta[$row] as $idPregunta => $v_preg){?>
				<tr>
					<td><?=$i++?></td>
					<td><?=$v_preg['pregunta'];?></td>
					<td>
						<ul class="list-group list-group-flush">
							<?if( empty($alternativa[$idPregunta]) ){?>
								<li class="list-group-item">
									<?=strlen($v_preg['respuesta']) > 0 ? $v_preg['respuesta'] : '-'?>
								</li>
							<?} else{?>
								<?foreach($alternativa[$idPregunta] as $idAlternativa => $v_alt){?>
									<li class="list-group-item">
										<div class="row">
											<div class="col-<?=empty($v_alt['foto']) ? 12 : 8?>">
												<?=$v_alt['respuesta']?>
											</div>
											<?if( !empty($v_alt['foto']) ){?>
											<div class="col-4 text-right">
												<button type="button"
													class="btn-visita-encuesta-alt-foto btn btn-sm px-1 text-primary"
													title="Ver Foto"
													data-url="<?=site_url("controlFoto/obtener_carpeta_foto/encuestas/{$v_alt['foto']}")?>">
													<i class="fal fa-camera-retro fa-lg"></i>
												</button>
											</div>
											<?}?>
										</div>
									</li>
								<?}?>
							<?}?>
						</ul>
					</td>
					<?if($i==2){?>
						<?$foto = '<img src="assets/images/sin_imagen.jpg" width="96px" >';?>
						<?if(!empty($value['foto'])){?>
							<?
								$fotoUrl = site_url("controlFoto/obtener_carpeta_foto/encuestas/{$value['foto']}");

								$foto = '<a href="javascript:;" class="lk-foto" data-fotourl="'.$fotoUrl.'">';
									$foto .= '<img src="'.$fotoUrl.'" width="96px" >';
								$foto .= '</a>';
							?>
						<?}?>
						<td rowspan="<?=count($pregunta[$row])?>" class="text-center" >
							<?=$foto?>
						</td>
					<?}?>
				</tr>
			<?}?>
			</tbody>
		</table>
	</div>
<?}?>
<script>
	$(document)
		.off('click','.btn-visita-encuesta-alt-foto')
		.on('click','.btn-visita-encuesta-alt-foto', function(){
			var control = $(this);
			var img = '<img src="' + control.data('url')  + '" class="img-fluid">'

			Fn.showModal({
				id: ++modalId,
				show: true,
				title: 'Foto',
				frm: img,
				btn: [{ title: 'Cerrar', fn: 'Fn.showModal({ id: ' + modalId + ', show: false });' }]
			});
		});
</script>
