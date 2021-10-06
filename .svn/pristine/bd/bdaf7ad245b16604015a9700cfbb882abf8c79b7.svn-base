var liveStorecheckEnc = {
	oConfirm: {},
	idModal: 0,
	load: function(){

		$(document).on('click', '.btn-live-encuesta-consultar', function(e){
			e.preventDefault();

			var url = 'configuraciones/gestion/liveStorecheckEnc/consultar';
			$.when(Fn.ajax({ 'url': url })).then(function(a){
				if( a['result'] != 2 ){
					Fn.replaceContent('content-live-list-encuestas', a['data']['html']);
				}
			});
		});

		$(document).on('click', '.btn-live-encuesta-estado', function(e){
			e.preventDefault();
			var control = $(this);
			var estado = control.data('estado');

			var rowSelected = Fn.rowSelected('tb-live-list-encuesta', 'id');
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

			var data = { 'data': JSON.stringify({ 'idEncuesta': rowSelected, 'estado': estado }) };
			var url = 'configuraciones/gestion/liveStorecheckEnc/estado';

			$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
				if( a['result'] != 2 ){
					if( a['result'] == 1 ){
						$('.btn-live-encuesta-consultar').click();
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

		$(document).on('click', '.btn-live-encuesta-nuevo', function(e){
			e.preventDefault();
			var url = 'configuraciones/gestion/liveStorecheckEnc/nuevo'
			$.when(Fn.ajax({ 'url': url })).then(function(a){
				if( a['result'] != 2 ){
					var idModal = ++modalId;
					Fn.showModal({
						'id': idModal,
						'show': true,
						'large': true,
						'title': 'Nuevo Formato',
						'frm': a['data']['view'],
						'btn': [
								{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' },
								{ 'title': '<i class="fa fa-save"></i> Guardar', 'id': 'btn-live-encuesta-guardar', 'class': 'btn-success', 'data': { 'frm': a['data']['frm'] } }
							]
					});

					liveStorecheckEnc.idModal = idModal;
				}
			});
		});

		$(document).on('click', '.btn-live-encuesta-ver', function(e){
			e.preventDefault();
			var control = $(this);

			var data = { 'data': JSON.stringify(control.data()) };
			var url = 'configuraciones/gestion/liveStorecheckEnc/ver';

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

		$(document).on('click', '#btn-live-encuesta-guardar', function(e){
			e.preventDefault();
			var control = $(this);
			var frm = control.data('frm');

			var message = '¿Desea guardar el nuevo formato? ';
			liveStorecheckEnc.oConfirm = {
					'frm': frm,
					'fn': 'liveStorecheckEnc.guardar()',
					'message': Fn.message({ 'type': 2, 'message': message })
				};

			liveStorecheckEnc.confirmar();

		});

		$(document).on('click', '#btn-confirm-ok', function(e){
			e.preventDefault;

			if( $.type(liveStorecheckEnc['oConfirm']) != 'undefined' &&
				$.type(liveStorecheckEnc['oConfirm']['fn']) != 'undefined'
			){
				eval(liveStorecheckEnc['oConfirm']['fn']);
			}
		});


		$('.btn-live-encuesta-consultar').click();
	},
	confirmar: function(){
		var defaults = { 'frm' : '', 'fn': '', 'idModal': '', 'title': 'Confirmar', 'message': Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' }), 'data': {} };
		var config = $.extend({}, defaults, liveStorecheckEnc.oConfirm);

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
		var frm = liveStorecheckEnc['oConfirm']['frm'];

		var data = { 'data': JSON.stringify(Fn.formSerializeObject(frm)) };
		var url = 'configuraciones/gestion/liveStorecheckEnc/guardar';
		$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
			if( a['result'] != 2 ){
				if( a['result'] == 1 ){
					Fn.showModal({ 'id': liveStorecheckEnc['idModal'], 'show': false });
					$('.btn-live-encuesta-consultar').click();
				}

				var idModal = ++modalId;
				Fn.showModal({
					'id': idModal,
					'show': true,
					'title': 'Nuevo Formato',
					'frm': a['msg']['content'],
					'btn': [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }]
				});
			}
		});
	},
}
liveStorecheckEnc.load();