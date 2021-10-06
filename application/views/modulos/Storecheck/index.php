<style>
	.color-C { color: #5cb85c; }
	.color-I { color: #f6ea67; }
	.color-F { color: #d9534f; }
	.color-O { color: #6063d7; }
	.color-V { color: #95cbe7; }
	.color-Fe { color: #666; }

	.page-item{
		/*border: 5px solid red;*/
	}

	.page-item div.item-li{
		position: relative;
		display: block;
		padding: .5rem .75rem;
		margin-left: -1px;
		line-height: 1.25;
		background-color: #fff;
		border: 1px solid #dee2e6;
		min-height: inherit;
	}
	.textCondicion{
		height: 35px;
	}
</style>
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
</style>
<div class="row">
    <div class="col-12">

        <div class="mb-3 card">

            <div class="card-header-tab card-header">
                <ul class="nav nav-pills">
                    <li class="nav-item active"><a data-toggle="tab" href="#tab-content-0" class="active nav-link">Principal</a></li>
                </ul>
                <div class="funciones">
                    <a href="javascript:void(0);" class="btn btn-consultar btn-outline-primary border-0" title="Filtrar"><i class="fa fa-filter"></i></a>
                    <button type="button" data-toggle="collapse" href="#collapseBodyBasemadre" class="btn btn-outline-primary border-0 btnCollapse" title="Desplegar filtros" aria-expanded="true"><i class="fas fa-lg fa-caret-down"></i></button>
                </div>
            </div>

            <div class="card-body mostrarocultar collapse" id="collapseBodyBasemadre">
                <div class="tab-content">

                    <form id="formFiltroStorecheck">
                        <div class="form-row mb-3">

                            <div class='col-auto'>
                                <!-- <label for='idMes'>Mes</label><br> -->
                                <select id='idMes' name='idMes' class='form-control form-control-sm my_select2Full'>
                                    <option value="">-- Mes --</option>
                                    <option value="01">Enero</option>
                                    <option value="02">Febrero</option>
                                    <option value="03">Marzo</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Mayo</option>
                                    <option value="06">Junio</option>
                                    <option value="07">Julio</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Setiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                            </div>

                            <div class='col-auto'>
                                <!-- <label for='idAnio'>Mes</label><br> -->
                                <?$anioProyecto = 2020;
                                $anioActual = (int) date("Y");
                                 ?>
                                <select class="form-control form-control-sm my_select2" id="idAnio" name="idAnio">
                                    <option value="">-- Año --</option>
                                    <option value="<?= $anioActual ?>"><?= $anioActual ?></option>
                                    <?php
                                    while ($anioActual != $anioProyecto) {
                                        $anioActual--; ?>
                                        <option value="<?= $anioActual ?>"><?= $anioActual ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-auto">
                                <!-- <label for='cuenta'>Cuenta</label><br> -->
                                <?= getFiltros(['cuenta' => ['label' => 'Cuenta', 'name' => 'cuenta', 'id' => 'cuenta', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                            </div>
                            <div class="col-auto">
                                <!-- <label for='proyecto'>Proyecto</label><br> -->
                                <?= getFiltros(['proyecto' => ['label' => 'Proyecto', 'name' => 'proyecto', 'id' => 'proyecto', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                            </div>
                            <div class="col-auto">
                                <!-- <label for='grupoCanal'>Grupo Canal</label><br> -->
                                <?= getFiltros(['grupoCanal' => ['label' => 'Grupo Canal', 'name' => 'grupoCanal', 'id' => 'grupoCanal', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                            </div>
                            <div class="col-auto">
                                <!-- <label for='canal'>Canal</label><br> -->
                                <?= getFiltros(['canal' => ['label' => 'Canal', 'name' => 'canal', 'id' => 'canal', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                            </div>
                            <div class="col-auto">
                                <!-- <label for='cadena'>Cadena</label><br> -->
                                <?= getFiltros(['cadena' => ['label' => 'Cadena', 'name' => 'cadena', 'id' => 'cadena', 'data' => true, 'select2' => 'my_select2Full', 'html' => '']]) ?>
                            </div>
                        </div>

                        <div class="form-row mb-3">
                            <div class='col-auto'>
                                <!-- <label for='idPuntoDeVenta'>Acción</label><br> -->
                                <button type="submit" class="btn-getPuntosDeVenta btn btn-primary m-lg-0">Obtener puntos de venta</button>
                            </div>

                            <div class='col-auto'>
                                <!-- <label for='idPuntoDeVenta'>Punto de Venta</label><br> -->
                                <select id='idPuntoDeVenta' name='idPuntoDeVenta' class='form-control form-control-sm my_select2Full'>
                                    <option value="">-- Punto de Venta --</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>

<div class="row tipoDetallado" id="contentStorecheck">
	<div class="col-lg-12">
		<div class="main-card mb-3 card">
			<div class="card-header bg-purple-gradient text-white">
				<i class="fas fa-list-alt fa-lg"></i>&nbspDETALLE
			</div>
			<div class="card-body">
				<div class="alert alert-info" role="alert">
					<i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGÚN RESULTADO.
				</div>
			</div>
		</div>
	</div>
</div>