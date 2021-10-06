	<div class="card-datatable">
	<table id="tb-modulacion" class="table table-striped table-bordered nowrap dataTable no-footer" style="width:100%;">
		<thead>
			<tr>
				
				<th class="text-center align-middle">OPCIONES</th>
				<th class="text-center align-middle">#</th>
				<th class="text-center align-middle">RUTA</th>
				<th class="text-center align-middle">GTM</th>
				<th class="text-center align-middle"># CLIENTES</th>
				<th class="text-center align-middle">FECHA INICIO</th>
				<th class="text-center align-middle">FECHA FIN</th>
			</tr>
		</thead>
		<tbody>
			<? $ix=1; ?>
			<?foreach ($ruta as $row){ ?>
				<tr>
					<td class="text-center">
						
					<a href="javascript:;" class="btn-editar-rutas btn btn-default btn-xs" data-id="<?=$row['idRutaProg'];?>" data-fecIni="<?=$row['fecIni'];?>" data-fecFin="<?=$row['fecFin'];?>" style="float: left;"><i class="fas fa-edit"></i></a>
					<a href="javascript:;" class="btn-rutas-editar-usuarios-tradicional btn btn-default btn-xs" data-id="<?=$row['idRutaProg'];?>" style="float: left;"><i class="fa fa-user"></i></a>
					
					<a href="javascript:;" class="btn-rutas-eliminar btn btn-default btn-xs" data-id="<?=$row['idRutaProg'];?>" style="float: left;"><i class="fas fa-trash"></i></a>
					
					</td>
					<td class="text-center"><?=$ix++;?></td>
					<td class="text-center"><?=$row['nombreRuta'];?></td>
					<td class="text-center"><?=$row['gtm'];?></td>
					<td class="text-center"><?=$row['numClientes'];?></td>
					<td class="text-center"><?=$row['fecIni'];?></td>
					<td class="text-center"><?=$row['fecFin'];?></td>
				</tr>
			<? } ?>
		</tbody>
	</table>
	<div