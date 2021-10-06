<style>
.active span.text{
    color: black !important;
}
.col-lg-3 {
    float: left;
}
</style>
<form id="formRutaGenerada">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12" >	
			<div class="form-group">
				<label>RUTA: </label>
				<input type="hidden" name="idRutaProg" id="idRutaProg" value="<?=$data[0]['idRutaProg']?>">
				<input type="text" name="nombreRuta" id="nombreRuta" readonly class="form-control input-sm" value=" <?=isset($data[0]['nombreRuta'])?$data[0]['nombreRuta']:""?>">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-6" >
			<label>FECHA INICIO</label>
			<input type="text" class="form-control input-sm fecha" id="fecha_ini" readonly name="fecha_ini" value="<?= isset($data[0]['fecIni'])? $data[0]['fecIni'] :  DATE('d/m/Y');?>">
		</div>

		<div class="col-md-6 col-sm-6 col-xs-6" >
			<label>FECHA FIN</label>
			<input type="text" class="form-control input-sm fecha" id="fecha_fin" readonly name="fecha_fin" value="<?= isset($data[0]['fecFin'])? $data[0]['fecFin'] :  '';?>">
		</div>
	</div>

	<div class='row mb-3'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
            <div id="calendar"></div>
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

