	<div class="card-datatable">
	<table id="tb-modulacion" class="table table-striped table-bordered nowrap dataTable no-footer" style="width:100%;">
		<thead>
			<tr>
				<th class="text-center align-middle" rowspan="1" >#</th>
				<th class="text-center align-middle" rowspan="1" >TIPO CLIENTE</th>
				<th class="text-center align-middle" rowspan="1" >MIN CATEGORIAS</th>
				<th class="text-center align-middle" rowspan="1" >MIN ELEMENTOS</th>
				<th class="text-center align-middle" rowspan="1" ></th>
				
			</tr>
		</thead>
		<tbody>
			<? foreach ($validacion as $row_e){ ?>
				<tr>
					<td class="text-center"><?=$row_e['idValidacion']?></td>
					<td class="text-center"><?=$row_e['nombre']?></td>
					<td class="text-center"><?=$row_e['minCategorias']?></td>
					<td class="text-center"><?=$row_e['minElementosOblig']?></td>
					<td>
						<button type="button" class="btn btn-danger editar" data-permiso="<?=$row_e['idValidacion']?>" title="EDITAR">
						<i class="fas fa-edit fa-lg" aria-hidden="true"></i></button>
					</td>
				</tr>
			<? } ?>
		</tbody>
	</table>
	</div>