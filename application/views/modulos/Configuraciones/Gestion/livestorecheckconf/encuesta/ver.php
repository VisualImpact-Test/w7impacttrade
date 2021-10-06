<div class="row px-5 pt-3">
	<div class="col-md-12">
		<div class="form-group">
			<label class="font-weight-bold">* <?=$encuesta?></label> 
			<small style="color: #808080 !important;"><?=!empty($flag_cliente)? " (La encuesta está dirigida a la Tienda) ": " (La encuesta está dirigida a la Evaluación) " ?></small>

		</div>
	</div>
	<div class="col-md-12">
		<div class="row pl-5">
			
			<?$i=1; foreach($preguntas as $idPregunta => $preg){?>
				<div class="card border-success mb-3" style="max-width: 25rem;width:25rem">
					<div class="card-header bg-transparent border-success <?=( empty($alternativas[$idPregunta]) ? 'mb-0' : '' )?>">
						<label class="font-weight-bold"> <?=$i++.'. '.$preg['nombre']?> <small style="color: #808080 !important;">(<?=$preg['tipo']?>)</small></label>
					</div>
					<div class="card-body text-primary">
						<?if( !empty($alternativas[$idPregunta]) ){?>
						<div class="row px-3 pb-3">
							<?$e = 1 ;foreach($alternativas[$idPregunta] as $idAlternativa => $alt){?>
							<div class="col-md-12">
								<div class="form-group">
									<span><?=$e++.') '.$alt['nombre']?></span>
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
					<?if($preg['tipo'] == 'Multiple' && !empty($preg['tipoAuditoria'])){?>
						<div class="card-footer ">
							<?if(!empty($preg['flag_presencia'])){?>
								<small class="text-muted">Presentes </small>
							<?}else{?>
								<small class="text-muted">No presentes </small>
							<?}?>
						</div>
					<?}?>
				</div>
			<?}?>
		</div>
	</div>
</div>