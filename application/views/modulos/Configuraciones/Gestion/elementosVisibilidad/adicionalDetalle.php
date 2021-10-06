<div class="card-dataTable">
<table id="tb-detalleAdicional" class="table table-striped table-bordered nowrap table-sm" width="100%">
	<thead>
		<tr>
			<th class="text-center" rowspan="2">#</th>
			<th class="text-center" colspan="3">OPCIONES</th>
			<th class="text-center" colspan="8">LISTA DE VISIBILIDAD AUDITORIA ADICIONAL</th>

		</tr>
		<tr>
			<th class="text-center">ALL<br><input type="checkbox" id="chkb-estadoAllAdicionales" name="chkb-estadoAllAdicionales" class="dataEstadoAllElementos"></th>
			<th class="text-center">DE BAJA/<br>DE ALTA</th>
			<th class="text-center">EDITAR</th>
			<th class="text-center">FECHA<br>INICIO</th>
			<th class="text-center">FECHA<br>FIN</th>
			<th class="text-center">GRUPO<br>CANAL</th>
			<th class="text-center">CANAL</th>
			<th class="text-center">PROYECTO</th>
			<th class="text-center">CLIENTE</th>
			<th class="text-center">FECHA REGISTRO</th>
			<th class="text-center">ESTADO</th>
		</tr>
	</thead>
	<tbody>
		<? $ix=1; $checkboxLista=''; $estadoLista=''; $editarLista='-'; $vistaEstado='';?>
		<? foreach ($listaAdicional as $kla => $lista): ?>
			<? if ( empty($lista['fecFin']) ) {
				$checkboxLista='<input type="checkbox" name="cambiarEstadoLista" class="cambiarEstadoLista" data-lista="'.$lista['idListVisibilidadAdc'].'" value="0" data-tipo-visibilidad="adicional">';
				$estadoLista='<a href="javascript:;" id="aAdicional-'.$lista['idListVisibilidadAdc'].'" class="btn btn-primary btnCambiarListaFechaFin" title="ACTIVO" data-lista="'.$lista['idListVisibilidadAdc'].'" data-estado="0" data-title-cambio="DESACTIVAR"><i class="fas fa-toggle-on fa-lg"></i></a>';
				$editarLista='<button class="btn btn-success editarLista" title="EDITAR LISTA" data-lista="'.$lista['idListVisibilidadAdc'].'"><i class="fas fa-edit fa-lg"></i></button>';
				$vistaEstado='<span class="el-estado btn-success">ACTIVO</span>';
			} else {
				$checkboxLista='<input type="checkbox" name="cambiarEstadoLista" class="cambiarEstadoLista" data-lista="'.$lista['idListVisibilidadAdc'].'" value="1" data-tipo-visibilidad="adicional">';
				$estadoLista='<a href="javascript:;" id="aAdicional-'.$lista['idListVisibilidadAdc'].'" class="btn btn-danger btnCambiarListaFechaFin" title="DESACTIVADO" data-lista="'.$lista['idListVisibilidadAdc'].'" data-estado="1" data-title-cambio="ACTIVAR"><i class="fas fa-toggle-off fa-lg"></i></a>';
				$editarLista='<span>-</span>';
				$vistaEstado='<span class="btn-danger el-estado">DESACTIVO</span>';		
			} ?>

			<tr id="tr-<?=$lista['idListVisibilidadAdc']?>" data-lista="<?=$lista['idListVisibilidadAdc']?>">
				<td class="text-center"><?=$ix++;?></td>
					<td class="text-center" id="tdChkb-<?=$lista['idListVisibilidadAdc']?>"><?=$checkboxLista;?></td>
					<td class="text-center" id="tdEstado-<?=$lista['idListVisibilidadAdc']?>"><?=$estadoLista;?></td>
					<td class="text-center" id="tdEditar-<?=$lista['idListVisibilidadAdc']?>"><?=$editarLista;?></td>
					<td class="text-center"><?=(!empty($lista['fecIni'])?$lista['fecIni']:'-');?></td>
					<td class="text-center" id="tdFecFin-<?=$lista['idListVisibilidadAdc']?>"><?=(!empty($lista['fecFin'])?$lista['fecFin']:'-');?></td>
					<td class=""><?=(!empty($lista['grupoCanal'])?$lista['grupoCanal']:'-');?></td>
					<td class=""><?=(!empty($lista['canal'])?$lista['canal']:'-');?></td>
					<td class=""><?=(!empty($lista['proyecto'])?$lista['proyecto']:'-');?></td>
					<td class=""><?=(!empty($lista['cliente'])?$lista['cliente']:'-');?></td>
					<td class="text-center"><?=(!empty($lista['fechaCreacion'])?$lista['fechaCreacion']:'-');?></td>
					<td class="text-center" id="tdVistaEstado-<?=$lista['idListVisibilidadAdc']?>"><?=$vistaEstado;?></td>
			</tr>
		<? endforeach ?>
	</tbody>
</table>
</div>