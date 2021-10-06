<style>
.active span.text{
    color: black !important;
}
.col-lg-3 {
    float: left;
}
</style>
<form id="nueva_ruta">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12" >	
			<div class="form-group">
				<label>RUTA: </label>
				<input type="text" name="nombreRuta" id="nombreRuta" class="form-control input-sm" value="">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-6" >
			<label>FECHA INICIO</label>
			<input type="text" class="form-control input-sm fecha" id="fecha_ini" readonly name="fecha_ini" value="<?=DATE('d/m/Y');?>">
		</div>

		<div class="col-md-6 col-sm-6 col-xs-6" >
			<label>FECHA FIN</label>
			<input type="text" class="form-control input-sm fecha" id="fecha_fin" readonly name="fecha_fin" value="">
		</div>
	</div>
	<div class="row" style="margin-top:10px;">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label>GTM: </label>
				<select class="form-control input-sm selectpicker" id="idGtm" name="idGtm" title="SELECCIONE" data-actions-box="true" data-live-search="true" >
					<? foreach( $data_gtm as $row ){ ?>
						<option value="<?=$row['idUsuario']?>"><?=$row['nombres']?></option>
					<? } ?>
				</select>
			</div>
		</div>
	</div>
	
	<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:20px;padding:20px;overflow: hidden;">
		<div class="form-group">
			<label>IDCLIENTES: (ingrese los id cliente separados por comas. y seleccione los dias que seran visitados los clientes ingresados.) </label>
			<textArea class="form-control input-sm selectpicker" id="idCliente" name="idCliente"></textArea>
		</div>

		<div class="form-group">
			<div class="col-lg-3"> <div class="col-md-9">LUNES </div><div class="col-md-3"><input type="checkbox" id="lunes" name="dia" value="1"></div></div>
			<div class="col-lg-3"> <div class="col-md-9">MARTES </div><div class="col-md-3"><input type="checkbox" id="martes" name="dia" value="2"></div></div>
			<div class="col-lg-3"> <div class="col-md-9">MIERCOLES </div><div class="col-md-3"><input type="checkbox" id="miercoles" name="dia" value="3"></div></div>
			<div class="col-lg-3"> <div class="col-md-8">JUEVES </div><div class="col-md-4"><input type="checkbox" id="jueves" name="dia" value="4"></div></div>
			<div class="col-lg-3"> <div class="col-md-9">VIERNES </div><div class="col-md-3"><input type="checkbox" id="viernes" name="dia" value="5"></div></div>
			<div class="col-lg-3"> <div class="col-md-9">SABADO </div><div class="col-md-3"><input type="checkbox" id="sabado" name="dia" value="6"></div></div>
			<div class="col-lg-3"> <div class="col-md-9">DOMINGO </div><div class="col-md-3"><input type="checkbox" id="domingo" name="dia" value="7"></div></div>
			<div class="col-lg-3"> <button id="add_clientes" class="btn btn-success" style="padding:5px;">Agregar a Ruta</button></div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:20px;" >
	<div id="content-usuarios" class="widget-content table-responsive table-content" style="overflow-y: scroll;max-height:150px;">
		<table class="table">
			<thead>
				<tr>
					<th>			</th>
					<th>IDCLIENTE	</th>
					<th>CLIENTE		</th>
					<th>LUNES		</th>
					<th>MARTES		</th>
					<th>MIERCOLES	</th>
					<th>JUEVES		</th>
					<th>VIERNES		</th>
					<th>SABADO		</th>
					<th>DOMINGO		</th>
				</tr>
			<thead>
			<tbody>
				<tr></tr>
			</tbody>
		</table>
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
