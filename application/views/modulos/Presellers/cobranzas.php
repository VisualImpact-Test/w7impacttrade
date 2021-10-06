<?
	$flagHide=$this->session->userdata('flagHide'); 
	//$igv_ = $igv;
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
			<th>TOTAL: <?=count($qry_ventas)?></th>
			<th colspan="27"></th>
		</tr>
        <tr>
			<th>#</th>
			<th>UNIDAD</th>
			<th>CIUDAD</th>
			<th>PLAZA</th>
			<th>COD TOPE</th>
			<th>TOPE</th>
			<th>PRESELLER</th>
			<th>FECHA VENTA</th>
			<th>COD CLIENTE</th>
			<th>CLIENTE</th>
			<th>CAT. CLIENTE</th>
			<th>TIPO PLAN</th>
			<th>COD VENTA</th>
			<th>FECHA PAGO</th>
			<th>TOTAL VENTA</th>
			<th>AMORTIZADO</th>
			<th>DEUDA</th>
			<th>PAGO</th>
			<th>CARGO PS</th>
			<th>BOLETA TOPE</th>
			<th>TIPO COMPROBANTE</th>
			<th>NUMERO COMPROBANTE</th>
	

			
        </tr>
	</thead>
	<tbody>
		<? $ix = 0;?>
		<? foreach($qry_ventas as $row){
			$ix++; 
			$nombreH=$flagHide=='1'?'RUTA '.$row->idUsuario:$row->preseller;
		?>
		<tr>
			<td class="td-center" style="text-align:center;"><?=$ix;?></td>
			<td class="td-left" ><?=$row->unidad;?></td>
			<td class="td-left" ><?=$row->ciudad;?></td>
			<td class="td-left" ><?=$row->plaza;?></td>
			<td class="td-center" style="text-align:center;"><?=$row->idTope;?></td>
			<td class="td-left" ><?=$row->tope;?></td>
			<td class="td-left"><?=$nombreH;?></td>
			<td class="td-center" style="text-align:center;"><?=$row->fecha_v;?></td>
			<td class="td-center" style="text-align:center;" ><?=$row->idCliente;?></td>
			<td class="td-left" ><?=$row->cliente;?></td>
			<td class="td-left" ><?=$row->catCliente;?></td>
			<td class="td-left" ><?=$row->planCliente;?></td>
			<td class="td-center" style="text-align:center;"><?=$row->codVenta;?></td>
			<td class="td-center" style="text-align:center;"><?=$row->fechaPago;?></td>
			<?
				/* if($row->amortizacion >0 ){
					$amortizado = $row->amortizacion-$row->monto;
				}else{
					$amortizado=0;
				}
				*/
				$deuda = $row->total_real - $row->monto ; 
			?>
			<td class="td-right" style="text-align:right;"><?=moneda_presellers($row->total_real);?></td>
			<td class="td-right" style="text-align:right;"><?=moneda_presellers($row->amortizacion);?></td>
			<td class="td-right" style="text-align:right;"><?=moneda_presellers($deuda);?></td>
			<td class="td-right" style="text-align:right;"><?=moneda_presellers($row->monto);?></td>
			
			<?
				$foto1 = ( !empty($row->imgCargoPs) )? '<i class="lk-show-foto-presellers fa fa-picture-o pointer img_foto" data-modulo="presellers" data-tipoDoc="" data-num="" data-foto="'.$row->imgCargoPs.'" /></i>': '';
				$foto2 = ( !empty($row->imgBoletaTope) )? '<i class="lk-show-foto-presellers fa fa-picture-o pointer img_foto" data-modulo="presellers" data-tipoDoc="" data-num="" data-foto="'.$row->imgBoletaTope.'" /></i>': '';
				//$dataFoto = ( !empty($ft) )? 'data-modulo="presellers" data-foto="'.$foto_1.'"': '';*/
			?>
			<td nowrap class="td-right"><?=$foto1;?></td>
			<td nowrap class="td-right"><?=$foto2;?></td>

			
			<?php 
				$nc = '';
				$nc1 = '';
				$fot = '';
				$fot1 = '';
				$tipoDoc = '';
				$tipoDoc1 = '';
				foreach ($qry_ncomprobante as $key => $value) {
					if($value->codVenta == $row->codVenta){
						if(strcmp($nc, $value->numComp) !== 0){
							$nc.= $value->numComp;
							$nc1.= $value->numComp.', ';
							$ft = $value->foto;
						}
						if(strcmp($fot, $value->foto) !== 0){
							$fot.= $value->foto;
							$fot1.= $value->foto.', ';
							$ft = $value->foto;
						}
						if(strcmp($tipoDoc, $value->tipo) !== 0){
							$tipoDoc.= $value->tipo;
							$tipoDoc1.= $value->tipo.', ';
							$ft = $value->foto;
						}
					} 
				} 

				$ncomp = substr($nc1, 0, -2);
				$foto_1 = substr($fot1, 0, -2);
				$tipoDocumento = substr($tipoDoc1, 0, -2);
				$foto = ( !empty($ft) )? '<i class="lk-show-foto-presellers fa fa-picture-o pointer img_foto" data-modulo="presellers" data-tipoDoc="'.$tipoDoc1.'" data-num="'.$ncomp.'" data-foto="'.$foto_1.'" /></i>': '';
				//$dataFoto = ( !empty($ft) )? 'data-modulo="presellers" data-foto="'.$foto_1.'"': '';
			?>
			<td class="td-left" ><?=$tipoDocumento;?></td>
			<td nowrap class="td-right"><?=$ncomp.'  '.$foto;?></td>
		</tr>
		<?}?>
	</tbody>
</table>
<div id="tabla-secreta" style="display: none">
<table class="table" >
	<thead>
		<tr>
			<th>TOTAL: <?=count($qry_ventas)?></th>
			<th colspan="27"></th>
		</tr>
        <tr>
			<th>#</th>
			<th>UNIDAD</th>
			<th>CIUDAD</th>
			<th>PLAZA</th>
			<th>COD TOPE</th>
			<th>TOPE</th>
			<th>PRESELLER</th>
			<th>FECHA VENTA</th>
			<th>COD CLIENTE</th>
			<th>CLIENTE</th>
			<th>CAT. CLIENTE</th>
			<th>TIPO PLAN</th>
			<th>COD VENTA</th>
			<th>FECHA PAGO</th>
			<th>TOTAL VENTA</th>
			<th>AMORTIZADO</th>
			<th>DEUDA</th>
			<th>PAGO</th>
			<th>CARGO PS</th>
			<th>BOLETA TOPE</th>
			<th>TIPO COMPROBANTE</th>
			<th>NUMERO COMPROBANTE</th>
        </tr>
	</thead>
	<tbody>
		<? $ix = 0;?>
		<? foreach($qry_ventas as $row){
			$ix++; 
			$nombreH=$flagHide=='1'?'RUTA '.$row->idUsuario:$row->preseller;
		?>
		<tr>
			<td class="td-center" style="text-align:center;"><?=$ix;?></td>
			<td class="td-left" ><?=$row->unidad;?></td>
			<td class="td-left" ><?=$row->ciudad;?></td>
			<td class="td-left" ><?=$row->plaza;?></td>
			<td class="td-center" style="text-align:center;"><?=$row->idTope;?></td>
			<td class="td-left" ><?=$row->tope;?></td>
			<td class="td-left"><?=$nombreH;?></td>
			<td class="td-center" style="text-align:center;"><?=$row->fecha_v;?></td>
			<td class="td-center" style="text-align:center;" ><?=$row->idCliente;?></td>
			<td class="td-left" ><?=$row->cliente;?></td>
			<td class="td-left" ><?=$row->catCliente;?></td>
			<td class="td-left" ><?=$row->planCliente;?></td>
			<td class="td-center" style="text-align:center;"><?=$row->codVenta;?></td>
			<td class="td-center" style="text-align:center;"><?=$row->fechaPago;?></td>
			<?
				/* if($row->amortizacion >0 ){
					$amortizado = $row->amortizacion-$row->monto;
				}else{
					$amortizado=0;
				}
				*/
				$deuda = $row->total_real - $row->monto ; 
			?>
			<td class="td-right" style="text-align:right;"><?=moneda_presellers($row->total_real);?></td>
			<td class="td-right" style="text-align:right;"><?=moneda_presellers($row->amortizacion);?></td>
			<td class="td-right" style="text-align:right;"><?=moneda_presellers($deuda);?></td>
			<td class="td-right" style="text-align:right;"><?=moneda_presellers($row->monto);?></td>
			
			<?
				$foto1 = ( !empty($row->imgCargoPs) )? '<i class="lk-show-foto-presellers fa fa-picture-o pointer img_foto" data-modulo="presellers" data-tipoDoc="" data-num="" data-foto="'.$row->imgCargoPs.'" /></i>': '';
				$foto2 = ( !empty($row->imgBoletaTope) )? '<i class="lk-show-foto-presellers fa fa-picture-o pointer img_foto" data-modulo="presellers" data-tipoDoc="" data-num="" data-foto="'.$row->imgBoletaTope.'" /></i>': '';
				//$dataFoto = ( !empty($ft) )? 'data-modulo="presellers" data-foto="'.$foto_1.'"': '';*/
			?>
			<td nowrap class="td-right"><?=$foto1;?></td>
			<td nowrap class="td-right"><?=$foto2;?></td>

			
			<?php 
				$nc = '';
				$nc1 = '';
				$fot = '';
				$fot1 = '';
				$tipoDoc = '';
				$tipoDoc1 = '';
				foreach ($qry_ncomprobante as $key => $value) {
					if($value->codVenta == $row->codVenta){
						if(strcmp($nc, $value->numComp) !== 0){
							$nc.= $value->numComp;
							$nc1.= $value->numComp.', ';
							$ft = $value->foto;
						}
						if(strcmp($fot, $value->foto) !== 0){
							$fot.= $value->foto;
							$fot1.= $value->foto.', ';
							$ft = $value->foto;
						}
						if(strcmp($tipoDoc, $value->tipo) !== 0){
							$tipoDoc.= $value->tipo;
							$tipoDoc1.= $value->tipo.', ';
							$ft = $value->foto;
						}
					} 
				} 

				$ncomp = substr($nc1, 0, -2);
				$foto_1 = substr($fot1, 0, -2);
				$tipoDocumento = substr($tipoDoc1, 0, -2);
				$foto = ( !empty($ft) )? '<i class="lk-show-foto-presellers fa fa-picture-o pointer img_foto" data-modulo="presellers" data-tipoDoc="'.$tipoDoc1.'" data-num="'.$ncomp.'" data-foto="'.$foto_1.'" /></i>': '';
				//$dataFoto = ( !empty($ft) )? 'data-modulo="presellers" data-foto="'.$foto_1.'"': '';
			?>
			<td class="td-left" ><?=$tipoDocumento;?></td>
			<td nowrap class="td-right"><?=$ncomp.'  '.$foto;?></td>
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