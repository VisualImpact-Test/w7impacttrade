<?if( !$onlyForm ){?>
		<style>
			body {
				background-color: #dedede;
			}
		</style>
		<div class="container" style="margin-top: 3rem; padding: 0; background-color: transparent;">
			<nav class="navbar navbar-menu navbar-default" style="border-radius: 8px 8px 0 0; margin: 0; border: 0;">
				<img src="assets/images/logos/visual.png" style="margin: 0.8rem; height: 40px;" />
			</nav>
		</div>
		<div class="container" style="padding: 0; background-color: transparent;">
			<div id="content-lsck-orden" style="padding: 3rem; background-color: #fff; border: 1px solid transparent; border-radius: 0 0 8px 8px;">
<?}?>
				<?if( empty($fecRespuesta) ){?>
				<form id="frm-lsck-orden">
					<div class="row">
						<div class="col-md-12">
							<h4><?=$cliente?></h4>
							<input type="hidden" name="idAudClienteEvalPreg" value="<?=$idAudClienteEvalPreg?>">
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Pregunta:</label><br>
								<span style="margin-left: 2rem;"><?=$pregunta?></span>
							</div>
							<div class="form-group">
								<label>Orden de Trabajo:</label><br>
								<span style="margin-left: 2rem;"><?=$ordenTrabajo?></span>
							</div>
							<?if( !empty($item[$idAudClienteEvalPreg]) ){?>
								<div class="form-group">
									<label>Item Faltantes:</label><br>
									<?foreach($item[$idAudClienteEvalPreg] as $i){?>
									<li style="margin-left: 2rem;"><?=$i?></li>
									<?}?>
								</div>
							<?}?>
							<div class="form-group">
								<label>¿Se solucionó?</label>
								<div class="radio" style="margin-top: 0;">
									<label><input type="radio" name="estado" value="0" > NO</label>
								</div>
								<div class="radio">
									<label><input type="radio" name="estado" value="1" > SI</label>
								</div>
							</div>
							<div class="form-group">
								<label>Comentario:</label>
								<textarea name="observacion" class="form-control" style="resize: none;"></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<button type="button" id="btn-lsck-orden-guardar" class="btn btn-primary"><i class="far fa-save"></i> Guardar</button>
						</div>
					</div>
				</form>
				<?} else{?>
					<div class="row">
						<div class="col-md-12">
							<?=createMessage(array('type' => 2, 'message' => 'ya se mandó una respuesta para esta orden de trabajo'))?>
						</div>
					</div>
				<?}?>
<?if( !$onlyForm ){?>
			</div>
		</div>
<?}?>