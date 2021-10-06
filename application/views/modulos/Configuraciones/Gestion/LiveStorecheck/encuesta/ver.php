<div class="row px-5 pt-3">
	<div class="col-md-12">
		<div class="form-group">
			<label class="font-weight-bold">* <?=$encuesta?></label>
		</div>
	</div>
	<div class="col-md-12">
		<div class="row pl-5">
			<?foreach($preguntas as $idPregunta => $preg){?>
				<div class="col-md-12">
					<div class="form-group <?=( empty($alternativas[$idPregunta]) ? 'mb-0' : '' )?>">
						<label class="font-weight-bold"><?=$preg['nombre']?> <small style="color: #808080 !important;">(<?=$preg['tipo']?>)</small></label>
					</div>
					<?if( !empty($alternativas[$idPregunta]) ){?>
					<div class="row px-3 pb-3">
						<?foreach($alternativas[$idPregunta] as $idAlternativa => $alt){?>
						<div class="col-md-12">
							<div class="form-group">
								<span><?=$alt['nombre']?></span>
							</div>				
						</div>
						<?}?>
					</div>
					<?} else{?>
					<div class="row px-3">
						<div class="col-md-12">
							<div class="form-group">
								<?if(!empty($preg['tipoAuditoria'])){?>
									<span>La pregunta está compuesta por auditoría de <?=$preg['tipoAuditoria']?> </span>
								<?}else{?>
									<span>No se encontró alternativas.</span>
								<?}?>
							</div>				
						</div>
					</div>
					<?}?>
				</div>
			<?}?>
		</div>
	</div>
</div>