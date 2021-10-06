<div class="card-datatable">
<table id="<?=$tableListaNombre;?>" class="mb-0 table table-bordered text-nowrap w-100">
	<thead>
		<tr>
			<th class="text-center align-middle" rowspan="2">#</th>
			<th class="text-center align-middle" colspan="6">CLIENTE</th>
			<th class="text-center align-middle" colspan="3">MODULACIÓN</th>
			<? foreach ($listaCategoria as $klct => $categoria): ?>
				<th class="text-center align-middle" colspan="<?=count($categoria['listaElementos'])?>"><?=$categoria['categoria']?></th>
			<? endforeach ?>
		</tr>
		<tr>
			<th class="text-center align-middle">GRUPO<br>CANAL</th>
			<th class="text-center align-middle">CANAL</th>
			<th class="text-center align-middle">IDCLIENTE</th>
			<th class="text-center align-middle td-min-190">CLIENTE</th>
			<th class="text-center align-middle td-min-150">TIPO CLIENTE</th>
			<th class="text-center align-middle">DEPARTAMENTO</th>
			<th class="text-center align-middle">EDITAR</th>
			<th class="text-center align-middle">LISTA<br>AUDITORIA</th>
			<th class="text-center align-middle td-min-190">VALIDACIONES<br>(Debe tener)</th>
			<? foreach ($listaCategoria as $klcte => $categoria): ?>
				<? foreach ($categoria['listaElementos'] as $kle => $elemento): ?>
					<th class="text-center align-middle"><?=$elemento['elemento']?></th>
				<? endforeach ?>
			<? endforeach ?>
		</tr>
	</thead>
	<tbody>
		<? $ix=1; ?>
		<? foreach ($listaClientes as $klc => $cliente): ?>
			<? $htmlEditar = ( $flagEditar==1 ? '<button type="button" class="btn btn-info editarPermisoClienteMod" data-permiso="'.$idPermiso.'" data-cliente="'.$cliente['idCliente'].'" title="EDITAR MODULACIÓN"><i class="fas fa-edit fa-lg"></i></button>':'<span>-</span>' ); ?>
			<tr id="trc-<?=$cliente['idCliente']?>" data-cliente="<?=$cliente['idCliente']?>">
				<td class="text-center"><?=$ix++;?></td>
				<td class="text-center"><?=(!empty($cliente['grupoCanal'])?$cliente['grupoCanal']:'-')?></td>
				<td class="text-center"><?=(!empty($cliente['canal'])?$cliente['canal']:'-')?></td>
				<td class="text-center"><?=(!empty($cliente['idCliente'])?$cliente['idCliente']:'-')?>
					<input type="hidden" tipo="cliente" value="<?=$cliente['idCliente'];?>" name="idCliente" />
				</td>
				<td class="td-min-190"><?=(!empty($cliente['razonSocial'])?$cliente['razonSocial']:'-')?></td>
				<td class="text-center td-min-150"><?=(!empty($cliente['subCanal'])?$cliente['subCanal']:'-')?></td>
				<td class="text-center"><?=(!empty($cliente['departamento'])?$cliente['departamento']:'-')?></td>
				<td class="text-center align-middle" id="tbEditar-<?=$idPermiso?>-<?=$cliente['idCliente']?>"><?=$htmlEditar;?></td>
				<? $estadoListaGenerada = isset($listaModulacion[$cliente['idCliente']]['flagListaGenerada']) ? $listaModulacion[$cliente['idCliente']]['flagListaGenerada'] : 0;?>
				<? $vistaEstadoLista = ( $estadoListaGenerada==1 ? '<span class="el-estado btn-success">GENERADA</span>': '<span class="btn-danger el-estado">NO</span>' ); ?>
				<td class="text-center align-middle"><?=$vistaEstadoLista;?></td>
				<td class="text-center td-min-190">
					<label>MÍNIMO: <?=$cliente['minCategorias']?> CATEGORIAS.</label><br>
					<label>MÍNIMO: <?=$cliente['minElementosOblig']?> ELEMENTOS.</label><br>
				</td>

				<? foreach ($listaCategoria as $klct => $categoria): ?>
					<? foreach ($categoria['listaElementos'] as $klcte => $elemento): ?>
						<? $cantidadMod = isset($listaModulacion[$cliente['idCliente']]['listaModuElementos'][$klcte]['cantidad']) ? $listaModulacion[$cliente['idCliente']]['listaModuElementos'][$klcte]['cantidad'] : 0;?>
						<td class="text-center align-middle"><?=$cantidadMod;?></td>
					<? endforeach ?>
				<? endforeach ?>
			</tr>
		<? endforeach ?>
	</tbody>
</table>
</div>
<!--div class="card-datatable">
	<table id="tb-modulacion" class="table table-striped table-bordered nowrap dataTable no-footer" width="100%">
		<thead>
			<tr>
				<th class="text-center align-middle" rowspan="2">#</th>
				<th class="text-center align-middle" rowspan="2">GRUPO<br>CANAL</th>
				<th class="text-center align-middle" rowspan="2">CANAL</th>
				<th class="text-center align-middle" rowspan="2">IDCLIENTE</th>
				<th class="text-center align-middle" rowspan="2">CLIENTE</th>
				<th class="text-center align-middle" rowspan="2">TIPO CLIENTE</th>
				<th class="text-center align-middle" rowspan="2">DEPARTAMENTO</th>
				<th class="text-center align-middle" rowspan="2">VALIDACIONES</th>
				<? /*foreach ($categoria as $row => $value){ ?>
					<th colspan="<?=count($elementos[$row])?>" class="text-center"><?=$value['categoria']?></th>
				<? } ?>
			</tr>
			<tr>
				<? foreach ($categoria as $row => $value){ ?>
					<? foreach ($elementos[$row] as $row_e => $value_e){ ?>
						<th class="text-center"><?=$value_e['elemento']?></th>
					<? } ?>
				<? } ?>
			</tr>
		</thead>
		<tbody>
			<? $ix=1; ?>
			<?foreach ($clientes as $row){ ?>
				<tr>
					<td class="text-center"><?=$ix++;?></td>
					<td class="text-center"><?=$row['grupoCanal'];?></td>
					<td class="text-center"><?=$row['canal'];?></td>
					<td class="text-center"><input type="hidden" tipo="cliente" value="<?=$row['idCliente'];?>" name="idCliente" /><?=$row['idCliente'];?></td>
					<td class="text-center"><?=$row['razonSocial'];?></td>
					<td class="text-center"><?=$row['subcanal'];?></td>
					<td class="text-center"><?=$row['departamento'];?></td>
					<td id="tdButton" class="text-center"> 
						DEBE TENER MINIMO : <?=$row['minCategorias']?> CATEGORIAS. <br>
						DEBE TENER MINIMO : <?=$row['minElementosOblig']?> ELEMENTOS . <br>
					</td>	
					<? foreach ($categoria as $row_c => $value_c){ ?>
						<? foreach ($elementos[$row_c] as $row_e => $value_e){ ?>
							<?
								$checked = isset($modulacion[$row['idCliente']][$row_e]['elemento'])?'checked':'';
								$cantidad = isset($modulacion[$row['idCliente']][$row_e]['cantidad'])?$modulacion[$row['idCliente']][$row_e]['cantidad']:'0';
							?>
							<td class="text-center">
								<div style="display:none;"><input type="checkbox" name="modulacion_<?=$row['idCliente'] ?>_<?=$row_e?>" value="<?=$row_e?>" <?=$checked?> /></div>
								<center><input class="form-control" type="number" tipo="cantidad" idCliente="<?=$row['idCliente']?>" idElemento="<?=$row_e?>" class="cantidad" value="<?=$cantidad?>" name="cantidad" style="width:100px;text-align: center;"/></center>
							</td>
						<? } ?>
					<? } ?>
				</tr>
			<? } ?>
		</tbody>
	</table>
</div-->

<!--<div class="card-datatable">
	<table id="tb-modulacion" class="table table-striped table-bordered nowrap dataTable no-footer" style="width:100%;">
		<thead>
			<tr>
				<th class="text-center align-middle" rowspan="2" >#</th>
				<th class="text-center align-middle" rowspan="2" >GRUPO CANAL</th>
				<th class="text-center align-middle" rowspan="2" >CANAL</th>
				<th class="text-center align-middle" rowspan="2" >IDCLIENTE</th>
				<th class="text-center align-middle" rowspan="2" >CLIENTE</th>
				<th class="text-center align-middle" rowspan="2" >TIPO CLIENTE</th>
				<th class="text-center align-middle" rowspan="2" >DEPARTAMENTO</th>
				<th class="text-center align-middle" rowspan="2" >VALIDACIONES</th>
				<? foreach ($categoria as $row => $value){ ?>
					<th colspan="<?=count($elementos[$row])?>" class="text-center"><?=$value['categoria']?></th>
				<? } ?>
			</tr>
			<tr>
				<? foreach ($categoria as $row => $value){ ?>
					<? foreach ($elementos[$row] as $row_e => $value_e){ ?>
						<th class="text-center"><?=$value_e['elemento']?></th>
					<? } ?>
				<? } ?>
			</tr>
		</thead>
		<tbody>
			<? $ix=1; ?>
			<?foreach ($clientes as $row){ ?>
				<tr>
					<td class="text-center"><?=$ix++;?></td>
					<td class="text-center"><?=$row['grupoCanal'];?></td>
					<td class="text-center"><?=$row['canal'];?></td>
					<td class="text-center"><input type="hidden" value="<?=$row['idCliente'];?>" name="idCliente"><?=$row['idCliente'];?></td>
					<td class="text-center"><?=$row['razonSocial'];?></td>
					<td class="text-center"><?=$row['subcanal'];?></td>
					<td class="text-center"><?=$row['departamento'];?></td>
					<td id="tdButton" class="text-center"> 
						DEBE TENER MINIMO : <?=$row['minCategorias']?> CATEGORIAS. <br>
						DEBE TENER MINIMO : <?=$row['minElementosOblig']?> ELEMENTOS . <br>
					</td>	
					<? foreach ($categoria as $row_c => $value_c){ ?>
						<? foreach ($elementos[$row_c] as $row_e => $value_e){ ?>
							<?
								$checked = isset($modulacion[$row['idCliente']][$row_e]['elemento'])?'checked':'';
								$cantidad = isset($modulacion[$row['idCliente']][$row_e]['cantidad'])?$modulacion[$row['idCliente']][$row_e]['cantidad']:'0';
							?>
							<td class="text-center">
								<input type="checkbox" name="modulacion_<?=$row['idCliente'] ?>" value="<?=$row_e?>" <?=$checked?>>
								<input type="text" class="cantidad" value="<?=$cantidad?>" name="cantidad_<?=$row['idCliente'] ?>">
							</td>
						<? } ?>
					<? } ?>
				</tr>
			<? }*/ ?>
		</tbody>
	</table>
</div>-->