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
            return 'S/. '.$valor;
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
	            <div id="idContentAuditoria" class="table-responsive">
	            	<!----------------------------------------------------------->
					
<?			
if($mensaje==''){
?>
<div class="row" >
	<div class="col-md-4 col-sm-12 col-xs-12"></div>
	<div class="col-md-4 col-sm-12 col-xs-12">
		<div class="widget" >
			<div class="widget-head">
				<div class="pull-left"></div>  
				<div id="" class="widget-icons pull-right">
					<a href="javascript:;" class="lk-export-excel" data-content="tabla-avance-resumen" data-title="Avance Ventas" ><i class="fa fa-file-excel-o"></i></a>
				</div>  
				<div class="clearfix"></div>
			</div>
			<div id="tabla-avance-resumen" class="table table-striped table-bordered nowrap" style="font-size: 90%" >
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
	<div class="col-md-4 col-sm-12 col-xs-12"></div>
</div>
<div class="row" >
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="widget" >
					<div class="widget-head">
						<div class="pull-left">Avance</div>  
						<div id="" class="widget-icons pull-right">
							<a href="javascript:;" class="lk-export-excel" data-content="tabla-avance" data-title="Avance Ventas" ><i class="fa fa-file-excel-o"></i></a>
						</div>  
						<div class="clearfix"></div>
					</div>
					<div id="tabla-avance" >
<table class="table table-striped table-bordered nowrap" style="font-size: 90%" ><!-- -->
	<thead>
		<tr>
			<th></th>
			<th>P3M</th>
			<th>OBJ	VENTA</th>
			<th>VENTA</th>
			<th>Idx VENTA vs OBJ</th>
			<th>Idx VENTA vs P3M</th>
			<th>PROY</th>
			<th>Idx PROY vs OBJ</th>
			<th>GAP</th>
			<th>OBJ DIARIO</th>
		</tr>
	</thead>
	<tbody>
		<?foreach($unidades as $ix_u => $row_u){ ?>
			<tr>
				<?
					$p3m = isset($row_u['p3m'])?$row_u['p3m']:0;
					$cuota = isset($row_u['cuota'])?$row_u['cuota']:0;
					$ventas = isset($row_u['ventas'])?$row_u['ventas']:0;
					$p3m_unidad=0;
					if(isset($ciudades[$ix_u] )){ foreach($ciudades[$ix_u] as $ix_c => $row_c){
						if(isset($plazas[$ix_u][$ix_c] )){ foreach($plazas[$ix_u][$ix_c] as $ix_p => $row_p){
							if(isset($topes[$ix_u][$ix_c][$ix_p] )){ foreach($topes[$ix_u][$ix_c][$ix_p] as $ix_t => $row_t){ 
								if(isset($usuarios[$ix_u][$ix_c][$ix_p][$ix_t] )){ foreach($usuarios[$ix_u][$ix_c][$ix_p][$ix_t] as $ix_us => $row_us){
									if(isset($row_us['nombre'])){
										$p3m = isset($row_us['p3m'])?$row_us['p3m']:0;
										$p3m_unidad = $p3m_unidad + $p3m;
									}
								}}
							}}
						}}
					}}
						
					$ventas_cuota = ($cuota>0)?round(($ventas/$cuota)*100,2):0;
					$ventas_p3m = ($p3m_unidad>0)? round(($ventas/$p3m_unidad)*100,2):0;
					$proyectado = ($ventas/$diaUtilActual)*$diasUtil;
					$proyectado_cuota = ($cuota>0)?round(($proyectado/$cuota)*100,2):0;
					$gap = $ventas - $cuota;
					$diasRestantes = $diasUtil-$diaUtilActual;
					$objetivoDiario = ($diasRestantes>0)? ($gap * -1)/$diasRestantes:0;
				?>
				<td style="background-color: #0856a4; color: #FFFFFF" ><?=$row_u['nombre']?></td>
				<td style="background-color: #0856a4; color: #FFFFFF;text-align:right;"><?=($p3m_unidad>0)?moneda_presellers($p3m_unidad,$igv):'-';?></td>
				<td style="background-color: #0856a4; color: #FFFFFF;text-align:right;"><?=($cuota)?moneda_presellers($cuota,$igv):'-';?></td>
				<td style="background-color: #0856a4; color: #FFFFFF;text-align:right;"><?=($ventas)?moneda_presellers($ventas,$igv):'-';?></td>
				<td style="background-color: #0856a4; color: #FFFFFF;text-align:right;"><?=($ventas_cuota>0)?$ventas_cuota.' %':'-'; ?></td>
				<td style="background-color: #0856a4; color: #FFFFFF;text-align:right;"><?=($ventas_p3m>0)?$ventas_p3m.' %':'-'; ?></td>
				<td style="background-color: #0856a4; color: #FFFFFF;text-align:right;"><?=($ventas>0)?moneda_presellers($proyectado,$igv):'-'; ?></td>
				<td style="background-color: #0856a4; color: #FFFFFF;text-align:right;"><?=($proyectado_cuota>0)?$proyectado_cuota.' %':'-'; ?></td>
				<td style="background-color: #0856a4; color: #FFFFFF;text-align:right;"><?=($ventas>0)?moneda_presellers($gap,$igv):'-'; ?></td>
				<td style="background-color: #0856a4; color: #FFFFFF;text-align:right;"><?=($objetivoDiario>0)?moneda_presellers($objetivoDiario,$igv):'-'; ?></td>
			</tr>
			<?if(isset($ciudades[$ix_u] )){ foreach($ciudades[$ix_u] as $ix_c => $row_c){ ?>
				<tr>
					<?
						$p3m = isset($row_c['p3m'])?$row_c['p3m']:0;
						$cuota = isset($row_c['cuota'])?$row_c['cuota']:0;
						$ventas = isset($row_c['ventas'])?$row_c['ventas']:0;
						
						$p3m_ciudad=0;
						if(isset($plazas[$ix_u][$ix_c] )){ foreach($plazas[$ix_u][$ix_c] as $ix_p => $row_p){
							if(isset($topes[$ix_u][$ix_c][$ix_p] )){ foreach($topes[$ix_u][$ix_c][$ix_p] as $ix_t => $row_t){ 
								if(isset($usuarios[$ix_u][$ix_c][$ix_p][$ix_t] )){ foreach($usuarios[$ix_u][$ix_c][$ix_p][$ix_t] as $ix_us => $row_us){
									if(isset($row_us['nombre'])){
										$p3m = isset($row_us['p3m'])?$row_us['p3m']:0;
										$p3m_ciudad = $p3m_ciudad + $p3m;
									}
								}}
							}}
						}}
						
						$ventas_cuota = ($cuota>0)?round(($ventas/$cuota)*100,2):0;
						$ventas_p3m = ($p3m_ciudad>0)?($ventas/$p3m_ciudad)*100:0;
						$proyectado = ($ventas/$diaUtilActual)*$diasUtil;
						$proyectado_cuota = ($cuota>0)?round(($proyectado/$cuota)*100,2):0;
						$gap = $ventas - $cuota;
						$diasRestantes = $diasUtil-$diaUtilActual;
						$objetivoDiario = ($diasRestantes>0)? ($gap * -1)/$diasRestantes:0;
					?>
					<td style="background-color: #0e6ecd; color: #FFFFFF" ><?=$row_c['nombre']?></td>
					<td style="background-color: #0e6ecd; color: #FFFFFF;text-align:right;"><?=($p3m_ciudad>0)?moneda_presellers($p3m_ciudad,$igv):'-';?></td>
					<td style="background-color: #0e6ecd; color: #FFFFFF;text-align:right;"><?=($cuota)?moneda_presellers($cuota,$igv):'-';?></td>
					<td style="background-color: #0e6ecd; color: #FFFFFF;text-align:right;"><?=($ventas)?moneda_presellers($ventas,$igv):'-';?></td>
					<td style="background-color: #0e6ecd; color: #FFFFFF;text-align:right;"><?=($ventas_cuota>0)?$ventas_cuota.' %':'-'; ?></td>
					<td style="background-color: #0e6ecd; color: #FFFFFF;text-align:right;"><?=($ventas_p3m>0)?$ventas_p3m.' %':'-'; ?></td>
					<td style="background-color: #0e6ecd; color: #FFFFFF;text-align:right;"><?=($ventas>0)?moneda_presellers($proyectado,$igv):'-'; ?></td>
					<td style="background-color: #0e6ecd; color: #FFFFFF;text-align:right;"><?=($proyectado_cuota>0)?$proyectado_cuota.' %':'-'; ?></td>
					<td style="background-color: #0e6ecd; color: #FFFFFF;text-align:right;"><?=($ventas>0)?moneda_presellers($gap,$igv):'-'; ?></td>
					<td style="background-color: #0e6ecd; color: #FFFFFF;text-align:right;"><?=($objetivoDiario>0)?moneda_presellers($objetivoDiario,$igv):'-'; ?></td>
				</tr>
				<?if(isset($plazas[$ix_u][$ix_c] )){ foreach($plazas[$ix_u][$ix_c] as $ix_p => $row_p){ ?>
					<?
						$p3m = isset($row_p['p3m'])?$row_p['p3m']:0;
						$cuota = isset($row_p['cuota'])?$row_p['cuota']:0;
						$ventas = isset($row_p['ventas'])?$row_p['ventas']:0;
						$p3m_plaza=0;
						if(isset($topes[$ix_u][$ix_c][$ix_p] )){ foreach($topes[$ix_u][$ix_c][$ix_p] as $ix_t => $row_t){ 
							if(isset($usuarios[$ix_u][$ix_c][$ix_p][$ix_t] )){ foreach($usuarios[$ix_u][$ix_c][$ix_p][$ix_t] as $ix_us => $row_us){
								if(isset($row_us['nombre'])){
									$p3m = isset($row_us['p3m'])?$row_us['p3m']:0;
									$p3m_plaza = $p3m_plaza + $p3m;
								}
							}}
						}}
							
						$ventas_cuota = ($cuota>0)? round(($ventas/$cuota)*100,2):0;
						$ventas_p3m = ($p3m_plaza>0)?round(($ventas/$p3m_plaza)*100,2):0;
						$proyectado = ($ventas/$diaUtilActual)*$diasUtil;
						$proyectado_cuota = ($cuota>0)?round(($proyectado/$cuota)*100,2):0;
						$gap = $ventas - $cuota;
						$diasRestantes = $diasUtil-$diaUtilActual;
						$objetivoDiario = ($diasRestantes>0)?($gap * -1)/$diasRestantes:0;
					?>
					<tr>
						<td style="background-color: #1789fb; color: #FFFFFF" ><?=$row_p['nombre']?></td>
						<td style="background-color: #1789fb; color: #FFFFFF;text-align:right;" ><?=($p3m_plaza>0)?moneda_presellers($p3m_plaza,$igv):'-';?></td>
						<td style="background-color: #1789fb; color: #FFFFFF;text-align:right;" ><?=($cuota)?moneda_presellers($cuota,$igv):'-';?></td>
						<td style="background-color: #1789fb; color: #FFFFFF;text-align:right;" ><?=($ventas)?moneda_presellers($ventas,$igv):'-';?></td>
						<td style="background-color: #1789fb; color: #FFFFFF;text-align:right;" ><?=($ventas_cuota>0)?$ventas_cuota.' %':'-'; ?></td>
						<td style="background-color: #1789fb; color: #FFFFFF;text-align:right;" ><?=($ventas_p3m>0)?$ventas_p3m.' %':'-'; ?></td>
						<td style="background-color: #1789fb; color: #FFFFFF;text-align:right;"><?=($ventas>0)?moneda_presellers($proyectado,$igv):'-'; ?></td>
						<td style="background-color: #1789fb; color: #FFFFFF;text-align:right;" ><?=($proyectado_cuota>0)?$proyectado_cuota.' %':'-'; ?></td>
						<td style="background-color: #1789fb; color: #FFFFFF;text-align:right;" ><?=($ventas>0)?moneda_presellers($gap,$igv):'-'; ?></td>
						<td style="background-color: #1789fb; color: #FFFFFF;text-align:right;" ><?=($objetivoDiario>0)?moneda_presellers($objetivoDiario,$igv):'-'; ?></td>
					</tr>
					<?if(isset($topes[$ix_u][$ix_c][$ix_p] )){ foreach($topes[$ix_u][$ix_c][$ix_p] as $ix_t => $row_t){ ?>
						<?
							if(isset($row_t['nombre'])){
							$p3m = isset($row_t['p3m'])?$row_t['p3m']:0;
							$cuota = isset($row_t['cuota'])?$row_t['cuota']:0;
							$ventas = isset($row_t['ventas'])?$row_t['ventas']:0;
							
							$p3m_tope=0;
							if(isset($usuarios[$ix_u][$ix_c][$ix_p][$ix_t] )){ foreach($usuarios[$ix_u][$ix_c][$ix_p][$ix_t] as $ix_us => $row_us){
								if(isset($row_us['nombre'])){
									$p3m = isset($row_us['p3m'])?$row_us['p3m']:0;
									$p3m_tope = $p3m_tope + $p3m;
								}
							}}
							
							$ventas_cuota = ($cuota>0)? round(($ventas/$cuota)*100,2):0;
							$ventas_p3m = ($p3m_tope>0)?round(($ventas/$p3m_tope)*100,2):0;
							$proyectado = ($ventas/$diaUtilActual)*$diasUtil;
							$proyectado_cuota = ($cuota>0)?round(($proyectado/$cuota)*100,2):0;
							$gap = $ventas - $cuota;
							$objetivo_diario = $ventas - $cuota;
							$diasRestantes = $diasUtil-$diaUtilActual;
							$objetivoDiario = ($diasRestantes>0)? ($gap * -1)/$diasRestantes:0;
						?>
						<tr>	
							
							<td style="background-color: #c1eaf4;" ><?=$row_t['nombre']?></td>
							<td style="background-color: #c1eaf4;text-align:right;" ><?=($p3m_tope>0)?moneda_presellers($p3m_tope,$igv):'-';?></td>
							<td style="background-color: #c1eaf4;text-align:right;" ><?=($cuota)?moneda_presellers($cuota,$igv):'-';?></td>
							<td style="background-color: #c1eaf4;text-align:right;" ><?=($ventas)?moneda_presellers($ventas,$igv):'-';?></td>
							<td style="background-color: #c1eaf4;text-align:right;" ><?=($ventas_cuota>0)?$ventas_cuota.' %':'-'; ?></td>
							<td style="background-color: #c1eaf4;text-align:right;" ><?=($ventas_p3m>0)?$ventas_p3m.' %':'-'; ?></td>
							<td style="background-color: #c1eaf4;text-align:right;" ><?=($ventas>0)?moneda_presellers($proyectado,$igv):'-'; ?></td>
							<td style="background-color: #c1eaf4;text-align:right;" ><?=($proyectado_cuota>0)?$proyectado_cuota.' %':'-'; ?></td>
							<td style="background-color: #c1eaf4;text-align:right;" ><?=($ventas>0)?moneda_presellers($gap,$igv):'-'; ?></td>
							<td style="background-color: #c1eaf4;text-align:right;" ><?=($objetivoDiario>0)?moneda_presellers($objetivoDiario,$igv):'-'; ?></td>
						</tr>
						<? } ?>
						<? if(isset($usuarios[$ix_u][$ix_c][$ix_p][$ix_t] )){ foreach($usuarios[$ix_u][$ix_c][$ix_p][$ix_t] as $ix_us => $row_us){
								if(isset($row_us['nombre'])){
									$p3m = isset($row_us['p3m'])?$row_us['p3m']:0;
									$cuota = isset($row_us['cuota'])?$row_us['cuota']:0;
									$ventas = isset($row_us['ventas'])?$row_us['ventas']:0;
									
									$ventas_cuota = ($cuota>0)?round(($ventas/$cuota)*100,2):0;
									$ventas_p3m = ($p3m>0)?round(($ventas/$p3m)*100,2):0;
									$proyectado = ($ventas/$diaUtilActual)*$diasUtil;
									$proyectado_cuota = ($cuota>0)?round(($proyectado/$cuota)*100,2):0;
									$gap = $ventas - $cuota;
									$diasRestantes = $diasUtil-$diaUtilActual;
									$objetivoDiario = ($diasRestantes>0)? ( $gap * (-1) )/$diasRestantes:0;
						?>
							<tr>
								<?$nombreH=$flagHide=='1'?'RUTA '.$row_us['idUsuario']:$row_us['nombre'];?>
								<td><?=$nombreH?></td>
								<td style="text-align:right;"><?=($p3m>0)?moneda_presellers($p3m,$igv):'-';?></td>
								<td style="text-align:right;"><?=($cuota)?moneda_presellers($cuota,$igv):'-';?></td>
								<td style="text-align:right;"><?=($ventas)?moneda_presellers($ventas,$igv):'-';?></td>
								<td style="text-align:right;"><?=($ventas_cuota>0)?$ventas_cuota.' %':'-'; ?></td>
								<td style="text-align:right;"><?=($ventas_p3m>0)?$ventas_p3m.' %':'-'; ?></td>
								<td style="text-align:right;"><?=($ventas>0)?moneda_presellers($proyectado,$igv):'-'; ?></td>
								<td style="text-align:right;"><?=($proyectado_cuota>0)?$proyectado_cuota.' %':'-'; ?></td>
								<td style="text-align:right;"><?=($ventas>0)?moneda_presellers($gap,$igv):'-'; ?></td>
								<td style="text-align:right;"><?=($objetivoDiario>0)?moneda_presellers($objetivoDiario,$igv):'-'; ?></td><!---->
							</tr>
						<?}}}?>
					<?}}?>
				<?}}?>
			<?}}?>
		<?}?>
	</tbody>
</table>
					</div>
				</div>
			</div>
</div>
	<? } else{ ?>
		<h1><?=$mensaje?></h1>
	<? } ?>
					
	            	<!----------------------------------------------------------->
	            </div>
	        </div>
	    </div>
	</div>
<div>