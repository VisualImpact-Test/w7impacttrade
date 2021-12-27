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
				<ul class="nav nav-tabs nav-underline nav-justified">
					<li class="nav-item">
						<a class="nav-link active btnSeguimiento" data-toggle="tab" href="#tab-content-0" data-value="1">Seguimiento</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="customizer border-left-blue-grey border-left-lighten-4 d-none d-xl-block">
	<a href="javascript:;" class="customizer-close"><i class="fal fa-times"></i></a>
	<a href="javascript:;" class="customizer-toggle box-shadow-3 bg-trade-visual-grad-left text-white">
		<i class="fal fa-cog fa-lg fa-spin"></i>
	</a>
	<div class="customizer-content p-2 ps-container ps-theme-dark">
		<form id="frm-tracking">
			<h4>CONFIGURACIÓN</h4>
			<hr>
			<div class="customizer-content-button">
				<button type="button" class="btn btn-outline-trade-visual border-0" data-url="filtrar" id="btn-tracking" title="Consultar">
					<i class="fa fa-search"></i> <span class="txt_filtro"></span>
				</button>
			</div>
			<hr>
			<div class="customizer-content-filter">
				<h5 class="mt-1 mb-1 text-bold-500"><i class="fal fa-table"></i> Filtros</h5>
				<div class="form-row">
					<input type="hidden" name="tipoFormato" id="idTipoFormato" value="1" />
					<div class="col-md-12">
						<div class="mb-2 mr-sm-2  position-relative form-group">
							<div class="field">
								<div class="ui my_calendar">
									<div class="ui input left icon" style="width:100%">
										<i class="calendar icon"></i>
										<input type="text" class="form-control" id="txt-fechas_simple" name="txt-fechas_simple" value="<?= date("d/m/Y") ?>" placeholder="Date">
									</div>
								</div>
							</div>
						</div>
						
						<div class="mb-2 mr-sm-2  position-relative form-group filtros_asistencia custom_tooltip">
							<span class="tooltiptext">Tipo Usuario</span>
							<?= getFiltros(['tipoUsuario' => ['label' => 'Tipo Usuario', 'name' => 'tipoUsuario_filtro', 'id' => 'tipoUsuario_filtro', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '','selected'=>$tipoUsuarioRuta]]) ?>
						</div>
						<div class="mb-2 mr-sm-2  position-relative form-group filtros_asistencia custom_tooltip">
							<span class="tooltiptext">Usuario</span>
							<?= getFiltros(['usuario' => ['label' => 'Usuarios', 'name' => 'usuario_filtro_tipo', 'id' => 'usuario_filtro_tipo', 'data' => true, 'select2' => 'ui my_select2Full', 'html' => '','selected'=>$usuarioRuta]]) ?>
						</div>
						
					</div>
				</div>

				<div id="dv-leyenda">
					<hr>
					<h5 class="mt-1 text-bold-500"><i class="far fa-info-circle"></i> Leyenda</h5>
					<div class="form-group">
						<div class="clearfix py-1 px-1">
							<img src="assets\images\maps\tienda_7.png" alt="10" class="float-left pr-1" height="30">
							<p>Visita en curso.</p>
						</div>
						<div class="clearfix py-1 px-1">
							<img src="assets\images\maps\tienda_5.png" alt="10" class="float-left pr-1" height="30">
							<p>Visitada(primer visita).</p>
						</div>
						<div class="clearfix py-1 px-1">
							<img src="assets\images\maps\tienda_2.png" alt="10" class="float-left pr-1" height="30">
							<p >Incidencia.</p>
						</div>
						<div class="clearfix py-1 px-1">
							<img src="assets\images\maps\tienda_3.png" alt="10" class="float-left pr-1" height="30">
							<p>Visitada.</p>
						</div>
						<div class="clearfix py-1 px-1">
							<img src="assets\images\maps\tienda_1.png" alt="10" class="float-left pr-1" height="30">
							<p >Sin visitar.</p>
						</div>
						<div class="clearfix py-1 px-1">
							<img src="assets\images\maps\tienda_4.png" alt="10" class="float-left pr-1" height="30">
							<p>Visitada(última visita).</p>
						</div>
						<div class="clearfix py-1 px-1">
							<img src="assets\images\maps\tienda_6.png" alt="10" class="float-left pr-1" height="30">
							<p>GPS fuera de los 100m. </p>
						</div>
					</div>
					<!-- <div class="form-group">
						<div class="custom-control custom-checkbox mb-1">
							<input type="checkbox" class="custom-control-input" id="ckb-todos" name="ckb-todos" checked="">
							<label class="custom-control-label" for="ckb-todos"><span class="color-N"><i class="fa fa-circle"></i></span> Todo </label>
						</div>
						<div class="custom-control custom-checkbox mb-1">
							<input type="checkbox" class="custom-control-input filtroCondicion" id="ck-sinvisitar" name="ck-sinvisitar" value="PV" checked>
							<label class="custom-control-label" for="ck-sinvisitar"><span class="color-F"><i class="fa fa-circle"></i></span> Por Visitar </label>
						</div>
						<div class="custom-control custom-checkbox mb-1">
							<input type="checkbox" class="custom-control-input filtroCondicion" id="ck-visitado" name="ck-visitado" value="V" checked>
							<label class="custom-control-label" for="ck-visitado"><span class="color-C"><i class="fa fa-circle"></i></span> Visitado </label>
						</div>
						<div class="custom-control custom-checkbox mb-1">
							<input type="checkbox" class="custom-control-input filtroCondicion" id="ck-incidencia" name="ck-incidencia" value="IN" checked>
							<label class="custom-control-label" for="ck-incidencia"><span class="color-I"><i class="fa fa-circle"></i></span> Incidencia </label>
						</div>
					</div> -->
				</div>
			</div>
		</form>
	</div>
</div>

<div class="row tipoDetallado">
	<div class="col-lg-12">
		<div class="main-card mb-3 card">
			<div class="card-body p-0" id="idContentTracking">
				<?= getMensajeGestion('noResultados') ?>
			</div>
		</div>
	</div>
</div>



<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcH2xfbm8z-5iSE4knkRJiNKRhKQrhH6E&callback=initMap"></script>
<script type="text/javascript" src="assets/libs/anychart/anychart-base.min.js"></script>
<script type="text/javascript" src="assets/libs/anychart/anychart-ui.min.js"></script>
<script type="text/javascript" src="assets/libs/anychart/anychart-map.min.js"></script>
<script type="text/javascript" src="assets/libs/anychart/countries/peru.js"></script>