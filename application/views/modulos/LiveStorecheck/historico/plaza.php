<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<button id="btn-lsck-auditar-plaza"
				class="btn btn-primary"
				data-id-plaza="<?=$idPlaza?>"
				data-id-cuenta=3
				data-id-proyecto=3
			>
				<i class="fas fa-flag-checkered"></i> Iniciar Auditoria
			</button>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table id="tb-lsck-plazas-auditadas-hist" class="table table-striped text-nowrap" width="100%">
				<thead>
					<tr>
						<th>#<?=nbs(3);?></th>
						<th>FECHA</th>
						<th>HORA</th>
						<th>AUDITOR</th>
						<th># TIENDAS</th>
						<th class="no-sort">PREG</br>NOTA</th>
						<th class="no-sort">PERF OMS</br>NOTA</th>
						<th class="no-sort">PERF OMS</br>%</th>
						<th class="no-sort">PERF OMS</br>CALIFICACIÓN</th>
						<th class="no-sort"></th>
					</tr>
				</thead>
				<tbody>
					<?foreach($data as $i => $row){?>
					<tr data-id="<?=$row['idAudPlaza']?>">
						<td><?=($i + 1)?></td>
						<td class="text-center"><?=$row['fecha']?></td>
						<td class="text-center"><?=$row['hora']?></td>
						<td><?=$row['usuario']?></td>
						<td><?=$row['totalCliente']?></td>
						<td><?=$row['pregNota']?></td>
						<td><?=$row['perfNota']?></td>
						<td><?=$row['perfPorcentaje']?></td>
						<td><?=$row['perfCalificacion']?></td>
						<td class="text-center">
							<button type="button" class="btn btn-sm btn-primary btn-lsck-historico-plaza-pdf" data-id="<?=$row['idAudPlaza']?>" title="Generar PDF"><i class="fa fa-file-pdf fa-lg"></i></button>
							<button type="button" class="btn btn-sm btn-primary btn-lsck-historico-plaza-foto" data-id="<?=$row['idAudPlaza']?>" title="Ver Fotos"><i class="fas fa-camera-retro fa-lg"></i></button>
							<button type="button" class="btn btn-sm btn-primary btn-lsck-historico-tienda" data-id="<?=$row['idAudPlaza']?>" title="Ver Tiendas"><i class="fas fa-store fa-lg"></i></button>
						</td>
					</tr>
					<?}?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$('#tb-lsck-plazas-auditadas-hist').dataTable({
		'dom': 'rtip',
		'scrollX': true,
		'columnDefs': [{ 'targets': 'no-sort', 'orderable': false }]
	});

	setTimeout(function(){
		Fn.dataTableAdjust();
	}, 200);
</script>