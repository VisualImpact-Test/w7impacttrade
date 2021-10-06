<div class="row themeWhite">
	<div class="col-md-12">
		<div class="mb-3 mt-3 card">
			<div class="card-header">
				<i class="fas fa-clipboard-list fa-lg"></i>&nbspLISTA DE POSIBLES SIMILITUDES
			</div>
			<div class="card-body">
				<div class="tab-content">
					<div class="table-responsive">
						<table class="mb-0 table table-bordered table-sm text-nowrap" width="100%">
							<thead>
								<tr>
									<th class="align-middle text-center">ID<br>CLIENTE</th>
									<th class="align-middle">NOMBRE COMERCIAL</th>
									<th class="align-middle">RAZÓN SOCIAL</th>
									<th class="align-middle text-center">DIRECCIÓN</th>
									<th class="align-middle text-center">DNI</th>
									<th class="align-middle text-center">RUC</th>
									<th class="align-middle text-center">CUENTA</th>
									<th class="align-middle text-center">PROYECTO</th>
									<th class="align-middle text-center">CANAL</th>
								</tr>
							</thead>
							<tbody>
								<? foreach ($listaClientes as $klc => $row): ?>
									<tr>
										<td class="text-center"><?=$row['idCliente']?></td>
										<td><?=$row['nombreComercial']?></td>
										<td><?=$row['razonSocial']?></td>
										<td><?=(!empty($row['direccion'])?$row['direccion']:'-')?></td>
										<td class="text-center"><?=(!empty($row['dni'])?$row['dni']:'-')?></td>
										<td class="text-center"><?=(!empty($row['ruc'])?$row['ruc']:'-')?></td>
										<td class="text-center"><?=(!empty($row['cuenta'])?$row['cuenta']:'-')?></td>
										<td class="text-center"><?=(!empty($row['proyecto'])?$row['proyecto']:'-')?></td>
										<td class="text-center"><?=(!empty($row['canal'])?$row['canal']:'-')?></td>
									</tr>
								<? endforeach ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>