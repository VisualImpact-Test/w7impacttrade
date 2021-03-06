<div class="row themeWhite">

	<div class="col-md-12">

		<div class="mb-12 mt-12 card">
			<div class="row">
				<div class="col-md-6">
					<div class="card-header">SELECCIONAR PERIODO Y RUTA PARA CLONAR</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<label>RUTA</label>
								<select class="form-control" id="idRuta" name="idRuta">
									<? foreach ($rutas as $row) { ?>
										<option value="<?= $row['idProgRuta'] ?>"><?= $row['nombreRuta'] ?></option>
									<? } ?>
								</select>
							</div>
						</div>
						<div class="row py-2">
							<div class="col-md-6 col-sm-6 col-xs-6">
								<button type="button" data-toggle="collapse" id="btn-importar" class="btn btn-outline-primary border-0"><i class="fas fa-plus-square" aria-hidden="true"></i>Obtener Data Ruta</button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card-header">DATA NUEVA RUTA</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6">
								<label>FECHA INICIO</label>
								<input type="text" class="form-control input-sm fecha" id="fecha_ini"  name="fecha_ini" value="<?= isset($data[0]['fecIni']) ? $data[0]['fecIni'] :  DATE('d/m/Y'); ?>">
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<label>FECHA FIN</label>
								<input type="text" class="form-control input-sm fecha" id="fecha_fin"  name="fecha_fin" value="<?= isset($data[0]['fecFin']) ? $data[0]['fecFin'] :  DATE('d/m/Y'); ?>">
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<label>RUTA</label>
								<input class="form-control" id="nombreRuta" name="nombreRuta" placeholder="Nombre de la ruta">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6">
								<label for="usuario"> USUARIO</label>
								<select class="my-select2-usuarios form-control" id="usuario" name="usuario">
									<?=htmlSelectOptionArray2(['query'=>$listaUsuarios,'id'=>'idUsuario','value'=>'nombreUsuario'])?>
								</select>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6 ">
								<label for="tipoUsuario"> PERFIL USUARIO</label>
								<select class="form-control my-select2-tipousuario" id="tipoUsuario" name="tipoUsuario">
									
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="mb-12 mt-12 card" style="width: 90%;margin: auto;">

				</div>
			</div>

			<div class="card-body">
				<div class="">
					<div class="alert alert-warning" role="alert">
						<i class="fas fa-check-circle"></i> Se pide que los valores a ingresar en la tabla sean en letra <strong>MAY??SCULA</strong>, para estandarizar y evitar inconvenientes.<br>
						<i class="fas fa-check-circle"></i> Si la columa ingresada <strong>no existe informaci??n</strong>, es preferible que se deje la <strong>celda vacia</strong>.<br>
						<i class="fas fa-check-circle"></i> Si algunas celdas aparecen en color <strong>rojo</strong>, a pesar de no tener informaci??n, se recomienda verificar que no exista espacios en blanco.<br>
						<!--<i class="fas fa-check-circle"></i> La carga masiva tiene un tope <strong>m??ximo de 50 filas</strong>, si usted dispone de m??s datos, se recomienda realizar el procedimiento dos veces.<br>-->
					</div>
				</div>
				<div class="tab-content">
					<div class="table-responsive">
						<!-- style="width: 100%;"-->
						<div id="cargaMasivaRutas"></div>
						<!--style="overflow: auto;"-->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>

	$(document).ready(function() {

		Modulacion.usuariosTipo = <?=json_encode($listaTiposUsuario)?>

		$('#fecha_ini').daterangepicker({
			locale: {
				"format": "DD/MM/YYYY",
				"applyLabel": "Aplicar",
				"cancelLabel": "Cerrar",
				"daysOfWeek": ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
				"monthNames": ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"],
				"firstDay": 1
			},
			parentEl: "div.modal-content",
			singleDatePicker: true,
			//startDate: start_date,
			showDropdowns: false,
			autoApply: true,
			//autoUpdateInput: false,
		});

		$('#fecha_fin').daterangepicker({
			locale: {
				'format': 'DD/MM/YYYY',
				'daysOfWeek': ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
				'monthNames': ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"],
			},
			parentEl: "div.modal-content",
			singleDatePicker: true,
			autoUpdateInput: false,
		});

		$('#fecha_fin').on('apply.daterangepicker', function(ev, picker) {
			var control = $(this);
			var name = control.attr('name');
			var fecha_inicio = $("#fecha_ini").val();
			var dateB = moment(picker.startDate.format('YYYY-MM-DD'));
			var dateC = moment(moment(fecha_inicio, "DD/MM/YYYY").format('YYYY-MM-DD'));
			var diferencia = dateB.diff(dateC, 'days');
			if (diferencia >= 0) control.val(picker.startDate.format('DD/MM/YYYY'));
			else control.val('');
		});

		$('#fecha_fin').on('blur.daterangepicker', function(ev, picker) {
			var control = $(this);
			var fecha = control.val();
			if (!moment(fecha, 'DD/MM/YYYY', true).isValid()) control.val('');

			var fecha_inicio = $("#fecha_ini").val();
			var dateB = moment(moment(fecha, "DD/MM/YYYY").format('YYYY-MM-DD'));
			var dateC = moment(moment(fecha_inicio, "DD/MM/YYYY").format('YYYY-MM-DD'));
			var diferencia = dateB.diff(dateC, 'days');
			if (diferencia < 0) control.val('');
		});


	});
</script>
<script>

</script>