<div class="card-datatable">
<table id="tb-gestorReporteVisitas" class="mb-0 table table-bordered text-nowrap w-100">
	<thead>
		<tr>
			<th class="text-center align-middle" rowspan="2">#</th>
			<th class="text-center align-middle" colspan="4">OPCIONES</th>
			<th class="text-center align-middle" colspan="3">RUTA</th>
			<th class="text-center align-middle" colspan="6">VISITA</th>
		</tr>
		<tr>
			<th class="text-center align-middle">
				<div class="custom-checkbox custom-control">
					<input class="custom-control-input" type="checkbox" id="chkb-visitasAll" name="chkb-visitasAll" value="1">
					<label class="custom-control-label" for="chkb-visitasAll"></label>
				</div>
				MARCAR
			</th>
			<th class="text-center align-middle">ESTADO</th>
			<th class="text-center align-middle">CONTINGENCIA</th>
			<th class="text-center align-middle">EXCLUIDO</th>
			<th class="text-center align-middle">FECHA</th>
			<th class="text-center align-middle">ID USUARIO</th>
			<th class="text-center align-middle">ESTADO USUARIO</th>
			<th class="text-center align-middle">USUARIO</th>
			<th class="text-center align-middle">ID CLIENTE</th>
			<th class="text-center align-middle">CLIENTE</th>
			<th class="text-center align-middle">CANAL</th>
			<th class="text-center align-middle">DISTRIBUIDORA</th>
			<th class="text-center align-middle">PLAZA</th>
			<th class="text-center align-middle">DIRECCIÓN</th>
		</tr>
	</thead>
	<tbody>
		<? $ix=1; ?>
		<? foreach ($listaVisitas as $klv => $row): 
			$badge = $row['estado'] == 1 ? 'badge-success' : 'badge-danger';
			$mensajeEstado = $row['estado'] == 1 ? 'Activo' : 'Inactivo';
			$iconoBotonEstado = $row['estado'] == 1 ? 'fal fa-lg fa-toggle-on' : 'fal fa-lg fa-toggle-off';
		?>
			<tr > 
				<td class="text-center"><?=$ix++;?></td>
				<td class="text-center">
					<div class="custom-checkbox custom-control" visita="<?=$row['idVisita']?>">
						<? if ( $row['estado']==1 ): ?>
							<input class="custom-control-input chkb-visitaActivo" type="checkbox" id="estado-<?=$row['idVisita']?>" name="estado-<?=$row['idVisita']?>" value="<?=$row['idVisita']?>"  estadoExclusion=<?=$row['idTipoExclusion']?> >
						<? else: ?>
							<input class="custom-control-input chkb-visitaInactivo" type="checkbox" id="estado-<?=$row['idVisita']?>" name="estado-<?=$row['idVisita']?>" value="<?=$row['idVisita']?>" estadoExclusion=<?=$row['idTipoExclusion']?>>
						<? endif ?>

						<? if ( $row['idTipoExclusion']==null ): ?>
							<input class="chkb-visitaIncluido" type="checkbox" id="exclusion-<?=$row['idVisita']?>" tipo="incluido" name="exclusion-<?=$row['idVisita']?>" value="<?=$row['idVisita']?>" style="display:none;">
						<? else: ?>
							<input class="chkb-visitaExcluido" type="checkbox" id="exclusion-<?=$row['idVisita']?>" tipo="excluido" name="exclusion-<?=$row['idVisita']?>" value="<?=$row['idVisita']?>" style="display:none;">
						<? endif ?>
						<label class="custom-control-label" for="estado-<?=$row['idVisita']?>" ></label>
					</div>
				</td>
				<td data-order="<?= $mensajeEstado ?>" class="text-center style-icons">
					<span class="badge <?= $badge ?>"><?= $mensajeEstado ?></span>
				</td>
				<?
					$estadoExclusion='';
					if ( isset($row['idTipoExclusion']) ) {
						$estadoExclusion = '<div><span class="color-F"></span> EXCLUIDO</div>';
					}else{
						$estadoExclusion ='<div><span class="color-C"></span> - </div>';
					}
					
					$estadoContingencia='';
					if ( $row['flagContingencia']==1 ) {
						$estadoContingencia = '<div><span class="color-F"></span> HABILITADO</div>';
					}else{
						$estadoContingencia ='<div><span class="color-C"></span> INHABILITADO </div>';
					}
				?>
				<td class="text-center"><?=(!empty($estadoContingencia)?$estadoContingencia:'-')?></td>

				<td class="text-center"><?=(!empty($estadoExclusion)?$estadoExclusion:'-')?></td>
				<td class="text-center"><?=(!empty($row['fecha'])?$row['fecha']:'-')?></td>
				<td class="text-center"><?=(!empty($row['idUsuario'])?$row['idUsuario']:'-')?></td>
				<td class="text-center"><?= (!empty($row['cesado']) ? "<h4 class='text-center'><span class=' badge badge-danger'>Cesado</span></h4>" : "<h4 class='text-center'><span class='badge badge-primary'>Activo</span></h4>") ?></td>
				<td class="<?=!empty($row['cesado']) ? 'text-danger': ''?>"><?=(!empty($row['nombreUsuario'])?$row['nombreUsuario']:'-')?></td>
				<td class="text-center"><?=(!empty($row['idCliente'])?$row['idCliente']:'-')?></td>
				<td class=""><?=(!empty($row['razonSocial'])?$row['razonSocial']:'-')?></td>
				<td class="text-center"><?=(!empty($row['canal'])?$row['canal']:'-')?></td>
				<td class=""><?=(!empty($row['distribuidora'])?$row['distribuidora']:'-')?></td>
				<td class=""><?=(!empty($row['plaza'])?$row['plaza']:'-')?></td>
				<td class=""><?=(!empty($row['direccion'])?$row['direccion']:'-')?></td>
			</tr>
		<? endforeach ?>
	</tbody>
</table>
</div>