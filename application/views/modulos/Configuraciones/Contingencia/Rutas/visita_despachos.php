<form id="frm-visitaDespachos">
	<div class="hide">
		<input class="form-control" type="text" id="idVisita" name="idVisita" value="<?=$idVisita?>">
		<? $idVisitaDespachos = ( isset($visita['idVisitaDespachos']) && !empty($visita['idVisitaDespachos']) ) ? $visita['idVisitaDespachos'] : ''; ?>
		<? $idVisitaDesapachosDet = ( isset($visita['idVisitaDesapachosDet']) && !empty($visita['idVisitaDesapachosDet']) ) ? $visita['idVisitaDesapachosDet'] : ''; ?>
		<input class="form-control" type="text" id="idVisitaDespachos" name="idVisitaDespachos" value="<?=$idVisitaDespachos?>">
		<input class="form-control" type="text" id="idVisitaDesapachosDet" name="idVisitaDesapachosDet" value="<?=$idVisitaDesapachosDet?>">
	</div>
	<div class="row themeWhite">
		<div class="col-md-12">
			<div class="mb-3 mt-3 card">
				<div class="card-header">
					INFORMACIÓN DE DESPACHOS
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="form-row">
							<div class="col-md-12">
								<? $visitaPlaca = ( isset($visita['placa']) && !empty($visita['placa']) ) ? $visita['placa'] : ''; ?>
								<div class="position-relative form-group">
									<label for="despachoPlaca"><h5 class="card-title">PLACA</h5></label>
									<input type="text" placeholder="N° Placa" name="despachoPlaca" id="despachoPlaca" class="form-control" value="<?=$visitaPlaca;?>">
								</div>
							</div>
							<div class="col-md-12">
								<div class="divider"></div>
								<h5 class="card-title">FRECUENCIA</h5>
								<div class="position-relative form-group">
                                    <div>
                                        <div class="custom-checkbox custom-control custom-control-inline">
                                        	<? $checkedLunes = ( isset($visita['listaDias'][1]) && !empty($visita['listaDias'][1]) ) ? 'checked':''; ?>
                                        	<input type="checkbox" id="frecuenciaLunes" name="frecuencias" class="custom-control-input inputChecked" value="1" <?=$checkedLunes;?> >
                                        	<label class="custom-control-label" for="frecuenciaLunes">LUNES</label>
                                        </div>
                                        <div class="custom-checkbox custom-control custom-control-inline">
                                        	<? $checkedMartes = ( isset($visita['listaDias'][2]) && !empty($visita['listaDias'][2]) ) ? 'checked':''; ?>
                                        	<input type="checkbox" id="frecuenciaMartes" name="frecuencias" class="custom-control-input inputChecked" value="2" <?=$checkedMartes;?> >
                                        	<label class="custom-control-label" for="frecuenciaMartes">MARTES</label>
                                        </div>
                                        <div class="custom-checkbox custom-control custom-control-inline">
                                        	<? $checkedMiercoles = ( isset($visita['listaDias'][3]) && !empty($visita['listaDias'][3]) ) ? 'checked':''; ?>
                                        	<input type="checkbox" id="frecuenciaMiercoles" name="frecuencias" class="custom-control-input inputChecked" value="3" <?=$checkedMiercoles;?> >
                                        	<label class="custom-control-label" for="frecuenciaMiercoles">MIÉRCOLES</label>
                                        </div>
                                        <div class="custom-checkbox custom-control custom-control-inline">
                                        	<? $checkedJueves = ( isset($visita['listaDias'][4]) && !empty($visita['listaDias'][4]) ) ? 'checked':''; ?>
                                        	<input type="checkbox" id="frecuenciaJueves" name="frecuencias" class="custom-control-input inputChecked" value="4" <?=$checkedJueves;?> >
                                        	<label class="custom-control-label" for="frecuenciaJueves">JUEVES</label>
                                        </div>
                                        <div class="custom-checkbox custom-control custom-control-inline">
                                        	<? $checkedViernes = ( isset($visita['listaDias'][5]) && !empty($visita['listaDias'][5]) ) ? 'checked':''; ?>
                                        	<input type="checkbox" id="frecuenciaViernes" name="frecuencias" class="custom-control-input inputChecked" value="5" <?=$checkedViernes;?> >
                                        	<label class="custom-control-label" for="frecuenciaViernes">VIERNES</label>
                                        </div>
                                        <div class="custom-checkbox custom-control custom-control-inline">
                                        	<? $checkedSabado = ( isset($visita['listaDias'][6]) && !empty($visita['listaDias'][6]) ) ? 'checked':''; ?>
                                        	<input type="checkbox" id="frecuenciaSabado" name="frecuencias" class="custom-control-input inputChecked" value="6" <?=$checkedSabado;?> >
                                        	<label class="custom-control-label" for="frecuenciaSabado">SABADO</label>
                                        </div>
                                        <div class="custom-checkbox custom-control custom-control-inline">
                                        	<? $checkedDomingo = ( isset($visita['listaDias'][7]) && !empty($visita['listaDias'][7]) ) ? 'checked':''; ?>
                                        	<input type="checkbox" id="frecuenciaDomingo" name="frecuencias" class="custom-control-input inputChecked" value="7" <?=$checkedDomingo;?> >
                                        	<label class="custom-control-label" for="frecuenciaDomingo">DOMINGO</label>
                                        </div>
                                    </div>
                                </div>
							</div>
							<div class="col-md-12">
								<div class="divider"></div>
								<h5 class="card-title">HORARIO</h5>
								<div class="row">
									<div class="col-md-6">
										<div class="input-group input-group-lg">
											<? $visitaHoraIni = ( isset($visita['horaIni']) && !empty($visita['horaIni']) ) ? $visita['horaIni'] : ''; ?>
                                            <div class="input-group-prepend"><span class="input-group-text">DESDE</span></div>
                                            <input id="horarioDesde" name="horarioDesde" type="time" class="form-control" value="<?=$visitaHoraIni;?>">
                                        </div>
									</div>
									<div class="col-md-6">
										<div class="input-group input-group-lg">
											<? $visitaHoraFin = ( isset($visita['horaFin']) && !empty($visita['horaFin']) ) ? $visita['horaFin'] : ''; ?>
                                            <div class="input-group-prepend"><span class="input-group-text">HASTA</span></div>
                                            <input id="horarioHasta" name="horarioHasta" type="time" class="form-control" value="<?=$visitaHoraFin;?>">
                                        </div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="divider"></div>
								<div class="position-relative form-group">
									<label for="incidencia"><h5 class="card-title">INCIDENCIA</h5></label>
									<? $incidenciaVisita = ( isset($visita['idIncidencia']) && !empty($visita['idIncidencia']) ) ? $visita['idIncidencia'] : ''; ?>
									<select class="form-control slWidth" id="incidencia" name="incidencia">
										<option value="">-- Incidencias --</option>
										<? foreach ($listaIncidencias as $kli => $incidencia): ?>
											<? $selected = ( $incidencia['idIncidencia']==$incidenciaVisita ? 'selected' : '' );?>
											<option value="<?=$incidencia['idIncidencia']?>" <?=$selected;?>><?=$incidencia['incidencias']?></option>
										<? endforeach ?>
									</select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="divider"></div>
								<div class="position-relative form-group">
									<? $visitaComentario = ( isset($visita['comentario']) && !empty($visita['comentario']) ) ? $visita['comentario'] : ''; ?>
									<label for="despachoComentario"><h5 class="card-title">COMENTARIO</h5></label>
									<input type="text" placeholder="Comentario" name="despachoComentario" id="despachoComentario" class="form-control" value="<?=$visitaComentario;?>">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>