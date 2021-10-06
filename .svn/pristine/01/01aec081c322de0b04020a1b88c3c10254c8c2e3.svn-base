<form id="frm-visitaOrden">
	<div class="hide">
		<input class="form-control" type="text" id="idVisita" name="idVisita" value="<?=$idVisita?>">
		<? $idVisitaOrden = ( isset($visita['idVisitaOrden']) && !empty($visita['idVisitaOrden']) ) ? $visita['idVisitaOrden'] : ''; ?>
		<input class="form-control" type="text" id="idVisitaOrden" name="idVisitaOrden" value="<?=$idVisitaOrden?>">
	</div>
	<div class="row themeWhite">
		<div class="col-md-12">
			<div class="mb-3 mt-3 card">
				<div class="card-header">
					REGISTRAR ORDEN DE TRABAJO
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="form-row">
							<div class="col-md-12">
								<div class="position-relative form-group">
									<label for="incidencia"><h5 class="card-title">TIPO DE ORDEN</h5></label>
									<? $tipoOrdenVisita = ( isset($visita['idOrden']) && !empty($visita['idOrden']) ) ? $visita['idOrden'] : ''; ?>
									<select class="form-control slWidth" id="tipoOrden" name="tipoOrden">
										<option value="">-- Tipo Orden --</option>
										<? foreach ($listaOrdenes as $klto => $ordenes): ?>
											<? $selected = ( $ordenes['idOrden']==$tipoOrdenVisita ? 'selected' : '' );?>
											<option value="<?=$ordenes['idOrden']?>" <?=$selected;?>><?=$ordenes['orden']?></option>
										<? endforeach ?>
									</select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="divider"></div>
								<h5 class="card-title">OTRO</h5>
								<? $checkedOtro = ( isset($visita['flagOtro']) && !empty($visita['flagOtro']) && $visita['flagOtro']==1 ) ? 'checked':''; ?>
								<? $descripcionVisita = ( isset($visita['descripcion']) && !empty($visita['descripcion']) ) ? $visita['descripcion'] : ''; ?>
									<div class="input-group">
                                        <div class="input-group-prepend">
                                        	<span class="input-group-text"><input id="otro" name="otro" aria-label="Checkbox for following text input" type="checkbox" value="1" <?=$checkedOtro;?>></span>
                                        </div>
                                        <input placeholder="Descripción" type="text" class="form-control" name="descripcion" id="descripcion" value="<?=$descripcionVisita;?>">
                                    </div>
							</div>
							<div class="col-md-12">
								<div class="divider"></div>
								<h5 class="card-title">FOTO</h5>
								<div class="row" id="foto">
									<? $fotoImg = ( isset($visita['idVisitaFoto']) && !empty($visita['idVisitaFoto']) ) ? $this->fotos_url.'orden/'.$visita['foto']:'';?>
									<div class="col">
										<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal">
											<img class="imgNormal foto" name="img-fotoprincipal" id="img-fotoprincipal" src="<?=$fotoImg;?>" alt="">
										</a>
									</div>
									<div class="col">
										<div class="content-input-file">
											<input type="text" readonly="readonly" id="txt-fotoprincipal" name="fotoprincipal" class="hide" >
											<input type="text" readonly="readonly" id="txt-fotoprincipal_show" class="text-file" placeholder="Solo .jpg" >
											<span class="btn-file btnFoto" data-file="fl-fotoprincipal"><i class="fa fa-file-image" aria-hidden="true"></i> Buscar</span>
											<input type="file" id="fl-fotoprincipal" class="fl-control hide" name="filefotoprincipal" data-content="txt-fotoprincipal"  accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal" >
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="divider"></div>
								<h5 class="card-title">ESTADO DE LA ORDEN</h5>
								<div class="position-relative form-group">
									<div>
									<? $estadoOrdenVisita = ( isset($visita['idOrdenEstado']) && !empty($visita['idOrdenEstado']) ) ? $visita['idOrdenEstado']:''; ?>
									<? foreach ($listaEstadoOrden as $kleo => $estados): ?>
										<? $checkedEstadoOrden = $estados['idOrdenEstado']==$estadoOrdenVisita ? 'checked':'';?>
										<div class="custom-radio custom-control">
											<input type="radio" id="estadoOrden-<?=$kleo?>" name="estadoOrden" class="custom-control-input" <?=$checkedEstadoOrden;?> value="<?=$estados['idOrdenEstado']?>">
											<label class="custom-control-label" for="estadoOrden-<?=$kleo?>"><?=$estados['ordenEstado'];?></label>
										</div>
									<? endforeach ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>