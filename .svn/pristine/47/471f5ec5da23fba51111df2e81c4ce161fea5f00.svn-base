<form id="frm-basemadreSeleccionarSegmentacionCliente">
	<div class="row themeWhite">
		<div class="col-md-12">
			<div class="mb-3 mt-3 card">
				<div class="card-header">
					SELECCIONAR UN TIPO DE REGISTRO DE CLIENTE HISTÓRICO
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="frb-group">
							<? if (!empty($listaSegmentacion)): ?>
								<? if ( isset($listaSegmentacion['flagClienteTradicional']) && $listaSegmentacion['flagClienteTradicional']>0 ): ?>
									<div class="frb frb-primary">
										<input type="radio" id="segmentacionTradicional" name="tipoSegmentacion" value="1" patron="requerido">
										<label for="segmentacionTradicional">
											<span class="frb-title">Cliente Tradicional</span>
											<span class="frb-description">Se le mostrara una ventana en la cual solo podra registrar clientes que pertenescan a la segmentacion cliente de tradicional.</span>
										</label>
									</div>
								<? endif ?>
								
								<? if ( isset($listaSegmentacion['flagClienteModerno']) && $listaSegmentacion['flagClienteModerno']>0 ): ?>
									<div class="frb frb-success">
										<input type="radio" id="segmentacionModerna" name="tipoSegmentacion" value="2" patron="requerido">
										<label for="segmentacionModerna">
											<span class="frb-title">Cliente Moderno</span>
											<span class="frb-description">Se le mostrará una ventana en la cual solo podra registrar a los clientes que pertenescan a la segmentación de clientes modernos, cadena y banner.</span>
										</label>
									</div>
								<? endif ?>
							<? else: ?>
								<div class="alert alert-warning" role="alert">
									Su usuario <strong>no tiene</strong> la funcionalidad de <strong>solicitar</strong> la creación de clientes.<br>
									Comuniquese con el <strong>área de analistas</strong> para poder <strong>asignar</strong> le dicha funcionalidad.
								</div>
							<? endif ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>