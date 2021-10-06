<style>
.active span.text{
    color: black !important;
}
.col-lg-3 {
    float: left;
}
</style>
<form id="actualizar_ruta">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12" >	
			<div class="form-group">
				<label>RUTA: </label>
				<input type="hidden" name="idRutaProg" id="idRutaProg" value="<?=$data[0]['idRutaProg']?>">
				<input type="text" name="nombreRuta" id="nombreRuta" class="form-control input-sm" value=" <?=isset($data[0]['nombreRuta'])?$data[0]['nombreRuta']:""?>">
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

	<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:20px;" >
		<div class="card-body">
			<div class="">
				<div class="alert alert-warning" role="alert">
					<i class="fas fa-check-circle"></i> Se pide que los valores a ingresar en la tabla sean en letra <strong>MAYÚSCULA</strong>, para estandarizar y evitar inconvenientes.<br>
					<i class="fas fa-check-circle"></i> Si la columa ingresada <strong>no existe información</strong>, es preferible que se deje la <strong>celda vacia</strong>.<br>
					<i class="fas fa-check-circle"></i> Si algunas celdas aparecen en color <strong>rojo</strong>, a pesar de no tener información, se recomienda verificar que no exista espacios en blanco.<br>
					<i class="fas fa-check-circle"></i> La carga masiva tiene un tope <strong>máximo de 50 filas</strong>, si usted dispone de más datos, se recomienda realizar el procedimiento dos veces.<br>
				</div>
			</div>
			<div class="tab-content">
				<div class="table-responsive"><!-- style="width: 100%;"-->
					<div id="editarRutasMasiva"></div><!--style="overflow: auto;"-->
				</div>
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

		var container = document.getElementById('editarRutasMasiva');
		var settings = {
					licenseKey: 'non-commercial-and-evaluation',
					data: [ <?=$visitas?> ], 
					/* dataSchema: {nombreRuta:null, idGtm:null, idCliente:null, lunes:null,martes:null,miercoles:null,jueves:null, viernes:null, sabado:null, domingo:null }, */
					colHeaders: ['ELIMINAR','IDCLIENTE', 'LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','SABADO','DOMINGO'],
					startRows: 10,
					//startCols: 4,
					columns: [
						{data: 'eliminar', type:'numeric', allowEmpty: false},
						{data: 'idCliente', type:'numeric', allowEmpty: false},
						{data: 'lunes', type:'numeric'},
						{data: 'martes', type:'numeric'},
						{data: 'miercoles', type:'numeric'},
						{data: 'jueves', type:'numeric'},
						{data: 'viernes', type:'numeric'},
						{data: 'sabado', type:'numeric'},
						{data: 'domingo', type:'numeric'},
						
					],
					minSpareCols: 1, //always keep at least 1 spare row at the right
					minSpareRows: 1,  //always keep at least 1 spare row at the bottom,
					rowHeaders: true, //n° contador de las filas
					//filters: true, // permite filtrar en la columna, pero elimina la opción STARTROWS
					contextMenu: true,
					dropdownMenu: true, //desplegable en la columna, ofrece oopciones
					height: 300,
					//width: '100%',
					stretchH: 'all', //Expande todas las columnas al 100%
					maxRows: 50, //cantidad máxima de filas
					manualColumnResize: true,
					//FUNCIONES
					cells: function(row,col, prop){
						if (col==3) {
							//console.log('row - col',row+'-'+col);
						}
					},
					
				};

				Modulacion.handsontable = new Handsontable(container, settings);
				console.log('Carga Masiva');
				setTimeout(function(){
					//$.fn.dataTable.tables( { visible: true, api: true } ).columns.adjust();
				Modulacion.handsontable.render(); 
				}, 1000);
			

</script>

