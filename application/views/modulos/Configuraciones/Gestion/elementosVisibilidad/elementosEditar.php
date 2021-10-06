<form id="frm-elementoNuevoEditar">
	<div class="row themeWhite">
		<div class="col-md-12">
			<div class="mb-3 card">
				<div class="card-header">
					ELEMENTO DE VISIBILIDAD
				</div>
				<div class="card-body">
					<div class="tab-content">
						<? $idElementoVis = isset($elemento['idElementoVis']) && !empty($elemento['idElementoVis']) ? $elemento['idElementoVis']: ''; ?>
						<? $elementoNombre = isset($elemento['elemento']) && !empty($elemento['elemento']) ? $elemento['elemento']: ''; ?>
						<? $elementoTipo = isset($elemento['idTipoElementoVisibilidad']) && !empty($elemento['idTipoElementoVisibilidad']) ? $elemento['idTipoElementoVisibilidad']: ''; ?>
						<? $elementoCategoria = isset($elemento['idCategoria']) && !empty($elemento['idCategoria']) ? $elemento['idCategoria']: ''; ?>
						<div class="hide">
							<input type="text" name="elementoVisibilidad" id="elementoVisibilidad" value="<?=$idElementoVis?>">
						</div>
						<div class="position-relative form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">Nombre</span>
								</div>
								<input type="text" class="form-control" id="nombreElemento" name="nombreElemento" patron="requerido" value="<?=$elementoNombre;?>">
							</div>
						</div>
						<div class="position-relative form-group">
							<label for="slTipoElemento" class="">Tipo de Elemento:</label>
							<select type="select" id="slTipoElemento" name="slTipoElemento" class="custom-select" patron="requerido">
								<option value="">-- Seleccionar Tipo --</option>
								<? foreach ($listaTipoElementos as $kte => $tipo): ?>
									<? $optionSelected = $tipo['idTipoElementoVis']==$elementoTipo ? 'selected':''; ?>
									<option value="<?=$tipo['idTipoElementoVis']?>" <?=$optionSelected;?>><?=$tipo['tipoElemento']?></option>
								<? endforeach ?>
							</select>
						</div>
						<div class="position-relative form-group">
							<label for="slCategoria" class="">Categoría:</label>
							<select type="select" id="slCategoria" name="slCategoria" class="custom-select">
								<option value="">-- Seleccionar Categoría --</option>
								<? foreach ($listaCategorias as $kte => $categoria): ?>
									<? $optionSelected = $categoria['idCategoria']==$elementoCategoria ? 'selected':''; ?>
									<option value="<?=$categoria['idCategoria']?>" <?=$optionSelected;?> ><?=$categoria['categoria']?></option>
								<? endforeach ?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>