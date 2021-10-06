<div class="row themeWhite">

	<div class="col-md-12">
		<div class="mb-12 mt-12 card">
			<div class="card-header">
				CARGA MASIVA DE CLIENTES
			</div>

<br><br>
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-4 col-sm-4 col-xs-4" >
				<label>FECHA INICIO</label>
				<input type="text" class="form-control input-sm fecha" id="fecha_ini" readonly name="fecha_ini" value="<?= isset($data[0]['fecIni'])? $data[0]['fecIni'] :  DATE('d/m/Y');?>">
			</div>

			<div class="col-md-4 col-sm-4 col-xs-4" >
				<label>FECHA FIN</label>
				<input type="text" class="form-control input-sm fecha" id="fecha_fin" readonly name="fecha_fin" value="<?= isset($data[0]['fecFin'])? $data[0]['fecFin'] :  '';?>">
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4" >
				<label>GENERACION</label><BR>
				<div class="position-relative form-check form-check-inline">
					<label class="form-check-label">
						<input type="radio" name="ch-generacion" value="diaria" class="form-check-input"> Diaria</label>
				</div>
				<div class="position-relative form-check form-check-inline">
					<label class="form-check-label">
						<input type="radio" name="ch-generacion" value="completa" class="form-check-input"> Completa</label>
				</div>
			</div>
		</div>
	</div>
	

			
			<div class="card-body">
				<div class="">
					<div class="alert alert-warning" role="alert">
						<i class="fas fa-check-circle"></i> Se pide que los valores a ingresar en la tabla sean en letra <strong>MAYÚSCULA</strong>, para estandarizar y evitar inconvenientes.<br>
						<i class="fas fa-check-circle"></i> Si la columa ingresada <strong>no existe información</strong>, es preferible que se deje la <strong>celda vacia</strong>.<br>
						<i class="fas fa-check-circle"></i> Si algunas celdas aparecen en color <strong>rojo</strong>, a pesar de no tener información, se recomienda verificar que no exista espacios en blanco.<br>
						<i class="fas fa-check-circle"></i> Si ha seleccionado la generacion completa se generara las rutas y visitas de acorde a los valores registrados en el intervalo de fecha inicio y fin.<br>
						<i class="fas fa-check-circle"></i> La carga masiva tiene un tope <strong>máximo de 1000 filas</strong>.<br>
						<!--<i class="fas fa-check-circle"></i> La carga masiva tiene un tope <strong>máximo de 50 filas</strong>, si usted dispone de más datos, se recomienda realizar el procedimiento dos veces.<br>-->
					</div>
				</div>
				<div class="row">
					<button type="button" data-toggle="collapse" id="btn-descargarRutasFormato" class="btn-outline-primary border-0" style="padding:10px;margin-left:10px;border-radius: 13px;outline: blue;">  Descargar Formato</button>
				</div>
				<div class="tab-content">
					<div class="table-responsive"><!-- style="width: 100%;"-->
						<div id="cargaMasivaRutas"></div><!--style="overflow: auto;"-->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
	$('#fecha_ini').daterangepicker({
		locale: {
			"format": "DD/MM/YYYY",
			"applyLabel": "Aplicar",
			"cancelLabel": "Cerrar",
			"daysOfWeek": ["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
			"monthNames": ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre"],
			"firstDay": 1
		},
		parentEl :"div.modal-content",
		singleDatePicker: true,
		//startDate: start_date,
		showDropdowns: false,
		autoApply: true,
		//autoUpdateInput: false,
	});
	
	$('#fecha_fin').daterangepicker({
		locale: {
		'format': 'DD/MM/YYYY',
		'daysOfWeek': ["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
		'monthNames': ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre"],
		},
		parentEl :"div.modal-content",
		singleDatePicker: true,
		autoUpdateInput: false,
	});	

	$('#fecha_fin').on('apply.daterangepicker', function(ev,picker){
		var control=$(this);
		var name=control.attr('name');
		var fecha_inicio = $("#fecha_ini").val();
		var dateB = moment(picker.startDate.format('YYYY-MM-DD'));
		var dateC = moment(moment(fecha_inicio, "DD/MM/YYYY").format('YYYY-MM-DD'));
		var diferencia  = dateB.diff(dateC, 'days');
		if( diferencia>=0 ) control.val(picker.startDate.format('DD/MM/YYYY'));
		else control.val('');
	});

	$('#fecha_fin').on('blur.daterangepicker', function(ev,picker){
		var control=$(this);
		var fecha=control.val();
		if( !moment(fecha,'DD/MM/YYYY',true).isValid() ) control.val('');

		var fecha_inicio = $("#fecha_ini").val();
		var dateB = moment(moment(fecha, "DD/MM/YYYY").format('YYYY-MM-DD'));
		var dateC = moment(moment(fecha_inicio, "DD/MM/YYYY").format('YYYY-MM-DD'));
		var diferencia  = dateB.diff(dateC, 'days');
		if(diferencia<0) control.val('');
	});
	
});

</script>
<script>

</script>