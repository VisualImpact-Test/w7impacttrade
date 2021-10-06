
	<div class="card-datatable">
	<table id="tb-mantenimientoCliente" class="mb-0 table table-bordered text-nowrap w-100">
		<thead>
			<tr>
				<th class="text-center align-middle" rowspan="2">#</th>
				<th class="text-center align-middle" rowspan="2">OPCIONES</th>
				<th class="text-center align-middle" rowspan="2">FECHA</th>

				<th class="text-center align-middle" rowspan="2">EJECUTIVO</th>
				<th class="text-center align-middle" rowspan="2">GTM</th>
				<th class="text-center align-middle" rowspan="2">CANAL</th>

				<th class="text-center align-middle" rowspan="2">PLAZA</th>
				<th class="text-center align-middle" colspan="3" rowspan="1">DISTRIBUIDORA SUCURSAL</th>

				<th class="text-center align-middle" colspan="2" rowspan="1">DATOS CLIENTE</th>	

				<th class="text-center align-middle" colspan="11" rowspan="1">DATOS MANTENIMIENTO</th>

				<th class="text-center align-middle" rowspan="2">VALIDADO</th>

			</tr>

			<tr>
				
				<th class="text-center align-middle" rowspan="1">CIUDAD</th>
				<th class="text-center align-middle" rowspan="1">COD DISTRIBUIDORA</th>
				<th class="text-center align-middle" rowspan="1">DISTRIBUIDORA</th>

				<th class="text-center align-middle" rowspan="1">COD VISUAL</th>
				<th class="text-center align-middle" rowspan="1">RAZÓN SOCIAL</th>

				<th class="text-center align-middle" rowspan="1">COD CLIENTE</th>
				<th class="text-center align-middle" rowspan="1">NOMBRE COMERCIAL</th>
				<th class="text-center align-middle" rowspan="1">RAZON SOCIAL</th>
				<th class="text-center align-middle" rowspan="1">RUC</th>
				<th class="text-center align-middle" rowspan="1">DNI</th>
				<th class="text-center align-middle" rowspan="1">DEPARTAMENTO</th>
				<th class="text-center align-middle" rowspan="1">PROVINCIA</th>
				<th class="text-center align-middle" rowspan="1">DISTRITO</th>
				<th class="text-center align-middle" rowspan="1">DIRECCION</th>
				<th class="text-center align-middle" rowspan="1">LATITUD</th>
				<th class="text-center align-middle" rowspan="1">LONGITUD</th>

				

				
			</tr>
		</thead>
		<tbody>
			<? $i=1; foreach($visitas as $row){ 
				 $mensajeValidado = $row['validado'] == 1 ? 'Validado' : '-';
				?>
				<tr>
					<td class="text-center"><?=$i++;?></td>
					<td class="text-center">
						<button class="btn btn-Validar btn-outline-secondary border-0" data-id="<?=$row['idVisita']?>" title="Validar"><i class="fas fa-edit"></i></button>
					</td>
					<td class="text-center"><?=$row['fecha']?></td>

					<td class=""><?=(!empty($row['supervisor'])?$row['supervisor']:'-')?></td>
					<td class=""><?=(!empty($row['nombreUsuario'])?$row['nombreUsuario']:'-')?></td>
					<td class="text-center"><?=(!empty($row['canal'])?$row['canal']:'-')?></td>

					<td class="text-center"><?=(!empty($row['plaza'])?$row['plaza']:'-')?></td>


					<td class="text-center"><?=(!empty($row['ciudadDistribuidoraSuc'])?$row['ciudadDistribuidoraSuc']:'-')?></td>
					<td class="text-center"><?=(!empty($row['codUbigeoDistrito'])?$row['codUbigeoDistrito']:'-')?></td>
					<td class="text-center"><?=(!empty($row['distribuidora'])?$row['distribuidora']:'-')?></td>

					<td class="text-center"><?=(!empty($row['idCliente'])?$row['idCliente']:'-')?></td>
					<td class="text-center"><?=(!empty($row['razonSocial'])?$row['razonSocial']:'-')?></td>
					
					<td class="text-center"><?=(!empty($row['codCliente'])?$row['codCliente']:'-')?></td>
					<td class="text-center"><?=(!empty($row['nombreComercial'])?$row['nombreComercial']:'-')?></td>
					<td class="text-center"><?=(!empty($row['razonSociald'])?$row['razonSociald']:'-')?></td>
					<td class="text-center"><?=(!empty($row['ruc'])?$row['ruc']:'-')?></td>
					<td class="text-center"><?=(!empty($row['dni'])?$row['dni']:'-')?></td>
					<td class="text-center"><?=(!empty($row['departamento'])?$row['departamento']:'-')?></td>
					<td class="text-center"><?=(!empty($row['provincia'])?$row['provincia']:'-')?></td>
					<td class="text-center"><?=(!empty($row['distrito'])?$row['distrito']:'-')?></td>
					<td class="text-center"><?=(!empty($row['direccion'])?$row['direccion']:'-')?></td>
					<td class="text-center"><?=(!empty($row['latitud'])?$row['latitud']:'-')?></td>
					<td class="text-center"><?=(!empty($row['longitud'])?$row['longitud']:'-')?></td>
					<td class="text-center"><?=  $mensajeValidado ?></td>
				</tr>
				<?
				
			}
		?>
				
		</tbody>
	</table>	
</div>