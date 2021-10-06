<?$url = base_url('../'.$this->carpeta['livestorecheck']);?>
<style>
div.toggle.btn{
	border-radius: 20px;
}

div.toggle.btn-success,
label.btn-success {
    background: #03e05b !important;
    border: 0.5px solid #03e05b !important;
}

div.toggle.btn-danger,
label.btn-danger {
	background: #ff4e4e !important;
    border: 0.5px solid #ff4e4e !important;
}

label.btn-success:hover, label.btn-success:focus {
    background-color: #03e05b !important;
}

.toggle-handle {
    left: -9px;
    padding: 8px;
    border-radius: 20px;
}

.off .toggle-handle {
	left: 9px;
}

.toggle-on.btn {
	padding-right: 24px !important;
}

.toggle-off.btn {
    padding-left: 24px !important;
}
</style>
<div class="container-fluid">
	<form id="<?=$frm?>">
		<div class="row content-live">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header card-header-tab">
						<ul class="nav" role="tablist">
							<?$ieva = 0;?>
							<?foreach($evaluaciones as $idEvaluacion => $eva){?>
								<li class="nav-item <?if( $ieva == 0 ){?>active<?}?>" >
									<a href="#tab-lsck-evaluacion-<?=$idEvaluacion?>"
										class="nav-link"
										role="tab"
										aria-controls="tab-lsck-evaluacion-<?=$idEvaluacion?>"
										data-toggle="tab"
									>
										<?=$eva['nombre']?>
									</a>
								</li>
								<?$ieva++;?>
							<?}?>
						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content">
							<?$ieva = 0;?>
							<?foreach($evaluaciones as $idEvaluacion => $eva){?>
								<div role="tabpanel" class="tab-pane fade <?if( $ieva == 0 ){?>show active<?}?>" id="tab-lsck-evaluacion-<?=$idEvaluacion?>">
									<div class="row">
										<?foreach($fotos[$idEvaluacion] as $idAudFoto => $ft){?>
										<div class="col-md-3">
											<input type="hidden" name="idAudFoto" value="<?=$idAudFoto?>">
											<img src="<?=$url.$idAudFoto?>.png" class="img-responsive img-thumbnail">
											<div style="display: table; margin: 0 auto; padding-top: 1rem;">
												<input type="checkbox" name="foto[<?=$idAudFoto?>]" class="chk-lsck-estado" value="1"
													data-toggle="toggle"
													data-on="Activo"
													data-off="Inactivo"
													data-onstyle="success"
													data-offstyle="danger"
													data-size="mini"
													data-width="80"
													<?=(!empty($ft['estado']) ? 'checked' : '')?>
												/>
											</div>
										</div>
										<?}?>
									</div>
								</div>
								<?$ieva++;?>
							<?}?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	$('.chk-lsck-estado').bootstrapToggle();
</script>