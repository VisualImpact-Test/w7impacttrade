<?
	$flagHide=$this->session->userdata('flagHide'); 
	$igv_ = $igv;
    function moneda_presellers($valor, $dec = TOTAL_DECIMALES)
    {
        //return $valor;
        if( is_string($valor) ) return $valor;
        else
        {
            $valor = number_format($valor, TOTAL_DECIMALES, '.', ',');
            return $valor;
        }
    }

?>	
<style>
.widget-head{
    background-color: #ecebeb !important;
    border-top-right-radius: 3px !important;
    border-top-left-radius: 3px !important;
    /* text-shadow: 0px 1px #fff; */
    border: 1px solid #ecebeb
    0: ;
    color: #000 !important;
    font-size: 13px !important;
    font-weight: bold !important;
    padding: 8px 15px !important;
}
i.fa.fa-file-excel-o {
    color: #000 !important;
    font-size: 20px !important;
}

.table {
    border-spacing: 5px !important;
    border-collapse: collapse !important;
    white-space: nowrap !important;
    margin-bottom: 0 !important;
	width: 100% !important;
    max-width: 100% !important;
	font-size:10px !important;
}
.table th {
    vertical-align: middle !important;
    text-transform: uppercase;
    color: #FFF;
    background-color: #002856;
    text-align: center !important;
    padding: 5px;
    border-top: none !important;
    border-bottom: 1px dotted #6f6f6f;
    border-right: 1px dotted #6f6f6f;
}
.widget {
    overflow: auto;
    margin: 15px;
}
</style>
<div class="col-lg-12">
	    <div class="main-card mb-3 card">
	    	<div class="card-header">
	    		<i class="fas fa-list-alt fa-lg"></i>&nbspDetalle
	    	</div>
	        <div class="card-body">
	            <div id="idContentAuditoria" >
	            	<!----------------------------------------------------------->

<?
	function calcularMonto($valor,$igv,$dec=TOTAL_DECIMALES)
    {
        if($igv==1)$valor=$valor/(1000*IGV);
		if($igv==2)$valor=$valor/1000;
		return $valor;
    } 
	
	function semaforizarProyeccion($tipo,$porciento)
    {
		if($tipo == 'unidad'){
			$porciento = round( $porciento, 0 );
			if($porciento>99)return "porcVerde_unidad";
			if($porciento>=90 && $porciento<=99)return "porcAmarillo";
			if($porciento>=0 && $porciento<=89)return "porcRojo_unidad";
		}
		
		if($tipo == 'ciudad'){
			$porciento = round( $porciento, 0 );
			if($porciento>99)return "porcVerde_ciudad";
			if($porciento>=90 && $porciento<=99)return "porcAmarillo";
			if($porciento>=0 && $porciento<=89)return "porcRojo_ciudad";
		}
		if($tipo == 'plaza'){
			$porciento = round( $porciento, 0 );
			if($porciento>99)return "porcVerde_plaza";
			if($porciento>=90 && $porciento<=99)return "porcAmarillo";
			if($porciento>=0 && $porciento<=89)return "porcRojo_plaza";
		}
		
		if($tipo == 'tope'){
			$porciento = round( $porciento, 0 );
			if($porciento>99)return "porcVerde_tope";
			if($porciento>=90 && $porciento<=99)return "porcAmarillo";
			if($porciento>=0 && $porciento<=89)return "porcRojo_tope";
		}
		
        
    }

    function addPorcentaje($valor)
    {
        if( is_string($valor) ) return $valor;
        else
        {
            $valor = round($valor,0);
            return $valor.'%';
        }
    }
    
    function addSignoPacing($valor)
    {
        $valor = round($valor,0);
        //$valor = $valor - 100;
        return $valor > 100 ? "+".$valor : "-".$valor;
    }
    
    function calcularMontoSinIGV($valor)
    {
        return $valor / IGV;
    }
    
    function semaforizarDashboard($porcentaje)
    {
        if($porcentaje>0){ $html = '<i style="float:left;color: GREEN" class="fa fa-circle"></i>';}
        if($porcentaje<=0){ $html = '<i style="float:left;color: RED" class="fa fa-circle"></i>';}
		return $html;
    }
	function gap($monto)
    {
        if($monto>100){ $html = '<i style="float:left;color: GREEN" class="fa fa-circle"></i>';}
        if($monto<=100){ $html = '<i style="float:left;color: RED" class="fa fa-circle"></i>';}
		return $html;
    }
	function pacing_flecha($pacing)
    {
		
        if($pacing>100){ $html = '<i style="float:left;color: GREEN" class="fa fa-arrow-up"></i>';}
        if($pacing<=100){ $html = '<i style="float:left;color: RED" class="fa fa-arrow-down" ></i>';}
		return $html;
    }
	
	$performance = isset($ventas)?$ventas:array();
	$ofender = isset($ventas)?$ventas:array();
	
	function ofender($a,$b){
		return $a['venta']-$b['venta'];
	}
	function performance($a,$b){
		return -$a['venta']+$b['venta'];
	}
	uasort($ofender, 'ofender');
	uasort($performance, 'performance');

	foreach($cabeceraAnioMes as $keyAnio=>$arrayMeses){
		foreach($arrayMeses as $keyMes=>$valMes){
			$ultAnio  = $keyAnio;
			$ultMes  = $keyMes;
		}
	}
	$i=0;
	$performance_final = array();
	foreach( $performance as $row ){
		if($i<3){
			$performance_final[$i]['idSucursal']=$row['idSucursal'];
			$performance_final[$i]['venta']=$row['venta'];
		}
		$i++;
	} 
	$j=0;
	$ofender_final = array();
	foreach( $ofender as $row ){
		if($j<3){
			$ofender_final[$j]['idSucursal']=$row['idSucursal'];
			$ofender_final[$j]['venta']=$row['venta'];
		}
		$j++;
	} 
?>
<div class="row" >
	<div class="col-md-4 col-sm-4 col-xs-4"></div>
	<div class="col-md-4 col-sm-4 col-xs-4">
		<div class="widget" >
			<div class="widget-head">
				<div class="pull-left"></div>  
				<div id="" class="widget-icons pull-right">
					<a href="javascript:;" class="lk-export-excel" data-content="tabla-summary-resumen" data-title="Avance Summary" ><i class="fa fa-file-excel-o"></i></a>
				</div>  
				<div class="clearfix"></div>
			</div>
			<div id="tabla-summary-resumen" >
				<table class="table" >
					<tr>
						<td style="background:#396ece;color:#ffffff;font-weight:bold;">DIAS HABILES</td>
						<td style="text-align:center;"><b><?=$diasUtil;?></b></td>
					</tr>
					<tr>
						<td style="background:#396ece;color:#ffffff;font-weight:bold;">DIAS TRANSCURRIDOS</td>
						<td style="text-align:center;"><b><?=$diaUtilActual;?></b></td>
					</tr>
					<tr>
						<td style="background:#396ece;color:#ffffff;font-weight:bold;">DIAS RESTANTES</td>
						<td style="text-align:center;"><b><?=$diasUtil-$diaUtilActual;?></b></td>
					</tr>
					<tr>
						<td style="background:#396ece;color:#ffffff;font-weight:bold;">% AVANCE</td>
						<td style="text-align:center;"><b><?=round(($diaUtilActual/$diasUtil)*100,2).'%';?></b></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-4 col-sm-4 col-xs-4"></div>
</div>
<div class="row" >
	<div class="col-md-7 col-sm-12 col-xs-12">
		<div class="widget" >
			<div class="widget-head">
				<div class="pull-left">Summary (Plazas)</div>  
				<div id="" class="widget-icons pull-right">
					<a href="javascript:;" class="lk-export-excel" data-content="tabla-summary-1" data-title="Summary Plazas" ><i class="fa fa-file-excel-o"></i></a>
				</div>  
				<div class="clearfix"></div>
			</div>
			<div id="tabla-summary-1" >
				<table class="table table-striped table-bordered nowrap" style="font-size: 90%">
					<thead>
						<tr>
							<th rowspan="3">PLAZA</th>
							<!--<th rowspan="3">P3M</th>-->
							<th>CUOTA</th>
							<th>AVANCE</th>
							<th rowspan="3">IDX</th>
							<th  rowspan="2" colspan="2">PROYECCION AL CIERRE</th>
							<th rowspan="3">GAP<br>(miles S/.)</th>
							<th rowspan="3">PACING</th>	
						</tr>
						<tr>
							
							<th><?=$mesActual.' '.$anioActual?></th>
							<th><?=$fechaFinal?></th>
						</tr>
						<tr>
							<th>(miles S/.)</th>
							<th>(miles S/.)</th>
							<th>(miles S/.)</th>
							<th>%</th>
						</tr>
					</thead>
					<tbody>
						<? $total_cuota=0;$total_ventas=0; foreach($unidades as $ix_u => $row_u){ $p3m_total=isset($row_u['p3m'])?$row_u['p3m']:0; ?>
							<?if(isset($ciudades[$ix_u] )){ foreach($ciudades[$ix_u] as $ix_c => $row_c){ ?>
								<?if(isset($plazas[$ix_u][$ix_c] )){ foreach($plazas[$ix_u][$ix_c] as $ix_p => $row_p){ ?>
									<?
										$p3m = isset($row_p['p3m'])?$row_p['p3m']:0;
										$cuota = isset($row_p['cuota'])?$row_p['cuota']:0;
										$ventas = isset($row_p['ventas'])?$row_p['ventas']:0;
										
										$ventas_cuota = ($cuota>0)? round(($ventas/$cuota)*100,2):0;
										$pacing = ($p3m>0)?(($ventas/$p3m)*100)-100:0;
										$proyectado = ($ventas/$diaUtilActual)*$diasUtil;
										$proyectado_cuota = ($cuota>0)?round(($proyectado/$cuota)*100,2):0;
										$gap = $ventas - $cuota;
										$diasRestantes = $diasUtil-$diaUtilActual;
										$objetivoDiario = ($diasRestantes>0)?$gap/$diasRestantes:0;
										
										$total_cuota  = $cuota  + $total_cuota;
										$total_ventas = $ventas + $total_ventas;
									?>
									<tr>
										<td><?=$row_p['nombre']?></td>
										<!--<td style="text-align:right;"><?=($p3m>0)?moneda_presellers($p3m,$igv):'-';?></td>-->
										<td style="text-align:right;"><?=($cuota)?moneda_presellers($cuota,$igv):'-';?></td>
										<td style="text-align:right;"><?=($ventas)?moneda_presellers($ventas,$igv):'-';?></td>
										<td style="text-align:right;"><?=($ventas_cuota>0)?$ventas_cuota.'%':'-';?></td>
										<td style="text-align:right;"><?=($ventas>0)?moneda_presellers($proyectado,$igv):'-';?></td>
										<td style="text-align:right;"><?=($proyectado_cuota>0)?semaforizarDashboard($proyectado_cuota).$proyectado_cuota.'%':'-';?></td>
										<td style="text-align:right;"><?=($ventas>0)?gap($gap).moneda_presellers($gap,$igv):'-';?></td>
										<td style="text-align:right;"><?=($p3m>0)?pacing_flecha($pacing).$pacing:'-';?></td>
									</tr>
								<?}}?>
							<?}}?>
						<?}?>
					</tbody>
					<tfoot>
							<?
								$p3m = $p3m_total;
								$cuota = $total_cuota;
								$ventas = $total_ventas;
								
								$ventas_cuota = ($cuota>0)?round(($ventas/$cuota)*100,2):0;
								$pacing = ($p3m>0)?(($ventas/$p3m)*100)-100:0;
								$proyectado = ($ventas/$diaUtilActual)*$diasUtil;
								$proyectado_cuota = ($cuota>0)?round(($proyectado/$cuota)*100,2):0;
								$gap = $ventas - $cuota;
								$diasRestantes = $diasUtil-$diaUtilActual;
								$objetivoDiario = ($diasRestantes>0)?$gap/$diasRestantes:0;
								
							?>
						<tr>
							<td>TOTAL</td>
							<!--<td style="text-align:right;"><?=($p3m>0)?moneda_presellers($p3m,$igv):'-';?></td>-->
							<td style="text-align:right;"><?=($cuota)?moneda_presellers($cuota,$igv):'-';?></td>
							<td style="text-align:right;"><?=($ventas)?moneda_presellers($ventas,$igv):'-';?></td>
							<td style="text-align:right;"><?=($ventas_cuota>0)?$ventas_cuota.'%':'-';?></td>
							<td style="text-align:right;"><?=($ventas>0)?moneda_presellers($proyectado,$igv):'-';?></td>
							<td style="text-align:right;"><?=($proyectado_cuota>0)?semaforizarDashboard($proyectado_cuota).$proyectado_cuota.'%':'-';?></td>
							<td style="text-align:right;"><?=($ventas>0)?gap($gap).moneda_presellers($gap,$igv):'-';?></td>
							<td style="text-align:right;"><?=($p3m>0)?pacing_flecha($pacing).$pacing:'-';?></td>
						</tr>
					</tfoot>
				</table>

			</div>
		</div>
	</div>
	<?
	$trVentasXCategoria='';
	$cuotaCategoriaActual = '';
    $porcCuota = 0;
	foreach($categoria as $keyComparteCuota=>$arrayDataComparteCuota)
    {
        if( $cuotaCategoriaActual != $keyComparteCuota )
        {
            $porcCuota = $arrayDataComparteCuota['cuota'];
            $cuotaCategoriaActual = $keyComparteCuota;
            $trVentasXCategoria .= '<tr><td>'.implode(" / ",$arrayDataComparteCuota['nombre']).' (<strong>'.$porcCuota.'%</strong>)'.'</td>';
       
		
		foreach($cabeceraAnioMes as $keyAnio=>$arrayMeses)
        {
            foreach($arrayMeses as $keyMes=>$valMes)
            {
                $venta = 0;
               if( isset($ventaCategoria[$keyAnio][$keyMes]) ){
                    foreach( $arrayDataComparteCuota['idProductoCategoria'] as $idCategoria ){
                        if(isset($ventaCategoria[$keyAnio][$keyMes][$idCategoria]))
							$venta+=$ventaCategoria[$keyAnio][$keyMes][$idCategoria];
                    }
                }

                 if($ultAnio==$keyAnio && $ultMes==$keyMes){
                   $promedio=0;
                    $cantProm=0;
					foreach($arrayDataComparteCuota['idProductoCategoria'] as $idCategoria){
                        if(isset($promedioVentaXCategoria[$idCategoria])){ 
                            $cantProm=(count($promedioVentaXCategoria[$idCategoria])>$cantProm)?count($promedioVentaXCategoria[$idCategoria]):$cantProm; 
							$promedio+=array_sum($promedioVentaXCategoria[$idCategoria]);
						}
                    }
                    $promedio = ( $promedio != '-' && $promedio > 0 ) ? $promedio/$cantProm : $promedio;
                    $cuota = ($porcCuota*$cuotaTotal)/100;
                    $idxCuota = (($venta!='-'&&$venta>0)&&($cuota!='-'&&$cuota>0))?round(($venta/$cuota)*100,2):'-';
					$proyeccionCierre = '-';
                    $proyeccionCierre = ($venta!='-'&&$venta>0)?($venta/$diaUtilActual)*$diasUtil:$proyeccionCierre;
                    $idxPNM = ($promedio>0)?($proyeccionCierre/$promedio)*100:0;
					
                    $trVentasXCategoria .= '<td style="text-align:right;">'.moneda_presellers($cuota,$igv).'</td>';
					$trVentasXCategoria .= '<td style="text-align:right;">'.moneda_presellers($venta,$igv).'</td>';
                    $trVentasXCategoria .= '<td style="text-align:right;">'.addPorcentaje($idxCuota).'</td>';
					$trVentasXCategoria .= (($proyeccionCierre!='-' && $proyeccionCierre>0) && ($promedio!='-' && $promedio>0))? ('<td style="text-align:right;">'.pacing_flecha($idxPNM).addSignoPacing($idxPNM).'</td>' ):'<td style="text-align:right;">-</td>';
                }
                else
                    $trVentasXCategoria .= '<td style="text-align:right;">'.(($venta!= '-' && $venta>0)?moneda_presellers($venta,$igv):$venta).'</td>';
            }
        }
        $trVentasXCategoria .= '</tr>';
		 }
	}
?>
	<div class="col-md-5 col-sm-12 col-xs-12">
		<div class="widget" >
			<div class="widget-head">
				<div class="pull-left">Summary (Categorias)</div>  
				<div id="" class="widget-icons pull-right">
					<a href="javascript:;" class="lk-export-excel" data-content="tabla-summary-2" data-title="Summary Categorias" ><i class="fa fa-file-excel-o"></i></a>
				</div>  
				<div class="clearfix"></div>
			</div>
			<div id="tabla-summary-2" >
			<table class="table">
				<thead>
					<tr>
						<th rowspan="3">CATEGORIAS</th>
						<th>CUOTA</th>
						<th>AVANCE AL</th>
						<th rowspan="2">AVANCE VS. CUOTA</th>
						<th rowspan="3">AVANCE VS. P3M</th>
					</tr>
					<tr>
						<th><?=$mesActual.' '.$anioActual?></th>
						<th><?=$fechaFinal?></th>
					</tr>
					<tr>
						<th>(miles S/)</th>
						<th>(miles S/)</th>
						<th><?=$fechaFinal?></th>
					</tr>
				</thead>
				<tbody>
					<?=$trVentasXCategoria?>
				</tbody>
			</table>
			</div>
		</div>
	</div>
</div>

<div class="row" >
	<div class="col-md-6 col-sm-12 col-xs-12">
		<div class="widget" >
			<div class="widget-head">
				<div class="pull-left">Summary (Top Performance)</div>  
				<div id="" class="widget-icons pull-right">
					<a href="javascript:;" class="lk-export-excel" data-content="tabla-summary-3" data-title="Summary Top Performance" ><i class="fa fa-file-excel-o"></i></a>
				</div>  
				<div class="clearfix"></div>
			</div>
			<div id="tabla-summary-3" >
				<? $total=count($performance); if($total>0){ ?>
					<table class="table">
						<thead>
							<tr>
								<th>TOPE</th>
								<!--<th>P3M</th>-->
								<th>OBJETIVO (MILES S/.)</th>
								<th>AVANCE AL<br><?=$fechaFinal?><br>(MILES S/.)</th>
								<th>% AVANCE</th>
								<th>GAP<br>(MILES S/.)</th>
								<th>PACING</th>
							</tr>
						</thead>
						<tbody>
							<?foreach($performance_final as $row){ ?>
								<?if(isset($top_performance[$row['idSucursal']])){ ?>
									<?
										$p3m = isset($top_performance[$row['idSucursal']]['p3m'])?$top_performance[$row['idSucursal']]['p3m']:0;
										$cuota = isset($top_performance[$row['idSucursal']]['cuota'])?$top_performance[$row['idSucursal']]['cuota']:0;
										$ventas = isset($top_performance[$row['idSucursal']]['ventas'])?$top_performance[$row['idSucursal']]['ventas']:0;
										
										$ventas_cuota = ($cuota>0)?round(($ventas/$cuota)*100,2):0;
										$pacing = ($p3m>0)?(($ventas/$p3m)*100)-100:0;
										$proyectado = ($ventas/$diaUtilActual)*$diasUtil;
										$proyectado_cuota = ($cuota>0)?round(($proyectado/$cuota)*100,2):0;
										$gap = $ventas - $cuota;
										$diasRestantes = $diasUtil-$diaUtilActual;
										$objetivoDiario = ($diasRestantes>0)?$gap/$diasRestantes:0;
									?>
									<tr>
										<td><?=$top_performance[$row['idSucursal']]['nombre']?></td>
										<!--<td style="text-align:right;"><?=($p3m>0)?moneda_presellers($p3m,$igv):'-';?></td>-->
										<td style="text-align:right;"><?=($cuota)?moneda_presellers($cuota,$igv):'-';?></td>
										<td style="text-align:right;"><?=($ventas)?moneda_presellers($ventas,$igv):'-';?></td>
										<td style="text-align:right;"><?=($ventas_cuota>0)?$ventas_cuota.'%':'-';?></td>
										<td style="text-align:right;"><?=($ventas>0)?moneda_presellers($gap,$igv):'-';?></td>
										<td style="text-align:right;"><?=($p3m>0)?pacing_flecha($pacing).$pacing:'-';?></td>
									</tr>
								<?}?>
							<?}}else{ ?><h4 style="text-align:center;background:#fbec88;padding:20px;border-radius:60px;">Atención!. No hay datos para Top Performance X Tope</h4> <?}?>
						</tbody>
					</table>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-12 col-xs-12">
		<div class="widget" >
			<div class="widget-head">
				<div class="pull-left">Summary (Top Offenders)</div>  
				<div id="" class="widget-icons pull-right">
					<a href="javascript:;" class="lk-export-excel" data-content="tabla-summary-4" data-title="Summary Top Offenders" ><i class="fa fa-file-excel-o"></i></a>
				</div>  
				<div class="clearfix"></div>
			</div>
			<div id="tabla-summary-4" >
			<?
				$i=0;
				$cont=0;

				foreach($ofender_final as $row){
					$id2=$row['idSucursal'];
					foreach($performance_final as $row2){
						if($row2['idSucursal'] == $id2){
							$cont++;
						}
					}
				}
			?>
			<? if($cont==0){?>
	<table class="table">
		<thead>
			<tr>
				<th>TOPE</th>
				<!--<th>P3M</th>-->
				<th>OBJETIVO (MILES S/.)</th>
				<th>AVANCE AL<br><?=$fechaFinal?><br>(MILES S/.)</th>
				<th>% AVANCE</th>
				<th>GAP<br>(MILES S/.)</th>
				<th>PACING</th>
			</tr>
		</thead>
		<tbody>
			<?$i=0;foreach($ofender_final as $row){ ?>
				<?if( $performance_final[$i]['idSucursal'] != $row['idSucursal'] ){  ?>
							<?
								$p3m = isset($top_ofender[$row['idSucursal']]['p3m'])?$top_ofender[$row['idSucursal']]['p3m']:0;
								$cuota = isset($top_ofender[$row['idSucursal']]['cuota'])?$top_ofender[$row['idSucursal']]['cuota']:0;
								$ventas = isset($top_ofender[$row['idSucursal']]['ventas'])?$top_ofender[$row['idSucursal']]['ventas']:0;
								
								$ventas_cuota = ($cuota>0)?round(($ventas/$cuota)*100,2):0;
								$pacing = ($p3m>0)?(($ventas/$p3m)*100)-100:0;
								$proyectado = ($ventas/$diaUtilActual)*$diasUtil;
								$proyectado_cuota = ($cuota>0)?round(($proyectado/$cuota)*100,2):0;
								$gap = $ventas - $cuota;
								$diasRestantes = $diasUtil-$diaUtilActual;
								$objetivoDiario = ($diasRestantes>0)?$gap/$diasRestantes:0;
							?>
							<tr>
								<td><?=$top_ofender[$row['idSucursal']]['nombre']?></td>
								<!--<td style="text-align:right;"><? //=($p3m>0)?moneda_presellers($p3m,$igv):'-';?></td>-->
								<td style="text-align:right;"><?=($cuota)?moneda_presellers($cuota,$igv):'-';?></td>
								<td style="text-align:right;"><?=($ventas)?moneda_presellers($ventas,$igv):'-';?></td>
								<td style="text-align:right;"><?=($ventas_cuota>0)?$ventas_cuota.'%':'-';?></td>
								<td style="text-align:right;"><?=($ventas>0)?moneda_presellers($gap,$igv):'-';?></td>
								<td style="text-align:right;"><?=($p3m>0)?pacing_flecha($pacing).$pacing:'-';?></td>
							</tr>

					<?} $i++; }}else{ ?><p class="p-info" style="padding: 1em" ><i class="fa fa-info-circle"></i> No se ha generado ningun resultado.</p><?}?>
				</tbody>
			</table>
			</div>
		</div>
	</div>
</div>				

	            	<!----------------------------------------------------------->
	            </div>
	        </div>
	    </div>
	</div>
<div>