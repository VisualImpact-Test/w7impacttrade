<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-header-tab card-header">
				<ul class="nav">
					<li class="nav-item active"><a data-toggle="tab" href="#tab-content-1" data-value="1" class="nav-link btnOpcionTab">Elementos</a></li>
					<li class="nav-item"><a data-toggle="tab" href="#tab-content-2" data-value="2" class="nav-link btnOpcionTab">Auditoria Visibilidad Obligatoria</a></li>
					<li class="nav-item"><a data-toggle="tab" href="#tab-content-3" data-value="3" class="nav-link btnOpcionTab">Auditoria Visibilidad Iniciativa</a></li>
					<li class="nav-item"><a data-toggle="tab" href="#tab-content-4" data-value="4" class="nav-link btnOpcionTab">Auditoria Visibilidad Adicional</a></li>
				</ul>
				<div class="d-none d-lg-block funciones">
					<span id="opciones-1">
						<button id="btn-filtrarElementosVisibilidad" class="btn btn-outline-primary border-0" data-url="filtrar" title="FILTRAR"><i class="fas fa-filter"></i></button>
						<button id="btn-cambiarEstadoElementos" class="btn btn-outline-primary border-0" data-url="cambiarEstadoElementos" title="DESACTIVAR/ACTIVAR"><i class="fas fa-yin-yang"></i></button>
						<button id="btn-nuevoElemento" class="btn btn-outline-primary border-0" data-url="nuevoElemento" title="NUEVO ELEMENTO"><i class="fas fa-file-alt"></i></button>
						<button id="btn-cargaMasivaElemento" class="btn btn-outline-primary border-0" data-url="nuevoElementoMasivo" title="CARGA MASIVA"><i class="fas fa-plus-square"></i></button>
					</span>
					<span id="opciones-2">
						<button class="btn btn-outline-primary border-0 btn-filtrarAuditoriaVisibilidad" data-visibilidad="obligatoria" data-url="filtrarAuditoriaVisibilidad" title="FILTRAR"><i class="fas fa-filter"></i></button>
						<button id="btn-deBajaAuditoriaObligatoria" class="btn btn-outline-primary border-0" data-url="deBajaAuditoriaObligatoria" title="DE BAJA"><i class="fas fa-thumbs-down"></i></button>
						<button id="btn-deAltaAuditoriaObligatoria" class="btn btn-outline-primary border-0" data-url="deAltaAuditoriaObligatoria" title="DE ALTA"><i class="fas fa-thumbs-up"></i></button>
						<button id="btn-nuevaListaObligatoria" class="btn btn-outline-primary border-0" data-url="nuevoListaObligatoria" title="NUEVO LISTA OBLIGATORIA"><i class="fas fa-file-alt"></i></button>
						<button id="btn-nuevaListaObligatoriaMasiva" class="btn btn-outline-primary border-0" data-url="nuevoListaObligatoriaMasiva" title="CARGA MASIVA"><i class="fas fa-plus-square"></i></button>
					</span>
					<span id="opciones-3">
						<button class="btn btn-outline-primary border-0 btn-filtrarAuditoriaVisibilidad" data-visibilidad="iniciativa" data-url="filtrarAuditoriaVisibilidad" title="FILTRAR"><i class="fas fa-filter"></i></button>
						<button id="btn-deBajaAuditoriaIniciativa" class="btn btn-outline-primary border-0" data-url="deBajaAuditoriaIniciativa" title="DE BAJA"><i class="fas fa-thumbs-down"></i></button>
						<button id="btn-deAltaAuditoriaIniciativa" class="btn btn-outline-primary border-0" data-url="deAltaAuditoriaIniciativa" title="DE ALTA"><i class="fas fa-thumbs-up"></i></button>
						<button id="btn-nuevaListaIniciativa" class="btn btn-outline-primary border-0" data-url="nuevoListaIniciativa" title="NUEVO LISTA INICIATIVA"><i class="fas fa-file-alt"></i></button>
						<button id="btn-nuevaListaIniciativaMasiva" class="btn btn-outline-primary border-0" data-url="nuevoListaIniciativaMasiva" title="CARGA MASIVA"><i class="fas fa-plus-square"></i></button>
					</span>
					<span id="opciones-4">
						<button class="btn btn-outline-primary border-0 btn-filtrarAuditoriaVisibilidad" data-visibilidad="adicional" data-url="filtrarAuditoriaVisibilidad" title="FILTRAR"><i class="fas fa-filter"></i></button>
						<button id="btn-deBajaAuditoriaAdicional" class="btn btn-outline-primary border-0" data-url="deBajaAuditoriaAdicional" title="DE BAJA"><i class="fas fa-thumbs-down"></i></button>
						<button id="btn-deAltaAuditoriaAdicional" class="btn btn-outline-primary border-0" data-url="deAltaAuditoriaAdicional" title="DE ALTA"><i class="fas fa-thumbs-up"></i></button>
						<button id="btn-nuevaListaAdicional" class="btn btn-outline-primary border-0" data-url="nuevoListaAdicional" title="NUEVO LISTA ADICIONAL"><i class="fas fa-file-alt"></i></button>
						<button id="btn-nuevaListaAdicionalMasiva" class="btn btn-outline-primary border-0" data-url="nuevoListaAdicionalMasiva" title="CARGA MASIVA"><i class="fas fa-plus-square"></i></button>
					</span>
					<button type="button" data-toggle="collapse" href="#collapseBodyElementosVisibilidad" title="DESPLEGAR FILTROS" class="btn btn-outline-primary border-0 btnCollapse"><i class="fas fa-caret-down fa-lg" aria-hidden="true"></i></button>
				</div>
			</div>
			<div class="card-body collapse" id="collapseBodyElementosVisibilidad">
				<div class="tab-content">
					<div class="tab-pane show active" id="tab-content-1" role="tabpanel">
						<form id="frm-elementosVisibilidad">
							<div class="form-row mb-3">
								<!--div class="col-auto">
									<input name="txt-fechas" id="txt-fechas-1" value="<?=date("d/m/Y").' - '.date("d/m/Y") ?>" type="text" class="form-control form-control-sm form-fecha">
								</div-->
								<div class="col-auto">
									<select class="form-control slWidth" id="slTipoElemento" name="slTipoElemento">
										<option value="">-- Tipo Elemento --</option>
										<? foreach ($listadoTipos as $klte => $tipo): ?>
											<option value="<?=$tipo['idTipoElementoVis']?>"><?=$tipo['tipoElemento']?></option>
										<? endforeach ?>
									</select>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane show" id="tab-content-2" role="tabpanel">
						<form id="frm-AudVisibilidadOblig">
							<div class="form-row mb-3">
								<div class="d-none">
									<input type="text" name="visibilidad" class="form-control form-control-sm" value="obligatoria">
								</div>
								<div class="col-auto">
									<input name="txt-fechas" id="txt-fechas-2" value="<?= date("d/m/Y").' - '.date("d/m/Y") ?>" type="text" class="form-control form-control-sm form-fecha">
								</div>
								<div class="col-auto">
                                    <!--label for='proyecto'>Proyecto</label><br-->
                                    <?= getFiltros(['proyecto' => ['label' => 'Proyecto', 'name' => 'proyecto', 'id' => 'proyecto', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                                </div>
                                <div class="col-auto">
                                    <!--label for='grupoCanal'>Grupo Canal</label><br-->
                                    <?= getFiltros(['grupoCanal' => ['label' => 'Grupo Canal', 'name' => 'grupoCanal', 'id' => 'grupoCanal', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                                </div>
                                <div class="col-auto">
                                    <!--label for='canal'>Canal</label><br-->
                                    <?= getFiltros(['canal' => ['label' => 'Canal', 'name' => 'canal', 'id' => 'canal', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                                </div>
							</div>
						</form>
					</div>
					<div class="tab-pane show" id="tab-content-3" role="tabpanel">
						<form id="frm-AudVisibilidadInic">
							<div class="form-row mb-3">
								<div class="d-none">
									<input type="text" name="visibilidad" class="form-control form-control-sm" value="iniciativa">
								</div>
								<div class="col-auto">
									<input name="txt-fechas" id="txt-fechas-3" value="<?= date("d/m/Y").' - '.date("d/m/Y") ?>" type="text" class="form-control form-control-sm form-fecha">
								</div>
								<div class="col-auto">
                                    <!--label for='proyecto'>Proyecto</label><br-->
                                    <?= getFiltros(['proyecto' => ['label' => 'Proyecto', 'name' => 'proyecto', 'id' => 'proyecto_3', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                                </div>
                                <div class="col-auto">
                                    <!--label for='grupoCanal'>Grupo Canal</label><br-->
                                    <?= getFiltros(['grupoCanal' => ['label' => 'Grupo Canal', 'name' => 'grupoCanal', 'id' => 'grupoCanal_3', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                                </div>
                                <div class="col-auto">
                                    <!--label for='canal'>Canal</label><br-->
                                    <?= getFiltros(['canal' => ['label' => 'Canal', 'name' => 'canal', 'id' => 'canal_3', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                                </div>
							</div>
						</form>
					</div>
					<div class="tab-pane show" id="tab-content-4" role="tabpanel">
						<form id="frm-AudVisibilidadAdic">
							<div class="form-row mb-3">
								<div class="d-none">
									<input type="text" name="visibilidad" class="form-control form-control-sm" value="adicional">
								</div>
								<div class="col-auto">
									<input name="txt-fechas" id="txt-fechas-4" value="<?= date("d/m/Y").' - '.date("d/m/Y") ?>" type="text" class="form-control form-control-sm form-fecha">
								</div>
								<div class="col-auto">
                                    <!--label for='proyecto'>Proyecto</label><br-->
                                    <?= getFiltros(['proyecto' => ['label' => 'Proyecto', 'name' => 'proyecto', 'id' => 'proyecto_4', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                                </div>
                                <div class="col-auto">
                                    <!--label for='grupoCanal'>Grupo Canal</label><br-->
                                    <?= getFiltros(['grupoCanal' => ['label' => 'Grupo Canal', 'name' => 'grupoCanal', 'id' => 'grupoCanal_4', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                                </div>
                                <div class="col-auto">
                                    <!--label for='canal'>Canal</label><br-->
                                    <?= getFiltros(['canal' => ['label' => 'Canal', 'name' => 'canal', 'id' => 'canal_4', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                                </div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="divDetalleElementos" class="row">
	<div class="col-lg-12 col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-header">
				<i class="fas fa-list-alt fa-lg"></i>&nbspResumen Elementos de Visibilidad
			</div>
			<div class="card-body">
				<div id="idResumenElementos" class="table-responsive">
					<div class="alert alert-info" role="alert">
						<i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGUN REGISTRO.
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="divDetalleAuditVisibilidadOblig" class="row">
	<div class="col-lg-12 col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-header">
				<i class="fas fa-list-alt fa-lg"></i>&nbspResultados Auditoria Elementos Visibilidad Obligatoria
			</div>
			<div class="card-body">
				<div id="idDetalleAuditVisibilidadOblig" class="table-responsive">
					<div class="alert alert-info" role="alert">
						<i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGUN REGISTRO.
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="divDetalleAuditVisibilidadInic" class="row">
	<div class="col-lg-12 col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-header">
				<i class="fas fa-list-alt fa-lg"></i>&nbspResultados Auditoria Elementos Visibilidad Iniciativas
			</div>
			<div class="card-body">
				<div id="idDetalleAuditVisibilidadInic" class="table-responsive">
					<div class="alert alert-info" role="alert">
						<i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGUN REGISTRO.
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="divDetalleAuditVisibilidadAdic" class="row">
	<div class="col-lg-12 col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-header">
				<i class="fas fa-list-alt fa-lg"></i>&nbspResultados Auditoria Elementos Visibilidad Adicional
			</div>
			<div class="card-body">
				<div id="idDetalleAuditVisibilidadAdic" class="table-responsive">
					<div class="alert alert-info" role="alert">
						<i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGUN REGISTRO.
					</div>
				</div>
			</div>
		</div>
	</div>
</div>