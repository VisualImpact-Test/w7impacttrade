<div class="card-datatable">
	<table id="tb-permisos" class="mb-0 table table-bordered text-nowrap w-100">
		<thead>
			<tr>
				<th class="text-center align-middle" rowspan="2">#</th>
				<th class="text-center align-middle" colspan="3">OPCIONES</th>
				<th class="text-center align-middle" rowspan="2">USUARIO</th>
				<th class="text-center align-middle" colspan="2">FECHA DE CARGA</th>
				<th class="text-center align-middle" colspan="2">FECHA DE LISTAS</th>
			</tr>
			<tr>
				<th class="text-center align-middle">ACTIVAR/<br>DESACTIVAR</th>
				<th class="text-center align-middle">HABILITAR<br>EDICIÓN</th>
				<th class="text-center align-middle">EDITAR</th>
				<th class="text-center align-middle">FECHA INICIO CARGA</th>
				<th class="text-center align-middle">FECHA FIN CARGA</th>
				<th class="text-center align-middle">FECHA INICIO LISTA</th>
				<th class="text-center align-middle">FECHA FIN LISTA</th>
			</tr>
		</thead>
		<tbody>
			<? $ix=1; $estadoPermiso=''; $habilitarEditarPermiso='-';$editarPermiso='-'; $vistaEstado='';?>
			<?foreach ($permisos as $row){ ?>
				<? if ($row['estado']==1){
					if ($row['flagEditar']==1) {
						$habilitarEditarPermiso='<button type="button" class="btn btn-success btnHabilitarEditar" title="HABILITADO" data-permiso="'.$row['idPermiso'].'" data-estado="0" data-title-cambio="DESABILITAR EDICIÓN"><i class="fas fa-bell fa-lg"></i></button>';
					} else {
						$habilitarEditarPermiso='<button type="button" class="btn btn-danger btnHabilitarEditar" title="DESHABILITADO" data-permiso="'.$row['idPermiso'].'" data-estado="1" data-title-cambio="HABILITAR EDICIÓN"><i class="fas fa-bell-slash fa-lg"></i></button>';
					}

					$estadoPermiso='<a href="javascript:;" id="aPermiso-'.$row['idPermiso'].'" class="btn btn-primary btnCambiarEstado" title="ACTIVO" data-permiso="'.$row['idPermiso'].'" data-estado="0" data-title-cambio="DESACTIVAR" data-flag-editar="'.$row['flagEditar'].'"><i class="fas fa-toggle-on fa-lg"></i></a>';
					$editarPermiso='<button class="btn btn-success editarPermiso" data-permiso="'.$row['idPermiso'].'" title="EDITAR PERMISO" ><i class="fas fa-edit fa-lg"></i></button>';
					$vistaEstado='<span class="el-estado btn-success">ACTIVO</span>';
				} else {
					$estadoPermiso='<a href="javascript:;" id="aPermiso-'.$row['idPermiso'].'" class="btn btn-danger btnCambiarEstado" title="DESACTIVADO" data-permiso="'.$row['idPermiso'].'" data-estado="1" data-title-cambio="ACTIVAR" data-flag-editar="'.$row['flagEditar'].'"><i class="fas fa-toggle-off fa-lg"></i></a>';
					$habilitarEditarPermiso='<span>-</span>';
					$editarPermiso='<span>-</span>';
					$vistaEstado='<span class="btn-danger el-estado">DESACTIVO</span>';		
				} ?>
				<tr id="trp-<?=$row['idPermiso']?>">
					<td class="text-center"><?=$ix++;?></td>
					<td id="tdEstado-<?=$row['idPermiso']?>" class="text-center"><?=$estadoPermiso;?></td>
					<td id="tdHabEditar-<?=$row['idPermiso']?>" class="text-center"><?=$habilitarEditarPermiso;?></td>
					<td id="tdEditar-<?=$row['idPermiso']?>" class="text-center"><?=$editarPermiso;?></td>
					<td class="text-center"><?=$row['usuario'];?></td>
					<td class="text-center"><?=$row['fecIniCarga'];?></td>
					<td class="text-center"><?=$row['fecFinCarga'];?></td>
					<td class="text-center"><?=$row['fecIniLista'];?></td>
					<td class="text-center"><?=$row['fecFinLista'];?></td>
				</tr>
			<? } ?>
		</tbody>
	</table>
</div>