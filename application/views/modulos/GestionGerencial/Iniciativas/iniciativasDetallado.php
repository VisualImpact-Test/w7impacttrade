<div class="card-datatable">
<table id="tb-iniciativasDetalle" class="mb-0 table table-bordered text-nowrap" width="100%">
	<thead>
		<tr>
			<th class="text-center align-middle" rowspan="2">#</th>
			<th class="text-center align-middle" rowspan="2">INHABILITAR / PDF</th>		
			<th class="text-center align-middle" rowspan="2">FECHA</th>
			<th class="text-center align-middle" rowspan="2">HORA</th>
			<th class="text-center align-middle" rowspan="2">EJECUTIVO</th>
			<th class="text-center align-middle" rowspan="2">GTM</th>
			<th class="text-center align-middle" rowspan="2">CANAL</th>

			<th class="text-center align-middle" rowspan="2">PLAZA</th>
			<th class="text-center align-middle" colspan="3">DISTRIBUIDORA SUCURSAL</th>
			<th class="text-center align-middle" colspan="4">UBICACIÓN</th>

			<th class="text-center align-middle" colspan="2">DATOS CLIENTE</th>			
			<th class="text-center align-middle" colspan="7">DATOS DE INICIATIVAS</th>	
		</tr>
		<tr>
			
			<th class="text-center align-middle">CIUDAD</th>
			<th class="text-center align-middle">COD DISTRIBUIDORA</th>
			<th class="text-center align-middle">DISTRIBUIDORA</th>

			<th class="text-center align-middle">DEPARTAMENTO</th>
			<th class="text-center align-middle">PROVINCIA</th>
			<th class="text-center align-middle">DISTRITO</th>
			<th class="text-center align-middle">DIRECCIÓN</th>

			<th class="text-center align-middle">COD VISUAL</th>
			<th class="text-center align-middle">RAZÓN SOCIAL</th>

			<th class="text-center align-middle">INICIATIVA</th>
			<th class="text-center align-middle">ELEMENTO</th>
			<th class="text-center align-middle">MOTIVO</th>
			<th class="text-center align-middle">PRESENTE</th>
			
			<th class="text-center align-middle">FOTO</th>
			<th class="text-center align-middle">CANTIDAD</th>
			<th class="text-center align-middle">CUENTA<br>CON<br>PRODUCTO</th>
		</tr>
	</thead>
	<tbody>
		<? $ix=1; ?>
		<? foreach ($listaVisitaIniciativas as $kli => $row): ?>
			<tr>
				<td class="text-center"><?=$ix++;?></td>
				<td class="text-center">
					<input name="check[]" id="check" class="check" type="checkbox"  value="<?=$row['idVisitaIniciativaTradDet'];?>" />
				</td>
				<td class="text-center"><?=$row['fecha']?></td>
				<td class="text-center"><?=$row['hora']?></td>
				<td class=""><?=(!empty($row['supervisor'])?$row['supervisor']:'-')?></td>
				<td class=""><?=(!empty($row['nombreUsuario'])?$row['nombreUsuario']:'-')?></td>
				<td class="text-center"><?=(!empty($row['canal'])?$row['canal']:'-')?></td>
				<td class="text-center"><?=(!empty($row['plaza'])?$row['plaza']:'-')?></td>
				<td class="text-center"><?=(!empty($row['ciudadDistribuidoraSuc'])?$row['ciudadDistribuidoraSuc']:'-')?></td>
				<td class="text-center"><?=(!empty($row['codUbigeoDisitrito'])?$row['codUbigeoDisitrito']:'-')?></td>
				<td class="text-center"><?=(!empty($row['distribuidora'])?$row['distribuidora']:'-')?></td>
				
				<td class="text-center"><?=(!empty($row['departamento'])?$row['departamento']:'-')?></td>
				<td class="text-center"><?=(!empty($row['provincia'])?$row['provincia']:'-')?></td>
				<td class="text-center"><?=(!empty($row['distrito'])?$row['distrito']:'-')?></td>
				<td class="text-center"><?=(!empty($row['direccion'])?$row['direccion']:'-')?></td>

				<td class="text-center"><?=(!empty($row['idCliente'])?$row['idCliente']:'-')?></td>
				<td><?=(!empty($row['razonSocial'])?$row['razonSocial']:'-')?></td>
				<td><?=(!empty($row['iniciativa'])?$row['iniciativa']:'-')?></td>
				<td><?=(!empty($row['elementoIniciativa'])?$row['elementoIniciativa']:'-')?></td>
				<td class="text-center"><?=(!empty($row['motivo'])?$row['motivo']:'-')?></td>
				<td class="text-center"><?=(!empty($row['presencia'])?($row['presencia']==1?'SI':'NO'):'-')?></td>
				<? 
					$fotoImg = ( isset($row['foto']) && !empty($row['foto']) ) ? $this->fotos_url.'iniciativa/'.$row['foto']:'';
					if (!empty($fotoImg)){
						$fotoImg = '<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-'.$row['idVisita'].'-'.$row['idElementoIniciativa'].'">
									<img class="fotoMiniatura foto" name="img-fotoprincipal-'.$row['idVisita'].'-'.$row['idElementoIniciativa'].'" id="img-fotoprincipal-'.$row['idVisita'].'-'.$row['idElementoIniciativa'].'" src="'.$fotoImg.'" alt=""></a>';
					}
				?>
				<td class="text-center"><?=(!empty($fotoImg)?$fotoImg:'-');?></td>
				<td class="text-center"><?=(!empty($row['cantidad'])?$row['cantidad']:'-')?></td>
				<td class="text-center"><?=(!empty($row['producto'])?($row['producto']?'SÍ':'NO'):'-')?></td>

				
				
			</tr>
		<? endforeach ?>
	</tbody>
</table>
</div>