<?
/*
$i = 1;
$data = [];
foreach($tienda as $idx => $row){
	$data[$idx] = [
			// 'check' => "<input type=\"checkbox\" class=\"chk-lsck-tienda pointer\" data-id=\"{$row['idCliente']}\" style=\"width: 1.3rem; height: 1.3rem;\">",
			// 'check' => '<input type="checkbox" class="chk-lsck-tienda pointer" data-id="'.$row['idCliente'].'" style="width: 1.3rem; height: 1.3rem;">',
			'check' => '1',
			'num' => $i++,
			'idCliente' => $row['idCliente'],
			'tipoCliente' => $row['tipoCliente'],
			'razonSocial' => $row['razonSocial'],
			'direccion' => $row['direccion']
		];
}
// print_r($data);
// die();
*/
?>
<div class="row">
	<div class="col-md-12">
		<div id="content-live-tienda-lista" class="table-responsive mt-3">
			<table id="tb-lsck-tienda" class="table table-bordered table-striped table-sm-px text-nowrap" width="100%" >
				<thead>
					<tr>
						<th></th>
						<th>#</th>
						<th>COD VI</th>
						<th>TIPO CLIENTE</th>
						<th>RAZON SOCIAL</th>
						<th>DIRECCIÓN</th>
					</tr>
				</thead>
				<tbody>
					<?$i = 1;?>
					<?foreach($tienda as $row){?>
					<tr>
						<td class="text-center">
							<input type="checkbox" class="chk-lsck-tienda pointer" data-id="<?=$row['idCliente']?>" style="width: 1.3rem; height: 1.3rem;">
						</td>
						<td><?=$i++;?></td>
						<td><?=$row['idCliente']?></td>
						<td><?=$row['tipoCliente']?></td>
						<td><?=$row['razonSocial']?></td>
						<td><?=$row['direccion']?></td>
					</tr>
					<?}?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$('#tb-lsck-tienda').DataTable({
		// ordering: false,
		scrollY: '40vh',
		scrollX: true
	});
</script>