var liveStorecheck = {
	idModal: 0,
	content: 'content-live-list-categorias',
	oConfirm: {},
	categorias: false,
	load: function(){

		liveStorecheck.categorias = false;

		$(document).on('click', '.btn-live-gestor-consultar', function(e){
			e.preventDefault();

			var url = 'configuraciones/gestion/liveStorecheck/consultar';
			$.when(Fn.ajax({ 'url': url })).then(function(a){
				if( a['result'] != 2 ){
					var content = liveStorecheck.content;
					View.replaceContentHtml(content, a['data']['html']);
				}
			});
		});

		$(document).on('click', '.btn-live-gestor-estado', function(e){
			e.preventDefault();
			var control = $(this);
			var estado = control.data('estado');

			var rowSelected = Fn.rowSelected('tb-live-list-categoria', 'id');
			var rowSelectedCount = rowSelected.length;

			var idModal = ++modalId;
			if( rowSelectedCount == 0 ){
				var btn = [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }];
				var message = '';
					message = 'No se ha seleccionado ningún registro';
					message = Fn.message({ 'type': 2, 'message': message });

				Fn.showModal({
						'id': idModal,
						'show': true,
						'title': 'Alerta',
						'frm': message,
						'btn': btn
					});

				return false;
			}

			var data = { 'data': JSON.stringify({ 'idListCategoria': rowSelected, 'estado': estado }) };
			var url = 'configuraciones/gestion/liveStorecheck/cambiarEstado';

			$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
				if( a['result'] != 2 ){
					if( a['result'] == 1 ){
						$('.btn-live-gestor-consultar').click();
					}

					var btn = [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }];
					Fn.showModal({
							'id': idModal,
							'show': true,
							'title': 'Estado',
							'frm': a['msg']['content'],
							'btn': btn
						});
				}
			});
		});

		$(document).on('click', '.btn-live-gestor-baja', function(e){
			e.preventDefault();
			var control = $(this);

			var rowSelected = Fn.rowSelected('tb-live-list-categoria', 'id');
			var rowSelectedCount = rowSelected.length;

			var idModal = ++modalId;
			if( rowSelectedCount == 0 ){
				var btn = [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }];
				var message = '';
					message = 'No se ha seleccionado ningún registro';
					message = Fn.message({ 'type': 2, 'message': message });

				Fn.showModal({
						'id': idModal,
						'show': true,
						'title': 'Alerta',
						'frm': message,
						'btn': btn
					});

				return false;
			}

			liveStorecheck['oConfirm']['data'] = { 'idListCategoria': rowSelected };

			message = '';
				message += '<div class="row">';
					message += '<div class="col-md-12">';
						message += '<div class="form-group">';
							message += '<label>Fecha Fin:</label>';
							message += '<input type="date" name="fecFin" id="fec-live-gestor-fin" class="form-control input-sm">';
						message += '</div>';
					message += '</div>';
				message += '</div>';

			Fn.showModal({
					'id': idModal,
					'show': true,
					'width': '300px',
					'title': 'Fecha Fin',
					'frm': message,
					'btn': [
							{ 'title': 'Guardar', 'id': 'btn-live-gestor-baja' },
							{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }
						]
				});

			liveStorecheck.idModal = idModal;
		});

		$(document).on('click', '#btn-live-gestor-baja', function(e){
			e.preventDefault();
			var fecFin = $('#fec-live-gestor-fin').val();

			if( fecFin.length == 0 ){
				var idModal = ++modalId;
				var btn = [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }];
				var message = 'Debe ingresar una fecha';
					message = Fn.message({ 'type': 2, 'message': message });

				Fn.showModal({
						'id': idModal,
						'show': true,
						'title': 'Alerta',
						'frm': message,
						'btn': btn
					});

				return false;
			}

			var message = '¿Desea dar de baja al(los) registro(s) seleccionado(s)?';
			liveStorecheck['oConfirm']['fn'] = 'liveStorecheck.darBaja()';
			liveStorecheck['oConfirm']['data']['fecFin'] = fecFin;
			liveStorecheck['oConfirm']['message'] = Fn.message({ 'type': 2, 'message': message });
			liveStorecheck.confirmar();
		});

		$(document).on('click', '.btn-live-gestor-alta', function(e){
			e.preventDefault();
			var control = $(this);

			var rowSelected = Fn.rowSelected('tb-live-list-categoria', 'id');
			var rowSelectedCount = rowSelected.length;

			var idModal = ++modalId;
			if( rowSelectedCount == 0 ){
				var btn = [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }];
				var message = '';
					message = 'No se ha seleccionado ningún registro';
					message = Fn.message({ 'type': 2, 'message': message });

				Fn.showModal({
						'id': idModal,
						'show': true,
						'title': 'Alerta',
						'frm': message,
						'btn': btn
					});

				return false;
			}

			var message = '¿Desea dar de alta al(los) registro(s) seleccionado(s)?';
			liveStorecheck['oConfirm'] = {
					'fn': 'liveStorecheck.darAlta()',
					'data': { 'idListCategoria': rowSelected },
					'message': Fn.message({ 'type': 2, 'message': message })
				};

			liveStorecheck.confirmar();
		});

		$(document).on('click', '.btn-live-gestor-nuevo', function(e){
			e.preventDefault();

			var url = 'configuraciones/gestion/liveStorecheck/nuevo';
			$.when(Fn.ajax({ 'url': url })).then(function(a){
				if( a['result'] != 2 ){
					var idModal = ++modalId;
					Fn.showModal({
						'id': idModal,
						'show': true,
						'large': true,
						'title': 'Nueva Lista',
						'frm': a['data']['view'],
						'btn': [
								{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' },
								{ 'title': '<i class="fas fa-arrow-left"></i> Atras', 'class': 'btn-success page-live-back hide', 'data': { 'action': 'back' } },
								{ 'title': '<i class="fas fa-arrow-right"></i> Seguir', 'class': 'btn-success page-live-next', 'data': { 'action': 'next', 'frm': a['data']['frm'] } },
								{ 'title': '<i class="fa fa-save"></i> Guardar', 'id': 'list-live-guardar', 'class': 'btn-success', 'data': { 'frm': a['data']['frm'] } }
							]
					});

					liveStorecheck.idModal = idModal;
				}
			});
		});

		$(document).on('click', '.btn-live-gestor-ver', function(e){
			e.preventDefault();
			var control = $(this);

			var data = { 'data': JSON.stringify(control.data()) };
			var url = 'configuraciones/gestion/liveStorecheck/ver';

			$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
				if( a['result'] != 2 ){
					var idModal = ++modalId;
					var btn = [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }];
					Fn.showModal({
							'id': idModal,
							'show': true,
							'title': 'Detalle',
							'frm': a['data']['view'],
							'btn': btn
						});
				}
			});
		});

		$(document).on('change', '#cbx-live-grupoCanal', function(){
			var control = $(this);
			var grupoCanal = parseInt(control.val());
			/*
				idFormato
				0: Ninguna Agrupacion
				1: Distribuidora
				2: DistribuidoraSucursal
				3: cadena
				4: banner
				5: plaza
				6: pdv
			*/

			$('#cbx-live-formato').find('option').not(':first').remove();
			$('#cbx-live-formato').val('');

			var html = '';
			if( $.inArray(grupoCanal, [1,4]) != -1 ){
				html += '<option value="1">Distribuidora</option>';
				html += '<option value="2">DistribuidoraSucursal</option>';
				html += '<option value="6">PDV</option>';
			}
			else if( $.inArray(grupoCanal, [2]) != -1 ){
				html += '<option value="3">Cadena</option>';
				html += '<option value="4">Banner</option>';
				html += '<option value="6">PDV</option>';
			}
			else if( $.inArray(grupoCanal, [5]) > -1 ){
				html += '<option value="5">Plaza</option>';
				html += '<option value="6">PDV</option>';
			}

			$('#cbx-live-formato').append(html);						
		});

		$(document).on('change', '#cbx-live-formato', function(){
			var control = $(this);
			var formato = parseInt(control.val());
			var grupoCanal = parseInt($('#cbx-live-grupoCanal').val());

			$('.formato-live').hide();
			$('.formato-live select').removeAttr('patron');
			$('.formato-live select').prop('disabled', true);

			if( $.inArray(grupoCanal, [1,4]) != -1 ){
				if( formato == 1 ){
					$('#cbx-live-distribuidora').prop('disabled', false);
					$('#cbx-live-distribuidora').val('');

					$('#cbx-live-distribuidora').parents('.formato-live:first').show();
				}
				else if( formato == 2 ){
					$('#cbx-live-distribuidora').prop('disabled', false);
					$('#cbx-live-distribuidora').val('');

					$('#cbx-live-distribuidoraSuc').prop('disabled', false);
					$('#cbx-live-distribuidoraSuc').find('option').not(':first').remove();
					$('#cbx-live-distribuidoraSuc').val('');

					$('#cbx-live-distribuidora').parents('.formato-live:first').show();
					$('#cbx-live-distribuidoraSuc').parents('.formato-live:first').show();
				}
				else if( formato == 6 ){
					$('#cbx-live-distribuidora').prop('disabled', false);
					$('#cbx-live-distribuidora').val('');

					$('#cbx-live-distribuidoraSuc').prop('disabled', false);
					$('#cbx-live-distribuidoraSuc').find('option').not(':first').remove();
					$('#cbx-live-distribuidoraSuc').val('');

					$('#cbx-live-pdv').prop('disabled', false);
					$('#cbx-live-pdv').find('option').not(':first').remove();
					$('#cbx-live-pdv').find('optgroup').remove();
					$('#cbx-live-pdv').val('');

					$('#cbx-live-distribuidora').parents('.formato-live:first').show();
					$('#cbx-live-distribuidoraSuc').parents('.formato-live:first').show();
					$('#cbx-live-pdv').parents('.formato-live:first').show();
				}
			}
			else if( $.inArray(grupoCanal, [2]) != -1 ){
				if( formato == 3 ){
					$('#cbx-live-cadena').prop('disabled', false);
					$('#cbx-live-cadena').val('');

					$('#cbx-live-cadena').parents('.formato-live:first').show();
				}
				else if( formato == 4 ){
					$('#cbx-live-cadena').prop('disabled', false);
					$('#cbx-live-cadena').val('');

					$('#cbx-live-banner').prop('disabled', false);
					$('#cbx-live-banner').find('option').not(':first').remove();
					$('#cbx-live-banner').val('');

					$('#cbx-live-cadena').parents('.formato-live:first').show();
					$('#cbx-live-banner').parents('.formato-live:first').show();
				}
				else if( formato == 6 ){
					$('#cbx-live-cadena').prop('disabled', false);
					$('#cbx-live-cadena').val('');

					$('#cbx-live-banner').prop('disabled', false);
					$('#cbx-live-banner').find('option').not(':first').remove();
					$('#cbx-live-banner').val('');

					$('#cbx-live-pdv').prop('disabled', false);
					$('#cbx-live-pdv').find('option').not(':first').remove();
					$('#cbx-live-pdv').find('optgroup').remove();
					$('#cbx-live-pdv').val('');

					$('#cbx-live-cadena').parents('.formato-live:first').show();
					$('#cbx-live-banner').parents('.formato-live:first').show();
					$('#cbx-live-pdv').parents('.formato-live:first').show();
				}
			}
			else if( $.inArray(grupoCanal, [5]) > -1 ){
				if( formato == 5 ){
					$('#cbx-live-plaza').prop('disabled', false);
					$('#cbx-live-plaza').val('');

					$('#cbx-live-plaza').parents('.formato-live:first').show();
				}
				else if( formato == 6 ){
					$('#cbx-live-plaza').prop('disabled', false);
					$('#cbx-live-plaza').val('');

					$('#cbx-live-pdv').prop('disabled', false);
					$('#cbx-live-pdv').find('option').not(':first').remove();
					$('#cbx-live-pdv').find('optgroup').remove();
					$('#cbx-live-pdv').val('');

					$('#cbx-live-plaza').parents('.formato-live:first').show();
					$('#cbx-live-pdv').parents('.formato-live:first').show();
				}
			}

			$('.formato-live select:visible').prop('patron', 'requerido');
		});

		$(document).on('change', '.cbx-live-for-pdv', function(){
			$('#cbx-live-pdv').find('option').not(':first').remove();
			$('#cbx-live-pdv').val('');
		});

		$(document).on('click', '#btn-live-tienda-lista', function(e){
			e.preventDefault();
			var control = $(this);
			var valor = control.val();

			if( (
					(
						$('#cbx-live-canal').val().length > 0 &&
						$('#cbx-live-subCanal').find('option').length == 1
					) ||
					$('#cbx-live-subCanal').val().length > 0
				) && (
					(
						$('#cbx-live-distribuidoraSuc').not('[disabled]').val() != undefined &&
						$('#cbx-live-distribuidoraSuc').not('[disabled]').val().length > 0
					) || (
						$('#cbx-live-banner').not('[disabled]').val() != undefined &&
						$('#cbx-live-banner').not('[disabled]').val().length > 0
					) || (
						$('#cbx-live-plaza').not('[disabled]').val() != undefined &&
						$('#cbx-live-plaza').not('[disabled]').val().length > 0
					)
				) &&
				$('#cbx-live-pdv').not('[disabled]').length > 0
			){

				var forPDV = {};
				$.each($('.cbx-live-for-pdv').not('[disabled]'), function(i, v){
					var name = $(v).attr('name');
					var value = $(v).val();

					forPDV[name] = value;
				});

				var data = { 'data': JSON.stringify(forPDV) };
				var url = 'configuraciones/gestion/liveStorecheck/tienda';

				$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
					if( a['result'] != 2 ){
						if( Fn.obj_count(a['data']['region']) > 0 ){
							$('#cbx-live-pdv').find('option').not(':first').remove();
							$('#cbx-live-pdv').val('');
						}

						$.each(a['data']['region'], function(i, v){
							var optHtml = '';
								optHtml += '<optgroup label="' + v + '">';
									$.each(a['data']['tienda'][i], function(ii, vv){
										optHtml += '<option value="' + ii +'">' + vv + '</option>';
									});
								optHtml += '</optgroup>';

							$('#cbx-live-pdv').append(optHtml);
						});
					}
				});
			}
			else{
				var message = '';
					message += '<div class="row">';
						message += '<div class="col-md-12">';
							message += Fn.message({ 'type': 2, 'message': 'Verifique que los siguientes datos esten seleccionados para listar los pdv' });
						message += '</div>';
					message += '</div>';
					message += '<div class="row">';
						message += '<div class="col-md-12 px-5">';
							message += '<div class="form-group mb-0">';
							if( $('#cbx-live-canal').val().length == 0 ){
								message += '<li>Canal</li>';
							}
							if(
								$('#cbx-live-subCanal').val().length == 0 &&
								$('#cbx-live-subCanal').find('option').length > 1
							){
								message += '<li>Sub Canal</li>';
							}
							if(
								$('#cbx-live-distribuidoraSuc').not('[disabled]').val() != undefined &&
								$('#cbx-live-distribuidoraSuc').not('[disabled]').val().length == 0
							){
								message += '<li>Distribuidora Sucursal</li>';
							}
							if(
								$('#cbx-live-banner').not('[disabled]').val() != undefined &&
								$('#cbx-live-banner').not('[disabled]').val().length == 0
							){
								message += '<li>Banner</li>';
							}
							if(
								$('#cbx-live-plaza').not('[disabled]').val() != undefined &&
								$('#cbx-live-plaza').not('[disabled]').val().length == 0
							){
								message += '<li>Plaza</li>';
							}

							message += '</div>';
						message += '</div>';
					message += '</div>';

				$('#cbx-live-pdv').find('option').not(':first').remove();
				$('#cbx-live-pdv').find('optgroup').remove();
				$('#cbx-live-pdv').val('');

				var idModal = ++modalId;
				Fn.showModal({
					'id': idModal,
					'show': true,
					'title': 'Alerta',
					'frm': message,
					'btn': [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }]
				});
			}

		});

		$(document).on('change', 'select.cbx_cadena', function(e){
			e.preventDefault();
			var control = $(this);

			var frm = control.parents('form:first');
			var frmId = frm.attr('id');

			list: {
				var cbx_banner = $('#' + frmId +' select.cbx_banner:not(:disabled)');
				var cbx_cliente = $('#' + frmId +' select.cbx_cliente:not(:disabled)');

				if( cbx_banner.length == 0 ) break list;
				
				if( cbx_banner.attr('multiple') == undefined ) cbx_banner.html('<option value="">SELECCIONAR</option>');
				else cbx_banner.html('');

				if( cbx_cliente.length > 0 ){
					if( cbx_cliente.attr('multiple') == undefined ) cbx_cliente.html('<option value="">SELECCIONAR</option>');
					else cbx_cliente.html('');
				}

				var idCadena = control.val();
				if(
					idCadena == null ||
					idCadena.length == 0 ||
					(idCadena.length == 1 && idCadena[0].length == 0)
				) break list;

				var data = { 'data': JSON.stringify({ 'idCadena': idCadena }) };
				var url = 'configuraciones/gestion/liveStorecheck/banner';

				$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
					if( a['result'] != 2 ){
						$.each(a['data'], function(i, v){
							cbx_banner.append('<option value="' + i +'">' + v + '</option>');
						});
					}
				});
			}

		});

		$(document).on('change', 'select.cbx_banner', function(e){
			e.preventDefault();
			var control = $(this);

			var frm = control.parents('form:first');
			var frmId = frm.attr('id');

			list: {
				var cbx_cliente = $('#' + frmId +' select.cbx_cliente:not(:disabled)');
				if( cbx_cliente.length == 0 ) break list;

				if( cbx_cliente.attr('multiple') == undefined ) cbx_cliente.html('<option value="">SELECCIONAR</option>');
				else cbx_cliente.html('');

				var idBanner = control.val();
				if(
					idBanner == null ||
					idBanner.length == 0 ||
					(idBanner.length == 1 && idBanner[0].length == 0)
				) break list;

				var data = { 'data': JSON.stringify({ 'idBanner': idBanner }) };
				var url = 'configuraciones/gestion/liveStorecheck/tienda';

				$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
					if( a['result'] != 2 ){
						if( Fn.obj_count(a['data']['region']) > 0 ){
							cbx_cliente.html('');
						}

						$.each(a['data']['region'], function(i, v){
							var optHtml = '';
								optHtml += '<optgroup label="' + v + '">';
									$.each(a['data']['tienda'][i], function(ii, vv){
										optHtml += '<option value="' + ii +'">' + vv + '</option>';
									});
								optHtml += '</optgroup>';

							cbx_cliente.append(optHtml);
						});
					}
				});
			}
		});

		$(document).on('change', 'select.cbx_calificar', function(e){
			e.preventDefault();
			var control = $(this);
			var valor = control.val();

			var cbx_encuesta = control.parents('div.row:first').find('.cbx_encuesta');
				if( cbx_encuesta.length == 0) return false;
				cbx_encuesta.val('');

			if( valor == 1 ){
				cbx_encuesta.prop('disabled', true);
			}
			else if( valor == 2 ){
				cbx_encuesta.prop('disabled', false);
			}
		});

		$(document).on('change', '.vrf-live-list', function(e){
			e.preventDefault();
			liveStorecheck.categorias = true;
		});

		$(document).on('click', '.page-live-back', function(e){
			e.preventDefault();
			var control = $(this);

			$('.page-live-back').addClass('hide');
			$('.page-live-next').removeClass('hide');

			if( !$('#page-live-1').is(':visible') ){
				$('#page-live-2').hide();
				$('#page-live-1').show();
			}
		});

		$(document).on('click', '.page-live-next', function(e){
			e.preventDefault();
			var control = $(this);
			var frm = control.data('frm');

			var message = '';
			var error = 0

			if( $('#txt-live-fecIni').val().length == 0 ){
				message = Fn.message({ 'type': 2, 'message': 'Debe ingresar una fecha de inicio' });
				error++;
			}
			else if(
				$('#cbx-live-distribuidora').is(':visibile') &&
				$('#cbx-live-distribuidora').val().length == 0
			){
				message = Fn.message({ 'type': 2, 'message': 'Debe elegir un valor para el campo de Distribuidora' });
				error++;
			}
			else if(
				$('#cbx-live-distribuidoraSuc').is(':visibile') &&
				$('#cbx-live-distribuidoraSuc').val().length == 0
			){
				message = Fn.message({ 'type': 2, 'message': 'Debe elegir un valor para el campo de Distribuidora Sucursal' });
				error++;
			}
			else if(
				$('#cbx-live-cadena').is(':visibile') &&
				$('#cbx-live-cadena').val().length == 0
			){
				message = Fn.message({ 'type': 2, 'message': 'Debe elegir un valor para el campo de Cadena' });
				error++;
			}
			else if(
				$('#cbx-live-banner').is(':visibile') &&
				$('#cbx-live-banner').val().length == 0
			){
				message = Fn.message({ 'type': 2, 'message': 'Debe elegir un valor para el campo de Banner' });
				error++;
			}
			else if(
				$('#cbx-live-pdv').is(':visibile') &&
				$('#cbx-live-pdv').val().length == 0
			){
				message = Fn.message({ 'type': 2, 'message': 'Debe elegir un valor para el campo de PDV' });
				error++;
			}
			else if(
				$('#cbx-live-categoria').val() == null ||
				$('#cbx-live-categoria').val().length == 0
			){
				message = Fn.message({ 'type': 2, 'message': 'Debe elegir un valor para el campo de Categoria' });
				error++;
			}

			if( error > 0 ){
				Fn.showModal({
						'id': ++modalId,
						'show': true,
						'title': 'Alerta',
						'frm': message,
						'btn': [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + modalId + ', show: false });' }]
					});
				return false;
			}

			var datos = Fn.formSerializeObject(frm);

			$('.page-live-back').removeClass('hide');
			$('.page-live-next').addClass('hide');

			if( !liveStorecheck.categorias ){
				$('#page-live-1').hide();
				$('#page-live-2').show();

				return false;
			}
			else{
				liveStorecheck.categorias = false;
			}

			var data = { 'data': JSON.stringify(Fn.formSerializeObject(frm)) }
			var url = 'configuraciones/gestion/liveStorecheck/construir'

			$('#page-live-2').html('Construyendo ...');
			$.when(Fn.ajax({ 'url': url, 'data': data })).then(function(a){
				if( a['result'] == 1 ){
					$('#page-live-2').html(a['data']['view']);

					$('#page-live-1').hide();
					$('#page-live-2').show();
				}
				else if( a['result'] == 0 ){
					Fn.showModal({
							'id': ++modalId,
							'show': true,
							'title': 'Alerta',
							'frm': a['msg']['content'],
							'btn': [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + modalId + ', show: false });' }]
						});
					return false;
				}
			});
		});

		$(document).on('click', '#list-live-guardar', function(e){
			e.preventDefault();
			var control = $(this);

			var frmId = control.data('frm');
			var frmData = Fn.formSerializeObject(frmId);

			var data = { 'data': JSON.stringify(frmData) };
			var url = 'configuraciones/gestion/liveStorecheck/calcular';

			$.when( Fn.ajax({ 'url': url, 'data': data, 'loading': 'Calculando Resultado' }) ).then(function(a){
				if( a['result'] == 1 ){
					var message = '¿Desea guardar los datos de la lista? ';
					liveStorecheck.oConfirm = {
							'frm': frmId,
							'fn': 'liveStorecheck.guardar()',
							'message': Fn.message({ 'type': 2, 'message': message })
						};

					liveStorecheck.confirmar();
				}
				else if( a['result'] == 0 ){
					Fn.showModal({
							'id': ++modalId,
							'show': true,
							'title': 'Alerta',
							'frm': a['msg']['content'],
							'btn': [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + modalId + ', show: false });' }]
						});
				}
			});
		});

		$(document).on('click', '#btn-confirm-ok', function(e){
			e.preventDefault;

			if( $.type(liveStorecheck['oConfirm']) != 'undefined' &&
				$.type(liveStorecheck['oConfirm']['fn']) != 'undefined'
			){
				eval(liveStorecheck['oConfirm']['fn']);
			}
		});

		$('.btn-live-gestor-consultar').click();
	},
	confirmar: function(){
		var defaults = { 'frm' : '', 'fn': '', 'idModal': '', 'title': 'Confirmar', 'message': Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' }), 'data': {} };
		var config = $.extend({}, defaults, liveStorecheck.oConfirm);

		var idModal = ++modalId;
		$.when( Fn.validateForm({ 'id' : config['frm'] }) ).then(function(a){
			if( !a ){
				var btn = [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }];
				Fn.showModal({
						'id': idModal,
						'show': true,
						'title': 'Alerta',
						'frm': Fn.message({ 'type': 2, 'message': 'Se encontró datos obligatorios que no fueron ingresados, verificar los datos remarcados en rojo' }),
						'btn': btn
					});
				return false;
			}

			var btn = [
					{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' },
					{ 'title': 'Continuar', 'id': 'btn-confirm-ok', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }
				];

			Fn.showModal({
					'id': idModal,
					'show': true,
					'title': config['title'],
					'frm': config['message'],
					'btn': btn
				});
		});
	},
	guardar: function(){
		var frm = liveStorecheck['oConfirm']['frm'];

		var data = { 'data': JSON.stringify(Fn.formSerializeObject(frm)) };
		var url = 'configuraciones/gestion/liveStorecheck/guardar';
		$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
			if( a['result'] != 2 ){
				if( a['result'] == 1 ){
					Fn.showModal({ 'id': liveStorecheck['idModal'], 'show': false });
					$('.btn-live-gestor-consultar').click();
				}

				var idModal = ++modalId;
				Fn.showModal({
					'id': idModal,
					'show': true,
					'title': 'Nueva Lista',
					'frm': a['msg']['content'],
					'btn': [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }]
				});
			}
		});
	},
	darAlta: function(){
		var data = { 'data': JSON.stringify(liveStorecheck['oConfirm']['data']) };
		var url = 'configuraciones/gestion/liveStorecheck/darAlta';

		$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
			if( a['result'] != 2 ){
				if( a['result'] == 1 ){
					Fn.showModal({ 'id': liveStorecheck['idModal'], 'show': false });
					$('.btn-live-gestor-consultar').click();
				}

				var idModal = ++modalId;
				Fn.showModal({
					'id': idModal,
					'show': true,
					'title': 'Fecha Fin',
					'frm': a['msg']['content'],
					'btn': [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }]
				});
			}
		});
	},
	darBaja: function(){
		var data = { 'data': JSON.stringify(liveStorecheck['oConfirm']['data']) };
		var url = 'configuraciones/gestion/liveStorecheck/darBaja';

		$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
			if( a['result'] != 2 ){
				if( a['result'] == 1 ){
					Fn.showModal({ 'id': liveStorecheck['idModal'], 'show': false });
					$('.btn-live-gestor-consultar').click();
				}

				var idModal = ++modalId;
				Fn.showModal({
					'id': idModal,
					'show': true,
					'title': 'Fecha Fin',
					'frm': a['msg']['content'],
					'btn': [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }]
				});
			}
		});
	}
}
liveStorecheck.load();