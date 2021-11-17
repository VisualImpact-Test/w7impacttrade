<h5>PRECIOS</h5>
<div class="table-responsive">
<table class="mb-0 table table-bordered table-sm text-nowrap">
	<thead class="bg-light">
		<tr>
			<th class="text-center align-middle">#</th>
			<th class="text-center align-middle">PRODUCTO</th>
			<th class="text-center align-middle">PRECIO</th>
			<!-- <th class="text-center align-middle">PRECIO REGULAR</th>
			<th class="text-center align-middle">PRECIO OFERTA</th> -->

			<?=$columnasAdicionales['headers_adicionales'];?>
		</tr>
	</thead>
	<tbody>
		<? $i=1; foreach($precio as $row){ ?>
			<tr>
				<td><?=$i++?></td>
				<td><?=$row['producto']?></td>
				<td class="text-center"><?=!empty($row['precio'])? $row['precio'] : '-'?></td>
				<!-- <td class="text-center"><?=!empty($row['precioRegular'])? $row['precioRegular'] : '-'?></td>
				<td class="text-center"><?=!empty($row['precioOferta'])? $row['precioOferta'] : '-'?></td> -->
				<? foreach($columnasAdicionales['body_adicionales'] AS $k => $r) {?>
					<td class="text-center"><?=verificarEmpty($row[$r], 3)?></td>
				<? } ?>
			</tr>
		<? } ?>
	</tbody>
</table>
</div>