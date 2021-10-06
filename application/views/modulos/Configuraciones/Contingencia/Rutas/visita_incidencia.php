<form id="frm-visitaIncidencia">
	<div class="hide">
		<input class="form-control" type="text" id="idVisita" name="idVisita" value="<?= $idVisita ?>">
	</div>
	<div class="row themeWhite" style="padding: 10px;padding-top: 0px;">
		<div class="col-lg-12 d-flex">
			<div class="w-100 mb-3 p-0">
				<div class="card-body p-0">
					<ul class="nav nav-tabs nav-justified">
						<li class="nav-item" id="nav-link-0"><a data-toggle="tab" href="#tab-competencia-0" class="nav-link active show">REGISTRAR INCIDENCIA</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="tab-content">
				<? if ($estadoIncidencia == 1) : ?>
					<div class="form-row">
						<div class="col-md-3">
							<div class="position-relative form-group">
								<label class="card-title">TIPO INCIDENCIA:</label>
								<select class="form-control slWidth" name="tipoIncidencia" id="tipoIncidencia" patron="requerido" style="width:100%">
									<option value="">-- Tipo Incidencia --</option>
									<? foreach ($listaTipoIncidencia as $kli => $incidencias) : ?>
										<option value="<?= $incidencias['idIncidencia'] ?>"><?= $incidencias['tipoIncidencia'] ?></option>
									<? endforeach ?>
								</select>
							</div>
							<div class="hide">
								<input type="text" class="form-control" value="" name="nombreIncidencia" id="nombreIncidencia">
							</div>
						</div>
						<div class="col-md-7">
							<div class="position-relative form-group">
								<label class="card-title">COMENTARIO:</label>
								<input type="text" placeholder="Comentario" name="comentarioIncidencia" id="comentarioIncidencia" class="form-control" value="" style="width:100%">
							</div>
						</div>
						<div class="col-md-2">
							<label class="card-title">FOTO INCIDENCIA:</label>
							<br>
							<div id="fotoIncidencia" style="display:inline-flex;" class="divContentImg">
								<div>
									<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal">
										<img class="imgNormal foto fotoMiniatura" name="img-fotoprincipal" id="img-fotoprincipal" src="" alt="" style="width: 40px;display: none;">
									</a>
								</div>
								<div>
									<span class="btn border-0 btn-outline-secondary btn-file btnAbrirFoto disabled" title="Abrir imagen subida"><i class="fal fa-image-polaroid fa-lg" aria-hidden="true"></i></span>
								</div>
								<div>
									<div class="content-input-file">
										<input type="text" readonly="readonly" id="txt-fotoprincipal" name="fotoprincipal" class="hide">
										<input type="text" readonly="readonly" id="txt-fotoprincipal_show" class="text-file hide" placeholder="Solo .jpg">
										<span class="btn border-0 btn-outline-secondary btn-file btnFoto" data-file="fl-fotoprincipal" title="Subir imagen JPG"><i class="fa fa-file-upload fa-lg" aria-hidden="true"></i></span>
										<input type="file" id="fl-fotoprincipal" class="fl-control hide" name="filefotoprincipal" data-content="txt-fotoprincipal" accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal">
									</div>
								</div>
							</div>
						</div>
					</div>
				<? else : ?>
					<div class="alert alert-warning" role="alert">
						<i class="fas fa-question-circle fa-lg"></i> ¿Desea quitar la incidencia a la visita?
					</div>
				<? endif ?>
			</div>
		</div>
	</div>
</form>