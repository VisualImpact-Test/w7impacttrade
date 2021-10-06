<div class="row themeWhite">
	<div class="col-md-12">
		<div class="mb-3 mt-3 card">
			<div class="card-header">
				CARGA MASIVA DE CLIENTES
				<? $btnDistSucursal = ($tipoSegmentacion==2 ? 'hide' : '');?>
				<div class="ml-auto <?=$btnDistSucursal;?>">
					<button id="btn-addColumnaCargaMasiva" class="btn-wide btn btn-primary"><i class="fas fa-plus-square"></i> Añadir Distribuidora Sucursal</button>
				</div>
			</div>
			<div class="card-body">
				<div class="">
					<div class="alert alert-warning" role="alert">
						<i class="fas fa-check-circle"></i> Se pide que los valores a ingresar en la tabla sean en letra <strong>MAYÚSCULA</strong>, para estandarizar y evitar inconvenientes.<br>
						<i class="fas fa-check-circle"></i> Se pide registrar las columnas en las cuales <strong>aparezca el símbolo del asterisco (*)</strong> en la cebecera de la columna para evitar inconveniente de registro, datos obligatorios para el registro del cliente.<br>
						<i class="fas fa-check-circle"></i> Se pide registrar las columnas en las cuales <strong>aparezca el símbolo del doble asterisco (**)</strong> en la cebecera de la columna para evitar inconveniente de registro, datos obligatorios para el registro del cliente histórico.<br>
						<i class="fas fa-check-circle"></i> Si la columa ingresada <strong>no existe información</strong>, es preferible que se deje la <strong>celda vacia</strong>.<br>
						<i class="fas fa-check-circle"></i> Si algunas celdas aparecen en color <strong>rojo</strong>, a pesar de no tener información, se recomienda verificar que no exista espacios en blanco.<br>
						<i class="fas fa-check-circle"></i> La carga masiva tiene un tope <strong>máximo de 1000 filas</strong>.<br>
					</div>
				</div>
				<div class="tab-content">
					<div class="table-responsive"><!-- style="width: 100%;"-->
						<div id="nuevoPuntoMasivo"></div><!--style="overflow: auto;"-->
					</div>
				</div>
				<div class="hide">
					<input class="form-control" type="text" id="contColumnasDistribuidora" value="1">
					<input class="form-control" type="text" id="tipoSegmentacion" value="<?=$tipoSegmentacion?>">
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	Basemadre.dataListaRegionesNombre = JSON.parse('<?=json_encode($listaRegionesNombre)?>');
	Basemadre.dataListaRegionesDepartamentoProvinciaDistrito = JSON.parse('<?=json_encode($listaRegionesConcatenado)?>');
	Basemadre.dataListaProvinciasNombre = JSON.parse('<?=json_encode($listaProvinciasNombre)?>');
	Basemadre.dataListaDistritosNombre = JSON.parse('<?=json_encode($listaDistritosNombre)?>');
	Basemadre.dataListaZonaPeligrosaNombre = JSON.parse('<?=json_encode($listaZonaPeligrosaNombre)?>');
	Basemadre.dataListaCuentaNombre = JSON.parse('<?=json_encode($listaCuentaNombre)?>');
	Basemadre.dataListaProyectoNombre = JSON.parse('<?=json_encode($listaProyectoNombre)?>');
	Basemadre.dataListaFrecuenciaNombre = JSON.parse('<?=json_encode($listaFrecuenciaNombre)?>');
	Basemadre.dataListaZonaNombre = JSON.parse('<?=json_encode($listaZonaNombre)?>');
	Basemadre.dataListaGrupoCanalNombre = JSON.parse('<?=json_encode($listaGrupoCanalNombre)?>');
	Basemadre.dataListaCanalNombre = JSON.parse('<?=json_encode($listaCanalNombre)?>');
	Basemadre.daataListaClienteTipoNombre = JSON.parse('<?=json_encode($listaClienteTipoNombre)?>');
	Basemadre.dataListaCadenaNombre = JSON.parse('<?=json_encode($listaCadenaNombre)?>');
	Basemadre.dataListaBannerNombre = JSON.parse('<?=json_encode($listaBannerNombre)?>');
	Basemadre.dataListaPlazaNombre = JSON.parse('<?=json_encode($listaPlazaNombre)?>');
	Basemadre.dataListaDistribuidoraSucursalNombre = JSON.parse('<?=json_encode($listaDistribuidoraSucursalNombre)?>');
</script>