var liveStorecheck = {
	data: {},
	content: 'content-live-auditorias',
	idModal: 0,
	oConfirm: {},
	load: function(){
		
		$(document).on('click', '#btn-lsck-consultar', function(e){
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

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
            $('#btn-lsck-consultar').click();
        });

		$(document).on('click', '#btn-lsck-plaza', function(e){
			e.preventDefault();
			var control = $(this);
			var idModal = ++modalId;

			var data = { 'data': JSON.stringify({ 'idModal': idModal }) };
			var url = 'liveStorecheck/plazas';

			$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
				if( a['result'] != 2 ){
					Fn.showModal({
						id: idModal,
						show: true,
						width: '70%',
						title: 'Plazas',
						frm: a['data']['view'],
						btn: [
								{ title: 'Cerrar', fn: 'Fn.showModal({ id: ' + idModal + ', show: false });' },
								{ title: '<i class="fas fa-flag-checkered"></i> Iniciar', id: 'btn-lsck-auditar', class: 'btn-primary' }
							]
					});
				}
			});

			liveStorecheck['idModal'] = idModal;
		});

		$(document).on('click', '#btn-lsck-auditar', function(e){
			e.preventDefault();
			var control = $(this);

			if( $('#tb-lsck-plaza').DataTable().rows('.selected').count() == 0 ){
				var message = Fn.message({ 'type': 2, 'message': 'Debe seleccionar una plaza para iniciar auditoria' });
				Fn.showModal({
					'id': ++modalId,
					'show': true,
					'title': 'Alerta',
					'frm': message,
					'btn': [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + modalId + ', show: false });' }]
				});
				return false;
			}

			var tr = $('#tb-lsck-plaza').DataTable().rows('.selected').nodes()[0];
			var idPlaza = $(tr).data('id');
			var idModal = ++modalId;

			var content = Fn.message({ 'type': 3, 'message': '¿Seguro que desea iniciar la auditoria?' });
			var btn = [
					{ title: 'Cerrar', fn: 'Fn.showModal({ id: ' + idModal + ', show: false });' },
					{ title: 'Continuar', fn: 'Fn.showModal({ id: ' + idModal + ', show: false }); liveStorecheck.auditar(' + idPlaza + ');' }
				];

			Fn.showModal({
				id: idModal,
				show: true,
				title: 'Iniciar',
				frm: content,
				btn: btn
			});
		});

		$(document).on('click', '#btn-lsck-frm-close', function(e){
			e.preventDefault();
			var control = $(this);
			var idModal = control.data('modal');

			$('body').find('.modal-lsck-form').remove();
			Fn.showModal({ 'id': idModal, 'show': false });
		});

		$(document).on('click', '#btn-lsck-frm-guardar', function(e){
			e.preventDefault();
			var control = $(this);

			if( !liveStorecheck.verificar() )
				return false;

			var frmId = control.data('frm');
			var frmData = liveStorecheckForm.data(true);

			var data = { 'data': JSON.stringify(frmData) };
			var url = 'liveStorecheck/calcular';

			$.when( Fn.ajax({ 'url': url, 'data': data, 'loading': 'Calculando Resultado' }) ).then(function(a){
				if( a['result'] == 2 ) return false;

				var message = '';
				if( a['result'] == 0 ){
					message = Fn.message({ type: 2, message: a['msg']['content'] });
					Fn.showModal({
							id: ++modalId,
							show: true,
							title: a['msg']['title'],
							frm: message,
							btn: [{ title: 'Cerrar', fn: 'Fn.showModal({ id: ' + modalId + ', show: false });' }]
						});
				}
				else{
					message = '¿Desea guardar los datos de la auditoria? ';
						message += a.data.view;

					liveStorecheck.idModal = ++modalId;
					Fn.showModal({
						id: modalId,
						show: true,
						title: 'Guardar Auditoria',
						frm: Fn.message({ 'type': 3, 'message': message }),
						btn: [
								{ title: 'Cerrar', fn: 'Fn.showModal({ id: ' + modalId + ', show: false });' },
								{ title: 'Guardar', fn: 'liveStorecheck.guardar(' + a.data.idCalculo + ');' }
							]
					});
				}
			});
		});

		$(document).on('click', '#btn-lsck-historico-plaza', function(e){
			e.preventDefault();

			var rowSelected = Fn.rowSelected('tb-lsck-plazas-auditadas');
			var rowSelectedCount = rowSelected.length;

			if( rowSelectedCount == 0 || rowSelectedCount > 1 ){
				var idModal = ++modalId;
				var btn = [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }];
				var message = '';
					if( rowSelectedCount == 0 ) message = 'No se ha seleccionado ningún registro';
					else message = 'Debe seleccionar solo una plaza';
					message = Fn.message({ type: 2, message: message });

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
			var url = 'liveStorecheck/historicoPlaza';

			$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
				if( a['result'] != 2 ){
					var idModal = ++modalId;
					var btn = [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }];

					Fn.showModal({
							'id': idModal,
							'width': '80%',
							'show': true,
							'title': 'Histórico',
							'frm': a['data']['view'],
							'btn': btn
						});

					liveStorecheck.idModal = idModal;
				}
			});
		});

		$(document).on('click', '.btn-lsck-historico-plaza-pdf', function(e){
			var control = $(this);

			var data = { 'data': JSON.stringify({ 'idAudPlaza': control.data('id') }) };
			var url = site_url + 'liveStorecheck/historicoPDF';

			Fn.download(url,data);
		});

		$(document).on('click', '.btn-lsck-historico-plaza-foto', function(e){
			e.preventDefault();
			var control = $(this);
			var idAudPlaza = control.data('id');

			var data = { 'data': JSON.stringify({ idAudPlaza: idAudPlaza }) };
			var url = 'liveStorecheck/historicoFoto';

			$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
				var idModal = ++modalId;
				if( a['result'] == 1 ){
					Fn.showModal({
						'id': idModal,
						'show': true,
						'width': '80%',
						'title': 'Plaza Fotos',
						'frm': a['data']['view'],
						'btn': [
								{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' },
								{ 'title': '<i class="fa fa-save"></i> Guardar', 'id': 'btn-lsck-historico-fotos-estado-guardar', 'data': { 'frm': a['data']['frm'] }  }
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
						'btn': [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }]
					});
				}
			});
		});

		$(document).on('click', '#btn-lsck-auditar-plaza', function(e){
			var control = $(this);
			var idPlaza = control.data('idPlaza');
			var message = Fn.message({ 'type': 3, 'message': '¿Desea empezar auditoria a la plaza?' });

			liveStorecheck.oConfirm = {
					'fn': 'liveStorecheck.auditar(' + idPlaza +');',
					'message': message,
					'data': control.data()
				};

			liveStorecheck.confirmar();
		});

		$(document).on('click', '.btn-lsck-historico-tienda', function(e){
			var control = $(this);
			var idAudPlaza = control.data('id');
			var idModal = ++modalId;

			var data = { 'data': JSON.stringify({ idModal: idModal, idAudPlaza: idAudPlaza }) };
			var url = 'liveStorecheck/historicoTienda';

			$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
				if( a['result'] != 2 ){
					Fn.showModal({
						id: idModal,
						show: true,
						width: '80%',
						title: 'Tiendas',
						frm: a['data']['view'],
						btn: [{ title: 'Cerrar', fn: 'Fn.showModal({ id: ' + idModal + ', show: false });' }]
					});
				}
			});
		});

		$(document).on('click', '.btn-lsck-historico-tienda-foto', function(e){
			e.preventDefault();
			var control = $(this);
			var idAudCliente = control.data('id');

			var data = { 'data': JSON.stringify({ idAudCliente: idAudCliente }) };
			var url = 'liveStorecheck/historicoFoto';

			$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
				var idModal = ++modalId;
				if( a['result'] == 1 ){
					Fn.showModal({
						'id': idModal,
						'show': true,
						'width': '80%',
						'title': 'Tienda Fotos',
						'frm': a['data']['view'],
						'btn': [
								{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' },
								{ 'title': '<i class="fa fa-save"></i> Guardar', 'id': 'btn-lsck-historico-tiendas-fotos-estado-guardar', 'data': { 'frm': a['data']['frm'] }  }
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
						'btn': [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }]
					});
				}
			});
		});

		$(document).on('click', '#btn-lsck-historico-fotos-estado-guardar', function(e){
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

		$(document).on('click', '.btn-lsck-historico-tienda-orden', function(e){
			e.preventDefault();
			var control = $(this);
			var idAudCliente = control.data('id');

			var data = { 'data': JSON.stringify({ idAudCliente: idAudCliente }) };
			var url = 'liveStorecheck/historicoOrden';

			$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
				if( a['result'] != 2 ){
					var idModal = ++modalId;
					Fn.showModal({
						'id': idModal,
						'show': true,
						'title': 'Auditoria - Ordenes',
						'frm': a['data']['view'],
						'width': '80%',
						'btn': [
								{ 'title': '<i class="far fa-bell"></i> Notificar', 'id': 'btn-lsck-historico-tienda-orden-notificar'  },
								{ 'title': 'Cerrar', 'id': 'btn-lsck-frm-close', 'data': { 'modal': idModal } }
							]
					});

					liveStorecheck['idModal'] = idModal;
				}
			});
		});

		$(document).on('click', '#btn-lsck-historico-tienda-orden-notificar', function(e){
			e.preventDefault();
			var control = $(this);
			var rowSelectedCount = $('.chk-lsck-orden-notificar:checked').length;

			if( rowSelectedCount == 0 ){
				var idModal = ++modalId;
				var btn = [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }];
				var message = Fn.message({ 'type': 2, 'message': 'No se ha seleccionado ningún registro' });

				Fn.showModal({
						'id': idModal,
						'show': true,
						'title': 'Alerta',
						'frm': message,
						'btn': btn
					});

				return false;
			}
			else{
				var message = '¿Desea notificar al(los) responsable(s) sobre la(s) orden(es)?';

				liveStorecheck.oConfirm = {
						'fn': 'liveStorecheck.notificarOrden()',
						'message': Fn.message({ 'type': 2, 'message': message })
					};

				liveStorecheck.confirmar();
			}
		});

		$(document).on('click', '#btn-confirm-ok', function(e){
			e.preventDefault;

			if( $.type(liveStorecheck['oConfirm']) != 'undefined' &&
				$.type(liveStorecheck['oConfirm']['fn']) != 'undefined'
			){
				eval(liveStorecheck['oConfirm']['fn']);
			}
		});

		$(document).ready(function () {
			$('#btn-lsck-consultar').click();
		});
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
	auditar: function( idPlaza = 0 ){
		var idModal = ++modalId;
		var data = { 'data': JSON.stringify({ idModal: idModal, idPlaza: idPlaza }) };
		var url = 'liveStorecheck/formulario';

		$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
			if( a['result'] == 2 ) return false;
			else if( a['result'] == 0 ){
				Fn.showModal({
					'id': idModal,
					'show': true,
					'title': 'Auditoria',
					'frm': Fn.message({ type: 2, message: a['msg']['content'] }),
					'btn': [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }]
				});

				return false;
			}


			Fn.showModal({
				'id': idModal,
				'show': true,
				'width': '95%',
				'title': 'Auditoria',
				'frm': a['data']['view'],
				'btn': [
						{ 'title': 'Cerrar', 'id': 'btn-lsck-frm-close', 'data': { 'modal': idModal } },
						{ 'title': '<i class="fa fa-save"></i> Guardar', 'id': 'btn-lsck-frm-guardar', 'data': { 'frm': a['data']['frm'] }  }
					]
			});

			liveStorecheck['idModal'] = idModal;
		});
	},
	verificar: function(){
		var result = true;

			var aRadio = [];
			var i, v = '';
			$.each($('.btn-lsck-calificar').find('input[type="radio"]'), function(i, v){
				if( $.inArray($(v).attr('name'), aRadio) == -1 )
					aRadio.push($(v).attr('name'));
			});

			var aAlerta = {};
			var i, v = '';
			$.each(aRadio, function(i, v){
				var input = $('input[name="' + v + '"]');
				if( !input.is(':checked') ){
					var pdv = input.parents('.modal-lsck-form:first').data('tienda');
					var eva = input.parents('.modal-lsck-form:first').find('.modal-header').data('evaluacion');
					var pre = input.parents('.lbl-lsck-pregunta:first').data('pregunta');

					if( !aAlerta[pdv] ) aAlerta[pdv] = {};
					if( !aAlerta[pdv][eva] ) aAlerta[pdv][eva] = [];

					aAlerta[pdv][eva].push(pre);
				}
			});

			var msgAlerta = '';
			var i, v = '';
			if( Fn.obj_count(aAlerta) ){
				msgAlerta += Fn.message({ type: 2, message: 'Debe indicar el resultado de las siguientes preguntas' });
				$.each(aAlerta, function(i, v){
					msgAlerta += '<ul>';
						msgAlerta += '<span class="font-weight-bold text-primary">' + i + '</span>';
						$.each(v, function(ii, vv){
							msgAlerta += '<li>' + ii;
								msgAlerta += '<ul>';
									$.each(vv, function(iii, vvv){
										msgAlerta += '<li>' + vvv + '</li>';
									});
								msgAlerta += '</ul>';
							msgAlerta += '</li>';
						});
					msgAlerta += '</ul>';
				});

				Fn.showModal({
					id: ++modalId,
					show: true,
					title: 'Alerta',
					frm: msgAlerta,
					btn: [{ title: 'Cerrar', fn: 'Fn.showModal({ id: ' + modalId + ', show: false });' }]
				});

				result = false;
			}

		return result;
	},
	guardar: function( idCalculo = 0 ){
		var data = { 'data': JSON.stringify($.extend(liveStorecheckForm.data(), { idCalculo: idCalculo })) };
		var url = 'liveStorecheck/guardar';
		$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
			if( a['result'] != 2 ){
				if( a['result'] == 1 ){
					Fn.showModal({ 'id': liveStorecheck['idModal'], 'show': false });
					$('#btn-lsck-frm-close').click();
					Fn.showModal({ id: liveStorecheck.idModal, show: false });
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
	notificarOrden: function(){
		var aNotificar = [];
		$.each($('.chk-lsck-orden-notificar:checked'), function(i, v){
			aNotificar.push($(v).val());
		});

		var data = { 'data': JSON.stringify({ 'idAudClienteEvalPreg': aNotificar }) };
		var url = 'liveStorecheck/historicoOrdenNotificar';
		$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
			if( a['result'] != 2 ){
				if( a['result'] == 1 ){
					Fn.showModal({ 'id': liveStorecheck['idModal'], 'show': false });
					// $('#btn-live-form-close').click();
				}

				var idModal = ++modalId;
				Fn.showModal({
					'id': idModal,
					'show': true,
					'title': a['msg']['title'],
					'frm': a['msg']['content'],
					'btn': [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }]
				});
			}
		});
	},
}
liveStorecheck.load();