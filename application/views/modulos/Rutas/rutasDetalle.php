<style>
	table.dataTable {
		border-collapse: collapse !important;
	}
</style>
<?
$disabledTH['Encuestas'] = 'tdDisabledRutacuenta';
$disabledTH['CheckProducto'] = 'tdDisabledRutacuenta';
$disabledTH['Precios'] = 'tdDisabledRutacuenta';
$disabledTH['Promociones'] = 'tdDisabledRutacuenta';
$disabledTH['Fotos'] = 'tdDisabledRutacuenta';
$disabledTH['Inventario'] = 'tdDisabledRutacuenta';
$disabledTH['Visibilidad'] = 'tdDisabledRutacuenta';
$disabledTH['MantenimientoCliente'] = 'tdDisabledRutacuenta';
$disabledTH['Iniciativas'] = 'tdDisabledRutacuenta';
$disabledTH['InteligenciaCompetitiva'] = 'tdDisabledRutacuenta';
$disabledTH['OrdenTrabajo'] = 'tdDisabledRutacuenta';
$disabledTH['VisibilidadAuditoria'] = 'tdDisabledRutacuenta';
$disabledTH['Premiacion'] = 'tdDisabledRutacuenta';
$disabledTH['Modulacion'] = 'tdDisabledRutacuenta';
$disabledTH['Observacion'] = 'tdDisabledRutacuenta';

foreach ($permisos_modulos_cuenta as $key => $row) {
	$disabledTH[preg_replace('/\s+/', '', $row['nombre'])] = '';
}
?>
<div class="card-datatable">
	<table id="tb-rutasDetalle" class="table table-striped table-bordered nowrap w-100" style="font-size:12px;">
		<thead class="text-center align-middle">
			<!-- Si se agrega una columna nueva ir a FILTRAR_LEYENDA en rutas.js y verificar el numero de columna -->
			<tr class="text-black">
				<th rowspan="2" class="noVis">#</th>
				<th rowspan="2" class="text-center">FECHA</th>
				<th rowspan="2" class="text-center">PERFIL USUARIO</th>
				<th rowspan="2" class="text-center hideCol">COD<br>EMPLEADO</th>
				<th rowspan="2" class="text-center">COD<br>USUARIO</th>
				<th rowspan="2" class="text-center">NOMBRE USUARIO</th>
				<th rowspan="2" class="text-center">GRUPO CANAL</th>
				<th rowspan="2" class="text-center">CANAL</th>
				<th rowspan="2" class="text-center hideCol">SUB CANAL</th>
				<? foreach ($segmentacion['headers'] as $k => $v) { ?>
                    <th rowspan="2" class="text-center align-middle"><?= strtoupper($v['header']) ?></th>
                <? } ?>
				<th rowspan="2" class="text-center">COD VISUAL</th>
				<th rowspan="2" class="text-center hideCol">COD <?=$this->sessNomCuentaCorto?></th>
				<th rowspan="2" class="text-center">COD PDV</th>
				<th rowspan="2" class="text-center hideCol">DEPARTAMENTO</th>
				<th rowspan="2" class="text-center hideCol">PROVINCIA</th>
				<th rowspan="2" class="text-center hideCol">DISTRITO</th>
				<th rowspan="2" class="text-center">PDV</th>
				<th rowspan="2" class="text-center">FRECUENCIA</th>
				<th rowspan="2" class="text-center">HORA INICIO</th>
				<th rowspan="2" class="text-center hideCol">LATITUD INICIAL</th>
				<th rowspan="2" class="text-center hideCol">LONGITUD INICIAL</th>
				<th rowspan="2" class="text-center">HORA FIN</th>
				<th rowspan="2" class="text-center hideCol">LATITUD FINAL</th>
				<th rowspan="2" class="text-center hideCol">LONGITUD FINAL</th>
				<th rowspan="2" class="text-center">TIEMPO (MIN)</th>
				<th rowspan="2" class="text-center">INCIDENCIA</th>
				<th rowspan="2" class="text-center colCondicion">CONDICIÓN</th>
				<th colspan="15" class="text-center">MÓDULOS</th>
			</tr>
			<tr class="text-black">
				<th class="text-center thEncuesta <?= !empty($disabledTH['Encuestas'])?$disabledTH['Encuestas']." hideCol noVis " : '' ?>">ENCUESTA</th>
				<th class="text-center thProductos <?= !empty($disabledTH['CheckProducto'])? $disabledTH['CheckProducto']. " hideCol noVis": '' ?>">CHECK<br>PRODUCTOS</th>
				<th class="text-center thPrecios <?= !empty($disabledTH['Precios'])? $disabledTH['Precios']." hideCol noVis ": '' ?>">PRECIOS</th>
				<th class="text-center thPromociones <?= !empty($disabledTH['Promociones'])? $disabledTH['Promociones']." hideCol noVis": '' ?>">PROMOCIONES</th>
				<th class="text-center thFotos <?= !empty($disabledTH['Fotos'])? $disabledTH['Fotos']." hideCol noVis" : '' ?>">FOTOS</th>
				<th class="text-center thInventario  <?= !empty($disabledTH['Inventario'])? $disabledTH['Inventario']." hideCol noVis ": '' ?>">INVENTARIO</th>
				<th class="text-center thVisibilidad <?= !empty($disabledTH['Visibilidad'])? $disabledTH['Visibilidad']. " hideCol noVis ": '' ?>">VISIBILIDAD</th>
				<th class="text-center thMantenimientoCliente  <?= !empty($disabledTH['MantenimientoCliente'])? $disabledTH['MantenimientoCliente']." hideCol noVis" : ''?>">MANTENIMIENTO<br>CLIENTE</th>
				<th class="text-center thIniciativas <?= !empty($disabledTH['Iniciativas'])? $disabledTH['Iniciativas']. " hideCol noVis": '' ?>  ">INICIATIVAS</th>
				<th class="text-center thInteligenciaCompetitiva <?= !empty($disabledTH['InteligenciaCompetitiva'])? $disabledTH['InteligenciaCompetitiva']." hideCol noVis": '' ?>  ">INTELIGENCIA<br>COMPETITIVA</th>
				<th class="text-center thOrdenTrabajo <?= !empty($disabledTH['OrdenTrabajo'])? $disabledTH['OrdenTrabajo']." hideCol noVis": '' ?>  ">ORDEN DE<br>TRABAJO</th>
				<th class="text-center thVisibilidadAuditoria <?= !empty($disabledTH['VisibilidadAuditoria'])? $disabledTH['VisibilidadAuditoria']." hideCol noVis ": '' ?>  ">VISIBILIDAD<br>AUDITORIA</th>
				<th class="text-center thPremiacion <?= !empty($disabledTH['Premiacion']) ? $disabledTH['Premiacion']." hideCol noVis" : ''  ?>  ">PREMIACIÓN</th>
				<th class="text-center thSurtido <?= !empty($disabledTH['Modulacion'])? $disabledTH['Modulacion']." hideCol noVis" : '' ?>  ">SURTIDO</th>
				<th class="text-center thObservacion <?= !empty($disabledTH['Observacion'])?  $disabledTH['Observacion']." hideCol noVis" : '' ?>  ">OBSERVACION</th>
			</tr>
		</thead>
		<tbody>
	
		</tbody>
	</table>
</div>

<script>
	$(document).ready(function() {
		var c = 0;
	});


</script>