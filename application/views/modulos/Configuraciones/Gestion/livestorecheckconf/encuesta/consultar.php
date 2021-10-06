<div class="card-datatable">
<table id="tb-live-list-encuesta" class="mb-0 table table-sm no-footer w-100 text-nowrap" width="100%">
	<thead class="thead-light">
		<tr>
			<th class="no-sort"></th>
			<th>#</th>
			<th>OPCIONES</th>
			<th>CUENTA</th>
			<th>FORMATO</th>
			<th>PREGUNTAS</th>
			<th>TIENDA</th>
			<th>ESTADO</th>
			<th class="no-sort"></th>
		</tr>
	</thead>
	<tbody>
		<?$i = 1;?>
		<?foreach($data as $value){
            $badge = $value['estado'] == 1 ? 'badge-success' : 'badge-danger';
            $mensajeEstado = $value['estado'] == 1 ? 'Activo' : 'Inactivo';
            $iconoBotonEstado = $value['estado'] == 1 ? 'fa fa-toggle-on fa-lg' : 'fa fa-toggle-off fa-lg';    
        ?>
		<tr data-id="<?=$value['idEncuesta']?>" data-estado="<?= $value['estado'] ?>">
            <td></td>
			<td><?=$i++?></td>
            <td>
                <div>
                    <!-- <button class="btn btn-Editar btn-outline-secondary border-0" title="Editar"><i class="fas fa-edit fa-lg"></i></button> -->
                    <button class="btn btn-CambiarEstado btn-outline-secondary border-0" title="Activar/Desactivar"><i class="<?= $iconoBotonEstado ?>"></i></button>
                </div>
            </td>
			<td><?=$value['cuenta']?></td>
			<td><?=$value['nombre']?></td>
			<td><?=$value['numPreg']?></td>
			<td><?=!empty($value['flag_cliente'])? "SI": "NO" ?></td>
            <td data-order="<?= $mensajeEstado ?>" class="style-icons">
                <span class="badge <?= $badge ?>"><?= $mensajeEstado ?></span>
            </td>
			<td class="text-center">
				<button class="btn-live-encuesta-ver btn btn-xs" data-id="<?=$value['idEncuesta']?>" title="Ver Detalle"><i class="fa fa-eye"></i></button>
			</td>
		</tr>
		<?}?>
	</tbody>
</table>
</div>