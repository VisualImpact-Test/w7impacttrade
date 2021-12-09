		<div class="card-datatable">
		<table id="<?=$idDataTableDetalle;?>" class="table table-striped table-bordered nowrap">
			<thead>
				<tr>
					<th class="text-center align-middle noVis" rowspan="3">#</th>
					<th class="text-center align-middle" rowspan="3">FECHA</th>
					<th class="text-center align-middle" rowspan="3">COD<br>USUARIO</th>
					<th class="text-center align-middle hideCol"  rowspan="3" >ESTADO USUARIO</th>
					<th class="text-center align-middle" rowspan="3">USUARIO</th>
					<th class="text-center align-middle " rowspan="3">GRUPO CANAL</th>
					<th class="text-center align-middle" rowspan="3">CANAL</th>
					<? foreach ($segmentacion['headers'] as $k => $v) { ?>
						<th rowspan="3" class="text-center align-middle"><?= strtoupper($v['header']) ?></th>
						<? } ?>
					<th class="text-center align-middle hideCol" rowspan="3">DEPARTAMENTO</th>
					<th class="text-center align-middle hideCol" rowspan="3">PROVINCIA</th>
					<th class="text-center align-middle hideCol" rowspan="3">DISTRITO</th>
					<th class="text-center align-middle" rowspan="3">PDV</th>
					<th class="text-center align-middle" rowspan="3">COD<br>VISUAL</th>
					<th class="text-center align-middle" rowspan="3">COD<br>CLIENTE</th>
					<th class="text-center align-middle hideCol" rowspan="3">DIRECCIÓN</th>
					<th class="text-center align-middle" rowspan="3">CONDICIÓN</th>
					<th class="text-center align-middle" colspan="3">HORARIO</th>
					<th class="text-center align-middle" rowspan="3">INCIDENCIA</th>
					<th class="text-center align-middle" colspan="20">MÓDULOS</th>
					<!-- <th class="text-center align-middle" rowspan="3">CARGAR DATA</th> -->
				</tr>
				<tr>
					<th class="text-center align-middle" rowspan="2">HORA<br>INICIO</th>
					<th class="text-center align-middle" rowspan="2">HORA<br>FIN</th>
					<th class="text-center align-middle" rowspan="2">ACTUALIZAR</th>
					<th class="text-center align-middle" rowspan="2">ENCUESTA</th>
					<th class="text-center align-middle" rowspan="2">IPP</th>
					<th class="text-center align-middle" rowspan="2">CHECK<br>PRODUCTOS</th>
					<th class="text-center align-middle" rowspan="2">PRECIOS</th>
					<th class="text-center align-middle" rowspan="2">PROMOCIONES</th>
					<th class="text-center align-middle noVis" rowspan="2">SOS</th>
					<th class="text-center align-middle noVis" rowspan="2">SOD</th>
					<th class="text-center align-middle noVis" rowspan="2">ENCARTES</th>
					<th class="text-center align-middle noVis" rowspan="2">SEG DE PLAN</th>
					<th class="text-center align-middle noVis" rowspan="2">DESPACHOS</th>
					<th class="text-center align-middle" rowspan="2">FOTOS</th>
					<th class="text-center align-middle" rowspan="2">INVENTARIO</th>
					<th class="text-center align-middle" rowspan="2">VISIBILIDAD</th>
					<th class="text-center align-middle" rowspan="2">MANTENIMIENTO<br>CLIENTE</th>
					<th class="text-center align-middle" rowspan="2">INICIATIVAS</th>
					<th class="text-center align-middle" rowspan="2">INTELIGENCIA<br>COMPETITIVA</th>
					<th class="text-center align-middle" rowspan="2">ORDEN<br>DE<br>TRABAJO</th>
					<th class="text-center align-middle" colspan="3">VISIBILIDAD<br>AUDITORIA</th>
				</tr>
				<tr>
					<th class="text-center align-middle  noVis">OBLIGATORIA</th>
					<th class="text-center align-middle">INICIATIVA</th>
					<th class="text-center align-middle  noVis">ADICIONAL</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
		</div>

	<script>
		$('#btn-saveContingenciaAsistencia').parent().removeClass('hide');
	</script>