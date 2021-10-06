<form id="registrar_permiso">
	<div class="row">
		<div class="col-md-12">
			<div class="mb-3 card">
				<div class="card-header">
					REGISTRAR FECHAS DE CARGA Y VIGENCIA DE LISTAS
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="position-relative row form-group">
							<label for="fechaCarga" class="col-sm-3 col-form-label">Fechas Carga:</label>
							<div class="col-sm-9">
								<input name="fechaCarga" id="fechaCarga" value="<?= date("d/m/Y").' - '.date("d/m/Y") ?>" type="text" class="form-control text-center rango_fechas" patron="requerido">
							</div>
						</div>
						<div class="position-relative row form-group">
							<label for="fechaLista" class="col-sm-3 col-form-label">Fechas Listas:</label>
							<div class="col-sm-9">
								<input name="fechaLista" id="fechaLista" value="<?= date("d/m/Y").' - '.date("d/m/Y") ?>" type="text" class="form-control text-center rango_fechas" patron="requerido">
							</div>
						</div>
						<div class="divider"></div>
						<div class="div-modulos">
							<h5 class="card-title">MÓDULOS:</h5>
							<? if (!empty($listaModulos)): ?>
								<div class="position-relative form-group">
									<? $i=1; ?>
									<? foreach ($listaModulos as $klm => $row): ?>
										<div class="custom-checkbox custom-control">
											<input type="checkbox" id="switch<?=$i?>" class="custom-control-input" name="modulos" value="<?=$row['idModulo']?>" checked>
											<label class="custom-control-label" for="switch<?=$i?>"><?=$row['modulo']?></label>
										</div>
										<? $i++;?>
									<? endforeach ?>
								</div>
							<? else: ?>
								<div class="alert alert-warning" role="alert"><i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGÚN RESULTADO.</div>
							<? endif ?>
						</div>
						<div class="divider"></div>
						<div class="div-usuarios">
							<h5 class="card-title">USUARIOS:</h5>
							<? if (!empty($listaUsuarios)): ?>
								<div class="position-relative row form-group">
									<label for="usuarios" class="col-sm-2 col-form-label">Usuario:</label>
									<div class="col-sm-10 input-group">
										<select name="select" id="usuarios" class="form-control text-center select2" name="usuarios">
											<option selected value="">Seleccione Usuario</option>
											<? foreach ($listaUsuarios as $klu => $row): ?>
												<option value="<?=$row['idUsuario']?>"><?=$row['usuario']?></option>
											<? endforeach ?>
										</select>
										<div class="input-group-append">
											<button id="btn-addUsuario" class="btn btn-primary"><i class="fas fa-plus-square"></i> Agregar</button>
										</div>
									</div>
								</div>
								<div class="position-relative form-group">
									<div class="table-responsive">
										<table id="detalle_usuario" class="mb-0 table table-bordered table-sm text-nowrap">
											<thead>
												<tr>
													<th class="text-center">#</th>
													<th class="text-center">USUARIO</th>
													<th class="text-center">ELIMINAR</th>
												</tr>
											</thead>
											<tbody>
												<tr class="noData">
													<td class="text-center" colspan="3">Presionar el botón <strong>Agregar</strong></td>
												</tr>
											</tbody>
										</table>
										<input type="hidden" id="cantUsuarios" name="cantUsuarios" value="0">
									</div>
								</div>
							<? else: ?>
								<div class="alert alert-warning" role="alert"><i class="fas fa-info-circle"></i> NO SE HA GENERADO NINGÚN RESULTADO.</div>
							<? endif ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-12">
		<!--b style="text-transform: uppercase;font-size: 15px;">Registrar fechas de carga y vigencia de listas.</b>
		<hr-->
		<!--400853783-->
		 <!--div class="form-group">
			<div class="col-3">
				<label for="fechaCarga">Fechas Carga </label>
			</div>
			<div class="col-9">
				<input name="fechaCarga" id="fechaCarga" value="<?=date("d/m/Y");?>" type="text" class="form-control text-center rango_fechas" style="width: 300px;">
			</div>
		</div>
		<div class="form-group">
			<div class="col-3">
				<label for="fechaLista">Fechas Listas</label>
			</div>
			<div class="col-9">
				<input name="fechaLista" id="fechaLista" value="<?=date("d/m/Y");?>" type="text" class="form-control  text-center rango_fechas" style="width: 300px;">
			</div>
		</div-->
		
		
		<!--div class="form-group">
			<b style="font-size:18px;margin-bottom:10px;margin-top:30px;">MODULOS </b>
		</div-->
		
		<!--div class="form-group">
			<? $i=1; foreach($modulos as $row){ ?>
			 <div class="custom-control custom-switch col-6">
				<input type="checkbox" class="custom-control-input" id="switch<?=$i?>" name="modulos" value="<?=$row['idModulo']?>" checked>
				<label class="custom-control-label" for="switch<?=$i?>" ><?=$row['modulo']?></label>
			</div>
			<? $i++;} ?>
		</div-->
		
		<!--div class="form-group">
			<b style="font-size:18px;margin-bottom:10px;margin-top:30px;">USUARIOS </b>
		</div-->
		
		<!--div class="form-group">
			<div class="col-3">
				<label for="usuarios">Usuarios</label>
			</div>
			<div class="col-6">
				<select name="usuarios" id="usuarios" class="form-control  text-center" style="width: 100%;">
					<? foreach($usuarios as $row){ ?>
						<option value="<?=$row['idUsuario']?>"><?=$row['usuario']?></option>
					<? } ?>
				</select>
			</div>
			<div class="col-3">
				<button id="add" class="btn btn-primary">Agregar</button>
			</div>
		</div-->
		<!--div class="form-group">
			<div class="col-12">
				<table class="table" id="detalle_usuario" style="width:100%;">
					<thead>
						<tr>
							<th>USUARIO</th>
							<th></th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
		</div-->
	</div>
</form >

<script>
	$('.select2').select2({
		dropdownParent: $("div.modal-content"),
		width: '80%'
	});

	$('.rango_fechas').daterangepicker({
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
	});

	$("#btn-addUsuario").click( function(e){
		e.preventDefault();
		var cantUsuarios = parseInt($('#cantUsuarios').val()) + 1;
		var idUsuario = $('#usuarios').val();
		var usuario = $('#usuarios option:selected').text();

		if ( idUsuario!='' && usuario!='') {
			var fila ='';
				fila+= '<tr>';
					fila+='<td class="text-center">'+cantUsuarios+'</td>'
					fila+='<td>'+usuario+' <input type="hidden" name="idUsuario" value="'+idUsuario+'">';
						fila+='<input type="hidden" name="usuario" value="'+usuario+'">';
					fila+='</td>';
					fila+='<td class="text-center"><button class="btn-deleteRow btn btn-danger"><i class="fas fa-trash fa-lg"></i></button></td>';
				fila+='</tr>';
			$('#detalle_usuario tbody tr.noData').remove();
			$('#detalle_usuario tbody').append(fila);
			$('#usuarios').select2('val', 'Seleccione Usuario');
			$('#cantUsuarios').val(cantUsuarios);
		}
	});
		
	$(document).on('click','.btn-deleteRow',function(e){
		e.preventDefault();

		var tr = $(this).parents('tr').remove();
	});
</script>