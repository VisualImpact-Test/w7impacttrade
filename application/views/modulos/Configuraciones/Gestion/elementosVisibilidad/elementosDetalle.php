<div class="card-datatable">
<table id="tb-elementosDetalle" class="table table-striped table-bordered nowrap table-sm" width="100%">
	<thead>
		<tr>
			<th class="text-center" rowspan="2">#</th>
			<th class="text-center" colspan="3">OPCIONES</th>
			<th class="text-center" colspan="5">ELEMENTO</th>
		</tr>
		<tr>
			<th class="text-center">ALL<br><input type="checkbox" id="chkb-estadoAllElementos" name="chkb-estadoAllElementos" class="dataEstadoAllElementos"></th>
			<th class="text-center">ACTIVAR/<br>DESACTIVAR</th>
			<th class="text-center">EDITAR</th>
			<th class="text-center">NOMBRE</th>
			<th class="text-center">TIPO</th>
			<th class="text-center">CATEGORÍA</th>
			<th class="text-center">FECHA REGISTRO</th>
			<th class="text-center">ESTADO</th>
		</tr>
	</thead>
	<tbody>
		<? $ix=1; $estadoElemento=''; $editarElemento='-'; $vistaEstado='';?>
		<? foreach ($listaElementos as $kle => $elemento): ?>
			<? if ($elemento['estado']==1){
				$estadoElemento='<a href="javascript:;" id="aElemento-'.$elemento['idElementoVis'].'" class="btn btn-primary btnCambiarEstado" title="ACTIVO" data-elemento="'.$elemento['idElementoVis'].'" data-estado="0" data-title-cambio="DESACTIVAR"><i class="fas fa-toggle-on fa-lg"></i></a>';
				$editarElemento='<button class="btn btn-success editarElemento" title="EDITAR ELEMENTO" data-elemento="'.$elemento['idElementoVis'].'"><i class="fas fa-edit fa-lg"></i></button>';
				$vistaEstado='<span class="el-estado btn-success">ACTIVO</span>';			
			} else {
				$estadoElemento='<a href="javascript:;" id="aElemento-'.$elemento['idElementoVis'].'" class="btn btn-danger btnCambiarEstado" title="DESACTIVADO" data-elemento="'.$elemento['idElementoVis'].'" data-estado="1" data-title-cambio="ACTIVAR"><i class="fas fa-toggle-off fa-lg"></i></a>';
				$editarElemento='<span>-</span>';
				$vistaEstado='<span class="btn-danger el-estado">DESACTIVO</span>';		
			} ?>
			<tr id="tr-<?=$elemento['idElementoVis']?>" data-elemento="<?=$elemento['idElementoVis']?>">
				<td class="text-center"><?=$ix++;?></td>
				<td class="text-center" id="tdChkb-<?=$elemento['idElementoVis']?>">
					<input type="checkbox" name="cambiarEstado" class="cambiarEstado" data-elemento="<?=$elemento['idElementoVis']?>">
				</td>
				<td class="text-center" id="tdBtn-<?=$elemento['idElementoVis']?>"><?=$estadoElemento;?></td>
				<td class="text-center" id="tdEditar-<?=$elemento['idElementoVis']?>"><?=$editarElemento;?></td>
				<td class="text-center"><?=$elemento['elemento'];?></td>
				<td class="text-center"><?=$elemento['tipoElemento'];?></td>
				<td class="text-center"><?=(!empty($elemento['categoria'])?$elemento['categoria']:'-');?></td>
				<td class="text-center"><?=(!empty($elemento['fechaCreacion'])?$elemento['fechaCreacion']:'-');?></td>
				<td class="text-center" id="tdEstado-<?=$elemento['idElementoVis']?>"><?=$vistaEstado;?></td>
			</tr>
		<? endforeach ?>
	</tbody>
</table>
</div>