var liveStorecheckOrden = {
	oConfirm: {},
	load: function(){
		$(document).off('click', '#btn-lsck-orden-guardar').on('click', '#btn-lsck-orden-guardar', function(e){
			e.preventDefault();
			var control = $(this);

			var estado = $('#frm-lsck-orden input[name=estado]:checked').val();
			if( estado == undefined || estado.length == 0 ){
				var idModal = ++modalId;
				var btn = [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }];

				Fn.showModal({
						'id': idModal,
						'show': true,
						'title': 'Alerta',
						'frm': Fn.message({ 'type': 2, 'message': 'Debe seleccionar una respuesta para la orden de trabajo' }),
						'btn': btn
					});

				return false;
			}

			liveStorecheckOrden.oConfirm = {
					'frm': 'frm-lsck-orden',
					'fn': 'liveStorecheckOrden.guardar()',
					'message': Fn.message({ 'type': 3, 'message': '¿Desea guardar los datos para la orden de trabajo?' }),
				};

			liveStorecheckOrden.confirmar();
		});

		$(document).on('click', '#btn-confirm-ok', function(e){
			e.preventDefault;

			if( $.type(liveStorecheckOrden['oConfirm']) != 'undefined' &&
				$.type(liveStorecheckOrden['oConfirm']['fn']) != 'undefined'
			){
				eval(liveStorecheckOrden['oConfirm']['fn']);
			}
		});

	},
	confirmar: function(){
		var defaults = { 'frm' : '', 'fn': '', 'idModal': '', 'title': 'Confirmar', 'message': Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' }), 'data': {}, 'modalClass': '' };
		var config = $.extend({}, defaults, liveStorecheckOrden.oConfirm);

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
					{ 'title': 'Continuar', 'id': 'btn-confirm-ok', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' },
					{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }
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
		var frm = liveStorecheckOrden['oConfirm']['frm'];

		var data = { 'data': JSON.stringify(Fn.formSerializeObject(frm)) };
		var url = 'liveStorecheckOrden/guardar';
		$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
			if( a['result'] == 2 ) return false;

			if( a['result'] == 1 ){
				$('#content-lsck-orden').html(a['msg']['content']);
			}
			else{
				var idModal = ++modalId;
				Fn.showModal({
					'id': idModal,
					'show': true,
					'title': 'Alerta',
					'frm': a['msg']['content'],
					'btn': [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }]
				});
			}
		});
	},
};
liveStorecheckOrden.load();