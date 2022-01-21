
<form id="nuevo_usuario">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12" >	
			<div class="form-group">
				<label>USUARIO: </label>
				<input name="idProgRuta" value="<?=isset($data[0])? $data[0]['idProgRuta'] :'' ?>" type="hidden">
				<select class="form-control input-sm selectpicker" id="idUsuario" name="idUsuario" title="SELECCIONE" data-actions-box="true" data-live-search="true"  >
					<?
						if(isset($data[0])){
							if(isset($data[0]['idUsuario'])){
							echo'<option value="'.$data[0]['idUsuario'].'" selected>'.$data[0]['usuario'].'</option>';
							}
						}
						foreach($usuario as $row){
							echo'<option value="'.$row['idUsuario'].'">'.$row['nombres'].'</option>';
						}
					?>
				</select >
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6" >
			<label>FECHA INICIO</label>
			<input type="text" class="form-control input-sm fecha" id="fecha_ini" name="fechas_ini_rutas" value="<?=DATE('d/m/Y');?>">
		</div>

		<div class="col-md-6" >
			<label>FECHA FIN</label>
			<input type="text" class="form-control input-sm fecha" id="fecha_fin" name="fechas_fin_rutas" value="<?=DATE('d/m/Y');?>">
		</div>
		<div class="col-md-2 d-none" >
			<button id="agregar_usuario_ruta" type="button" class="btn btn-success" style="margin-top:10px;">Registrar</button>
		</div>
	</div>
</form>
<hr>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12" >
	<div id="content-usuarios" class="widget-content table-responsive table-content" style="overflow-y: scroll;max-height:150px;">
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>USUARIO</th>
					<th>FECHA INICIO</th>
					<th>FECHA FIN</th>
				</tr>
			</thead>
			<tbody>
			<? $i=1; foreach($data as $row){ ?>
				<tr>
					<td><?=$i?></td>
					<td><?=$row['usuario']?></td>
					<td><?=$row['fecIni']?></td>
					<td><?=$row['fecFin']?></td>
				</tr>
			<? $i++; } ?>
			</tbody>
		</table>
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

