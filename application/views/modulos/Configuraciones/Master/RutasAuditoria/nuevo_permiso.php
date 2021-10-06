<style>
	.form-group{
		margin:10px;
	}
</style>
<form class="form-inline" id="registrar_permiso">
<div class="col-12">
	<b style="text-transform: uppercase;font-size: 15px;">Registrar fechas de carga y vigencia de listas.</b>
	<hr>
	<!--400853783-->
	 <div class="form-group">
		<div class="col-3">
			<label for="fechaCarga">Fechas Carga </label>
		</div>
		<div class="col-9">
			<input name="fechaCarga" id="fechaCarga" value="<?=date("d/m/Y");?>" type="text" class="form-control text-center rango_fechas" style="width: 100%;">
		</div>
	</div>
	<div class="form-group">
		<div class="col-3">
			<label for="fechaLista">Fechas Listas</label>
		</div>
		<div class="col-9">
			<input name="fechaLista" id="fechaLista" value="<?=date("d/m/Y");?>" type="text" class="form-control  text-center rango_fechas" style="width: 100%;">
		</div>
	</div>
	
	
	<div class="form-group">
		<b style="font-size:18px;margin-bottom:10px;margin-top:30px;">MODULOS </b>
	</div>
	
	<div class="form-group">
		<? $i=1; foreach($modulos as $row){ ?>
		 <div class="custom-control custom-switch col-6">
			<input type="checkbox" class="custom-control-input" id="switch<?=$i?>" name="modulos" value="<?=$row['idModulo']?>" checked>
			<label class="custom-control-label" for="switch<?=$i?>" ><?=$row['modulo']?></label>
		</div>
		<? $i++;} ?>
	</div>
	
	<div class="form-group">
		<b style="font-size:18px;margin-bottom:10px;margin-top:30px;">USUARIOS </b>
	</div>
	
	<div class="form-group">
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
	</div>
	<div class="form-group">
		<div class="col-12">
	<script>
		//$('#detalle_usuario').DataTable();

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
	</script>

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
	</div>
</div>
</form >

<script>
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
		
$(document).on('click','.del',function(e){
			e.preventDefault();
			var id =  $(this).parents("tr").find("td").remove();
});
</script>