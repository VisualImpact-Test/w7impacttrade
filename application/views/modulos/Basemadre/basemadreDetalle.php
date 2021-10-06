<div class="card-datatable">
	<table id="tb-basemadreDetalle" class="table table-striped table-bordered nowrap" width="100%">
		<thead>
			<tr>
				<th class="text-center noVis">#</th>
				<th class="text-center">GRUPO CANAL</th>
				<th class="text-center">CANAL</th>
				<th class="text-center hideCol">SUB CANAL</th>
				<th class="text-center">CLIENTE TIPO</th>
				<? foreach ($segmentacion['headers'] as $k => $v) { ?>
                    <th class="text-center align-middle"><?= strtoupper($v['header']) ?></th>
                <? } ?>
				<th class="text-center hideCol">DEPARTAMENTO</th>
				<th class="text-center hideCol">PROVINCIA</th>
				<th class="text-center hideCol">DISTRITO</th>
				<th class="text-center">COD VISUAL</th>
				<th class="text-center hideCol">COD <?=$this->sessNomCuentaCorto?></th>
				<th class="text-center hideCol">COD PDV</th>
				<th class="text-center">PDV</th>
				<th class="text-center">RAZÓN SOCIAL</th>
				<th class="text-center">DIRECCIÓN</th>
				<th class="text-center">RUC</th>
				<th class="text-center">DNI</th>
				<th class="text-center">FRECUENCIA</th>
				<th class="text-center">EN CARTERA</th>
				<th class="text-center">MONTO VENTA</th>
				<th class="text-center">% PARTI. UNIVERSO</th>
				<th class="text-center">% PARTI. CANAL</th>
				<th class="text-center">% PARTI. DEPART.</th>
				<th class="text-center">PROGRAMADO</th>
				<th class="text-center">ÚLTIMO CONTACTO</th>
			</tr>
		</thead>
		<tbody>
		
		</tbody>
	</table>
</div>