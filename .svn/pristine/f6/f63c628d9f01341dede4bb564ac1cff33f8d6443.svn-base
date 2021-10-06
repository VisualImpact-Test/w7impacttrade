<!-- <form id="<?=$frm?>"> -->
<style>
.btn-flotante {
	font-size: 16px; /* Cambiar el tamaño de la tipografia */
	text-transform: uppercase; /* Texto en mayusculas */
	font-weight: bold; /* Fuente en negrita o bold */
	color: #ffffff; /* Color del texto */
	border-radius: 5px; /* Borde del boton */
	letter-spacing: 2px; /* Espacio entre letras */
	background-color: #1e66e9; /* Color de fondo */
	 /*padding: 18px 30px; /* Relleno del boton */
	/* position: fixed; */
	/* bottom: 20%; */
	right: 20%;
	transition: all 300ms ease 0ms;
	box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
	z-index: 99;
}
.btn-flotante:hover {
	background-color: #2c2fa5; /* Color de fondo al pasar el cursor */
	box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.3);
	transform: translateY(-7px);
}
@media only screen and (max-width: 600px) {
 	.btn-flotante {
		font-size: 14px;
		padding: 12px 20px;
		bottom: 20px;
		right: 20px;
	}
} 


</style>
<form id="formNew">
	<div class="row m-2">
		<div class="col-md-12 d-none" >
			<div class="form-group">
				<label>Cuenta:</label>
				<select name="idCuenta" class="flt_cuenta form-control form-control-sm" patron="requerido">
					<?foreach($cuenta as $cu){?>
						<option value="<?=$cu['id']?>"><?=$cu['nombre']?></option>
					<?}?>
				</select>
			</div>
		</div>
		<div class="col-md-12" style="">
			<div class="form-group">
				<!-- <label>Formato de Preguntas:<?=nbs(3);?></label> -->
				<div class="input-group mb-3">
					<input style="font-size:20px" type="text" name="encuesta" class="form-control form-control-sm" placeholder="Formato de preguntas sin título." maxLength="250" patron="requerido" />
					<div class="input-group-append">
						<!-- <button class="btn btn-outline-secondary" type="button" id="button-addon2">Button</button> -->
						<button class="btn-flotante btn btn-outline-secondary btn-live-pregunta" title="Agregar Pregunta"><i class="fas fa-plus"></i> </button>
					</div>
				
				</div>
				<select name="flag_cliente" id="flag_cliente" class="form-control" style="font-size:15px">
						<option value="0">Encuesta de Evaluación</option>
						<option value="1">Encuesta de Tienda</option>
				</select>
			</div>
		</div>
		<div class="col-md-12 content-live-pregunta" style="padding-top: 10px;">
			<div class="row cont_input" style="padding: 1rem;border-left:solid 5px ;border-radius:15px;box-shadow: 10px 5px 5px #00000073">
				<div class="col-md-12 form-inline">

					<div class="form-group mr-1" style="font-size: 20px;">
						<input type="hidden" name="aPregunta" value="1"/>
						<input type="text" name="pregunta[1]" class="form-control form-control-sm" placeholder="Pregunta" maxLength="250" patron="requerido"/>
					</div>
					<div class="form-group mr-1">
						<select name="tipo[1]" class="cbx-live-pregunta-tipo form-control form-control-sm"  patron="requerido">
							<?foreach($tipos as $idTipo => $tp){?>
							<option value="<?=$idTipo?>" <?=($idTipo == 1 ? 'selected' : '')?>><?=$tp['nombre']?></option>
							<?}?>
						</select>
					</div>
					<div class="form-group mr-1">
						<button class="btn-live-alternativa btn btn-primary btn-sm" title="Agregar Alternativa" disabled><i class="fas fa-plus"></i> Alternativas</button>
					</div>



					<!-- <div class="form-group mr-1 checkVerDetalle d-none form-check">
						<label for="checkDetalle[1]" class="mr-1 form-check-label">Ver Detalle:</label>
						<input type="checkbox" id="checkDetalle[1]" name="checkDetalle[1]" class="form-control form-control-sm" patron="requerido"/>
					</div> -->

				</div>
				<div class="col-md-12 content-live-alternativa">
					<div class="row px-5 py-2"></div>
				</div>
				<hr style="border: solid 1px lightgrey;width: 100%;">
				<div class="col-md-12">
					<div style="float:right">
						<div class="checkVerDetalle custom-control custom-switch" style="padding-top: 5px;padding-left: 40px;" >
							<input type="checkbox" id="checkDetalle[1]" name="checkDetalle[1]"  class="custom-control-input">
							<label class="custom-control-label" for="checkDetalle[1]">Ver Detalle</label>
						</div>
					</div>
					<div style="float:right">
						<hr class="vt">
					</div>
					<div style="float:right;padding-right:10px;padding-left:10px">
						<button class="btn-live-pregunta-borrar btn btn-outline-primary" disabled><i class="fa fa-trash-alt"></i></button>
						<!-- <button type="button"  title="Duplicar pregunta" class="btn-live-pregunta-copiar btn btn-outline-primary" ><i class="fa fa-copy"></i></button> -->
					</div>
					<div style="float:right">
						<hr class="vt">
					</div>
					<div style="float:right">
						<div class="form-group mr-1 tipoPresencia d-none">
							<select name="presencia[1]" class=" form-control form-control-sm"  patron="requerido">
								<option value="">-- Tipo Presencia --</option>
								<option value="SI">Presentes</option>
								<option value="NO">No Presentes</option>
							</select>
						</div>
					</div>
					<div style="float:right;padding-right:10px">
						<div class="form-group mr-1 tiposAuditoria d-none">
							<select name="tipoAuditoria[1]" class=" form-control form-control-sm"  patron="requerido">
								<option value="">-- Tipo Auditoría --</option>
								<?foreach($tiposAuditoria as $idTipo => $tp){?>
								<option value="<?=$tp['id']?>" ><?=$tp['value']?></option>
								<?}?>
							</select>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<script>
var contPregunta = 1;

var htmlPregunta = `

<div class="row preg-live-input cont_input" style="padding: 1rem;border-left:solid 5px gray;border-radius:15px;box-shadow: 10px 5px 5px #00000073">
	<div class="col-md-12 form-inline">
		<div class="form-group mr-1" style="font-size: 20px;">
			<input type="hidden" name="aPregunta" value="??"/>
			<input type="text" name="pregunta[??]" class="form-control form-control-sm" placeholder="Pregunta" maxLength="250" patron="requerido"/>
		</div>
		<div class="form-group mr-1">
			<select name="tipo[??]" class="cbx-live-pregunta-tipo form-control form-control-sm" patron="requerido">
				<?foreach($tipos as $idTipo => $tp){?>
				<option value="<?=$idTipo?>" <?=($idTipo == 1 ? 'selected' : '')?>><?=$tp['nombre']?></option>
				<?}?>
			</select>
		</div>
		<div class="form-group mr-1">
		<button class="btn-live-alternativa btn btn-primary btn-sm" title="Agregar Alternativa" disabled><i class="fas fa-plus"></i> Alternativas</button>
		</div>


	</div>
	<div class="col-md-12 content-live-alternativa">
		<div class="row px-5 py-2"></div>
	</div>
	<hr style="border: solid 1px lightgrey;width: 100%;">
	<div class="col-md-12">
		<div style="float:right">
			<div class="checkVerDetalle custom-control custom-switch" style="padding-top: 5px;padding-left: 40px;" >
				<input type="checkbox" id="checkDetalle[??]" name="checkDetalle[??]"  class="custom-control-input">
				<label class="custom-control-label" for="checkDetalle[??]">Ver Detalle</label>
			</div>
		</div>
		<div style="float:right">
			<hr class="vt">
		</div>
		<div style="float:right;padding-right:10px;padding-left:10px">
			<button title="Eliminar pregunta" class="btn-live-pregunta-borrar btn btn-outline-primary "><i class="fa fa-trash-alt"></i></button>
			<!-- <button type="button"  title="Duplicar pregunta" class="btn-live-pregunta-copiar btn btn-outline-primary" ><i class="fa fa-copy"></i></button> -->
		</div>
		<div style="float:right">
			<hr class="vt">
		</div>
		<div style="float:right">
			<div class="form-group mr-1 tipoPresencia d-none">
				<select name="presencia[??]" class=" form-control form-control-sm"  patron="requerido">
					<option value="">-- Tipo Presencia --</option>
					<option value="SI">Presentes</option>
					<option value="NO">No Presentes</option>
				</select>
			</div>
		</div>
		<div style="float:right;padding-right:10px">
			<div class="form-group mr-1 tiposAuditoria d-none">
				<select name="tipoAuditoria[??]" class=" form-control form-control-sm"  patron="requerido">
					<option value="">-- Tipo Auditoría --</option>
					<?foreach($tiposAuditoria as $idTipo => $tp){?>
					<option value="<?=$tp['id']?>" ><?=$tp['value']?></option>
					<?}?>
				</select>
			</div>	
		</div>
	</div>
</div>
`;

var htmlAlternativa = `
<div class="col-md-12 alt-live-input">
		<div class="input-group mb-3">
			<input type="text" name="alternativa[??]" class="form-control form-control-sm" placeholder="Ingrese una alternativa" maxLength="200" patron="requerido" />
			<div class="input-group-append">
				<!-- <button class="btn btn-outline-secondary" type="button" id="button-addon2">Button</button> -->
				<button style="border:none;" class="btn-live-alternativa-borrar btn btn-outline-secondary btn-sm" title="Borrar Alternativa"><i class="fa fa-times"></i></button>
			</div>
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

	if(control.val() == 3){
		content.find('.tiposAuditoria ').removeClass('d-none');
		content.find('.tipoPresencia').removeClass('d-none');
		// content.find('.checkVerDetalle').removeClass('d-none');
	}else{
		content.find('.tiposAuditoria select').val('');
		// content.find('.checkVerDetalle input').prop('checked',false);
		content.find('.tipoPresencia select').val('');

		content.find('.tiposAuditoria').addClass('d-none');
		// content.find('.checkVerDetalle').addClass('d-none');
		content.find('.tipoPresencia').addClass('d-none');
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
$(document).off('click', '.btn-live-pregunta-copiar').on('click', '.btn-live-pregunta-copiar', function(e){
	e.preventDefault();
	var control = $(this);
	var copy = control.parents('.preg-live-input:first').html();

	var htmlPregunta_ = $.replaceAll(htmlPregunta, '??', contPregunta);
	$('.content-live-pregunta').append(htmlPregunta_);
});

$(document).off('click', '.btn-live-alternativa-borrar').on('click', '.btn-live-alternativa-borrar', function(e){
	e.preventDefault();
	var control = $(this);
	control.parents('.alt-live-input:first').remove();
});
$('.content-live-pregunta').on('click', function(e) {
  if (e.target !== this)
    return;  
});

$(document).on('click','.content-live-pregunta .row input,.content-live-pregunta .row select,.content-live-pregunta .row button',function(){
	let control = $(this);

	$('.cont_input').css('border-left','solid 5px gray')
	control.parents('.cont_input').css('border-left','solid 5px #0072ff');
})


</script>