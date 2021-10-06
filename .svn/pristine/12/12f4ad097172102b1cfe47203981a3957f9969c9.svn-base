<? $verClientesActivar = ($htmlClienteActivar) ? '' : 'd-none'; ?>
<? $verTransferirAgregados = ($htmlTranferirAgregados) ? '' : 'd-none'; ?>
<div class="row mt-4">
	<div class="col-lg-2 d-flex justify-content-center align-items-center">
		<h3 class="card-title mb-3">
			<i class="<?= $icon ?>"></i>
			<?= $title ?>
		</h3>
	</div>
	<div class="col-lg-10 d-flex">
		<div class="card w-100 mb-3 p-0">
			<div class="card-body p-0">
				<ul class="nav nav-tabs nav-justified">
					<li class="nav-item " id="nav-link-0"><a data-toggle="tab" href="#tab-content-0" class="active nav-link" data-value="1"> Clientes Basemadre</a></li>
					<li class="nav-item "><a data-toggle="tab" id="nav-link-1" href="#tab-content-1" class="nav-link" data-value="2"> Solicitudes de Registro</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="customizer border-left-blue-grey border-left-lighten-4 d-none d-xl-block ">
	<a href="javascript:;" class="customizer-close"><i class="fal fa-times"></i></a>
	<a href="javascript:;" class="customizer-toggle box-shadow-3 bg-trade-visual-grad-left text-white">
		<i class="fal fa-cog fa-lg fa-spin"></i>
	</a>
	<div class="customizer-content p-2 ps-container ps-theme-dark" data-ps-id="aca1f25c-4ed9-a04b-d154-95a5d6494748">
		<form id="frm-maestrosBasemadre">
			<div class="card-header" style="margin-bottom: 14px;">
				<h4>CONFIGURACIÓN</h4>
			</div>
			<div class="customizer-content-button">

				<input type="hidden" name="tipoGestor" id="tipoGestor" value="1">
				<button id="btn-filtrarMaestrosBasemadre" class="btn btn-outline-trade-visual border-0" data-url="filtrar" title="Filtrar">
					<i class="fas fa-search"></i>
				</button>

				<button id="btn-deBajaMaestrosBasemadre" class="btn btn-outline-trade-visual border-0 <?= $verClientesActivar; ?>" data-url="deBaja" title="De Baja Basemadre">
					<i class="fas fa-times-circle"></i>
				</button>
				<button id="btn-cargaMasivaHistorico" class="btn btn-outline-trade-visual border-0" data-url="cargaMasivaHistorico" title="Carga Masiva Actualizar Historico">
					<i class="fas fa-plus-square"></i>
				</button>
				<button id="btn-cargaMasivaAlternativa" class="btn btn-outline-trade-visual border-0" title="Carga Masiva Alternativa">
					<i class="fas fa-file-upload"></i>
				</button>
				<button id="btn-verDeBajaMaestrosBasemadre" class="btn btn-outline-trade-visual border-0 <?= $verClientesActivar; ?>" data-url="verDeBaja" title="Ver De Baja Basemadre">
					<i class="fas fa-eye-slash"></i>
				</button>
				<button id="btn-activarMaestrosBasemadre" class="btn btn-outline-trade-visual border-0 <?= $verClientesActivar; ?>" data-url="activar" title="Activar Basemadre">
					<i class="fas fa-hand-point-up"></i>
				</button>

				<button id="btn-filtrarMaestrosClientesAgregados" class="btn btn-outline-trade-visual border-0" data-url="filtrarAgregados" title="Listar Solicitudes Registro" style="display:none;">
					<i class="fas fa-user-clock"></i>
				</button>
				<button id="btn-nuevoMaestrosBasemadre" class="btn btn-outline-trade-visual border-0" data-url="" title="Nuevo Histórico" style="display:none;">
					<i class="fas fa-file-alt"></i>
				</button>
				<button id="btn-cargaMasivaMaestrosBasemadre" class="btn btn-outline-trade-visual border-0" data-url="nuevoPuntoMasivo" title="Carga Masiva" style="display:none;">
					<i class="fas fa-plus-square"></i>
				</button>
				<button id="btn-deBajaMaestrosAgregados" class="btn btn-outline-trade-visual border-0 <?= $verTransferirAgregados; ?>" data-url="deBaja" title="De Baja Agregados" style="display:none;">
					<i class="fas fa-times-circle"></i>
				</button>
				<button id="btn-rechazarClientesAgregados" class="btn btn-outline-trade-visual border-0 <?= $verTransferirAgregados; ?>" data-url="rechazarAgregados" title="Rechazar Solicitudes" style="display:none;">
					<i class="fas fa-thumbs-down"></i>
				</button>
				<button id="btn-transferirClientesAgregados" class="btn btn-outline-trade-visual border-0 <?= $verTransferirAgregados; ?>" data-url="" title="Transferir Agregados" style="display:none;">
					<i class="fas fa-random"></i>
				</button>

				<button id="btn-cargaMasivaAlternativaClienteProyecto" class="btn btn-outline-trade-visual border-0" title="Carga Masiva Cliente Proyecto">
					<i class="fas fa-file-import"></i>
				</button>
			</div>
			<hr>
			<div class="customizer-content-filter">
				<h5 class="mt-1 mb-1 text-bold-500"><i class="fal fa-table"></i> Filtros</h5>
				<div class="form-row">

					<div class="col-md-12">
						<div class="mb-2 mr-sm-2  position-relative form-group">
							<div class="field">
								<div class="ui my_calendar">
									<div class="ui input left icon" style="width:100%">
										<i class="calendar icon"></i>
										<input type="text" name="txt-fechas" id="txt-fechas-2" placeholder="Date" value="<?= date("d/m/Y") . ' - ' . date("d/m/Y") ?>" class="form-control">
									</div>
								</div>
							</div>
						</div>

						<div id="filter-content-0">
							<div class="mb-2 mr-sm-2  position-relative form-group ">
								<?= getFiltros(['cuenta' => ['select2' => 'my_select2Full']]); ?>
							</div>
							<div class="mb-2 mr-sm-2  position-relative form-group ">
								<?= getFiltros(['proyecto' => ['select2' => 'my_select2Full']]); ?>
							</div>

							<div class="mb-2 mr-sm-2  position-relative form-group ">
								<?= getFiltros(['grupoCanal' => ['label' => 'Grupo Canal', 'name' => 'grupoCanal_filtro', 'id' => 'grupoCanal_filtro', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
							</div>
							<div class="mb-2 mr-sm-2  position-relative form-group ">
								<?= getFiltros(['canal' => ['label' => 'Canal', 'name' => 'canal_filtro', 'id' => 'canal_filtro', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
							</div>
						</div>

						<div class="mb-2 mr-sm-2 position-relative form-group" id="filter-content-1" style="display:none;">
							<select id="slSolicitud" name="slSolicitud" class="ui my_select2Full" style="width:100%" title="Estado Transferencia">
								<option value="">-- Usuario --</option>
								<? foreach ($listaSolicictud as $klr => $row) : ?>
									<option value="<?= $row['idSolicitudTipo'] ?>"><?= $row['solicitudTipo'] ?></option>
								<? endforeach ?>
							</select>
						</div>

						<div class="mb-2 mr-sm-2  position-relative form-group ">
							<textarea class="form-control slWidth" name="txt-nombres" id="txt-nombres" style="resize:none;" placeholder="Ingrese los clientes separados por salto de linea"></textarea>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="main-card mb-3 card ">
	<div class="card-body p-0">
		<div class="tab-content" id="content-live-storecheckconf">
			<div class="tab-pane fade show active" id="tab-content-0" role="tabpanel">
				<?= getMensajeGestion('noResultados') ?>
			</div>
			<div class="tab-pane fade " id="tab-content-1" role="tabpanel">
				<?= getMensajeGestion('noResultados') ?>
			</div>
		</div>
	</div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcH2xfbm8z-5iSE4knkRJiNKRhKQrhH6E&callback=initMap"></script>