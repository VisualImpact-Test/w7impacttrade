var liveStorecheck = {
	data: {},
	content: 'content-live-auditorias',
	idModal: 0,
	oConfirm: {},
	load: function(){
		$(document).on('change', '#frm-live-filtros select[name=idCadena]', function(e){
			e.preventDefault();
			var control = $(this);
			var cbx_banner = $('#frm-live-filtros select[name=idBanner]');
			var idCadena = control.val();

			cbx_banner.html('<option value="">SELECCIONAR</option>');

			if( idCadena.length == 0 ){
				return false;
			}

			var data = { 'data': JSON.stringify({ 'idCadena': idCadena }) };
			var url = 'liveStorecheck/banner';

			$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
				if( a['result'] != 2 ){
					$.each(a['data'], function(i, v){
						cbx_banner.append('<option value="' + i +'">' + v + '</option>');
					});
				}
			});
		});

		$(document).on('click', '.btn-live-consultar', function(e){
			e.preventDefault();
			var control = $(this);
			var idModal = ++modalId;

			var frm = Fn.formSerializeObject('frm-live-filtros');
				frm['idModal'] = idModal;

			var data = { 'data': JSON.stringify(frm) };
			var url = 'liveStorecheck/auditorias';

			$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
				if( a['result'] != 2 ){
					var contentId = liveStorecheck.content;
					Fn.replaceContent(contentId, a['data']['html']);
				}
			});

			liveStorecheck['idModal'] = idModal;
		});

		$(document).on('click', '#btn-live-historico', function(e){
			e.preventDefault();

			var rowSelected = Fn.rowSelected('tb-live-tiendas-auditadas');
			var rowSelectedCount = rowSelected.length;

			if( rowSelectedCount == 0 || rowSelectedCount > 1 ){
				var idModal = ++modalId;
				var btn = [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }];
				var message = '';
					if( rowSelectedCount == 0 ) message = 'No se ha seleccionado ningún registro';
					else message = 'Debe seleccionar solo un pdv';
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

			var data = { 'data': JSON.stringify( rowSelected[0] ) };
			var url = 'liveStorecheck/historico';

			$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
				if( a['result'] != 2 ){
					var idModal = ++modalId;
					var btn = [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }];

					Fn.showModal({
							'id': idModal,
							'show': true,
							'title': 'Histórico',
							'frm': a['data']['html'],
							'btn': btn
						});

					liveStorecheck.idModal = idModal;
				}
			});
		});

		$(document).on('click', '.btn-live-pdf-individual', function(e){
			e.preventDefault();

			var idAuditoria = {0:$(this).attr('data-id')};

			var data = { 'data': JSON.stringify({ 'idAuditoria': idAuditoria }) };
			var url = 'adt_pdf/auditoria_pdf';

			Fn.download(url,data);
		});

		$(document).on('click', '#btn-live-pdf', function(e){
			e.preventDefault();

			var rowSelected = Fn.rowSelected('tb-live-tiendas-auditadas', 'id');
			var rowSelectedCount = rowSelected.length;

			if( rowSelectedCount == 0  ){
				var idModal = ++modalId;
				var btn = [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }];
				var message = '';
					if( rowSelectedCount == 0 ) message = 'No se ha seleccionado ningún registro';
					else message = 'Debe seleccionar solo una tienda';
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

			var data = { 'data': JSON.stringify({ 'idTienda': rowSelected , "filas":rowSelectedCount}) };
			var url = 'adt_pdf/auditoria_pdf';

			// $.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
			// 	if( a['result'] != 2 ){
			// 		var idModal = ++modalId;
			// 		var btn = [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }];

			// 		Fn.showModal({
			// 				'id': idModal,
			// 				'show': true,
			// 				'title': 'PDF',
			// 				'content': "Se generó el pdf",
			// 				'btn': btn
			// 			});

			// 		liveStorecheck.idModal = idModal;
			// 	}
			// });

			Fn.download(url,data);

		});

		$(document).on('click', '#btn-live-tiendas', function(e){
			e.preventDefault();
			var control = $(this);
			var idModal = ++modalId;

			var data = { 'data': JSON.stringify({ 'idModal': idModal }) };
			var url = 'liveStorecheck/tiendas';

			$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
				if( a['result'] != 2 ){
					Fn.showModal({
						'id': idModal,
						'show': true,
						'width': '70%',
						'title': 'Auditoria',
						'content': a['data']['view'],
						'btn': [
								{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' },
								{ 'title': '<i class="fas fa-flag-checkered"></i> Iniciar', 'id': 'btn-live-auditar', 'class': 'btn-success' },
								{ 'title': '<i class="fa fa-search"></i> Buscar', 'id': 'btn-live-tiendas-lista', 'class': 'btn-success' }
							]
					});
				}
			});

			liveStorecheck['idModal'] = idModal;
		});

		$(document).on('click', '#btn-live-tiendas-lista', function(e){
			e.preventDefault();
			var control = $(this);
			var idModal = ++modalId;

			var data = { 'data': JSON.stringify(Fn.formSerializeObject('frm-live-tiendas')) };
			var url = 'liveStorecheck/tiendasLista';

			$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
				if( a['result'] != 2 ){
					Fn.replaceContent('content-live-tiendas-lista', a['data']['view']);
				}
			});
		});

		$(document).on('click', '#btn-live-auditar', function(e){
			e.preventDefault();
			if( $('#tb-live-tiendas').DataTable().rows('.selected').count() == 0 ){
				var message = Fn.message({ 'type': 2, 'message': 'Debe seleccionar una tienda para iniciar auditoria' });
				Fn.showModal({
					'id': ++modalId,
					'show': true,
					'title': 'Alerta',
					'frm': message,
					'btn': [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + modalId + ', show: false });' }]
				});
				return false;
			}

			// var idTienda = $($('#tb-live-tiendas').DataTable().rows('.selected').nodes()[0]).data('id');
			var data = $($('#tb-live-tiendas').DataTable().rows('.selected').nodes()[0]).data();
			var aTitle = $("#tb-live-tiendas").DataTable().columns().header().toArray().map(x => x.innerText)
			var aData = $('#tb-live-tiendas').DataTable().rows('.selected').data()[0];

			var message = '';
				message += '<div class="row">';
					message += '<div class="col-md-12">';
						message += Fn.message({ 'type': 3, 'message': '¿Desea empezar auditoria a la tienda seleccionada?' });
					message += '</div>';
				message += '</div>';
				message += '<div class="row">';
					message += '<div class="col-md-12 px-5">';
						$.each(aTitle, function(i, v){
							message += '<div class="form-group mb-0">';
								message += '<span class="font-weight-bold">' + v +': </span>';
								message += '<label>' + aData[i] +'</label>';
							message += '</div>';
						});
					message += '</div>';
				message += '</div>';

			liveStorecheck.oConfirm = {
					'fn': 'liveStorecheck.auditar();',
					'message': message,
					'data': data
				};

			liveStorecheck.confirmar();
		});

		$(document).on('click', '#btn-live-auditar-tienda', function(e){
			var control = $(this);
			var message = Fn.message({ 'type': 3, 'message': '¿Desea empezar auditoria a la tienda?' });

			liveStorecheck.oConfirm = {
					'fn': 'liveStorecheck.auditar();',
					'message': message,
					'data': control.data()
				};

			liveStorecheck.confirmar();
		});

		$(document).on('click', '#btn-live-guardar', function(e){
			e.preventDefault();
			var control = $(this);

			var frmId = control.data('frm');
			var frmData = liveStorecheckForm.data(true);

			var data = { 'data': JSON.stringify(frmData) };
			var url = 'liveStorecheck/calcular';

			$.when( Fn.ajax({ 'url': url, 'data': data, 'loading': 'Calculando Resultado' }) ).then(function(a){
				if( a['result'] != 2 ){

					var message = '¿Desea guardar los datos de la auditoria? ';
						message += '<label class="font-weight-bold">Nota Calculada: ' + a['data']['nota'] + '</label>';
					
					liveStorecheck.oConfirm = {
							'frm': frmId,
							'fn': 'liveStorecheck.guardar()',
							'message': Fn.message({ 'type': 2, 'message': message })
						};

					liveStorecheck.confirmar();
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

		$(document).on('click', '#btn-live-form-close', function(e){
			e.preventDefault();
			var control = $(this);
			var idModal = control.data('modal');

			$('body').find('.modal-live-preguntas').remove();
			Fn.showModal({ 'id': idModal, 'show': false });
		});

		$(document).on('click', '.btn-live-fotos', function(e){
			e.preventDefault();
			var control = $(this);
			var idAuditoria = control.data('id');

			var data = { 'data': JSON.stringify({ 'idAuditoria': idAuditoria }) };
			var url = 'liveStorecheck/fotos';

			$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
				var idModal = ++modalId;
				if( a['result'] == 1 ){
					Fn.showModal({
						'id': idModal,
						'show': true,
						'width': '80%',
						'title': 'Auditoria Fotos',
						'frm': a['data']['view'],
						'btn': [
								{ 'title': 'Cerrar', 'id': 'btn-live-form-close', 'data': { 'modal': idModal } },
								{ 'title': '<i class="fa fa-save"></i> Guardar', 'id': 'btn-live-guardar-fotos-estado', 'data': { 'frm': a['data']['frm'] }  }
							]
					});

					liveStorecheck['idModal'] = idModal;
				}
				else if( a['result'] == 0 ){
					Fn.showModal({
						'id': idModal,
						'show': true,
						'title': 'Auditoria Fotos',
						'frm': a['data']['view'],
						'btn': [{ 'title': 'Cerrar', 'id': 'btn-live-form-close', 'data': { 'modal': idModal } }]
					});
				}
			});
		});

		$(document).on('click', '#btn-live-guardar-fotos-estado', function(e){
			e.preventDefault();
			var control = $(this);

			var frmId = control.data('frm');
			var message = '¿Desea guardar los cambios de las fotos?';

			liveStorecheck.oConfirm = {
					'frm': frmId,
					'fn': 'liveStorecheck.guardarFotosEstado()',
					'message': Fn.message({ 'type': 2, 'message': message })
				};

			liveStorecheck.confirmar();
		});

		// $('.btn-live-consultar').click();
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
	auditar: function(){
		// Fn.showModal({ id: liveStorecheck['idModal'], show: false });

		var idModal = ++modalId;
		var data = { 'data': JSON.stringify($.extend({}, { 'idModal': idModal }, liveStorecheck['oConfirm']['data'])) };
		var url = 'liveStorecheck/formulario';

		$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
			if( a['result'] == 0 ){
				Fn.showModal({
					'id': idModal,
					'show': true,
					'title': 'Auditoria',
					'frm': a['msg']['content'],
					'btn': [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }]
				});
			}
			if( a['result'] == 1 ){
				Fn.showModal({
					'id': idModal,
					'show': true,
					'width': '95%',
					'title': 'Auditoria',
					'frm': a['data']['view'],
					'btn': [
							{ 'title': '<i class="fa fa-save"></i> Guardar', 'id': 'btn-live-guardar', 'data': { 'frm': a['data']['frm'] }  },
							{ 'title': 'Cerrar', 'id': 'btn-live-form-close', 'data': { 'modal': idModal } }
						]
				});

				liveStorecheck['idModal'] = idModal;
			}
		});
	},
	guardar: function(){
		var data = { 'data': JSON.stringify(liveStorecheckForm.data()) };
		var url = 'liveStorecheck/guardar';
		$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
			if( a['result'] != 2 ){
				if( a['result'] == 1 ){
					// Fn.showModal({ 'id': liveStorecheck['idModal'], 'show': false });
					$('#btn-live-form-close').click();
				}

				var idModal = ++modalId;
				var message = Fn.message({ 'type': a['result'], 'message': a['msg']['content'] });

				Fn.showModal({
					'id': idModal,
					'show': true,
					'title': a['msg']['title'],
					'frm': message,
					'btn': [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }]
				});
			}
		});
	},
	guardarFotosEstado: function(){
		var frm = liveStorecheck['oConfirm']['frm'];

		var data = { 'data': JSON.stringify(Fn.formSerializeObject(frm)) };
		var url = 'liveStorecheck/guardarFotosEstado';
		$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
			if( a['result'] != 2 ){
				if( a['result'] == 1 ){
					Fn.showModal({ 'id': liveStorecheck['idModal'], 'show': false });
				}

				var idModal = ++modalId;
				var message = Fn.message({ 'type': a['result'], 'message': a['msg']['content'] });

				Fn.showModal({
					'id': idModal,
					'show': true,
					'title': a['msg']['title'],
					'frm': message,
					'btn': [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }]
				});
			}
		});
	},
}
liveStorecheck.load();