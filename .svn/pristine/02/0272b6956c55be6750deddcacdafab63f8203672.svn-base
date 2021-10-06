<form id="<?=$frm?>">
	<div class="row m-2">
		<div class="col-md-12">
			<div class="form-group">
				<label>Cuenta:</label>
				<select name="idCuenta" class="flt_cuenta form-control form-control-sm" patron="requerido">
					<?foreach($cuenta as $cu){?>
						<option value="<?=$cu['id']?>"><?=$cu['nombre']?></option>
					<?}?>
				</select>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Formato de Preguntas:<?=nbs(3);?><button class="btn-live-pregunta btn btn-primary btn-sm" title="Agregar Pregunta"><i class="fas fa-plus"></i> Preguntas</button></label>
				<input type="text" name="encuesta" class="form-control form-control-sm" placeholder="Ingrese un título" maxLength="250" patron="requerido" />
			</div>
		</div>
		<div class="col-md-12 content-live-pregunta">
			<div class="row" style="padding: 1rem;">
				<div class="col-md-12 form-inline">
					<div class="form-group mr-1">
						<label class="mr-1">Pregunta:<?=nbs(3);?><button class="btn-live-pregunta-borrar btn btn-danger btn-sm" disabled><i class="fa fa-trash-alt"></i></button></label>
						<input type="hidden" name="aPregunta" value="1"/>
						<input type="text" name="pregunta[1]" class="form-control form-control-sm" placeholder="Ingrese una pregunta" maxLength="250" patron="requerido"/>
					</div>
					<div class="form-group mr-1">
						<select name="tipo[1]" class="cbx-live-pregunta-tipo form-control form-control-sm"  patron="requerido">
							<?foreach($tipos as $idTipo => $tp){?>
							<option value="<?=$idTipo?>" <?=($idTipo == 1 ? 'selected' : '')?>><?=$tp['nombre']?></option>
							<?}?>
						</select>
					</div>
					<button class="btn-live-alternativa btn btn-primary btn-sm" title="Agregar Alternativa" disabled><i class="fas fa-plus"></i> Alternativas</button>
				</div>
				<div class="col-md-12 content-live-alternativa">
					<div class="row p-2"></div>
				</div>
			</div>
		</div>
	</div>
</form>
<script>
var contPregunta = 1;

var htmlPregunta = `
<div class="row preg-live-input" style="padding: 1rem;">
	<div class="col-md-12 form-inline">
		<div class="form-group mr-1">
			<label class="mr-1">Pregunta:<?=nbs(3);?><button class="btn-live-pregunta-borrar btn btn-danger btn-sm" title="Borrar Pregunta"><i class="fa fa-trash-alt"></i></button></label>
			<input type="hidden" name="aPregunta" value="??"/>
			<input type="text" name="pregunta[??]" class="form-control form-control-sm" placeholder="Ingrese una pregunta" maxLength="250" patron="requerido"/>
		</div>
		<div class="form-group mr-1">
			<select name="tipo[??]" class="cbx-live-pregunta-tipo form-control form-control-sm" patron="requerido">
				<?foreach($tipos as $idTipo => $tp){?>
				<option value="<?=$idTipo?>" <?=($idTipo == 1 ? 'selected' : '')?>><?=$tp['nombre']?></option>
				<?}?>
			</select>
		</div>
		<button class="btn-live-alternativa btn btn-primary btn-sm" title="Agregar Alternativa" disabled><i class="fas fa-plus"></i> Alternativas</button>
	</div>
	<div class="col-md-12 content-live-alternativa">
		<div class="row px-5 py-2"></div>
	</div>
</div>
`;

var htmlAlternativa = `
<div class="col-md-12 alt-live-input">
	<div class="form-group">
		<label class="mr-1">Alternativa:<?=nbs(3);?><button class="btn-live-alternativa-borrar btn btn-danger btn-sm" title="Borrar Alternativa"><i class="fa fa-trash-alt"></i></button></label>
		<input type="text" name="alternativa[??]" class="form-control form-control-sm" placeholder="Ingrese una alternativa" maxLength="200" patron="requerido" />
	</div>
</div>
`;

$(document).off('change', '.cbx-live-pregunta-tipo').on('change', '.cbx-live-pregunta-tipo', function(e){
	e.preventDefault();
	var control = $(this);
	var content = control.parents('.row:first');

	if( control.val() != 1 ){
		content.find('.btn-live-alternativa').prop('disabled', false);
	}
	else{
		content.find('.btn-live-alternativa').prop('disabled', true);
		content.find('.content-live-alternativa .row').html('');
	}
});

$(document).off('click', '.btn-live-pregunta').on('click', '.btn-live-pregunta', function(e){
	e.preventDefault();
	contPregunta++;

	var htmlPregunta_ = $.replaceAll(htmlPregunta, '??', contPregunta);
	$('.content-live-pregunta').append(htmlPregunta_);
});

$(document).off('click', '.btn-live-alternativa').on('click', '.btn-live-alternativa', function(e){
	e.preventDefault();
	var control = $(this);
	var content = control.parents('.row:first');

	var contPregunta_ = content.find('input[name="aPregunta"]').val();
	var htmlAlternativa_ = $.replaceAll(htmlAlternativa, '??', contPregunta_);
	content.find('.content-live-alternativa .row').append(htmlAlternativa_);
});

$(document).off('click', '.btn-live-pregunta-borrar').on('click', '.btn-live-pregunta-borrar', function(e){
	e.preventDefault();
	var control = $(this);
	control.parents('.preg-live-input:first').remove();
});

$(document).off('click', '.btn-live-alternativa-borrar').on('click', '.btn-live-alternativa-borrar', function(e){
	e.preventDefault();
	var control = $(this);
	control.parents('.alt-live-input:first').remove();
});

</script>