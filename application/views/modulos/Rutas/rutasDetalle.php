<style>
	table.dataTable {
		border-collapse: collapse !important;
	}
</style>
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
				<th rowspan="2" class="text-center hideCol">ESTADO USUARIO</th>
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
				<th colspan="19" class="text-center">MÓDULOS</th>
			</tr>
			<tr class="text-black">
				<th class="text-center thEncuesta <?= !empty($disabledTH['Encuestas'])?$disabledTH['Encuestas']."   " : '' ?>   <?= (!in_array( 1,$arrayColumnasVisibles,true ))? "hideCol excel-borrar noVis": "" ?>">ENCUESTA</th>
				<th class="text-center thProductos <?= !empty($disabledTH['CheckProducto'])? $disabledTH['CheckProducto']. "  ": '' ?><?= (!in_array( 3,$arrayColumnasVisibles,true ))? "hideCol excel-borrar noVis": "" ?> ">CHECK<br>PRODUCTOS</th> 
				<th class="text-center thPrecios <?= !empty($disabledTH['Precios'])? $disabledTH['Precios']."   ": '' ?><?= (!in_array( 10,$arrayColumnasVisibles,true ))? "hideCol excel-borrar noVis": "" ?> ">PRECIOS</th> 
				<th class="text-center thPromociones <?= !empty($disabledTH['Promociones'])? $disabledTH['Promociones']."  ": '' ?><?= (!in_array( 7,$arrayColumnasVisibles,true ))? "hideCol excel-borrar noVis": "" ?> ">PROMOCIONES</th> 
				<th class="text-center thFotos <?= !empty($disabledTH['Fotos'])? $disabledTH['Fotos']."  " : '' ?><?= (!in_array( 9,$arrayColumnasVisibles,true ))? "hideCol excel-borrar noVis": "" ?> ">FOTOS</th> 
				<th class="text-center thInventario  <?= !empty($disabledTH['Inventario'])? $disabledTH['Inventario']."   ": '' ?><?= (!in_array( 11,$arrayColumnasVisibles,true ))? "hideCol excel-borrar noVis": "" ?> ">INVENTARIO</th> 
				<th class="text-center thVisibilidad <?= !empty($disabledTH['Visibilidad'])? $disabledTH['Visibilidad']. "   ": '' ?><?= (!in_array( 5,$arrayColumnasVisibles,true ))? "hideCol excel-borrar noVis": "" ?> ">VISIBILIDAD</th> 
				<th class="text-center thMantenimientoCliente  <?= !empty($disabledTH['MantenimientoCliente'])? $disabledTH['MantenimientoCliente']."  " : ''?><?= (!in_array( 14,$arrayColumnasVisibles,true ))? "hideCol excel-borrar noVis": "" ?> ">MANTENIMIENTO<br>CLIENTE</th> 
				<th class="text-center thIniciativas <?= !empty($disabledTH['Iniciativas'])? $disabledTH['Iniciativas']. "  ": '' ?>  <?= (!in_array( 12,$arrayColumnasVisibles,true ))? "hideCol excel-borrar noVis": "" ?> ">INICIATIVAS</th> 
				<th class="text-center thInteligenciaCompetitiva <?= !empty($disabledTH['InteligenciaCompetitiva'])? $disabledTH['InteligenciaCompetitiva']."  ": '' ?>  <?= (!in_array( 13,$arrayColumnasVisibles,true ))? "hideCol excel-borrar noVis": "" ?> ">INTELIGENCIA<br>COMPETITIVA</th> 
				<th class="text-center thOrdenTrabajo <?= !empty($disabledTH['OrdenTrabajo'])? $disabledTH['OrdenTrabajo']."  ": '' ?>  <?= (!in_array( 22,$arrayColumnasVisibles,true ))? "hideCol excel-borrar noVis": "" ?> ">ORDEN DE<br>TRABAJO</th> 
				<th class="text-center thVisibilidadAuditoria <?= !empty($disabledTH['VisibilidadAuditoria'])? $disabledTH['VisibilidadAuditoria']."   ": '' ?>  <?= (!in_array( 17,$arrayColumnasVisibles,true ))? "hideCol excel-borrar noVis": "" ?> ">VISIBILIDAD<br>AUDITORIA</th> 
				<th class="text-center thPremiacion <?= !empty($disabledTH['Premiacion']) ? $disabledTH['Premiacion']."  " : ''  ?>  <?= (!in_array( 24,$arrayColumnasVisibles,true ))? "hideCol excel-borrar noVis": "" ?> ">PREMIACIÓN</th> 
				<th class="text-center thSurtido <?= !empty($disabledTH['Modulacion'])? $disabledTH['Modulacion']."  " : '' ?>  <?= (!in_array( 23,$arrayColumnasVisibles,true ))? "hideCol excel-borrar noVis": "" ?> ">SURTIDO</th> 
				<th class="text-center thObservacion <?= !empty($disabledTH['Observacion'])?  $disabledTH['Observacion']."  " : '' ?>  <?= (!in_array( 20,$arrayColumnasVisibles,true ))? "hideCol excel-borrar noVis": "" ?> ">OBSERVACION</th> 
				<th class="text-center thTareas <?= !empty($disabledTH['Tareas'])?  $disabledTH['Tareas']."  " : '' ?>  <?= (!in_array( 25,$arrayColumnasVisibles,true ))? "hideCol excel-borrar noVis": "" ?> ">TAREAS</th> 
				<th class="text-center thEvidenciaFotografica <?= !empty($disabledTH['EvidenciaFotografica'])?  $disabledTH['EvidenciaFotografica']."  " : '' ?>  <?= (!in_array( 26,$arrayColumnasVisibles,true ))? "hideCol excel-borrar noVis": "" ?> ">EVIDENCIA FOTOGRAFICA</th> 
				<th class="text-center thOrdenAuditoria <?= !empty($disabledTH['OrdenAuditoria'])?  $disabledTH['OrdenAuditoria']."  " : '' ?>  <?= (!in_array( 15,$arrayColumnasVisibles,true ))? "hideCol excel-borrar noVis": "" ?> ">ORDEN AUDITORIA</th> 
				<th class="text-center thModulacion <?= !empty($disabledTH['Modulacion'])?  $disabledTH['Modulacion']."  " : '' ?>  <?= (!in_array( 16,$arrayColumnasVisibles,true ))? "hideCol excel-borrar noVis": "" ?> ">MODULACION</th> 

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