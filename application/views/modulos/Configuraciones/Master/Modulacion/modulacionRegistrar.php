<style>
	.handsontable .td-normal{
		font-weight: bold;
		text-align: center;
	}
	.handsontable .td-true{
		background-color: #7be87b !important;
		font-weight: bold;
		text-align: center !important;
	}
	.handsontable .td-false{
		background-color: #dc3545 !important;
		font-weight: bold;
		text-align: center !important;
	}
</style>
<div class="row themeWhite">
	<div class="col-md-12">
		<div class="mb-3 card">
			<div class="card-header">
				REGISTRAR MODULACIÓN MASIVA
			</div>
			<div class="card-body">
				<form id="frm-registrarModulacionMasiva">
					<div class="hide">
						<? $permisoAnterior = !empty($dataPermisoAnterior) ? $dataPermisoAnterior['idPermiso'] : ""; ?>
						<input type="text" class="form-control" id="permisoAnterior" name="permisoAnterior" value="<?=$permisoAnterior?>">
					</div>
					<div class="div-informacion">
						<div class="alert alert-warning" role="alert">
							<i class="fas fa-check-circle"></i> Se pide que los valores a ingresar en la tabla sean en letra <strong>MAYÚSCULA</strong>, para estandarizar y evitar inconvenientes.<br>
							<i class="fas fa-check-circle"></i> Si la columa ingresada <strong>no existe información</strong>, es preferible que se deje la <strong>celda vacia</strong>.<br>
							<i class="fas fa-check-circle"></i> Si algunas celdas aparecen en color <strong>rojo</strong>, a pesar de no tener información, se recomienda verificar que no exista espacios en blanco.<br>
							<i class="fas fa-check-circle"></i> La carga masiva tiene un tope <strong>máximo de 1000 filas</strong>.<br>
							<i class="fas fa-check-circle"></i> Si el usuario desea cargar por <strong>segunda vez</strong> la modulación para <strong>uno o varios clientes</strong>, puede utilizar dicha <strong>carga masiva</strong>, esto hara que la información se actualice, de manera individual para <strong>cada cliente</strong> en específico.<br>
						</div>
					</div>
					<div class="row">
						<div class="hide">
							<input type="text" name="masivoPermiso" id="masivoPermiso" value="<?=$dataPermiso['idPermiso']?>">
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="table-responsive">
								<table class="table table-striped table-bordered nowrap table-sm" width="100%">
									<thead>
										<tr>
											<th class="text-center">FECHA INICIO CARGA</th>
											<th class="text-center">FECHA FIN CARGA</th>
											<th class="text-center">FECHA INICIO LISTA</th>
											<th class="text-center">FECHA FIN LISTA</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="text-center"><label><i class="fas fa-hourglass-half"></i> <?=$dataPermiso['fecIniCarga']?></label></td>
											<td class="text-center"><label><i class="fas fa-hourglass-half"></i> <?=$dataPermiso['fecFinCarga']?></label></td>
											<td class="text-center"><label><i class="fas fa-calendar-week"></i> <?=$dataPermiso['fecIniLista']?></label></td>
											<td class="text-center"><label><i class="fas fa-calendar-week"></i> <?=$dataPermiso['fecFinLista']?></label></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="row">
						<button type="button" data-toggle="collapse" id="btn-descargarModulacionFormato" class="btn-outline-primary border-0" style="padding:10px;margin-left:10px;border-radius: 13px;outline: blue;">  Descargar Formato</button>
					</div>
					<div class="tab-content">
						<div class="table-responsive"><!-- style="width: 100%;"-->
							<div id="registrarModulacionMasivo"></div><!--style="overflow: auto;"-->
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	Modulacion.dataListaClientes = JSON.parse('<?=json_encode($listaClientes)?>');
	Modulacion.dataListaClientesMinimos = JSON.parse('<?=json_encode($listaClientesMinimos)?>');
	Modulacion.dataListaElementos = JSON.parse('<?=json_encode($listaElementos)?>');
</script>