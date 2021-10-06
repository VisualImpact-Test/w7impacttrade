<?
	$arreglo_ingresos = array();
	if ( isset($fechas)) {
		foreach ($fechas as $ix_f => $row_f) {
			$completa=0;
			$congps=0;
			$singps=0;

			$incidencia=0;

			$falta_just=0;
			$vacaciones=0;
			$feriado=0;
			$otros=0;

			$falta_inj=0;

			if ( isset($listaUsuarios[$ix_f]) ) {
				foreach ($listaUsuarios[$ix_f]['usuarios'] as $ix_u => $row) {
					if ( !empty($row['fecha']) ) {
						$arr_asist = isset($asistencias[$ix_f]['usuarios'][$ix_u]['asistencias'][1]) ? $asistencias[$ix_f]['usuarios'][$ix_u]['asistencias'][1] : array();

						$latitud = isset($arr_asist['latitud']) ? $arr_asist['latitud'] : '';
						$longitud = isset($arr_asist['longitud']) ? $arr_asist['longitud'] : '';

						$status = '';
						$ocurrencia = '';

						if ( !empty($row['feriado']) && empty($arr_asist)) {
							$status = 'Fe';

							$feriado++;
							$falta_just++;
						} else {
							if ( !empty($row['vacaciones']) ) {
								$status = 'V';
								$vacaciones++;
								$falta_just++;
							} else {
								if ( !empty($row['ocurrencia']) ) {
									$status = 'O';
									$ocurrencia = $row['ocurrencia'];
									$otros++;
									$falta_just++;
								}
							}
						}
						//
						if ( empty($status)) {
							$status_ocurr = isset($arr_asist['idOcurrencia']) ? 1 : 0;

							if ( $status_ocurr==1 ) {
								$status = 'O';
								$incidencia++;

								$arreglo_ingresos[$ix_f]['tipo_incidencia'][$arr_asist['idOcurrencia']]['total'] = ( isset($arreglo_ingresos[$ix_f]['tipo_incidencia'][$arr_asist['idOcurrencia']]['total']) ) ? $arreglo_ingresos[$ix_f]['tipo_incidencia'][$arr_asist['idOcurrencia']]['total'] + 1 : 1;
							}
						}
						//
						//
						$status_ing = isset($asistencias[$ix_f]['usuarios'][$ix_u]['asistencias'][1]) ? 1 : 0;

						if ( empty($status) ) {
							if ( $status_ing==1 ) {
								$status = 'C';
								$completa++;
								if ( !empty($latitud) && !empty($longitud) ) {
									$congps++;
								} else {
									$singps++;
								}
							} elseif ( $status_ing==0 ) {
								$status = 'I';
								$falta_inj++;
							}
						}

					}
				}
			}

			$arreglo_ingresos[$ix_f]['completa']=$completa;
			$arreglo_ingresos[$ix_f]['congps']=$congps;
			$arreglo_ingresos[$ix_f]['singps']=$singps;

			$arreglo_ingresos[$ix_f]['incidencia']=$incidencia;

			$arreglo_ingresos[$ix_f]['falta_just']=$falta_just;
			$arreglo_ingresos[$ix_f]['feriado']=$feriado;
			$arreglo_ingresos[$ix_f]['vacaciones']=$vacaciones;
			$arreglo_ingresos[$ix_f]['otros']=$otros;

			$arreglo_ingresos[$ix_f]['falta_inj']=$falta_inj;

			$arreglo_ingresos[$ix_f]['total']=$completa+$incidencia+$falta_just+$falta_inj;
			//
			if($arreglo_ingresos[$ix_f]['total']>0){
				$arreglo_ingresos[$ix_f]['completas_por']=(isset($arreglo_ingresos[$ix_f]['completa']) && isset($arreglo_ingresos[$ix_f]['total']))? round(($arreglo_ingresos[$ix_f]['completa']/$arreglo_ingresos[$ix_f]['total'])*100,2):'0';
				$arreglo_ingresos[$ix_f]['incidencias_por']=(isset($arreglo_ingresos[$ix_f]['incidencia']) && isset($arreglo_ingresos[$ix_f]['total']))? round(($arreglo_ingresos[$ix_f]['incidencia']/$arreglo_ingresos[$ix_f]['total'])*100,2):'0';
				$arreglo_ingresos[$ix_f]['faltaInjus_por']=(isset($arreglo_ingresos[$ix_f]['falta_inj']) && isset($arreglo_ingresos[$ix_f]['total']))? round(($arreglo_ingresos[$ix_f]['falta_inj']/$arreglo_ingresos[$ix_f]['total'])*100,2):'0';
				$arreglo_ingresos[$ix_f]['faltaJust_por']=(isset($arreglo_ingresos[$ix_f]['falta_just']) && isset($arreglo_ingresos[$ix_f]['total']))? round(($arreglo_ingresos[$ix_f]['falta_just']/$arreglo_ingresos[$ix_f]['total'])*100,2):'0';
			}
		}
	}

	/*********************MARCACIÓN SALIDA************************/
	$arreglo_salidas = array();
	if ( isset($fechas) ) {
		foreach ($fechas as $ix_f => $row_f) {
			$completa=0;
			$congps=0;
			$singps=0;

			$incidencia=0;

			$falta_just=0;
			$vacaciones=0;
			$feriado=0;
			$otros=0;
			
			$falta_inj=0;

			if ( isset($listaUsuarios[$ix_f]) ) {
				foreach ($listaUsuarios[$ix_f]['usuarios'] as $ix_u => $row) {
					$arr_asist = isset($asistencias[$ix_f]['usuarios'][$ix_u]['asistencias'][3]) ? $asistencias[$ix_f]['usuarios'][$ix_u]['asistencias'][3] : array();

					$latitud = isset($arr_asist['latitud']) ? $arr_asist['latitud'] : '';
					$longitud = isset($arr_asist['longitud']) ? $arr_asist['longitud'] : '';

					$status = '';
					$ocurrencia = '';

					if ( !empty($row['feriado']) && empty($asistencias[$ix_f]['usuarios'][$ix_u]['asistencias'][1])) {
						$status = 'Fe';

						$feriado++;
						$falta_just++;
					} else {
						if ( !empty($row['vacaciones']) ) {
							$status = 'V';
							$vacaciones++;
							$falta_just++;
						} else {
							if ( !empty($row['ocurrencia']) ) {
								$status = 'O';
								$ocurrencia = $row['ocurrencia'];
								$otros++;
								$falta_just++;
							}
						}
					}
					//
					if ( empty($status) ) {
						$status_ocurr = isset($arr_asist['idOcurrencia']) ? 1 : 0;

						if ( $status_ocurr==1 ) {
							$status = 'O';
							$incidencia++;

							$arreglo_salidas[$ix_f]['tipo_incidencia'][$arr_asist['idOcurrencia']]['total'] = ( isset($arreglo_salidas[$ix_f]['tipo_incidencia'][$arr_asist['idOcurrencia']]['total']) ) ? $arreglo_salidas[$ix_f]['tipo_incidencia'][$arr_asist['idOcurrencia']]['total'] + 1 : 1;
						}
					}
					//
					//
					$status_ing = isset($asistencias[$ix_f]['usuarios'][$ix_u]['asistencias'][3]) ? 1 : 0;
					//
					if ( empty($status) ) {
						if ( $status_ing==1 ) {
							$status = 'C';
							$completa++;
							if ( !empty($latitud) && !empty($longitud) ) {
								$congps++;
							} else {
								$singps++;
							}
						} elseif ( $status_ing==0 ) {
							$status = 'I';
							$falta_inj++;
						}
					}
				}
			}

			$arreglo_salidas[$ix_f]['completa']=$completa;
			$arreglo_salidas[$ix_f]['congps']=$congps;
			$arreglo_salidas[$ix_f]['singps']=$singps;

			$arreglo_salidas[$ix_f]['incidencia']=$incidencia;

			$arreglo_salidas[$ix_f]['falta_just']=$falta_just;
			$arreglo_salidas[$ix_f]['feriado']=$feriado;
			$arreglo_salidas[$ix_f]['vacaciones']=$vacaciones;
			$arreglo_salidas[$ix_f]['otros']=$otros;
			
			$arreglo_salidas[$ix_f]['falta_inj']=$falta_inj;
			$arreglo_salidas[$ix_f]['total']=$completa+$incidencia+$falta_just+$falta_inj;

			if($arreglo_salidas[$ix_f]['total']>0){
				$arreglo_salidas[$ix_f]['completas_por']=(isset($arreglo_salidas[$ix_f]['completa']) && isset($arreglo_salidas[$ix_f]['total']))? round(($arreglo_salidas[$ix_f]['completa']/$arreglo_salidas[$ix_f]['total'])*100,2):'0';
				$arreglo_salidas[$ix_f]['incidencias_por']=(isset($arreglo_salidas[$ix_f]['incidencia']) && isset($arreglo_salidas[$ix_f]['total']))? round(($arreglo_salidas[$ix_f]['incidencia']/$arreglo_salidas[$ix_f]['total'])*100,2):'0';
				$arreglo_salidas[$ix_f]['faltaInjus_por']=(isset($arreglo_salidas[$ix_f]['falta_inj']) && isset($arreglo_salidas[$ix_f]['total']))? round(($arreglo_salidas[$ix_f]['falta_inj']/$arreglo_salidas[$ix_f]['total'])*100,2):'0';
				$arreglo_salidas[$ix_f]['faltaJust_por']=(isset($arreglo_salidas[$ix_f]['falta_just']) && isset($arreglo_salidas[$ix_f]['total']))? round(($arreglo_salidas[$ix_f]['falta_just']/$arreglo_salidas[$ix_f]['total'])*100,2):'0';
			}
		}
	}

?>
<!--------------------MARCACIÓN ENTRADA-------------------->
<div class="col-lg-12" style="margin-top: 1rem;">
<div class="row">
	<div class="col-lg-6">
		<div class="main-card mb-3 card">
			<div class="card-header card-header-spotlight">
				<i class="fas fa-chart-bar"></i>&nbsp;Historia de Entradas
			</div>
			<div class="card-body">
				<div id="idContentHistogramaEntrada">
					<?if ( isset($fechas)): ?>
						<div id="lineChartMarcacionesEntrada" style="height: 400px;"></div>
					<?else: echo(getMensajeGestion('noRegistros')); endif ?>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-6">
		<div class="main-card mb-3 card">
			<div class="card-header card-header-spotlight">
				<i class="fas fa-list-alt fa-lg"></i>&nbsp;Marcaciones de Entrada
			</div>
			<div class="card-body">
				<div id="idContentCuadroEntrada">
					<?if ( isset($fechas)): ?>
						<table class="mb-0 table table-bordered">
							<thead>
								<tr>
									<th class="text-center align-middle">OPCIONES</th>
									<?foreach ($fechas as $ix_f => $row_f): ?>
										<th class="text-center align-middle"><?=$row_f;?></th>
									<?endforeach ?>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="row-1">COMPLETA <a href="javascript:;" class="lk-row-1" data-indicador="comp" data-show="false"><i class="fa fa-plus-circle"></i></a></td>
									<? foreach ($fechas as $ix_f => $row_f): ?>
										<td class="text-center row-1"><?=$arreglo_ingresos[$ix_f]['completas_por'].'%';?></td>
									<? endforeach ?>
								</tr>
								<tr class="row-2-comp hide"> 
									<td style="padding-left:20px !important;">CON GPS</td>
									<? foreach($fechas as $ix_f => $row_f){ ?>
										<td class="text-center row-2-comp"><?=$arreglo_ingresos[$ix_f]['congps']; ?>
									<? } ?>
								</tr>
								<tr class="row-2-comp hide">
									<td style="padding-left:20px !important;">SIN GPS</td>
									<? foreach($fechas as $ix_f => $row_f){ ?>
										<td class="text-center"><?=$arreglo_ingresos[$ix_f]['singps']; ?>
									<? } ?>
								</tr>
								<tr>
									<td class="row-1" >INCIDENCIA <a href="javascript:;" class="lk-row-1" data-indicador="inc" data-show="false" ><i class="fa fa-plus-circle" ></i></a></td>
									<? foreach($fechas as $ix_f => $row_f){	?>
										<td class="text-center row-1"><?=$arreglo_ingresos[$ix_f]['incidencias_por'].'%'; ?>
									<? } ?>
								</tr>
								<? foreach($ocurrencias as $i_o => $row_o){ ?>
									<tr class="row-2-inc hide">
										<td style="padding-left:20px !important;"><?= $row_o?></td>
										<? foreach($fechas as $ix_f => $row_f){ ?>
											<td class="text-center"><?= isset($arreglo_ingresos[$ix_f]['tipos_incidencia'][$i_o]['total']) ? $arreglo_ingresos[$ix_f]['tipos_incidencia'][$i_o]['total'] : '0' ; ?>
										<? } ?>
										</tr>
								<? } ?>
								<tr>
									<td class="row-1">FALTA JUSTIFICADA <a href="javascript:;" class="lk-row-1" data-indicador="faltaJus" data-show="false" ><i class="fa fa-plus-circle" ></i></a></td>
									<? foreach($fechas as $ix_f => $row_f){ ?>
										<td class="text-center row-1" ><?=$arreglo_ingresos[$ix_f]['faltaJust_por'].'%'; ?>
									<? } ?>
								</tr>
								<tr class="row-2-faltaJus hide">
									<td style="padding-left:20px !important;">FERIADO</td>
									<? foreach($fechas as $ix_f => $row_f){ ?>
										<td class="text-center" ><?=$arreglo_ingresos[$ix_f]['feriado']; ?>
									<? } ?>
								</tr>
								<tr class="row-2-faltaJus hide">
									<td style="padding-left:20px !important;">VACACIONES</td>
									<? foreach($fechas as $ix_f => $row_f){ ?>
										<td class="text-center"><?=$arreglo_ingresos[$ix_f]['vacaciones']; ?>
									<? } ?>
								</tr>
								<tr class="row-2-faltaJus hide">
									<td style="padding-left:20px !important;">OTROS</td>
									<? foreach($fechas as $ix_f => $row_f){ ?>
										<td class="text-center"><?=$arreglo_ingresos[$ix_f]['otros']; ?>
									<? } ?>
								</tr>
								<tr>
									<td class="row-1">FALTA INJUSTIFICADA <a href="javascript:;" class="lk-row-1" data-indicador="faltaInj" data-show="false" ><i class="fa fa-plus-circle" ></i></a></td>
									<? foreach($fechas as $ix_f => $row_f){ ?>
										<td class="text-center row-1"><?=$arreglo_ingresos[$ix_f]['faltaInjus_por'].'%'; ?>
									<? } ?>
								</tr>
								<tr class="row-2-faltaInj hide">
									<td style="padding-left:20px !important;">FALTAS</td>
									<? foreach($fechas as $ix_f => $row_f){ ?>
										<td class="text-center"><?=$arreglo_ingresos[$ix_f]['falta_inj']; ?>
									<? } ?>
								</tr>
							</tbody>
						</table>
					<?else: echo(getMensajeGestion('noRegistros')); endif ?>
				</div>
			</div>
		</div>
	</div>
</div>

<!-------------------MARCACIÓN SALIDA---------------------------->

<div class="row">
	<div class="col-lg-6">
		<div class="main-card mb-3 card">
			<div class="card-header card-header-spotlight">
				<i class="fas fa-chart-bar"></i>&nbsp;Histograma de Salidas
			</div>
		
			<div class="card-body">
				<div id="idContentHistogramaSalida">
					<? if ( isset($fechas)): ?>
						<div id="lineChartMarcacionesSalida" style="height: 400px;"></div>
					<? else: echo(getMensajeGestion('noRegistros')); endif ?>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-6">
		<div class="main-card mb-3 card">
			<div class="card-header card-header-spotlight">
				<i class="fas fa-list-alt fa-lg"></i>&nbsp;Marcaciones de Salida
			</div>
		
			<div class="card-body">
				<div id="idContentCuadroSalida">
					<? if (isset($fechas)): ?>
						<table class="mb-0 table table-bordered">
							<thead>
								<tr>
									<th class="text-center align-middle">OPCIONES</th>
									<?foreach ($fechas as $ix_f => $row_f): ?>
										<th class="text-center align-middle"><?=$row_f;?></th>
									<?endforeach ?>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="row-1">COMPLETA <a href="javascript:;" class="lk-row-1" data-indicador="compSal" data-show="false" ><i class="fa fa-plus-circle" ></i></a></td>
									<? foreach($fechas as $ix_f => $row_f){	?>
										<td class="text-center row-1"><?=$arreglo_salidas[$ix_f]['completas_por'].'%'; ?>
									<? } ?>
								</tr>
								<tr class="row-2-compSal hide"> 
									<td style="padding-left:20px !important;">CON GPS</td>
									<? foreach($fechas as $ix_f => $row_f){ ?>
										<td class="text-center row-2-compSal"><?=$arreglo_salidas[$ix_f]['congps']; ?>
									<? } ?>
								</tr>
								<tr class="row-2-compSal hide">
									<td style="padding-left:20px !important;">SIN GPS</td>
									<? foreach($fechas as $ix_f => $row_f){ ?>
										<td class="text-center"><?=$arreglo_salidas[$ix_f]['singps']; ?>
									<? } ?>
								</tr>
								<tr>
									<td class="row-1" >INCIDENCIA <a href="javascript:;" class="lk-row-1" data-indicador="incSal" data-show="false" ><i class="fa fa-plus-circle" ></i></a></td>
									<? foreach($fechas as $ix_f => $row_f){	?>
										<td class="text-center row-1"><?=$arreglo_salidas[$ix_f]['incidencias_por'].'%'; ?>
									<? } ?>
								</tr>
							
								<? foreach($ocurrencias as $i_o => $row_o){?>
									<tr class="row-2-incSal hide">
										<td style="padding-left:20px !important;"><?= $row_o?></td>
										<? foreach($fechas as $ix_f => $row_f){	?>
											<td class="text-center"><?= isset($arreglo_salidas[$ix_f]['tipos_incidencia'][$i_o]['total']) ? $arreglo_salidas[$ix_f]['tipos_incidencia'][$i_o]['total'] : '0' ; ?>
										<? } ?>
									</tr>
								<? } ?>

								<tr>
									<td class="row-1">FALTA JUSTIFICADA <a href="javascript:;" class="lk-row-1" data-indicador="faltaJusSal" data-show="false" ><i class="fa fa-plus-circle" ></i></a></td>
									<? foreach($fechas as $ix_f => $row_f){	?>
										<td class="text-center row-1" ><?=$arreglo_salidas[$ix_f]['faltaJust_por'].'%'; ?>
									<? } ?>
								</tr>
								<tr class="row-2-faltaJusSal hide">
									<td style="padding-left:20px !important;">FERIADO</td>
									<? foreach($fechas as $ix_f => $row_f){	?>
										<td class="text-center" ><?=$arreglo_salidas[$ix_f]['feriado']; ?>
									<? } ?>
								</tr>
								<tr class="row-2-faltaJusSal hide">
									<td style="padding-left:20px !important;">VACACIONES</td>
									<? foreach($fechas as $ix_f => $row_f){	?>
										<td class="text-center"><?=$arreglo_salidas[$ix_f]['vacaciones']; ?>
									<? } ?>
								</tr>
								<tr class="row-2-faltaJusSal hide">
									<td style="padding-left:20px !important;">OTROS</td>
									<? foreach($fechas as $ix_f => $row_f){	?>
										<td class="text-center"><?=$arreglo_salidas[$ix_f]['otros']; ?>
									<? } ?>
								</tr>
								<tr>
									<td class="row-1">FALTA INJUSTIFICADA <a href="javascript:;" class="lk-row-1" data-indicador="faltaInjSal" data-show="false" ><i class="fa fa-plus-circle" ></i></a></td>
									<? foreach($fechas as $ix_f => $row_f){	?>
										<td class="text-center row-1"><?=$arreglo_salidas[$ix_f]['faltaInjus_por'].'%'; ?>
									<? } ?>
								</tr>
								<tr class="row-2-faltaInjSal hide">
									<td style="padding-left:20px !important;">FALTAS</td>
									<? foreach($fechas as $ix_f => $row_f){	?>
										<td class="text-center"><?=$arreglo_salidas[$ix_f]['falta_inj']; ?>
									<? } ?>
								</tr>
							</tbody>
						</table>
					<? else: echo(getMensajeGestion('noRegistros')); endif ?>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<script>
	anychart.onDocumentReady(function () {
		console.log("Creación de CartLine Entradas");
    	var data_completados = [
			<?foreach($fechas as $ix_f => $row_f){
				echo '{x:"'.$row_f.'",value:'.$arreglo_ingresos[$ix_f]['completas_por'].'},';
			}
			?>
		];

		var data_incidencias = [
			<?foreach($fechas as $ix_f => $row_f){
				echo '{x:"'.$row_f.'",value:'.$arreglo_ingresos[$ix_f]['incidencias_por'].'},';
			}
			?>
		];

		var data_just = [
			<?foreach($fechas as $ix_f => $row_f){
				echo '{x:"'.$row_f.'",value:'.$arreglo_ingresos[$ix_f]['faltaJust_por'].'},';
			}
			?>
		];
		
		var data_injust = [
			<?foreach($fechas as $ix_f => $row_f){
				echo '{x:"'.$row_f.'",value:'.$arreglo_ingresos[$ix_f]['faltaInjus_por'].'},';
			}
			?>
		];
		// create a chart
		var chart = anychart.line();

		var labels = chart.labels();
		labels.enabled(true);
		labels.position("centerTop");
		labels.anchor("bottom");
		labels.fontSize(9);
		labels.format(function(){return this.value+'%'});

		chart.yAxis().labels().format('{%Value}%');
		// create a spline series and set the data
		var series1 = chart.spline(data_completados);
		series1.name('Completados');
		series1.color('#5cb85c');

		var series2 = chart.spline(data_incidencias);
		series2.name('Incidencias');
		series2.color('#ff9343');
		
		var series3 = chart.spline(data_just);
		series3.name('Falta Just.');
		series3.color('#ffea49');

		var series4 = chart.spline(data_injust);
		series4.name('Falta Injust.');
		series4.color('#d9534f');

		chart.tooltip().format("{%SeriesName} : {%value}%");

		// set the chart title
		//chart.title("MARCACIONES DE ENTRADA");

		// set the titles of the axes
		var xAxis = chart.xAxis();
		xAxis.title("");
		var yAxis = chart.yAxis();
		//yAxis.title("Sales, $");


		 // turn the legend on
		 chart.legend()
	            .enabled(true)
	            .fontSize(13)
				.padding([0, 0, 20, 0]);
				
		// set the container id
		chart.container("lineChartMarcacionesEntrada");

		// initiate drawing the chart
		chart.draw();
	});

	anychart.onDocumentReady(function(){
		console.log("Creación de ChartLine Salidas");
		// create data
		var data_completados = [
			<?foreach($fechas as $ix_f => $row_f){
				echo '{x:"'.$row_f.'",value:'.$arreglo_salidas[$ix_f]['completas_por'].'},';
			}
			?>
		];

		var data_incidencias = [
			<?foreach($fechas as $ix_f => $row_f){
				echo '{x:"'.$row_f.'",value:'.$arreglo_salidas[$ix_f]['incidencias_por'].'},';
			}
			?>
		];

		var data_just = [
			<?foreach($fechas as $ix_f => $row_f){
				echo '{x:"'.$row_f.'",value:'.$arreglo_salidas[$ix_f]['faltaJust_por'].'},';
			}
			?>
		];
		
		var data_injust = [
			<?foreach($fechas as $ix_f => $row_f){
				echo '{x:"'.$row_f.'",value:'.$arreglo_salidas[$ix_f]['faltaInjus_por'].'},';
			}
			?>
		];
		// create a chart
		var chart = anychart.line();

		var labels = chart.labels();
		labels.enabled(true);
		labels.position("centerTop");
		labels.anchor("bottom");
		labels.fontSize(9);
		labels.format(function(){return this.value+'%'});


		chart.yAxis().labels().format('{%Value}%');
		// create a spline series and set the data
		var series1 = chart.spline(data_completados);
		series1.name('Completados');
		series1.color('#0041ff');

	 

		var series2 = chart.spline(data_incidencias);
		series2.name('Incidencias');
		series2.color('#ff9343');
		
		var series3 = chart.spline(data_just);
		series3.name('Falta Just.');
		series3.color('#ffea49');

		var series4 = chart.spline(data_injust);
		series4.name('Falta Injust.');
		series4.color('#ff4545');

		chart.tooltip().format("{%SeriesName} : {%value}%");

		// set the chart title
		//chart.title("MARCACIONES DE SALIDA");

		// set the titles of the axes
		var xAxis = chart.xAxis();
		xAxis.title("");
		var yAxis = chart.yAxis();
		//yAxis.title("Sales, $");


		 // turn the legend on
		 chart.legend()
	            .enabled(true)
	            .fontSize(13)
				.padding([0, 0, 20, 0]);
				
		// set the container id
		chart.container("lineChartMarcacionesSalida");

		// initiate drawing the chart
		chart.draw();
	});
</script>

	