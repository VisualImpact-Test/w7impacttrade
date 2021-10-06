<form id="<?=$frm?>">
	<div id="page-live-1" class="page-live p-3">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label>Fecha de Inicio:</label><br>
					<input type="date" name="fecIni" id="txt-live-fecIni" class="vrf-live-list form-control form-control-sm" value="<?=date('Y-m-d')?>" patron="requerido">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Cuenta:</label><br>
					<select name="idCuenta" id="cbx-live-cuenta" class="flt_cuenta my_select2_ cbx-live-for-pdv vrf-live-list form-control form-control-sm" patron="requerido">
						<option value="">Seleccionar</option>
						<?foreach($cuenta as $idCuenta => $cu){?>
							<option value="<?=$idCuenta?>"><?=$cu['nombre']?></option>
						<?}?>
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Proyecto:</label><br>
					<select name="idProyecto" id="cbx-live-proyecto" class="flt_proyecto my_select2_ cbx-live-for-pdv vrf-live-list form-control form-control-sm" patron="requerido">
						<option value="">Seleccionar</option>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label>Grupo Canal:</label><br>
					<select name="idGrupoCanal" id="cbx-live-grupoCanal" class="flt_grupoCanal my_select2_ cbx-live-for-pdv vrf-live-list form-control form-control-sm" patron="requerido">
						<option value="">Seleccionar</option>
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Canal:</label><br>
					<select name="idCanal" id="cbx-live-canal" class="flt_canal my_select2_ cbx-live-for-pdv vrf-live-list form-control form-control-sm" patron="requerido">
						<option value="">Seleccionar</option>
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Sub Canal:</label><br>
					<select name="idSubCanal" id="cbx-live-subCanal" class="flt_subCanal my_select2_ cbx-live-for-pdv vrf-live-list form-control form-control-sm">
						<option value="">Seleccionar</option>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label>Agrupación:</label><br>
					<select name="idFormato" id="cbx-live-formato" class="form-control my_select2_ form-control-sm" patron="requerido">
						<option value="">Seleccionar</option>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 formato-live" style="display: none;">
				<div class="form-group">
					<label>Cadena:</label><br>
					<select name="idCadena" id="cbx-live-cadena" class="flt_cadena my_select2_ cbx-live-for-pdv vrf-live-list form-control form-control-sm" disabled>
						<option value="">Seleccionar</option>
						<?foreach($cadena as $idCadena => $cd){?>
							<option value="<?=$idCadena?>"><?=$cd['nombre']?></option>
						<?}?>
					</select>
				</div>
			</div>
			<div class="col-md-12 formato-live" style="display: none;">
				<div class="form-group">
					<label>Banner:</label><br>
					<select name="idBanner" id="cbx-live-banner" class="flt_banner my_select2_ cbx-live-for-pdv vrf-live-list form-control form-control-sm" disabled>
						<option value="">Seleccionar</option>
					</select>
				</div>
			</div>
			<div class="col-md-12 formato-live" style="display: none;">
				<div class="form-group">
					<label>Distribuidora:</label><br>
					<select name="idDistribuidora" id="cbx-live-distribuidora" class="flt_distribuidora my_select2_ cbx-live-for-pdv vrf-live-list form-control form-control-sm" disabled>
						<option value="">Seleccionar</option>
					</select>
				</div>
			</div>
			<div class="col-md-12 formato-live" style="display: none;">
				<div class="form-group">
					<label>Distribuidora Sucursal:</label><br>
					<select name="idDistribuidoraSucursal" id="cbx-live-distribuidoraSuc" class="flt_distribuidoraSucursal my_select2_ cbx-live-for-pdv vrf-live-list form-control form-control-sm" disabled>
						<option value="">Seleccionar</option>
					</select>
				</div>
			</div>
			<div class="col-md-12 formato-live" style="display: none;">
				<div class="form-group">
					<label>Plaza:</label><br>
					<select name="idPlaza" id="cbx-live-plaza" class="flt_plaza my_select2_ cbx-live-for-pdv vrf-live-list form-control form-control-sm" disabled>
						<option value="">Seleccionar</option>
					</select>
				</div>
			</div>
			<div class="col-md-12 formato-live" style="display: none;">
				<div class="form-group">
					<label>PDV: 
						<button id="btn-live-tienda-lista" class="btn btn-sm btn-primary"><i class="fa fa-sort-amount-asc"></i> Listar</button>
					</label><br>
					<select name="idCliente" id="cbx-live-pdv" class="flt_cliente vrf-live-list form-control" data-tags="false" multiple disabled></select>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label>Categorias:</label><br>
					<select name="idCategoria" id="cbx-live-categoria" class="cbx_categoria vrf-live-list form-control form-control-sm" multiple>
						<?foreach($categoria as $idCategoria => $cat){?>
							<option value="<?=$idCategoria?>"><?=$cat['nombre']?></option>
						<?}?>
					</select>
				</div>
			</div>
		</div>
	</div>
	<div id="page-live-2" class="page-live" style="display: none;"></div>
</form>
<script>
	$('#<?=$frm?> .my_select2_').select2({
		'width': '100%'
	});

	$('#cbx-live-categoria, #cbx-live-pdv').select2({
		'width': '100%',
		'closeOnSelect': false
	}).on('select2:close', function(e){
		var control = $(this);
		var uldiv = control.siblings('span.select2').find('ul');
		var count = control.find(':selected').length;

		if( count > 0 ){
			var multiple = (count > 1 ? 's' : '');
			uldiv.html('<li>' + count + ' Item' + multiple + ' seleccionado' + multiple + '</li>');
		}
		else{
			uldiv.html('');
		}
	});
	
</script>