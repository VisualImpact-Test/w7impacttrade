var CarteraObjetivo = {

	frmScorecard: 'frm-carteraobjetivo',
	contentDetalle: 'idContentCarteraObjetivo',
	url: 'CarteraObjetivo/',

	load: function () {

		$(document).on('click', '#btn-filtrarCarteraObjetivo', function () {
			var ruta = 'reporte';
			var config = {
				'idFrm': CarteraObjetivo.frmScorecard
				, 'url': CarteraObjetivo.url + ruta
				, 'contentDetalle': CarteraObjetivo.contentDetalle
			};

			Fn.loadReporte_new(config);
		});

		$(document).on('click', '.btn-editar', function () {
			++modalId;

			let idObjetivo = $(this).parents('tr:first').data('id');
			let data = { 'idObjetivo': idObjetivo };

			let jsonString = { 'data': JSON.stringify(data) };
			let config = { 'url': CarteraObjetivo.url + 'formulario', 'data': jsonString };

			$.when(Fn.ajax(config)).then((a) => {
				let btn = [];
				let fn = [];

				fn[0] = 'Fn.showModal({ id:' + modalId + ',show:false });';
				btn[0] = { title: 'Cerrar', fn: fn[0] };
				fn[1] = 'Fn.showConfirm({ idForm: "formUpdate", fn: "CarteraObjetivo.actualizarCartera()", content: "¿Esta seguro de actualizar la cartera objetivo?" });';
				btn[1] = { title: 'Actualizar', fn: fn[1] };

				Fn.showModal({ id: modalId, show: true, title: a.msg.title, frm: a.data.html, btn: btn, width: '50%' });
			});
		});

		$(document).on('click', '.btn-actualizar-estado', function () {
			++modalId;

			let idObjetivo = $(this).parents('tr:first').data('id');
			let estado = $(this).data('estado');
			let data = { 'idObjetivo': idObjetivo, 'estado': estado };

			let jsonString = { 'data': JSON.stringify(data) };
			let config = { 'url': CarteraObjetivo.url + 'actualizar_estado', 'data': jsonString };

			$.when(Fn.ajax(config)).then((a) => {
				$("#btn-filtrarCarteraObjetivo").click();
			});
		});

		$(document).on("click", "#btn-masivoCarteraObjetivo", function () {
			++modalId;

			let data = {};

			let jsonString = { 'data': JSON.stringify(data) };
			let config = { 'url': CarteraObjetivo.url + 'carga_masiva', 'data': jsonString };

			$.when(Fn.ajax(config)).then((a) => {
				let btn = [];
				let fn = [];

				fn[0] = 'Fn.showModal({ id:' + modalId + ',show:false });';
				btn[0] = { title: 'Cerrar', fn: fn[0] };
				fn[1] = 'CarteraObjetivo.guardarCargaMasiva();';
				btn[1] = { title: 'Guardar', fn: fn[1] };

				Fn.showModal({ id: modalId, show: true, title: "Configuración", frm: a.data.html, btn: btn, width: '80%', class: "modalCargaMasivaObjetivos" });

				HTCustom.llenarHTObjectsFeatures(a.data.ht);
			});
		});

		$(document).on('shown.bs.modal', '.modalCargaMasivaObjetivos', function () {
			HTCustom.crearHTObjects(HTCustom.HTObjectsFeatures);
		});

		HTCustom.load();
		$('#btn-filtrarCarteraObjetivo').click();
	},

	guardarCargaMasiva: function () {
		++modalId;

		let data = Fn.formSerializeObject('formCarteraObjetivo');
		let HT = [];
		$.each(HTCustom.HTObjects, function (i, v) {
			if (typeof v !== 'undefined') HT.push(v.getSourceData());
		});
		data['HT'] = HT;
		let jsonString = { 'data': JSON.stringify(data) };
		let config = { 'url': CarteraObjetivo.url + 'guardar_carga_masiva', 'data': jsonString };

		$.when(Fn.ajax(config)).then(function (a) {
			let btn = [];
			let fn = [];

			fn[0] = 'Fn.showModal({ id:' + modalId + ',show:false });';
			if (a.result == 1) {
				fn[0] = 'Fn.closeModals(' + modalId + ');$("#btn-filtrarCarteraObjetivo").click();';
			}
			btn[0] = { title: 'Cerrar', fn: fn[0] };

			Fn.showModal({ id: modalId, show: true, title: a.msg.title, frm: a.msg.content, btn: btn, width: '40%' });
		});
	},

	actualizarCartera: function () {
		++modalId;

		let data = Fn.formSerializeObject('formUpdate');

		let jsonString = { 'data': JSON.stringify(data) };
		let config = { 'url': CarteraObjetivo.url + 'actualizar', 'data': jsonString };

		$.when(Fn.ajax(config)).then(function (a) {
			let btn = [];
			let fn = [];

			fn[0] = 'Fn.showModal({ id:' + modalId + ',show:false });';
			if (a.result == 1) {
				fn[0] = 'Fn.closeModals(' + modalId + ');$("#btn-filtrarCarteraObjetivo").click();';
			}
			btn[0] = { title: 'Cerrar', fn: fn[0] };

			Fn.showModal({ id: modalId, show: true, title: a.msg.title, frm: a.msg.content, btn: btn, width: '40%' });
		});
	},
}

CarteraObjetivo.load();