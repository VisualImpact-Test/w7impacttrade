<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table id="tb-lsck-tiendas-auditadas-hist" class="table table-striped text-nowrap" width="100%">
				<thead>
					<tr>
						<th>#<?=nbs(3);?></th>
						<th>TIPO CLIENTE</th>
						<th>RAZON SOCIAL</th>
						<th>DIRECCIÓN</th>
						<th class="no-sort"></th>
					</tr>
				</thead>
				<tbody>
					<?foreach($data as $i => $row){?>
					<tr data-id="<?=$row['idAudCliente']?>">
						<td><?=($i + 1)?></td>
						<td><?=$row['tipoCliente']?></td>
						<td><?=$row['razonSocial']?></td>
						<td><?=$row['direccion']?></td>
						<td class="text-center">
							<button type="button" class="btn btn-sm btn-primary btn-lsck-historico-tienda-foto" data-id="<?=$row['idAudCliente']?>" title="Ver Fotos"><i class="fas fa-camera-retro"></i></button>
							<button type="button" class="btn btn-sm btn-primary btn-lsck-historico-tienda-orden" data-id="<?=$row['idAudCliente']?>" title="Ver Orden de Trabajo"><i class="fas fa-tasks"></i></button>
						</td>
					</tr>
					<?}?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$('#tb-lsck-tiendas-auditadas-hist').dataTable({
		dom: 'rtip',
		scrollX: true,
		scrollY: '35vh',
		columnDefs: [{ 'targets': 'no-sort', 'orderable': false }]
	});

	setTimeout(function(){
		Fn.dataTableAdjust();
	}, 200);
</script>