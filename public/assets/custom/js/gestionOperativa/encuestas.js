var Encuestas = {
	idFormFiltros: 'formFiltrosEncuesta',
	url: 'gestionOperativa/encuestas/',
	idDivContent: 'encuestaContent',
	tabSeleccionado: 1,
	estadoConsulta: 0,

	load: function () {
		$(document).ready(function (e) {
			$('.flt_grupoCanal').change();
		});

		$(document).on('click', '#btn-filtrarEncuesta', function (e) {
			e.preventDefault();

			let navActivo = $('.btnReporte').find('.active');

			let content = navActivo.data('content');
			let tabla = navActivo.data('tabla');
			let url = navActivo.data('url');

			var data = Fn.formSerializeObject(Encuestas.idFormFiltros);
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Encuestas.url + url, 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {
				$('#' + content).html(a.data.html);
				$('#' + tabla).DataTable(a.data.configTable);
				Fn.showLoading(false);
			});
		});

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
			$('#btn-filtrarEncuesta').click();
		});

		$(document).ready(function () {
			$('#btn-filtrarEncuesta').click();
			$(".flt_grupoCanal").change();
		});

		$(document).on('click', '.btn-fotosEncuesta', function (e) {
			e.preventDefault();

			let idVisita = $(this).data('idvisita');
			var data = { 'idVisita': idVisita };
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Encuestas.url + 'getFotosPorEncuesta', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {
				++modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };
				Fn.showModal({ id: modalId, show: true, title: a.msg.title, frm: a.data.html, btn: btn });
			});
		});

		$(document).on('click', '#chkb-habilitarTodos', function () {
			var input = $(this);

			if (input.is(':checked')) {
				$('#tablaDetalladoEncuesta').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.check').prop('checked', true);
					$(data).find('.inputCantidad').removeClass('disabled');
					$(data).find('.divFotos').removeClass('disabled');
				});
			} else {
				$('#tablaDetalladoEncuesta').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.check').prop('checked', false);
					$(data).find('.inputCantidad').addClass('disabled');
					$(data).find('.divFotos').addClass('disabled');
				});
			}

		});

		$(document).on('click', '.check_row', function () {
			var input = $(this);

			let id = input.data('id');

			if (input.is(':checked')) {
				$('#tablaDetalladoEncuesta').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.check_' + id).prop('checked', true);
				});
			} else {
				$('#tablaDetalladoEncuesta').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.check_' + id).prop('checked', false);
				});
			}
		});

		$(document).on('click', '.seleccionarTienda', function () {
			var input = $(this);

			let isChecked = input.is(":checked");

			if (isChecked) {
				input.parents('tr').find('.inputCantidad').removeClass('disabled');
				input.parents('tr').find('.divFotos').removeClass('disabled');
			} else {
				input.parents('tr').find('.inputCantidad').addClass('disabled');
				input.parents('tr').find('.divFotos').addClass('disabled');
			}

		});

		$(document).on('click', '#btn-encuesta-pdf', function () {
			var dataClientes = [];
			var arrayClientes = [];
			var cont = 0;
			var nombreEncuesta = $('#idEncuesta option:selected').text();

			$('input.seleccionarTienda').each(function (ev) {
				var visitaCheckbox = $(this);

				if (visitaCheckbox.is(':checked')) {
					cont++;
					var idVisitaEncuesta = visitaCheckbox.data('idvisitaencuesta');
					var idVisitaEncuesta = visitaCheckbox.data('idvisitaencuesta');
					var nombreCliente = visitaCheckbox.data('nombrecliente');
					var cantidadFotos = visitaCheckbox.parents('tr').find('.inputCantidad').val();

					var dataFotos = [];
					var arrayFotos = [];
					var contFotos = 0;

					$('input.check_' + idVisitaEncuesta).each(function (evf) {
						var chkbfoto = $(this);
						if (chkbfoto.is(':checked')) {
							contFotos++;
							var nombreFoto = chkbfoto.data('nombrefoto');

							//INSERTAMOS ARRAY FOTO
							arrayFotos.push(nombreFoto);
							if (cantidadFotos == contFotos) {
								dataFotos.push(arrayFotos);
								arrayFotos = [];
								contFotos = 0;
							}
						}
					});

					dataFotos.push(arrayFotos);

					//INSERTAMOS ARRAY
					arrayClientes = { 'nombreEncuesta': nombreEncuesta, 'idVisitaEncuesta': idVisitaEncuesta, 'nombreCliente': nombreCliente, 'cantidadFotos': cantidadFotos, 'contFotos': contFotos, 'dataFotos': dataFotos };
					dataClientes.push(arrayClientes);
				}
			});

			if (cont == 0) {
				++modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
				var btn = [];
				btn[0] = { title: 'Aceptar', fn: fn };
				Fn.showModal({ id: modalId, show: true, title: 'ALERTA', content: 'No se ha registrado ningún cambio', btn: btn });
			} else {
				var data = JSON.stringify(dataClientes);
				var jsonString = { 'data': data };
				var url = site_url + Encuestas.url + 'generar_pdf';
				Fn.download(url, jsonString);
			}

		});

		$(document).on('keyup', '.inputCantidad', function () {
			var input = $(this);
			let val = input.val();

			if(val == ''){
				input.val('0');
			}
		});

	},
}
Encuestas.load();