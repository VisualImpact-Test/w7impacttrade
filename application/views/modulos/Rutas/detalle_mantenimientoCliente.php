<h5>MANTENIMIENTO CLIENTE</h5>
<div class="table-responsive">
	<table class="mb-0 table table-bordered table-sm text-nowrap">
		<tbody>
			<? $i=1; foreach($listaMantenimientoCliente as $ix_o => $row_o){ ?>
				<tr>
					<td class="bg-light" width="250px">CÓDIGO CLIENTE</td>
					<td><?=!empty($row_o['codCliente'])? $row_o['codCliente'] : '-'?></td>
				</tr>
				<tr>
					<td class="bg-light">NOMBRE COMERCIAL</td>
					<td><?=!empty($row_o['nombreComercial'])? $row_o['nombreComercial'] : '-'?></td>
				</tr>
				<tr>
					<td class="bg-light">RAZÓN SOCIAL</td>
					<td><?=!empty($row_o['razonSocial'])? $row_o['razonSocial'] : '-'?></td>
				</tr>
				<tr>
					<td class="bg-light">RUC</td>
					<td><?=!empty($row_o['ruc'])? $row_o['ruc'] : '-'?></td>
				</tr>
				<tr>
					<td class="bg-light">DNI</td>
					<td><?=!empty($row_o['dni'])? $row_o['dni'] : '-'?></td>
				</tr>
				<tr>
					<td class="bg-light">CÓDIGO UBIGEO</td>
					<td><?=!empty($row_o['cod_ubigeo'])? $row_o['cod_ubigeo'] : '-'?></td>
				</tr>
					<td class="bg-light">DIRECCIÓN</td>
					<td><?=!empty($row_o['direccion'])? $row_o['direccion'] : '-'?></td>
				</tr>
				</tr>
					<td class="bg-light">LATITUD</td>
					<td><?=!empty($row_o['latitud'])? $row_o['latitud'] : '-'?></td>
				</tr>
				</tr>
					<td class="bg-light">LONGITUD</td>
					<td><?=!empty($row_o['longitud'])? $row_o['longitud'] : '-'?></td>
				</tr>
				</tr>
					<td class="bg-light">MAPA</td>
					<td>
						<?if( !empty($row_o['latitud']) && !empty($row_o['longitud']) ){?>
							<a target="_blank" href="https://www.google.com/maps/place/<?=$row_o['latitud']?>,<?=$row_o['longitud']?>">
								<i class="far fa-map-marked-alt"></i> Ver en mapa
							</a>
						<?} else echo '-';?>
					</td>
				</tr>
			<? } ?>
		</tbody>
	</table>
</div>