<form id="frm-basemadreSeleccionarPunto">
	<div class="row themeWhite">
		<div class="col-md-12">
			<div class="mb-3 mt-3 card">
				<div class="card-header">
					SELECCIONAR UN TIPO DE REGISTRO DE CLIENTE HISTÓRICO
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="position-relative form-group">
							<div>
								<div class="custom-radio custom-control">
									<input type="radio" id="clienteNuevo" name="tipoRegistro" class="custom-control-input" value="0" checked>
									<label class="custom-control-label" for="clienteNuevo">Registrar Nuevo Cliente + Registro Histórico de Cliente</label>
								</div>
								<div class="custom-radio custom-control">
									<input type="radio" id="clienteExistente" name="tipoRegistro" class="custom-control-input" value="1">
									<label class="custom-control-label" for="clienteExistente">Registrar Histórico de Cliente de un cliente existente</label>
								</div>
							</div>
						</div>
						<div class="position-relative form-group dvListaCliente">
							<div class="divider"></div>
							<div class="row">
								<div class="col-md-12 col-lg-12">
									<label for="clienteRegistro">SELECCIONAR CLIENTE</label>
								</div>
								<div class="col-md-12 col-lg-12">
									<select class="form-control slWidth" id="clienteRegistro" name="clienteRegistro">
										<option value="">-- Nombre Comercial -- Razón Social --</option>
										<? foreach ($listaBasemadre as $klp => $row): ?>
											<option value="<?=$row['idCliente']?>"><?=$row['nombreComercial']?> -- <?=$row['razonSocial']?></option>
										<? endforeach ?>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>