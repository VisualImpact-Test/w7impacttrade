<div class="card-datatable">
	<table id="tb-permisosAntiguos" class="mb-0 table table-bordered text-nowrap w-100">
		<thead>
			<tr>
				<th class="text-center align-middle" rowspan="2">#</th>
				<th class="text-center align-middle" colspan="2">OPCIONES</th>
				<th class="text-center align-middle" rowspan="2">USUARIO</th>
				<th class="text-center align-middle" colspan="2">FECHA DE CARGA</th>
				<th class="text-center align-middle" colspan="2">FECHA DE LISTAS</th>
			</tr>
			<tr>
				<th class="text-center align-middle">VER<br>CLIENTES</th>
				<th class="text-center align-middle">GENERAR<br>LISTAS</th>
				<th class="text-center align-middle">FECHA INICIO CARGA</th>
				<th class="text-center align-middle">FECHA FIN CARGA</th>
				<th class="text-center align-middle">FECHA INICIO LISTA</th>
				<th class="text-center align-middle">FECHA FIN LISTA</th>
			</tr>
		</thead>
		<tbody>
			<? $ix = 1; ?>
			<? foreach ($listaPermisos as $klp => $permiso) : ?>
				<? $htmlGenerarLista = ($permiso['flagEditar'] == 1 ? '<button type="button" class="btn btn-outline-danger border-0 generarLista" data-permiso="' . $permiso['idPermiso'] . '" title="Generar Lista"><i class="fas fa-share-square fa-lg"></i></i></button>' : '<span>-</span>'); ?>
				<tr id="trp-<?= $permiso['idPermiso'] ?>">
					<td class="text-center align-middle"><?= $ix++; ?></td>
					<td class="text-center" id="tdVer-<?= $permiso['idPermiso'] ?>">
						<button type="button" class="btn btn-outline-secondary border-0 verModulacionAntigua" data-permiso="<?= $permiso['idPermiso'] ?>" data-usuario="<?= $permiso['idUsuario'] ?>" title="Ver Modulación" data-lista="antigua"><i class="fas fa-eye fa-lg"></i></button>
					</td>
					<td class="text-center" id="tdLista-<?= $permiso['idPermiso'] ?>"><?= $htmlGenerarLista; ?></td>
					<td class=""><?= $permiso['usuario']; ?></td>
					<td class="text-center"><?= $permiso['fecIniCarga']; ?></td>
					<td class="text-center"><?= $permiso['fecFinCarga']; ?></td>
					<td class="text-center"><?= $permiso['fecIniLista']; ?></td>
					<td class="text-center"><?= $permiso['fecFinLista']; ?></td>
				</tr>
			<? endforeach ?>
		</tbody>
	</table>
</div>