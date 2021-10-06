<div class="row">
	<div class="col-lg-12">
		<div class="main-card mb-3 card">
			<form id="frm-modulacion">
				<div class="card-header">
					<i class="<?=$icon;?>"></i>&nbsp<?=$title;?>
					<div class="ml-auto collapse-link-header">
						<button id="btn-filtrarModulacion" class="btn btn-outline-primary border-0" data-url="filtrar" title="Filtrar"><i class="fas fa-filter"></i></button>
						<button id="btn-nuevoModulacion" class="btn btn-outline-primary border-0" data-url="nuevo" title="Nuevo"><i class="fas fa-plus-square"></i></button>
						<button type="button" data-toggle="collapse" href="#collapseBodyAsistencia" class="btn btn-outline-primary border-0 btnCollapse"><i class="fas fa-caret-down fa-lg"></i></button>
					</div>
				</div>
				<div id="collapseBodyAsistencia" class="collapse card-body">
					<div class="tab-content">
						<div class="row">
							<div id="idDivForm" class="col-lg-12">
								<div class="form-inline">
									<div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
										<input name="fechas" id="fechas" value="<?=date("d/m/Y");?>" type="text" class="form-control form-control-sm text-center rango_fechas">
									</div>
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="tipoDetallado">
	<div class="row">
		<div class="col-lg-12">
			<div class="main-card mb-3 card">
				<div class="card-header">
					<i class="fas fa-list-alt fa-lg"></i>&nbspResultados
				</div>
				<div class="card-body">
					<div id="idDetalleModulacion" class="table-responsive">
						<div class="alert alert-info" role="alert">
							<i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGUN REGISTRO.
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>