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
.panel-heading{
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

.table_pres {
    border-spacing: 5px !important;
    border-collapse: collapse !important;
    white-space: nowrap !important;
    margin-bottom: 0 !important;
	width: 100% !important;
    max-width: 100% !important;
	font-size:10px !important;
}
.table_pres th {
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

</style>
<div class="col-lg-12">
	    <div class="main-card mb-3 card">
	    	<div class="card-header">
	    		<i class="fas fa-list-alt fa-lg"></i>&nbspDetalle
	    	</div>
	        <div class="card-body">
	            <div id="idContentAuditoria" class="table-responsive">
	            	<!----------------------------------------------------------->
<style>
	.col-td{
		background-color:#505050;
		color:#ffffff;
		font-weight:bold;
	}
	
	td,th { 
		padding: 2px;
	}
	
	th{
		text-align:center;
	}
	
</style>

<div class="row">

	<div class="col-md-6">
			<div class="widget-content" style="overflow-y: auto !important; margin: 1em" >
				<table class="table table-striped table-bordered nowrap table_pres" style="font-size: 90%" >
					<thead style="background:#002856; color:#ffffff;">
						<tr>
							<th >PLAZA</th>
							<th >PRESELLER</th>
							<th >T. LOMITO</br> POINTS</th>
							<th >TARGET </br> 10%</th>
							<th >%COB. </br> LOMITO</th>
							<th >TARGET </br> 20%</th>
							<th >%COB. </br> LOMITO</th>
						</tr>
					</thead>
					<tbody>
						<?$data_lomito = '';
						foreach($resumen as $ix_r => $row_r){
							$i=0;$total_surte = 0;$c_cuota10=0;$c_cuota20=0;$t_cuota10=0;$t_cuota20=0;
							foreach($row_r as $ix => $row){
								$nombreH=$flagHide=='1'?'RUTA '.$row->idUsuario:$row->usuario;
								?>
								<tr >		
									<?$cob1 = (is_numeric($row->total_surte) && is_numeric($row->cuota10))? round(($row->total_surte/$row->cuota10)*100,2) : '';
									$cob2 = (is_numeric($row->total_surte) && is_numeric($row->cuota20))? round(($row->total_surte/$row->cuota20)*100,2) : '';
									//$color_bg1= is_numeric($cob1) && $cob1>=100?'#15ce5f':'#e43a4a';
									$color_bg1= is_numeric($cob1)? ($cob1>=100?'#15ce5f':'#e43a4a'):'#fff';
									$color_bg2= is_numeric($cob2)? ($cob2>=100?'#15ce5f':'#e43a4a'):'#fff';?>
									<?if($i==0){?><td class="col-td" rowspan="<?=$plazas[$ix_r]?>"><?=$row->plaza?></td><?}?>
									<td><?=$nombreH?></td>
									<td class="text-center"><?=!empty($row->total_surte)?$row->total_surte:'0'?></td>
									<td class="text-right"><?=!empty($row->cuota10)?  $row->cuota10 : '<center>-</center>';?></td>	
									<td class="text-right" style="background-color:<?=$color_bg1?>; font-weight:bold;"><?=is_numeric($cob1)? $cob1.'%' : '<center>-</center>';?></td>
									<td class="text-right"><?=!empty($row->cuota20)?  $row->cuota20 : '<center>-</center>';?></td>	
									<td class="text-right" style="background-color:<?=$color_bg2?>; font-weight:bold;"><?=is_numeric($cob2)? $cob2.'%' : '<center>-</center>';?></td>
								</tr>
								<?$total_surte += $row->total_surte;
								if(is_numeric($row->cuota10)){$t_cuota10+=$row->cuota10;$c_cuota10++;}
								if(is_numeric($row->cuota20)){$t_cuota20+=$row->cuota20;$c_cuota20++;}
								$data['resultados'][$row->plaza]['surte'] = $total_surte/($i+1);
								$cuota_promedio1= $c_cuota10>0?$t_cuota10/$c_cuota10:$t_cuota10;
								$cuota_promedio2= $c_cuota20>0?$t_cuota20/$c_cuota20:$t_cuota20;
								$data['resultados'][$row->plaza]['cuota10'] = $cuota_promedio1;
								$data['resultados'][$row->plaza]['cuota20'] = $cuota_promedio2;
								//$data_lomito.="['".$row->plaza."','".$total_surte/($i+1)."','".$cuota_promedio1."','".$cuota_promedio2."'],";
								?>
							
							<?$i++;}
						}
						//print_r($data['resultados']);
						foreach($data['resultados'] as $ix => $row){
								$data_lomito.="['".$ix."','".$row['surte']."','".$row['cuota10']."','".$row['cuota20']."'],";
						}
					
						//print_r($data_lomito);?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-md-6" style="height:100%" >
			<div class="panel panel-default">
				<div class="panel-heading">
					RESUMEN POR PLAZA
					<div class="widget-icons pull-right">
					</div>  
					<div class="clearfix"></div>
				</div>
				<div class="panel-body" style="min-height: 100px; padding: 20px !important;">
					<div id="lomito2" style="height:400px; "></div>
				</div>
			</div>
		</div>

	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="widget" >
			<div class="widget-head">
				<div id="" class="widget-icons pull-right">
					<a href="javascript:;" class="lk-export-excel" data-content="tabla-secreta" data-title="Reportes" ><a>
				</div>  
				<div class="clearfix"></div>
			</div>
			<div id="whls_reportes_tabla"  >
				<table id="data-table"  class="table table-striped table-bordered nowrap" style="font-size: 90%">
					<thead>
						<tr>
							<th >PLAZA</th>
							<th >USUARIO</th>
							<th >ID VISUAL</th>
							<th >CLIENTE</th>
							<th >AVANCE (S/.)</th>
							<?foreach($tipo_surte as $ix_ts => $row_ts){?>
								<?foreach($surte[$ix_ts] as $ix_s => $row_s){?>
									<th><?=$row_s;?></th>
								<?}?>
							<?}?>
							<th class = "text-center">Total Lomitos</br>Alcanzados</th>
							<th>LOMITOS</br> TOTALES</th>
							<th>IDX</th>
						</tr>
					</thead>
					<tbody>
						<?foreach($data_surte as $ix_sd => $row_sd){
							foreach($row_sd as $ix => $row){
								$nombreH=$flagHide=='1'?'RUTA '.$row['idUsuario']:$row['usuario'];
								?>
							<tr>
								<td><?=empty($row['plaza'])? '<center>-</center>' : $row['plaza'];?></td>
								<td><?=empty($row['usuario'])? '<center>-</center>' : $nombreH;?></td>		
								<td><?=empty($row['idSucursal'])? '<center>-</center>' : $row['idSucursal'];?></td>		
								<td><?=empty($row['sucursal'])? '<center>-</center>' : $row['sucursal'];?></td>		
								<td class="text-right"><?=is_numeric($row['ventas'])?  moneda_presellers($row['ventas'],$igv_) : '<center>-</center>';?></td>		
								
									<?$array_tipo_surte = array();
									$por = (is_numeric($total_lomitos) && is_numeric($row['presentes']))? round(($row['presentes']/$total_lomitos)*100,2) : '';?>
									<?foreach($tipo_surte as $ix_ts => $row_ts){?>
										<? $array_tipo_surte[$ix_ts] = array(); ?>
										<?foreach($surte[$ix_ts] as $ix_s => $row_s){
											$cantidad_surte = isset($data_surte[$ix_sd][$ix]['surte'][$ix_ts][$ix_s])? $data_surte[$ix_sd][$ix]['surte'][$ix_ts][$ix_s] : 0;
											//$existe_surte = isset($data_surte[$ix_sd][$ix]['surte'][$ix_ts][$ix_s])? 1 : 0;
											?>
											<td style="text-align: right !important" ><?=$cantidad_surte;?></td>
										<?}?>
									<?}?>
									<?$total_surte=0;?>
								<td style="text-align: center !important" ><?=$row['presentes'];?></td>
								<td style="text-align: center !important" ><?=$total_lomitos;?></td>
								<td style="text-align: right !important" ><?=is_numeric($por)? $por.'%' : '<center>-</center>';?></td>
							</tr>
							<?}?>
						<?}?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
 var dataSet = anychart.data.set([<?=$data_lomito?>]);

	chart = anychart.bar();

	<?for($i = 1; $i<4; $i++){?>
		var series = dataSet.mapAs({x: 0, value: <?=$i?>});
		chart.bar(series);
	<?	}?>
	
	  // rename each series
	  chart.getSeriesAt(0).name("AVANCE");
	  chart.getSeriesAt(1).name("TARGET 10%");
	  chart.getSeriesAt(2).name("TARGET 20%");
chart.padding([0, 0, 5, 10]);
chart.legend()
            .enabled(true)
            .fontSize(13)
            .padding([0, 0, 20, 0]);
chart.container("lomito2");
chart.draw();	
</script>
	
	
	            	<!----------------------------------------------------------->
	            </div>
	        </div>
	    </div>
	</div>
<div>