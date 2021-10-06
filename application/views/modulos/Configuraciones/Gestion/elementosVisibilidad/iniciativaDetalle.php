<div class="card-datatable">
<table id="tb-detalleIniciativa" class="table table-striped table-bordered nowrap table-sm" width="100%">
	<thead>
		<tr>
			<th class="text-center" rowspan="2">#</th>
			<th class="text-center" colspan="3">OPCIONES</th>
			<th class="text-center" colspan="8">LISTA DE VISIBILIDAD AUDITORIA INICIATIVA</th>

		</tr>
		<tr>
			<th class="text-center">ALL<br><input type="checkbox" id="chkb-estadoAllIniciativas" name="chkb-estadoAllIniciativas" class="dataEstadoAllElementos"></th>
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
		<? foreach ($listaIniciativas as $key => $lista): ?>
			<? if ( empty($lista['fecFin']) ) {
				$checkboxLista='<input type="checkbox" name="cambiarEstadoLista" class="cambiarEstadoLista" data-lista="'.$lista['idListVisibilidadIni'].'" value="0" data-tipo-visibilidad="iniciativa">';
				$estadoLista='<a href="javascript:;" id="aIniciativa-'.$lista['idListVisibilidadIni'].'" class="btn btn-primary btnCambiarListaFechaFin" title="ACTIVO" data-lista="'.$lista['idListVisibilidadIni'].'" data-estado="0" data-title-cambio="DESACTIVAR"><i class="fas fa-toggle-on fa-lg"></i></a>';
				$editarLista='<button class="btn btn-success editarLista" title="EDITAR LISTA" data-lista="'.$lista['idListVisibilidadIni'].'"><i class="fas fa-edit fa-lg"></i></button>';
				$vistaEstado='<span class="el-estado btn-success">ACTIVO</span>';
			} else {
				$checkboxLista='<input type="checkbox" name="cambiarEstadoLista" class="cambiarEstadoLista" data-lista="'.$lista['idListVisibilidadIni'].'" value="1" data-tipo-visibilidad="iniciativa">';
				$estadoLista='<a href="javascript:;" id="aIniciativa-'.$lista['idListVisibilidadIni'].'" class="btn btn-danger btnCambiarListaFechaFin" title="DESACTIVADO" data-lista="'.$lista['idListVisibilidadIni'].'" data-estado="1" data-title-cambio="ACTIVAR"><i class="fas fa-toggle-off fa-lg"></i></a>';
				$editarLista='<span>-</span>';
				$vistaEstado='<span class="btn-danger el-estado">DESACTIVO</span>';		
			} ?>

			<tr id="tr-<?=$lista['idListVisibilidadIni']?>" data-lista="<?=$lista['idListVisibilidadIni']?>">
				<td class="text-center"><?=$ix++;?></td>
					<td class="text-center" id="tdChkb-<?=$lista['idListVisibilidadIni']?>"><?=$checkboxLista;?></td>
					<td class="text-center" id="tdEstado-<?=$lista['idListVisibilidadIni']?>"><?=$estadoLista;?></td>
					<td class="text-center" id="tdEditar-<?=$lista['idListVisibilidadIni']?>"><?=$editarLista;?></td>
					<td class="text-center"><?=(!empty($lista['fecIni'])?$lista['fecIni']:'-');?></td>
					<td class="text-center" id="tdFecFin-<?=$lista['idListVisibilidadIni']?>"><?=(!empty($lista['fecFin'])?$lista['fecFin']:'-');?></td>
					<td class=""><?=(!empty($lista['grupoCanal'])?$lista['grupoCanal']:'-');?></td>
					<td class=""><?=(!empty($lista['canal'])?$lista['canal']:'-');?></td>
					<td class=""><?=(!empty($lista['proyecto'])?$lista['proyecto']:'-');?></td>
					<td class=""><?=(!empty($lista['cliente'])?$lista['cliente']:'-');?></td>
					<td class="text-center"><?=(!empty($lista['fechaCreacion'])?$lista['fechaCreacion']:'-');?></td>
					<td class="text-center" id="tdVistaEstado-<?=$lista['idListVisibilidadIni']?>"><?=$vistaEstado;?></td>
			</tr>
		<? endforeach ?>
	</tbody>
</table>
</div>