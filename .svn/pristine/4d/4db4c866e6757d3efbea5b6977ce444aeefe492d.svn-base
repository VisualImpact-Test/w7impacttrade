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
					<td class="text-center align-middle">
						
					<a href="javascript:;" class="btn-editar-rutas btn btn-outline-secondary border-0" data-id="<?=$row['idRutaProg'];?>" data-fecIni="<?=$row['fecIni'];?>" data-fecFin="<?=$row['fecFin'];?>"><i class="fas fa-edit fa-lg"></i></a>
					<a href="javascript:;" class="btn-rutas-editar-usuarios-tradicional btn btn-outline-secondary border-0" data-id="<?=$row['idRutaProg'];?>"><i class="fa fa-user fa-lg"></i></a>
					
					<a href="javascript:;" class="btn-rutas-eliminar btn btn-outline-secondary border-0" data-id="<?=$row['idRutaProg'];?>"><i class="fas fa-trash fa-lg"></i></a>
					
					<?
						if($row['generado']=="1"){
					?>
						<a href="javascript:;" class="btn-rutas-generada btn  btn-outline-secondary border-0" data-id="<?=$row['idRutaProg'];?>" data-fecIni="<?=$row['fecIni'];?>" data-fecFin="<?=$row['fecFin'];?>"><i class="fas fa-calendar fa-lg"></i></a>
					<?
						}
					?>

					</td>
					<td class="text-center align-middle"><?=$ix++;?></td>
					<td class="align-middle"><?=$row['nombreRuta'];?></td>
					<td class="align-middle"><?=$row['gtm'];?></td>
					<td class="text-center align-middle"><?=$row['numClientes'];?></td>
					<td class="text-center align-middle"><?=$row['fecIni'];?></td>
					<td class="text-center align-middle"><?=$row['fecFin'];?></td>
				</tr>
			<? } ?>
		</tbody>
	</table>
	<div