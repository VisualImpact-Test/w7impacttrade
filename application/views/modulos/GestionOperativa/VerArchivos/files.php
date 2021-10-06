<div class="card-datatable">
		<table id="data-table" class="table table-bordered text-nowrap" style="width:100%; font-size:12px;">
			<thead>
				<tr class="">
					<th>#</th>
					<th>GRUPO</th>
					<th>CARPETA</th>
					<th>NOMBRE</th>
					<th>CREADOR</th>
					<th>TIPO</th>
					<th>FECHA</th>
					<th>HORA</th>
					<th>TAMAÑO</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1;
				foreach ($grupo as $ix_g => $row_g) { ?>
					<?php foreach ($folder[$ix_g] as $ix_f => $row_f) { ?>
						<?php foreach ($archivos[$ix_g][$ix_f] as $ix_a => $row_a) { ?>
							<tr>
								<td class="text-center"><?= $i++ ?></td>
								<td class="text-center"><?= $row_a->nombreGrupo ?></td>
								<td><?= $row_a->nombreCarpeta ?></td>
								<td>
									<div style="width:200px; word-wrap: break-word !important; white-space: normal !important;">
										<a href="javascript:;" class="lk-download" data-nombregrupo="<?= $row_a->nombreGrupo ?>" data-nombrecarpeta="<?= $row_a->nombreCarpeta ?>" data-usuarioautor="<?= $row_a->nombreUsuarioCreador ?>" data-usuarioautorcorreo="" data-idfile="<?= $row_a->idArchivo ?>" data-file="<?= $row_a->nombreArchivo ?>" data-extension="<?= $row_a->extension ?>" data-name="<?= $row_a->nombreRegistrado ?>">
											<i class="fa fa-download" aria-hidden="true"></i>
											<?= $row_a->nombreRegistrado . '.' . $row_a->extension ?>
										</a>
									</div>
								</td>
								<td><?= $row_a->nombreUsuarioCreador ?></td>
								<td class="text-center"><?= $row_a->tipoArchivo ?></td>
								<td class="text-center"><?= $row_a->fecha ?></td>
								<td class="text-center"><?= $row_a->hora ?></td>
								<td class="text-center"><?= formatBytes($row_a->peso) ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
</div>
<div id="vista-miniatura" style="display:none;  overflow-y: auto; overflow-x: hidden;">
	<div class="d-flex flex-wrap">
		<?php $i = 1;
		foreach ($grupo as $ix_g => $row_g) { ?>
			<?php foreach ($folder[$ix_g] as $ix_f => $row_f) { ?>
				<?php foreach ($archivos[$ix_g][$ix_f] as $ix_a => $row_a) { ?>
					<div class="text-center">
						<?
							$array_icon = array(
								'Excel' => 'fa fa-file-excel-o', 'Word' => 'fa fa-file-word-o', 'Imagen' => 'fa fa-picture-o', 'PDF' => 'fa fa-file-pdf-o', 'Vídeo' => 'fa fa-file-video-o', 'PowerPoint' => 'fa fa-file-powerpoint-o'
							);
							?>
						<div style="font-size: 48px" class="text-center">
							<a href="javascript:;" class="lk-download" data-nombregrupo="<?= $row_a->nombreGrupo ?>" data-nombrecarpeta="<?= $row_a->nombreCarpeta ?>" data-usuarioautor="<?= $row_a->nombreUsuarioCreador ?>" data-usuarioautorcorreo="" data-idfile="<?= $row_a->idArchivo ?>" data-file="<?= $row_a->nombreArchivo ?>" data-extension="<?= $row_a->extension ?>" data-name="<?= $row_a->nombreRegistrado ?>">
								<i class="<?= isset($array_icon[$row_a->tipoArchivo]) ? $array_icon[$row_a->tipoArchivo] : 'fa fa-file' ?>" aria-hidden="true"></i>
							</a>
						</div>
						<div style="font-size:10px; font-weight: bold; width: 150px; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;" title="<?= $row_a->nombreRegistrado . '.' . $row_a->extension ?>">
							<?= $row_a->nombreRegistrado . '.' . $row_a->extension ?>
						</div>
						<div style="font-size:10px;">
							<?= $row_a->nombreUsuarioCreador ?>
						</div>
						<div style="font-size:10px;">
							<?= $row_a->fecha ?>
						</div>
						<div style="font-size:10px;">
							<?= $row_a->hora ?>
						</div>
					</div>
				<?php } ?>
			<?php } ?>
		<?php } ?>
	</div>
</div>