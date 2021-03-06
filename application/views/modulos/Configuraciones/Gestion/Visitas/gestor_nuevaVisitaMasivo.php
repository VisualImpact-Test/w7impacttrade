<div class="row themeWhite">
	<div class="col-md-12">
		<div class="mb-3 mt-3 card">
			<div class="card-header">
				CARGA MASIVA DE VISITAS
			</div>
			<div class="card-body">
				<div class="">
					<div class="alert alert-warning" role="alert">
						<i class="fas fa-check-circle"></i> Si algunas celdas aparecen en color <strong>rojo</strong>, a pesar de no tener información, se recomienda verificar que no exista espacios en blanco.<br>
						<i class="fas fa-check-circle"></i> La carga masiva tiene un tope <strong>máximo de 500 filas</strong>, si usted dispone de más datos, se recomienda realizar el procedimiento dos veces.<br>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label for="tipo">Tipo Usuario</label>
						<select class="form-control" name="tipo" id="tipo">
							<?= htmlSelectOptionArray2(['query' => $tiposUsuario, 'id' => 'idTipoUsuario', 'value' => 'nombre']) ?>
						</select>
					</div>
				</div>
				<div class="tab-content">
					<div class="table-responsive">
						<div id="nuevoPuntoMasivoVisita"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	Visitas.dataListaUsuarios = JSON.parse('<?= json_encode($listaUsuarios) ?>');
	Visitas.dataListaTipoUsuario = JSON.parse('<?= json_encode($listaTipoUsuario) ?>');
	Visitas.dataListaClientes = JSON.parse('<?= json_encode($listaClientes) ?>');
</script>