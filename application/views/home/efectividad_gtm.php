<div class="card-datatable p-0 w-100">
	<table id="tablaEfectividadGtm" class="mb-0 table table-sm text-nowrap compact" style="width:100%;border-style:none;">
		<thead style="background-color:darkgray;color:white;">
			<tr>
				<th class="text-center noVis" style="width:30%">USUARIO</th>
				<th class="text-center" style="width:15%">PROGRAMADOS</th>
				<th class="text-center" style="width:15%"><?=$this->sessIdProyecto == PROYECTO_PROMOTORIA_AJE ? "VISITADO" : "EFECTIVO" ?></th>
				<th class="text-center noVis" style="width:15%"><?=$this->sessIdProyecto == PROYECTO_PROMOTORIA_AJE ? "% VISITA" : "EFECTIVIDAD" ?></th>

				<?if( $this->sessIdProyecto != PROYECTO_PROMOTORIA_AJE ){?>
					<th class="text-center" style="width:15%">INCIDENCIAS</th>
				<?}?>

				<?if($this->sessIdProyecto == PROYECTO_PROMOTORIA_AJE){?>
					<th class="text-center" style="width:15%">COMPRA B2B</th>
					<th class="text-center" style="width:15%">% EFECTIVIDAD B2B</th>
				<?}?>
					
				<?if($this->sessIdProyecto != PROYECTO_PROMOTORIA_AJE){?>
					<th class="text-center hideCol">IPP</th>
					<th class="text-center hideCol">CHECKLIST</th>
					<th class="text-center hideCol">FOTOS</th>
				<?}?>

			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>