var Cobertura = {
	idFormFiltros: 'formFiltrosCobertura',
	url: 'cobertura/',
	urlActivo: 'detallado',
	idDivContent: 'encuestaContent',
	tabSeleccionado: 1,
	estadoConsulta: 0,

	load: function () {
		$(document).ready(function (e) {
			$('.flt_grupoCanal').change();
		});

		$(document).on('click', '#btn-filtrarCobertura', function (e) {
			e.preventDefault();
			var data = Fn.formSerializeObject(Cobertura.idFormFiltros);
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Cobertura.url + 'detallado', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {
				$(`#${Cobertura.idDivContent}`).html(a.data.html);
				if (Cobertura.urlActivo == 'detallado') {
					$('#tablaDetalladoCobertura').DataTable(a.data.configTable);
				} else if (Cobertura.urlActivo == 'resumen') {
					$('#tablaResumenCobertura').DataTable(a.data.configTable);
				}

				Fn.showLoading(false);
			});
		});

		$(document).on('click', '.card-body > ul > li > a', function (e) {
			var control = $(this);
			Cobertura.urlActivo = control.data('url');
			Cobertura.idDivContent = control.data('contentdetalle');
		});

		$('.btnReporte').on('click', function (e) {
			e.preventDefault();
			var opcion = $(this).attr("data-value");
			Cobertura.tabSeleccionado = opcion;
			$(".div-para-ocultar").addClass('card');
			$("#tipoFormato").val(opcion);
			if (opcion == 1) {
				$('#idTipoFormato').val(1);
			} else if (opcion == 2) {
				$('#idTipoFormato').val(2);
				if (Cobertura.estadoConsulta == 1) {
					$(".div-para-ocultar").removeClass('card');
				}
			} else if (opcion == 3) {
				$('#idTipoFormato').val(3);
			}
		});

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
			$('#btn-filtrarCobertura').click();
		});

		$(document).ready(function () {
			$('#btn-filtrarCobertura').click();
			$(".flt_grupoCanal").change();
			//$('#idEncuesta').selectpicker();
		});
	},
}
Cobertura.load();