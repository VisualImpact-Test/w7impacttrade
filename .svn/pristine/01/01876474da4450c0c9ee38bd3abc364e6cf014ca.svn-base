<? $verGenerarLista = ($htmlGenerarLista) ? '' : 'd-none'; ?>


<div class="row mt-4">
	<div class="col-lg-4 d-flex justify-content-center align-items-center">
		<h3 class="card-title mb-3">
			<i class="<?= $icon ?>"></i>
			<?= $title ?>
		</h3>
	</div>
	<div class="col-lg-8 d-flex">
		<div class="card w-100 mb-3 p-0">
			<div class="card-body p-0">
				<ul class="nav nav-tabs nav-justified">

					<li class="nav-item" id="nav-link-0"><a data-toggle="tab" href="#idDetalleModulacionAntigua" data-value="1" class="active nav-link">Antiguas</a></li>
					<li class="nav-item"><a data-toggle="tab" href="#idDetalleModulacionActual" data-value="2" class="nav-link">Actuales</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="customizer border-left-blue-grey border-left-lighten-4 d-none d-xl-block open">
	<a href="javascript:;" class="customizer-close"><i class="fal fa-times"></i></a>
	<a href="javascript:;" class="customizer-toggle box-shadow-3 bg-trade-visual-grad-left text-white">
		<i class="fal fa-cog fa-lg fa-spin"></i>
	</a>
	<div class="customizer-content p-3 ps-container ps-theme-dark" data-ps-id="aca1f25c-4ed9-a04b-d154-95a5d6494748">
		<form id="frm-modulacion">
			<div class="card-header" style="margin-bottom: 14px;">
				<h4>CONFIGURACIÓN</h4>
			</div>
			<div class="customizer-content-button">
				<button class="btn btn-outline-trade-visual border-0 btn-filtrarModulacion" id="btn-filtrarModulacion-antes" data-url="filtrar" title="Filtrar" data-modulacion="antigua">
					<i class="fas fa-search"></i>
				</button>

				<button class="btn btn-outline-trade-visual border-0 btn-filtrarModulacion" id="btn-filtrarModulacion-actual" data-url="filtrar" title="Filtrar" data-modulacion="actual" style="display:none;">
					<i class="fas fa-search"></i>
				</button>
				<button id="btn-generarListas" type="button" class="btn btn-outline-trade-visual border-0 <?= $verGenerarLista; ?>" data-url="generarListas" title="Generar Listas" style="display:none;">
					<i class="fas fa-share-square"></i>
				</button>
				<button id="btn-cargaMasivaAlternativa" class="btn btn-outline-trade-visual border-0" data-url="cargaMasivaAlternativa" title="Carga Masiva Alternativa" style="display:none;">
					<i class="fas fa-file-upload"></i>
				</button>
			</div>
			<hr>
			<div class="customizer-content-filter">
				<h5 class="mt-1 mb-1 text-bold-500"><i class="fal fa-table"></i> Filtros</h5>
				<div class="form-row">
					<input type="hidden" name="tipoFormato" id="tipoFormato" value="1" />
					<div class="col-md-12">
						<div class="mb-2 mr-sm-2  position-relative form-group">
							<div class="field">
								<div class="ui my_calendar">
									<div class="ui input left icon" style="width:100%">
										<i class="calendar icon"></i>
										<input type="text" name="txt-fechas" id="txt-fechas" placeholder="Date" value="<?= date("d/m/Y") . ' - ' . date("d/m/Y") ?>" class="form-control">
									</div>
								</div>
							</div>
						</div>
						<input type="hidden" id="tipoModulacion" name="tipoModulacion" class="form-control form-control-sm" value="antigua">
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="main-card mb-3 card ">
	<div class="card-body p-0">
		<div class="tab-content" id="content-auditoria">
			<div class="tab-pane fade show active" id="idDetalleModulacionAntigua" role="tabpanel">
				<?= getMensajeGestion('noResultados') ?>
			</div>
			<div id="idDetalleClienteAntigua" style="display:none;">
				<?= getMensajeGestion('noResultados') ?>
			</div>

			<div class="tab-pane fade" id="idDetalleModulacionActual" role="tabpanel">
				<?= getMensajeGestion('noResultados')  ?>
			</div>
			<div id="idDetalleClienteActual" style="display:none;">
				<?= getMensajeGestion('noResultados') ?>
			</div>
		</div>
	</div>
</div>