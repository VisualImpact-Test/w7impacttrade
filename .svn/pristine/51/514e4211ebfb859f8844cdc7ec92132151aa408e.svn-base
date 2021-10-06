<style>
body { position: relative; }
#ZoomBox { position: absolute; top: 50%; left: 50%; transform: translate(-0%, -0%); }
.contenedor_hora { font-size: 10px !important; }

.bg-warning-gradient { background: linear-gradient(90deg, #ffc107, #e52e71); }
.bg-primary-gradient { background: linear-gradient(90deg, #007bff, #e52e71) }
.bg-purple-gradient { background: linear-gradient(90deg, #5011ad , #e52e71); }
.card-header>.nav>li.active {
    border-bottom: none !important;
}

.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: #fff !important;
    background: linear-gradient(90deg, #5011ad , #e52e71) !important;
}

button.btn.btn-xs.btn-primary.buttons-collection.buttons-page-length {
    background: linear-gradient(90deg, #007bff, #e52e71) !important;
	border: none;
}

button.btn.btn-xs.btn-primary.buttons-excel.buttons-html5 {
    background: linear-gradient(90deg, #ffc107, #e52e71) !important;
	border: none;
}
.inner > .dropdown-menu{
	display:block;
}

.selected > .dropdown-item{
    color: #fff;
    text-decoration: none;
    background-color: #007bff;
}

.bs-searchbox {
	display:none;
}

</style>
<div class="row">
	<div class="col-lg-12">
		<div class="main-card mb-3 card">
			<form id="frm-iniciativas">
				<div class="card-header-tab card-header">

					<!--div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
						<div role="group" class="btn-group btn-group-toggle" data-toggle="buttons">
							<label class="btn btn-info btnReporte active">
								<input type="radio" name="tipoReporte" id="tipoReporte1" autocomplete="off" value="1" checked>DETALLADO
							</label>
							<label class="btn btn-info btnReporte">
								<input type="radio" name="tipoReporte" id="tipoReporte2" autocomplete="off" value="2">CONSOLIDADO
							</label>
						</div>
					</div-->
					<input type="hidden" name="tipoReporte" id="tipoReporte" value="1">
					<ul class="nav nav-pills">
						<li class="nav-item active"><a data-toggle="tab" href="#tab-content-0" data-value="1"  class="btnReporte active nav-link" name="tipoReporte">Detallado</a></li>
						<li class="nav-item"><a data-toggle="tab" href="#tab-content-1" data-value="2"  class="btnReporte nav-link" name="tipoReporte">Consolidado</a></li>
					</ul>

					<!--div class="ml-auto collapse-link-header">
						<button id="btn-filtrarIniciativas" class="btn-wide btn btn-primary" data-url="filtrar"><i class="fas fa-filter"></i></button>
						<button type="button" data-toggle="collapse" href="#collapseBodyIniciaitiva" class="btn btn-primary "><i class="fas fa-caret-up fa-lg"></i></button>
					</div-->
					<div class="d-none d-lg-block funciones">
						<button class="btn btn-outline-primary border-0" data-url="filtrar" id="btn-filtrarIniciativas" title="Filtrar"><i class="fa fa-filter"></i></button>
						<button class="btn btn-outline-primary border-0" data-url="pdf" id="btn-iniciativas-pdf" title="Pdf"><i class="fa fa-file-pdf-o"></i></button>
						<button type="button" data-toggle="collapse" href="#collapse-search" class="btn btn-outline-primary border-0 btnCollapse" title="Desplegar filtros"><i class="fas fa-caret-down fa-lg"></i></button>
					</div>
				</div>
				<div id="collapse-search" class="collapse card-body">
					<div class="tab-content">
						<div class="row">
							<div id="idDivForm" class="col-md-2">
								<div class="form-inline">

									<div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
										<!-- <label for="txt-fechas" class="mr-sm-2">Rango de fechas </label> -->
										<input name="txt-fechas" id="txt-fechas" value="<?= date("d/m/Y").' - '.date("d/m/Y") ?>" type="text" class="form-control form-control-sm form-fecha">
									</div>
								</div>
							</div>
							<div id="idDivForm" class="col-md-10">
								<div class="form-inline">
									<div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group filtros_visitas">
										<!-- <label for='proyecto_filtro'>Proyecto</label><br> -->
										<?= getFiltros(['proyecto' => ['label' => 'Proyecto', 'name' => 'proyecto_filtro', 'id' => 'proyecto_filtro', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
									</div>
									<div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group filtros_visitas" >
										<!-- <label for='grupoCanal_filtro'>Grupo Canal</label><br> -->
										<?= getFiltros(['grupoCanal' => ['label' => 'Grupo Canal', 'name' => 'grupoCanal_filtro', 'id' => 'grupoCanal_filtro', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
									</div>
									<div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group filtros_visitas">
										<!-- <label for='canal_filtro'>Canal</label><br> -->
										<?= getFiltros(['canal' => ['label' => 'Canal', 'name' => 'canal_filtro', 'id' => 'canal_filtro', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
									</div>

									<div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group filtros_visitas">
										<div class="form-group">
											<select class="selectpicker" id="idDistribuidora" name="idDistribuidora" title="Distribuidora (Todo)" data-live-search="true" multiple data-actions-box="true" >
												<?php
													foreach($distribuidoras as $row){
														?>
															<option class="dropdown-item" value="<?=$row['idDistribuidora']?>" ><?=$row['nombre']?></option>
														<?
													}
												?>
											</select>
										</div>
									</div>

									<div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group filtros_visitas">
										<div class="form-group">
											<select id="idCliente" name="idCliente" title="Clientes (Todo)" data-live-search="true" data-actions-box="true" >
											<option class="dropdown-item" value="" >--Cliente--</option>
												<?php
													foreach($clientes as $row){
														?>
															<option class="dropdown-item" value="<?=$row['idCliente']?>" ><?=$row['razonSocial']?></option>
														<?
													}
												?>
											</select>
										</div>
									</div>

									<div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group filtros_visitas">
										<div class="form-group">
										<select class="selectpicker" id="idElemento" name="idElemento" title="Elementos (Todo)" data-live-search="true" multiple data-actions-box="true" >
												<?php
													foreach($elementos as $row){
														?>
															<option class="dropdown-item" value="<?=$row['idElementoVis']?>" ><?=$row['nombre']?></option>
														<?
													}
												?>
											</select>
										</div>
									</div>

									
									<div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group dvConsolidado">
										<div role="group" class="btn-group btn-group-toggle" data-toggle="buttons">
											<label class="btn btn-info btnReporte active">
												<input type="radio" name="tipoConsolidado" id="tipoConsolidado1" autocomplete="off" value="1" checked>COBERTURA
											</label>
											<label class="btn btn-info btnReporte">
												<input type="radio" name="tipoConsolidado" id="tipoConsolidado2" autocomplete="off" value="2">IMPLEMENTACIÓN
											</label>
										</div>
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

<div class="dvDetallado">
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="main-card mb-3 card">
				<div class="card-header bg-purple-gradient text-white">
					<i class="fas fa-list-alt fa-lg"></i>&nbspRESULTADOS DETALLADO
				</div>
				<div class="card-body">
					<div id="idDetalleDetallado" class="table-responsive">
						<div class="alert alert-info" role="alert">
							<i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGUN RESULTADO.
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="dvConsolidado">
	<div class="row dvCobertura">
		<div class="col-lg-12 col-md-12">
			<div class="main-card mb-3 card">
				<div class="card-header bg-purple-gradient text-white">
					<i class="fas fa-list-alt fa-lg"></i>&nbspResultados CONSOLIDADO COBERTURA
				</div>
				<div class="card-body">
					<div id="idDetalleConsolidadoCobertura" class="table-responsive">
						<div class="alert alert-info" role="alert">
							<i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGUN RESULTADO.
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="dvConsolidado">
	<div class="row dvImplementacion">
		<div class="col-lg-12 col-md-12">
			<div class="main-card mb-3 card">
				<div class="card-header bg-purple-gradient text-white">
					<i class="fas fa-list-alt fa-lg"></i>&nbspResultados CONSOLIDADO IMPLEMENTACIÓN
				</div>
				<div class="card-body">
					<div id="idDetalleConsolidadoImplementacion" class="table-responsive">
						<div class="alert alert-info" role="alert">
							<i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGUN RESULTADO.
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
