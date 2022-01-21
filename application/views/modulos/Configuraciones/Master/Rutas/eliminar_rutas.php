<style>
.active span.text{
    color: black !important;
}
.col-lg-3 {
    float: left;
}
</style>
<form id="eliminar_ruta">
	<input type="hidden" name="idProgRuta" id="idProgRuta" value="<?=$idProgRuta?>">
	<div class="col-md-12 col-sm-12 col-xs-12 px-5 dvFiltrarClientes" style="overflow: hidden;">
		<div class="form-group">
			<label>Filtrado</label>
			<textArea class="form-control input-sm selectpicker" id="idCliente" name="idCliente" placeholder="Filtre los codigos de los clientes que desea eliminar separados por comas. Ejm: 1234,4321,54654"></textArea>
		</div>
		<div class="form-group">
			<div class="col-lg-12"> <button id="busca_clientes_eliminar" class="btn btn-success w-100" >Filtrar clientes</button></div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:20px;" >
	<div id="content-usuarios" class="widget-content table-responsive table-content" style="overflow-y: scroll;max-height:150px;">
		<table class="table rutas">
			<thead>
				<tr>
					<th>			</th>
					<th>#			</th>
					<th>IDCLIENTE	</th>
					<th>CLIENTE		</th>
					<th> <br><center><input type="checkbox" class="selecteliminar"></center></th>
				</tr>
			<thead>
			<tbody>
				<? $i=1; if(isset($clientes)){foreach($clientes as $row => $value ){ ?>
					<tr>
						<td>
							<?
								$flagModulacion = $this->session->userdata('flag_modulacion');
								if($flagModulacion==1){
							?>
							<a href="javascript:;" class="eliminar_visita_programada btn btn-default btn-xs" data-idCliente="<?=$row?>" data-idProgRuta="<?=$data[0]['idProgRuta']?>" style="float: left;"><i class="fa fa-trash"></i></a>
							<?
								}
							?>
						</td>
						<td><?=$i?></td>
						<td><?=$value['id']?></td>
						<td><?=$value['razonSocial']?></td>
						
						<td><center><input type="checkbox" value="<?=$value['idProgVisita']?>" class="eliminar" name="eliminar" <?=isset($dias[$row][1]['dia'])?'checked':''?>   ></center> </td>
					</tr>
				<? $i++; }} ?>
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

<script>
$(".selecteliminar").on("click", function() {  
  if ($(".eliminar").length != $(".eliminar:checked").length) {  
    $(".eliminar").prop("checked", true);  
  } else {  
    $(".eliminar").prop("checked", false);  
  }  
});
</script>
