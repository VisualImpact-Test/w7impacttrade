<?
$modalDet = "";
$idPlaza = $plaza['id'];
?>
<style>
.tab-tienda {
	width: 120px;
	overflow: hidden;
	white-space: nowrap;
	text-overflow: ellipsis;
}

#nav-tienda:empty::before {
	content: '¡Ninguna tienda seleccionada para la auditoria!';
	color: red;
	margin: 3px;
	font-weight: bold;
}
</style>
<form id="<?=$frm?>" role="form">
	<div class="container-fluid">
		<div class="row content-lsck info">
			<div class="col-md-12 col-sm-12 col-xs-12 mb-4">
				<h5 class="text-center font-weight-bold h-lsck-title">INFORMACIÓN DE PLAZA</h5>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<span>Plaza:</span>
					<span class="font-weight-bold"><?=$plaza['nombre']?></span>
					<input type="hidden" name="idCuenta" value="3">
					<input type="hidden" name="idProyecto" value="3">
					<input type="hidden" id="idPlaza" name="idPlaza" value="<?=$idPlaza?>">
				</div>
			</div>
			<?
			$numInfo = count($info);
			$colNumInfo = round($numInfo / 2);
			$i = 1; $j = 1;
			foreach($info as $vinfo){?>
				<?if( $j == 1 ){?>
					<div class="col-md-4">
				<?}?>
						<?$valor = !isset($plazaInfo[$vinfo['idInfo']]) ? '0' : $plazaInfo[$vinfo['idInfo']]['valor'];?>
						<div class="form-group">
							<?$empresa = '';?>
							<?if( $vinfo['idInfo'] == 5 ){?>
								<?if( isset($plazaInfo[$vinfo['idInfo']]['empresa']) &&
									!empty($plazaInfo[$vinfo['idInfo']]['empresa'])
								){?>
									<?$empresa = " / {$plazaInfo[$vinfo['idInfo']]['empresa']}";?>
								<?}?>
							<?}?>
							<span><?=$vinfo['nombre']?></span>
							<span class="font-weight-bold"><?=$valor.$empresa?></span>
							<input type="hidden" name="punto[informacion][<?=$vinfo['idInfo']?>]" value="<?=$valor?>">
						</div>
				<?if( $i == $numInfo || $j == $colNumInfo ){?>
					</div>
					<?$j = 1;?>
				<?}else{?>
					<?$j++;?>
				<?}?>
				<?$i++;?>
			<?}?>
			<div class="col-md-4">
				<table class="table table-sm table-striped">
					<thead>
						<tr>
							<th>Tipo Cliente</th>
							<th># Tiendas</th>
							<?foreach($extAudTipo as $vex){?>
								<th>Prom. <?=$vex['nombre']?></th>
								<th># <?=$vex['nombre']?></th>
							<?}?>
						</tr>
					</thead>
					<tbody>
						<?foreach($tipoCliente as $vtc){?>
							<?$totalTiendas = !isset($plazaTipoCliente[$vtc['idTipoCliente']]) ? 0 : $plazaTipoCliente[$vtc['idTipoCliente']]['totalTienda'];?>
						<tr>
							<td><?=$vtc['nombre']?></td>
							<td class="text-center"><?=$totalTiendas?></td>
							<?foreach($extAudTipo as $idExtAudTipo => $vex){?>
								<?$promedio = !isset($extAudTipoProm[$vtc['idTipoCliente']][$idExtAudTipo]['valor']) ? 0 : $extAudTipoProm[$vtc['idTipoCliente']][$idExtAudTipo]['valor'];?>
								<?$total = !isset($audTipoTotal[$vtc['idTipoCliente']][$idExtAudTipo]['valor']) ? 0 : $audTipoTotal[$vtc['idTipoCliente']][$idExtAudTipo]['valor'];?>
								<td class="text-center"><?=$promedio?></td>
								<td class="text-center"><?=$total?></td>
							<?}?>
						</tr>
						<?}?>
					</tbody>
				</table>
			</div>
			<?if( !empty($evaluacionPlaza) ){?>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<h4>Adicionales: </h4>
				<?foreach($evaluacionPlaza as $idEvaluacion => $ev){?>
					<button type="button"
						class="btn btn-primary btn-sm"
						data-toggle="modal"
						data-target="#modal-lsck-plaza-evaluacion-<?=$idEvaluacion?>"
					><i class="fas fa-pencil-alt fa-lg"></i> <?=$ev['nombre']?></button>
					<input type="hidden" name="plaza-evaluacion[<?=$idPlaza?>]" value="<?=$idEvaluacion?>">
					<?
					$modalDet .= '<div id="modal-lsck-plaza-evaluacion-'.$idEvaluacion.'" class="modal-lsck-form modal fade" tabindex="-1" >';
						$modalDet .= '<div class="modal-dialog">';
							$modalDet .= '<div class="modal-content">';
								$modalDet .= '<div class="modal-header">';
									$modalDet .= '<h5 class="modal-title">Plaza - Evaluación</h5>';
									$modalDet .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
										$modalDet .= '<span aria-hidden="true">&times;</span>';
									$modalDet .= '</button>';
								$modalDet .= '</div>';
								$modalDet .= '<div class="modal-body">';
									$modalDet .= '<form id="'.$frm.'-plaza-eval-'.$idEvaluacion.'">';
										// $modalDet .= '<div class="row">';
											// $modalDet .= '<input type="hidden" name="plaza-evaluacion['.$idPlaza.']" value="'.$idEvaluacion.'">';
										// $modalDet .= '</div>';
										$modalDet .= '<div class="row p-3">';
											$modalDet .= '<div class="col-md-12 content-lsck-capturas">';
												$modalDet .= '<div class="form-group form-inline">';
													$modalDet .= '<label><i class="fas fa-camera-retro fa-lg"></i> Capturas:</label>';
													$modalDet .= '<input type="file" name="capturas" class="file-lsck-capturas form-control input-sm" placeholder="Cargar Imagen" data-plaza="'.$idPlaza.'" data-evaluacion="'.$idEvaluacion.'" accept=".png, .jpg, .jpeg" multiple >';
												$modalDet .= '</div>';
												$modalDet .= '<div class="content-lsck-galeria"></div>';
											$modalDet .= '</div>';
										$modalDet .= '</div>';
										$modalDet .= '<div class="row p-3">';
										foreach($evaluacionDetPlaza[$idEvaluacion] as $idEvaluacionDet => $evd){
											$modalDet .= '<div class="col-md-12">';
												$modalDet .= '<div class="content-lsck-eval form-row">';
													$modalDet .= '<div class="col-md-12 col-sm-12 col-xs-12">';
														if( !empty($evd['detallar']) ){
															$modalDet .= '<div class="form-group">';
																$modalDet .= '<label class="font-weight-bold pull-left">'.$evd['nombre'].'</label>';
																$modalDet .= '<div class="input-group input-group-lsck">';
																	$modalDet .= '<div class="input-group-addon">';
																		$modalDet .= '<button class="btn-lsck-comentario btn btn-xs" title="Ingresar Comentario" data-plaza="'.$idPlaza.'" data-evaluacion-det="'.$idEvaluacionDet.'" ><i class="fas fa-edit"></i></button>';
																	$modalDet .= '</div>';
																	$modalDet .= '<textarea id="plaza-comentario-'.implode('-', [$idPlaza,$idEvaluacionDet]).'" class="txt-lsck-comentario form-control" name="plaza-comentario['.$idPlaza.']['.$idEvaluacionDet.']" rows="1" maxlength="500" placeholder="Escribir"></textarea>';
																$modalDet .= '</div>';
															$modalDet .= '</div>';
														} else{
															$modalDet .= '<label class="font-weight-bold">'.$evd['nombre'].'</label>';
														}
														$modalDet .= '<input type="hidden" name="plaza-evaluacionDet['.$idPlaza.']['.$idEvaluacion.']" value="'.$idEvaluacionDet.'">';
													$modalDet .= '</div>';
													$modalDet .= '<div class="col-md-12 col-sm-12 col-xs-12">';
														$modalDet .= '<div class="form-row px-3">';
														$numPreg = 1;
														if( isset($preguntas[$evd['idEncuesta']]) ){
															foreach($preguntas[$evd['idEncuesta']] as $idPregunta => $preg){
																$modalDet .= '<div class="col-md-12 pb-3">';
																	$modalDet .= '<label>'.$numPreg++.') '.$preg['nombre'];
																		$modalDet .= '<input type="hidden" name="plaza-pregunta['.$idPlaza.']['.$idEvaluacionDet.']" value="'.$idPregunta.'">';
																	$modalDet .= '</label>';
																	if( in_array($preg['tipo'], [2, 3]) ){
																		$type = $preg['tipo'] == 2 ? 'radio' : ($preg['tipo'] == 3 ? 'checkbox' : '');
																		foreach($alternativas[$idPregunta] as $idAlternativa => $alt){
																			$modalDet .= '<div class="'.$type.'" style="padding-left: 1rem;">';
																				$modalDet .= '<label class="pointer">';
																					$modalDet .= '<input type="'.$type.'" class="mr-2" name="plaza-alternativa['.$idPlaza.']['.$idEvaluacionDet.']['.$idPregunta.']" value="'.$idAlternativa.'" >'.$alt['nombre'];
																				$modalDet .= '</label>';
																			$modalDet .= '</div>';
																		}
																	}
																	else{
																		$modalDet .= '<textarea name="plaza-respuesta['.$idPlaza.']['.$idEvaluacionDet.']['.$idPregunta.']" class="form-control" placeholder="Escriba una respuesta" rows=3></textarea>';
																	}
																$modalDet .= '</div>';
															}
														}
														$modalDet .= '</div>';
													$modalDet .= '</div>';
												$modalDet .= '</div>';
											$modalDet .= '</div>';
										}
										$modalDet .= '</div>';
									$modalDet .= '</form>';
								$modalDet .= '</div>';
								$modalDet .= '<div class="modal-footer">';
									$modalDet .= '<button type="button" class="btn btn-default btn-modal-close" data-id="#modal-lsck-plaza-evaluacion-'.$idEvaluacion.'">Cerrar</button>';
								$modalDet .= '</div>';
							$modalDet .= '</div>';
						$modalDet .= '</div>';
					$modalDet .= '</div>';
					?>
				<?}?>
			</div>
			<?}?>
		</div>
		<div class="row content-lsck">
			<div class="col-md-12 col-sm-12 col-xs-12 pb-3">
				<div class="row">
					<h5 class="font-weight-bold h-live-title col-auto my-2">TIENDAS:</h5>
					<div id="sch-tienda" class="ui fluid search category col-md-8">
						<div class="ui action input col-md-12">
							<input type="text" id="sch-tienda-input" class="prompt" name="sch-tiendas" placeholder="Buscar Tiendas">
							<input type="hidden" id="sch-tienda-id" name="sch-tienda-id" >
							<button type="button" id="btn-tienda-add" class="ui blue button">
								<i class="fas fa-store fa-lg mr-1"></i> Agregar
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="card-header card-header-tab">
						<ul id="nav-tienda" class="nav"></ul>
					</div>
					<div class="card-body">
						<div id="tab-content-tienda" class="tab-content"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<?echo $modalDet;?>
<script>
var frmLiveAuditoria = "<?=$frm?>";
var modalLiveAuditoria = "<?=$idModal?>";

var liveStorecheckForm = {
	idModal: 0,
	load: function(){

		$(document).off('shown.bs.modal', '#modal-page-' + modalLiveAuditoria).on('shown.bs.modal', '#modal-page-' + modalLiveAuditoria, function(){
			$('body').find('.modal-lsck-form').appendTo(document.body);
		});

		$('#sch-tienda').search({
			type: 'category',
			// minCharacters: 3,
			maxResults: 7,
			cache: false,
			apiSettings: { url: site_url + 'livestorecheck/buscar/<?=$idPlaza?>/{query}' },
			onSelect: function(item){
				$('#sch-tienda-id').val(item.id);
			}
		});

		$(document).off('click', '#btn-tienda-add').on('click', '#btn-tienda-add', function(e){
			var idPlaza = $('#idPlaza').val();
			var idCliente = $('#sch-tienda-id').val();
			var numTienda = $('#nav-tienda .nav-item').length;

			if( !idCliente ){
				var message = Fn.message({ type: 2, message: 'No ha seleccionado ninguna tienda' });
				Fn.showModal({ id: ++modalId, show: true, frm: message, btn: [{ title: 'Cerrar', fn: 'Fn.showModal({ id: ' + modalId + ', show: false });' }] });
				return false;
			}
			else if( $('#nav-item-' + idCliente).length > 0 ){
				var message = Fn.message({ type: 2, message: 'Tienda ya está agregada a la auditoria' });
				Fn.showModal({ id: ++modalId, show: true, frm: message, btn: [{ title: 'Cerrar', fn: 'Fn.showModal({ id: ' + modalId + ', show: false });' }] });

				$('#sch-tienda-input').val('');
				$('#sch-tienda-id').val('');

				return false;
			}

			var url = 'livestorecheck/formularioTienda';
			var data = { data: JSON.stringify({ idPlaza: idPlaza, idCliente: idCliente, numTienda: numTienda }) };

			$.when( Fn.ajax({ url: url, data: data }) ).then(function(a){
				if( a.result == 2 ) return false;
				else if( a.result == 0 ){
					Fn.showModal({
						'id': ++modalId,
						'show': true,
						'title': 'Auditoria',
						'frm': Fn.message({ type: 2, message: a['msg']['content'] }),
						'btn': [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + modalId + ', show: false });' }]
					});

					return false;
				}

				$('#sch-tienda-input').val('');
				$('#sch-tienda-id').val('');

				var view = JSON.parse(a.data.view);
				$('#nav-tienda').append(view.tab);
				$('#tab-content-tienda').append(view.eval);
				$(view.modal.enc).appendTo(document.body);
				$(view.modal.eval).appendTo(document.body);
				$(view.modal.det).appendTo(document.body);
			});
		});

		$(document).off('change', '.file-lsck-capturas').on('change', '.file-lsck-capturas', function(e){
			var control = $(this);

			var data = control.data();
			var frm = frmLiveAuditoria;

			var id = '';
			var nameImg = '';
			if( data['plaza'] ){
				id = data['plaza'];
				name = 'plaza-img';
			}
			else if( data['cliente'] ){
				id = data['cliente'];
				name = 'img';
			}


			if( control.val() ){
				var content = control.parents('.content-lsck-capturas:first').find('.content-lsck-galeria');
				var num = control.get(0).files.length;

				list: {
					var total = $('input[name="' + name + '[' + id + '][' + data['evaluacion'] + ']"]').length;
					if( (num + total) > 5 ){
						var message = Fn.message({ type: 2, message: 'Solo se permiten 5 capturas como máximo' });
						Fn.showModal({
							'id': ++modalId,
							'show': true,
							'title': 'Alerta',
							'frm': message,
							'btn': [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + modalId + ', show: false });' }]
						});

						break list;
					}

					for(var i = 0; i < num; ++i){
						var size = control.get(0).files[i].size;
							size = Math.round((size / 1024)); 

						if( size > 2048 ){
							var message = Fn.message({ type: 2, message: 'Solo se permite como máximo 1MB por captura' });
							Fn.showModal({
								'id': ++modalId,
								'show': true,
								'title': 'Alerta',
								'frm': message,
								'btn': [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + modalId + ', show: false });' }]
							});

							break list;
						}
					}

					for(var i = 0; i < num; ++i){
						Fn.handleImages(control.get(0).files[i], function(base64){
							var img = '';
								img += '<div class="content-lsck-capturas col-md-2 p-1 float-left">';
									img += '<div class="img-live">';
										img += '<span class="img-lsck-capturas-delete closes pointer" title="Eliminar" role="button">&times;</span>';
										img += '<input type="hidden" name="' + name +'[' + id + '][' + data['evaluacion'] + ']" class="calculo-lsck-no" value="' + base64 + '">';
										img += '<img src="' + base64 + '" class="img-lsck-capturas img-responsive img-thumbnail">';
									img += '</div>';
								img += '</div>';

							content.append(img);
						}, false);
					}
				}

				control.val('');
			}
		});

		$(document).off('click', '.img-lsck-capturas').on('click', '.img-lsck-capturas', function(e){
			e.preventDefault();
		});

		$(document).off('click', '.img-lsck-capturas-delete').on('click', '.img-lsck-capturas-delete', function(e){
			e.preventDefault();
			var control = $(this);
			control.parents('.content-lsck-capturas:first').remove();
		});

		$(document).off('click', '.btn-lsck-preguntas').on('click', '.btn-lsck-preguntas', function(e){
			e.preventDefault();
		});

		$(document).off('click', '.btn-lsck-competencia').on('click', '.btn-lsck-competencia', function(e){
			e.preventDefault();
		});

		$(document).off('click', '.btn-lsck-comentario').on('click', '.btn-lsck-comentario', function(e){
			e.preventDefault();
			var control = $(this);
			var data = control.data();
			var frm = frmLiveAuditoria;

			if( data['plaza'] ){
				var value = $('#plaza-comentario-' + data['plaza'] + '-' + data['evaluacionDet']).val();
				var maxlength = $('#plaza-comentario-' + data['plaza'] + '-' + data['evaluacionDet']).attr('maxlength');
					if( maxlength ){
						maxlength = 'maxlength="' + maxlength + '"';
					}

				var content = '';
					content += '<div class="form-group">';
						content += '<textarea class="form-control" rows="7" ' + maxlength + ' placeholder="Ingrese texto según corresponda." data-plaza="' + data['plaza'] + '" data-evaluacion-det="' + data['evaluacionDet'] + '">' + value + '</textarea>';
					content += '</div>';
			}
			else{
				var value = $('#comentario-' + data['cliente'] + '-' + data['evaluacionDet']).val();
				var maxlength = $('#comentario-' + data['cliente'] + '-' + data['evaluacionDet']).attr('maxlength');
					if( maxlength ){
						maxlength = 'maxlength="' + maxlength + '"';
					}

				var content = '';
					content += '<div class="form-group">';
						content += '<textarea class="form-control" rows="7" ' + maxlength + ' placeholder="Ingrese texto según corresponda." data-cliente="' + data['cliente'] + '" data-evaluacion-det="' + data['evaluacionDet'] + '">' + value + '</textarea>';
					content += '</div>';				
			}


			var idModal = ++modalId;
			liveStorecheckForm.idModal = idModal;

			var btn = [{ 'title': 'Cerrar', 'class': 'btn-lsck-comentario-close' }];
			Fn.showModal({
				'id': idModal,
				'show': true,
				'title': 'Comentario',
				'frm': content,
				'btn': btn
			});
		});

		$(document).off('click', '.btn-lsck-comentario-close').on('click', '.btn-lsck-comentario-close', function(e){
			e.preventDefault();
			var idModal = liveStorecheckForm.idModal;

			var data = $('#modal-page-' + idModal).find('textarea').data();
			var value = $('#modal-page-' + idModal).find('textarea').val();

			if( data['plaza'] )
				$('#plaza-comentario-' + data['plaza'] + '-' + data['evaluacionDet']).val(value);
			else
				$('#comentario-' + data['cliente'] + '-' + data['evaluacionDet']).val(value);

			Fn.showModal({ 'id': idModal, 'show': false });
		});

		$(document).off('click', '.btn-modal-close').on('click', '.btn-modal-close', function(e){
			e.preventDefault();
			var control = $(this);

			$(control.data('id')).bsModal('hide');
		});

	},
	data: function(calculo = false){
		var frm = frmLiveAuditoria;
		var data = !calculo ? Fn.formSerializeObject(frm) : Fn.formSerializeObject(frm, {'class': ['calculo-live-no']});

			$.each($('.modal-lsck-form').find('form'), function(i, v){
				var dataModal = Fn.formSerializeObject($(v).attr('id'));
				data = $.extend({}, dataModal, data);
			});

		return data;
	},

}
liveStorecheckForm.load();
</script>