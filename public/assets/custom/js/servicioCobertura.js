var ServicioCobertura = {

	frmServicioCobertura: 'frm-servicioCobertura',
	contentDetalle: 'idDivResumen',
	idTableDetalle: 'tb-servicioCoberturaDetalle',
	url: 'servicioCobertura/',
	tabSeleccionado: 1,
	estadoConsulta: 0,

	load: function () {

		$(document).ready(function () {
			$('#btn-actualizarData').click();

			let botones_filtro = $('.txt_filtro').length;
			if (botones_filtro > 3) {
				$('.txt_filtro').hide(500);
			} else {
				$('.txt_filtro').show(500);
			}
		});

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
			$('#btn-filtrarServicioCobertura').click();
		});

		$(document).on('click', '#btn-filtrarServicioCobertura', function (e) {
			e.preventDefault();

			var control = $(this);
			var config = {
				'idFrm': ServicioCobertura.frmServicioCobertura
				, 'url': ServicioCobertura.url + control.data('url')
				, 'contentDetalle': ServicioCobertura.contentDetalle
			};

			$.when(Fn.loadReporte_new(config)).then(() => {
				// if (ServicioCobertura.tabSeleccionado == 3) {
				// 	ServicioCobertura.estadoConsulta = 1;
				// 	$(".div-para-ocultar").removeClass('card');
				// }
			});
		});

		$('.btnReporte').on('click', function (e) {
			e.preventDefault();
			var opcion = $(this).attr("data-value");
			ServicioCobertura.tabSeleccionado = opcion;
			$("#tipoFormato").val(opcion);
			$(".div-para-ocultar").addClass('card');
			$("#txt-fechas").removeClass('d-none');
			if (opcion == 1) {
				$('#dv-leyenda').show(500);
				if ($(".detalle-primera").length > 0) {
					$('#btn-filtrarServicioCobertura').click();
				}
			} else if (opcion == 2) {
				$('#dv-leyenda').hide(500);
				if ($(".resumen-primera").length > 0) {
					$('#btn-filtrarServicioCobertura').click();
				}

			} else if (opcion == 3) {
				$('#dv-leyenda').hide(500);
				if ($(".grafica-primera").length > 0) {
					$('#btn-filtrarServicioCobertura').click();
				}
				if (ServicioCobertura.estadoConsulta == 1) {
					$(".div-para-ocultar").removeClass('card');
				}
			} else if (opcion == 4) {
				$("#txt-fechas_simple").removeClass('d-none');
				$("#txt-fechas").addClass('d-none');
			}
		});

		$('#ckb-todos').on('click', function (e) {
			var checked = $(this).prop('checked');
			if (checked == false) {
				$('.filtroCondicion').each(function (ev) {
					var control = $(this);
					var opcion = control.val();

					control.prop("checked", false);
					// if ( $('#'+ServicioCobertura.idTableDetalle).length > 0) {
					// 	$('#tb-servicioCoberturaDetalle').DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
					// 		var data = this.node();
					// 		$(data).find('.'+opcion).parent('tr').hide();
					// 	});

					// 	var page = Math.floor((Math.random() * 10) + 1);
					// 	$('#tb-servicioCoberturaDetalle').DataTable().page.len(page).draw();
					// 	$('#tb-servicioCoberturaDetalle').DataTable().page.len(20).draw();
					// }
				});
			} else {
				$('.filtroCondicion').each(function (ev) {
					var control = $(this);
					var opcion = control.val();

					control.prop("checked", true);
					// if ( $('#'+ServicioCobertura.idTableDetalle).length > 0) {
					// 	$('#tb-servicioCoberturaDetalle').DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
					// 		var data = this.node();
					// 		$(data).find('.'+opcion).parent('tr').show();
					// 	});

					// 	var page = Math.floor((Math.random() * 10) + 1);
					// 	$('#tb-servicioCoberturaDetalle').DataTable().page.len(page).draw();
					// 	$('#tb-servicioCoberturaDetalle').DataTable().page.len(20).draw();
					// }
				});


			}
			ServicioCobertura.filtrar_leyenda();
		});

		$('.filtroCondicion').on('click', function (e) {
			ServicioCobertura.filtrar_leyenda();
		});
		$('#btn-actualizarData').on('click', function (e) {

			$.when(ServicioCobertura.actualizar_data()).then(() => {
				$('#btn-filtrarServicioCobertura').click();
			});
			
		});

		$(document).on("click", ".mostrarDetalle", function (e) {
			e.preventDefault();
			let control = $(this);
			let detalleClass = control.data('detalle');
			let vistaDeDetalle = control.val();

			if (vistaDeDetalle == 0) {
				$('.' + detalleClass).removeClass('d-none');
				control.val('1');
				control.removeClass('fa-plus-circle');
				control.addClass('fa-minus-circle');
			} else {
				$('.' + detalleClass).addClass('d-none');
				control.val('0');
				control.addClass('fa-plus-circle');
				control.removeClass('fa-minu-circle');
			}
		});


		$(document).on("click", ".mostrarDetalleH", function (e) {
			e.preventDefault();
			let control = $(this);
			let detalleClass = control.data('detalle');
			let vistaDeDetalle = control.val();

			if (vistaDeDetalle == 0) {
				$('.' + detalleClass).removeClass('d-none');
				control.val('1');
				control.removeClass('fa-plus-circle');
				control.addClass('fa-minus-circle');
			} else {
				$('.' + detalleClass).addClass('d-none');
				control.val('0');
				control.addClass('fa-plus-circle');
				control.removeClass('fa-minu-circle');
			}
		});

		$(document).on("click", ".lk-row-1", function (e) {
			var indicador = $(this).attr("data-indicador");
			var show = $(this).attr("data-show");
			if (show == "false") {
				$(this).html('<i class="fa fa-minus-circle" ></i>');
				$(this).attr("data-show", "true");

				$(".row-2-" + indicador).removeClass("hide");
			} else {
				$(this).html('<i class="fa fa-plus-circle" ></i>');
				$(this).attr("data-show", "false");
				//
				$(".lk-row21-" + indicador).attr("data-show", "false");
				$(".lk-row21-" + indicador).html('<i class="fa fa-plus-circle" ></i>');

				//
				$(".row-2-" + indicador).addClass("hide");
				$(".row-21-" + indicador).addClass("hide");
			}
		});

		$(document).on("click", ".lk-show-gps1", function () {
			var control = $(this);
			let latitud_cliente = control.data("latitudCliente");
			let longitud_cliente = control.data("longitudCliente");

			var data = { type: control.data('type'), latitud: control.data('latitud'), longitud: control.data('longitud'),latitud_cliente,longitud_cliente };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': ServicioCobertura.url + 'mostrarMapa', 'data': jsonString };

			$.when(Fn.ajax(configAjax)).then(function (a) {
				++modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
				var btn = new Array();
				btn[0] = { title: 'Cerrar', fn: fn };
				Fn.showModal({ id: modalId, show: true, title: a.msg.title, content: a.data, btn: btn, width: "90%" });
			});
		});

		$(document).on("click", ".fotoMiniatura", function () {
			var control = $(this);
			var data = { type: control.data('type'), idUsuario: control.data('idusuario'), fecha: control.data('fecha') };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': ServicioCobertura.url + 'mostrarFoto', 'data': jsonString };

			$.when(Fn.ajax(configAjax)).then(function (a) {
				++modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
				var btn = new Array();
				btn[0] = { title: 'Cerrar', fn: fn };
				Fn.showModal({ id: modalId, show: true, title: "FOTOS", content: a.data, btn: btn });
			});
		});

		$(document).on("click", ".view_alerta", function (e) {
			e.preventDefault();
			let control = $(this);
			let tipoDetalle = control.data('tipo');
			let hoy = control.data('hoy');
			let tr = control.closest("tr");
			let ruta = tr.data('ruta');
			let fechaTope = tr.data('fechatope');

			var data = { tipoDetalle, ruta, hoy, fechaTope };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': ServicioCobertura.url + 'view_detalle_servicio', 'data': jsonString };

			$.when(Fn.ajax(configAjax)).then(function (a) {
				++modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
				var btn = new Array();
				btn[0] = { title: 'Cerrar', fn: fn };
				Fn.showModal({ id: modalId, show: true, title: a.data.title, content: a.data.html, btn: btn, width:a.data.width });
			});
		});


		$('.tipoDetalladoVertical').hide();
		$('.tipoGrafica').hide();
	},
	filtrar_leyenda: function () {
		let condiciones = [];
		$('.filtroCondicion').each(function (ev) {
			var control = $(this);
			var opcion = control.val();
			var checked = control.prop('checked');

			if (checked == true) {
				let name = (control.data('name'));
				condiciones.push(name);
			}
		});
		let str_condiciones = condiciones.join('|');
		if (str_condiciones == '') {
			str_condiciones = "NO CONDICIONES";
		}

		$('#tb-servicioCoberturaDetalle').DataTable().column(28).search(str_condiciones, true, false).draw();
	},
	actualizar_data: function(){
		let anno_filtro = $("#anno_filtro").val();
		let mes_filtro = $("#mes_filtro").val();
		let quincena_filtro = $("#quincena_filtro").val();
		let tipoFormato = $("#tipoFormato").val();


		var data = { anno_filtro,mes_filtro,quincena_filtro,tipoFormato };
		var jsonString = { 'data': JSON.stringify(data) };
		var configAjax = { 'url': ServicioCobertura.url + 'actualizarData', 'data': jsonString };

		$.when(Fn.ajax(configAjax)).then(function (a) {
			++modalId;
			var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
			var btn = new Array();
			btn[0] = { title: 'Cerrar', fn: fn };
			Fn.showModal({ id: modalId, show: true, title: a.msg.title, content: a.data.html, btn: btn, width: a.data.width });
		});
	}
}

ServicioCobertura.load();