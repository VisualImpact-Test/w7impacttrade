	<div class="card-datatable">
	<table id="tb-modulacion" class="table table-striped table-bordered nowrap dataTable no-footer w-100">
		<thead>
			<tr>
				<th class="noVis"></th>
				<th class="noVis">#</th>
				<th class="text-center align-middle">OPCIONES</th>
				<th class="text-center align-middle">RUTA</th>
				<th class="text-center align-middle">PERFIL USUARIO</th>
				<th class="text-center align-middle">USUARIO</th>
				<th class="text-center align-middle">FECHA INICIO</th>
				<th class="text-center align-middle">FECHA FIN</th>
			</tr>
		</thead>
		<tbody>
			<? $ix=1; ?>
			<?foreach ($ruta as $row){ ?>
				<tr class="" data-idProgRuta = <?=$row['idProgRuta']?>>
					<td></td>
					<td></td>
					<td class="text-center align-middle">
						
					<a href="javascript:;" class="btn-editar-rutas btn-sm btn-outline-secondary border-0" data-id="<?=$row['idProgRuta'];?>" data-fecIni="<?=$row['fecIni'];?>" data-fecFin="<?=$row['fecFin'];?>"><i class="fas fa-edit fa-lg"></i></a>
					<a href="javascript:;" class="btn-rutas-editar-usuarios-tradicional btn-sm btn-outline-secondary border-0" data-id="<?=$row['idProgRuta'];?>"><i class="fa fa-user fa-lg"></i></a>
					
					<a href="javascript:;" class="btn-rutas-eliminar btn-sm btn-outline-secondary border-0" data-id="<?=$row['idProgRuta'];?>"><i class="fas fa-trash fa-lg"></i></a>
					
					<?
						if($row['generado']=="1"){
					?>
						<a href="javascript:;" class="btn-rutas-generada btn  btn-outline-secondary border-0" data-id="<?=$row['idProgRuta'];?>" data-fecIni="<?=$row['fecIni'];?>" data-fecFin="<?=$row['fecFin'];?>"><i class="fas fa-calendar fa-lg"></i></a>
					<?
						}
					?>

					</td>
					<td class="align-middle"><?=$row['nombreRuta'];?></td>
					<td class=""><?=$row['tipoUsuario'];?></td>
					<td class="text-left"><?=$row['usuario'];?></td>
					<td class="text-center align-middle"><?=$row['fecIni'];?></td>
					<td class="text-center align-middle"><?=$row['fecFin'];?></td>
				</tr>
			<? } ?>
		</tbody>
	</table>
	<div