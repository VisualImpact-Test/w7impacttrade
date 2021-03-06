<form id="formCargaMasiva" role="form">
    <div class="row">
        <div class="col-md-12">
            <label for="tipo">Tipo Usuario</label>
            <select class="form-control" name="tipo" id="tipo">
                <?= htmlSelectOptionArray2(['query' => $tiposUsuario, 'id' => 'idTipoUsuario', 'value' => 'nombre']) ?>
            </select>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <label>FECHA INICIO</label>
                    <input type="text" class="form-control input-sm fecha" id="fecha_ini" readonly name="fecha_ini" value="<?= isset($data[0]['fecIni']) ? $data[0]['fecIni'] :  DATE('d/m/Y'); ?>">
                </div>

                <div class="col-md-4 col-sm-4 col-xs-4">
                    <label>FECHA FIN</label>
                    <input type="text" class="form-control input-sm fecha" id="fecha_fin" readonly name="fecha_fin" value="<?= isset($data[0]['fecFin']) ? $data[0]['fecFin'] :   DATE('d/m/Y'); ?>">
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <label>GENERACION</label><BR>
                    <div class="position-relative form-check form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" name="ch-generacion" value="diaria" class="form-check-input"> Diaria</label>
                    </div>
                    <div class="position-relative form-check form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" name="ch-generacion" value="completa" class="form-check-input" checked> Completa</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12" id="divTablaCargaMasiva">

            <ul class="nav nav-tabs" role="tablist">
                <?php foreach ($hojas as $key => $row) { ?>
                    <li class="nav-item">
                        <a class="tabCargaMasiva nav-link <?= ($key == 0) ? 'active' : '' ?>" id="hoja<?= $key ?>-tab" data-nrohoja="<?= $key ?>" data-toggle="tab" href="#hoja<?= $key ?>" role="tab" aria-controls="hoja<?= $key ?>" aria-selected="true"><?= $row ?></a>
                    </li>
                <?php } ?>
            </ul>

            <div class="tab-content mt-4 text-white">
                <div class="">
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-check-circle"></i> Se pide que los valores a ingresar en la tabla sean en letra <strong>MAY??SCULA</strong>, para estandarizar y evitar inconvenientes.<br>
                        <i class="fas fa-check-circle"></i> Si la columa ingresada <strong>no existe informaci??n</strong>, es preferible que se deje la <strong>celda vac??a</strong>.<br>
                        <i class="fas fa-check-circle"></i> Si algunas celdas aparecen en color <strong>rojo</strong>, a pesar de no tener informaci??n, se recomienda verificar que no exista espacios en blanco.<br>
                        <i class="fas fa-check-circle"></i> Si ha seleccionado la generacion completa se generara las rutas y visitas de acorde a los valores registrados en el intervalo de fecha inicio y fin.<br>
                        <!--<i class="fas fa-check-circle"></i> La carga masiva tiene un tope <strong>m??ximo de 50 filas</strong>, si usted dispone de m??s datos, se recomienda realizar el procedimiento dos veces.<br>-->
                    </div>
                </div>
                <?php foreach ($hojas as $key => $row) { ?>
                    <div class="tab-pane <?= ($key == 0) ? 'show active' : '' ?>" id="hoja<?= $key ?>" role="tabpanel" aria-labelledby="hoja<?= $key ?>-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="divHT<?= $key ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>
</form>

<script>
	$(document).ready(function() {
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