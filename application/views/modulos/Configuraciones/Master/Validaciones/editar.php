<style>
	.form-group{
		margin:10px;
	}
</style>
<form class="form-inline" id="registrar_permiso">
<div class="col-12">
	<!--400853783-->
	 <div class="form-group">
		<div class="col-3">
			<label for="fechaCarga">CLIENTE TIPO </label>
		</div>
		<div class="col-9">
			<select name="clientetipo" id="clientetipo" class="form-control text-center" style="width: 100%;">
				<? foreach($modulos as $row){ ?>
					<?
						$selected = ($validacion[0]['idClienteTipo']==$row['idSubCanal'])?'selected':'';
					?>
					<option value="<?=$row['idSubCanal']?>" <?=$selected?>><?=$row['nombre']?></option>
				<? } ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<div class="col-3">
			<label for="fechaLista">MIN Categorias</label>
		</div>
		<div class="col-9">
			<input name="mincategoria" id="mincategoria" value="<?=$validacion[0]['minCategorias']?>" type="text" class="form-control  text-center" style="width: 100%;">
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-3">
			<label for="fechaLista">MIN Elementos</label>
		</div>
		<div class="col-9">
			<input name="minelementos" id="minelementos" value="<?=$validacion[0]['minElementosOblig']?>" type="text" class="form-control  text-center" style="width: 100%;">
			<input name="idValidacion" id="idValidacion" type="hidden" value="<?=$validacion[0]['idValidacion']?>" type="text" class="form-control  text-center" style="width: 100%;">
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