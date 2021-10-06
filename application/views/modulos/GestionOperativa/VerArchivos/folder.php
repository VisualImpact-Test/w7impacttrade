<style>
	.lk-folder {
		margin-bottom: 1.1em !important;
		font-size: 10px !important;
		padding-left: 1em;
		padding-right: 0.5em;
		width: 150px !important;
		word-wrap: break-word !important;
		white-space: normal !important;
		/* height: 60px; */

		color: #5F6368 !important;
		background-color: rgba(255, 255, 255, 0) !important;
		border-color: rgba(255, 255, 255, 0) !important;
		/* margin-bottom: 80px !important; */
		font-weight: bold;
	}
</style>
<? $contador = 1;
foreach ($grupo as $ix_g => $row_g) { ?>

<div style='font-size: 1.4rem; font-weight:700;margin-left: 30px;'>
	<h2 style="font-weight: bold;"><?= $row_g->nombreGrupo ?></h2>
</div>

<div class="d-flex flex-wrap p-2">
	<?php $contador = 1;
	foreach ($folder[$ix_g] as $ix_f => $row_f) { ?>
		<a href="javascript:;" data-folder="<?= $ix_f ?>" class="btn btn-success btn-sm lk-folder"><i class="fa fa-folder fa-9x"></i><br /><?= $row_f->nombreCarpeta ?></a>
	<?php $contador++;
	} ?>
</div>

<? } ?>