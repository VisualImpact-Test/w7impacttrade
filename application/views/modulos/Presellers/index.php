<div class="row">
    <div class="col-12">

        <div class="mb-3 card">

            <div class="card-header-tab card-header">
                <!-- <ul class="nav">
                    <li class="nav-item"><a data-toggle="tab" href="#tab-content-0" class="active nav-link">Principal</a></li>
                </ul>
                <div class="funciones">
                    <a href="javascript:void(0);" class="btn btn-consultar btn-outline-primary border-0" title="Consultar"><i class="fa fa-search"></i></a>
                    <button type="button" data-toggle="collapse" href="#collapseBodyBasemadre" class="btn btn-outline-primary border-0" title="Minimizar/Maximizar" aria-expanded="true"><i class="fas fa-lg fa-caret-up"></i></button>
                </div> -->

                <input type="hidden" id="idReporte" name="reporte" value="1">
                <ul class="nav" >
                    <li class="nav-item active"><a data-toggle="tab" href="#tab-content-0" data-value="1"  class="btnReporte active nav-link">Detalle Ventas</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#tab-content-1" data-value="2"  class="btnReporte nav-link">Detalle Pre Ventas</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#tab-content-2" data-value="3"  class="btnReporte nav-link">ADPP</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#tab-content-3" data-value="4"  class="btnReporte nav-link">Cobranzas</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#tab-content-4" data-value="5"  class="btnReporte nav-link">Lomito</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#tab-content-5" data-value="6"  class="btnReporte nav-link">Avance Ventas</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#tab-content-6" data-value="7"  class="btnReporte nav-link">Summary</a></li> 
                </ul>
                
                <div class="d-none d-lg-block funciones">
                    <a href="javascript:void(0);" class="btn btn-consultar btn-outline-primary border-0" title="Consultar"><i class="fa fa-search"></i></a>
                    <button type="button" data-toggle="collapse" href="#collapseBodyBasemadre" class="btn btn-outline-primary border-0" title="Minimizar/Maximizar" aria-expanded="true"><i class="fas fa-lg fa-caret-down"></i></button>
                </div>

                <div class="d-md-none mb-0 mr-0 dropleft btn-group">
					<button class="btn-wide btn btn-sm btn-primary">Opciones</button>
					<button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle-split dropdown-toggle btn btn-primary"><span class="sr-only">Toggle Dropdown</span></button>
					<div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu">
						<button class="dropdown-item btn btn-outline-primary border-0 btn-consultar" data-url="filtrar"  ><i class="fa fa-search"></i> Buscar</button>
						<button type="button" data-toggle="collapse" href="#collapse-search" class="dropdown-item btn btn-outline-primary border-0"><i class="fas fa-caret-up fa-lg"></i> Minimizar</button>
					</div>
				</div>

            </div>

            <div class="card-body collapse" id="collapseBodyBasemadre">
                <div class="tab-content">
                    <form id="formFiltroPresellers">
                        <div class="form-inline">
                            <!--
                            <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
								<div role="group" class="btn-group btn-group-toggle" data-toggle="buttons">
									<label class="btn btn-info btnCanal active">
										<input type="radio" name="reporte" id="detalle_ventas" autocomplete="off" value="1" data-url ="ventas" checked>Detalle Ventas
									</label>
									<label class="btn btn-info btnCanal">
										<input type="radio" name="reporte" id="detalle_preventas" autocomplete="off" value="2" data-url="preventas" >Detalle Pre Ventas
									</label>
									<label class="btn btn-info btnCanal">
										<input type="radio" name="reporte" id="adpp" autocomplete="off" value="3" data-url="adpp" >ADPP
									</label>
									<label class="btn btn-info btnCanal">
										<input type="radio" name="reporte" id="cobranzas" autocomplete="off" value="4" data-url="cobranzas" >Cobranzas
									</label>
									<label class="btn btn-info btnCanal">
										<input type="radio" name="reporte" id="lomito" autocomplete="off" value="5" data-url="lomito" >Lomito
									</label>
									<label class="btn btn-info btnCanal">
										<input type="radio" name="reporte" id="avance_ventas" autocomplete="off" value="6" data-url="avance" >Avance Ventas
									</label>
									<label class="btn btn-info btnCanal">
										<input type="radio" name="reporte" id="summary" autocomplete="off" value="7" data-url="summary" >Summary
									</label>
								</div>
							</div>
							-->
							<div class="mb-2 mr-sm-2 mb-sm-0 form-group">
                                <!-- <label for="fechas" class="mr-sm-2">Rango de fecha</label> -->
                                <input name="fechas" id="fechas" value="<?=date("d/m/Y");?>" type="text" class="form-control form-control-sm text-center rango_fechas form-fecha">
                            </div>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
        <div class="row" id="contentPresellers" >
	<div class="col-lg-12">
		<div class="main-card mb-3 card">
			<div class="card-header">
				<i class="fas fa-list-alt fa-lg"></i>&nbspDetalle
			</div>
			<div class="card-body" id="idContentRutas">
				<div class="alert alert-info" role="alert">
					<i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGÚN RESULTADO.
				</div>
			</div>
		</div>
	</div>
</div>

    </div>

</div>
<script type="text/javascript" src="assets/libs/anychart/anychart-base.min.js"></script>
<script type="text/javascript" src="assets/libs/anychart/anychart-ui.min.js"></script>
<script type="text/javascript" src="assets/libs/anychart/anychart-map.min.js"></script>
<script type="text/javascript" src="assets/libs/anychart/countries/peru.js"></script>