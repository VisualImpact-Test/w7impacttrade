var Gestores = {

	moduloActivo: '',
	urlActivo: '',
	idContentActivo: '',

	menuActivo: '',
	idFormMenuActivo: '',
	idFormNewActivo: '',
	idFormUpdateActivo: '',
	getTablaActivo: '',
	getFormNewActivo: '',
	getFormUpdateActivo: '',
	funcionRegistrarActivo: '',
	funcionActualizarActivo: '',

	idModalPrincipal: '',

	load: function () {

		$(".btnConsultar").click(function (e) {
			e.preventDefault();
			var data = Functions.formSerializeObject(Gestores.idFormMenuActivo);
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Gestores.urlActivo + Gestores.getTablaActivo, 'data': jsonString };

			$.when(Functions.ajax(config)).then(function (a) {

				if (a.data.html == null) {
					return false;
				}

				$('#' + Gestores.idContentActivo).html(a.data.html);
				Gestores.showDataTable();
			});
		});

		$(document).on('click', '.btnCambiarEstado', function (e) {
			++modalId;

			var menuActivo = Gestores.menuActivo;

			var btn = [];
			var data = {
				tipo: $(this).attr("data-tipo")
				, ix: $(this).attr("data-ix")
				, menuActivo: menuActivo
			};
			var estado = ($(this).attr("data-tipo") == 0) ? 'Desactivar' : 'Activar';
			var fn0 = 'Functions.showModal({ id:' + modalId + ',show:false });';
			var fn1 = 'Gestores.cambiarEstado(' + JSON.stringify(data) + ');';
			btn[0] = { title: 'No', fn: fn0 };
			btn[1] = { title: 'Si', fn: fn1 };
			Functions.showModal({ id: modalId, show: true, title: 'Activar/Desactivar', content: '¿Desea <strong>' + estado + '</strong> el registro seleccionado?', btn: btn });
		});

		$(document).on('click', '.btnNew', function () {

			var config = { 'url': Gestores.urlActivo + Gestores.getFormNewActivo };

			$.when(Functions.ajax(config)).then(function (a) {

				if (a.msg == '') {
					return false;
				}

				++modalId;
				Gestores.idModalPrincipal = modalId;
				var fn = 'Functions.showConfirm({ fn:"Gestores.registrar()",content:"¿Esta seguro de realizar el registro?" });';
				var fn1 = 'Functions.showModal({ id:' + modalId + ',show:false });';

				var btn = new Array();
				btn[0] = { title: 'Registrar', fn: fn };
				btn[1] = { title: 'Cancelar', fn: fn1 };

				Functions.showModal({ id: modalId, show: true, title: a.msg.title, frm: a.data.html, btn: btn, width: a.data.width });
			});
		});

		$(document).on("click", ".btnEditar", function (e) {
			e.preventDefault();

			var data = { 'id': $(this).attr('data-id') };
			var jsonString = { 'data': JSON.stringify(data) };

			var config = { 'url': Gestores.urlActivo + Gestores.getFormUpdateActivo, 'data': jsonString };

			$.when(Functions.ajax(config)).then(function (a) {

				if (a.msg == '') {
					return false;
				}

				++modalId;
				Gestores.idModalPrincipal = modalId;
				var fn = 'Functions.showConfirm({ fn:"Gestores.actualizar()",content:"¿Esta seguro de actualizar los datos?" });';
				var fn1 = 'Functions.showModal({ id:' + modalId + ',show:false });';
				var btn = new Array();
				btn[0] = { title: 'Actualizar', fn: fn };
				btn[1] = { title: 'Cancelar', fn: fn1 };

				if(a.data.btn == false){
				var fn = 'Functions.showModal({ id:' + modalId + ',show:false });';
				var btn = new Array();
				btn[0] = { title: 'Cerrar', fn: fn };
				}
				
				Functions.showModal({ id: modalId, show: true, title: a.msg.title, frm: a.data.html, btn: btn, width: a.data.width });
			});
		});
	},

	showDataTable: function () {
		var $datatable = $('#data-table');
		$datatable.dataTable({
			'scrollX': true,
			'scrollY': 450,
			'scrollCollapse': true,
			'ordering': false,
			'lengthMenu': [[10, 25, 50, 100, 1000], ['10 Filas', '25 Filas', '50 Filas', '100 Filas', '1000 Filas']],
			'iDisplayLength': 10,
			'dom': 'Bfrtip',
			'buttons': ['csv', 'pageLength'],
			'language': { buttons: { 'csv': 'Excel', 'pageLength': { _: 'Mostrando %d Filas' } } }
		});
		$("#data-table_filter").find("input[type=search]").attr("placeholder", "Ingrese texto");
	},

	cambiarEstado: function (data) {
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { url: Gestores.urlActivo + 'cambiarEstado', data: jsonString };

		$.when(Functions.ajax(config)).then(function (b) {

			if (b.msg == '') {
				return false;
			}

			++modalId;
			if (b.result == 1) {
				
				var fn = 'Functions.showModal({ id:' + (modalId - 1) + ',show:false });Functions.showModal({ id:' + modalId + ',show:false });';
				$("#" + Gestores.idFormMenuActivo + " .btnConsultar").click();
			} else {
				var fn = 'Functions.showModal({ id:' + modalId + ',show:false });';
			}
			var btn = new Array();
			btn[0] = { title: 'Continuar', fn: fn };
			Functions.showModal({ id: modalId, show: true, title: b.msg.title, content: b.msg.content, btn: btn });
		});
	},

	registrar: function () {

		$.when(Functions.validateForm({ id: Gestores.idFormNewActivo })).then(function (a) {
			if (a === true) {
				var data = Functions.formSerializeObject(Gestores.idFormNewActivo);
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url': Gestores.urlActivo + Gestores.funcionRegistrarActivo, 'data': jsonString };

				$.when(Functions.ajax(config)).then(function (a) {
					if (a.msg == '') {
						return false;
					}

					++modalId;
					var fn = 'Functions.showModal({ id:' + modalId + ',show:false });';

					

					if (a.result == 1) fn += 'Functions.showModal({ id:' + Gestores.idModalPrincipal + ',show:false });$("#' + Gestores.idFormMenuActivo + ' .btnConsultar").click();';

					var btn = new Array();
					btn[0] = { title: 'Cerrar', fn: fn };
					Functions.showModal({ id: modalId, show: true, title: a.msg.title, btn: btn, content: a.msg.content });
				});
			}
		});

	},

	actualizar: function () {

		$.when(Functions.validateForm({ id: Gestores.idFormUpdateActivo })).then(function (a) {
			if (a === true) {
				var data = Functions.formSerializeObject(Gestores.idFormUpdateActivo);
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url': Gestores.urlActivo + Gestores.funcionActualizarActivo, 'data': jsonString };

				$.when(Functions.ajax(config)).then(function (a) {
					if (a.msg == '') {
						return false;
					}

					++modalId;
					var fn = 'Functions.showModal({ id:' + modalId + ',show:false });';

					if (a.result == 1) fn += 'Functions.showModal({ id:' + Gestores.idModalPrincipal + ',show:false });$("#' + Gestores.idFormMenuActivo + ' .btnConsultar").click();';

					var btn = new Array();
					btn[0] = { title: 'Cerrar', fn: fn };
					Functions.showModal({ id: modalId, show: true, title: a.msg.title, btn: btn, content: a.msg.content });
				});
			}
		});

	},
}
Gestores.load();