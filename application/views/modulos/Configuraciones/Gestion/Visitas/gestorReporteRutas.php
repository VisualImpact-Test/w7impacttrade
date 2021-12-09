<div class="card-datatable">
	<table id="tb-gestorReporteRutas" class="mb-0 table table-bordered text-nowrap w-100">
		<thead>
			<tr>
				<th class="text-center align-middle" rowspan="2">#</th>
				<th class="text-center align-middle" colspan="3">OPCIONES</th>
				<th class="text-center align-middle" colspan="3">RUTA</th>
				<th class="text-center align-middle" colspan="5">USUARIO</th>
				<th class="text-center align-middle">VISITAS</th>
				<th class="text-center align-middle" colspan="2">ENCARGADO</th>
			</tr>
			<tr>
				<th class="text-center align-middle">EDITAR</th>
				<th class="text-center align-middle">
					<div class="custom-checkbox custom-control">
						<input class="custom-control-input" type="checkbox" id="chkb-rutasAll" name="chkb-rutasAll" value="1">
						<label class="custom-control-label" for="chkb-rutasAll"></label>
					</div>
					MARCAR
				</th>
				<th class="text-center align-middle">ESTADO</th>
				<th class="text-center align-middle">ID RUTA</th>
				<th class="text-center align-middle">CUENTA</th>
				<th class="text-center align-middle">PROYECTO</th>
				<th class="text-center align-middle">FECHA</th>
				<th class="text-center align-middle">COD USUARIO</th>
				<th class="text-center align-middle">ESTADO USUARIO</th>
				<th class="text-center align-middle">USUARIO</th>
				<th class="text-center align-middle">TIPO USUARIO</th>
				<th class="text-center align-middle">NRO</th>
				<th class="text-center align-middle">ID USUARIO</th>
				<th class="text-center align-middle">NOMBRE ENCARGADO</th>
			</tr>
		</thead>
		<tbody>
			<? $ix = 1; ?>
			<? foreach ($listaRutas as $klr => $row) : 
				$badge = $row['estado'] == 1 ? 'badge-success' : 'badge-danger';
                $mensajeEstado = $row['estado'] == 1 ? 'Activo' : 'Inactivo';
                $iconoBotonEstado = $row['estado'] == 1 ? 'fal fa-lg fa-toggle-on' : 'fal fa-lg fa-toggle-off';
			?>
				<tr>
					<td class="text-center"><?= $ix++; ?></td>
					<td class="text-center">
						<button class="btn btn-outline-secondary border-0 btnEditarRuta" data-ruta="<?= $row['idRuta'] ?>"><i class="fas fa-lg fa-edit"></i></button>
					</td>
					<td class="text-center">
						<div class="custom-checkbox custom-control">
							<? if ($row['estado'] == 0) : ?>
								<input class="custom-control-input chkb-rutaInactivo" type="checkbox" id="estado-<?= $row['idRuta'] ?>" name="estado-<?= $row['idRuta'] ?>" value="<?= $row['idRuta'] ?>">
							<? else : ?>
								<input class="custom-control-input chkb-rutaActivo" type="checkbox" id="estado-<?= $row['idRuta'] ?>" name="estado-<?= $row['idRuta'] ?>" value="<?= $row['idRuta'] ?>">
							<? endif ?>
							<label class="custom-control-label custom-control-label-danger" for="estado-<?= $row['idRuta'] ?>"></label>
						</div>
					</td>
					<td data-order="<?= $mensajeEstado ?>" class="text-center style-icons">
                        <span class="badge <?= $badge ?>"><?= $mensajeEstado ?></span>
                    </td>
					<td class="text-center"><?= (!empty($row['idRuta']) ? $row['idRuta'] : '-') ?></td>
					<td class="text-center"><?= (!empty($row['cuenta']) ? $row['cuenta'] : '-') ?></td>
					<td class="text-center"><?= (!empty($row['proyecto']) ? $row['proyecto'] : '-') ?></td>
					<td class="text-center"><?= (!empty($row['fecha']) ? $row['fecha'] : '-') ?></td>
					<td class="text-center"><?= (!empty($row['idUsuario']) ? $row['idUsuario'] : '-') ?></td>
					<td class="text-center"><?= (!empty($row['cesado']) ? "<h4 class='text-center'><span class=' badge badge-danger'>Cesado</span></h4>" : "<h4 class='text-center'><span class='badge badge-primary'>Activo</span></h4>") ?></td>
					<td class="<?!empty($row['cesado']) ? 'text-danger': ''?>"><?= (!empty($row['nombreUsuario']) ? $row['nombreUsuario'] : '-') ?></td>
					<td class="text-center"><?= (!empty($row['tipoUsuario']) ? $row['tipoUsuario'] : '-') ?></td>
					<td class="text-center"><?= (!empty($row['numVisita']) ? $row['numVisita'] : '-') ?></td>
					<td class="text-center"><?= (!empty($row['idUsuarioEncargado']) ? $row['idUsuarioEncargado'] : '-') ?></td>
					<td class=""><?= (!empty($row['nombreUsuarioEncargado']) ? $row['nombreUsuarioEncargado'] : '-') ?></td>
				</tr>
			<? endforeach ?>
		</tbody>
	</table>
</div>