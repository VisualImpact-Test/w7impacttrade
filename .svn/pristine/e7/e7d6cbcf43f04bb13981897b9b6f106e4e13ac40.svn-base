<?
	//$flagHide=$this->session->userdata('flagHide'); 
	$igv_ = $igv;
    function moneda_presellers($valor, $dec = TOTAL_DECIMALES)
    {
        //return $valor;
        if( is_string($valor) ) return $valor;
        else
        {
            $valor = number_format($valor, TOTAL_DECIMALES, '.', ',');
            return 'S/. '.$valor;
        }
    }

?>	

<div class="col-lg-12">
	    <div class="main-card mb-3 card">
	    	<div class="card-header">
	    		<i class="fas fa-list-alt fa-lg"></i>&nbspDetalle
	    	</div>
	        <div class="card-body">
	            <div id="idContentAuditoria" class="table-responsive">
	            	<!----------------------------------------------------------->
					
				
<table id="data-table" class="table table-striped table-bordered nowrap" style="font-size: 90%" >
	<thead>
		<tr>
			<th >PLAZA</th>	
			<th >ID VISUAL</th>
			<th >CÓDIGO P&G</th>
			<th >TIPO DE CLIENTE</th>
			<th >RAZÓN SOCIAL</th>
			<th >NOMBRE COMERCIAL</th>
			<th >CUOTA</th>
			<th >AVANCE (S/.)</th>
			<th >% AVANCE</th>
			<th >GAP</th>
			<th >EVALUACION<br /><sup>CUOTA TOTAL VS VENTA TOTAL</sup></th>
			<th >ESCALA ALCANZADA</th>
			<th>PAGO CUOTA</th>
			<th >% VISIBILIDAD</th>
			<?foreach($tipo_surte as $ix_ts => $row_ts){?>
				<?foreach($surte[$ix_ts] as $ix_s => $row_s){?>
					<th><?=$row_s['nombre'];?></th>
				<?}?>
			<?}?>
			<?foreach($tipo_surte as $ix_ts => $row_ts){?>
				<th><?=$row_ts;?></th>
			<?}?>
			<th>Total Surtido</th>
			<th>Gana</th>
		</tr>
	</thead>
	<tbody>
		<?foreach($data_surte as $ix_sd => $row_sd){?>
			<tr>
				<td><?=empty($row_sd['plaza'])? '<center>-</center>' : $row_sd['plaza'];?></td>
				<td><?=empty($row_sd['cod_visual'])? '<center>-</center>' : $row_sd['cod_visual'];?></td>
				<td><?=empty($row_sd['cod_pg'])? '<center>-</center>' : $row_sd['cod_pg'];?></td>
				<td><?=empty($row_sd['tipo_cliente'])? '<center>-</center>' : $row_sd['tipo_cliente'];?></td>
				<td><?=empty($row_sd['cliente'])? '<center>-</center>' : $row_sd['cliente'];?></td>
				<td><?=empty($row_sd['sucursal'])? '<center>-</center>' : $row_sd['sucursal'];?></td>
				<?
					$cuota = !empty($row_sd['cuota'])? $row_sd['cuota']: '';///1000
					$visibilidad = !empty($row_sd['visibilidad'])? $row_sd['visibilidad']: '';///1000
					$ventas = isset($row_sd['ventas'])? array_sum($row_sd['ventas']) : '';///1000
					$por = (is_numeric($cuota) && is_numeric($ventas))? round(($ventas/$cuota)*100,2) : '';
					$gap = (is_numeric($cuota) && is_numeric($ventas))? $ventas - $cuota : '';
					if($gap>0) $color_gap = '#15ce5f'; else $color_gap = '#e91c30';
				?>
				<td style="text-align: right !important" ><?=is_numeric($cuota)? moneda_presellers($cuota, $igv_ ) : '<center>-</center>';?></td>
				<td style="text-align: right !important" ><?=is_numeric($ventas)? moneda_presellers($ventas, $igv_) : '<center>-</center>';?></td>
				<td style="text-align: right !important" ><?=is_numeric($por)? $por.'%' : '<center>-</center>';?></td>
				<td style="text-align: right !important" ><?=is_numeric($gap)? moneda_presellers($gap, $igv_): '<center>-</center>';//'<span  style="color:'.$color_gap.'" >'..'</span>' ?></td>
				
				<!--
					=SI(I15>=(H15*0.97),SI(I15>200000,2.2%,SI(I15>100000,2%,SI(I15>40000,1.7%,SI(I15>2000,1.2%,0)))),0)
				-->
				<?
					$evaluacion = '';
					$escala_alcanzada = '';
					$pago_cuota = '';
					if(is_numeric($ventas)){
						if($ventas > 0 ){
							$row_select = array();
							$existe = false;
							foreach($data_conf as $ix_cf => $row_cf){
								
								if( ($ventas > $ix_cf ) && !$existe ){
									$row_select = $row_cf;
									$existe = true;
								}
							}
							if(!empty($row_select)){
								$por_venta = $row_select['porcentajeVenta'];
								$evaluacion = 0;
								$escala_alcanzada = 0;
								$pago_cuota = 0;
								if( $ventas >= $cuota * $por_venta) {
									$evaluacion = 1;
									$escala_alcanzada = $row_select['porcentajeEscala'];
									$pago_cuota = $ventas * $escala_alcanzada;
									//=SI(L127=1,I127*M127,0)
									
								}
								//$escala_alcanzada = montoEscala;
								//$pago_cuota = porcentajeEscala;
							} else {
								$evaluacion = 0;
								$escala_alcanzada = 0;
								$pago_cuota = 0;
							}
						} else {
							$evaluacion = 0;
							$escala_alcanzada = 0;
							$pago_cuota = 0;
						}
					}					
				?>
				<td style="text-align: right !important" ><?=is_numeric($evaluacion)? (($evaluacion >0)?  '<i class="fa fa-exclamation" ></i> NO' : '<i class="fa fa-check" ></i> SI'  ): '<center>-</center>';?></td>
				<td style="text-align: right !important" ><?=is_numeric($escala_alcanzada)? round($escala_alcanzada * 100,2).'%' : '<center>-</center>';//?></td>
				<td style="text-align: right !important" ><?=is_numeric($pago_cuota)? moneda_presellers($pago_cuota, $igv_) : '<center>-</center>';//?></td>
				<td style="text-align: right !important" ><?=is_numeric($visibilidad)? round($visibilidad,2).'%' : '<center>-</center>';?></td>
				<?$array_tipo_surte = array();?>
				<?foreach($tipo_surte as $ix_ts => $row_ts){?>
					<? $array_tipo_surte[$ix_ts] = array(); ?>
					<?foreach($surte[$ix_ts] as $ix_s => $row_s){//print_r($row_s['cantidad']);?>
						<?	//print_r(isset($data_surte[$ix_sd]['cantidad'][$ix_ts][$ix_s])?$data_surte[$ix_sd]['cantidad'][$ix_ts][$ix_s]:'vacio');
							$cant_actual = isset($data_surte[$ix_sd]['cantidad'][$ix_ts][$ix_s])? $data_surte[$ix_sd]['cantidad'][$ix_ts][$ix_s] : 0;
							$existe_surte = $cant_actual >= $row_s['cantidad']? 1 : 0;
							array_push($array_tipo_surte[$ix_ts],$existe_surte);
						?>
						<td style="text-align: right !important" ><?=$existe_surte;?></td>
					<?}?>
				<?}?>
				<?$total_surte=0;?>
				<?foreach($tipo_surte as $ix_ts => $row_ts){?>
					<?$total_surte = $total_surte + array_sum($array_tipo_surte[$ix_ts]);?>
					<td style="text-align: right !important" ><?=array_sum($array_tipo_surte[$ix_ts]);?></td>
				<?}?>
				<td style="text-align: right !important" ><?=$total_surte;?></td>
				<?
					$monto_gana = 0;
					if(isset($array_tipo_surte[2])){
						if($total_surte >= $valor1 && array_sum($array_tipo_surte[2]) >= $valor2  ){
							$monto_gana = $monto_gana_surte; 
						}
					}
					
				?>
				<td style="text-align: right !important" ><?=moneda_presellers($monto_gana, $igv_);?></td>
			</tr>
		<?}?>
	</tbody>
</table>

<div id="tabla-secreta" style="display: none" class="table table-striped table-bordered nowrap" style="font-size: 90%">
<table class="table" >
	<thead>
		<tr>
			<th >PLAZA</th>	
			<th >ID VISUAL</th>
			<th >CÓDIGO P&G</th>
			<th >TIPO DE CLIENTE</th>
			<th >RAZÓN SOCIAL</th>
			<th >NOMBRE COMERCIAL</th>
			<th >CUOTA</th>
			<th >AVANCE (S/.)</th>
			<th >% AVANCE</th>
			<th >GAP</th>
			<th >EVALUACION<br /><sup>CUOTA TOTAL VS VENTA TOTAL</sup></th>
			<th >ESCALA ALCANZADA</th>
			<th>PAGO CUOTA</th>
			<th >% VISIBILIDAD</th>
			<?foreach($tipo_surte as $ix_ts => $row_ts){?>
				<?foreach($surte[$ix_ts] as $ix_s => $row_s){?>
					<th><?=$row_s;?></th>
				<?}?>
			<?}?>
			<?foreach($tipo_surte as $ix_ts => $row_ts){?>
				<th><?=$row_ts;?></th>
			<?}?>
			<th>Total Surtido</th>
			<th>Gana</th>
		</tr>
	</thead>
	<tbody>
		<?foreach($data_surte as $ix_sd => $row_sd){?>
			<tr>
				<td><?=empty($row_sd['plaza'])? '<center>-</center>' : $row_sd['plaza'];?></td>
				<td><?=empty($row_sd['cod_visual'])? '<center>-</center>' : $row_sd['cod_visual'];?></td>
				<td><?=empty($row_sd['cod_pg'])? '<center>-</center>' : $row_sd['cod_pg'];?></td>
				<td><?=empty($row_sd['tipo_cliente'])? '<center>-</center>' : $row_sd['tipo_cliente'];?></td>
				<td><?=empty($row_sd['cliente'])? '<center>-</center>' : $row_sd['cliente'];?></td>
				<td><?=empty($row_sd['sucursal'])? '<center>-</center>' : $row_sd['sucursal'];?></td>
				<?
					$cuota = !empty($row_sd['cuota'])? $row_sd['cuota']: '';///1000
					$visibilidad = !empty($row_sd['visibilidad'])? $row_sd['visibilidad']: '';///1000
					$ventas = isset($row_sd['ventas'])? array_sum($row_sd['ventas']) : '';///1000
					$por = (is_numeric($cuota) && is_numeric($ventas))? round(($ventas/$cuota)*100,2) : '';
					$gap = (is_numeric($cuota) && is_numeric($ventas))? $ventas - $cuota : '';
					if($gap>0) $color_gap = '#15ce5f'; else $color_gap = '#e91c30';
				?>
				<td style="text-align: right !important" ><?=is_numeric($cuota)? moneda_presellers($cuota, $igv_) : '<center>-</center>';?></td>
				<td style="text-align: right !important" ><?=is_numeric($ventas)? moneda_presellers($ventas, $igv_) : '<center>-</center>';?></td>
				<td style="text-align: right !important" ><?=is_numeric($por)? $por.'%' : '<center>-</center>';?></td>
				<td style="text-align: right !important" ><?=is_numeric($gap)? moneda_presellers($gap, $igv_): '<center>-</center>';//'<span  style="color:'.$color_gap.'" >'..'</span>' ?></td>
				
				<!--
					=SI(I15>=(H15*0.97),SI(I15>200000,2.2%,SI(I15>100000,2%,SI(I15>40000,1.7%,SI(I15>2000,1.2%,0)))),0)
				-->
				<?
					$evaluacion = '';
					$escala_alcanzada = '';
					$pago_cuota = '';
					if(is_numeric($ventas)){
						if($ventas > 0 ){
							$row_select = array();
							$existe = false;
							foreach($data_conf as $ix_cf => $row_cf){
								
								if( ($ventas > $ix_cf ) && !$existe ){
									$row_select = $row_cf;
									$existe = true;
								}
							}
							if(!empty($row_select)){
								$por_venta = $row_select['porcentajeVenta'];
								$evaluacion = 0;
								$escala_alcanzada = 0;
								$pago_cuota = 0;
								if( $ventas >= $cuota * $por_venta) {
									$evaluacion = 1;
									$escala_alcanzada = $row_select['porcentajeEscala'];
									$pago_cuota = $ventas * $escala_alcanzada;
									//=SI(L127=1,I127*M127,0)
									
								}
								//$escala_alcanzada = montoEscala;
								//$pago_cuota = porcentajeEscala;
							} else {
								$evaluacion = 0;
								$escala_alcanzada = 0;
								$pago_cuota = 0;
							}
						} else {
							$evaluacion = 0;
							$escala_alcanzada = 0;
							$pago_cuota = 0;
						}
					}					
				?>
				<td style="text-align: right !important" ><?=is_numeric($evaluacion)? (($evaluacion >0)?  '<i class="fa fa-exclamation" ></i> NO' : '<i class="fa fa-check" ></i> SI'  ): '<center>-</center>';?></td>
				<td style="text-align: right !important" ><?=is_numeric($escala_alcanzada)? round($escala_alcanzada * 100,2).'%' : '<center>-</center>';//?></td>
				<td style="text-align: right !important" ><?=is_numeric($pago_cuota)? moneda_presellers($pago_cuota, $igv_) : '<center>-</center>';//?></td>
				<td style="text-align: right !important" ><?=is_numeric($visibilidad)? round($visibilidad,2).'%' : '<center>-</center>';?></td>
				<?$array_tipo_surte = array();?>
				<?foreach($tipo_surte as $ix_ts => $row_ts){?>
					<? $array_tipo_surte[$ix_ts] = array(); ?>
					<?foreach($surte[$ix_ts] as $ix_s => $row_s){?>
						<?
							$existe_surte = isset($data_surte[$ix_sd]['surte'][$ix_ts][$ix_s])? 1 : 0;
							array_push($array_tipo_surte[$ix_ts],$existe_surte);
						?>
						<td style="text-align: right !important" ><?=$existe_surte;?></td>
					<?}?>
				<?}?>
				<?$total_surte=0;?>
				<?foreach($tipo_surte as $ix_ts => $row_ts){?>
					<?$total_surte = $total_surte + array_sum($array_tipo_surte[$ix_ts]);?>
					<td style="text-align: right !important" ><?=array_sum($array_tipo_surte[$ix_ts]);?></td>
				<?}?>
				<td style="text-align: right !important" ><?=$total_surte;?></td>
				<?
					$monto_gana = 0;
					if($total_surte >= $valor1 && array_sum($array_tipo_surte[2]) >= $valor2  ){
						$monto_gana = $monto_gana_surte; 
					}
				?>
				<td style="text-align: right !important" ><?=moneda_presellers($monto_gana, $igv_);?></td>
			</tr>
		<?}?>
	</tbody>
</table>
</div> 
					
	            	<!----------------------------------------------------------->
	            </div>
	        </div>
	    </div>
	</div>
<div>