<? foreach ($grupo as $ix_g => $row_g) { ?>
<div style='font-size: 1.4rem; font-weight:700;'><?= $row_g->nombreGrupo ?></div>
<input type="hidden" id="usuarioDescarga" value="<?= $nombreCompleto ?>">
<br />
<ul id="simple_list-<?= $ix_g ?>">
	<? foreach ($folder[$ix_g] as $ix_f => $row_f) { ?>
	<li style="margin-left: 1em !important;">
		<div class="jsl-collapsed-arrow" id="simple_listtmp00_tgl"></div>
		<i class="fa fa-folder" aria-hidden="true"></i>
		<b><?= $row_f->nombreCarpeta ?></b>
		<hr style="margin-top: 1em !important; margin-bottom: 0.5em !important">
		<ul class="jsl-collapsed jslist-ul jslist-ol">
			<? foreach ($archivos[$ix_g][$ix_f] as $ix_a => $row_a) { ?>
			<li class="jslist-li">
				<div style="width:200px; word-wrap: break-word !important;     white-space: normal !important;">
					<a href="javascript:;" class="lk-download" data-file="<?= $row_a->nombreArchivo ?>" data-extension="<?= $row_a->extension ?>" data-name="<?= $row_a->nombreRegistrado ?>"><i class="fa fa-file-text" aria-hidden="true"></i>
						<?= $row_a->nombreRegistrado . '.' . $row_a->extension ?>
					</a>
				</div>
			</li>
			<? } ?>
		</ul>
	</li>
	<br />
	<? } ?>
</ul>
<? } ?>
<script>
	<?php foreach ($grupo as $ix_g => $row_g) { ?>
		JSLists.createTree("simple_list-<?= $ix_g; ?>");
	<?php } ?>
	//JSLists.createTree("simple_list-2");
</script>