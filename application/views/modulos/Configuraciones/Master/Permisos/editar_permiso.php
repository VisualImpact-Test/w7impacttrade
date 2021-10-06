<style>
	.form-group{
		margin:10px;
	}
</style>

<form id="registrar_permiso">
	<div class="row">
		<div class="col-md-12">
			<div class="mb-3 card">
				<div class="card-header">
					EDITAR FECHAS DE CARGA Y VIGENCIA DE LISTAS
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="position-relative row form-group">
							<label for="fechaCarga" class="col-sm-3 col-form-label">Fechas Carga </label>
							<div class="col-sm-9">
								<input name="fechaCarga" id="fechaCarga" value="<?=$permisos[0]['fecIniCarga']?>" type="text" class="form-control text-center rango_fechas" patron="requerido">
							</div>
						</div>
						<div class="position-relative row form-group">
							<label for="fechaLista" class="col-sm-3 col-form-label">Fechas Listas</label>
							<div class="col-sm-9">
								<input name="fechaLista" id="fechaLista" value="<?=$permisos[0]['fecIniLista'];?>" type="text" class="form-control  text-center rango_fechas" patron="requerido">
							</div>
						</div>
						<div class="divider"></div>
						<div class="div-modulos">
							<h5 class="card-title">MÓDULOS:</h5>
							<div class="position-relative row form-group">
								<? $i=1; foreach($modulos as $row){ $checked =(isset($permiso[$row['idModulo']]))?'checked':'';?>
								 <div class="custom-control custom-switch col-6">
									<input type="checkbox" class="custom-control-input" id="switch<?=$i?>" name="modulos" value="<?=$row['idModulo']?>" <?=$checked?>>
									<label class="custom-control-label" for="switch<?=$i?>" ><?=$row['modulo']?></label>
								</div>
								<? $i++;} ?>
							</div>	
						</div>
						<div class="divider"></div>
						<div class="div-usuarios">
							<h5 class="card-title">USUARIOS:</h5>
							<div class="position-relative row form-group">
								<div class="col-3">
									<label for="usuarios">Usuario</label>
								</div>
								<div class="col-9">
									<input name ="usuario" value="<?=$permisos[0]['usuario']?>" class="form-control text-center" style="width:100%;" readonly>
									<input name ="idPermiso" type="hidden" value="<?=$permisos[0]['idPermiso']?>" class="form-control text-center" style="width:100%;" readonly>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form >

<script>
	$('#fechaCarga').daterangepicker({
		locale: {
			"format": "DD/MM/YYYY",
			"applyLabel": "Aplicar",
			"cancelLabel": "Cerrar",
			"daysOfWeek": ["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
			"monthNames": ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre"],
			"firstDay": 1
		},
		parentEl: ".modal-content",
		singleDatePicker: false,
		showDropdowns: false,
		autoApply: true,
		startDate: "<?=$permisos[0]['fecIniCarga']?>",
		endDate: "<?=$permisos[0]['fecFinCarga']?>"
	});

	$('#fechaLista').daterangepicker({
		locale: {
			"format": "DD/MM/YYYY",
			"applyLabel": "Aplicar",
			"cancelLabel": "Cerrar",
			"daysOfWeek": ["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
			"monthNames": ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre"],
			"firstDay": 1
		},
		parentEl: ".modal-content",
		singleDatePicker: false,
		showDropdowns: false,
		autoApply: true,
		startDate: "<?=$permisos[0]['fecIniLista']?>",
		endDate: "<?=$permisos[0]['fecFinLista']?>"
	});

	$("#add").click( function(e){
		e.preventDefault();
		
		var idUsuario = $('#usuarios').val();
		var usuario = $('#usuarios option:selected').text();
		var html ='';
		html+= '<tr>';
			html+='<td>'+usuario+' <input type="hidden" name="idUsuario" value="'+idUsuario+'"> </td>';
			html+='<td><button class="del btn btn-primary">Eliminar</button></td>';
		html+='</tr>';
		
		$('#detalle_usuario tbody').append(html);
	});
		
	$(document).on('click','.del',function(e){
		e.preventDefault();
		var id =  $(this).parents("tr").find("td").remove();
	});
</script>