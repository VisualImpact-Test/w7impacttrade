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
					<li class="nav-item " id="nav-link-0"><a data-toggle="tab" href="#tab-content-0" class="active nav-link" data-value="1"> Rutas</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="customizer border-left-blue-grey border-left-lighten-4 d-none d-xl-block ">
	<a href="javascript:;" class="customizer-close"><i class="fal fa-times"></i></a>
	<a href="javascript:;" class="customizer-toggle box-shadow-3 bg-trade-visual-grad-left text-white">
		<i class="fal fa-cog  fa-spin"></i>
	</a>
	<div class="customizer-content p-2 ps-container ps-theme-dark" data-ps-id="aca1f25c-4ed9-a04b-d154-95a5d6494748">
		<form id="frm-modulacion">
			<div class="card-header" style="margin-bottom: 14px;">
				<h4>CONFIGURACIÓN</h4>
			</div>
			<div class="customizer-content-button">
				<button id="btn-filtrarModulacion" class="btn btn-outline-trade-visual btn-Consultar border-0" data-url="filtrar" title="Filtrar">
					<i class="fa fa-search"></i>
				</button>
				<!-- 
					DEPRECATED
					<button id="btn-cargaMasivaRutas" class="btn btn-outline-trade-visual border-0" title="Carga Masiva">
					<i class="fas fa-upload"></i>
					</button> 
				-->
				<button class="btn btn-outline-trade-visual border-0 btn-CargaMasiva" title="Carga Masiva"><i class="fas fa-folder-plus"></i></button>
				<button id="btn-clonarRutas" class="btn btn-outline-trade-visual border-0" title="Clonar Ruta">
					<i class="fas fa-copy"></i>
				</button>
				<button id="btn-descargar" class="btn btn-outline-trade-visual border-0" title="Descargar Base">
					<i class="fas fa-download"></i>
				</button>
				<button id="btn-generarRutasManual" class="btn btn-outline-trade-visual border-0" title="Generar Ruta/Visita">
					<i class="fas fa-sync-alt"></i>
				</button>
				<button id="btn-cargaMasivaAlternativa" class="btn btn-outline-trade-visual border-0" title="Carga Masiva Alternativa">
					<i class="fas fa-file-upload"></i>
				</button>
				<?if($this->sessIdProyecto == PROYECTO_MODERNO_PG):?>
					<a href="../configuraciones/gestion/horario" target="_blank" id="btn-gestorHorarios" class="btn btn-outline-trade-visual border-0" title="Gestionar horarios">
						<i class="fas fa-calendar-alt"></i>
					</a>
				<?endif;?>
			</div>

			<div class="customizer-content-filter">
				<h5 class="mt-1 mb-1 text-bold-500"><i class="fal fa-table"></i> Filtros</h5>
				<div class="form-row">

					<div class="col-md-12">
						<div class="mb-2 mr-sm-2  position-relative form-group">
							<div class="field">
								<div class="ui my_calendar">
									<div class="ui input left icon" style="width:100%">
										<i class="calendar icon"></i>
										<input type="text" name="fechas" id="fechas" placeholder="Date" value="<?= date("d/m/Y") . ' - ' . date("d/m/Y") ?>" class="form-control rango_fechas">
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

<div class="main-card mb-3 card ">
	<div class="card-body p-0">
		<div class="tab-content" id="content-live-rutas">
			<div class="tab-pane fade show active" id="idDetalleModulacion" role="tabpanel">
				<?= getMensajeGestion('noResultados') ?>
			</div>
		</div>
	</div>
</div>