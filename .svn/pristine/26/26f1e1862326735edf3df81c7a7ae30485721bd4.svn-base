<h5>INVENTARIO PRODUCTOS</h5>
<div class="table-responsive">
<table class="mb-0 table table-bordered table-sm text-nowrap">
	<thead>
		<tr  class="bg-purple-gradient text-white">
			<th class="text-center align-middle">#</th>
			<th class="text-center align-middle">PRODUCTO</th>
			<th class="text-center align-middle">STOCK INICIAL</th>
			<th class="text-center align-middle">SELLIN</th>
			<th class="text-center align-middle">STOCK</th>
			<th class="text-center align-middle">VALIDACIÓN</th>
			<th class="text-center align-middle">OBSERVACIÓN</th>
			<th class="text-center align-middle">COMENTARIO</th>
			<th class="text-center align-middle">FECHA VENCIMIENTO</th>
		</tr>
	</thead>
	<tbody>
		<? $i=1; foreach($listaProductos as $row){ ?>
			<tr>
				<td><?=$i++?></td>
				<td><?=$row['producto']?></td>
				<td class="text-center"><?=!empty($row['stock_inicial'])? $row['stock_inicial'] : '-'?></td>
				<td class="text-center"><?=!empty($row['sellin'])? $row['sellin'] : '-'?></td>
				<td class="text-center"><?=!empty($row['stock'])? $row['stock'] : '-'?></td>
				<td class="text-center"><?=!empty($row['validacion'])? $row['validacion'] : '-'?></td>
				<td class="text-center"><?=!empty($row['observacion'])? $row['observacion'] : '-'?></td>
				<td class="text-center"><?=!empty($row['comentario'])? $row['comentario'] : '-'?></td>
				<td class="text-center"><?=!empty($row['fechaVencimiento'])? $row['fechaVencimiento'] : '-'?></td>
			</tr>
		<? } ?>
	</tbody>
</table>
</div>