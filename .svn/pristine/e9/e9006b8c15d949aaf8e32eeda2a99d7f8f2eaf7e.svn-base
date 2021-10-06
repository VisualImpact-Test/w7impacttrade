<form id="frm-cargarData">
	<div class="hide">
	</div>
	<div class="row themeWhite">
		<div class="col-md-12">
			<div class="mb-3 mt-3 card">
				<div class="card-header">
					CARGAR DATA -
				<?= isset($usuario)? $usuario : "" ?>
					
					<input id="codUsuarioSeleccionado" type="hidden" value="<?= isset($codUsuario)? $codUsuario : "" ?>">
					<input id="idVisitaSel" type="hidden" value="<?= isset($idVisitaSel)? $idVisitaSel : "" ?>">
				</div>
				<div class="card-body">
					<label>FECHA: <?= isset($fecha)? $fecha : "" ?></label>
					<label>PDV: <?= isset($pdvSel)? $pdvSel : "-" ?></label>
					
					<div class="content-input-file">
						<input type="file" id="btnFileBackup" data-file="" accept=".db"> 
					</div>
					<div class="ml-auto">
							<button type="button" id="btn-consultarArchivo" class="btn btn-primary ">Consultar</button>
						</div>
					<div class="tab-content">
						<div class="table-responsive" id="cargarDataContent">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>