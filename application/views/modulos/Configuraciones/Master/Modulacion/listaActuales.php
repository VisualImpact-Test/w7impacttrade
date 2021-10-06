<div class="card-datatable">
<? $verGenerarLista = ($htmlGenerarLista)?'':'d-none'; ?>
<? $htmlColSpanOpciones = ($htmlGenerarLista)?3:2; ?>
<table id="tb-permisosActuales" class="mb-0 table table-bordered text-nowrap w-100" >
	<thead>
		<tr>
			<th class="text-center align-middle" rowspan="2">#</th>
			<th class="text-center align-middle <?=$verGenerarLista;?>" rowspan="2">ALL<br><input type="checkbox" id="chkb-checkAllPermisos" name="chkb-checkAllPermisos" class="dataCheckAllPermisos"></th>
			<th class="text-center align-middle" colspan="<?=$htmlColSpanOpciones;?>">OPCIONES</th>
			<th class="text-center align-middle" rowspan="2">USUARIO</th>
			<th class="text-center align-middle" colspan="2">FECHA DE CARGA</th>
			<th class="text-center align-middle" colspan="2">FECHA DE LISTAS</th>
		</tr>
		<tr>
			<th class="text-center align-middle">VER<br>CLIENTES</th>
			<th class="text-center align-middle">CARGAR<br>MODULACIÓN</th>
			<th class="text-center align-middle <?=$verGenerarLista;?>">GENERAR<br>LISTAS</th>
			<th class="text-center align-middle">FECHA INICIO CARGA</th>
			<th class="text-center align-middle">FECHA FIN CARGA</th>
			<th class="text-center align-middle">FECHA INICIO LISTA</th>
			<th class="text-center align-middle">FECHA FIN LISTA</th>
		</tr>
	</thead>
	<tbody>
		<? $ix=1; ?>
		<? foreach ($listaPermisos as $klp => $permiso): ?>
			<? $htmlTdCargarModulación = ( $permiso['flagEditar']==1 ? '<button type="button" class="btn btn-primary cargarModulacion" data-permiso="'.$permiso['idPermiso'].'" data-usuario="'.$permiso['idUsuario'].'" title="Cargar Modulación" data-url="registrarModulacion"><i class="fas fa-upload fa-lg"></i></button>':'<span>-</span>' ); ?>
			<? $htmlTdCargarMasiva = ( $permiso['flagEditar']==1 ? '<button type="button" class="btn btn-primary cargarMasiva" data-permiso="'.$permiso['idPermiso'].'" data-usuario="'.$permiso['idUsuario'].'" title="Cargar Modulación Masivo" data-url="registrarModulacionMasivo"><i class="fas fa-file-upload fa-lg"></i></button>':'<span>-</span>' ); ?>
			<? $htmlTdGenerarLista = ( $permiso['flagEditar']==1 ? '<button type="button" class="btn btn-danger generarLista" data-permiso="'.$permiso['idPermiso'].'" title="Generar Lista"><i class="fas fa-share-square fa-lg"></i></i></button>':'<span>-</span>' ); ?>
			<tr id="trp-<?=$permiso['idPermiso']?>">
				<td class="text-center align-middle"><?=$ix++;?></td>
				<td class="text-center align-middle <?=$verGenerarLista;?>" id="tdCheck-<?=$permiso['idPermiso']?>">
					<input type="checkbox" name="generarListaPermiso" class="generarListaPermiso" value="<?=$permiso['idPermiso']?>">
				</td>
				<td class="text-center" id="tdVer-<?=$permiso['idPermiso']?>">
					<button type="button" class="btn btn-success verModulacion" data-permiso="<?=$permiso['idPermiso']?>" data-usuario="<?=$permiso['idUsuario']?>" title="VER MODULACIÓN" data-lista="actual"><i class="fas fa-eye fa-lg"></i></button>
				</td>
				<td class="text-center" id="tdCargar-<?=$permiso['idPermiso']?>"><?=$htmlTdCargarModulación;?>  <?=$htmlTdCargarMasiva;?></td>
				<td class="text-center <?=$verGenerarLista;?>" id="tdLista-<?=$permiso['idPermiso']?>"><?=$htmlTdGenerarLista;?></td>
				<td class=""><?=$permiso['usuario'];?></td>
				<td class="text-center"><?=$permiso['fecIniCarga'];?></td>
				<td class="text-center"><?=$permiso['fecFinCarga'];?></td>
				<td class="text-center"><?=$permiso['fecIniLista'];?></td>
				<td class="text-center"><?=$permiso['fecFinLista'];?></td>
			</tr>
		<? endforeach ?>
	</tbody>
</table>
</div>