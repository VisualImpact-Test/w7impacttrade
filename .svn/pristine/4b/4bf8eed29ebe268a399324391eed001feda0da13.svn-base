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
	padding-right: 21px !important;
}

.toggle-off.btn {
    padding-left: 21px !important;
}
</style>
<div class="container-fluid">
	<form id="<?=$frm?>">
		<div class="row content-live">
			<div class="col-md-12">
			<div class="card">
				<div class="card-header card-header-tab">
					<ul class="nav">
						<?$icat = 0;?>
						<?foreach($categorias as $idCategoria => $cg){?>
							<li class="nav-item <?if( $icat == 0 ){?>active<?}?>">
								<a href="#tab-live-categoria-<?=$idCategoria?>"
									class="nav-link <?if( $icat == 0 ){?>active<?}?>"
									role="tab"
									aria-controls="tab-live-categoria-<?=$idCategoria?>"
									data-toggle="tab"
								><?=$cg['nombre']?></a></li>
							<?$icat++;?>
						<?}?>
					</ul>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<?$icat = 0;?>
						<?foreach($categorias as $idCategoria => $cg){?>
							<div id="tab-live-categoria-<?=$idCategoria?>" class="tab-pane fade <?if( $icat == 0 ){?>show active<?}?>" role="tabpanel">
							<?foreach($evaluaciones[$idCategoria] as $idEvaluacion => $eva){?>
								<div class="row p-1">
									<div class="col-md-12">
										<label class="text-bold"><?=$eva['nombre']?></label>
									</div>
									<?foreach($fotos[$idCategoria][$idEvaluacion] as $idAuditoriaFoto => $ft){?>
									<div class="col-md-3">
										<input type="hidden" name="idAuditoriaFoto" value="<?=$idAuditoriaFoto?>">
										<img src="<?=$url.$idAuditoriaFoto?>.png" class="img-responsive img-thumbnail">
										<div style="display: table; margin: 0 auto; padding-top: 1rem;">
											<input type="checkbox" name="foto[<?=$idAuditoriaFoto?>]" class="chk-live-estado" value="1"
												data-toggle="toggle"
												data-on="Activo"
												data-off="Inactivo"
												data-onstyle="success"
												data-offstyle="danger"
												data-size="mini"
												data-width="75"
												<?=(!empty($ft['estado']) ? 'checked' : '')?>
											/>
										</div>
									</div>
									<?}?>
								</div>
							<?}?>
							</div>
							<?$icat++;?>
						<?}?>
					</div>
				</div>
			</div>
			</div>
		</div>
	</form>
</div>
<script>
	$('.chk-live-estado').bootstrapToggle();
</script>