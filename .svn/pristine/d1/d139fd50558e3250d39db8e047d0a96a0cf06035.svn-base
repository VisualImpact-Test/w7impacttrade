var Premiaciones = {

	idFormFiltros: 'formFiltroPremiaciones',
	url: 'premiaciones/',
	idDivContent: 'contentPremiaciones',
	idTableDetalle: 'tb-Premiaciones',

	load: function () {
		
		$(document).ready(function (e) {
			$('.flt_grupoCanal').change();
        });

		$('#btn-consultar').on('click', function (e) {
			e.preventDefault();

			var control = $(this);
			var config = {
				'idFrm': Premiaciones.idFormFiltros
				, 'url': Premiaciones.url + 'lista_premiaciones'
				, 'contentDetalle': Premiaciones.idDivContent
			};
			Fn.loadReporte_new(config);
		});

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
			$('#btn-consultar').click();
        });

		$("#btn-pdf").on("click", function (e) {
			e.preventDefault();

			var datos = {};

			var f = $('#txt-fechas').val();
			var fechas = f.split('-');

			datos['fecIni'] = fechas[0];
			datos['fecFin'] = fechas[1];
			var data = { 'data': JSON.stringify({ datos }) };
			var url = Premiaciones.url + 'premiaciones_pdf';
			Fn.download(url, data);
		});

		$('body').on('click', '.btn-actualizar-estado', function (e) {
			e.preventDefault();
			let id = $(this).attr('data-id');
			let estado = $(this).attr('data-estado');

			let data = { 'id': id, 'estado': estado };
			let jsonString = { 'data': JSON.stringify(data) };
			let config = { 'url': Premiaciones.url + 'actualizar_estado', 'data': jsonString };

			$.when(Fn.ajax(config)).then((a) => {
				if (a.status == '1') {
					var spanResultado = 'spanEstado-' + id;
					var hrefResultado = 'hrefEstado-' + id;
					$("#" + spanResultado).html(a.result_texto);
					if (a.result_texto == 'Activo') {
						$("#" + spanResultado).removeClass('badge-danger');
						$("#" + spanResultado).addClass('badge-success');
					} else {
						$("#" + spanResultado).removeClass('badge-success');
						$("#" + spanResultado).addClass('badge-danger');
					}
					$("#" + hrefResultado).attr('data-estado', a.result_id);
				}
			});
		});

		$(document).on("click", "#btn-configuracion", () => {
			++modalId;

			let jsonString = { 'data': '' };
			let config = { 'url': Premiaciones.url + 'premiaciones_configuracion', 'data': jsonString };

			$.when(Fn.ajax(config)).then((a) => {
				let btn = [];
				let fn = [];

				fn[0] = 'Fn.showModal({ id:' + modalId + ',show:false });';
				btn[0] = { title: 'Cerrar', fn: fn[0] };

				Fn.showModal({ id: modalId, show: true, title: "Configuración", frm: a.data.html, btn: btn, width: '80%' });
				$('#tb-contentTablaPremiaciones').DataTable();
			});
		});

		$(document).on("click", "#btn-cargo-premiacion", function () {
			++modalId;

			let idPremiacion = $(this).data('id');
			let nombre = $(this).data('nombre');
			let data = { 'idPremiacion': idPremiacion, 'nombre': nombre };

			let jsonString = { 'data': JSON.stringify(data) };
			let config = { 'url': Premiaciones.url + 'premiaciones_configuracion_cargos', 'data': jsonString };

			$.when(Fn.ajax(config)).then((a) => {
				let btn = [];
				let fn = [];

				fn[0] = 'Fn.showModal({ id:' + modalId + ',show:false });';
				btn[0] = { title: 'Cerrar', fn: fn[0] };

				Fn.showModal({ id: modalId, show: true, title: "Configuración", frm: a.data.html, btn: btn, width: '80%' });
				$('#tb-cargoPremiaciones').DataTable();

				$('#sel-cargo-grupo-canal').change();
			});
		});

		$(document).on("change", "#sel-cargo-grupo-canal", () => {
			$('#sel-cargo-canal option')
				.hide() // hide all
				.filter('[data-grupocanal="' + $('#sel-cargo-grupo-canal').val() + '"]') // filter options with required value
				.show(); // and show them
		});

		$(document).on('click', '#btn-guardar-cargo', (e) => {
			Fn.showConfirm({ idForm: "formCargos", fn: "Premiaciones.guardarCargos()", content: "¿Esta seguro de agregar el cargo?" });
		});

		$(document).on('click', '.prettyphoto', function (e) {
			e.preventDefault();

			++modalId;

			var foto = $(this).data('foto');

			Fn.showLoading(true);

			$.when($.post(site_url + "premiaciones/mostrarFoto", { foto: foto }, function (data) {
				dataBody = data;
			})).then(() => {
				++modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };

				Fn.showLoading(false);
				Fn.showModal({ id: modalId, show: true, title: "FOTOS", content: dataBody, btn: btn });
			});
		});

		$(document).on("click", ".eliminarCargoPremiacion", function () {
			let idCargo = $(this).data('id');
			let idPremiacion = $('#idPremiacion_cargo').val();
			Fn.showConfirm({ fn: "Premiaciones.eliminarCargos(" + idCargo + "," + idPremiacion + ")", content: "¿Esta seguro de eliminar el cargo?" });
		});

		$(document).on("click", "#btn-objetivo-premiacion", function () {
			++modalId;

			let idPremiacion = $(this).data('id');
			let nombre = $(this).data('nombre');
			let data = { 'idPremiacion': idPremiacion, 'nombre': nombre };

			let jsonString = { 'data': JSON.stringify(data) };
			let config = { 'url': Premiaciones.url + 'premiaciones_configuracion_objetivos', 'data': jsonString };

			$.when(Fn.ajax(config)).then((a) => {
				let btn = [];
				let fn = [];

				fn[0] = 'Fn.showModal({ id:' + modalId + ',show:false });';
				btn[0] = { title: 'Cerrar', fn: fn[0] };

				Fn.showModal({ id: modalId, show: true, title: "Configuración", frm: a.data.html, btn: btn, width: '80%', class: "modalCargaMasivaObjetivos" });
				$('#tb-objetivoPremiaciones').DataTable();

				HTCustom.llenarHTObjectsFeatures(a.data.ht);
			});
		});

		$(document).on('shown.bs.modal', '.modalCargaMasivaObjetivos', function () {
			HTCustom.crearHTObjects(HTCustom.HTObjectsFeatures);
		});

		$(document).on('click', '#btn-guardar-objetivo', (e) => {
			Fn.showConfirm({ idForm: "formObjetivos", fn: "Premiaciones.guardarObjetivos()", content: "¿Esta seguro de agregar los objetivos?" });
		});

		$(document).on("click", ".btn-estado-objetivo", function () {
			++modalId;

			let idObjetivo = $(this).data('id');
			let data = { 'idObjetivo': idObjetivo };

			let jsonString = { 'data': JSON.stringify(data) };
			let config = { 'url': Premiaciones.url + 'premiaciones_configuracion_objetivos_estado', 'data': jsonString };

			$.when(Fn.ajax(config)).then((a) => {
				let btn = [];
				let fn = [];

				fn[0] = 'Fn.showModal({ id:' + modalId + ',show:false });';
				btn[0] = { title: 'Cerrar', fn: fn[0] };

				Fn.showModal({ id: modalId, show: true, title: "Configuración", frm: a.data.html, btn: btn, width: '40%' });
			});
		});

		$(document).on('click', '#btn-estado-objetivos', (e) => {
			Fn.showConfirm({ idForm: "formEstadosObjetivos", fn: "Premiaciones.guardarObjetivosEstado()", content: "¿Esta seguro de actualizar el objetivo?" });
		});

		$(document).ready(function () {
			$('#btn-consultar').click();
		});
	},

	Actualizar: function () {
		var data = Fn.formSerializeObject('editar');
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': Premiaciones.url + 'actualizar_Premiaciones', 'data': jsonString };

		$.when(Fn.ajax(config)).then(function (a) {
			$('#resultadoPremiacionesEditar').html(a.data);
		});
	},

	Habilitar_analista: function () {
		var data = Fn.formSerializeObject('editar');
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': Premiaciones.url + 'actualizar_estado_analista', 'data': jsonString };

		$.when(Fn.ajax(config)).then(function (a) {
			$('#resultadoPremiacionesEditar').html(a.data);
		});
	},

	guardarCargos: function () {
		var file_data = $('#inputFileCargo').prop('files')[0];
		var file_name = file_data.name;
		var formato = file_name.split(".");

		if ((formato[1] == 'jpg') || (formato[1] == 'JPG') || (formato[1] == 'png') || (formato[1] == 'PNG')) {
			var idPremiacion = $('#idPremiacion_cargo').val();
			var premiacion = $('#nombrePremiacion_cargo').val();
			var canal = $('#sel-cargo-canal').val();
			var plaza = $('#sel-cargo-plaza').val();
			var distribucion = $('#sel-cargo-rd').val();
			var form_data = new FormData();
			form_data.append('file', file_data);
			form_data.append('idPremiacion', idPremiacion);
			form_data.append('premiacion', premiacion);
			form_data.append('idCanal', canal);
			form_data.append('idPlaza', plaza);
			form_data.append('idDistribucion', distribucion);
			$.ajax({
				url: site_url + 'index.php/' + Premiaciones.url + 'premiaciones_cargos_guardar',
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				beforeSend: function () {
					Fn.showLoading(true);
				},
				success: function (result) {
					$("#resultadoGuardarCargos").empty();
					$("#bodyTablaCargosPremiaciones").html(result.result);
				},
				error: function () {
					var idModal = ++modalId;
					var btn = [{ 'title': 'Aceptar', 'fn': 'Fn.showModal({ id:' + idModal + ', show: false });' }];

					Fn.showModal({
						'id': idModal,
						'show': true,
						'title': 'ERROR',
						'content': 'Ocurrio un error inesperado en el sistema.',
						'btn': btn
					});
				},
				complete: function () {
					setTimeout(
						function () {
							Fn.showLoading(false);
							a.resolve(result);
						}
						, 100);
				}
			});
		} else {
			var contenido = "<div class='alert alert-info'>La imagen debe ser en formato jpg o png</div>";
			$("#resultadoGuardarCargos").html(contenido);
		}
	},

	eliminarCargos: function (idCargo, idPremiacion) {
		++modalId;

		let data = { 'idCargo': idCargo, 'idPremiacion': idPremiacion };

		let jsonString = { 'data': JSON.stringify(data) };
		let config = { 'url': Premiaciones.url + 'eliminar_cargo', 'data': jsonString };

		$.when(Fn.ajax(config)).then((a) => {
			let btn = [];
			let fn = [];

			fn[0] = 'Fn.showModal({ id:' + modalId + ',show:false });';
			btn[0] = { title: 'Cerrar', fn: fn[0] };

			Fn.showModal({ id: modalId, show: true, title: "Hecho", frm: a.data.html, btn: btn, width: '40%' });
			$('#bodyTablaCargosPremiaciones').html(a.data.tabla);
			// $('#tb-cargoPremiaciones').DataTable();
		});
	},

	guardarObjetivos: function () {
		let data = Fn.formSerializeObject('formObjetivos');
		let HT = [];
		$.each(HTCustom.HTObjects, function (i, v) {
			if (typeof v !== 'undefined') HT.push(v.getSourceData());
		});
		data['HT'] = HT;
		let jsonString = { 'data': JSON.stringify(data) };
		let config = { 'url': Premiaciones.url + 'premiaciones_objetivos_guardar', 'data': jsonString };

		$.when(Fn.ajax(config)).then(function (a) {
			$('#bodyTablaObjetivosPremiaciones').html(a.data.html);

			let btn = [];
			let fn = [];

			fn[0] = 'Fn.showModal({ id:' + modalId + ',show:false });';
			btn[0] = { title: 'Cerrar', fn: fn[0] };

			Fn.showModal({ id: modalId, show: true, title: a.msg.title, frm: a.msg.content, btn: btn, width: '40%' });
		});
	},

	guardarObjetivosEstado: function () {
		let data = Fn.formSerializeObject('formEstadosObjetivos');
		let jsonString = { 'data': JSON.stringify(data) };
		let config = { 'url': Premiaciones.url + 'premiaciones_objetivos_guardar_estado', 'data': jsonString };

		$.when(Fn.ajax(config)).then(function (a) {
			let btn = [];
			let fn = [];

			fn[0] = 'Fn.showModal({ id:' + modalId + ',show:false });';
			btn[0] = { title: 'Cerrar', fn: fn[0] };

			Fn.showModal({ id: modalId, show: true, title: a.msg.title, frm: a.msg.content, btn: btn, width: '40%' });
		});
	},
}
Premiaciones.load();