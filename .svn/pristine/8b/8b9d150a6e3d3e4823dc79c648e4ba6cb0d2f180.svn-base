<?
	$flagHide=$this->session->userdata('flagHide'); 
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
			<th colspan="22"></th>
		</tr>
        <tr>
			<th>#</th>
			<th>UNIDAD</th>
			<th>CIUDAD</th>
			<th>PLAZA</th>
			<th>COD TOPE</th>
			<th>TOPE</th>
			<th>PRESELLER</th>
			<th>FECHA PREVENTA</th>
			<th>ETAPA</th>
			<th>COD CLIENTE</th>
			<th>CLIENTE</th>
			<th>CAT. CLIENTE</th>
			<th>TIPO PLAN</th>
			<th>COD VENTA</th>
			<th>CATEGORÍA</th>
			<th>MARCA</th>
			<th>EAN</th>
			<th>PRODUCTO</th>
			<th>UM</th>
			<th>CANTIDAD</th>
			<th>PRECIO</th>
			<th>SUB-TOTAL (IGV)</th>
			<th>SUB-TOTAL (SIN IGV)</th>
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
			<td class="td-left"><?=$row->unidad;?></td>
			<td class="td-left"><?=$row->ciudad;?></td>
			<td class="td-left"><?=$row->plaza;?></td>
			<td class="td-center" style="text-align:center;"><?=$row->idTope;?></td>
			<td class="td-left"><?=$row->tope;?></td>
			<td class="td-left"><?=$nombreH;?></td>
			<td class="td-center" style="text-align:center;"><?=$row->fecha_pv;?></td>
			<td class="td-center" style="text-align:center;"><?=$row->etapa;?></td>
			<td class="td-center" style="text-align:center;"><?=$row->idCliente;?></td>
			<td class="td-left"><?=$row->cliente;?></td>
			<td class="td-left"><?=$row->catCliente;?></td>
			<td class="td-left"><?=$row->planCliente;?></td>
			<td class="td-center" style="text-align:center;"><?=$row->codVenta;?></td>
			<td class="td-left" ><?=$row->categoria;?></td>
			<td class="td-left" ><?=$row->marca;?></td>
			<td class="td-left" ><?=( !empty($row->ean) )? $row->ean: '-';?></td>
			<td class="td-left" ><?=$row->producto;?></td>
			<td class="td-center" style="text-align:center;" ><?=$row->um;?></td>
			<td class="td-right" style="text-align:center;" ><?=$row->cant;?></td>
			<td class="td-right" style="text-align:right;"><?=moneda_presellers($row->precio);?></td>
			<td class="td-right" style="text-align:right;"><?=moneda_presellers($row->subTotal);?></td>
			<td class="td-right" style="text-align:right;"><?=moneda_presellers($row->subTotal/IGV);?></td>
		</tr>
		<?}?>
	</tbody>
</table>

<div id="tabla-secreta" style="display: none" class="table table-striped table-bordered nowrap" style="font-size: 90%">
<table class="table" >
	<thead>
		<tr>
			<th>TOTAL: <?=count($qry_ventas)?></th>
			<th colspan="22"></th>
		</tr>
        <tr>
			<th>#</th>
			<th>UNIDAD</th>
			<th>CIUDAD</th>
			<th>PLAZA</th>
			<th>COD TOPE</th>
			<th>TOPE</th>
			<th>PRESELLER</th>
			<th>FECHA PREVENTA</th>
			<th>ETAPA</th>
			<th>COD CLIENTE</th>
			<th>CLIENTE</th>
			<th>CAT. CLIENTE</th>
			<th>TIPO PLAN</th>
			<th>COD VENTA</th>
			<th>CATEGORÍA</th>
			<th>MARCA</th>
			<th>EAN</th>
			<th>PRODUCTO</th>
			<th>UM</th>
			<th>CANTIDAD</th>
			<th>PRECIO</th>
			<th>SUB-TOTAL (IGV)</th>
			<th>SUB-TOTAL (SIN IGV)</th>
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
			<td class="td-left"><?=$row->unidad;?></td>
			<td class="td-left"><?=$row->ciudad;?></td>
			<td class="td-left"><?=$row->plaza;?></td>
			<td class="td-center" style="text-align:center;"><?=$row->idTope;?></td>
			<td class="td-left"><?=$row->tope;?></td>
			<td class="td-left"><?=$nombreH;?></td>
			<td class="td-center" style="text-align:center;"><?=$row->fecha_pv;?></td>
			<td class="td-center" style="text-align:center;"><?=$row->etapa;?></td>
			<td class="td-center" style="text-align:center;"><?=$row->idCliente;?></td>
			<td class="td-left"><?=$row->cliente;?></td>
			<td class="td-left"><?=$row->catCliente;?></td>
			<td class="td-left"><?=$row->planCliente;?></td>
			<td class="td-center" style="text-align:center;"><?=$row->codVenta;?></td>
			<td class="td-left" ><?=$row->categoria;?></td>
			<td class="td-left" ><?=$row->marca;?></td>
			<td class="td-left" ><?=( !empty($row->ean) )? $row->ean: '-';?></td>
			<td class="td-left" ><?=$row->producto;?></td>
			<td class="td-center" style="text-align:center;" ><?=$row->um;?></td>
			<td class="td-right" style="text-align:center;" ><?=$row->cant;?></td>
			<td class="td-right" style="text-align:right;"><?=moneda_presellers($row->precio);?></td>
			<td class="td-right" style="text-align:right;"><?=moneda_presellers($row->subTotal);?></td>
			<td class="td-right" style="text-align:right;"><?=moneda_presellers($row->subTotal/IGV);?></td>
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