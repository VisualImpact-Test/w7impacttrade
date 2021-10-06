var Gestion = {

	moduloActivo: '',
	urlActivo: '',
	idContentActivo: '',

	seccionActivo: '',
	idFormSeccionActivo: '',

	getTablaActivo: '',
	getFormNewActivo: '',
	getFormUpdateActivo: '',
	getFormCargaMasivaActivo: '',

	funcionRegistrarActivo: '',
	funcionActualizarActivo: '',
	funcionGuardarCargaMasivaActivo: '',

	$dataTable: [],
	columnaOrdenDT: '',
	funcionCustomDT: '',

	idModalPrincipal: '',

	btnConsultar :'.btn-Consultar',

	load: function () {
		//Evento general de consultar
		$(".btn-Consultar").click(function (e) {
			e.preventDefault();
			var data = Fn.formSerializeObject(Gestion.idFormSeccionActivo);
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Gestion.urlActivo + Gestion.getTablaActivo, 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {
				if (a.result === 2) return false;
				if (typeof a.data.validaciones !== null) Gestion.mostrarValidaciones(a.data.form, a.data.validaciones);
				if (a.result === 0) return false;

				$('#' + Gestion.idContentActivo).html(a.data.html);

				Gestion.funcionCustomDT();
				//Reajuste de columnas para DataTable
				// $('.tablaGestion').css('width', '100%');

				//Numeración automatica para DataTable
				Gestion.$dataTable[Gestion.idContentActivo].on('order.dt search.dt', function () {
					Gestion.$dataTable[Gestion.idContentActivo].column(Gestion.columnaOrdenDT, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
						cell.innerHTML = i + 1;
					});
				});

				Gestion.$dataTable[Gestion.idContentActivo].draw();
			});
		});

		//Evento general para obtener formulario de nuevo registro.
		$(document).on("click", ".btn-New", function (e) {
			e.preventDefault();
			var data = {'seccionActivo':Gestion.seccionActivo };


			var dataExtra = $(this).data('extra');
			var serialize = Fn.formSerializeObject(Gestion.idFormSeccionActivo);
			
			serialize.seccionActivo = Gestion.seccionActivo;

			Object.assign(serialize, {"dataExtra" : dataExtra });
			var jsonString = { 'data': JSON.stringify(serialize) };
			var config = { 'url': Gestion.urlActivo + Gestion.getFormNewActivo, 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

				if (a.result === 2) return false;

				++modalId;
				Gestion.idModalPrincipal = modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
				var fn1 = 'Fn.showConfirm({ fn:"Gestion.registrar()",content:"¿Esta seguro de realizar el registro?" });';

				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };
				btn[1] = { title: 'Registrar', fn: fn1 };

				Fn.showModal({ id: modalId, show: true, class: 'modalNew', title: a.msg.title, frm: a.data.html, btn: btn, width: a.data.width });
			
			});
		});

		//Evento general para mostrar formulario de carga masiva.
		$(document).on("click", ".btn-CargaMasiva", function (e) {
			e.preventDefault();

			var config = { 'url': Gestion.urlActivo + Gestion.getFormCargaMasivaActivo };

			$.when(Fn.ajax(config)).then(function (a) {

				if (a.result === 2) return false;

				++modalId;
				Gestion.idModalPrincipal = modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
				var fn1 = 'Fn.showConfirm({ fn:"Gestion.guardarCargaMasiva()",content:"¿Esta seguro de realizar la Carga Masiva?" });';

				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };
				btn[1] = { title: 'Guardar', fn: fn1 };

				Fn.showModal({ id: modalId, show: true, class: 'modalCargaMasiva', title: a.msg.title, frm: a.data.html, btn: btn, width: a.data.width })
				HTCustom.llenarHTObjectsFeatures(a.data.ht);
			});
		});

		//Evento general para mostrar formulario de actualización.
		$(document).on("click", ".btn-Editar", function (e) {
			e.preventDefault();

			var data = { 'id': $(this).closest('tr').data('id') , 'seccionActivo':Gestion.seccionActivo };
			var serialize = Fn.formSerializeObject(Gestion.idFormSeccionActivo);
			Object.assign(data, serialize);

			var jsonString = { 'data': JSON.stringify(data) };

			var config = { 'url': Gestion.urlActivo + Gestion.getFormUpdateActivo, 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

				if (a.result === 2) return false;

				++modalId;
				Gestion.idModalPrincipal = modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
				var fn1 = 'Fn.showConfirm({ fn:"Gestion.actualizar()",content:"¿Esta seguro de actualizar los datos?" });';

				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };
				btn[1] = { title: 'Actualizar', fn: fn1 };
				Fn.showModal({ id: modalId, show: true, class: 'modalUpdate', title: a.msg.title, frm: a.data.html, btn: btn, width: a.data.width });
			});
		});

		//Evento general para mostrar popup de cambiar de estado.
		$(document).on('click', '.btn-CambiarEstado', function (e) {
			e.preventDefault();

			++modalId;
			Gestion.idModalPrincipal = modalId;

			var seccionActivo = Gestion.seccionActivo;
			var id = $(this).closest('tr').data('id');
			var estado = $(this).closest('tr').data('estado');

			var btn = [];
			var data = { ids: [id], seccionActivo: seccionActivo, estado: estado };
			var mensajeEstado = (estado == 0) ? 'Activar' : 'Desactivar';

			var fn0 = 'Fn.showModal({ id:' + modalId + ',show:false });';
			var fn1 = 'Gestion.cambiarEstado(' + JSON.stringify(data) + ');';
			btn[0] = { title: 'No', fn: fn0 };
			btn[1] = { title: 'Sí', fn: fn1 };

			Fn.showModal({ id: modalId, show: true, title: 'Activar/Desactivar', content: '¿Desea <strong>' + mensajeEstado + '</strong> el registro seleccionado?', btn: btn });
		});

		//Evento general para mostrar popup de cambio de estado múltiple.
		$(".btn-CambiarEstadoMultiple").click(function (e) {
			e.preventDefault();

			++modalId;
			Gestion.idModalPrincipal = modalId;

			var btn = [];
			var estado = $(this).data('estado');
			var mensaje = (estado == 0) ? 'activar' : 'desactivar';
			var titulo = (estado == 0) ? 'Activar' : 'Desactivar';
			var seccionActivo = Gestion.seccionActivo;
			var ids = [];

			if (typeof Gestion.$dataTable[Gestion.idContentActivo] !== 'undefined') {
				$.map(Gestion.$dataTable[Gestion.idContentActivo].rows('.selected').nodes(), function (item) {
					ids.push($(item).data("id"));
				});
			}

			if (ids.length === 0) {
				btn[0] = { title: 'Aceptar', fn: 'Fn.showModal({ id:"' + modalId + '",show:false });' };
				var content = "No ha seleccionado ningún registro.</strong>";
				Fn.showModal({ id: modalId, show: true, title: titulo, content: content, btn: btn });
				return false;
			}

			var data = { ids: ids, seccionActivo: seccionActivo, estado: estado };

			var fn0 = 'Fn.showModal({ id:' + modalId + ',show:false });';
			var fn1 = 'Gestion.cambiarEstado(' + JSON.stringify(data) + ');';
			btn[0] = { title: 'No', fn: fn0 };
			btn[1] = { title: 'Sí', fn: fn1 };

			Fn.showModal({ id: modalId, show: true, title: titulo, content: '¿Desea <strong>' + mensaje + '</strong> los registros seleccionados?', btn: btn });
		});

		//Evento de renderizado de cada tab con un HandsonTable.
		$(document).on('shown.bs.tab', 'a[data-toggle="tab"][class*="tabCargaMasiva"]', function (e) {
			HTCustom.HTHojaActiva = $(this).data('nrohoja')
			HTCustom.HTObjects[HTCustom.HTHojaActiva].render();
		})

		//Evento cuando modal de Carga Masiva se termina de mostrar completamente (usado para renderizado de handsontable.)
		$(document).on('shown.bs.modal', '.modalCargaMasiva', function () {
			HTCustom.crearHTObjects(HTCustom.HTObjectsFeatures);
		});

		//Evento para borrar mensaje de validacion cuando se cambie el valor en un campo
		$(document).on("change paste keyup", ".is-valid, .is-invalid", function () {
			var tipoDeInput = $(this).attr('type');
			var idForm = $(this).closest("form").attr('id');
			var idElemento = $(this).attr('name');
			var contenedorElementoValidacion = $('#' + idForm + ' #' + idElemento).parent();

			switch (tipoDeInput) {
				case 'checkbox':
					$('#' + idForm + ' [name="' + idElemento + '"]').removeClass('is-valid');
					$('#' + idForm + ' [name="' + idElemento + '"]').removeClass('is-invalid');
					break;
				case 'radio':
					$('#' + idForm + ' [name="' + idElemento + '"]').removeClass('is-valid');
					$('#' + idForm + ' [name="' + idElemento + '"]').removeClass('is-invalid');
					break;
				default:
					$(this).removeClass('is-valid');
					$(this).removeClass('is-invalid');
					break;
			}

			$('.invalid-feedback', contenedorElementoValidacion).remove();
		});

		// Cargando load de variable HTCustom
		HTCustom.load();
	},

	cambiarEstado: function (data) {
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { url: Gestion.urlActivo + 'cambiarEstado', data: jsonString };

		$.when(Fn.ajax(config)).then(function (a) {

			if (a.result === 2) return false;

			++modalId;
			var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
			
			if (a.result == 1) fn += 'Fn.showModal({ id:' + Gestion.idModalPrincipal + ',show:false });$("'+Gestion.btnConsultar+'").click();';

			var btn = [];
			btn[0] = { title: 'Cerrar', fn: fn };
			Fn.showModal({ id: modalId, show: true, title: a.msg.title, btn: btn, content: a.msg.content });
		});
	},

	registrar: function () {
		var data = Fn.formSerializeObject('formNew');
		data.seccionActivo = Gestion.seccionActivo; 

		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': Gestion.urlActivo + Gestion.funcionRegistrarActivo, 'data': jsonString };

		$.when(Fn.ajax(config)).then(function (a) {

			if (a.result === 2) return false;
			if (typeof a.data.validaciones !== null) Gestion.mostrarValidaciones('formNew', a.data.validaciones);
			if (typeof a.data.validacionesMulti !== null) Gestion.mostrarValidaciones('formNew', a.data.validacionesMulti);

			++modalId;
			var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

			if (a.result == 1) fn += 'Fn.showModal({ id:' + Gestion.idModalPrincipal + ',show:false });$(".btn-Consultar").click();';

			var btn = [];
			btn[0] = { title: 'Cerrar', fn: fn };
			Fn.showModal({ id: modalId, show: true, title: a.msg.title, btn: btn, content: a.msg.content });
		});
	},

	actualizar: function () {
		var data = Fn.formSerializeObject('formUpdate');
		data.seccionActivo = Gestion.seccionActivo; 
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': Gestion.urlActivo + Gestion.funcionActualizarActivo, 'data': jsonString };

		$.when(Fn.ajax(config)).then(function (a) {

			if (a.result === 2) return false;
			if (typeof a.data.validaciones !== null) Gestion.mostrarValidaciones('formUpdate', a.data.validaciones);
			if (typeof a.data.validacionesMulti !== null) Gestion.mostrarValidaciones('formUpdate', a.data.validacionesMulti);

			++modalId;
			var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

			if (a.result == 1) fn += 'Fn.showModal({ id:' + Gestion.idModalPrincipal + ',show:false });$(".btn-Consultar").click();';

			var btn = [];
			btn[0] = { title: 'Cerrar', fn: fn };
			Fn.showModal({ id: modalId, show: true, title: a.msg.title, btn: btn, content: a.msg.content });
		});
	},

	guardarCargaMasiva: function () {
		var data = Fn.formSerializeObject('formCargaMasiva');
		var HT = [];
		$.each(HTCustom.HTObjects, function (i, v) {
			if (typeof v !== 'undefined') HT.push(v.getSourceData());
		});
		data['HT'] = HT;

		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': Gestion.urlActivo + Gestion.funcionGuardarCargaMasivaActivo, 'data': jsonString };

		$.when(Fn.ajax(config)).then(function (a) {

			if (a.result === 2) return false;

			++modalId;
			var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

			if (a.result == 1) fn += 'Fn.showModal({ id:' + Gestion.idModalPrincipal + ',show:false });$(".btn-Consultar").click();';

			var btn = [];
			btn[0] = { title: 'Cerrar', fn: fn };
			Fn.showModal({ id: modalId, show: true, title: a.msg.title, btn: btn, content: a.msg.content });
		});

		// 	} else {
		// 		++modalId;
		// 		var btn = [];

		// 		btn[0] = { title: 'Aceptar', fn: 'Fn.showModal({ id:"' + modalId + '",show:false });' };

		// 		var content = "<strong>Se encontraron datos inválidos en las siguientes pestañas:</strong>";
		// 		content += "<ul>";
		// 		HTCustom.HTHojasInvalidas.forEach(function (value, index) {
		// 			content += "<li>" + value + "</li>";
		// 		})
		// 		content += "</ul>";

		// 		Fn.showModal({ id: modalId, show: true, title: 'Alerta', content: content, btn: btn });
		// 	}
		// });
	},

	mostrarValidaciones: function (formulario, validaciones) {
		var campo;
		$.each(validaciones, function (idInput, mensajesDeValidacion) {
			campo = $('#' + formulario + ' [name="' + idInput + '"]');
			contenedorElementoValidacion = $('#' + formulario + ' #' + idInput).parent();

			campo.removeClass('is-valid');
			campo.removeClass('is-invalid');
			$('.invalid-feedback', contenedorElementoValidacion).remove();

			if (mensajesDeValidacion.length !== 0) {
				campo.addClass('is-invalid');
				var invalidFeedback;
				$.each(mensajesDeValidacion, function (indiceMensaje, mensaje) {
					invalidFeedback = '<div class="invalid-feedback d-block">' + mensaje + '</div>';
					contenedorElementoValidacion.append(invalidFeedback);
				});
			} else {
				campo.addClass('is-valid');
			}
		});
	},

	defaultDT: function () {
		Gestion.$dataTable[Gestion.idContentActivo] = $('#' + Gestion.idContentActivo + ' table').DataTable({
			columnDefs: [
				{ targets: 0, orderable: false, className: 'select-checkbox tex-center' },
				{ targets: [1, 2], searchable: false, orderable: false, className: 'text-center' },
				{ targets: [-1, -2, -3], className: 'text-center' },
				{ targets: 'colNumerica', className: 'text-center' },
			],
			select: { style: 'multi', selector: 'td:first-child' },
			order: [[3, 'asc']],
			buttons: ['pageLength', 'selectAll',
				'selectNone'],
		});
		Gestion.columnaOrdenDT = 1;
	}

}
Gestion.load();